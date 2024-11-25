<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_team', function (Blueprint $table) {
            $table->primaryUlid('eteam');
            $table->foreignPrefixedUlid('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreignPrefixedUlid('team_id')->references('id')->on('teams')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_team');
    }
};
