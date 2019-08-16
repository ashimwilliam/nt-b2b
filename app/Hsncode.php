<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hsncode extends Model
{
    protected $fillable = [
        'hsncode', 'description', 'wef_date', 'tax', 'additional_tax', 'status'
    ];

    public function products(){
        return $this->hasMany(Product::class, 'hsncode_id', 'id');
    }
}
