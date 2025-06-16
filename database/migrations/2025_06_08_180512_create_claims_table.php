<?php

use App\Enums\ClaimStatusEnums;
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
        Schema::create('claims', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Claim Officer
            $table->string('slug')->unique();
            $table->decimal('amount')->default(0);
            $table->string('status')->default(ClaimStatusEnums::PENDING);
            $table->string('type'); // ENUM
            $table->text('description')->nullable();
            $table->date('submission_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};