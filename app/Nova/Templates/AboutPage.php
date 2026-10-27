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

class AboutPage extends Template
{
    use HasMetaFields;

    protected $jsonAttributes = [
        'hero_image',
        'structure_roles',
        'founders',
        'network_people',
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

                    Text::make('Equation Hint', 'equation_hint')
                        ->translatable()
                        ->help('Shown under "Marketing + Development + Video = I MUST". The terms come from the founders.'),
                ]),

                Tab::make('TEAM STRUCTURE', [
                    Text::make('Title', 'structure_title')
                        ->translatable(),

                    Textarea::make('Lead', 'structure_lead')
                        ->translatable(),

                    Flexible::make('Roles', 'structure_roles')
                        ->addLayout('Role', 'role', [
                            Text::make('Title', 'title')
                                ->translatable()
                                ->rules('required'),

                            Textarea::make('Text', 'text')
                                ->translatable(),
                        ])
                        ->limit(3)
                        ->fullWidth()
                        ->button('Add Role'),
                ]),

                Tab::make('FOUNDERS', [
                    Text::make('Eyebrow', 'founders_eyebrow')
                        ->translatable(),

                    Text::make('Title', 'founders_title')
                        ->translatable(),

                    Flexible::make('Founders', 'founders')
                        ->addLayout('Founder', 'founder', [
                            Text::make('Discipline', 'discipline')
                                ->translatable()
                                ->rules('required')
                                ->help('Also used in the hero equation.'),

                            Text::make('Name', 'name')
                                ->translatable()
                                ->rules('required'),

                            Text::make('Position', 'position')
                                ->translatable(),

                            Textarea::make('Bio', 'bio')
                                ->translatable(),

                            FileManager::make('Photo', 'photo')
                                ->nullable(),

                            Text::make('Portfolio Link', 'link')
                                ->nullable(),
                        ])
                        ->limit(3)
                        ->fullWidth()
                        ->button('Add Founder'),
                ]),

                Tab::make('DEVELOPERS AND PARTNERS', [
                    Text::make('Title', 'network_title')
                        ->translatable(),

                    Textarea::make('Lead', 'network_lead')
                        ->translatable(),

                    Flexible::make('People', 'network_people')
                        ->addLayout('Person', 'person', [
                            Text::make('Name', 'name')
                                ->translatable()
                                ->rules('required'),

                            Text::make('Role', 'role')
                                ->translatable(),

                            FileManager::make('Photo', 'photo')
                                ->nullable(),

                            Text::make('Portfolio Link', 'link')
                                ->nullable(),
                        ])
                        ->fullWidth()
                        ->button('Add Person'),
                ]),

                Tab::make('PROJECTS SECTION', [
                    Text::make('Title', 'projects_title')
                        ->translatable(),

                    Textarea::make('Lead', 'projects_lead')
                        ->translatable()
                        ->help('The slider shows the latest portfolio projects.'),
                ]),

                Tab::make('CALL TO ACTION', [
                    Text::make('Title', 'cta_title')
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
