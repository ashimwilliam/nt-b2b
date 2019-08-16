<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Price extends Model
{
    protected $fillable = [
        'product_id', 'title', 'quantity', 'price'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
