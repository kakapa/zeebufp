<?php

use App\Enums\ClientStatusEnums;
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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique();
            $table->string('firstname', 60);
            $table->string('middlename', 60)->nullable();
            $table->string('title')->nullable(); // e.g. ClientTitleEnums::MR used here
            $table->string('lastname', 60);
            $table->string('email', 90)->unique()->nullable();
            $table->string('id_number', 13)->unique()->nullable(); // South African ID number
            $table->string('gender')->nullable(); // e.g. ClientGenderEnums::FEMALE used here
            $table->string('phone', 15)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('status')->default(ClientStatusEnums::ACTIVE); // Assuming status can be 'active', 'inactive', etc.
            $table->text('notes', 300)->nullable(); // Additional notes about the client
            $table->string('profile_picture')->nullable(); // URL or path to the client's profile picture
            $table->string('referral_source')->nullable(); // e.g. ClientSourceEnums::FRIEND used here
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
