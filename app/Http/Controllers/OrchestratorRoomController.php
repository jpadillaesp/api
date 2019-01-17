<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\OrchestratorRoom;
//use Faker\Provider\Uuid;
use Exception;
/**
 * @SWG\Swagger(
 *     @Info(title="OrchestratorRoom", version="0.1")
 * )
 */
class OrchestratorRoomController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $Orchestrators = null;

    /**
     * @Get(path="/api/v1/orchestratorroom",
     *     tags={"index"},
     *     summary="List Rooms",
     *     description="This can only be done by the logged in user.",
     *     operationId="all",
     *     @RequestBody(
     *         @MediaType(
     *              mediaType="application/json",
     *              @Schema(ref="#/components/schemas/OrchestratorRoom")
     *         )
     *     ),
     *     @Response(response="200", description="Colección de usuarios"),
     *     @Response(response="400", description="Ningun usuario registrado")
     * )
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {

            $this->Orchestrators = OrchestratorRoom::all();
            return response()->json(array('Errors' => $this->Errors['Errors'], 'orchestratorroom' => $this->Orchestrators), 201);
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

    /**
     * @Post(
     *     path="/api/v1/orchestratorroom/add",
     *     deprecated=false,
     *     tags={"add"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="user_id", type="string", description="User Id")
     *         )
     *     ),
     *     @Response(
     *         response=201,
     *         description="Colección de Salones de Orquestador",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/OrchestratorRoom")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(
     *         response=403,
     *         description="Ningun salon registrado"
     *     )
     * )
     */

    /**
     * Store a newly created resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'description' => 'required',
                    'disabled' => 'required'
        ]);
        if ($validator->fails()) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $validator->errors()->all()];
        }
        //$uuid = explode("-", Uuid::uuid());
        $request['room_code'] = $this->random_string(6);
        
        try {
            $this->Orchestrators = OrchestratorRoom::create($request->all());
            return response()->json(array('Errors' => $this->Errors['Errors'], 'orchestratorRoom' => $this->Orchestrators));
        } catch (Exception $exc) {
            $this->Errors['Errors']['status'] = true;
            $this->Errors['Errors']['message'] = $exc->getTraceAsString();
            return response()->json(array('Errors' => $this->Errors['Errors']));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * @Get(
     *     path="/api/v1/orchestratorroom/view/{id:[0-9]+}",
     *     deprecated=false,
     *     tags={"add"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="id", type="string", description="ID Rooms")
     *         )
     *     ),
     *     @Response(
     *         response=202,
     *         description="Colección de salones",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/OrchestratorRoom")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(
     *         response=403,
     *         description="Ningun usuario registrado"
     *     )
     * )
     */

    /**
     * @param \Illuminate\Http\Request $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            $this->Orchestrators = OrchestratorRoom::findOrFail($id);
            return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->Orchestrators), 201);
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

    /**
     * @Put(
     *     path="/api/v1/orchestratorroom/edit/{id:[0-9]+}",
     *     deprecated=false,
     *     tags={"add"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="data", ref="#/components/schemas/OrchestratorRoom"),
     *            @Property(property="id", type="string", description="ID OrchestratorRoom")
     *         )
     *     ),
     *     @Response(
     *         response=203,
     *         description="Edicion de salon de orquestador",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/OrchestratorRoom")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(
     *         response=403,
     *         description="Ningun usuario registrado"
     *     )
     * )
     */

    /**
     * Update the specified resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                        'id' => 'required',
                        'user_id' => 'required',
                        'description' => 'required',
                        'room_code' => 'required',
                        'disabled' => 'required'
            ]);
            if ($validator->fails()) {
                $this->Errors['Errors'] = ['status' => true, 'message' => $validator->errors()->all()];
            }
            $this->Orchestrators = OrchestratorRoom::findOrFail($id);
            $request['flatpassword'] = $request->input('password');
            $request['password'] = (new BcryptHasher)->make($request['password']);
            $this->User->update($request->all());
            return response()->json(array(array('errors' => $this->Errors['Errors']), 'Users' => $this->User));
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

        /**
     * @Delete(
     *     path="/api/v1/users/delete/{id:[0-9]+}",
     *     deprecated=false,
     *     tags={"add"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="id", type="string", description="ID User")
     *         )
     *     ),
     *     @Response(
     *         response=204,
     *         description="Usuario eliminado"
     *     ),
     *     @Response(
     *         response=403,
     *         description="Usuario no existe."
     *     )
     * )
     */

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $this->Orchestrators = OrchestratorRoom::find($id);
            $this->UsOrchestratorser->delete();
            $this->Errors['Errors']['message'] = 'Removed successfully.';
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
        return response()->json(array('Errors' => $this->Errors['Errors']), 201);
    }


    function random_string($max = 20) {
        $chars = explode(" ", "a b c d e f g h i j k l m n o p q r s t u v w x y z 0 1 2 3 4 5 6 7 8 9");
        for ($i = 0; $i < $max; $i++) {
            $rnd = array_rand($chars);
            $rtn .= base64_encode(md5($chars[$rnd]));
        }
        return substr(str_shuffle(strtolower($rtn)), 0, $max);
    }

}
