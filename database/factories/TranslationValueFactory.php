<?php

namespace Database\Factories;

use App\Models\TranslationValue;
use App\Models\TranslationKey;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationValueFactory extends Factory
{
    protected $model = TranslationValue::class;

    public function definition(): array
    {
        return [
            'translation_key_id' => TranslationKey::factory(),
            'language_code' => $this->faker->randomElement(['en', 'fr', 'es', 'de']),
            'tag' => $this->faker->randomElement(['web', 'mobile', 'desktop']),
            'value' => $this->faker->sentence(3),
        ];
    }
}
