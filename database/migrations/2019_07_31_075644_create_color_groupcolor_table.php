<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorGroupcolorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_groupcolor', function (Blueprint $table) {
            $table->integer('color_id')->unsigned()->nullable();
            /*$table->foreign('color_id')->references('id')
                ->on('colors')->onDelete('cascade');*/

            $table->integer('groupcolor_id')->unsigned()->nullable();
            /*$table->foreign('groupcolor_id')->references('id')
                ->on('groupcolors')->onDelete('cascade');*/

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
        Schema::dropIfExists('color_groupcolor');
    }
}
