<?php
/**
 * @license Apache 2.0
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Exception;
use OpenApi\Annotations\Get;
use OpenApi\Annotations\MediaType;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\RequestBody;
use OpenApi\Annotations\Response;
use OpenApi\Annotations\Schema;

/**
 * @SWG\Swagger(
 *     @Info(title="User", version="0.1")
 * )
 */
class UsersController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $User = null;

    /**
     * @Get(path="/api/v1/users",
     *     tags={"index"},
     *     summary="List user",
     *     description="This can only be done by the logged in user.",
     *     operationId="all",
     *     @RequestBody(
     *         @MediaType(
     *              mediaType="application/json",
     *              @Schema(ref="#/components/schemas/User")
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

        $this->User = User::all();
        return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->User), 201);
    }

    /**
     * @Post(
     *     path="/api/v1/users/add",
     *     tags={"add"},
     *     summary="Create user",
     *     @RequestBody(
     *         @JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @Response(
     *         response="200",
     *         description="Normal operation response",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/User")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(response="400", description="Ningun usuario registrado")
     * )
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        try {
            $validator = Validator::make($request->all(), ['full_name' => 'required', 'email' => 'required|email', 'password' => 'required']);
            if ($validator->fails()) {
                $this->Errors['Errors'] = ['status' => true, 'message' => $validator->errors()->all()];
            }
            $temp = $request['password'];
            $request['password'] = (new BcryptHasher)->make($request['password']);
            $request->merge(array('flatpassword' => $temp));
            $request->merge(array('api_token' => str_random(36)));
            $this->User = User::create($request->all());
            if ($this->User->save()) {
                return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->User), 201);
            } else {
                return response()->json(array('Errors' => $this->Errors['Errors']), 403);
            }
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
        }
        return response()->json(array('Errors' => $this->Errors['Errors']), 403);
    }

    /**
     * @Get(
     *     path="/api/v1/users/view/{id:[0-9]+}",
     *     deprecated=false,
     *     tags={"add"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="id", type="string", description="ID User")
     *         )
     *     ),
     *     @Response(
     *         response=202,
     *         description="Colección de usuarios",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/User")
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @Response(
     *         response=402,
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
            $this->User = User::findOrFail($id);
            return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->User), 201);
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

    /**
     * @Put(
     *     path="/api/v1/users/edit/{id:[0-9]+}",
     *     deprecated=false,
     *     tags={"add"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="data", ref="#/components/schemas/User"),
     *            @Property(property="id", type="string", description="ID User")
     *         )
     *     ),
     *     @Response(
     *         response=203,
     *         description="Colección de usuarios",
     *         @MediaType(
     *             mediaType="application/json",
     *             @Schema(
     *                 allOf={
     *                     @Schema(ref="#/components/schemas/ApiResponse"),
     *                     @Schema(
     *                         type="object",
     *                         @Property(property="data", ref="#/components/schemas/User")
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
     * @param \Illuminate\Http\Request $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                        'id' => 'required',
                        'email' => 'required|email',
                        'full_name' => 'required'
            ]);
            if ($validator->fails()) {
                $this->Errors['Errors'] = ['status' => true, 'message' => $validator->errors()->all()];
            }
            $this->User = User::findOrFail($id);
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
     *         response=404,
     *         description="Usuario no existe."
     *     )
     * )
     */

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $this->User = User::find($id);
            $this->User->delete();
            $this->Errors['Errors']['message'] = 'Removed successfully.';
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
        return response()->json(array('Errors' => $this->Errors['Errors']), 201);
    }

    /**
     * @Get(
     *     path="/api/v1/users/rooms/{id:[0-9]+}",
     *     deprecated=false,
     *     tags={"rooms"},
     *     @RequestBody(
     *         @MediaType(
     *            mediaType="application/json",
     *            @Property(property="$user_id", type="string", description="ID User")
     *         )
     *     ),
     *     @Response(
     *         response="201",
     *         description="Colección de Salones de Orquestadores",
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
     *         response="405",
     *         description="Ningun usuario registrado"
     *     )
     * )
     */

    /**
     * Getting the OrchestratorRoom's for a particular user 
     * @param \Illuminate\Http\Request $user_id
     * @return \Illuminate\Http\Response
     */
    public function OrchestratorRooms($user_id) {
        try {

            $rooms = User::findOrFail($user_id)->orchestratorRooms;
            foreach ($rooms as $room) {
                $room['roomscount'] = count($room->transcripts);
                unset($rooms->transcripts);
            }
            return array('error' => false, 'OrchestratorRooms' => $rooms);
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

}
