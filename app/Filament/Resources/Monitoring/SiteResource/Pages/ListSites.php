<?php

namespace App\Filament\Resources\Monitoring\SiteResource\Pages;


use App\Filament\Base\Resources\Pages\BaseListRecords;
use App\Filament\Resources\Monitoring\SiteResource;
use Filament\Resources\Table;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ListSites extends BaseListRecords
{
    public static function getResource(): string
    {
        return SiteResource::class;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('url')
                    ->label('Url')
                    ->sortable()
                    ->searchable()
                    ->default('N/A'),

                TextColumn::make('friendly_name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->default('N/A'),

                BooleanColumn::make('latestSslCertificateScan.is_ssl_certificate_valid')
                    ->label('SSL')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->getStateUsing(function ($record) {
                        return $record?->latestSslCertificateScan?->is_ssl_certificate_valid ? true : false;
                    }),

                TextColumn::make('latestSslCertificateScan.valid_till')
                    ->label('Expiry')
                    ->dateTime()
                    ->sortable(),

            ]);
    }

    protected function getTableQuery(): Builder
    {
        return static::getModel()::query()
            ->with([
                'latestSslCertificateScan'
            ]);
    }
}
