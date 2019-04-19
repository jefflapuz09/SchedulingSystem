<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Session;

class SuperAdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('superadmin');
    }
    
    function register_admin(){
        return view('super_admin.register_admin');
    }
    
    function register_admin_save(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255|unique:users',
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        
        if($validator->fails()){
            return redirect('/superadmin/register_admin')
                        ->withErrors($validator)
                        ->withInput();
        }else{
            \App\User::create([
               'username' => $request->username,
                'name' => $request->name,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'accesslevel' => 0,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            
            Session::flash('success','Successfully Created an Administrator!');
            return redirect('/superadmin/register_admin');
        }
    }
}
