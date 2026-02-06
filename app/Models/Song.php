<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Song extends Model
{
    use HasFactory;

    protected $table = 'songs';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'file_name',
        'duration',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function albums()
    {
        return $this->belongsToMany(
            Album::class,
            'album_song',
            'song_id',
            'album_id'
        );
    }
}
