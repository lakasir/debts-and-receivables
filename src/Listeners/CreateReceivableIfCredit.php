<?php

namespace Modules\DebtsAndReceivables\Listeners;

use Lakasir\LakasirModule\Events\TransactionSucceed;
use Modules\DebtsAndReceivables\Services\ReceivableService;

class CreateReceivableIfCredit
{
    public function __construct(private ReceivableService $receivableService)
    {
    }

    public function handle(TransactionSucceed $event): void
    {
        if ($event->selling->paymentMethod->is_credit) {
            $this->receivableService->create($event->selling, $event->data);
        }
    }
}
