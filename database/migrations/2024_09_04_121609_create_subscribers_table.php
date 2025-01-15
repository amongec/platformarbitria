<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();

            $table->string('email')->index();
            $table->boolean('is_subscribed')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        $query = "CREATE TRIGGER update_is_active BEFORE UPDATE ON subscribers
    FOR EACH ROW
    BEGIN
        IF NEW.is_subscribed = 0 THEN
            SET NEW.is_active = 0;
        END IF;
    END;
";

        DB::connection()->getPdo()->exec($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};
