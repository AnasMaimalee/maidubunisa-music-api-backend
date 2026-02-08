<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\SongRepository;
use Maimalee\LaravelApiResponse\ApiResponse;

class SongController extends Controller
{
    public function __construct(
        private SongRepository $songs,
        private ApiResponse $response
    ) {}

    public function index()
    {
        return $this->response->success(
            $this->songs->all(),
            'Songs fetched'
        );
    }

    public function show(string $id)
    {
        $song = $this->songs->find($id);

        if (! $song) {
            return $this->response->error(
                'Song not found',
                404
            );
        }

        return $this->response->success($song);
    }

    public function stream($path)
    {
        $fullPath = storage_path('app/public/' . $path); // adjust if needed

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $mime = 'audio/mpeg'; // force for .mp3

        // Or detect properly:
        // $mime = mime_content_type($fullPath) ?: 'audio/mpeg';

        return response()->file($fullPath, [
            'Content-Type' => $mime,
            'Content-Length' => filesize($fullPath),
            'Accept-Ranges' => 'bytes', // helps seeking
        ]);
    }
}
