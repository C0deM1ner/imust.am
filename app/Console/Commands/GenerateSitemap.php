<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use App\Nova\Services\NovaPage\Models\StaticPage;
use DateTimeInterface;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Write public/sitemap.xml with every page, post and project in each language';

    // Route name => the Nova page that holds its content and its "Index Page" switch.
    private const PAGES = [
        'home' => 'home-page',
        'about' => 'about-page',
        'services' => 'services-page',
        'expansion' => 'studio-page',
        'portfolio.index' => 'portfolio-page',
        'blog.index' => 'blog-page',
        'contact' => 'contact-page',
    ];

    public function handle(): void
    {
        $sitemap = Sitemap::create();
        $pages = StaticPage::query()->whereIn('name', self::PAGES)->get()->keyBy('name');

        foreach (self::PAGES as $route => $name) {
            $page = $pages->get($name);

            if ($page?->is_indexable !== false) {
                $this->add($sitemap, $route, [], $page?->updated_at);
            }
        }

        // Explicit is_active: when this runs from a Nova save, the models booted without IsActiveTrait's scope.
        Post::query()->where('is_active', true)->newestFirst()->get()
            ->reject(fn (Post $post) => $post->is_indexable === false)
            ->each(fn (Post $post) => $this->add($sitemap, 'blog.show', ['post' => $post], $post->updated_at));

        Project::query()->where('is_active', true)->orderBy('order')->get()
            ->reject(fn (Project $project) => $project->is_indexable === false)
            ->each(fn (Project $project) => $this->add($sitemap, 'portfolio.show', ['project' => $project], $project->updated_at));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap written with '.count($sitemap->getTags()).' URLs.');
    }

    private function add(Sitemap $sitemap, string $route, array $parameters, ?DateTimeInterface $modified): void
    {
        $urls = collect(config('localizer.supported_locales'))
            ->mapWithKeys(fn (string $locale) => [$locale => $this->url($route, $locale, $parameters)]);

        foreach ($urls as $url) {
            $tag = Url::create($url);

            if ($modified) {
                $tag->setLastModificationDate($modified);
            }

            foreach ($urls as $locale => $alternate) {
                $tag->addAlternate($alternate, $locale);
            }

            $sitemap->add($tag);
        }
    }

    // The default language has no prefix: /about, /ru/about, /en/about.
    private function url(string $route, string $locale, array $parameters): string
    {
        return $locale === config('app.fallback_locale')
            ? route("without_locale.$route", $parameters)
            : route("with_locale.$route", ['locale' => $locale] + $parameters);
    }
}
