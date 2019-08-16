<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Brand;
use App\Hsncode;
use App\Category;
use App\Subcategory;
use App\Groupcolor;
use App\Price;

class Product extends Model
{
    protected $fillable = [
        'sku_name', 'alias_name', 'sku_number', 'hsncode_id', 'brand_id', 'category_id', 'subcategory_id',
        'primary_unit', 'secondary_unit', 'other_unit', 'tags', 'weight', 'dimension', 'color', 'mrp',
        'type_of_sale', 'description', 'other_specifications', 'any_cautions', 'image_1', 'image_2',
        'image_3', 'image_4'
    ];

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function hsncode(){
        return $this->belongsTo(Hsncode::class, 'hsncode_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function prices(){
        return $this->hasMany(Price::class, 'product_id', 'id');
    }
}
