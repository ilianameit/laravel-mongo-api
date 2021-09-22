<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Videos extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'videos';
    protected $fillable = [
        'name','file', 'created_by'
    ];

    public function creator(){
        return $this->hasOne('App\Models\User', '_id', 'created_by');
    }
}
