<?php

namespace App\Models;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slider extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();

        static::deleting(function($slider) {
            Utils::removeFile($slider->image);
        });
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function next(){
        return $this->order()
                ->where('order', '>', $this->order)
                ->first();

    }
    public function previous(){
        return $this->order()
                ->where('order', '<', $this->order)
                ->get()
                ->last();
    }
}
