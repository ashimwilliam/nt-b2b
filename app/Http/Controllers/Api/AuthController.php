<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use Auth;
use GuzzleHttp\Client;

class AuthController extends ApiBaseController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ])->setStatusCode(422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        //unset($input['c_password']);

        $user = User::create($input);
        $response =   $this->getAuthToken([
            'grant_type' => 'password',
            'username' => $request->email,
            'password' => $request->password
        ]);

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $response->access_token,
            'refresh_token' => $response->refresh_token
        ])->setStatusCode(200);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ])->setStatusCode(422);
        }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();

            $response =   $this->getAuthToken([
                'grant_type' => 'password',
                'username' => $request->email,
                'password' => $request->password
            ]);
            if($cuser = $this->currentUser()){
                //$cuser->update($request->all());
            }
            //$user->settings;

            return response()->json([
                'success' => true,
                'user' => $user,
                'access_token' => $response->access_token,
                'refresh_token' => $response->refresh_token
            ])->setStatusCode(200);
        } else {
            return response()->json([
                'success' => false,
                'errors' => 'Unauthorised'
            ])->setStatusCode(401);
        }
    }

    public function logout(Request $request){
        $cuser = $this->currentUser();
        /*$updUser = User::find($cuser->id);
        $updUser->player_id = null;
        $updUser->save();*/

        $cuser->token()->revoke();
        //$cuser->AuthAcessToken()->delete(); //where  AauthAcessToken is hasmany //relationship written in User.php to oauth_access_tokens table
        return response()->json([
            'success' => true,
            'errors' => 'Successfully logged out'
        ])->setStatusCode(200);
    }

    public function refreshToken(Request $request){
        if ($request->input('refresh_token') == ""){
            return response()->json([
                'success' => false,
                'errors' => 'Please Enter Refresh Token'
            ])->setStatusCode(422);
        }

        try{
            $response =   $this->getAuthToken(['grant_type' => 'refresh_token', 'refresh_token' => $request->input('refresh_token')]);
            return response()->json([
                'success' => true,
                'access_token' => $response->access_token,
                'refresh_token' => $response->refresh_token
            ])->setStatusCode(200);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Invalid Data',
                'error_message' => $e->getMessage(),
            ])->setStatusCode(404);
        }
    }

    private function getAuthToken($argData){
        $form_params = [];
        $form_params['client_id'] = env('CLIENT_ID');
        $form_params['client_secret'] = env('CLIENT_SECRET');
        $form_params['scope'] = '';
        $form_params = $form_params+$argData;

        $http = new Client();
        $response = $http->post(env('APP_PASSPORT_URL').'/oauth/token', ['form_params' => $form_params]);

        return 	$response =  json_decode((string) $response->getBody());
    }

    /*public function currentUser(){
        $user = Auth::user();
        if (!$user) {
            $user = Auth::guard('api')->user();
        }
        return $user;
    }*/
}
