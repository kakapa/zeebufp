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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type'); // ENUM
            $table->string('status'); // ENUM
            $table->string('path');
            $table->decimal('size', 13, 2);
            $table->string('mime');
            $table->integer('views')->default(0);
            $table->timestamps();

            // Polymorphic relationship columns
            $table->uuid('documentable_id')->nullable();
            $table->string('documentable_type')->nullable();

            // Index for better performance
            $table->index(['documentable_id', 'documentable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};