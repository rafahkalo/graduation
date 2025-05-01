<?php

use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('num_usage')->default(0);
            $table->integer('remaining_usage')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type_offer', ['fixed', 'percent'])->default('fixed');
            $table->integer('value_offer')->default(0);
            $table->date('from');
            $table->date('to');
            $table->foreignIdFor(Unit::class)->nullable()->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
