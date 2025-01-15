<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("category_id");
            $table->foreign("user_id")->references('id')->on('users')->onDelete('set null');
            $table->string("slug")->unique();
            $table->string("name", 80)->unique();
            $table->text("excerpt", 150)->nullable();
            $table->longText("body")->nullable();
            $table->tinyInteger("status")->default('1')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("posts");
    }
};
