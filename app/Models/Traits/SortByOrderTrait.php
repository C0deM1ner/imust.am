<?php

namespace App\Models\Traits;

use App\Models\Scopes\SortByOrderGlobalScope;

trait SortByOrderTrait
{
    public static function bootSortByOrderTrait(): void
    {
        if (! is_nova_request()) {
            static::addGlobalScope(new SortByOrderGlobalScope);
        }
    }

    public array $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];
}
