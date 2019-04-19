<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
Use Illuminate\Support\Facades\DB;
use Request;


class CourseOfferingAjax extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function get_sections(){
        if(Request::ajax()){
            $level = Input::get('level');
            $program_code = Input::get('program_code');
            
            $sections = \App\CtrSection::where('level',$level)
                    ->where('is_active',1)->where('program_code',$program_code)
                    ->get();
            
            return view('admin.course_offering.ajax.get_sections',compact('sections'))->render();
        }
    }
    
    function edit_modal(){
        if(Request::ajax()){
            $curriculum_id = Input::get('curriculum_id');
            $course = \App\curriculum::find($curriculum_id);
            
            return view('admin.curriculum_management.edit_curriculum',compact('course'));
        }
    }
    
    function get_courses(){
        if(Request::ajax()){
            $curriculum_year = Input::get('cy');
            $level = Input::get('level');
            $period = Input::get('period');
            $section_name = Input::get('section_name');
            $program_code = Input::get('program_code');
            
            $offered = \App\offerings_infos_table::where('section_name',$section_name)->get();
            $courses = \App\curriculum::where('program_code',$program_code)->where('curriculum_year',$curriculum_year)
                    ->where('level',$level)->where('period',$period)
                    ->whereNotIn('id',$offered->pluck('curriculum_id')->toArray())->get();
            
            return view('admin.course_offering.ajax.get_courses',compact('courses','section_name','level','period','curriculum_year'))->render();
        }
    }
    
    function get_courses_offered(){
        if(Request::ajax()){
            $curriculum_year = Input::get('cy');
            $level = Input::get('level');
            $period = Input::get('period');
            $section_name = Input::get('section_name');
            
            $offerings = \App\offerings_infos_table::where('section_name',$section_name)
                    ->get();
            
            return view('admin.course_offering.ajax.get_courses_offered',compact('offerings','section_name','curriculum_year','level','period'))->render();
        }
    }
    
    function add_course_offer(){
        if(Request::ajax()){
            $section_name = Input::get('section_name');
            $curriculum_id = Input::get('course_id');
            
            $check_if_exists = \App\offerings_infos_table::
                    where('curriculum_id',$curriculum_id)->where('section_name',$section_name)
                    ->get();
            
            $curriculum = \App\curriculum::find($curriculum_id);
            if($check_if_exists->isEmpty()){
                $offering = new \App\offerings_infos_table;
                $offering->curriculum_id = $curriculum_id;
                $offering->section_name = $section_name;
                $offering->level = $curriculum->level;
                $offering->save();
                return 'Offered Subject!';
            }else{
                return 'Offered Subject Already Exists!';
            }
        }
    }
    
    function remove_course_offer(){
        if(Request::ajax()){
            
            $section_name = Input::get('section_name');
            $curriculum_id = Input::get('curriculum_id');
           
            $check_if_exists = \App\offerings_infos_table::
                    where('curriculum_id',$curriculum_id)->where('section_name',$section_name)
                    ->first(); 
            $check_if_exists->delete();
            return 'Removed Course Offered!';
           
        }
    }
    
    function edit_section(){
        if(Request::ajax()){
            $section_id = Input::get('section_id');
            
            $section = \App\CtrSection::find($section_id);
            $programs = \App\academic_programs::distinct()->get(['program_code','program_name']);
            return view('admin.course_offering.ajax.edit_section',compact('section','programs'));
        }
    }
    
    function edit_room(){
        if(Request::ajax()){
            $room_id = Input::get('room_id');
            
            $room = \App\CtrRoom::find($room_id);
            $programs = \App\academic_programs::distinct()->get(['program_code','program_name']);
            return view('admin.course_offering.ajax.edit_room',compact('room','programs'));
        }
    }
}
