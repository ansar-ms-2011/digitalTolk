<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void {
        Schema::create('translations_cache', function (Blueprint $table) {
            $table->id();
            $table->string('language_code', 5)->unique();
            $table->json('content');
            $table->timestamp('last_generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('translations_cache');
    }
};
