<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

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
        $response = ['errors' => ['error' => false, 'message' => 'Successful Login of User.']];

        $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
                ])->fails();

        if ($validator->fails()) {
            $response['errors']['error'] = true;
            $response['errors']['message'] = $validator->errors()->all();
        }

        $user = null;
        
        try {
            $user = User::where('email', $request->input('email'))->first();
        } catch (RuntimeException $e) {
            $response['errors']['error'] = true;
            $response['errors']['message'] = $e->getMessage();
        }

        if (count($user)) {
            if (password_verify($request->input('password'), $user->password)) {
                unset($user->password);
                return response()->json(array($response, 'user' => $user));
            } else {
                return response()->json($response);
            }
        } else {
            return response()->json($response);
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
