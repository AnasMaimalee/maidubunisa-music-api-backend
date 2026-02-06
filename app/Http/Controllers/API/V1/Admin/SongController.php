<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SongRepository;
use App\Services\SongService;
use Maimalee\LaravelApiResponse\ApiResponse;

class SongController extends Controller
{
    public function __construct(
        private SongRepository $songs,
        private SongService $service,
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
                'Album not found',
                404
            );
        }

        return $this->response->success($song);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'audio_path' => 'required|string', // replace with file handling later
            'is_active' => 'boolean',
            'album_ids' => 'array',
            'album_ids.*' => 'string|exists:albums,id'
        ]);

        $albumIds = $data['album_ids'] ?? [];
        unset($data['album_ids']);

        $song = $this->service->createSong($data, $albumIds);

        return $this->response->success($song->load('albums'), 'Song created');
    }
    
    public function destroy(Request $request, string $id)
    {
        $song = $this->service->getSong($id);

        if (empty($song)) {
            return $this->response->error('No Song Found');
        }

        $song->delete();

        return $this->response->success(null, 'Song Deleted');
    }
}
