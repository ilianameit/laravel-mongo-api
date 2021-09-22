<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Likes extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'likes';
    protected $fillable = [
        'video_id', 'created_by'
    ];
}
