<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Tag extends Resource
{
    use HasSortableRows;

    public static string $model = \App\Models\Tag::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'slug',
        'name->hy',
        'name->ru',
        'name->en',
    ];

    public static function label(): string
    {
        return 'Services';
    }

    public static function singularLabel(): string
    {
        return 'Service';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Boolean::make('Active', 'is_active')
                ->default(true)
                ->sortable(),

            Text::make('Name', 'name')
                ->translatable()
                ->rules('required', 'max:255')
                ->help('Shown as a filter on the portfolio page and as a label on project cards.'),

            Slug::make('Slug')
                ->nullable()
                ->hideFromIndex()
                ->help('Used in the filter link (?tag=video). Leave empty to make it from the English name.'),

            BelongsToMany::make('Projects', 'projects', Project::class),
        ];
    }
}
