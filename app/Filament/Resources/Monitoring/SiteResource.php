<?php

namespace App\Filament\Resources\Monitoring;

use App\Models\Monitoring\Site;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Base\Resources\BaseResource;
use App\Filament\Traits\Resources\ResourcesGetSlugTrait;
use App\Filament\Resources\Monitoring\SiteResource\Pages;
use App\Filament\Traits\Resources\ResourcesGetGlobalSearchResultUrlTrait;

class SiteResource extends BaseResource
{
    public static function canCreate(): bool
    {
        return Auth::user()->can('SITE.CREATE');
    }

    public static function canDelete($record): bool
    {
        return Auth::user()->can('SITE.DELETE');
    }

    public static function canEdit($record): bool
    {
        return Auth::user()->can('SITE.UPDATE');
    }

    public static function canExport(): bool
    {
        return Auth::user()->can('SITE.EXPORT');
    }

    public static function canView($record): bool
    {
        return Auth::user()->can('SITE.VIEW');
    }

    public static function canViewAny(): bool
    {
        return Auth::user()->can('SITE.VIEW');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['url', 'friendly_name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [];
    }

    public static function getLabel(): string
    {
        return 'Site';
    }

    public static function getModel(): string
    {
        return Site::class;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
            'view' => Pages\ViewSite::route('/{record}/'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return 'Sites';
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'friendly_name';
    }

    public static function getRelations(): array
    {
        return [];
    }

    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    protected static function getNavigationGroup(): ?string
    {
        return 'Monitoring';
    }

    protected static function getNavigationIcon(): string
    {
        return 'heroicon-o-globe-alt';
    }

    protected static function getNavigationLabel(): string
    {
        return 'Site';
    }

    protected static function getNavigationSort(): ?int
    {
        return 1;
    }
}
