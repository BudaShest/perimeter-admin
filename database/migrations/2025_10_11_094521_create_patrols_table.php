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
        // Создаем enum типы, если они еще не существуют
        DB::statement("DO $$ BEGIN
            CREATE TYPE patrol_status AS ENUM ('planned', 'in_progress', 'completed', 'cancelled');
        EXCEPTION
            WHEN duplicate_object THEN null;
        END $$;");

        DB::statement("DO $$ BEGIN
            CREATE TYPE patrol_type AS ENUM ('regular', 'special', 'emergency');
        EXCEPTION
            WHEN duplicate_object THEN null;
        END $$;");

        Schema::create('patrols', function (Blueprint $table) {
            $table->id(); // bigserial primary key (вместо patrol_id)
            $table->text('name');
            $table->timestampTz('start_ts');
            $table->timestampTz('end_ts');
            $table->string('status'); // Будем использовать string, но с check constraint
            $table->string('kind'); // Будем использовать string, но с check constraint
            $table->date('date_only');
            $table->foreignId('area_id')->constrained()->onDelete('cascade');
            $table->foreignId('route_version_id')->constrained()->nullable();
            $table->timestamps(); // Добавляем created_at и updated_at

            // Индексы для улучшения производительности
            $table->index('area_id');
            $table->index('route_version_id');
            $table->index('date_only');
            $table->index('status');
            $table->index('kind');
        });

        // Добавляем check constraints для status и kind
        DB::statement('ALTER TABLE patrols ADD CONSTRAINT patrols_status_check CHECK (status IN (\'planned\', \'in_progress\', \'completed\', \'cancelled\'))');
        DB::statement('ALTER TABLE patrols ADD CONSTRAINT patrols_kind_check CHECK (kind IN (\'regular\', \'special\', \'emergency\'))');

        // Проверяем, что end_ts > start_ts
        DB::statement('ALTER TABLE patrols ADD CONSTRAINT patrols_time_check CHECK (end_ts > start_ts)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrols');

        // Удаляем enum типы (осторожно - может использоваться другими таблицами)
        // DB::statement('DROP TYPE IF EXISTS patrol_status');
        // DB::statement('DROP TYPE IF EXISTS patrol_type');
    }
};
