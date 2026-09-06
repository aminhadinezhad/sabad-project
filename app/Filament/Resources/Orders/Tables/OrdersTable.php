<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Customer;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Morilog\Jalali\Jalalian;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.full_name')
                    ->label('خریدار')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('tracking_code')
                    ->label('کد سفارش')
                    ->formatStateUsing(fn($state) => self::toPersianDigits($state))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('total_price')
                    ->label('مبلغ')
                    ->formatStateUsing(fn($state) => self::toPersianDigits(number_format($state)))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('تاریخ')
                    ->formatStateUsing(fn($state) => Jalalian::fromDateTime($state)->format('%Y/%m/%d'))
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_finalized')
                    ->label('نهایی شده')
                    ->boolean()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
            ->filters([
                Filter::make('tracking_code')
                    ->schema([
                        TextInput::make('tracking_code')
                            ->label('کد سفارش')
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query->when(
                        $data['tracking_code'] ?? null,
                        fn(Builder $query, $value): Builder => $query->where('tracking_code', 'like', "%{$value}%"),
                    )),

                SelectFilter::make('is_finalized')
                    ->label('نهایی شده؟')
                    ->placeholder('یک گزینه را انتخاب کنید')
                    ->options([
                        '0' => 'نهایی نشده',
                        '1' => 'نهایی شده',
                    ]),

                SelectFilter::make('customer_id')
                    ->label('خریدار')
                    ->placeholder('یک گزینه را انتخاب کنید')
                    ->relationship('customer', 'full_name')
                    ->searchable()
                    ->preload(),
            ])
            ->deferFilters()
            ->recordActions([
                EditAction::make()
                    ->label('ویرایش'),

                Action::make('printInvoice')
                    ->label('چاپ پیش‌فاکتور سفارش')
                    ->icon('heroicon-o-printer')
                    ->url(fn(Order $record) => route('orders.invoice', $record))
                    ->openUrlInNewTab(),

                DeleteAction::make()
                    ->label('حذف')
                    ->requiresConfirmation()
                    ->modalHeading(
                        fn(Order $record): string => "حذف {$record->tracking_code}"
                    )
                    ->modalDescription('آیا برای انجام این کار مطمئن هستید؟')
                    ->modalSubmitActionLabel('حذف')
                    ->modalCancelActionLabel('لغو'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function toPersianDigits(string $value): string
    {
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        return str_replace($english, $persian, $value);
    }
}
