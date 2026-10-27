<?php

namespace App\Http\Requests;

use App\Nova\Templates\ServicesPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['nullable', 'string', 'max:50'],
            'package' => ['nullable', Rule::in([...array_keys(ServicesPage::PACKAGES), 'unsure'])],
            'message' => ['required', 'string', 'max:5000'],
            // Honeypot: hidden from people, so only bots fill it in.
            'website' => ['prohibited'],
        ];
    }
}
