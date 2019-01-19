<?php

namespace App\Http\Controllers;

use App\Models\OrchestratorRoom;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Exception;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;

class OrchestratorRoomController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    private $Orchestrators = null;

    /**
     * @Get(path="/api/v1/orchestratorroom",
     *     tags={"index"},
     *     summary="List Rooms",
     *     description="This can only be done by the logged in user.",
     *     operationId="all",
     *     @Response(response="200", description="Colección de usuarios"),
     *     @Response(response="400", description="Ningun usuario registrado")
     * )
     */

    /**
     * Display a listing of the resource.
     *
     * @return Http response
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
     *     @Response( response=403, description="Ningun salon registrado" )
     * )
     */

    /**
     * Store a newly created resource in database.
     *
     * @param Http request
     * @return Http response
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
     * @param  Http request 
     * @return  Http response
     */
    public function store(Request $request) {
        //
    }

    /**
     * @OA\Get(path="/api/v1/orchestratorroom/view/{id:[0-9]+}",
     *     summary="Info for a specific room",
     *     operationId="showRoomById",
     *     tags={"orchestratorroom"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The id of the room to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expected response to a valid request",
     *         @OA\Schema(ref="#/components/schemas/OrchestratorRoom")
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="unexpected error",
     *         @OA\Schema(ref="#/components/schemas/Error")
     *     )
     * )
     */

    /**
     * @param Http request 
     * @param int $id
     * @return Http response
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
     *     summary="Updated OrchestratorRoom",
     *     description="This can pnly be done by the logged in user.",
     *     operationId="updateRoom",
     *     @OA\Response(
     *         response=400,
     *         description="Invalid user supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\RequestBody(
     *         description="Updated user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */

    /**
     * 
     * @param Http request
     * @param  int  $id
     * @return Http response
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
     *     summary="Delete user",
     *     description="This can only be done by the logged in user.",
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The name that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     )
     * )
     */

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return Http response
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
