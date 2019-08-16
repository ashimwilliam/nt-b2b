<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRetailerFieldsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lat', 100)->after('remember_token')->nullable();
            $table->string('long', 100)->after('lat')->nullable();
            $table->string('first_name', 100)->after('long');
            $table->string('middle_name', 100)->after('first_name')->nullable();
            $table->string('last_name', 100)->after('middle_name');
            $table->string('address_line_1', 255)->after('last_name');
            $table->string('address_line_2', 255)->after('address_line_1');
            $table->string('city', 100)->after('address_line_2');
            $table->string('dstrict', 100)->after('city')->nullable();
            $table->integer('pin_code')->after('dstrict')->nullable();
            $table->string('state', 100)->after('pin_code')->nullable();
            $table->string('country', 100)->after('state')->nullable();
            $table->string('landmark', 255)->after('country')->nullable();
            $table->string('address_type', 100)->after('landmark')->nullable();
            $table->string('home_address', 255)->after('address_type')->nullable();
            $table->string('pan_number', 20)->after('home_address')->nullable();
            $table->string('adhaar_number', 20)->after('pan_number')->nullable();
            $table->string('business_contact_number', 20)->after('adhaar_number');
            $table->string('alternative_number', 20)->after('business_contact_number')->nullable();
            $table->string('phone_number', 20)->after('alternative_number')->nullable();
            $table->string('designation', 20)->after('phone_number')->nullable();
            $table->string('business_name', 100)->after('designation');
            $table->string('gstn_number', 100)->after('business_name')->nullable();
            $table->string('type_of_office', 100)->after('gstn_number')->nullable();
            $table->string('department', 100)->after('type_of_office');
            $table->string('shop_image', 100)->after('department')->nullable();
            $table->string('bank_account_number', 100)->after('shop_image')->nullable();
            $table->string('bank_name', 100)->after('bank_account_number')->nullable();
            $table->string('branch_name', 100)->after('bank_name')->nullable();
            $table->string('ifsc_code', 20)->after('branch_name')->nullable();
            $table->string('account_holder_name', 100)->after('ifsc_code')->nullable();
            $table->string('nature_of_business', 100)->after('account_holder_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['lat', 'long', 'first_name', 'middle_name', 'last_name', 'address_line_1', 'address_line_2', 'city', 'dstrict', 'pin_code', 'state', 'country', 'landmark',
                'address_type', 'home_address', 'pan_number', 'adhaar_number', 'business_contact_number', 'alternative_number', 'phone_number', 'designation', 'business_name',
                'gstn_number', 'type_of_office', 'department', 'shop_image', 'bank_account_number', 'bank_name', 'branch_name', 'ifsc_code', 'account_holder_name', 'nature_of_business']);
            //$table->dropUnique('users_business_contact_number_unique');
        });
    }
}
