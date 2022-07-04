<?php

namespace App\Filament\Base\Resources\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class BaseCreateRecord extends CreateRecord
{
    public function getActions(): array
    {
        return [
            Action::make('create_page_back_button')
                ->button()
                ->iconPosition('before')
                ->label('Back')
                ->url(static::getResource()::getUrl())
                ->color('danger')
                ->icon('heroicon-o-arrow-circle-left')
                ,
        ];
    }

    public function getBreadcrumb(): string
    {
        return 'Add';
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return Str::of(static::getResource()::getLabel())->append(' ')->append('Created')->__toString();
    }

    protected function getFormActions(): array
    {
        //@todo Add loading state to button
        return [
            Action::make('create_page_form_save_button')
                ->iconPosition('before')
                // ->icon('heroicon-o-check')
                ->label('Save')
                ->submit('create'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getTitle(): string
    {
        return Str::of('Create ')
            ->append(Str::singular(static::getResource()::getPluralLabel()));
    }
}
