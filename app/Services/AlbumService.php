<?php

namespace App\Services;

use App\Repositories\AlbumRepository;

class AlbumService
{
    protected AlbumRepository $albums;

    public function __construct(AlbumRepository $albums)
    {
        $this->albums = $albums;
    }

    public function getAlbums()
    {
        return $this->albums->all(); // all albums
    }

    public function getAlbum(string $id)
    {
        return $this->albums->find($id);
    }

    public function createAlbum(array $data)
    {
        return $this->albums->create($data);
    }

    public function updateAlbum(string $id, array $data)
    {
        return $this->albums->update($id, $data);
    }

    public function deleteAlbum(string $id)
    {
        return $this->albums->delete($id);
    }
}
