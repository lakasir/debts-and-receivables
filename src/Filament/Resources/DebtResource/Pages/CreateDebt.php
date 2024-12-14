<?php

namespace Modules\DebtsAndReceivables\Filament\Resources\DebtResource\Pages;

use Modules\DebtsAndReceivables\Filament\Resources\DebtResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDebt extends CreateRecord
{
    protected static string $resource = DebtResource::class;
}
