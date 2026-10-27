<?php

namespace App\Models\Traits;

use App\Models\Scopes\IsActiveGlobalScope;

trait IsActiveTrait
{
    public static function bootIsActiveTrait(): void
    {
        if (! is_nova_request()) {
            static::addGlobalScope(new IsActiveGlobalScope);
        }
    }
}
