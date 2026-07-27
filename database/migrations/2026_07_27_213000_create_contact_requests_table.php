<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 60);
            $table->string('service', 80);
            $table->text('message');
            $table->string('status', 20)->default('new');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};
