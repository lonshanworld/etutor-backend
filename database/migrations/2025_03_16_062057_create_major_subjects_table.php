<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
<<<<<<<< HEAD:database/migrations/2025_03_06_154956_create_major_subjects_table.php
        Schema::create('major_subjects', function (Blueprint $table) {
========
        Schema::create('major_subject', function (Blueprint $table) {
>>>>>>>> hak-dev:database/migrations/2025_03_16_062057_create_major_subjects_table.php
            $table->id();
            $table->foreignId('major_id');
            $table->foreignId('subject_id');
<<<<<<<< HEAD:database/migrations/2025_03_06_154956_create_major_subjects_table.php
========
            $table->timestamps();
>>>>>>>> hak-dev:database/migrations/2025_03_16_062057_create_major_subjects_table.php
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('major_subject');
    }
};
