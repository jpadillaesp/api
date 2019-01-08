<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\OrchestratorRoom;
//use Faker\Provider\Uuid;
use Exception;

class OrchestratorRoomController extends Controller {

    private $Errors = ['errors' => ['error' => false, 'message' => 'It was completed successfully.']];
    public $Orchestrators = null;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->Orchestrators = OrchestratorRoom::all();
        return response()->json(array($Errors, 'orchestratorroom' => $this->Orchestrators));
    }

    /**
     * Store a newly created resource in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            $this->Errors['errors']['error'] = true;
            $this->Errors['errors']['message'] = $validator->errors()->all();
        }
        //$uuid = explode("-", Uuid::uuid());
        $request['room_code'] = $this->random_string(6);
        try {
            $this->Orchestrators = OrchestratorRoom::create($request->all());
            return response()->json(array($this->Errors, 'orchestratorRoom' => $this->Orchestrators));
        } catch (Exception $exc) {
            $this->Errors['errors']['error'] = true;
            $this->Errors['errors']['message'] = $exc->getTraceAsString();
            return response()->json($this->Errors);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
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
