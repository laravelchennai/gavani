<?php

namespace App\Filament\Base\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseResource extends Resource
{
    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }

    public static function getSlug(): string
    {
        return collect([static::getNavigationGroup(), parent::getSlug()])
            ->map(fn ($each) => Str::of($each)->lower()->slug('-'))
            ->implode('/');
    }
}
