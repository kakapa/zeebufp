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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('account_id');
            $table->string('firstname', 60);
            $table->string('middlename', 60)->nullable();
            $table->string('lastname', 60);
            $table->string('id_number', 13)->unique()->nullable(); // South African ID number
            $table->string('gender')->nullable(); // e.g. ClientGenderEnums::FEMALE used here
            $table->string('phone', 15)->nullable();
            $table->string('relationship')->nullable();  // e.g. BeneficiaryRelationshipEnums::SON used here
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
