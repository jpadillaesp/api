<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Exception;
use App\Models\Transcript;

class TranscriptController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $Transcript = null;

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
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
                    'transcript' => 'required'
        ]);

        if ($validator->fails()) {
            $this->Errors['Errors']['status'] = true;
            $this->Errors['Errors']['message'] = $validator->errors()->all();
        }

        try {
            $this->Transcript = Transcript::create($request->all());
            return response()->json(array($this->Errors, 'transcript' => $this->Transcript ));
        } catch (Exception $e) {
            $this->Errors['Errors']['status'] = true;
            $this->Errors['Errors']['message'] = $e->getTraceAsString();
            return response()->json(array($this->Errors, 'transcript' => $transcript));
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

}
