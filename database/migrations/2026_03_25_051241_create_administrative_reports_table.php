<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrative_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_title');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administrative_reports');
    }
};