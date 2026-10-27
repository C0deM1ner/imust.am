<?php

namespace App\Nova\Settings;

use App\Casts\TranslateSettingCast;
use Exception;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Tabs\Tab;
use Outl1ne\NovaSettings\NovaSettings;
use Outl1ne\NovaSettings\NovaSettingsStore;

class Settings
{
    /**
     * @throws Exception
     */
    public static function fields(): NovaSettingsStore
    {
        return NovaSettings::addSettingsFields([
            self::mainTab(),
        ],
            self::casts()
        );
    }

    public static function casts(): array
    {
        return [
            'address' => TranslateSettingCast::class,
        ];
    }

    /**
     * @throws Exception
     */
    protected static function mainTab()
    {
        return Tab::group('Main', [
            self::generalTab(),
            self::socialTab(),
        ]);
    }

    protected static function generalTab(): Tab
    {
        return Tab::make('GENERAL', [
            Heading::make('Contact Information'),

            Text::make('Phone Number', 'phone_number')
                ->help('Shown in the footer and on the contact page.'),

            Text::make('Email', 'email')
                ->help('General email address shown on the website.'),

            Text::make('Address', 'address')
                ->translatable()
                ->help('Office address shown in the footer and on the contact page.'),
        ]);
    }

    protected static function socialTab(): Tab
    {
        return Tab::make('SOCIAL', [
            Heading::make('Social Media Links'),

            Text::make('Instagram', 'instagram'),

            Text::make('Facebook', 'facebook'),

            Text::make('LinkedIn', 'linkedin'),

            Text::make('YouTube', 'youtube'),
        ]);
    }
}
