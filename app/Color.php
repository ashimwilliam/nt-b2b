<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Groupcolor;

class Color extends Model
{
    protected $fillable = [
        'title', 'description', 'shade_img', 'color_code', 'status'
    ];

    public function groupcolors(){
        return $this->belongsToMany(Groupcolor::class)
            ->withPivot('groupcolor_id')
            ->withTimestamps();
    }
}
