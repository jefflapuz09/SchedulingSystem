<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class ReportAjax extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function get_room_occupied(){
        if(Request::ajax()){
            $room = Input::get('room');
            
            $schedules = \App\room_schedules::where('is_active',1)
                    ->where('room',$room)->get();
            
            return view('admin.reports.ajax.get_room_occupied',compact('schedules','room'));
        }
    }
}
