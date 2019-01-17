<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OpenApi\Annotations\Items;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;

/**
 * @Schema(
 *     title="SharedResource",
 *     description="SharedResource"
 * )
 *
 * @package App\Http\Responses
 */
class SharedResource extends Model {

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
     *     description="orchestrator_room_id",
     *     @Items(ref="#/components/schemas/OrchestratorRoom/properties/id")
     * 
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
