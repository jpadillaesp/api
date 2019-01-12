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

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes;

    public $id;
    public $full_name;
    public $email;
    public $black_listed;
    public $flatpassword;
    public $password;
    public $password_changed;
    public $disabled;
    public $api_token;
    public $remember_token;
    public $password_create;
    public $confirmPassword_create;
    public $password_change;
    public $confirmPassword_change;
    
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
