<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TranslationValue extends Model
{
    use HasFactory;

    protected $fillable = ['translation_key_id', 'language_code', 'tag', 'value'];

    public function key()
    {
        return $this->belongsTo(TranslationKey::class);
    }
}
