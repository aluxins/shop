<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $id)
 * @method static orderBy(string $string)
 * @method static where(string $string, $id)
 * @property mixed $name
 * @property mixed $url
 * @property mixed $sort
 * @property mixed $title
 * @property mixed $body
 * @property mixed $id
 */
class StorePages extends Model
{
    use HasFactory;
}
