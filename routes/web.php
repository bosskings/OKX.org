<?php

    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/login', function () {
        return view('login');
    });

    Route::get('/sign-up', function () {
        return view('sign-up');
    });

    Route::middleware(['auth'])->group(function () {
        
    
        Route::get('/dashboard', function () {
            return view('dashboard');
        });
    
        Route::get('/spot-trade', function () {
            return view('spot-trade');
        });
    
        Route::get('/future', function () {
            return view('future');
        });
    
        Route::get('/spot-details', function () {
            return view('spot-details');
        });
    
        Route::get('/future-details', function () {
            return view('future-details');
        });
    });

// require __DIR__.'/auth.php';

