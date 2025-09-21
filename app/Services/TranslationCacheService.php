<?php

namespace App\Services;

use App\Models\TranslationKey;
use App\Models\TranslationsCache;
use Illuminate\Support\Facades\DB;

class TranslationCacheService
{
    public function buildCache(string $lang): void
    {
        // Make sure a row exists
        $cache = TranslationsCache::firstOrCreate(['language_code' => $lang], [
            'content' => [],
        ]);
        $cache->content = [];
        $cache->save();

        TranslationKey::with([
            'values' => function ($q) use ($lang) {
                $q->where('language_code', $lang);
            }
        ])->chunk(1000, function ($keys) use ($lang) {
            $partialJson = [];

            foreach ($keys as $key) {
                $namespace = $key->namespace ?? 'default';

                foreach ($key->values as $val) {
                    $tag = $val->tag ?? 'default';
                    $partialJson[$namespace][$key->key][$tag] = $val->value;
                }
            }

            DB::table('translations_cache')
                ->where('language_code', $lang)
                ->update([
                    'content' => DB::raw("JSON_MERGE_PATCH(content, '" . json_encode($partialJson) . "')"),
                    'last_generated_at' => now(),
                ]);
        });
    }
}
