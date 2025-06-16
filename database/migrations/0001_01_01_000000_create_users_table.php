<?php

use App\Enums\UserStatusEnums;
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
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('country_id')->default(1); // South Africa (1)
            $table->unsignedBigInteger('role_id')->default(2); // Visitor (1)
            $table->string('fullnames');
            $table->char('initials', 3);
            $table->string('surname');
            $table->string('mobile_number', 10)->unique();
            $table->string('pin', 5)->nullable();
            $table->string('email')->nullable();
            $table->string('id_number')->nullable();
            $table->string('status')->nullable()->default(UserStatusEnums::ACTIVE); //ENUM:
            $table->string('gender')->nullable(); //ENUM:
            $table->string('marital_status')->nullable(); //ENUM:
            $table->string('work_status')->nullable(); //ENUM:
            $table->unsignedBigInteger('occupation_id')->nullable();
            $table->string('home_address')->nullable();
            //$table->string('home_phone_number', 10)->nullable();
            $table->string('education_level')->nullable(); //ENUM:
            $table->boolean('disability')->default(false);
            $table->text('about')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->timestamp('profiled_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};