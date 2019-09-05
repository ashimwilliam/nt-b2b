<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'image', 'status'
    ];

    public function getImageAttribute($value)
    {
        return env('APP_URL').'/uploads/banner/'.$value;
    }

    public function products(){
        return $this->belongsToMany(Product::class)
            ->select('id', 'sku_name', 'alias_name', 'sku_number', 'tags', 'image_1', 'status')
            ->withPivot('product_id')
            ->withTimestamps();
    }
}
