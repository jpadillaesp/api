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
 * @Schema(
 *     title="User",
 *     description="User"
 * )
 *
 * @package App\Http\Responses
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes;

    /**
     * @Property(
     *     type="integer",
     *     description="id",
     *     format="int64"
     * )
     *
     * @var integer
     */
    public $id;

    /**
     * @Property(
     *     type="string",
     *     description="full_name"
     * )
     *
     * @var string
     */
    public $full_name;

    /**
     * @Property(
     *     type="string",
     *     description="email"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @Property(
     *     type="integer",
     *     description="black_listed"
     * )
     *
     * @var int
     */
    public $black_listed;

    /**
     * @Property(
     *     type="string",
     *     description="flatpassword"
     * )
     *
     * @var string
     */
    public $flatpassword;

    /**
     * @Property(
     *     type="string",
     *     description="password"
     * )
     *
     * @var string
     */
    public $password;

    /**
     * @Property(
     *     type="string",
     *     description="password_changed"
     * )
     *
     * @var string
     */
    public $password_changed;

    /**
     * @Property(
     *     type="integer",
     *     description="disabled"
     * )
     *
     * @var int
     */
    public $disabled;

    /**
     * @Property(
     *     type="string",
     *     description="api_token"
     * )
     *
     * @var int
     */
    public $api_token;

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
