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
            $table->id();
            $table->string('slug')->unique();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('title')->nullable(); // e.g. ClientTitleEnums::MR used here
            $table->string('surname');
            $table->string('email')->unique()->nullable();
            $table->string('id_number')->unique()->nullable(); // South African ID number
            $table->string('gender')->nullable(); // e.g. ClientGenderEnums::FEMALE used here
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default(ClientStatusEnums::ACTIVE); // Assuming status can be 'active', 'inactive', etc.
            $table->string('notes')->nullable(); // Additional notes about the client
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
