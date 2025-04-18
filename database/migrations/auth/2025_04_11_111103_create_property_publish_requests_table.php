<?php

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
        Schema::create('property_publish_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignUuid('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->text('reason')->nullable(); // سبب الرفض إذا تم الرفض
            $table->text('notes')->nullable();  // ملاحظات المؤجّر
            $table->enum('property_type', ['apartment', 'villa', 'house', 'land', 'commercial', 'other']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_publish_requests');
    }
};
