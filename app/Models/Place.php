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
 * @property string $ownersName
 * @property string $ownersSurname
 * @property string $ownersPatronymic
 * @property string $ownersEmail
 * @property string $ownersPhone
 */
class Place extends Model
{
    use HasFactory;
}
