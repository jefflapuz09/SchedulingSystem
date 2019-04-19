<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class ReportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function room_occupied(){
        $rooms = \App\CtrRoom::all();
        return view('admin.reports.room_occupied',compact('rooms'));
    }
    
    function print_room_occupied($room){
        $schedules = \App\room_schedules::where('is_active',1)
                    ->where('room',$room)->get();
        
        $pdf = PDF::loadView('admin.reports.print_room_occupied',compact('schedules','room'));
        $pdf->setPaper('A4','portrait');
        return $pdf->stream("RoomsOccupied.pdf");
    }
}
