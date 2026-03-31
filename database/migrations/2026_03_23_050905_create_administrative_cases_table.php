<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrative_cases', function (Blueprint $table) {
            $table->id();

            // 🔥 IMPORTANT RELATION
            $table->foreignId('report_id')
                  ->constrained('administrative_reports')
                  ->onDelete('cascade');

            $table->string('name')->nullable();
            $table->string('station')->nullable();
            $table->string('docket_no')->nullable();
            $table->text('nature')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrative_cases');
    }
};