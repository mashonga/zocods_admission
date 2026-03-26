<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('program');
            $table->text('address')->nullable();
            $table->string('highest_qualification')->nullable();
            $table->string('previous_school')->nullable();
            $table->string('certificate_file')->nullable();
            $table->string('id_file')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('Submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
