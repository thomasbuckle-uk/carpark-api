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
        Schema::create('carpark', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_spaces');
            $table->timestamps();
        });

        Schema::create('pricing_calendar', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Carpark::class);
            $table->string('season');
            $table->string('day_type');
            $table->double('price_per_day');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_calendar');
        Schema::dropIfExists('carpark');
    }
};
