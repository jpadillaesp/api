<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrchestratorRoom extends Model {

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
        'title', 'description', 'room_code', 'user_id', 'disabled'
    ];
    protected $table = 'orchestrator_room';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function transcripts() {
        return $this->hasMany(Transcript::class);
    }

}
