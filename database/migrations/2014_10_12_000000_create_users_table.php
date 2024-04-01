<?php

use App\Models\User;
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
            $table->id();
            $table->string('user_name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('phone_number', 11);
            $table->tinyInteger('gender')->nullable()->comment('0: Male; 1: Female; 2: Other');
            $table->tinyInteger('role')->default(User::ROLE_USER);
            $table->tinyInteger('status')->default(User::INACTIVATED);
            $table->rememberToken();
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
