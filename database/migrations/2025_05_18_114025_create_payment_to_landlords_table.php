<?php

use App\Models\Admin;
use App\Models\Bank;
use App\Models\FinancialTransaction;
use App\Models\User;
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
        Schema::create('payment_to_landlords', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Admin::class)->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(User::class)->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(FinancialTransaction::class)->nullable()
                ->constrained()
                ->onDelete('no action');


            $table->foreignIdFor(Bank::class)->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->enum('type_transfer', ['bank'])->default('bank');
            $table->boolean('approved_by_user')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_to_landlords');
    }
};
