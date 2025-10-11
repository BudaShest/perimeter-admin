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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->integer('paid_days')->check('paid_days >= 0');
            $table->integer('point_limit')->check('point_limit >= 0');
            $table->timestampsTz();
        });


        DB::statement('ALTER TABLE areas ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE areas ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
