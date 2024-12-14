<?php

namespace Modules\DebtsAndReceivables;

use Illuminate\Support\Facades\Event;
use Lakasir\LakasirModule\Events\TransactionSucceed;
use Lakasir\LakasirModule\Providers\ExtendModuleServiceProvider;
use Modules\DebtsAndReceivables\Listeners\CreateReceivableIfCredit;

class DebtsAndReceivablesServiceProvider extends ExtendModuleServiceProvider
{
    public function register()
    {
        parent::register();

        Event::listen(TransactionSucceed::class, CreateReceivableIfCredit::class);
    }

    public static function getTitle(): string
    {
        return __('DebtsAndReceivables::app.title');
    }
}
