<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Формирование таблицы с фильмами
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->time('time');
        
        });
        // Формирование таблицы с Events(Событиями)
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('movie_id');
            $table->boolean('type');
            $table->tinyInteger('visited'); 
            $table->timestamps('created_at');
            // tinyInteger Т.к предполагаю, что один 5д кинотеатр не сможет вместить в себя > 255 чел.  
        });
        // Формирование таблицы с Кинотеатрами(Компаниями)
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movies');
        Schema::drop('events');
        Schema::drop('company');
    }
}
