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
        Schema::create('packages', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->text('description');
            $table->decimal('contribution', 10, 2);
            $table->decimal('coverage', 10, 2);
            $table->text('features');
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->boolean('main')->default(false); // Indicates main package
            $table->boolean('popular')->default(false); // Indicates recommended package
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
