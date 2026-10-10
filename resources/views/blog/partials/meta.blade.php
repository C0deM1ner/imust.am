@php
    // Date and estimated reading time (about 200 words per minute) for post $slug.
    $post = __("blog.posts.{$slug}");
    $words = collect($post['body'])
        ->map(fn ($block) => is_array($block[1]) ? implode(' ', $block[1]) : $block[1])
        ->sum(fn ($text) => count(preg_split('/\s+/u', trim($text))));
    $minutes = max(1, (int) round($words / 200));
    $date = \Illuminate\Support\Carbon::parse(config("blog.posts.{$slug}.date"))->locale(app()->getLocale());
@endphp
<time datetime="{{ $date->toDateString() }}">{{ $date->translatedFormat('j F Y') }}</time>
<span aria-hidden="true">&middot;</span>
<span>{{ __('blog.read_time', ['minutes' => $minutes]) }}</span>
