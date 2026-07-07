<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'attempts')) {
                $table->integer('attempts')->default(0)->after('paid_at');
            }
            if (!Schema::hasColumn('payments', 'last_error')) {
                $table->text('last_error')->nullable()->after('attempts');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['attempts', 'last_error']);
        });
    }
};
