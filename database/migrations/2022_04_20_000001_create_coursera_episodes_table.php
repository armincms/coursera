<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseraEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursera_episodes', function (Blueprint $table) {
            $table->id();
            $table->resourceName(); 
            $table->resourceSummary(); 
            $table->auth();    
            $table->tinyInteger('order')->default(0);   
            $table->foreignId('course_id')->constrained('coursera_courses'); 
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
        Schema::dropIfExists('coursera_episodes');
    }
}
