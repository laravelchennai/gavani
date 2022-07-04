<?php

namespace App\Filament\Resources\Monitoring\SiteResource\Pages;

use App\Filament\Base\Resources\Pages\BaseViewRecord;
use App\Filament\Resources\Monitoring\SiteResource;
use App\Models\Monitoring\Site;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;

class ViewSite extends BaseViewRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Card::make()
                    ->schema([
                        Placeholder::make('url')
                            ->label('URL')
                            ->content(function (Site $record) {
                                return $record?->url ?? '-';
                            }),

                Placeholder::make('friendly_name')
                    ->label('Friendly Name')
                    ->content(function (Site $record) {
                        return $record?->friendly_name ?? '-';
                    }),

                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan(2),



            ]);
    }

    public static function getResource(): string
    {
        return SiteResource::class;
    }
}
