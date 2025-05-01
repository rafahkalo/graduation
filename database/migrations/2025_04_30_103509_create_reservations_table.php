<?php

use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('reservation_source', ['app', 'reception'])->nullable();
            $table->enum('status', ['cancel', 'accept', 'pending', 'payment_pending'])->default('pending');
            $table->date('from')->nullable();
            $table->date('to')->nullable();

            $table->decimal('lessor_commission', 10, 3)->default(0); //عمولة المؤجر
            $table->decimal('lessor_commission_amount', 10, 2)->default(0); //مبلغ عمولة المؤجر
            $table->decimal('lessor_amount', 10, 2)->default(0); // المبلغ الذي سوف سيتلمه المؤجر

            $table->decimal('tenant_commission', 10, 3)->default(0); //عمولة المستأجر
            $table->decimal('tenant_commission_amount', 10, 2)->default(0); //مبلغ عمولة المستأجر
            $table->decimal('tenant_amount', 10, 2)->default(0); // المبلغ الذي سوف يدفعه المستأجر

            $table->decimal('platform_commission_amount', 10, 2)->default(0); //مبلغ عمولة المنصة من المؤجر والمستأجر
            $table->decimal('coupon_amount', 10, 3)->default(0);

            $table->foreignIdFor(Coupon::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->decimal('offer_amount', 10, 3)->default(0);

            $table->foreignIdFor(Offer::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(Unit::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(Tenant::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
