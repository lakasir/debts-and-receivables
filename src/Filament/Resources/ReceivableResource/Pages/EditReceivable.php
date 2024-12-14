<?php

namespace Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource;

class EditReceivable extends EditRecord
{
    protected static string $resource = ReceivableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
