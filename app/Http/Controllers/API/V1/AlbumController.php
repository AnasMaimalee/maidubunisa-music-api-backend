<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\AlbumRepository;
use App\Repositories\SongRepository;
use Maimalee\LaravelApiResponse\ApiResponse;

class AlbumController extends Controller
{
    public function __construct(
        private AlbumRepository $albums,
        private SongRepository $songs,
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

    public function songs(string $id)
    {
        return $this->response->success(
            $this->songs->getByAlbum($id),
            'Album songs fetched'
        );
    }
}
