<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorized_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->foreignId('deleted_by')->nullable();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('access_level')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorized_staff');
    }
};
