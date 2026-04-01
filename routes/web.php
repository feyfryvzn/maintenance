<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterMachineController;

Route::get('/', function () {
    return redirect()->route('master-machine.index');
});

// Master Machine Routes
Route::prefix('master-machine')->name('master-machine.')->group(function () {
    Route::get('/', [MasterMachineController::class, 'index'])->name('index');
    Route::post('/', [MasterMachineController::class, 'store'])->name('store');
    Route::get('/{id}', [MasterMachineController::class, 'show'])->name('show');
    Route::post('/{id}', [MasterMachineController::class, 'update'])->name('update');
    Route::post('/{id}/change-status', [MasterMachineController::class, 'changeStatus'])->name('change-status');
    Route::post('/{id}/void', [MasterMachineController::class, 'void'])->name('void');
    Route::get('/{id}/logs', [MasterMachineController::class, 'logs'])->name('logs');
    Route::delete('/image/{id}', [MasterMachineController::class, 'deleteImage'])->name('delete-image');
});
