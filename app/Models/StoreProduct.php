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
 */
class StoreProduct extends Model
{
    use HasFactory;
}
