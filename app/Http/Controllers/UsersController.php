<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Validator;
use Exception;

class UsersController extends Controller {

    private $Errors = ['errors' => ['error' => false, 'message' => 'It was completed successfully.']];
    public $User = null;

    public function index() {
        $this->User = User::all();
        return response()->json($this->User);
    }

    public function create(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                        'full_name' => 'required',
                        'password' => 'required',
                        'email' => 'required|email'
            ]);
            if ($validator->fails()) {
                $this->Errors['errors']['error'] = true;
                $this->Errors['errors']['message'] = $validator->errors()->all();
            }
            $request['flatpassword'] = $request['password'];
            $request['api_token'] = str_random(60);
            $request['password'] = (new BcryptHasher)->make($request['password']); //        $request['password'] = app('hash')->make($request['password']);
            $this->User = User::create($request->all());
            return response()->json(array($this->Errors, 'user' => $this->User));
        } catch (Exception $exc) {
            $this->Errors['errors']['error'] = true;
            $this->Errors['errors']['message'] = $e->getTraceAsString();
            return response()->json($this->Errors);
        }
    }

    public function show($id) {
        $this->User = User::findOrFail($id);
        return response()->json($this->User);
    }

    public function edit(Request $request, $id) {
        try {
            $validator = Validator::make($request->all(), [
                        'id' => 'required',
                        'email' => 'required|email', 'password' => 'required',
            ]);
            if ($validator->fails()) {
                $this->Errors['errors']['error'] = true;
                $this->Errors['errors']['message'] = $validator->errors()->all();
            }
            $this->User = User::findOrFail($id);
            $request['flatpassword'] = $request->input('password');
            $request['password'] = (new BcryptHasher)->make($request['password']);
            $this->Errors['errors']['message'] = $validator->errors()->all();
            $this->User->update($request->all());
            return response()->json(array($this->Errors, 'user' => $this->User));
        } catch (Exception $e) {
            $this->Errors['errors']['error'] = true;
            $this->Errors['errors']['message'] = $e->getTraceAsString();
            return response()->json($this->Errors);
        }
    }

    public function destroy($id) {
        $this->User = User::find($id);
        $this->User->delete();
        return response()->json('Removed successfully.');
    }

    //getting the OrchestratorRoom's for a particular user 
    public function getOrchestratorRooms($user_id) {
        $rooms = User::findOrFail($user_id)->orchestratorRooms;
        foreach ($rooms as $room) {
            $room['roomscount'] = count($room->transcripts);
            unset($rooms->transcripts);
        }
        return array('error' => false, 'OrchestratorRooms' => $rooms);
    }

}
