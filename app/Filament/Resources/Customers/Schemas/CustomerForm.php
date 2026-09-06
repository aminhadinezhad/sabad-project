<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->components([
                        TextInput::make('phone')
                            ->label('شماره موبایل')
                            ->tel()
                            ->disabled(),

                        TextInput::make('full_name')
                            ->label('نام فرد')
                            ->required(),

                        TextInput::make('address')
                            ->label('نشانی')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
