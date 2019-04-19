<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
Use Illuminate\Support\Facades\Session;

class CourseOfferingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }
    
    function course_offering_index(){
        $programs = \App\academic_programs::distinct()->get(['program_code','program_name']);
        return view('admin.course_offering.course_offering',compact('programs'));
    }
    
    function course_offering_program($program_code){
        $program = \App\academic_programs::where('program_code',$program_code)->first();
        $curriculum_year = \App\curriculum::distinct()->where('program_code',$program_code)->get(['curriculum_year']);
        $sections = \App\CtrSection::where('program_code',$program_code)->where('is_active',1)->get();
        return view('admin.course_offering.course_offering_program',compact('curriculum_year','program_code','program','sections'));
    }
    
    function section_management(){
        $sections = \App\CtrSection::where('is_active',1)->get();
        $programs = \App\academic_programs::distinct()->get(['program_code','program_name']);
        return view('admin.course_offering.section_management',compact('sections','programs'));
    }
    
    function section_management_archive(){
        $sections = \App\CtrSection::where('is_active',0)->get();
        return view('admin.course_offering.section_management_archive',compact('sections'));
    }
    
    function new_section(Request $request){
            
        $check_exists = \App\CtrSection::where('program_code',$request->program_code)
                ->where('level',$request->level)->where('section_name',$request->section_name)
                ->get();
        if($check_exists->isEmpty()){
            $new_section = new \App\CtrSection;
            $new_section->program_code = $request->program_code;
            $new_section->level = $request->level;
            $new_section->section_name = $request->section_name;
            $new_section->is_active = 1;
            $new_section->save();
            Session::flash('success','Successfully saved the record!');
            return redirect(url('/admin/section_management'));
        }else{
            Session::flash('error','Section Already Exists! Please Try Again!');
            return redirect(url('/admin/section_management'));
        }
    }
    
    function archive_section($section_id){
            $archive = \App\CtrSection::find($section_id);
            if($archive->is_active == 1){
                $archive->is_active = 0;
                $archive->update();
                Session::flash('error','Section '.$archive->section_name. " has been moved to the archive section.");
                return redirect(url('/admin/section_management'));
            }else{
                $archive->is_active = 1;
                $archive->update();
                Session::flash('success','Section '.$archive->section_name. " has been restored.");
                return redirect(url('/admin/section_management'));
            }
    }
    
    function update_section(Request $request){
            $section = \App\CtrSection::find($request->section_id);
            $section->program_code = $request->program_code;
            $section->level = $request->level;
            $section->section_name = $request->section_name;
            $section->update();
            Session::flash('success','Successfully updated the record!');
            return redirect(url('/admin/section_management'));
    }
    
    function room_management(){
            $rooms = \App\CtrRoom::where('is_active',1)->get();
            $programs = \App\academic_programs::distinct()->get(['program_code','program_name']);
            return view('admin.course_offering.room_management',compact('rooms','programs'));
    }
    
    function room_management_archive(){
            $rooms = \App\CtrRoom::where('is_active',0)->get();
            return view('admin.course_offering.room_management_archive',compact('rooms'));
    }
    
    function new_room(Request $request){
            
            $check_exists = \App\CtrRoom::where('room',$request->room)
                    ->where('building',$request->building)
                    ->get();
            if($check_exists->isEmpty()){
                $new_room = new \App\CtrRoom;
                $new_room->room = $request->room;
                $new_room->building = $request->building;
                $new_room->description = $request->description;
                $new_room->is_active = 1;
                $new_room->save();
                Session::flash('success','Successfully saved the record!');
                return redirect(url('/admin/room_management'));
            }else{
                Session::flash('error','Room Already Exists! Please Try Again!');
                return redirect(url('/admin/room_management'));
            }
    }
    
    function archive_room($room_id){
            $archive = \App\CtrRoom::find($room_id);
            if($archive->is_active == 1){
                $archive->is_active = 0;
                $archive->update();
                Session::flash('error',$archive->room. " has been moved to the archive section.");
                return redirect(url('/admin/room_management'));
            }else{
                $archive->is_active = 1;
                $archive->update();
                Session::flash('success',$archive->room. " has been restored.");
                return redirect(url('/admin/room_management'));
            }
    }
    
    function update_room(Request $request){
            $room = \App\CtrRoom::find($request->room_id);
            $room->room = $request->room;
            $room->building = $request->building;
            $room->description = $request->description;
            $room->update();
            Session::flash('success','Successfully updated the record!');
            return redirect(url('/admin/room_management'));
    }
}
