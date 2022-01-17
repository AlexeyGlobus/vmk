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

    const CREATE_RIGHT = 'create';
    const READ_RIGHT = 'read';
    const UPDATE_RIGHT = 'update';
    const DELETE_RIGHT = 'delete';

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
            self::CREATE_RIGHT => !!$bin[3],
            self::READ_RIGHT   => !!$bin[2],
            self::UPDATE_RIGHT => !!$bin[1],
            self::DELETE_RIGHT => !!$bin[0]
        ];
    }

    /**
     * Checks if action $action is allowed.
     *
     * @param  string  $action
     * @return bool
     */
    public function check(string $action) :bool
    {
        return $this->rights[$action];
    }
}
 