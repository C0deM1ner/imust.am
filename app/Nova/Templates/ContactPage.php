<?php

namespace App\Nova\Templates;

use App\Nova\Traits\HasMetaFields;
use Exception;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;
use Oneduo\NovaFileManager\FileManager;
use Whitecube\NovaPage\Pages\Template;

class ContactPage extends Template
{
    use HasMetaFields;

    protected $jsonAttributes = [
        'office_image',
        'meta_image',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @throws Exception
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Tab::group('CONTENT', [
                Tab::make('CONTENT', [
                    Text::make('Title', 'hero_title')
                        ->translatable()
                        ->rules('required'),

                    Textarea::make('Lead', 'hero_lead')
                        ->translatable(),
                ]),

                Tab::make('OFFICE', [
                    FileManager::make('Office Photo', 'office_image')
                        ->nullable()
                        ->hideFromIndex(),

                    Text::make('Photo Description', 'office_image_alt')
                        ->translatable(),

                    Textarea::make('Office Details', 'office_lines')
                        ->translatable()
                        ->help('One detail per line, for example "First floor". The address, email and phone are on the Settings page.'),
                ]),

                $this->metaFieldsTab(),
            ]),
        ];
    }

    public function cards(NovaRequest $request): array
    {
        return [];
    }
}
