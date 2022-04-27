<?php

use Armincms\Coursera\Models\CourseraLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseraSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coursera_subscriptions', function (Blueprint $table) {
            $table->id();   
            $table->foreignId('user_id')->constrained('users');  
            $table->foreignId('coursera_course_id')->constrained('coursera_courses');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coursera_subscriptions');
    }
}
