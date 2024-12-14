<?php

namespace Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\RelationManagers;

use App\Filament\Tenant\Resources\Traits\RefreshThePage;
use App\Models\Tenants\Setting;
use App\Models\Tenants\User;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Traits\HasReceivablePaymentForm;
use Modules\DebtsAndReceivables\Models\Receivable;
use Modules\DebtsAndReceivables\Models\ReceivablePayment;
use Modules\DebtsAndReceivables\Services\ReceivablePaymentService;

class ReceivablePaymentsRelationManager extends RelationManager
{
    use HasReceivablePaymentForm, RefreshThePage;

    protected static string $relationship = 'receivablePayments';

    protected static bool $isLazy = false;

    private $dPService;

    public function __construct()
    {
        $this->dPService = new ReceivablePaymentService();
    }

    public static function canViewForRecord(Model|Receivable $ownerRecord, string $pageClass): bool
    {
        return User::query()->find(Filament::auth()->id())->can('read receivable payment');
    }

    public function form(Form $form): Form
    {
        return $form->schema($this->getFormPayment($this->ownerRecord))->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('amount')
                    ->translateLabel()
                    ->money(Setting::get('currency', 'IDR')),
                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('last_receivable')
                    ->translateLabel()
                    ->money(Setting::get('currency', 'IDR')),
                Tables\Columns\TextColumn::make('date')
                    ->translateLabel()
                    ->date(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->action(function (array $data, ReceivablePayment $receivablePayment): void {
                        $this->dPService->update($receivablePayment, $data);
                        $this->refreshPage();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->action(function (ReceivablePayment $receivablePayment): void {
                        $this->dPService->destroy($receivablePayment);
                        $this->refreshPage();
                    }),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
