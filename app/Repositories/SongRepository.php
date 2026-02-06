<?php

namespace App\Repositories;

use App\Models\Song;
use Illuminate\Support\Str;

class SongRepository
{
    public function all()
    {
        return Song::all();
    }

    public function find(string $id)
    {
        return Song::find($id);
    }

    public function create(array $data)
    {
        $data['id'] = Str::uuid()->toString();
        return Song::create($data);
    }

    public function update(string $id, array $data)
    {
        $song = $this->find($id);
        if (!$song) return null;
        $song->update($data);
        return $song;
    }

    public function delete(string $id)
    {
        $song = $this->find($id);
        if (!$song) return false;
        return $song->delete();
    }

    public function attachToAlbums(string $songId, array $albumIds)
    {
        $song = $this->find($songId);
        if (!$song) return null;
        $song->albums()->sync($albumIds);
        return $song->load('albums');
    }
}
