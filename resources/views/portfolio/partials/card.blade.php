{{-- Portfolio project card. Expects $slug and $project (an entry of config/portfolio.php). --}}
@php
    $text = __("portfolio.projects.{$slug}");
    $coverSrc = isset($project['image']) ? asset($project['image']) : "https://picsum.photos/seed/{$project['cover']}/1000/1250?grayscale";
@endphp
<a href="{{ route('portfolio.show', ['slug' => $slug]) }}" class="photo-card portfolio-card">
    <img src="{{ $coverSrc }}" width="1000" height="1250" loading="lazy" alt="" class="photo-card-img">
    <div class="photo-card-shade" aria-hidden="true"></div>

    <ul class="portfolio-card-tags">
        @foreach ($project['tags'] as $tag)
            <li class="glass-pill tag-pill">{{ __("portfolio.tags.{$tag}") }}</li>
        @endforeach
    </ul>

    <span class="glass-pill arrow-badge" aria-hidden="true">
        <i class="ph ph-arrow-right"></i>
    </span>

    <p class="portfolio-card-meta">{{ $text['client'] }} &middot; {{ $project['year'] }}</p>
    <h2 class="portfolio-card-title">{{ $text['title'] }}</h2>
    <p class="portfolio-card-summary">{{ $text['summary'] }}</p>
</a>
