<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // the customer's contact details, so the pre-invoice need not be opened to call them (closed until clicked, like the sections below)
                Section::make('پروفایل خریدار')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->hiddenOn('create')
                    ->components([
                        Placeholder::make('customer_full_name')
                            ->label('خریدار/مشتری')
                            ->content(fn($record) => $record?->customer?->full_name ?: '-'),

                        Placeholder::make('customer_phone')
                            ->label('شماره موبایل')
                            ->content(fn($record) => $record?->customer?->phone ?: '-'),

                        Placeholder::make('customer_address')
                            ->label('نشانی')
                            ->columnSpanFull()
                            ->content(fn($record) => $record?->customer?->address ?: '-'),
                    ]),

                Section::make('اقدام ادمین')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->components([
                        Toggle::make('is_finalized')
                            ->label('نهایی شده؟')
                            ->helperText('در صورت نهایی شدن توسط ادمین، امکان ویرایش و یا حذف وجود نخواهد داشت.'),

                        Select::make('referred_to_user_id')
                            ->label('واسپاری به')
                            ->relationship('referredTo', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('یک گزینه را انتخاب کنید'),

                        Textarea::make('admin_notes')
                            ->label('نکات ادمین')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),

                Section::make('سایر اطلاعات سفارش')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->components([
                        Placeholder::make('tracking_code')
                            ->label('کد سفارش')
                            ->content(fn($record) => $record?->tracking_code),

                        Placeholder::make('total_price')
                            ->label('مبلغ سفارش')
                            ->content(fn($record) => number_format($record?->total_price)),
                    ]),
            ]);
    }
}
