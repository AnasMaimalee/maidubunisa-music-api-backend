<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (JWT PROTECTED)
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\API\V1\Admin\AuthController;
use App\Http\Controllers\API\V1\Admin\AlbumController;
use App\Http\Controllers\API\V1\Admin\SongController;

Route::prefix('v1/admin')->group(function () {

    /*
    |--------------------
    | Authentication
    |--------------------
    */
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/password', [AuthController::class, 'updatePassword']);

        /*
        |--------------------
        | Albums Management
        |--------------------
        */
        Route::get('/albums', [AlbumController::class, 'index']);
        Route::post('/albums', [AlbumController::class, 'store']);
        Route::get('/albums/{album}', [AlbumController::class, 'show']);
        Route::put('/albums/{album}', [AlbumController::class, 'update']);
        Route::delete('/albums/{album}', [AlbumController::class, 'destroy']);

        /*
        |--------------------
        | Songs Management
        |--------------------
        */
        Route::get('/songs', [SongController::class, 'index']);
        Route::post('/songs', [SongController::class, 'store']);
        Route::get('/songs/{song}', [SongController::class, 'show']);
        Route::put('/songs/{song}', [SongController::class, 'update']);
        Route::delete('/songs/{song}', [SongController::class, 'destroy']);

        /*
        |--------------------
        | Album ↔ Song Link
        |--------------------
        */
        Route::post('/albums/{album}/songs/{song}', [SongController::class, 'attachToAlbum']);
        Route::delete('/albums/{album}/songs/{song}', [SongController::class, 'detachFromAlbum']);
    });
});

/*
|--------------------------------------------------------------------------
| PUBLIC USER ROUTES (NO AUTH)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    /*
    |--------------------
    | Albums
    |--------------------
    */
    Route::get('/albums', [AlbumController::class, 'index']);
    Route::get('/albums/{album}', [AlbumController::class, 'show']);
    Route::get('/albums/{album}/songs', [SongController::class, 'albumSongs']);

    /*
    |--------------------
    | Songs
    |--------------------
    */
    Route::get('/songs', [SongController::class, 'index']);
    Route::get('/songs/{song}', [SongController::class, 'show']);
});


use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::get('/storage/{path}', function ($path) {
    $path = ltrim(str_replace(['../', '..\\'], '', $path), '/');
    $disk = Storage::disk('public');

    if (!$disk->exists($path)) {
        abort(404);
    }

    $mime = $disk->mimeType($path) ?: 'application/octet-stream';
    if (str_ends_with(strtolower($path), '.mp3')) {
        $mime = 'audio/mpeg';
    }

    return Response::file($disk->path($path), [
        'Content-Type'  => $mime,
        'Content-Length' => $disk->size($path),
        'Accept-Ranges' => 'bytes',
        'Access-Control-Allow-Origin' => '*',           // ← good
        'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
        'Access-Control-Expose-Headers' => 'Content-Length, Content-Range, Accept-Ranges',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*');
