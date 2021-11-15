<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "places".
 *
 * @property int $id
 * @property string $name
 * @property string $coords
 * @property integer $type
 * @property string $
 * @property string $owners_surname
 * @property string $owners_patronymic
 * @property string $owners_email
 * @property string $owners_phone
 */
class Place extends Model
{
    const TYPE_PRIVATE = 1;
    const TYPE_BUSINESS = 2;
    const TYPE_OTHER = 3;

    use HasFactory;
}
