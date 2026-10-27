{{-- Post card for listings. Expects $slug. --}}
@php($post = __("blog.posts.{$slug}"))
<a href="{{ route('blog.show', ['slug' => $slug]) }}" class="post-card">
    <div class="post-card-media">
        <img src="https://picsum.photos/seed/{{ config("blog.posts.{$slug}.cover") }}/1200/750?grayscale" width="1200" height="750" loading="lazy" alt="">
    </div>
    <div class="post-card-body">
        <p class="post-meta">
            <span class="post-meta-category">{{ $post['category'] }}</span>
            <span aria-hidden="true">&middot;</span>
            @include('blog.partials.meta', ['slug' => $slug])
        </p>
        <h3 class="post-card-title">{{ $post['title'] }}</h3>
        <p class="post-card-excerpt">{{ $post['excerpt'] }}</p>
        <span class="post-card-more">
            {{ __('blog.read_article') }}
            <i class="ph ph-arrow-right" aria-hidden="true"></i>
        </span>
    </div>
</a>
