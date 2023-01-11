<?php

namespace App\Models;

use App\Services\UrlGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'alias',
        'body',
        'image'
    ];

    protected $appends = ['url', 'image_uri'];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUriAttribute()
    {
        if ($this->image)
            return Storage::url($this->image);
        return $this->image;
    }

    public function getUrlAttribute()
    {
        $urlGenerator = new UrlGenerator;
        return $urlGenerator->generate(1, $this);
    }
}
