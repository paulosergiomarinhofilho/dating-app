<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_crashes', function (Blueprint $table) {
            $table->uuid('id')->nullable()->primary();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('os', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->longText('message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_crashes');
    }
};
