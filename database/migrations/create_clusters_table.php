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
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('city');
            $table->string('district')->nullable();
            $table->string('country');
            $table->unsignedMediumInteger('zipcode')->nullable()->length(5);
            //$table->foreignId('category_id');
            $table->string('slug')->unique();
            $table->string('title')->unique();
            //$table->string('thumbnail')->nullable();
            $table->string('excerpt', 150)->nullable();
            $table->string('body')->nullable();
            $table->boolean('status')->nullable();
            $table->unsignedInteger('likes')->default(0);
            //$table->timestamp('updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
