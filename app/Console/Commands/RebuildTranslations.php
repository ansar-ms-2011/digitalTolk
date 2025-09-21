<?php

namespace App\Console\Commands;

use App\Models\TranslationValue;
use Illuminate\Console\Command;
use App\Services\TranslationCacheService;

class RebuildTranslations extends Command
{
    protected $signature = 'translations:rebuild {lang?}';
    protected $description = 'Rebuild translation JSON cache';

    public function handle(TranslationCacheService $service): void
    {
        $lang = $this->argument('lang');

        if ($lang) {
            $service->buildCache($lang);
            $this->info("Cache rebuilt for [$lang]");
        } else {
            $langs = TranslationValue::distinct()->pluck('language_code');
            foreach ($langs as $l) {
                $service->buildCache($l);
                $this->info("Cache rebuilt for [$l]");
            }
        }
    }
}
