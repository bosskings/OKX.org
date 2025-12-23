<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

    Route::get('/', function(){ return view('index');})->name('home');

    Route::get('/login', function(){return view('login');})->name('login');

    Route::post('/login', [AuthenticationController::class, "login"])->name('login');

    Route::get('/sign-up', function(){return view('sign-up');});

    Route::post('/sign-up', [AuthenticationController::class, "register"])->name('register');



    // for admin section
    Route::get('/Admin-encrypted-form-999223', [AdminController::class, 'displayUsers'] )->name('adminHome');

    Route::get('/createTraders', [AdminController::class, 'showAllTraders'])->name('createTraders');

    Route::post('/createTraders', [AdminController::class, 'createTraders'])->name('createTraders');
    Route::post('/approveInvestment', [AdminController::class, 'approveInvestment'])->name('approveInvestment');
    Route::post('/approveWithdrawal', [AdminController::class, 'approveWithdrawal'])->name('approveWithdrawal');
    Route::post('/changeBalance', [AdminController::class, 'changeBalance'])->name('changeBalance');
    Route::post('/changePnl', [AdminController::class, 'changePnl'])->name('changePnl');
    Route::post('/changeTotalAssets', [AdminController::class, 'changeTotalAssets'])->name('changeTotalAssets');
    Route::post('/suspendUser', [AdminController::class, 'suspendUser'])->name('suspendUser');
    Route::post('/changePassword', [AdminController::class, 'changePassword'])->name('changePassword');








    Route::middleware(['auth'])->group(function () {
    
        Route::get('/dashboard', function(){ return view('dashboard', ['user'=>Auth::user()] ); })->name('dashboard');
        Route::post('/deposit', [DashboardController::class, 'deposit'])->name('deposit');
        Route::post('/withdrawRequest', [DashboardController::class, 'withdrawRequest'])->name('withdrawRequest');

        
        Route::get('/futures', [DashboardController::class, 'showFuturesTraders'])->name('futures');
        Route::get('/futureDetails/{id?}', [DashboardController::class, 'futureDetails'])->name('futureDetails');
        Route::post('/copyTrades', [DashboardController::class, 'copyTrades'])->name('copyTrades');
        
        Route::get('/spots', function(){return view('spot-trade');})->name('spots');
        Route::get('/spotDetails', function () {return view('spot-details'); });
    

        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    });

// require __DIR__.'/auth.php';

