<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sku_name');
            $table->string('alias_name')->nullable();
            $table->string('sku_number');
            $table->integer('hsncode_id');
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->string('primary_unit')->nullable();
            $table->string('secondary_unit')->nullable();
            $table->string('other_unit')->nullable();
            $table->text('tags')->nullable();
            $table->string('weight')->nullable();
            $table->string('dimension')->nullable();
            $table->string('color')->nullable();
            $table->decimal('mrp', 8,2);
            $table->string('type_of_sale', 100)->nullable(); //Retail/Bulk/Other
            $table->text('description');
            $table->text('other_specifications')->nullable();
            $table->text('any_cautions')->nullable();
            $table->string('image_1');
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_4')->nullable();
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
        Schema::dropIfExists('products');
    }
}
