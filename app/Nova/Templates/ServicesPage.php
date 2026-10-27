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

class ServicesPage extends Template
{
    use HasMetaFields;

    /**
     * The three packages. Names are brand names and stay the same in every language.
     */
    public const PACKAGES = ['start' => 'Start', 'grow' => 'Grow', 'maintain' => 'Maintain'];

    protected $jsonAttributes = [
        'hero_image',
        'start_groups',
        'grow_groups',
        'maintain_groups',
        'meta_image',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @throws Exception
     */
    public function fields(NovaRequest $request): array
    {
        $packageTabs = [];
        foreach (self::PACKAGES as $key => $name) {
            $packageTabs[] = $this->packageTab($key, $name);
        }

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
                ]),

                ...$packageTabs,

                Tab::make('CALL TO ACTION', [
                    Text::make('Title', 'help_title')
                        ->translatable(),

                    Textarea::make('Lead', 'help_lead')
                        ->translatable(),
                ]),

                $this->metaFieldsTab(),
            ]),
        ];
    }

    /**
     * Fields for one package card (also shown on the home page).
     */
    protected function packageTab(string $key, string $name): Tab
    {
        return Tab::make('I MUST '.strtoupper($name), [
            Text::make('Summary', "{$key}_summary")
                ->translatable(),

            Text::make('Price', "{$key}_price")
                ->translatable(),

            Text::make('Billing', "{$key}_cadence")
                ->translatable()
                ->help('For example "One-time fee" or "Monthly fixed fee".'),

            Text::make('Price Note', "{$key}_price_note")
                ->translatable()
                ->nullable()
                ->help('Optional second line under the billing, for example "per year".'),

            Textarea::make('Who It Is For', "{$key}_description")
                ->translatable(),

            Flexible::make('Included', "{$key}_groups")
                ->addLayout('Feature Group', 'group', [
                    Text::make('Group Title', 'title')
                        ->translatable()
                        ->help('Hidden when the package has only one group.'),

                    Textarea::make('Features', 'features')
                        ->translatable()
                        ->help('One feature per line.'),
                ])
                ->fullWidth()
                ->button('Add Feature Group'),
        ]);
    }

    public function cards(NovaRequest $request): array
    {
        return [];
    }
}
