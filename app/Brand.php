<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Brand extends Model
{
    protected $fillable = [
        'title', 'description', 'slug', 'status'
    ];

    public function products(){
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
