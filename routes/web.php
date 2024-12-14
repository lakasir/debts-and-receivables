<?php

use Illuminate\Support\Facades\Route;
use Modules\DebtsAndReceivables\Http\Controllers\ModuleController;

Route::get('/', [ModuleController::class, 'index']);
