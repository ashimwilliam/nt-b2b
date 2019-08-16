<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Mail,Auth;
use Illuminate\Support\Facades\File;
use Validator;
use Session;

class BaseController extends Controller
{

    function __construct(){
       // $this->middleware('guest')->only(['create', 'store', 'refreshToken', 'update']);
        //$this->middleware('auth_user')->except(['update','create', 'store','login', 'refreshToken', 'forgetPassword','setNewPassword']);
        //$this->client = ClientBuilder::create()->build();
    }

    public function uploadImage($request, $dir = '', $fieldName = '', $oldImgName = '', $flag_update = '') {
        if(!empty($dir) && !empty($fieldName)){

            if (!File::exists("uploads/" . $dir)) {
                $folderForFiles = File::makeDirectory("uploads/" . $dir, $mode = 0777, true, true);
            }

            $destinationPath = public_path() . "/uploads/" . $dir;
            $file = $request->file($fieldName);

            if (!empty($file)) {

                // Delete the old image
                if ($flag_update == 1) {
                    if (!empty($request->get($oldImgName))) {
                        File::Delete($destinationPath . $request->get($oldImgName));
                    }
                }

                $fileExtension = $file->getClientOriginalExtension();
                //$filename = date('d-m-Y+H-i-s') . str_replace(" ", "_", $file->getClientOriginalName());
                $filename = time()."_".mt_rand(100, 9999).".".$fileExtension;
                $filedata = $file->move($destinationPath, $filename);

                if ($filedata) {
                    return $filename;
                }
            }else if($flag_update == 1){
                return $oldImgName;
            }else{}
        }
        return false;
    }
}
