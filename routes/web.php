<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/songs/{path}', function ($path) {
    $filePath = storage_path("app/public/songs/{$path}");
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    return response()->file($filePath, [
        'Content-Type' => 'audio/mpeg',
        'Content-Disposition' => 'inline',
        'Cache-Control' => 'public, max-age=3600'
    ]);
})->where('path', '.*');
