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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile_select_service')->nullable();
            $table->string('address_select_service', 500);
            $table->unsignedMediumInteger('zipcode_select_service')->length(5);
            $table->string('city_select_service', 300);
            $table->string('district_select_service', 300)->nullable();
            $table->string('country_select_service', 300);
            $table->date('scheduled_date');
            $table->string('scheduled_time');
            $table->string('type_id');
            $table->string('status')->default('reserved');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
