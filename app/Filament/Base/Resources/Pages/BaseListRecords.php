<?php

namespace App\Filament\Base\Resources\Pages;

use Closure;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BaseListRecords extends ListRecords
{
    public $childClassPath;

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

    public function getActions(): array
    {
        return [];
    }

    public function getTableActions(): array
    {
        return [

            Action::make('list_page_table_record_edit')
            ->iconButton()
                ->label('Edit')
                ->tooltip('Edit')
                ->icon('heroicon-o-pencil-alt')
                ->visible(fn ($record): bool => static::getResource()::canEdit($record) && static::getResource()::hasPage('edit'))
                ->url(fn ($record): string => static::getResource()::hasPage('edit') ? static::getResource()::getUrl('edit', ['record' => $record, 'fromPage' => $this->childClassPath]) : null)
                ->openUrlInNewTab(),

            Action::make('list_page_table_record_view')
            ->iconButton()
                ->label('View')
                ->tooltip('View')
                ->icon('heroicon-o-eye')
                ->visible(fn ($record): bool => static::getResource()::canView($record) && static::getResource()::hasPage('view'))
                ->url(fn ($record): string => static::getResource()::hasPage('view') ? static::getResource()::getUrl('view', ['record' => $record, 'fromPage' => $this->childClassPath]) : null)
                ->openUrlInNewTab(),

                // Action::make('list_page_table_record_delete')
                //     ->iconButton()
                //     ->label('Delete')
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
                //    ->visible(fn ($record): string => static::getResource()::canDelete($record)),

            // ActionGroup::make([





            // ])
            //     ->tooltip('Actions')
            //     ->icon('heroicon-o-adjustments'),


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
                ->url(Arr::has(static::getResource()::getPages(), 'create') ? static::getResource()::getUrl('create') : null)
                ->visible(fn ($record): bool => static::getResource()::canCreate() && Arr::has(static::getResource()::getPages(), 'create')),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        $this->childClassPath = md5((new \ReflectionClass(get_class($this)))->getName());
    }

    protected function getHeading(): string
    {
        return false;
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
                ->url(Arr::has(static::getResource()::getPages(), 'create') ? static::getResource()::getUrl('create') : null)
                ->visible(fn ($record): bool => static::getResource()::canCreate() && Arr::has(static::getResource()::getPages(), 'create')),
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

    protected function getTableHeading(): string | Closure | null
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

    protected function getTitle(): string
    {
        return static::getResource()::getPluralLabel();
    }
}
