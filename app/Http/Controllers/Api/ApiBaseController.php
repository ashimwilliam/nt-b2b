<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\NotificationTrait;
use App\Traits\RequestJsonTypeTrait;
use App\Traits\UserSessionTrait;
use GuzzleHttp\Client;
use Mail,Auth;

class ApiBaseController extends Controller
{
    use NotificationTrait, UserSessionTrait, RequestJsonTypeTrait;
    public $client = null;

    function __construct(){
       // $this->middleware('guest')->only(['create', 'store', 'refreshToken', 'update']);
        //$this->middleware('auth_user')->except(['update','create', 'store','login', 'refreshToken', 'forgetPassword','setNewPassword']);
        //$this->client = ClientBuilder::create()->build();
    }

    public function currentUser(){
        $user = Auth::user();
        if (!$user) {
            $user = Auth::guard('api')->user();
        }
        return $user;
    }
}
