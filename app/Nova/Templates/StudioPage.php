<?php

namespace App\Nova\Templates;

use App\Nova\Traits\HasMetaFields;
use Exception;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;
use Oneduo\NovaFileManager\FileManager;
use Whitecube\NovaFlexibleContent\Flexible;
use Whitecube\NovaPage\Pages\Template;

class StudioPage extends Template
{
    use HasMetaFields;

    protected $jsonAttributes = [
        'hero_image',
        'offerings',
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
                Tab::make('HERO SECTION', [
                    Text::make('Eyebrow', 'hero_eyebrow')
                        ->translatable(),

                    Text::make('Title', 'hero_title')
                        ->translatable()
                        ->rules('required'),

                    Textarea::make('Lead', 'hero_lead')
                        ->translatable(),

                    FileManager::make('Background Image', 'hero_image')
                        ->nullable()
                        ->hideFromIndex(),

                    Text::make('Image Description', 'hero_image_alt')
                        ->translatable(),
                ]),

                Tab::make('OFFERINGS', [
                    Flexible::make('Offerings', 'offerings')
                        ->addLayout('Offering', 'offering', [
                            Text::make('Title', 'title')
                                ->translatable()
                                ->rules('required'),

                            Textarea::make('Text', 'text')
                                ->translatable(),

                            FileManager::make('Image', 'image')
                                ->nullable(),

                            Text::make('Image Description', 'image_alt')
                                ->translatable(),
                        ])
                        ->fullWidth()
                        ->button('Add Offering'),
                ]),

                Tab::make('CALL TO ACTION', [
                    Text::make('Title', 'cta_title')
                        ->translatable(),

                    Textarea::make('Lead', 'cta_lead')
                        ->translatable(),
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
