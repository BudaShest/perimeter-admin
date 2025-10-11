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
        // Создаем enum тип для pass_status
        DB::statement("DO $$ BEGIN
            CREATE TYPE pass_status AS ENUM ('сканирована', 'пропущена');
        EXCEPTION
            WHEN duplicate_object THEN null;
        END $$;");

        Schema::create('point_passes', function (Blueprint $table) {
            $table->id(); // bigserial primary key (вместо pass_id)
            $table->foreignId('patrol_id')->constrained()->onDelete('cascade');
            $table->foreignId('point_id')->constrained()->onDelete('cascade');
            $table->timestampTz('scanned_at')->nullable();
            $table->string('status'); // Будем использовать string с check constraint
            $table->text('comment')->nullable();
            $table->foreignId('phone_id')->constrained()->nullable();
            $table->double('gps_lat')->nullable();
            $table->double('gps_lon')->nullable();
            $table->double('gps_accuracy')->nullable();
            $table->text('signature_hash')->nullable();
            $table->timestamps(); // Добавляем created_at и updated_at

            // Уникальный constraint для patrol_id и point_id
            $table->unique(['patrol_id', 'point_id']);

            // Индексы для улучшения производительности
            $table->index('patrol_id');
            $table->index('point_id');
            $table->index('phone_id');
            $table->index('status');
            $table->index('scanned_at');
        });

        // Добавляем check constraint для status
        DB::statement('ALTER TABLE point_passes ADD CONSTRAINT point_passes_status_check CHECK (status IN (\'сканирована\', \'пропущена\'))');

        DB::statement('ALTER TABLE point_passes ADD CONSTRAINT scanned_if_scanned CHECK (((status = \'сканирована\'::text) AND (scanned_at IS NOT NULL)) OR (status = \'пропущена\'::text))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_passes');

        // Удаляем enum тип (осторожно - может использоваться другими таблицами)
        // DB::statement('DROP TYPE IF EXISTS pass_status');
    }
};
