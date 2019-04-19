<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class CourseScheduleAjax extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function get_sections(){
        if(Request::ajax()){
            $program_code = Input::get('program_code');
            $level = Input::get('level');
            
            $sections = \App\CtrSection::distinct()->where('program_code',$program_code)
                    ->where('level',$level)->get(['section_name']);
            
            return view('admin.course_schedule.ajax.get_sections',compact('sections'))->render();
        }
    }
    
    function get_courses_offered(){
        if(Request::ajax()){
            $program_code = Input::get('program_code');
            $level = Input::get('level');
            $section_name = Input::get('section_name');
            
            $courses = \App\offerings_infos_table::
                    where('level',$level)->where('section_name',$section_name)
                    ->get();
            
            return view('admin.course_schedule.ajax.get_courses_offered',compact('courses','section_name'));
        }
    }
    
    function get_rooms_available(){
        if(Request::ajax()){
            $day = Input::get('day');
            $time_start = Input::get('time_start');
            $time_end = Input::get('time_end');
            $offering_id = Input::get('offering_id');
            $section_name = Input::get('section_name');
            
            $conflict_schedules = \App\room_schedules::
                    join('offerings_infos','offerings_infos.id','room_schedules.offering_id')
                    ->where('offerings_infos.id',$offering_id)
                    ->where('room_schedules.day',$day)
                    ->where(function($query) use ($time_start, $time_end) {
                        $query->whereBetween('time_starts', array(date("H:i:s", strtotime($time_start)), date("H:i:s", strtotime($time_end))))
                        ->orwhereBetween('time_end', array(date("H:i:s", strtotime($time_start)), date("H:i:s", strtotime($time_end))));
                    })
                    ->get();
           
            if(!$conflict_schedules->isEmpty()){
                $query = "is_active = 1 and";
                foreach($conflict_schedules as $sched){
                    $query = $query . " room != '".$sched->room."'";
                }
                $rooms = \App\CtrRoom::whereRaw($query)->get();
            }else{
                $rooms = \App\CtrRoom::where('is_active',1)->get();
            }
            
            return view('admin.course_schedule.ajax.get_available_rooms',compact('rooms','offering_id','day','time_start','time_end','section_name'));
        }
    }
    
}
