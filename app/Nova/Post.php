<?php

namespace App\Nova;

use App\Nova\Traits\HasMetaFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;
use Mostafaznv\NovaCkEditor\CkEditor;
use Oneduo\NovaFileManager\FileManager;

class Post extends Resource
{
    use HasMetaFields;

    public static string $model = \App\Models\Post::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'slug',
        'title->hy',
        'title->ru',
        'title->en',
    ];

    public static $sort = ['published_at' => 'desc'];

    public static function label(): string
    {
        return 'Blog Posts';
    }

    public static function singularLabel(): string
    {
        return 'Blog Post';
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

            Text::make('Category', 'category')
                ->translatable(),

            Date::make('Published', 'published_at')
                ->rules('required')
                ->default(now())
                ->sortable()
                ->help('Posts are listed newest first.'),

            Tab::group('Details', [
                Tab::make('CONTENT', [
                    Slug::make('Slug')
                        ->nullable()
                        ->help('The article URL. Leave empty to make it from the English title.'),

                    FileManager::make('Cover', 'cover')
                        ->nullable(),

                    Textarea::make('Excerpt', 'excerpt')
                        ->translatable()
                        ->help('Shown on the post card and as the opening paragraph of the article.'),

                    CkEditor::make('Article', 'body')
                        ->translatable()
                        ->hideFromIndex(),
                ]),

                $this->metaFieldsTab(),
            ]),
        ];
    }
}
