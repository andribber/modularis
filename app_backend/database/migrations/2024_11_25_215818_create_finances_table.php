<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->primaryUlid('fin');
            $table->foreignPrefixedUlid('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignPrefixedUlid('operator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignPrefixedUlid('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('description');
            $table->string('amount');
            $table->string('type');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
