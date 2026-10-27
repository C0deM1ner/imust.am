{{-- Expects $project (App\Models\Project with tags loaded). --}}
<a href="{{ route('portfolio.show', $project) }}" class="photo-card portfolio-card">
    <img src="{{ img($project->cover) }}" width="1000" height="1250" loading="lazy" alt="" class="photo-card-img">
    <div class="photo-card-shade" aria-hidden="true"></div>

    <ul class="portfolio-card-tags">
        @foreach ($project->tags as $tag)
            <li class="glass-pill tag-pill">{{ $tag->name }}</li>
        @endforeach
    </ul>

    <span class="glass-pill arrow-badge" aria-hidden="true">
        <i class="ph ph-arrow-right"></i>
    </span>

    <p class="portfolio-card-meta">{{ $project->client }} &middot; {{ $project->year }}</p>
    <h2 class="portfolio-card-title">{{ $project->title }}</h2>
    <p class="portfolio-card-summary">{{ $project->summary }}</p>
</a>
