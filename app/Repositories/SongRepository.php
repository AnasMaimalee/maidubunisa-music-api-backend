<?php

namespace App\Repositories;

use App\Models\Song;
use Illuminate\Support\Str;

class SongRepository
{
    protected function formatSong(Song $song): array
    {
        return [
            'id'         => $song->id,
            'title'      => $song->title,
            'duration'   => $song->duration,
            'file_size'  => $song->file_size,
            'file_path'  => $song->file_path,
            'url'        => asset('storage/' . $song->file_path), // 🔥 FIX
            'is_active'  => $song->is_active,
            'created_at'=> $song->created_at,
        ];
    }

    public function all()
    {
        return Song::all()->map(fn ($song) => $this->formatSong($song));
    }

    public function find(string $id)
    {
        $song = Song::find($id);
        return $song ? $this->formatSong($song) : null;
    }

    public function create(array $data)
    {
        $data['id'] = Str::uuid()->toString();
        $song = Song::create($data);

        return $this->formatSong($song);
    }

    public function update(string $id, array $data)
    {
        $song = Song::find($id);
        if (! $song) return null;

        $song->update($data);
        return $this->formatSong($song);
    }

    public function delete(string $id)
    {
        $song = Song::find($id);
        if (! $song) return false;

        return $song->delete();
    }
}
