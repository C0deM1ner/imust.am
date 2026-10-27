<?php

namespace App\Models;

use App\Observers\ContactRequestObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(ContactRequestObserver::class)]
class ContactRequest extends Model
{
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'package',
        'message',
        'locale',
        'ip',
        'user_agent',
    ];
}
