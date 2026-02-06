<?php

namespace App\Services;

use App\Repositories\SongRepository;

class SongService
{
    protected SongRepository $songs;

    public function __construct(SongRepository $songs)
    {
        $this->songs = $songs;
    }

    public function getSongs()
    {
        return $this->songs->all();
    }

    public function getSong(string $id)
    {
        return $this->songs->find($id);
    }

    public function getAlbumSongs(string $albumId)
    {
        return $this->songs->all()->filter(function($song) use ($albumId) {
            return $song->albums->contains('id', $albumId);
        });
    }

    public function createSong(array $data, array $albumIds = [])
    {
        $song = $this->songs->create($data);

        if ($albumIds) {
            $this->songs->attachToAlbums($song->id, $albumIds);
        }

        return $song->load('albums');
    }

    public function updateSong(string $id, array $data)
    {
        return $this->songs->update($id, $data);
    }

    public function deleteSong(string $id)
    {
        return $this->songs->delete($id);
    }
}
