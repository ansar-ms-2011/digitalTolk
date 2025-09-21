<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up(): void {
        Schema::create('translation_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_key_id')->constrained('translation_keys')->onDelete('cascade');
            $table->string('language_code', 5);
            $table->string('tag', 50)->nullable(); // e.g. web, mobile, desktop
            $table->text('value');
            $table->timestamps();
            $table->unique(['translation_key_id', 'language_code', 'tag'], 'unique_key_lang_tag');

            $table->index(['language_code', 'tag']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('translation_values');
    }
};
