<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller {

    private $Errors = ['errors' => ['status' => false, 'message' => 'It was completed successfully.']];
    public $_Auth = null;

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
        try {
            $this->Errors['errors']['status'] = false;
            $this->Errors['errors']['message'] = 'Successful Login of User.';
            $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'password' => 'required'
            ]);

            if ($validator->fails()) {
                $this->Errors['errors']['status'] = true;
                $this->Errors['errors']['message'] = $validator->errors()->all();
            }

            $this->_Auth = User::where('email', $request->input('email'))->first();
//            dd($this->_Auth );
            if (isset($this->_Auth)) {
                if (password_verify($request->input('password'), $this->_Auth->password)) {
                    //unset($this->_Auth->password);
                    return response()->json(array('errors' => $this->Errors['errors'], 'user' => $this->_Auth),201);
                } else {
                    return response()->json($this->Errors);
                }
            } else {
                return response()->json($this->Errors);
            }
        } catch (Exception $exc) {
            $this->Errors['errors']['error'] = true;
            $this->Errors['errors']['message'] = $exc->getMessage();
            return response()->json($this->Errors);
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
        //
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
