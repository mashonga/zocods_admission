<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('nationality')->nullable();
            $table->string('occupation')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('exam_board')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'nationality',
                'occupation',
                'sponsor',
                'exam_board',
            ]);
        });
    }
};