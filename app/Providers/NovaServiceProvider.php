<?php

namespace App\Providers;

use App\Models\User;
use App\Nova\Dashboards\Main;
use App\Nova\Settings\Settings;
use App\Nova\Templates\AboutPage;
use App\Nova\Templates\ContactPage;
use App\Nova\Templates\HomePage;
use App\Nova\Templates\ListingPage;
use App\Nova\Templates\ServicesPage;
use App\Nova\Templates\StudioPage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Dashboard;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Tool;
use Oneduo\NovaFileManager\NovaFileManager;
use Outl1ne\NovaSettings\NovaSettings;
use Statikbe\NovaTranslationManager\TranslationManager;
use Whitecube\NovaPage\NovaPageTool;
use Whitecube\NovaPage\Pages\Manager;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Site pages editable in Nova: name => [menu label, template, Heroicon]. The site reads them with page('name').
     */
    public const PAGES = [
        'home-page' => ['HOME PAGE', HomePage::class, 'home'],
        'about-page' => ['ABOUT US', AboutPage::class, 'user-group'],
        'services-page' => ['SERVICES', ServicesPage::class, 'rectangle-stack'],
        'portfolio-page' => ['PORTFOLIO', ListingPage::class, 'photo'],
        'studio-page' => ['STUDIO', StudioPage::class, 'video-camera'],
        'blog-page' => ['BLOG', ListingPage::class, 'book-open'],
        'contact-page' => ['CONTACT', ContactPage::class, 'envelope'],
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::initialPath('/resources/nova-page/route.home-page/edit');

        Nova::serving(function () {
            app()->setLocale('en');
        });

        Nova::footer(function () {
            return Blade::render('
               <div class="mt-8 leading-normal text-xs text-gray-500 space-y-1">
               <p class="text-center">I MUST · Laravel Nova v{{ $version }}</p>
                </div>
                ', ['version' => Nova::version()]);
        });

        parent::boot();

        Nova::showUnreadCountInNotificationCenter();

        Nova::withBreadcrumbs();

        Nova::mainMenu(function () {
            $pages = [];
            foreach (self::PAGES as $name => [$label, , $icon]) {
                $pages[] = MenuSection::make($label)
                    ->path("/resources/nova-page/route.{$name}/edit")
                    ->icon($icon);
            }

            return [
                MenuSection::make('INBOX')
                    ->path('/resources/contact-requests')
                    ->icon('inbox'),

                ...$pages,

                MenuSection::make('BLOG POSTS')
                    ->path('/resources/posts')
                    ->icon('newspaper'),

                MenuSection::make('PROJECTS')
                    ->path('/resources/projects')
                    ->icon('briefcase'),

                MenuSection::make('SERVICES (TAGS)')
                    ->path('/resources/tags')
                    ->icon('tag'),

                MenuSection::make('FILE MANAGER')
                    ->path('/nova-file-manager')
                    ->icon('folder-open'),

                MenuSection::make('SETTINGS')
                    ->path('nova-settings')
                    ->icon('cog-6-tooth'),

                MenuSection::make('TRANSLATIONS')
                    ->path('translation-manager')
                    ->icon('language'),

                MenuSection::make('USERS')
                    ->path('/resources/users')
                    ->icon('users'),
            ];
        });

        Settings::fields();
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function (User $user) {
            return $user->isAdmin();
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, Dashboard>
     */
    protected function dashboards(): array
    {
        return [
            new Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, Tool>
     */
    public function tools(): array
    {
        return [
            NovaPageTool::make(),
            new TranslationManager,
            new NovaSettings,
            NovaFileManager::make(),
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        $pageManager = app(Manager::class);
        foreach (self::PAGES as $name => [, $template]) {
            $pageManager->register('route', $name, $template);
        }
    }
}
