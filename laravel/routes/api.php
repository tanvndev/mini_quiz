<?php

use App\Http\Controllers\Api\V1\{
    DashboardController,
};
use App\Http\Controllers\Api\V1\Auth\{
    AuthController,
    VerificationController
};
use App\Http\Controllers\Api\V1\Upload\{UploadController};
use App\Http\Controllers\Api\V1\Location\{LocationController};
use App\Http\Controllers\Api\V1\Permission\PermissionController;
use App\Http\Controllers\Api\V1\Topic\TopicController;
use App\Http\Controllers\Api\V1\User\{UserCatalogueController, UserController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {
    // AUTH ROUTE
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('refreshToken', [AuthController::class, 'refreshToken']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
    Route::get('/email-register-verify/{id}', [VerificationController::class, 'emailRegisterVerify'])->name('email.register.verify');

    // LOCATION ROUTE
    Route::prefix('location')->group(function () {
        Route::get('provinces', [LocationController::class, 'getProvinces']);
        Route::get('getLocation', [LocationController::class, 'getLocation']);
    });



    // Routes with JWT Middleware
    Route::group(['middleware' => 'jwt.verify'], function () {

        // DASHBOARD ROUTE
        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::put('changeStatus', [DashboardController::class, 'changeStatus'])->name('changeStatus');
            Route::put('changeStatusMultiple', [DashboardController::class, 'changeStatusMultiple'])->name('changeStatusMultiple');
            Route::delete('deleteMultiple', [DashboardController::class, 'deleteMultiple'])->name('deleteMultiple');
        });

        // USER CATALOGUE ROUTE
        // * Neu dung resource de tao .../catalogues thi phai gan them name neu khong se bi loi
        Route::prefix('/')->name('users.')->group(function () {
            Route::apiResource('users/catalogues', UserCatalogueController::class);
        });
        Route::put('users/catalogues/permissions/{id}', [UserCatalogueController::class, 'updatePermissions'])->name('users.catalogues.permissions');

        // USER ROUTE
        Route::apiResource('users', UserController::class);

        // PERMISSION ROUTE
        Route::apiResource('permissions', PermissionController::class);

        // TOPIC ROUTE
        Route::apiResource('topics', TopicController::class);

        // Upload ROUTE
        Route::apiResource('uploads', UploadController::class);
    });
});
