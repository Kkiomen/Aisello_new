<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 'name', 'json_page'
    ];

    protected $casts = [
        'json_page' => 'array'
    ];
}
