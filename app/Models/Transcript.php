<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transcript extends Model {

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
        'name', 'transcript', 'audiobase64', 'starTime', 'endTime', 'words', 'orchestrator_room_id', 'disabled'
    ];
    protected $table = 'transcript';

    public function orchestratorRoom() {
        return $this->belongsTo(OrchestratorRoom::class, 'orchestrator_room_id');
    }

}
