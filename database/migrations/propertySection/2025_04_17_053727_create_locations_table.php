<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('lng')->nullable();
            $table->string('lat')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->uuid('model_id');
            $table->string('model_type');
            $table->uuid('direction_id')->nullable();
            $table->json('translation')->nullable();
            $table->foreign('direction_id')->references('id')->on('directions')->nullable()->constrained()
                ->restrictOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
