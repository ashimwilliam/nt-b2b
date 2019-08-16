<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'description', 'slug', 'status'
    ];

    public function subcategory(){
        return $this->hasMany(Subcategory::class, 'category_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
