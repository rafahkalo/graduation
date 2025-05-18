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
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('model_type')->nullable();
            $table->string('model_id')->nullable();
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            // معلومات الملف
            $table->string('filename'); // اسم الملف المخزن (hash)
            $table->string('original_name'); // الاسم الأصلي
            $table->string('mime_type');
            $table->unsignedInteger('size');
            $table->string('storage_path');
            $table->string('disk');
            $table->string('extension');
            $table->string('hash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
