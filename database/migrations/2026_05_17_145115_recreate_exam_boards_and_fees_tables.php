<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('exam_boards')) {
            Schema::create('exam_boards', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('code')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('board_fees')) {
            Schema::create('board_fees', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('exam_board_id');
                $table->string('fee_name')->default('Examination Fee');
                $table->decimal('amount', 12, 2);
                $table->string('currency', 10)->default('MWK');
                $table->timestamps();

                $table->foreign('exam_board_id')->references('id')->on('exam_boards')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('board_fees');
        Schema::dropIfExists('exam_boards');
    }
};
