<?php

namespace Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Traits;

use App\Models\Tenants\PaymentMethod;
use App\Models\Tenants\Setting;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Modules\DebtsAndReceivables\Models\Receivable;

trait HasReceivablePaymentForm
{
    public function getFormPayment(Receivable $receivable): array
    {
        return [
            Select::make('payment_method_id')
                ->label(__('Payment method'))
                ->options(PaymentMethod::query()->where('is_credit', 'false')->pluck('name', 'id'))
                ->required(),
            TextInput::make('amount')
                ->translateLabel()
                ->mask(RawJs::make('$money($input)'))
                ->stripCharacters(',')
                ->prefix(Setting::get('currency', 'IDR'))
                ->lte($receivable->rest_receivable, true)
                ->required(),
            DatePicker::make('date')
                ->translateLabel()
                ->closeOnDateSelection()
                ->native(false)
                ->required(),
        ];
    }
}
