<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

return new class extends Migration
{
    public function up(){
        Schema::create('products', function (Blueprint $table){
            $table->id();
        //  $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 5,2);
            $table->text('door')->nullable();
            $table->text('select')->nullable();
            $table->text('test')->nullable();
            $table->text('cloud')->nullable();
            $table->text('chatTeam')->nullable();
            $table->text('customTeapot')->nullable();
            $table->text('delivery')->nullable();
            $table->text('platform')->nullable();

            $table->timestamps();
        });
    }
};