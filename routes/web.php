<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;

    Route::get('/', function(){ return view('index');})->name('home');

    Route::get('/login', function(){return view('login');})->name('login');

    Route::post('/login', [AuthenticationController::class, "login"])->name('login');

    Route::get('/sign-up', function(){return view('sign-up');});

    Route::post('/sign-up', [AuthenticationController::class, "register"])->name('register');

    Route::middleware(['auth'])->group(function () {
    
        Route::get('/dashboard', function(){return view('dashboard');})->name('dashboard');
    
        Route::get('/spot-trade', function(){return view('spot-trade');})->name('spot.trade');
    
        Route::get('/future', function () {return view('future');})->name('future.trade');
    
        Route::get('/spot-details', function () {
            return view('spot-details');
        });
    
        Route::get('/future-details', function () {
            return view('future-details');
        });

        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    });

// require __DIR__.'/auth.php';

