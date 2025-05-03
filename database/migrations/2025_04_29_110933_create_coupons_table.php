<?php

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
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percent'])->default('fixed');
            $table->unsignedInteger('value');
            $table->unsignedInteger('max_uses')->nullable();
            $table->unsignedInteger('current_uses')->default(0);
            $table->unsignedInteger('max_uses_per_user')->nullable();
            $table->date('starts_at');
            $table->date('expires_at');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->text('description')->nullable();
            $table->unsignedInteger('minimum_reservation_amount')->nullable();
            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');
            $table->unique(['user_id', 'code']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
