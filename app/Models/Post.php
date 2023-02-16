<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory,SoftDeletes,Uuids;

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'author',
        'thumbnail',
        'content',
        'status',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function setPublish()
    {
        $this->attributes['status'] = 'publish';
        self::save();
    }

    public function setArchive()
    {
        $this->attributes['status'] = 'archive';
        self::save();
    }
}
