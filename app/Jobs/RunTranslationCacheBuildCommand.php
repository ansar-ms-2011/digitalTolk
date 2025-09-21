<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Artisan;

class RunTranslationCacheBuildCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $lang;

    public function __construct(?string $lang = null)
    {
        $this->lang = $lang;
    }

    public function handle(): void
    {
        // Run your artisan command in the background
        Artisan::call('translations:rebuild', [
            'lang' => $this->lang,
        ]);
    }
}
