<?php

namespace Database\Factories;

use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationKeyFactory extends Factory
{
    protected $model = TranslationKey::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug,   // e.g. "welcome_message"
            'namespace' => $this->faker->randomElement(
                [
                    'auth',
                    'dashboard',
                    'profile',
                    'system',
                    'settings',
                    'login',
                    'register',
                    'forgot_password',
                    'reset_password',
                    'verify_email'
                ]
            ),
        ];
    }

    public function configure(): TranslationKeyFactory
    {
        return $this->afterCreating(function (TranslationKey $translation) {
            TranslationValue::factory()->create(['translation_key_id' => $translation->id]);
        });
    }
}
