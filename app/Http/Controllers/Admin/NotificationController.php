<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class NotificationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function notifications(){
        
            $notifications = \App\LoadNotification::get();
            return view('admin.notification.notification',compact('notifications'));
        
    }
}
