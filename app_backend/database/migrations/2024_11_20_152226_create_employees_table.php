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
            $table->foreignUlid('tenant_id', 35)->references('id')->on('tenants');
            $table->foreignUlid('user_id', 35)->nullable()->references('id')->on('users');
            $table->string('name');
            $table->string('email');
            $table->string('occupation');
            $table->string('salary');
            $table->string('area'); //teams feature
            $table->string('registry');
            $table->jsonb('bank_account');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
