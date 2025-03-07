<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('action');
            $table->foreignId('entity_id');
            $table->foreignId('web_page_id');
            $table->foreignId('web_browser_id');
            $table->integer('visit_count');
            $table->ipAddress('ip_address');
            $table->string('user_agents');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
