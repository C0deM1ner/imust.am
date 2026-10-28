<?php

namespace App\Support;

use App\Models\Post;
use App\Models\Project;
use Spatie\SchemaOrg\BlogPosting;
use Spatie\SchemaOrg\BreadcrumbList;
use Spatie\SchemaOrg\CreativeWork;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\ProfessionalService;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;
use Spatie\SchemaOrg\WebSite;

// schema.org JSON-LD. Every page gets the agency and the website; controllers add what the page itself is about.
class StructuredData
{
    public static function graph(Type ...$nodes): Graph
    {
        $graph = (new Graph)->add(self::organization())->add(self::website());

        foreach ($nodes as $node) {
            $graph->add($node);
        }

        return $graph;
    }

    public static function organization(): ProfessionalService
    {
        // Placeholder links ("#") from config/app.php stay out until real ones are set in Nova.
        $socials = collect(config('app.contact.socials'))
            ->map(fn ($url, $network) => setting($network, $url))
            ->filter(fn ($url) => filter_var($url, FILTER_VALIDATE_URL))
            ->values()
            ->all();

        return Schema::professionalService()
            ->identifier(self::id('organization'))
            ->name('I MUST')
            ->alternateName(__('common.meta_title'))
            ->description(__('common.meta_description'))
            ->url(url('/'))
            ->image(asset('img/share.jpg'))
            ->email(setting('email', config('app.contact.email')))
            ->telephone(setting('phone_number', config('app.contact.phone')))
            ->address(Schema::postalAddress()
                ->streetAddress(setting('address', __('common.address')))
                ->addressCountry('AM'))
            ->areaServed(Schema::country()->name('Armenia'))
            ->if($socials, fn (ProfessionalService $agency) => $agency->sameAs($socials));
    }

    public static function website(): WebSite
    {
        return Schema::webSite()
            ->identifier(self::id('website'))
            ->name('I MUST')
            ->url(url('/'))
            ->inLanguage(config('localizer.supported_locales'))
            ->publisher(self::agency());
    }

    public static function blogPosting(Post $post): BlogPosting
    {
        $url = route('blog.show', $post);

        return Schema::blogPosting()
            ->identifier($url.'#article')
            ->headline($post->title)
            ->description($post->excerpt)
            ->if($image = img($post->cover), fn (BlogPosting $posting) => $posting->image($image))
            ->datePublished($post->published_at)
            ->dateModified($post->updated_at)
            ->articleSection($post->category)
            ->inLanguage(app()->getLocale())
            ->mainEntityOfPage($url)
            ->author(self::agency())
            ->publisher(self::agency());
    }

    public static function project(Project $project): CreativeWork
    {
        $url = route('portfolio.show', $project);

        return Schema::creativeWork()
            ->identifier($url.'#work')
            ->name($project->title)
            ->description($project->summary)
            ->url($url)
            ->if($image = img($project->cover), fn (CreativeWork $work) => $work->image($image))
            ->if($project->year, fn (CreativeWork $work) => $work->dateCreated((string) $project->year))
            ->keywords($project->tags->pluck('name')->implode(', '))
            ->inLanguage(app()->getLocale())
            ->creator(self::agency());
    }

    // [label => url], from the home page down to the current one.
    public static function breadcrumbs(array $items): BreadcrumbList
    {
        return Schema::breadcrumbList()->itemListElement(
            collect($items)->keys()->map(fn (string $label, int $index) => Schema::listItem()
                ->position($index + 1)
                ->name($label)
                ->item($items[$label]))->all()
        );
    }

    // A reference to the organization node, so posts and projects don't repeat its details.
    private static function agency(): ProfessionalService
    {
        return Schema::professionalService()->identifier(self::id('organization'));
    }

    // Same @id in every language, so search engines see one agency and one website.
    private static function id(string $node): string
    {
        return url('/').'/#'.$node;
    }
}
