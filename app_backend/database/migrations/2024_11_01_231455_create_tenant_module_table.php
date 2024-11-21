<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_tenant', function (Blueprint $table) {
            $table->primaryUlid('tenmd');
            $table->foreignPrefixedUlid('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignPrefixedUlid('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->timestamp('expires_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_tenant');
    }
};
