<?php

namespace App\Http\Controllers\API\V1\Admin;


use App\Http\Controllers\Controller;
use App\Repositories\AlbumRepository;
use App\Repositories\SongRepository;
use Illuminate\Http\Request;
use App\Services\AlbumService;
use Maimalee\LaravelApiResponse\ApiResponse;

class AlbumController extends Controller
{
    public function __construct(
        private AlbumRepository $albums,
        private SongRepository $songs,
        private AlbumService $service,
        private ApiResponse $response
    ) {}

  
    public function index()
    {
        return $this->response->success(
            $this->albums->all(),
            'Albums fetched'
        );
    }
    
    public function show(string $id)
    {
        $album = $this->albums->find($id);

        if (! $album) {
            return $this->response->error(
                'Album not found',
                404
            );
        }

        return $this->response->success($album);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $album = $this->service->createAlbum($data);

        return $this->response->success($album, 'Album created');
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'string|max:255',
            'release_date' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $album = $this->service->updateAlbum($id, $data);

        if (!$album) return $this->response->error('Album not found', 404);

        return $this->response->success($album, 'Album updated');
    }

    public function destroy(Request $request, string $id)
    {
        $album = $this->service->getAlbum($id);

        if (empty($album)) {
            return $this->response->error('No Album Found');
        }

        $album->delete();

        return $this->response->success(null, 'Album Deleted');
    }

}
