<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $brand;
 * @property mixed $name;
 * @property mixed $article;
 * @property mixed $description;
 * @property mixed $price;
 * @property mixed $old_price;
 * @property mixed $available;
 * @property mixed $section;
 * @property mixed $id
 * @method static find(int $id)
 * @method static where(\Closure $param)
 * @method static whereIn(string $string, array $arr)
 *
 */
class StoreProduct extends Model
{
    use HasFactory;
}
