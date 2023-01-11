<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'alias',
        'description',
        'image',
        'association'
    ];

    protected $appends = ['image_uri', 'article_url'];

    public function getImageUriAttribute()
    {
        if ($this->image)
            return Storage::url($this->image);
        return $this->image;
    }

    public function getAssociationAttribute($value)
    {
        return json_decode($value);
    }

    public function getArticleUrlAttribute()
    {
        if ($this->association) {
            $resource = $this->association->resource;
            $article = Article::where('id',$resource->id)->first();
            return $article->url;
        }

        return '';
    }
}
