<?php
/**
 * Created by PhpStorm.
 * User: chandan
 * Date: 18/7/17
 * Time: 12:58 PM
 */

namespace App\Traits;

use Illuminate\Http\Request;

trait RequestJsonTypeTrait
{
    public static function isJsonType(Request $request)
    {
        return $request->wantsJson() || $request->header('Content-Type') == 'application/json';
    }
}