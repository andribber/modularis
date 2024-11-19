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
            $table->foreignUlid('tenant_id', 35)->references('id')->on('tenants');
            $table->foreignUlid('module_id', 35)->references('id')->on('modules');
            $table->timestamp('expires_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_tenant');
    }
};
