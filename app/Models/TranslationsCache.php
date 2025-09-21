<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationsCache extends Model
{
    protected $table = 'translations_cache';
    protected $fillable = ['language_code', 'content', 'last_generated_at'];

    protected $casts = [
        'content' => 'array',
        'last_generated_at' => 'datetime',
    ];
}
