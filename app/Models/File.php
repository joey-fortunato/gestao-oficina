<?php

namespace App\Models;

use App\Models\User;
use App\Models\FileVersion;
use App\Models\Tag;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class File extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function versions()
    {
        return $this->hasMany(FileVersion::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
