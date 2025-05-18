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
        Schema::create('unit_features', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Unit::class)->nullable()->constrained()->cascadeOnDelete();
            $table->uuid('feature_id')->nullable();
            $table->foreign('feature_id')->references('id')->on('features')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_features');
    }
};
