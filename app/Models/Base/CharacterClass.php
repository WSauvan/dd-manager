<?php

namespace App\Models\Base;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class CharacterClass extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'character_class';

    public const COLUMN_NAME = 'name';

    public const COLUMN_BASE_HP = 'base_hp';

    public const COLUMN_BASE_DIE = 'base_die';

    public const ACCESSOR_CHARACTER = 'character';

    public function character(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
