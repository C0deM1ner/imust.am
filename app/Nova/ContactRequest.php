<?php

namespace App\Nova;

use App\Nova\Templates\ServicesPage;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class ContactRequest extends Resource
{
    public static string $model = \App\Models\ContactRequest::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'company',
        'email',
        'phone',
        'message',
    ];

    public static $sort = ['created_at' => 'desc'];

    public static function label(): string
    {
        return 'Inbox';
    }

    public static function singularLabel(): string
    {
        return 'Contact Request';
    }

    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            DateTime::make('Received', 'created_at')
                ->sortable(),

            Text::make('Name')
                ->sortable(),

            Text::make('Company')
                ->sortable(),

            Email::make('Email')
                ->sortable(),

            Text::make('Phone')
                ->hideFromIndex(),

            Text::make('Package', fn () => $this->package === null || $this->package === 'unsure'
                ? 'Not sure yet'
                : 'I MUST '.(ServicesPage::PACKAGES[$this->package] ?? $this->package))
                ->sortable(),

            Textarea::make('Message')
                ->alwaysShow(),

            Text::make('Language', fn () => strtoupper($this->locale))
                ->hideFromIndex(),

            Text::make('IP Address', 'ip')
                ->hideFromIndex(),

            Text::make('Browser', 'user_agent')
                ->hideFromIndex(),
        ];
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public function authorizedToUpdate(Request $request): bool
    {
        return false;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }
}
