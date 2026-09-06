<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('printInvoice')
                ->label('چاپ پیش‌فاکتور سفارش')
                ->icon('heroicon-o-printer')
                ->url(fn($record) => route('orders.invoice', $record))
                ->openUrlInNewTab(),

            DeleteAction::make()
        ];
    }
}
