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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->date('birthdate');
            $table->enum('show_as_gender', ['female', 'male']);
            $table->string('gender')->nullable();
            $table->string('sexual_orientation')->nullable();
            $table->enum('target_gender', ['female', 'male', 'all']);
            $table->integer('max_distance')->nullable();
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();

            $table->longText('description_disability')->nullable();





            $table->boolean('active')->default(true);
            $table->boolean('isAdmin')->default(false);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
