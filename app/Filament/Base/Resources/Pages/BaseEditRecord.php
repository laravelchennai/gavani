<?php

namespace App\Filament\Base\Resources\Pages;

use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BaseEditRecord extends EditRecord
{
    public function getActions(): array
    {
        return [

            Action::make('edit_page_show_button')
                ->button()
                ->label('View')
                ->visible(static::getResource()::canView($this->record) && Arr::has(static::getResource()::getPages(), 'view'))
                ->url(Arr::has(static::getResource()::getPages(), 'view') ? static::getResource()::getUrl('view', ['record' => $this->record, 'fromPage' => 'editRecord']) : null)
                ->icon('heroicon-o-eye'),

            Action::make('edit_page_back_buttom')
                ->button()
                ->label('Back')
                ->url(static::getResource()::getUrl())
                ->color('danger')
                ->icon('heroicon-o-arrow-circle-left'),

        ];
    }

    public function getBreadcrumb(): string
    {
        return 'Edit';
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('edit_page_form_save_button')
                ->button()
                ->iconPosition('before')
                ->label('Update')
                ->submit('save'),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return Str::of(static::getResource()::getLabel())->append(' ')->append('Updated')->__toString();
    }

    protected function getTitle(): string
    {
        return Str::of('Edit ')
            ->append(Str::singular(static::getResource()::getPluralLabel()));
    }
}
