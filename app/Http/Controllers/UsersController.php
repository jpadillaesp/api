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

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $User = null;

    public function index() {
        
        $this->User = User::all();
        return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->User), 201);
    }

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

    public function show($id) {
        try {
            $this->User = User::findOrFail($id);
            return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->User), 201);
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

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

    //getting the OrchestratorRoom's for a particular user 
    public function getOrchestratorRooms($user_id) {
        try {

            $rooms = User::findOrFail($user_id)->orchestratorRooms;
            foreach ($rooms as $room) {
                $room['roomscount'] = count($room->transcripts);
                //unset($rooms->transcripts);
            }
            return array('error' => false, 'OrchestratorRooms' => $rooms);
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']), 403);
        }
    }

}
