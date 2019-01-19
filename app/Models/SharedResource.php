<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedResource extends Model {

    use SoftDeletes;

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
        'user_id', 'orchestrator_room_id', 'disabled'
    ];
    protected $table = 'shared_resource';

    public function user() {
        return $this->belongsToMany(User::class)
                        ->withPivot('create', 'read', 'update', 'delete');
    }

    public function orchestratorRoom() {
        return $this->belongsToMany(OrchestratorRoom::class)
                        ->withPivot('create', 'read', 'update', 'delete');
    }

}
