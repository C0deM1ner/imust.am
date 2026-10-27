<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactRequestController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Every page exists once per locale: /about (hy, the default), /ru/about, /en/about. See config/localizer.php.
Route::localize(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/services', [PageController::class, 'services'])->name('services');
    Route::get('/expansion', [PageController::class, 'expansion'])->name('expansion');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [ContactRequestController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('contact.store');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
});
