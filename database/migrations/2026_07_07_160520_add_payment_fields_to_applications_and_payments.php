<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('status');
            }
            if (!Schema::hasColumn('applications', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('payment_status');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'attempts')) {
                $table->integer('attempts')->default(0)->after('paid_at');
            }
            if (!Schema::hasColumn('payments', 'last_error')) {
                $table->text('last_error')->nullable()->after('attempts');
            }
            $table->index(['application_id', 'status']);
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'submitted_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['attempts', 'last_error']);
            $table->dropIndex(['application_id', 'status']);
            $table->dropIndex(['reference']);
        });
    }
};
