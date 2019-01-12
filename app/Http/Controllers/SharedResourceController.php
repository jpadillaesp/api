<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\SharedResource;
use App\Models\OrchestratorRoom;
use App\Models\User;

class SharedResourceController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $SharedResource = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'orchestrator_room_id' => 'required',
                    'room_code' => 'required'
        ]);

        if ($validator->fails()) {
            $this->Errors['Errors']['status'] = true;
            $this->Errors['Errors']['message'] = $validator->errors()->all();
        }
        $this->SharedResource = SharedResource::create($request->all());
        return response()->json(array($this->Errors, '$sharedResource' => $this->SharedResource ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

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

}
