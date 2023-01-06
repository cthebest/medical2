<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'path',
        'association'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',

    ];

    protected $url;

    public function getAssociationAttribute($value)
    {
        return json_decode($value);
    }


    public function getPathAttribute($value)
    {
        return URL::to($value);
    }
}
