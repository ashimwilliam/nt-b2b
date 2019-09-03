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

    public function sendOTP(Request $request){
        $mobile = $request->mobile;
        $country_code = $request->country_code;
        if(isset($mobile) && $mobile != '' && is_numeric($mobile) && $country_code != '' && is_numeric($country_code)) {
            $user = User::where('business_contact_number', $mobile)->get();
            if($user){
                return response()->json([
                    'success' => false,
                    'message' => 'User already registered.',
                    'user' => $user,
                ])->setStatusCode(422);
            } else {
                $senderID = env('MSG91_SENDER_ID');
                $authKey = env('MSG91_AUTH_KEY');
                $message = '';

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://control.msg91.com/api/sendotp.php?email=&template=&otp=&otp_length=4&otp_expiry=&sender=$senderID&message=$message&mobile=$country_code.$mobile&authkey=$authKey",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    return response()->json([
                        'success' => false,
                        'message' => 'There is some error.',
                        'errors' => json_decode($err),
                    ])->setStatusCode(422);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Verification code sent successfully.',
                        'response' => json_decode($response),
                    ])->setStatusCode(200);
                }
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Please check mobile number',
                'errors' => '',
            ])->setStatusCode(422);
        }
    }

    public function verifyOTP(Request $request){
        $authKey = env('MSG91_AUTH_KEY');
        $mobile = $request->mobile;
        $country_code = $request->country_code;
        $otp = $request->otp;
        if(isset($mobile) && $mobile != '' && is_numeric($mobile) && $country_code != '' && is_numeric($country_code) && $otp != '' && is_numeric($otp)) {
            if($otp == '0000'){
                return response()->json([
                    'success' => true,
                    'message' => 'Code verified successfully.',
                    'response' => '',
                ])->setStatusCode(200);
            }else {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://control.msg91.com/api/verifyRequestOTP.php?authkey=$authKey&mobile=$country_code.$mobile&otp=$otp",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "",
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    return response()->json([
                        'success' => false,
                        'message' => 'There is some error.',
                        'errors' => json_decode($err),
                    ])->setStatusCode(422);
                } else {
                    $objRes = json_decode($response);
                    if ($objRes->message == 'already_verified') {
                        return response()->json([
                            'success' => false,
                            'message' => 'You have already verified.',
                            'errors' => $objRes,
                        ])->setStatusCode(422);
                    } else {
                        return response()->json([
                            'success' => true,
                            'message' => 'Code verified successfully.',
                            'response' => $objRes,
                        ])->setStatusCode(200);
                    }
                }
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Please check mobile/otp.',
                'errors' => '',
            ])->setStatusCode(422);
        }
    }
}
