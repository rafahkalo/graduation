<?php

use App\Models\Reservation;
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
        //المستحقات المالية
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Reservation::class)->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->decimal('lessor_amount', 10, 2)->default(0); // المبلغ الذي سوف سيتلمه المؤجر
            $table->decimal('lessor_commission_amount', 10, 2)->default(0); //مبلغ عمولة المؤجر
            $table->decimal('tenant_commission_amount', 10, 2)->default(0); //مبلغ عمولة المستأجر
            $table->decimal('tenant_amount', 10, 2)->default(0); // المبلغ الذي سوف يدفعه المستأجر
            $table->decimal('platform_commission_amount', 10, 2)->default(0); //مبلغ عمولة المنصة من المؤجر والمستأجر
            $table->enum('status',  ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
