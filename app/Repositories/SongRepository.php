<?php

namespace App\Repositories;

use App\Models\Song;
use Illuminate\Support\Str;

class SongRepository
{
    /**
     * Format a single Song model into array response
     */
    protected function formatSong(Song $song): array
    {
        $filePath = $song->file_path ?? '';

        return [
            'id'         => $song->id,
            'title'      => $song->title,
            'duration'   => $song->duration,
            'file_size'  => $song->file_size,
            'file_path'  => $filePath,

            // 🔥 FIXED: Always use secure (HTTPS) URL
            // secure_url() guarantees https:// even if APP_URL is http
            'url'        => $filePath 
                ? secure_url('storage/' . ltrim($filePath, '/'))
                : '', // empty if no file path

            'is_active'  => $song->is_active,
            'created_at' => $song->created_at,
        ];
    }

    /**
     * Get all active songs
     */
    public function all()
    {
        // Optional: filter only active songs
        return Song::where('is_active', 1)
            ->get()
            ->map(fn ($song) => $this->formatSong($song));
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
        if (! $song) {
            return null;
        }

        $song->update($data);
        return $this->formatSong($song);
    }

    public function delete(string $id)
    {
        $song = Song::find($id);
        if (! $song) {
            return false;
        }

        return $song->delete();
    }
}