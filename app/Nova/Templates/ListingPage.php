<?php

namespace App\Nova\Templates;

use App\Nova\Traits\HasMetaFields;
use Exception;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;
use Whitecube\NovaPage\Pages\Template;

/**
 * Title block and closing call to action of a listing page (blog, portfolio).
 */
class ListingPage extends Template
{
    use HasMetaFields;

    protected $jsonAttributes = [
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
                Tab::make('INTRO', [
                    Text::make('Eyebrow', 'hero_eyebrow')
                        ->translatable(),

                    Text::make('Title', 'hero_title')
                        ->translatable()
                        ->rules('required'),

                    Textarea::make('Lead', 'hero_lead')
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
