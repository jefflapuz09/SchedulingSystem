<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class FacultyLoadingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function faculty_loading(){
       
           $instructors = \App\User::where('accesslevel',1)->get();
           return view('admin.faculty_loading.faculty_loading',compact('instructors'));
       
    }
    
    function generate_schedule($instructor){
        
            $schedules = \App\room_schedules::distinct()->where('is_active',1)
                    ->where('instructor',$instructor)
                    ->get();
            
            return view('admin.faculty_loading.generate_schedule',compact('schedules','instructor'));
    }
    
    function instructorlist_reports($instructor){
        $schedules = $this->getFullCalendar($instructor);
        return view('admin.instructor.edit_faculty_loading',compact('schedules','instructor'));
    }
    
    function getFullCalendar($instructor){
        $schedules = \App\room_schedules::where('is_active',1)->where('instructor',$instructor)->get();
         if(!$schedules->isEmpty()){
            foreach($schedules as $sched){
                $course_detail = \App\curriculum::join('offerings_infos','offerings_infos.curriculum_id','curricula.id')
                        ->where('offerings_infos.id',$sched->offering_id)->first(['curricula.course_code','offerings_infos.section_name']);
                if($sched->day == 'M'){
                    $day = 'Monday';
                }else if($sched->day == 'T'){
                    $day = 'Tuesday';
                }else if($sched->day == 'W'){
                    $day = 'Wednesday';
                }else if($sched->day == 'Th'){
                    $day = 'Thursday';
                }else if($sched->day == 'F'){
                    $day = 'Friday';
                }else if($sched->day == 'Sa'){
                    $day = 'Saturday';
                }else if($sched->day == 'Su'){
                    $day = 'Sunday';
                }

                if($sched->is_loaded == 1){
                    $color = "lighblue";
                }else{
                    $color = "lightsalmon";
                }

                $event_array[] = array(
                    'id' => $sched->id,
                    'title' => $course_detail->course_code.'<br>'.$sched->room.'<br>'.$course_detail->section_name,
                    'start' => date('Y-m-d', strtotime($day. ' this week')).'T'.$sched->time_starts,
                    'end' => date('Y-m-d', strtotime($day. ' this week')).'T'.$sched->time_end,
                    'color' => $color,
                    "textEscape"=> 'false' ,
                    'textColor' => 'black',
                    'offering_id' => $sched->offering_id
                );
            }
            $get_schedule = json_encode($event_array);
        }else{
            $get_schedule = NULL;
        }
        
        return $get_schedule;
    }
}
