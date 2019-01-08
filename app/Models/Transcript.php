<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transcript extends Model {

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

    public function orchestratorRoom() {
        return $this->belongsTo(OrchestratorRoom::class, 'orchestrator_room_id');
    }

}