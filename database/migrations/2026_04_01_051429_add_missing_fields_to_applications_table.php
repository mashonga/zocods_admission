<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {

            $table->string('marital_status')->nullable()->after('gender');
            $table->string('district')->nullable()->after('nationality');

            $table->string('sponsor_phone')->nullable()->after('sponsor');
            $table->string('employer')->nullable()->after('occupation');

            $table->text('postal_address')->nullable()->after('address');

            // extra qualifications
            $table->text('other_qualifications')->nullable()->after('highest_qualification');

            // declaration checkbox
            $table->boolean('agreed')->default(false)->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'marital_status',
                'district',
                'sponsor_phone',
                'employer',
                'postal_address',
                'other_qualifications',
                'agreed',
            ]);
        });
    }
};