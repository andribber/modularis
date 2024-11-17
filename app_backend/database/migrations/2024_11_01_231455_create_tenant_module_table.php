<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_module', function (Blueprint $table) {
            $table->primaryUlid('tenmd');
            $table->foreignUlid('tenant_id')->references('id')->on('tenants');
            $table->foreignUlid('module_id')->references('id')->on('modules');
            $table->timestamp('expires_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_module');
    }
};
