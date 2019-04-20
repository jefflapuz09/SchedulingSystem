<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Helper;
use Illuminate\Support\Facades\Redirect;

class CurriculumController extends Controller {     

   public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }

    function index() {
        return view('/admin/curriculum_management/curriculum');
    }
    
    function edit_curriculum(Request $request){
            $curriculum = \App\curriculum::find($request->curriculum_id);
            $curriculum->course_code = $request->course_code;
            $curriculum->course_name = $request->course_name;
            $curriculum->lec = $request->lec;
            $curriculum->lab = $request->lab;
            $curriculum->units = $request->units;
            $curriculum->is_complab = $request->complab;
            $curriculum->update();
            
            Session::flash('success','Successfully modified '.$request->course_code);
            return redirect(url('/admin/curriculum_management/list_curriculum',array($curriculum->program_code,$curriculum->curriculum_year)));
    }

    function viewcurricula($program_code) {
        
            $curricula = \App\curriculum::distinct()->where('program_code', $program_code)->get(['curriculum_year']);
            return view('/admin/curriculum_management/view_curriculums', compact('curricula', 'program_code'));

    }

    function listcurriculum($program_code, $curriculum_year) {
       
            return view('/admin/curriculum_management/list_curriculum', compact('program_code', 'curriculum_year'));
    }
    
    function print_curriculum($program_code,$curriculum_year){
        
            $program = \App\CtrAcademicProgram::where('program_code',$program_code)->first();
            $pdf = PDF::loadView('reg_college.curriculum_management.print_curriculum', compact('program_code','curriculum_year','program'));
            $pdf->setPaper('legal','portrait');
            return $pdf->stream("evaluation_form[]].pdf");
        
    }
    
    function add_course(Request $request){
       
            
            $curricula = new \App\curriculum;
            $curricula->curriculum_year = $request->curriculum_year;
            $curricula->program_code = $request->program_code;
            $curricula->program_name = \App\academic_programs::where('program_code',$request->program_code)->first()->program_name;
            $curricula->control_code = $request->course_code;
            $curricula->course_code = $request->course_code;
            $curricula->course_name = $request->course_name;
            $curricula->lec = $request->lec;
            $curricula->lab = $request->lab;
            $curricula->units = $request->units;
            $curricula->level = $request->level;
            $curricula->period = $request->period;
            $curricula->percent_tuition = 100;
            $curricula->is_complab = 0;
            $curricula->save();
                    
            Helper::addLogs('User '.Helper::getName(Auth::user()->idno). "Added a new Course ".$request->course_code." to the Curricula of ".$request->program_code);
            Log::info('User '.Helper::getName(Auth::user()->idno). "Added a new Course ".$request->course_code." to the Curricula of ".$request->program_code);
            Session::flash('success','Successfully Added a Course to the Curriculum of '.$request->program_code);
            return redirect(url('/admin/curriculum_management/curriculum'));
        
    }
    
    function view_course_curriculum($curriculum_id){
        
            $curricula = \App\Curriculum::find($curriculum_id);
            return view('reg_college.curriculum_management.display_course_curriculum',compact('curricula'));
        
    }
    
    function update_course_curriculum(Request $request,$id){
       
            $curricula = \App\Curriculum::find($id);
            $curricula->curriculum_year = $request->curriculum_year;
            $curricula->control_code = $request->course_code;
            $curricula->course_code = $request->course_code;
            $curricula->course_name = $request->course_name;
            $curricula->lec = $request->lec;
            $curricula->lab = $request->lab;
            $curricula->units = $request->units;
            $curricula->display_lec = $request->lec;
            $curricula->display_lab = $request->lab;
            $curricula->display_units = $request->units;
            $curricula->level = $request->level;
            $curricula->period = $request->period;
            $curricula->update();
            
            Helper::addLogs('User '.Helper::getName(Auth::user()->idno). "Modifed a Course ".$request->course_code." to the Curricula");
            Log::info('User '.Helper::getName(Auth::user()->idno). "Modifed Course ".$request->course_code." to the Curricula");
            Session::flash('success','Successfully Modifed a Course to the Curriculum');
            return redirect(url('/registrar_college/curriculum_management/curriculum'));
        
    }
    
    function prerequisites(){
        
            $lists = \App\Prerequisite::all();
            return view('reg_college.curriculum_management.prerequisites',compact('lists'));
        
    }
    
    function post_prerequisites(Request $request){
        
            $check_if_exists = \App\Prerequisite::where('Curriculum_year',$request->curriculum_year)
                    ->where('Course_Code',$request->program_code)
                    ->where('Subject_Code',$request->course_code)
                    ->where('Prerequisite',$request->prerequisite)->get();
            
            if(count($check_if_exists)==0){
                $new =  new \App\Prerequisite;
                $new->Course_Code = $request->program_code;
                $new->Course = \App\CtrAcademicProgram::where('program_code',$request->program_code)->first()->program_name;
                $new->Subject_Code = $request->course_code;
                $new->Prerequisite = $request->prerequisite;
                $new->Curriculum_year = $request->curriculum_year;
                $new->save();
                
                Helper::addLogs(Helper::getName(Auth::user()->idno).' added a prerequisite subject');
                Log::info(Helper::getName(Auth::user()->idno).' added a prerequisite subject');
                Session::flash('success','Added Prerequisite');
                return redirect(url('/registrar_college/curriculum_management/prerequisites'));
            }else{
                Session::flash('error','Prerequisite Already Exists!');
                return Redirect::back();
            }
        
    }

}