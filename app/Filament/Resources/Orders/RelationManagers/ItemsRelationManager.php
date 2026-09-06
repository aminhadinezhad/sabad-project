<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Morilog\Jalali\Jalalian;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'اقلام فاکتور مشتری';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                TextColumn::make('product_name')
                    ->label('کالا')
                    ->searchable()
                    ->extraHeaderAttributes(['class' => 'font-bold']),

                TextColumn::make('quantity')
                    ->label('تعداد')
                    ->searchable()
                    ->extraHeaderAttributes(['class' => 'font-bold']),

                TextColumn::make('unit_price')
                    ->label('قیمت واحد')
                    ->formatStateUsing(fn($state) => number_format($state))
                    ->searchable()
                    ->extraHeaderAttributes(['class' => 'font-bold']),

                TextColumn::make('vat_amount')
                    ->label('ارزش افزوده')
                    ->formatStateUsing(fn($state) => number_format($state))
                    ->searchable()
                    ->extraHeaderAttributes(['class' => 'font-bold']),

                TextColumn::make('unit_price_with_vat')
                    ->label('قیمت واحد + ارزش افزوده')
                    ->getStateUsing(fn($record) => number_format($record->unit_price + $record->vat_amount))
                    ->extraHeaderAttributes(['class' => 'font-bold']),

                TextColumn::make('total')
                    ->label('جمع ردیف')
                    ->getStateUsing(fn($record) => number_format($record->quantity * ($record->unit_price + $record->vat_amount)))
                    ->extraHeaderAttributes(['class' => 'font-bold']),

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->formatStateUsing(fn($state) => Jalalian::fromDateTime($state)->format('%Y/%m/%d'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->extraHeaderAttributes(['class' => 'font-bold']),
            ])
            ->headerActions([])
            ->recordActions([]);
    }
}
