<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(
 *     title="Transcript",
 *     description="Transcript"
 * )
 *
 * @package App\Http\Responses
 */
class Transcript extends Model {

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
     *     description="name"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @Property(
     *     type="string",
     *     description="transcript"
     * )
     *
     * @var string
     */
    public $transcript;

    /**
     * @Property(
     *     type="string",
     *     description="audio encode to base64"
     * )
     *
     * @var string
     */
    public $audiobase64;

    /**
     * @Property(
     *     type="string",
     *     description="starTime",
     *     format="00:00:00"
     * )
     *
     * @var string
     */
    public $starTime;

    /**
     * @Property(
     *     type="string",
     *     description="endTime",
     *     format="00:00:00"
     * )
     *
     * @var string
     */
    public $endTime;

    /**
     * @Property(
     *     type="integer",
     *     description="words"
     * )
     *
     * @var int
     */
    public $words;

    /**
     * @Property(
     *     type="integer",
     *     description="orchestrator_room_id",
     *     @Items(ref="#/components/schemas/OrchestratorRoom/properties/id")
     * )
     *
     * @var int
     */
    public $orchestrator_room_id;

    /**
     * @Property(
     *     type="integer",
     *     description="disable"
     * 
     * )
     *
     * @var int
     */
    public $disable;

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
