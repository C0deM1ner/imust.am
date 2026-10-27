<?php

namespace App\Observers;

use App\Models\ContactRequest;
use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;

class ContactRequestObserver
{
    // Shows up in the Nova notification bell of every admin; no mail setup needed.
    public function created(ContactRequest $request): void
    {
        $notification = NovaNotification::make()
            ->message("New contact request from {$request->name}")
            ->action('Open', new URL("/resources/contact-requests/{$request->getKey()}"))
            ->icon('inbox')
            ->type('info');

        User::where('is_admin', true)->each(fn (User $admin) => $admin->notify(clone $notification));
    }
}
