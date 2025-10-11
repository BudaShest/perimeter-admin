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
        Schema::create('area_points', function (Blueprint $table) {
            $table->id(); // bigserial primary key
            $table->foreignId('area_id')->constrained()->onDelete('cascade');
            $table->foreignId('point_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Добавляем created_at и updated_at

            // Уникальный constraint для area_id и point_id
            $table->unique(['area_id', 'point_id']);

            // Индексы для улучшения производительности
            $table->index('area_id');
            $table->index('point_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_points');
    }
};
