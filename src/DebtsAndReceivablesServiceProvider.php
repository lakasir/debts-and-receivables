<?php

namespace Modules\DebtsAndReceivables;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Lakasir\LakasirModule\Events\TransactionSucceed;
use Lakasir\LakasirModule\Facades\LakasirModule;
use Lakasir\LakasirModule\Providers\ExtendModuleServiceProvider;
use Livewire\Component;
use Livewire\Livewire;
use Modules\DebtsAndReceivables\Listeners\CreateReceivableIfCredit;

class DebtsAndReceivablesServiceProvider extends ExtendModuleServiceProvider
{
    public function register()
    {
        parent::register();
        $this->registerModuleComponents();

        Event::listen(TransactionSucceed::class, CreateReceivableIfCredit::class);
    }

    public static function getTitle(): string
    {
        return __('DebtsAndReceivables::app.title');
    }

    protected function registerModuleComponents(): void
    {
        /** @var Collection $modules * */
        $modules = LakasirModule::collectionModules();
        $modules->each(function ($module) {
            // dd($module);
            // Livewire::component('', '');
        });
        // $name = 'stats-receivable';
        // dd(class_exists('Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Widgets\StatsReceivable'));
        // dd(is_subclass_of('Modules\DebtsAndReceivables\Filament\Resources\ReceivableResource\Widgets\StatsReceivable', Component::class));
        // app('livewire')->component($name, GlobalStats::class);
        // app('livewire')->component('export-button', ExportButtonComponent::class);
    }
}
