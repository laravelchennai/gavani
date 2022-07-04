<?php

namespace App\Filament\Resources\Monitoring\SiteResource\Pages;

use App\Filament\Base\Resources\Pages\BaseEditRecord;
use App\Filament\Resources\Monitoring\SiteResource;
use App\Rules\Site\DomainMustBeValid;
use App\Rules\Site\DomainMustNotStartWithProtocolRule;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;

class EditSite extends BaseEditRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([

                        TextInput::make('url')
                            ->required()
                            ->label('Domain')
                            ->maxLength(400)
                            ->unique(static::getModel(), 'url', function ($record) {
                                return $record;
                            })
                            ->rules([
                                new DomainMustNotStartWithProtocolRule(),
                                new DomainMustBeValid(),
                            ])
                            ->validationAttribute('Domain Name'),

                        TextInput::make('friendly_name')
                        ->maxLength(300)
                            ->required()
                            ->unique(static::getModel(), 'url', function ($record) {
                                return $record;
                            }),


                    ])
                    ->columns([
                        'sm' => 2,
                    ]),

                Card::make()

                    ->schema([
                        Placeholder::make('Monitoring')
                        ->columnSpan(2),
                        Toggle::make('check_ssl')
                        ->label('SSL')
                            ->required(),
                        Toggle::make('check_domain')
                        ->label('Domain')
                        ->required(),

                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ]),
            ]);
    }

    public static function getResource(): string
    {
        return SiteResource::class;
    }
}
