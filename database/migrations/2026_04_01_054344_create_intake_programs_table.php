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
                $table->foreignId('intake_id')->constrained('intakes')->cascadeOnDelete();
                // programs.id is a uuid (managed by TypeORM on Supabase)
                $table->uuid('program_id');
                $table->foreign('program_id')->references('id')->on('programs')->cascadeOnDelete();
                $table->unsignedInteger('required_subject_count')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->unique(['intake_id', 'program_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('intake_programs');
    }
};