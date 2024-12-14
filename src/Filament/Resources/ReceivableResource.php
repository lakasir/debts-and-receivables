<?php

namespace Modules\DebtsAndReceivables\Filament\Resources;

use App\Models\Tenants\Setting;
use App\Traits\HasTranslatableResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Pages\ListReceivables;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Pages\ViewReceivable;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\RelationManagers\ReceivableItemsRelationManager;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\RelationManagers\ReceivablePaymentsRelationManager;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Traits\HasReceivablePaymentForm;
use Modules\DebtsAndReceivables\Models\Receivable;
use Modules\DebtsAndReceivables\Models\ReceivablePayment;
use Modules\DebtsAndReceivables\Services\ReceivablePaymentService;

class ReceivableResource extends Resource
{
    use HasReceivablePaymentForm, HasTranslatableResource;

    protected static ?string $model = Receivable::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function table(Table $table): Table
    {
        $self = new self();

        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('selling.code')
                    ->translateLabel()
                    ->searchable()
                    ->prefix('#'),
                TextColumn::make('member.name')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('total_receivable')
                    ->money(Setting::get('currency', 'IDR'))
                    ->translateLabel(),
                TextColumn::make('rest_receivable')
                    ->money(Setting::get('currency', 'IDR'))
                    ->translateLabel(),
                TextColumn::make('due_date')
                    ->translateLabel()
                    ->date(),
                TextColumn::make('last_billing_date')
                    ->translateLabel()
                    ->date(),
                TextColumn::make('status')
                    ->badge()
                    ->getStateUsing(function (Receivable $receivable) {
                        return $receivable->status ? __('Paid off') : __('Unpaid');
                    })
                    ->iconColor(fn (string $state): string => match ($state) {
                        __('Unpaid') => 'danger',
                        __('Paid off') => 'success',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        __('Paid off') => 'heroicon-o-check-circle',
                        __('Unpaid') => 'heroicon-o-exclamation-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        __('Unpaid') => 'danger',
                        __('Paid off') => 'success',
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('add_payment')
                    ->translateLabel()
                    ->icon('heroicon-s-credit-card')
                    ->model(ReceivablePayment::class)
                    ->visible(function ($record) {
                        if (! $record->status && can('create receivable payment')) {
                            return true;
                        }

                        return false;
                    })
                    ->form(fn ($record) => $self->getFormPayment($record))
                    ->action(function (array $data, Receivable $receivable, ReceivablePaymentService $dpService): void {
                        $dpService->create($receivable, $data);
                    }),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('member.name')
                ->translateLabel(),
            TextEntry::make('member.email')
                ->translateLabel(),
            TextEntry::make('total_receivable')
                ->translateLabel()
                ->money(Setting::get('currency', 'IDR')),
            TextEntry::make('rest_receivable')
                ->translateLabel()
                ->money(Setting::get('currency', 'IDR')),
            TextEntry::make('due_date')
                ->translateLabel()
                ->date(),
            TextEntry::make('total_billing_via_whatsapp')
                ->hidden()
                ->translateLabel(),
            TextEntry::make('last_billing_date')
                ->translateLabel()
                ->date(),
            TextEntry::make('status')
                ->translateLabel()
                ->getStateUsing(function (Receivable $receivable) {
                    return $receivable->status ? __('Paid off') : __('Unpaid');
                })
                ->color(fn (string $state): string => match ($state) {
                    __('Unpaid') => 'danger',
                    __('Paid off') => 'success',
                })
                ->badge()
                ->iconColor(fn (string $state): string => match ($state) {
                    __('Unpaid') => 'danger',
                    __('Paid off') => 'success',
                })
                ->icon(fn (string $state): string => match ($state) {
                    __('Paid off') => 'heroicon-o-check-circle',
                    __('Unpaid') => 'heroicon-o-exclamation-circle',
                }),
        ]);

    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('', [
                ReceivableItemsRelationManager::make(),
                ReceivablePaymentsRelationManager::make(),
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReceivables::route('/'),
            'view' => ViewReceivable::route('/{record}'),
        ];
    }
}
