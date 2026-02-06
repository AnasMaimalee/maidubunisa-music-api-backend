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
}
