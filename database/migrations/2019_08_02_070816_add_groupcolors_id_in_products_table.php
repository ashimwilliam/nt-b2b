<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupcolorsIdInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('hsncode_id')->change();
            $table->unsignedBigInteger('brand_id')->change();
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('subcategory_id')->change();

            $table->dropColumn('color');
            $table->unsignedBigInteger('groupcolor_id')->after('dimension');
            $table->boolean('status')->after('groupcolor_id')->nullable()->default(0);

            $table->foreign('hsncode_id')->references('id')->on('hsncodes');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('subcategories');
            $table->foreign('groupcolor_id')->references('id')->on('groupcolors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('hsncode_id')->change();
            $table->integer('brand_id')->change();
            $table->integer('category_id')->change();
            $table->integer('subcategory_id')->change();

            $table->dropForeign('products_groupcolor_id_foreign');
            $table->dropForeign('products_hsncode_id_foreign');
            $table->dropForeign('products_brand_id_foreign');
            $table->dropForeign('products_category_id_foreign');
            $table->dropForeign('products_subcategory_id_foreign');

            $table->string('color')->nullable();
            $table->dropColumn(['groupcolor_id', 'status']);
        });
    }
}
