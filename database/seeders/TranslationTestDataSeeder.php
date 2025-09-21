<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TranslationKey;
use App\Models\TranslationValue;

class TranslationTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $languages = ['en', 'fr', 'es', 'de'];
        $tags = ['web', 'mobile', 'desktop'];

        // Generate 100,000 keys
        // Generate keys in chunks (e.g. 1k at a time)
        for($batch = 1; $batch <= 15; $batch++) {
            TranslationKey::factory()->count(1000)->create()->chunk(100)->each(function ($chunk) use ($languages, $tags) {
                $values = [];

                foreach ($chunk as $key) {
                    foreach ($languages as $lang) {
                        foreach ($tags as $tag) {
                            $values[] = [
                                'translation_key_id' => $key->id,
                                'language_code' => $lang,
                                'tag' => $tag,
                                'value' => fake()->sentence(3),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }
                }

                // Insert chunk immediately, then free memory
                TranslationValue::insert($values);
                unset($values);
            });
        }
    }
}
