<?php

namespace App\Filament\Base\Resources\RelationManagers;

use Closure;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BaseHasManyRelationManager extends HasManyRelationManager
{
    public static function excelExportClass()
    {
        return Str::of(static::getResource()::getModel())
            ->replace(['App\Models\\'], ['App\Exports\ExcelExport\FromFilteredQuery\\'])
            ->append('Export')
            ->__toString();
    }

    public function exportToExcel()
    {
        return app(self::excelExportClass())->setQueryBuilder($this->getFilteredTableQuery());
    }

    public function getTableActions(): array
    {
        return [
            Action::make('list_page_table_record_edit')
                ->iconButton()
                ->label('')
                ->icon('heroicon-o-pencil-alt')
                ->visible(fn ($record): bool => static::getResource()::canEdit($record) && Arr::has(static::getResource()::getPages(), 'edit'))
                ->form($this->getEditFormSchema())
                ->mountUsing(fn () => $this->fillEditForm())
                ->modalButton(__('filament::resources/relation-managers/edit.action.modal.actions.save.label'))
                ->modalHeading(__('filament::resources/relation-managers/edit.action.modal.heading', ['label' => static::getRecordLabel()]))
                ->action(fn () => $this->save())
                ->icon('heroicon-s-pencil')
                ->hidden(true),

            Action::make('list_page_table_record_view')
                ->iconButton()
                ->label('')
                ->icon('heroicon-o-eye')
                ->visible(fn ($record): string => static::getResource()::canView($record) && Arr::has(static::getResource()::getPages(), 'view'))
                ->url(fn ($record): string => Arr::has(static::getResource()::getPages(), 'view') ? static::getResource()::getUrl('view', ['record' => $record]) : null, true),

            // Action::make('list_page_table_record_delete')
            //     ->iconButton()
            //     ->icon('heroicon-o-trash')
            //     ->color('danger')
            //     ->requiresConfirmation(true)
            //     ->modalHeading(Str::of('Delete ')->append(Str::singular(static::getResource()::getPluralLabel())))
            //     ->centerModal(true)
            //     ->modalSubheading('Are you sure you\'d like to delete ? This cannot be undone.')
            //     ->modalButton('Delete')
            //     ->action(function ($record) {
            //         $record->delete();
            //         $this->notify('success', Str::of(static::getResource()::getLabel())->append(' ')->append('Deleted')->__toString());
            //     })
            //     ->visible(fn ($record): bool => static::getResource()::canDelete($record)),
        ];
    }

    public function getTableHeaderActions(): array
    {
        return [
            Action::make('list_page_table_header_export_button')
                ->button()
                ->label('Export')
                ->iconPosition('before')
                ->icon('heroicon-o-arrow-circle-right')
                ->color('secondary')
                ->action('exportToExcel')
                ->visible(method_exists(static::getResource(), 'canExport') && static::getResource()::canExport()),

            Action::make('list_page_table_header_add_button')
                ->button()
                ->label('Add')
                ->iconPosition('before')
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->form($this->getCreateFormSchema())
                ->mountUsing(fn () => $this->fillCreateForm())
                ->modalActions($this->getCreateActionModalActions())
                ->modalHeading(__('filament::resources/relation-managers/create.action.modal.heading', ['label' => static::getRecordLabel()]))
                ->action(fn () => $this->create())
                ->visible(static::getResource()::canCreate() && Arr::has(static::getResource()::getPages(), 'create'))
                ->hidden(true),
        ];
    }

    public static function getTitle(): string
    {
        return static::getResource()::getNavigationLabel();
    }

    protected function getCreateActionModalActions(): array
    {
        return [
            Action::makeModalAction('create')
                ->label('Save')
                ->submit('callMountedTableAction')
                ->color('primary'),

            Action::makeModalAction('cancel')
                ->label(__('filament-support::actions.modal.buttons.cancel.label'))
                ->cancel()
                ->color('secondary'),
        ];
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return Str::of(static::getResource()::getLabel())->append(' ')->append('Created')->__toString();
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return Str::of(static::getResource()::getLabel())->append(' ')->append('Updated')->__toString();
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Action::make('create')
                ->button()
                ->label(Str::of('Add')->append(' ')->append(Str::singular(static::getResource()::getPluralLabel())))
                ->iconPosition('before')
                ->icon('heroicon-o-plus-circle')
                ->url(Arr::has(static::getResource()::getPages(), 'create') ? static::getResource()::canCreate() : null)
                ->visible(static::getResource()::canCreate() && Arr::has(static::getResource()::getPages(), 'create')),
        ];
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return Str::of('You may create a')
            ->append(' ')
            ->append(Str::singular(static::getResource()::getPluralLabel()))
            ->append(' ')
            ->append('using the button below.');
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return Str::of('No ')
            ->append(static::getResource()::getPluralLabel())
            ->append(' yet');
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-bookmark';
    }

    protected function getTableHeading(): ?string
    {
        return static::getResource()::getPluralLabel();
    }

    protected function getTableQueryStringIdentifier(): string
    {
        return Str::of(static::getResource()::getModel())
            ->basename()
            ->pluralStudly()
            ->snake()
            ->pipe('md5')
            ->__toString();
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return config('appconfig.adminpanel.tables.per_page_select_options');
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return function (Model $record) {
            return null;
        };
    }
}
