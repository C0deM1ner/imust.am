{{-- Post card for listings. Expects $slug; pass 'featured' => true for the wide latest-post card. --}}
@php
    $post = __("blog.posts.{$slug}");
    $featured ??= false;
@endphp
<a href="{{ route('blog.show', ['slug' => $slug]) }}" @class(['post-card', 'post-card-featured' => $featured])>
    <div class="post-card-media">
        <img src="{{ asset(config("blog.posts.{$slug}.image")) }}" width="1024" height="637" @unless ($featured) loading="lazy" @endunless alt="">
    </div>
    <div class="post-card-body">
        <p class="post-meta">
            <span class="post-meta-category">{{ $post['category'] }}</span>
            <span aria-hidden="true">&middot;</span>
            @include('blog.partials.meta', ['slug' => $slug])
        </p>
        @if ($featured)
            <h2 class="post-card-title">{{ $post['title'] }}</h2>
        @else
            <h3 class="post-card-title">{{ $post['title'] }}</h3>
        @endif
        <p class="post-card-excerpt">{{ $post['excerpt'] }}</p>
        <span class="post-card-more">
            {{ __('blog.read_article') }}
            <i class="ph ph-arrow-right" aria-hidden="true"></i>
        </span>
    </div>
</a>
