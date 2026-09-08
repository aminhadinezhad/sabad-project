<?php

namespace App\Filament\Resources\Brands\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->components([
                        TextInput::make('name')
                            ->label('نام سازنده/برند')
                            ->required()
                            ->dehydrateStateUsing(fn($state) => trim($state))
                            ->rules([
                                fn($record) => function (string $attribute, $value, \Closure $fail) use ($record) {
                                    $exists = Brand::where('name', trim($value))
                                        ->when($record, fn($q) => $q->where('id', '!=', $record->id))
                                        ->exists();

                                    if ($exists) {
                                        $fail('برندی با این نام از قبل وجود دارد.');
                                    }
                                },
                            ]),
                    ]),
            ]);
    }
}
