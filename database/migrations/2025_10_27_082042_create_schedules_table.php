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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Название расписания (например, "Утренний обход")
            $table->json('days_of_week'); // Дни недели [1,2,3,4,5,6,7] где 1-понедельник, 7-воскресенье
            $table->time('start_time'); // Время начала
            $table->time('end_time'); // Время окончания
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('route_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
