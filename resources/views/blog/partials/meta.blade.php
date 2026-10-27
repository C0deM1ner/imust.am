@php($date = $post->published_at->locale(app()->getLocale()))
<time datetime="{{ $date->toDateString() }}">{{ $date->translatedFormat('j F Y') }}</time>
<span aria-hidden="true">&middot;</span>
<span>{{ __('blog.read_time', ['minutes' => $post->readingMinutes()]) }}</span>
