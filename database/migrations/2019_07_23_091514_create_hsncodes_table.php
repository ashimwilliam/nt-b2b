<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHsncodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hsncodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hsncode',100);
            $table->text('description')->nullable();
            $table->date('wef_date')->nullable();
            $table->smallInteger('tax')->default(0);
            $table->smallInteger('additional_tax')->default(0);
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('hsncodes');
    }
}
