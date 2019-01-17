<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;



class AuthController extends Controller {

    private $Errors = ['Errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $_Auth = null;

    
   
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
        try {
            $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'password' => 'required'
            ]);

            if ($validator->fails()) {
                $this->Errors['Errors'] = ['status' => true, 'message' => $validator->errors()->all()];
            }

            $this->_Auth = User::where('email', $request->input('email'))->first();
//            dd($this->_Auth );
            if (isset($this->_Auth)) {
                if (password_verify($request->input('password'), $this->_Auth->password)) {
                    //unset($this->_Auth->password);
                    return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->_Auth), 201);
                } else {
                    return response()->json(array('Errors' => $this->Errors['Errors']));
                }
            } else {
                return response()->json(array('Errors' => $this->Errors['Errors']));
            }
        } catch (Exception $exc) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']));
        }
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
        try {
            $validator = Validator::make($request->all(), [
                        'id' => 'required',
                        'email' => 'required|email',
                        'password' => 'required',
                        'password_changeAccount' => 'required',
                        'confirmPassword_changeAccount' => 'required',
            ]);
            if ($validator->fails()) {
                 $this->Errors['Errors'] = ['status' => true, 'message' => $validator->errors()->all()];
            }
            $this->_Auth = User::findOrFail($id);

            if (isset($this->_Auth)) {
                if (password_verify($request->input('password'), $this->_Auth->password )) {
                    unset($this->_Auth->password);
                    $this->_Auth->flatpassword = $request->input('password_changeAccount');
                    $this->_Auth->password = (new BcryptHasher)->make($request['password_changeAccount']);
                    $this->_Auth->password_changed = date('Y-m-d');
                    $this->_Auth->update();
                    return response()->json(array('Errors' => $this->Errors['Errors'], 'Users' => $this->_Auth), 201);
                } else {
                    return response()->json(array('Errors' => $this->Errors['Errors']),401);
                }
            } else {
                return response()->json(array('Errors' => $this->Errors['Errors']),401);
            }
        } catch (Exception $e) {
            $this->Errors['Errors'] = ['status' => true, 'message' => $exc->getMessage()];
            return response()->json(array('Errors' => $this->Errors['Errors']));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy() {
        auth()->logout();
    }

}
