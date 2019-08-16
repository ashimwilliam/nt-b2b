<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'lat', 'long', 'first_name', 'middle_name', 'last_name', 'address_line_1', 'address_line_2', 'city', 'dstrict', 'pin_code', 'state', 'country', 'landmark',
        'address_type', 'home_address', 'pan_number', 'adhaar_number', 'business_contact_number', 'alternative_number', 'phone_number', 'designation', 'business_name',
        'gstn_number', 'type_of_office', 'department', 'shop_image', 'bank_account_number', 'bank_name', 'branch_name', 'ifsc_code', 'account_holder_name', 'nature_of_business'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
