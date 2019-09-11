<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'slug', 'status', 'image'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function products(){
        return $this->hasMany(Subcategory::class, 'subcategory_id', 'id');
    }
}
