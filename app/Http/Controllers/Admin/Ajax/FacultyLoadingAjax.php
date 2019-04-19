<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;

class FacultyLoadingAjax extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function courses_to_load(){
        if(Request::ajax()){
            $level = Input::get('level');
            $instructor = Input::get('instructor');
            
            $courses = \App\room_schedules::distinct()->
                    where('is_active',1)->whereNull('instructor')->get(['offering_id']);
            
            return view('admin.faculty_loading.ajax.courses_to_load',compact('level','courses'))->render();
        }
    }
    
    function current_load(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $level = Input::get('level');
            
            $loads = DB::table('curricula')
                    ->join('offerings_infos','curricula.id','offerings_infos.curriculum_id')
                    ->join('room_schedules','room_schedules.offering_id','offerings_infos.id')
                    ->where('room_schedules.instructor',$instructor)
                    ->get();
            $tabular_schedules = \App\room_schedules::distinct()->
                    where('is_active',1)->where('instructor',$instructor)->get(['offering_id']);
            $schedules = \App\room_schedules::
                    where('is_active',1)->where('instructor',$instructor)->get();
            
            return view('admin.faculty_loading.ajax.current_load',compact('schedules','instructor','level','tabular_schedules','loads'))->render();
        }
    }
    
    function add_faculty_load(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $info = \App\instructors_infos::where('instructor_id',$instructor)->first();
            
            
            $loads = DB::table('curricula')
                    ->join('offerings_infos','curricula.id','offerings_infos.curriculum_id')
                    ->join('room_schedules','room_schedules.offering_id','offerings_infos.id')
                    ->where('room_schedules.instructor',$instructor)
                    ->get();
            $load_units = \App\UnitsLoad::where('instructor_id',$instructor)->get();
            
            if($loads->sum('units') >= $load_units->sum('units')){
                abort(404);
            }
            
            $schedules = \App\room_schedules::where('offering_id',$offering_id)->get();
            if(!$schedules->isEmpty()){
                foreach($schedules as $schedule){
                    $conflict = \App\room_schedules::distinct()
                            ->where('instructor',$instructor)
                            ->where('day',$schedule->day)
                            ->where(function($query) use ($schedule) {
                                $query->whereBetween('time_starts', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))))
                                ->orwhereBetween('time_end', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))));
                            })
                            ->get(['offering_id']);
                    if($conflict->isEmpty()){
                        $schedule->instructor = $instructor;
                        $schedule->update();
                    }else{
                        $rollback_schedules = \App\room_schedules::where('offering_id',$schedule->offering_id)->get();
                        if(!$rollback_schedules->isEmpty()){
                            foreach($rollback_schedules as $rollback){
                                $rollback->instructor = NULL;
                                $rollback->update();
                            }
                            abort(500);
                            //HTTP Error 500 para kapag may nakitang conflict alert conflict. Naaadd pa din yung schedule
                            // kaso pag nakapasok sa rollback schedules inupdate ko ulit na parnag walang nangyari.
                        }
                    }
                }
            }
        }
    }
    
    function remove_faculty_load(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $schedules = \App\room_schedules::where('instructor',$instructor)->where('offering_id',$offering_id)->get();
            
            if(!$schedules->isEmpty()){
                foreach($schedules as $schedule){
                    $schedule->instructor = NULL;
                    $schedule->is_loaded = 0;
                    $schedule->save();
                }
            }
        }
    }
    
    function search_courses(){
        if(Request::ajax()){
            $value = Input::get('value');
            $level = Input::get('level');
            
            $curriculum = \App\curriculum::where('course_code','like',"%$value%")->get();
            
            return view('admin.faculty_loading.ajax.search_courses',compact('curriculum','level'));
        }
    }
    
    function reloadnotif(){
        if(Request::ajax()){
            $notif_id = Input::get('notif_id');
            
            $notification = \App\LoadNotification::find($notif_id);
            $notification->is_trash = 1;
            $notification->update();
            
            $notifications = \App\LoadNotification::get();
            return view('admin.notification.ajax.reload_notification',compact('notifications'));
        }
    }
    
    function get_units_loaded(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $level = Input::get('level');
            $type = \App\instructors_infos::where('instructor_id',$instructor)->first()->employee_type;
            $units = \App\UnitsLoad::where('instructor_id',$instructor)->first()->units;
            $tabular_schedules = \App\room_schedules::distinct()->
                    where('is_active',1)->where('instructor',$instructor)->get(['offering_id']);
            return view('admin.faculty_loading.ajax.get_units_loaded',compact('instructor','tabular_schedules','type','units','offering_id','level'));
        }
    }
    
    function override_add(){
        if(Request::ajax()){
            $instructor = Input::get('instructor');
            $offering_id = Input::get('offering_id');
            $override = Input::get('override');
            
            $info = \App\instructors_infos::where('instructor_id',$instructor)->first();
            
            $load_units = \App\UnitsLoad::where('instructor_id',$instructor)->first();
            $load_units->units = $override;
            $load_units->update();
            
            $schedules = \App\room_schedules::where('offering_id',$offering_id)->get();
            if(!$schedules->isEmpty()){
                foreach($schedules as $schedule){
                    $conflict = \App\room_schedules::distinct()
                            ->where('instructor',$instructor)
                            ->where('day',$schedule->day)
                            ->where(function($query) use ($schedule) {
                                $query->whereBetween('time_starts', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))))
                                ->orwhereBetween('time_end', array(date("H:i:s", strtotime($schedule->time_starts)), date("H:i:s", strtotime($schedule->time_end))));
                            })
                            ->get(['offering_id']);
                    if($conflict->isEmpty()){
                        $schedule->instructor = $instructor;
                        $schedule->update();
                    }else{
                        $rollback_schedules = \App\room_schedules::where('offering_id',$schedule->offering_id)->get();
                        if(!$rollback_schedules->isEmpty()){
                            foreach($rollback_schedules as $rollback){
                                $rollback->instructor = NULL;
                                $rollback->update();
                            }
                            abort(500);
                            //HTTP Error 500 para kapag may nakitang conflict alert conflict. Naaadd pa din yung schedule
                            // kaso pag nakapasok sa rollback schedules inupdate ko ulit na parnag walang nangyari.
                        }
                    }
                }
            }
        
        }
    }
}
