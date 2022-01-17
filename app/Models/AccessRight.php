<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * AccessRight model
 *
 * @property integer $id
 * @property string $table_name
 * @property integer $role
 * @property integer $rights
 *
 */
class AccessRight extends Model
{
    use HasFactory;

    /**
     * Get the create rights array.
     *
     * @param  integer  $value
     * @return array
     */
    public function getRightsAttribute(int $value) :array
    {
        $bin = decbin($value);
        return [
            'create' => !!$bin[0],
            'read'   => !!$bin[1],
            'update' => !!$bin[2],
            'delete' => !!$bin[3]
        ];
    }
}
 