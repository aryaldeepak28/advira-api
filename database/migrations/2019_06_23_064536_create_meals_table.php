<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('title');
            $table->string('description');
            $table->string('photo');
            $table->integer('photo_rotation')->default(0);
            $table->decimal('amount',10,6)->nullable();
            $table->string("restaurant_name")->nullable();
            $table->string("lat")->nullable();
            $table->string("lon")->nullable();
            $table->unsignedBigInteger('meal_category_id')->unsigned();
            $table->unsignedBigInteger('posted_by')->unsigned();
            $table->unsignedBigInteger('restaurant_id')->unsigned();
            $table->timestamps();


            $table->foreign('meal_category_id')->references('id')->on('meal_categories');
            $table->foreign('posted_by')->references('id')->on('users');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals');
    }
}
