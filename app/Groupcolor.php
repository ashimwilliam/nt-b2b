<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Color;

class Groupcolor extends Model
{
    protected $fillable = [
        'title', 'description', 'status'
    ];

    public function colors(){
        return $this->belongsToMany(Color::class)
            ->withPivot('color_id')
            ->withTimestamps();
    }
}
