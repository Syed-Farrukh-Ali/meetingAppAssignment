<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('description');
            $table->dateTime('datetime');
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('attendee1_id');
            $table->foreign('attendee1_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('attendee2_id');
            $table->foreign('attendee2_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('calendar_event_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
