<?php

namespace App\Filament\Base\Resources\Pages;

use Illuminate\Support\Str;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class BaseViewRecord extends ViewRecord
{
    public $childClassPath;

    public function getActions(): array
    {

        //@todo
        // Implement redirect

        // collect(get_declared_classes())
        // ->filter(fn($fullyQualifiedClassName) => str_starts_with($fullyQualifiedClassName,'App\\Filament\\'))
        // ->values()
        // ->map(function($fullyQualifiedClassName){
        //     return [
        //         'md5Hash' => md5($fullyQualifiedClassName),
        //         'className' => $fullyQualifiedClassName,
        //     ];
        // })
        // ->dd();
        return [
            Action::make('view_page_edit_action')
                ->button()
                ->label('Edit')
                ->url(static::getResource()::getUrl('edit', ['record' => $this->record, 'fromPage' => $this->childClassPath]))
                ->visible(static::getResource()::canEdit($this->record))
                ->icon('heroicon-o-pencil'),

            Action::make('view_page_back_action')
                ->button()
                ->label('Back')
                ->url(static::getResource()::getUrl())
                ->color('danger')
                ->icon('heroicon-o-arrow-circle-left'),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        $this->childClassPath = md5((new \ReflectionClass(get_class($this)))->getName());
    }

    protected function getTitle(): string
    {
        return Str::of('Edit ')
            ->append(Str::singular(static::getResource()::getPluralLabel()));
    }
}
