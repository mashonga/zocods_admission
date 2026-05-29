<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intake_programs', function (Blueprint $table) {
            $table->text('tuition_fee_notes')->nullable()->after('required_subject_count');
        });
    }

    public function down(): void
    {
        Schema::table('intake_programs', function (Blueprint $table) {
            $table->dropColumn('tuition_fee_notes');
        });
    }
};