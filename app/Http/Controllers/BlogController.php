<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = Post::newestFirst()->get();

        return view('blog.index', [
            'content' => page('blog-page'),
            'latest' => $posts->shift(),
            'posts' => $posts,
        ]);
    }

    public function show(Post $post): View
    {
        $url = route('blog.show', $post);

        return view('blog.show', [
            'post' => $post,
            'content' => $post,
            'listing' => page('blog-page'),
            'others' => Post::newestFirst()->whereKeyNot($post->getKey())->take(3)->get(),
            'shareLinks' => [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($url),
                'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url='.urlencode($url),
                'telegram' => 'https://t.me/share/url?url='.urlencode($url).'&text='.urlencode($post->title),
            ],
        ]);
    }
}
