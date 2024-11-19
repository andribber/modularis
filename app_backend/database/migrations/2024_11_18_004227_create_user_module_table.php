<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_user', function (Blueprint $table) {
            $table->primaryUlid('usrmd');
            $table->foreignUlid('user_id', 35)->references('id')->on('users');
            $table->foreignUlid('module_id', 35)->references('id')->on('modules');
            $table->string('role');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_user');
    }
};
