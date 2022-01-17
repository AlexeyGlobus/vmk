<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\CommonMark\Node\Node;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $email_verified_at
 * @property string $remember_token
 * @property integer $role
 * @property string $created_at
 * @property string $updated_at
 *
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_ACOOUNTANT = 2;
    const ROLE_DIRECTOR = 3;
    const ROLE_OTHER = 4;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    /**
     * @return mixed
     */
    public function getJWTIdentifier() :mixed
    {
        return $this->getKey();
    }
    
    /**
     * @return array
     */
    public function getJWTCustomClaims() :array
    {
        return [];
    }

    /**
     * Get user's access rights.
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accessRights() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccessRight::class,  'role', 'role');

    }

    /**
     * @inheritDoc
     */
    public function can ($abilities, $arguments = []) :bool
    {
        $result = false;
        $splitted = explode('-', $abilities);
        if (is_array($splitted) && count($splitted) === 2) {
            //$rights = $this->accessRights()->where('table_name', '=', $splitted[1])->first();
            $rights = AccessRight::where([
                ['role', '=', $this->role],
                ['table_name', '=', $splitted[1]]
            ])->first();
            $result = $rights->check($splitted[0]);
        }
        return $result;
    }
}
