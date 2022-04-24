<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseraLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursera_lessons', function (Blueprint $table) {
            $table->id();
            $table->summary(); 
            $table->longPrice();  
            $table->configuration(); 
            $table->tinyInteger('order')->default(0);   
            $table->foreignId('episode_id')->constrained('coursera_episodes');  
            $table->softDeletes(); 
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
        Schema::dropIfExists('coursera_lessons');
    }
}
