<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            //$table->bigIncrements('id');
            $table->bigInteger('product_id');
            //$table->foreign('product_id')->references('id')->on('products');
            $table->string('title')->nullable();
            $table->smallInteger('quantity')->default(0);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('prices', function(Blueprint $table){
            $table->dropForeign('prices_product_id_foreign');
        });*/

        Schema::dropIfExists('prices');
    }
}
