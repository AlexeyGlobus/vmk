<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use League\CommonMark\Node\Node;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
}
