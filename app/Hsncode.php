<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hsncode extends Model
{
    protected $fillable = [
        'hsncode', 'description', 'wef_date', 'tax', 'additional_tax', 'status'
    ];
}
