<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
class UserController extends Controller
{
    public $successStatus = 200;

    public function login(){
        if(Auth::attempt(['NIM' => request('NIM'),'password' => request('password')])){
            $user = Auth::user();
            $success['NIM'] = $user->NIM;
            $success['name'] =  $user->name;
            $success['email'] = $user->email;
            $success['roles'] = $user->roles;
            $success['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json(['status' => $success], $this->successStatus);
        }
        else{
            return response()->json(['status'=>'201'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NIM' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'roles' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        $success['roles'] = $user->roles;

        return response()->json(['success'=>$success], $this->successStatus);
    }
    public function update (Request $request, $NIM)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $roles = $request->input('roles');

        $data = \App\User::where('NIM',$NIM)->first();
        $data->name = $name;
        $data->email = $email;
        $data->roles = $roles;

        if($data->save()){ //mengecek apakah data kosong atau tidak
            $res['message'] = "Success!";
            $res['values'] = $data;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }
    public function index()
    {
        $data = DB::table('users')->simplePaginate(8);

        if(count($data) > 0){ //mengecek apakah data kosong atau tidak
            $res['message'] = "Success!";
            $res['values'] = $data;
            return response($res);
        }
        else{
            $res['message'] = "Empty!";
            return response($res);
        }
    }
}
