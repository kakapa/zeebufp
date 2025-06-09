<?php

use App\Enums\PaymentMethodEnums;
use App\Enums\PaymentStatusEnums;
use App\Enums\PaymentTypeEnums;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('slug')->unique();  // Payment ID in frontend
            $table->uuid('account_id')->nullable();
            $table->uuid('claim_id')->nullable();
            $table->decimal('amount', 13, 2);
            $table->date('pay_at')->nullable();
            $table->string('status')->default(PaymentStatusEnums::PENDING);
            $table->string('type')->default(PaymentTypeEnums::CONTRIBUTION);
            $table->string('method')->default(PaymentMethodEnums::EFT);
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};