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
            $table->ulid('id')->primary();
            $table->string('slug')->unique(); // Account ID in frontend
            $table->ulid('client_id');
            $table->unsignedInteger('payday')->default(1);
            $table->string('status')->default(AccountStatusEnums::PENDING);
            $table->decimal('total_contribution_amount')->default(0);
            $table->decimal('total_coverage_amount')->default(0);
            $table->date('last_payment_at')->nullable();
            $table->date('next_payment_at')->nullable();
            $table->text('notes', 300)->nullable();
            $table->timestamps();
        });

        Schema::create('account_package', function (Blueprint $table) {
            $table->ulid('account_id');
            $table->ulid('package_id');

            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('package_id')->references('id')->on('packages')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_package');
        Schema::dropIfExists('accounts');
    }
};
