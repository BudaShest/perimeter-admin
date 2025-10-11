<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('route_version_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_version_id')->constrained()->onDelete('cascade');
            $table->foreignId('point_id')->constrained()->onDelete('cascade');
            $table->integer('step_order');

            // Уникальный constraint для route_version_id и point_id
            $table->unique(['route_version_id', 'point_id']);

            // Уникальный индекс для route_version_id и step_order
            $table->unique(['route_version_id', 'step_order']);

            // Индексы для улучшения производительности
            $table->index('route_version_id');
            $table->index('point_id');
            $table->index('step_order');

            $table->timestamps(); // Добавляем created_at и updated_at
        });

        // Добавляем check constraint через raw SQL
        DB::statement('ALTER TABLE route_version_points ADD CONSTRAINT route_version_points_step_order_check CHECK (step_order > 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_version_points');
    }
};
