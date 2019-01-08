<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharedResource extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'transcript', 'audiobase64', 'starTime', 'endTime', 'words', 'orchestrator_room_id', 'disabled'
    ];

    public function user() {
        return $this->belongsToMany(User::class)
                        ->withPivot('create', 'read', 'update', 'delete');
    }

    public function orchestratorRoom() {
        return $this->belongsToMany(OrchestratorRoom::class)
                        ->withPivot('create', 'read', 'update', 'delete');
    }

}
