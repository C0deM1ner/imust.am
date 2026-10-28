<?php

namespace App\Providers;

use App\Listeners\ConvertToWebpListener;
use App\View\Composers\FooterComposer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Oneduo\NovaFileManager\Events\FileUploaded;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(
            FileUploaded::class,
            ConvertToWebpListener::class
        );

        View::composer('partials.footer', FooterComposer::class);

        Blueprint::macro('metaFields', function () {
            $this->boolean('is_indexable')->default(true);
            $this->text('meta_title')->nullable();
            $this->text('meta_description')->nullable();
            $this->text('meta_keywords')->nullable();
            $this->string('meta_image')->nullable();
        });
    }
}
