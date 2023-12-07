<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static orderBy(string $string)
 * @method static where(string $string, int $id)
 * @property mixed $name
 * @property mixed $sort
 * @property mixed $visible
 * @property mixed $link
 * @property int|mixed $parent
 */
class StoreSections extends Model
{
    use HasFactory;
}
