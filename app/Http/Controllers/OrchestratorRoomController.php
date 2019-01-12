<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\OrchestratorRoom;
//use Faker\Provider\Uuid;
use Exception;

class OrchestratorRoomController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $Orchestrators = null;

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
