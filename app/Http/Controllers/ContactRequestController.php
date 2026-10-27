<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\ContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ContactRequestController extends Controller
{
    public function store(StoreContactRequest $request): JsonResponse|RedirectResponse
    {
        ContactRequest::create($request->safe()->except('website') + [
            'locale' => app()->getLocale(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // contactForm.js sends with fetch and expects JSON; without JS the form posts and comes back here.
        if ($request->expectsJson()) {
            return response()->json(['message' => __('contact.form.sent')]);
        }

        return redirect()->to(route('contact').'#contact-form')->with('contact_sent', true);
    }
}
