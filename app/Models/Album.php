<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'release_date',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function songs()
    {
        return $this->belongsToMany(
            Song::class,
            'album_song',
            'album_id',
            'song_id'
        );
    }
}
