<?php

use App\Http\Controllers\Api\v1\Accountant\AccountantCashRequestController;
use App\Http\Controllers\Api\v1\Admin\AdminCashRequestController;
use App\Http\Controllers\Api\v1\CashCategoryController;
use App\Http\Controllers\Api\v1\Employee\AuthController;
use App\Http\Controllers\Api\v1\Employee\CashRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * API Routes
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider and all of them will
 * be assigned to the "api" middleware group. Make something great!
 */

Route::group(['prefix' => '/auth'], function () {


    Route::post('/login', [AuthController::class, 'login']);


});

//cancel order

Route::group(['middleware' => 'auth:api'], function () {

    //Profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/update-profile', [AuthController::class, 'updateProfile']);

    //Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    //chash Request

    Route::post('/cash-request', [CashRequestController::class, 'cashRequest']);
    //get my cash requests
    Route::get('/my-cash-requests', [CashRequestController::class, 'myCashRequests']);
    //get single cash request
    Route::get('/my-cash-request/{cash_request_id}', [CashRequestController::class, 'showMyCashRequest']);

    //get all departments
    Route::get('/departments', [CashRequestController::class, 'departments']);
    Route::get('/department/{id}', [CashRequestController::class, 'showDepartment']);

    //get all cash categories
    Route::get('/cash-categories', [CashCategoryController::class, 'cashCategories']);
    Route::get('/cash-category/{id}', [CashCategoryController::class, 'showCashCategory']);

    //routes by manager
    Route::group(['middleware' => 'Manager'], function () {

        //create cash request
        Route::post('/manager-cash-request', [CashRequestController::class, 'managerCashRequest']);
        //get all cash requests
        Route::get('/manager-cash-requests/{department_id}', [CashRequestController::class, 'cashRequests']);
        //get single cash request
        Route::get('/manager-cash-request/{department_id}/{cash_request_id}', [CashRequestController::class, 'showCashRequest']);
        //approved by manager
        Route::post('/approved-by-manager/{cash_request_id}', [CashRequestController::class, 'approvedByManager']);
        //Rejected by manager
        Route::post('/rejected-by-manager/{cash_request_id}', [CashRequestController::class, 'rejectedByManager']);
        //get all cash requests
    });

    //routes by accountant
    Route::group(['middleware' => 'Accountant'], function () {

        //get all cash requests
        Route::get('/accountant-cash-requests', [AccountantCashRequestController::class, 'cashRequests']);
        //get single cash request
        Route::get('/accountant-cash-request/{cash_request_id}', [AccountantCashRequestController::class, 'showCashRequest']);
        //approved by accountant
        Route::post('/approved-by-accountant/{cash_request_id}', [AccountantCashRequestController::class, 'approvedByAccountant']);
        //Rejected by accountant
        Route::post('/rejected-by-accountant/{cash_request_id}', [AccountantCashRequestController::class, 'rejectedByAccountant']);
    });


    //routes by admin
    Route::group(['middleware' => 'Admin'], function () {

        //get all cash requests
        Route::get('/admin-cash-requests', [AdminCashRequestController::class, 'cashRequests']);
        //get single cash request
        Route::get('/admin-cash-request/{cash_request_id}', [AdminCashRequestController::class, 'showCashRequest']);
        //approved by admin
        Route::post('/approved-by-admin/{cash_request_id}', [AdminCashRequestController::class, 'approvedByAdmin']);
        //Rejected by admin
        Route::post('/rejected-by-admin/{cash_request_id}', [AdminCashRequestController::class, 'rejectedByAdmin']);
    });





});

