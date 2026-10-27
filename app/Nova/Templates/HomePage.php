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

class HomePage extends Template
{
    use HasMetaFields;

    protected $jsonAttributes = [
        'hero_image',
        'team_roles',
        'studio_image',
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
                    Textarea::make('Subtitle', 'hero_subtitle')
                        ->translatable()
                        ->rules('required'),

                    FileManager::make('Background Image', 'hero_image')
                        ->nullable()
                        ->hideFromIndex(),

                    Text::make('Image Description', 'hero_image_alt')
                        ->translatable()
                        ->help('Describes the photo for screen readers and search engines.'),
                ]),

                Tab::make('TEAM SECTION', [
                    Text::make('Title', 'team_title')
                        ->translatable()
                        ->rules('required'),

                    Textarea::make('Lead', 'team_lead')
                        ->translatable(),

                    Flexible::make('Roles', 'team_roles')
                        ->addLayout('Role', 'role', [
                            Text::make('Title', 'title')
                                ->translatable()
                                ->rules('required'),

                            Text::make('Text', 'text')
                                ->translatable(),

                            FileManager::make('Image', 'image')
                                ->nullable(),

                            Text::make('Image Description', 'image_alt')
                                ->translatable(),
                        ])
                        ->limit(3)
                        ->fullWidth()
                        ->button('Add Role'),
                ]),

                Tab::make('PACKAGES SECTION', [
                    Text::make('Title', 'packages_title')
                        ->translatable()
                        ->help('The package cards themselves are edited on the Services page.'),
                ]),

                Tab::make('STUDIO SECTION', [
                    Text::make('Title', 'studio_title')
                        ->translatable(),

                    Textarea::make('Lead', 'studio_lead')
                        ->translatable(),

                    FileManager::make('Image', 'studio_image')
                        ->nullable()
                        ->hideFromIndex(),

                    Text::make('Image Description', 'studio_image_alt')
                        ->translatable(),
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
