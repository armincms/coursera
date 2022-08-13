<?php

use Armincms\Coursera\Models\CourseraLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfigColumnToCourseraSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coursera_subscriptions', function (Blueprint $table) {
            $table->configuration();
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
        Schema::table('coursera_subscriptions', function (Blueprint $table) {
            $table->dropConfiguration();
            $table->dropTimestamps();
        });
    }
}
