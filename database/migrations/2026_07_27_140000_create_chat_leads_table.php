<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_leads', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('session_token', 64);
            $table->timestamp('escalated_at')->nullable();
            $table->timestamps();

            $table->index('session_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_leads');
    }
};
