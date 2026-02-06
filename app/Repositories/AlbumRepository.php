<?php

namespace App\Repositories;

use App\Models\Album;
use Illuminate\Support\Str;

class AlbumRepository
{
    public function all()
    {
        return Album::all();
    }

    public function find(string $id)
    {
        return Album::find($id);
    }

    public function create(array $data)
    {
        $data['id'] = Str::uuid()->toString();
        return Album::create($data);
    }

    public function update(string $id, array $data)
    {
        $album = $this->find($id);
        if (!$album) return null;
        $album->update($data);
        return $album;
    }

    public function delete(string $id)
    {
        $album = $this->find($id);
        if (!$album) return false;
        return $album->delete();
    }
}
