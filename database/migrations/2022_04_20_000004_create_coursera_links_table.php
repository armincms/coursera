<?php

use Armincms\Coursera\Models\CourseraLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseraLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursera_links', function (Blueprint $table) {
            $table->id();  
            $table->string('path');
            $table->tinyInteger('order')->default(0);
            $table->locale();
            $table
                ->enum('resolution', array_keys(CourseraLink::resolutions())) 
                ->default('640x480');
            $table->foreignId('lesson_id')->constrained('coursera_lessons');
            $table->foreignId('server_id')->constrained('coursera_servers');
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
        Schema::dropIfExists('coursera_links');
    }
}
