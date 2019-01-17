<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(
 *     title="OrchestratorRoom",
 *     description="OrchestratorRoom"
 * )
 *
 * @package App\Http\Responses
 */
class OrchestratorRoom extends Model implements JsonResponse{

    use SoftDeletes;

    /**
     * @Property(
     *     type="integer",
     *     description="id"
     * )
     *
     * @var int
     */
    public $id;
    
    /**
     * @Property(
     *     type="string",
     *     description="title"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @Property(
     *     type="string",
     *     description="description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @Property(
     *     type="string",
     *     description="room_code"
     * )
     *
     * @var string
     */
    public $room_code;

    /**
     * @Property(
     *     type="integer",
     *     description="user_id",
     *     @Items(ref="#/components/schemas/User/properties/id")
     * 
     * )
     *
     * @var int
     */
    public $user_id;

    /**
     * @Property(
     *     type="integer",
     *     description="disabled"
     * )
     *
     * @var int
     */
    public $disabled;
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
