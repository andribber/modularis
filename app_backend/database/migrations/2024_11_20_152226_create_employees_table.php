<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->primaryUlid('emp');
            $table->foreignPrefixedUlid('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreignPrefixedUlid('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('occupation');
            $table->string('salary');
            $table->string('registry');
            $table->jsonb('bank_account');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
