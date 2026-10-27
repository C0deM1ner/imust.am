<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'content' => page('home-page'),
            'services' => page('services-page'),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'content' => page('about-page'),
            'projects' => Project::with('tags')->take(5)->get(),
        ]);
    }

    public function services(): View
    {
        return view('services', [
            'content' => page('services-page'),
        ]);
    }

    public function expansion(): View
    {
        return view('expansion', [
            'content' => page('studio-page'),
        ]);
    }

    public function contact(): View
    {
        return view('contact', [
            'content' => page('contact-page'),
            'email' => setting('email', config('app.contact.email')),
            'phone' => setting('phone_number', config('app.contact.phone')),
            'address' => setting('address', __('contact.office.city')),
            'mapUrl' => 'https://www.google.com/maps/search/?api=1&query='.urlencode('Avan, Yerevan, Armenia'),
        ]);
    }
}
