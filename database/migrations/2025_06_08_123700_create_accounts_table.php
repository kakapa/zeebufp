<?php

use App\Enums\AccountStatusEnums;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('slug')->unique(); // Account ID in frontend
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedInteger('payday')->default(1);
            $table->string('status')->default(AccountStatusEnums::PENDING);
            $table->decimal('total_coverage_amount')->default(0);
            $table->date('last_payment_at')->nullable();
            $table->date('next_payment_at')->nullable();
            $table->text('notes', 300)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};