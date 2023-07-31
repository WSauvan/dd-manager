<?php

namespace App\Models\Base;

use App\Models\CharacterClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class Character extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'character';

    public const COLUMN_NAME = 'name';

    public const COLUMN_LEVEL = 'level';

    public const ACCESSOR_CHARACTER_CLASS = 'character_class';

    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class);
    }
}
