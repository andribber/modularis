<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->primaryUlid('tea');
            $table->foreignPrefixedUlid('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignPrefixedUlid('leader_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('name');
            $table->string('description');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
