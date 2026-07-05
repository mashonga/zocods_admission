<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('intake_programs')) {
            Schema::create('intake_programs', function (Blueprint $table) {
                $table->id();
                $table->uuid('intake_id');
                $table->uuid('program_id');
                $table->timestamps();

                $table->foreign('intake_id')
                      ->references('id')
                      ->on('intakes')
                      ->cascadeOnDelete();
                      
                $table->foreign('program_id')
                      ->references('id')
                      ->on('programs')
                      ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_programs');
    }
};
