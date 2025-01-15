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
        Schema::create('nets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('email')->nullable();
            $table->string('name', 150)->unique()->required;
            $table->string('city', 300);
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('type_id');
            $table->string('role_id');
           // $table->string('password');
            $table->unsignedMediumInteger('zipcode')->nullable()->length(5);
  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nets');
    }
};
