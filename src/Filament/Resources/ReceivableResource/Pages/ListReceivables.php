<?php

namespace Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Widgets\StatsReceivable;

class ListReceivables extends ListRecords
{
    protected static string $resource = ReceivableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsReceivable::make(),
        ];
    }
}
