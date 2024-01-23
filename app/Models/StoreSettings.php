<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert(array $data)
 * @method static where(string $string, int|string $key)
 * @method static select(string $string, string $string1)
 */
class StoreSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value'
    ];

    public $timestamps = false;
}
