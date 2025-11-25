<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('refresh_tokens', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('token_hash');
    $table->timestamp('expires_at');
    $table->timestamp('revoked_at')->nullable();
    $table->string('user_agent')->nullable();
    $table->string('ip')->nullable();
    $table->timestamps();
});
