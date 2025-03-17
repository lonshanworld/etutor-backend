<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('major_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id');
            $table->foreignId('subject_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('major_subject');
    }
};
