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
    
    return Response::file($disk->path($path), [
        'Content-Type'              => $mime,
        'Content-Length'            => $disk->size($path),
        'Accept-Ranges'             => 'bytes',
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
        'Access-Control-Expose-Headers' => 'Content-Length, Content-Range, Accept-Ranges',
        'Cache-Control'             => 'public, max-age=86400', // cache audio for 1 day
    ]);
})->where('path', '.*');
