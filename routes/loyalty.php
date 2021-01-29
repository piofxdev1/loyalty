<?php

use App\Http\Controllers\Loyalty\RewardController;
use App\Http\Controllers\Loyalty\CustomerController;
use App\Http\Controllers\Loyalty\LoyaltySettingsController;

// Reward Routes
Route::get('/loyalty/reward', [RewardController::class, 'index'])->name('Reward.index');
Route::get('/loyalty/reward/create', [RewardController::class, 'create'])->name('Reward.create');
Route::post('/loyalty/reward/create', [RewardController::class, 'store'])->name('Reward.store');
Route::get('/loyalty/reward/edit', [RewardController::class, 'edit'])->name('Reward.edit');
Route::put('/loyalty/reward/edit', [RewardController::class, 'update'])->name('Reward.update');
Route::delete('/loyalty/reward/edit', [RewardController::class, 'delete'])->name('Reward.delete');
Route::get('/loyalty/reward/show', [RewardController::class, 'show'])->name('Reward.show');

// Customer Routes
Route::get('/loyalty/customer', [CustomerController::class, 'index'])->name('Customer.index');

// Setting Routes
Route::get('/loyalty/settings', [LoyaltySettingsController::class, 'index'])->name('Setting.index');
Route::get('/loyalty/settings/create', [LoyaltySettingsController::class, 'create'])->name('Setting.create');
Route::post('/loyalty/settings/create', [LoyaltySettingsController::class, 'store'])->name('Setting.store');
Route::get('/loyalty/settings/edit', [LoyaltySettingsController::class, 'edit'])->name('Setting.edit');
Route::put('/loyalty/settings/edit', [LoyaltySettingsController::class, 'update'])->name('Setting.update');
Route::delete('/loyalty/settings/edit', [LoyaltySettingsController::class, 'delete'])->name('Setting.delete');