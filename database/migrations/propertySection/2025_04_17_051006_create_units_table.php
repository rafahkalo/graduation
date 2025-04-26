<?php

use App\Models\Category;
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
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->text('description2')->nullable();
            $table->text('main_image')->nullable();
            $table->integer('street_width')->default(0);
            $table->decimal('space', 20, 2)->default(0);
            $table->enum('equipment', ['furnished', 'unfurnished'])->default('furnished');
            $table->enum('property_type', ['commercial_and_residential', 'commercial', 'residential'])->default('commercial_and_residential');

            $table->integer('floor')->default(0);
            $table->integer('property_age')->default(0);

            $table->enum('status', ['active', 'inactive', 'wait', 'refuse'])->default('wait');
            $table->enum('reservation_type', ['monthly', 'yearly']);
            $table->integer('deposit')->default(0);
            $table->enum('reservation_status', ['busy', 'reserved', 'available', 'maintenance'])->default('available');
            $table->enum('accept_by_admin', ['accepted', 'refused', 'wait'])->default('wait');
            $table->text('message_of_admin')->nullable();
            $table->text('house_rules')->nullable();
            $table->integer('views')->default(0);
            $table->decimal('price', 20, 2)->default(0);
            $table->uuid('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->cascadeOnDelete();

            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->foreignIdFor(Category::class)
                ->nullable()
                ->constrained()
                ->onDelete('no action');

            $table->json('rating_details')->nullable();
            $table->json('translation')->nullable();
            $table->string('guard_name')->nullable();
            $table->string('guard_phone')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
