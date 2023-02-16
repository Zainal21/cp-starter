<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'name',
        'slug'
    ];
    
    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
