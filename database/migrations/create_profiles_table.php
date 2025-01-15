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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->string('user_name', 45);
     
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();

                    $table->integer('banned_by')->unsigned()->nullable();
                    $table->foreign('banned_by')->references('id')->on('users');
                    $table->timestamp('banned_at')->nullable();
                       
                    
                        $table->string('phone_number');
                        $table->string('country_code');
                        $table->string('authy_id')->nullable();
                        $table->boolean('verified')->default(false);

                        $table->string('address');
                        $table->string('district')->nullable();
                        $table->string('country');
                        $table->string('zipcode');

            $table->string('billing_zipcode', 150)->nullable();
            $table->string('billing_city', 150)->nullable();
            $table->string('billing_country', 150)->nullable();
            $table->string('payment_id')->nullable();
   
            $table->unsignedBigInteger('user_id')->unique(); 
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
