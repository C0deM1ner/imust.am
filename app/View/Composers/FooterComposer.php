<?php

namespace App\View\Composers;

use Illuminate\View\View;

class FooterComposer
{
    // Nova settings first, config/app.php while a setting is empty.
    public function compose(View $view): void
    {
        $view->with('contact', [
            'email' => setting('email', config('app.contact.email')),
            'phone' => setting('phone_number', config('app.contact.phone')),
            'address' => setting('address', __('common.address')),
            'officeLines' => lines(page('contact-page')->office_lines),
            'socials' => collect(config('app.contact.socials'))->map(fn ($url, $network) => setting($network, $url))->all(),
        ]);
    }
}
