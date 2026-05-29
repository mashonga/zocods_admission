<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->text('introduction')->nullable()->after('duration');
            $table->text('entry_requirements')->nullable()->after('introduction');
            $table->text('mode_of_delivery')->nullable()->after('entry_requirements');
            $table->text('duration_details')->nullable()->after('mode_of_delivery');
            $table->text('module_summary')->nullable()->after('duration_details');
            $table->text('qualification_levels')->nullable()->after('module_summary');
            $table->text('assessment_details')->nullable()->after('qualification_levels');
            $table->text('grading_system')->nullable()->after('assessment_details');
            $table->text('progression_details')->nullable()->after('grading_system');
            $table->text('field_practicals')->nullable()->after('progression_details');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn([
                'introduction',
                'entry_requirements',
                'mode_of_delivery',
                'duration_details',
                'module_summary',
                'qualification_levels',
                'assessment_details',
                'grading_system',
                'progression_details',
                'field_practicals',
            ]);
        });
    }
};