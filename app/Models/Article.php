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

    protected $appends = ['url'];


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

    public function getUrlPhotoAttribute($value)
    {
        if ($value)
            return Storage::url($value);
        return $value;
    }

    public function getUrlAttribute()
    {
        $urlGenerator = new UrlGenerator;
        return $urlGenerator->generate(1, $this);
    }
}
