<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $user
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $patronymic
 * @property mixed $city
 * @property mixed $street_address
 * @property mixed $telephone
 * @property mixed $about
 * @method static where(string $string, $id)
 */
class StoreProfiles extends Model
{
    use HasFactory;
}
