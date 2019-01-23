<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class User
 *
 * @package App\Models
 *
 * @author  José Padilla <j.arturopad@gmail.com>
 *
 * @OA\Schema(
 *     description="User",
 *     title="User",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User extends Model implements
AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'black_listed', 'flatpassword', 'password', 'disable', 'api_token'
    ];
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'flatpassword', 'password', 'remember_token', 'deleted_at'
    ];

    public function orchestratorRooms() {
        return $this->hasMany(OrchestratorRoom::class);
    }

}
