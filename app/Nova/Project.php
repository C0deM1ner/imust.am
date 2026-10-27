<?php

namespace App\Nova;

use App\Nova\Traits\HasMetaFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;
use Oneduo\NovaFileManager\FileManager;
use Outl1ne\MultiselectField\Multiselect;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Project extends Resource
{
    use HasMetaFields;
    use HasSortableRows;

    public static string $model = \App\Models\Project::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'slug',
        'title->hy',
        'title->ru',
        'title->en',
        'client->en',
    ];

    public static function label(): string
    {
        return 'Projects';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Boolean::make('Active', 'is_active')
                ->default(true)
                ->sortable(),

            Text::make('Title', 'title')
                ->translatable()
                ->rules('required', 'max:255'),

            Text::make('Client', 'client')
                ->translatable(),

            Number::make('Year', 'year')
                ->min(2000)
                ->max(2100)
                ->sortable(),

            Multiselect::make('Services', 'tags')
                ->belongsToMany(Tag::class, false),

            Tab::group('Details', [
                Tab::make('CONTENT', [
                    Slug::make('Slug')
                        ->nullable()
                        ->help('The project URL. Leave empty to make it from the English title.'),

                    FileManager::make('Cover', 'cover')
                        ->nullable(),

                    Textarea::make('Summary', 'summary')
                        ->translatable()
                        ->help('One or two sentences on the project card.'),

                    Textarea::make('The Task', 'challenge')
                        ->translatable(),

                    Textarea::make('What We Did', 'work')
                        ->translatable()
                        ->help('One item per line.'),

                    Textarea::make('The Result', 'result')
                        ->translatable(),

                    FileManager::make('Gallery', 'gallery')
                        ->multiple()
                        ->nullable()
                        ->help('Photos under the story. The first one is shown full width.'),
                ]),

                $this->metaFieldsTab(),
            ]),
        ];
    }
}
