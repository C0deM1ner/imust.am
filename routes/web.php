<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

$locales = array_keys(config('app.locales'));
$pages = ['about', 'services', 'expansion', 'contact', 'blog'];

Route::redirect('/', '/'.$locales[0]);

foreach ($pages as $page) {
    Route::redirect("/{$page}", "/{$locales[0]}/{$page}");
}

Route::prefix('{locale}')
    ->whereIn('locale', $locales)
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::view('/', 'home')->name('home');
        Route::view('/about', 'about')->name('about');
        Route::view('/services', 'services')->name('services');
        Route::view('/expansion', 'expansion')->name('expansion');
        Route::view('/contact', 'contact')->name('contact');

        Route::view('/blog', 'blog.index')->name('blog.index');
        Route::get('/blog/{slug}', function (string $locale, string $slug) {
            abort_unless(array_key_exists($slug, config('blog.posts')), 404);

            return view('blog.show', ['slug' => $slug]);
        })->name('blog.show');
    });
