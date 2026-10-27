{{-- Page title block without a hero photo (blog, portfolio). Expects $eyebrow, $title and $lead. --}}
<div class="page-intro">
    <p class="eyebrow" data-reveal>{{ $eyebrow }}</p>
    <h1 class="hero-title page-intro-title" data-reveal style="--d:1">{{ $title }}</h1>
    <p class="hero-lead" data-reveal style="--d:2">{{ $lead }}</p>
</div>
