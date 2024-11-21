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
            $table->foreignPrefixedUlid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignPrefixedUlid('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->string('role');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_user');
    }
};
