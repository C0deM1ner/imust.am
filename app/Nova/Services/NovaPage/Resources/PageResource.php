<?php

namespace App\Nova\Services\NovaPage\Resources;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Whitecube\NovaPage\Pages\StaticResource;

class PageResource extends StaticResource
{
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'nova-page';

    /**
     * Indicates whether Nova should check for modifications between viewing and updating a resource.
     *
     * @var bool
     */
    public static $trafficCop = false;

    /**
     * Get the URI key for the resource.
     */
    public static function uriKey(): string
    {
        return 'nova-page';
    }

    /**
     * Get the displayable label of the resource.
     */
    public static function label(): string
    {
        return config('novapage.labels.pages');
    }

    /**
     * Get the displayable singular label of the resource.
     */
    public static function singularLabel(): string
    {
        return config('novapage.labels.page');
    }

    /**
     * Get the base fields displayed at the top of the resource's form.
     */
    protected function getFormIntroductionFields(): array
    {
        return [
            (new Panel(__('Base page attributes'), $this->getBaseAttributeFields()))->withToolbar(),
        ];
    }

    /**
     * Get the base common attributes
     */
    protected function getBaseAttributeFields(): array
    {
        return [
            Text::make(__('Page title'), 'title')
                ->rules(['required', 'max:255'])->translatable(),
        ];
    }

    /**
     * Get the base attributes Nova Panel
     */
    protected function getIndexTableFields(): array
    {
        return [
            Text::make(__('Name'), 'title', function () {
                return $this->getName();
            })->sortable(),
        ];
    }
}
