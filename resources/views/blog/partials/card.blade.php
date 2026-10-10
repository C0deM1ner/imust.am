{{-- Post card for listings. Expects $slug. --}}
@php($post = __("blog.posts.{$slug}"))
<a href="{{ route('blog.show', ['slug' => $slug]) }}" class="group flex h-full flex-col overflow-hidden rounded-[24px] border border-white/10 bg-surface transition-colors hover:border-white/25">
    <div class="relative aspect-[16/10] overflow-hidden">
        <img src="https://picsum.photos/seed/{{ config("blog.posts.{$slug}.cover") }}/1200/750?grayscale" width="1200" height="750" loading="lazy" alt=""
             class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-[1.04]">
    </div>
    <div class="flex flex-1 flex-col p-24 md:p-28">
        <p class="flex flex-wrap items-center gap-x-8 gap-y-4 text-ps text-muted">
            <span class="font-semibold text-primary">{{ $post['category'] }}</span>
            <span aria-hidden="true">&middot;</span>
            @include('blog.partials.meta', ['slug' => $slug])
        </p>
        <h3 class="mt-12 text-[22px] font-bold leading-snug tracking-tight transition-colors group-hover:text-primaryLight md:text-[24px]">{{ $post['title'] }}</h3>
        <p class="mt-10 text-p text-muted">{{ $post['excerpt'] }}</p>
        <span class="mt-auto inline-flex items-center gap-8 pt-24 text-ps font-semibold text-paper">
            {{ __('blog.read_article') }}
            <i class="ph ph-arrow-right transition-transform duration-300 group-hover:translate-x-4" aria-hidden="true"></i>
        </span>
    </div>
</a>
