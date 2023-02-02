<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Meeting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('Customers');
            $table->foreignId('staff_id')->references('id')->on('Staffs');
            $table->foreignId('service_id')->references('id')->on('Services');
            $table->foreignId('creator_user_id')->references('id')->on('Users');
            $table->dateTime('meeting_at');
            $table->integer('duration');
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
        Schema::dropIfExists('Meetings');
    }
}
