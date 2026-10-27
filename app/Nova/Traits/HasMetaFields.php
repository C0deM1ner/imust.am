<?php

namespace App\Nova\Traits;

use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Tabs\Tab;
use Oneduo\NovaFileManager\FileManager;

trait HasMetaFields
{
    public function metaFieldsTab(): Tab
    {
        return Tab::make('SEO', $this->metaFields());
    }

    public function metaFields(): array
    {
        return [
            Boolean::make('Index Page', 'is_indexable')
                ->trueValue(true)
                ->falseValue(false)
                ->default(true)
                ->hideFromIndex(),

            Text::make('Title', 'meta_title')
                ->nullable()
                ->translatable()
                ->hideFromIndex(),

            Textarea::make('Keywords', 'meta_keywords')
                ->nullable()
                ->translatable()
                ->hideFromIndex(),

            Textarea::make('Description', 'meta_description')
                ->nullable()
                ->translatable()
                ->hideFromIndex(),

            FileManager::make('Image', 'meta_image')
                ->nullable()
                ->hideFromIndex(),
        ];
    }
}
