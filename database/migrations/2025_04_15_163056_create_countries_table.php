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
        Schema::create('countries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // اسم الدولة
            $table->string('code', 3)->nullable(); // رمز الدولة (ISO 3166-1 alpha-2 or alpha-3)
            $table->string('phone_code')->nullable(); // رمز الاتصال الدولي
            $table->json('translation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
