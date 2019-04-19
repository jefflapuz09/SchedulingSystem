<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class AccountController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
    }
    
    function change_pass(){
        return view('account.password');
    }
    
    function change_password(Request $request){
            $validate = $request->validate([
                'password' => 'required|min:6|confirmed'
            ]);
            if($validate){
                $user = \App\User::find($request->idno);
                $user->password = bcrypt($request->password);
                $user->update();
            }
            Session::flash('success','Password has been modified!');
            return redirect(url('/account/change_password'));
    }
}
