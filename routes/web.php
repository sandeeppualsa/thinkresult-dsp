<?php

use App\Http\Controllers\Admin\AdvertiserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InsertionOrderController;
use App\Http\Controllers\Admin\LineItemController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Advertiser\AuthController as AdvertiserAuthController;
use App\Http\Controllers\Advertiser\CampaignController as AdvertiserCampaignController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Route;

// Web Frontend Routes
Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware('prevent-back')->prefix('admin')->group(function () {
    Route::middleware('admin-auth')->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name("login");
        Route::post('verify_login', [AuthController::class, 'verifyLogin']);
    });

    Route::middleware('admin-all')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::get('profile', [ProfileController::class, 'index']);
        Route::post('profile/save_profile', [ProfileController::class, 'save_profile']);
        Route::get('security', [ProfileController::class, 'security']);
        Route::post('security/save_change_password', [ProfileController::class, 'save_change_password']);
        Route::get('logout', [DashboardController::class, 'logout']);

        Route::prefix('common')->group(function () {
            Route::post('upload_files', [CommonController::class, 'upload_files']);
        });

        Route::middleware('super-admin')->group(function () {
            Route::get('users', [UserController::class, 'index']);
            Route::get('users/create', [UserController::class, 'create']);
            Route::post('users', [UserController::class, 'store']);
            Route::get('users/{id}/edit', [UserController::class, 'edit']);
            Route::put('users/{id}', [UserController::class, 'update']);
            Route::delete('users/{id}', [UserController::class, 'destroy']);
            Route::get('users/data', [UserController::class, 'getUsers']);

            Route::get('advertisers', [AdvertiserController::class, 'index']);
            Route::get('advertisers/create', [AdvertiserController::class, 'create']);
            Route::post('advertisers', [AdvertiserController::class, 'store']);
            Route::get('advertisers/{id}/edit', [AdvertiserController::class, 'edit']);
            Route::put('advertisers/{id}', [AdvertiserController::class, 'update']);
            Route::delete('advertisers/{id}', [AdvertiserController::class, 'destroy']);

            Route::prefix('advertisers/{advertiserId}/campaigns')->group(function () {
                Route::get('/', [CampaignController::class, 'index']);
                Route::get('/create', [CampaignController::class, 'create']);
                Route::post('/', [CampaignController::class, 'store']);
                Route::get('/{campaignId}/edit', [CampaignController::class, 'edit']);
                Route::put('/{campaignId}', [CampaignController::class, 'update']);
                Route::delete('/{campaignId}', [CampaignController::class, 'destroy']);

                Route::prefix('{campaignId}/insertion-orders')->group(function () {
                    Route::get('/', [InsertionOrderController::class, 'index']);
                    Route::get('/create', [InsertionOrderController::class, 'create']);
                    Route::post('/', [InsertionOrderController::class, 'store']);
                    Route::get('/{insertionOrderId}/edit', [InsertionOrderController::class, 'edit']);
                    Route::put('/{insertionOrderId}', [InsertionOrderController::class, 'update']);
                    Route::delete('/{insertionOrderId}', [InsertionOrderController::class, 'destroy']);
                });

                Route::prefix('{campaignId}/line-items')->group(function () {
                    Route::get('/', [LineItemController::class, 'index']);
                    Route::get('/create', [LineItemController::class, 'create']);
                    Route::post('/', [LineItemController::class, 'store']);
                    Route::get('/{lineItemId}/edit', [LineItemController::class, 'edit']);
                    Route::put('/{lineItemId}', [LineItemController::class, 'update']);
                    Route::delete('/{lineItemId}', [LineItemController::class, 'destroy']);
                });
            });
        });
    });
});

// Advertiser Routes
Route::middleware('prevent-back')->prefix('advertiser')->group(function () {
    Route::middleware('advertiser-auth')->group(function () {
        Route::get('login', [AdvertiserAuthController::class, 'login'])->name("advertiser.login");
        Route::post('verify_login', [AdvertiserAuthController::class, 'verifyLogin']);
    });

    Route::middleware('advertiser-all')->group(function () {
        Route::get('dashboard', [AdvertiserCampaignController::class, 'index']);
        Route::get('logout', [AdvertiserAuthController::class, 'logout']);
    });
});
