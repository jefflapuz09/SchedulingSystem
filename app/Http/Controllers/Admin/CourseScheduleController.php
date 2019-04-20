<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;
use DB;

class CourseScheduleController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function course_schedule(){
        
            $programs = \App\academic_programs::distinct()->get(['program_code','program_name']);
            return view('admin.course_schedule.course_schedule',compact('programs'));
        
    }
    
    function add_schedule($offering_id,$section_name){
            $offering = \App\offerings_infos_table::find($offering_id);
            $curricula = \App\curriculum::find($offering->curriculum_id);
            $inactive = \App\room_schedules::where('is_active',0)->get();
            $get_schedule = $this->getSchedule($offering_id);
            $is_complab = \App\curriculum::find($offering->curriculum_id)->is_complab;
            return view('admin.course_schedule.add_schedule',compact('offering','curricula','inactive','offering_id','get_schedule','section_name','is_complab'));
        
    }
    
    public static function getSchedule($offering_id){
        $event_array = array();
        $schedules = \App\room_schedules::where('offering_id',$offering_id)->get();
        if(!$schedules->isEmpty()){
            foreach($schedules as $sched){
                $course_detail = \App\curriculum::join('offerings_infos','offerings_infos.curriculum_id','curricula.id')
                        ->where('offerings_infos.id',$offering_id)->first(['curricula.course_code','offerings_infos.section_name']);
                if($sched->day == 'M'){
                    $day = 'Monday';
                    $color = 'LightSalmon';
                }else if($sched->day == 'T'){
                    $day = 'Tuesday';
                    $color = 'lightblue';
                }else if($sched->day == 'W'){
                    $day = 'Wednesday';
                    $color = 'LightSalmon';
                }else if($sched->day == 'Th'){
                    $day = 'Thursday';
                    $color = 'lightblue';
                }else if($sched->day == 'F'){
                    $day = 'Friday';
                    $color = 'LightSalmon';
                }else if($sched->day == 'Sa'){
                    $day = 'Saturday';
                    $color = 'lightblue';
                }else if($sched->day == 'Su'){
                    $day = 'LightSalmon';
                }
                $event_array[] = array(
                    'id' => $sched->id,
                    'title' => $course_detail->course_code.'<br>'.$sched->room.'<br>'.$course_detail->section_name,
                    'start' => date('Y-m-d', strtotime($day. ' this week')).'T'.$sched->time_starts,
                    'end' => date('Y-m-d', strtotime($day. ' this week')).'T'.$sched->time_end,
                    'color' => $color,
                    "textEscape"=> 'false' ,
                    'textColor' => 'black',
                    'offering_id' => $offering_id
                );
            }
        }
        return json_encode($event_array);
    }
    
    function add_schedule_post(Request $request){
        
            $offering_id = $request->offering_id;
            $day = $request->day;
            $time_start = $request->time_start;
            $time_end = $request->time_end;
            $section_name = $request->section_name;
            
            $same_sched = DB::table('offerings_infos')
                    ->join('room_schedules','offerings_infos.id','room_schedules.offering_id')
                    ->where('offerings_infos.section_name',$request->section_name)
                    ->where('room_schedules.day',$request->day)
                    ->where('room_schedules.time_starts',date('H:i:s',strtotime($time_start)))
                    ->where('room_schedules.time_end',date('H:i:s',strtotime($time_end)))
                    ->get();
            
            if(count($same_sched)==0){
                $new_schedule = new \App\room_schedules;
                $new_schedule->day = $day;
                $new_schedule->time_starts = date('H:i:s',strtotime($time_start));
                $new_schedule->time_end = date('H:i:s',strtotime($time_end));
                $new_schedule->room = $request->room;
                $new_schedule->offering_id = $offering_id;
                $new_schedule->save();

                Session::flash('success','Successfully in creating a schedule!');
                return redirect(url('/admin/course_scheduling/schedule',array($offering_id,$section_name)));
            }else{
                Session::flash('error','Same Schedule Found!');
                return redirect(url('/admin/course_scheduling/schedule',array($offering_id,$section_name)));
            }
            
        
    }
    
    function remove_schedule($schedule_id,$offering_id){
        
            
            $offering = \App\offerings_infos_table::find($offering_id);
            
            $schedule = \App\room_schedules::find($schedule_id);
            $schedule->is_active = 0;
            $schedule->offering_id = NULL;
            $schedule->update();
            
            Session::flash('error','Changed the status of the schedule!');
            return redirect(url('/admin/course_scheduling/schedule',array($offering_id,$offering->section_name)));
        
    }
    
    function attach_schedule($schedule_id,$offering_id){
        
            
            $offering = \App\offerings_infos_table::find($offering_id);
            
            $schedule = \App\room_schedules::find($schedule_id);
            $schedule->is_active = 1;
            $schedule->offering_id = $offering_id;
            $schedule->update();
            
            Session::flash('success','Successfully in attaching the schedule!');
            return redirect(url('/admin/course_scheduling/schedule',array($offering_id,$offering->section_name)));
        
    }
    
    function delete_schedule($schedule_id,$offering_id){
        
            
            $offering = \App\offerings_infos_table::find($offering_id);
            
            $schedule = \App\room_schedules::find($schedule_id);
            $schedule->delete();
            
            Session::flash('error','Deleted the schedule!');
            return redirect(url('/admin/course_scheduling/schedule',array($offering_id,$offering->section_name)));
        
    }
}
