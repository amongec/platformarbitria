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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            $table->string('user_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('type_service', 255)->nullable();
            $table->date('date_reserva', 100)->nullable();
            $table->text('time_reserva')->nullable();
            $table->text('title', 100)->nullable();
            $table->date('start', 100)->nullable();
            $table->date('end', 100)->nullable();
            $table->string('color', 50)->nullable();

            $table->timestamps();
             });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
