<?php

namespace App\Models;

use App\Jobs\RunTranslationCacheBuildCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TranslationKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'namespace',
    ];

    public function values(): HasMany|TranslationKey
    {
        return $this->hasMany(TranslationValue::class);
    }


    protected static function booted(): void
    {
        static::created(function ($model) {
            $langs = TranslationValue::distinct()->pluck('language_code');
            foreach ($langs as $l) {
                RunTranslationCacheBuildCommand::dispatch($l);
            }
        });

        static::updated(function ($model) {
            $langs = TranslationValue::distinct()->pluck('language_code');
            foreach ($langs as $l) {
                RunTranslationCacheBuildCommand::dispatch($l);
            }
        });

        static::deleted(function ($model) {
            $langs = TranslationValue::distinct()->pluck('language_code');
            foreach ($langs as $l) {
                RunTranslationCacheBuildCommand::dispatch($l);
            }
        });
    }
}
