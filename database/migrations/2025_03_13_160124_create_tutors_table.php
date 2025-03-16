<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('subject_id');
            $table->foreignId('created_by');
            $table->foreignId('deleted_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->string('qualifications');
            $table->integer('experience');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};
