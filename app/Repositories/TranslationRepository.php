<?php

namespace App\Repositories;

use App\Models\TranslationKey;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class TranslationRepository
{
    public function getTranslations(
        ?array $keys = null,
        ?array $tags = null,
        string $content = null,
        int $perPage = 50
    ): array|LengthAwarePaginator {
        $queryBuilder = TranslationKey::with([
            'values' => function ($q) use ($tags, $content) {
                if ($tags) {
                    $q->whereIn('tag', $tags);
                }
                if ($content) {
                    $q->where('value', 'like', '%' . $content . '%');
                }
            }
        ]);

        if ($keys) {
            $queryBuilder->whereIn('key', $keys);
        }

        return $perPage > 0 ? $queryBuilder->paginate($perPage) : $queryBuilder->get();
    }

    /**
     * @throws Throwable
     */
    public function saveTranslation(array $data): TranslationKey
    {
        return DB::transaction(function () use ($data) {
            $translation = TranslationKey::create(['key' => $data['key'], 'namespace' => $data['namespace']]);
            foreach ($data['values'] as $value) {
                $translation->values()->create([
                    'translation_key_id' => $translation->id,
                    'language_code' => $value['language_code'],
                    'value' => $value['value'],
                    'tag' => $value['tag']
                ]);
            }
            return $translation;
        });
    }

    /**
     * @throws Throwable
     */
    public function updateTranslation(TranslationKey $translationKey, array $data): TranslationKey
    {
        return DB::transaction(function () use ($translationKey, $data) {
            $translationKey->update([
                'namespace' => $data['namespace']
            ]);
            $translationKey->values()->delete();
            foreach ($data['values'] as $value) {
                $translationKey->values()->create([
                    'translation_key_id' => $translationKey->id,
                    'language_code' => $value['language_code'],
                    'value' => $value['value'],
                    'tag' => $value['tag']
                ]);
            }
            return $translationKey;
        });
    }

    /**
     * @throws Throwable
     */
    public function deleteTranslation(string $key)
    {
        return DB::transaction(function () use ($key) {
            $translation = TranslationKey::where(['key' => $key])->firstOrFail();
            $translation->values()->delete();
            $translation->delete();
            return true;
        });
    }
}
