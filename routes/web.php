<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

Route::get('/storage/{path}', function ($path) {
    $path = ltrim(str_replace(['../', '..\\'], '', $path), '/');

    $disk = Storage::disk('public');

    if (!$disk->exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    $mime = $disk->mimeType($path) ?: 'application/octet-stream';
    if (str_ends_with(strtolower($path), '.mp3')) {
        $mime = 'audio/mpeg';
    }

   return Response::file($disk->path($path), [
        'Content-Type' => $mime,
        'Content-Length' => $disk->size($path),
        'Accept-Ranges' => 'bytes',
        'Access-Control-Allow-Origin' => '*',           // ← remove this
        'Access-Control-Allow-Methods' => 'GET, HEAD, OPTIONS',
        'Access-Control-Expose-Headers' => 'Content-Length, Content-Range, Accept-Ranges',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*');