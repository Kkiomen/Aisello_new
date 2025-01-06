<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'language',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'tag_article');
    }
}
