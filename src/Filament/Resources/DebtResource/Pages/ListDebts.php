<?php

namespace Modules\DebtsAndReceivables\Filament\Resources\DebtResource\Pages;

use Modules\DebtsAndReceivables\Filament\Resources\DebtResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDebts extends ListRecords
{
    protected static string $resource = DebtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
