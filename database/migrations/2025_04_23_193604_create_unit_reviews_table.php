<?php

use App\Models\Reservation;
use App\Models\Tenant;
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
        Schema::create('unit_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(Unit::class)->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(Tenant::class)->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(Reservation::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->text('reason')->nullable();
            $table->decimal('rating', 3, 1);
            $table->decimal('cleanliness', 3, 1)->default(0);
            $table->decimal('accuracy', 3, 1)->default(0);
            $table->decimal('check_in', 3, 1)->default(0);
            $table->decimal('communication', 3, 1)->default(0);
            $table->decimal('value', 3, 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_reviews');
    }
};
