<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddCurriculumController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
    }

    function index() {
          return view('/admin/curriculum_management/add_curriculum');
                
        }
    function upload_backup2(Request $request){
        if(Auth::user()->accesslevel == env('REG_COLLEGE')){
            $row = 2;
            $path = Input::file('import_file')->getRealPath();
            Excel::selectSheets('Sheet1')->load($path, function($reader) use ($row) {
                $uploaded = array();
                do {
                    $curriculum_year = $reader->getActiveSheet()->getCell('A' . $row)->getValue();
                    $period = $reader->getActiveSheet()->getCell('B' . $row)->getValue();
                    $level = $reader->getActiveSheet()->getCell('C' . $row)->getValue();
                    $program_code = $reader->getActiveSheet()->getCell('D' . $row)->getValue();
                    $course_code = $reader->getActiveSheet()->getCell('E' . $row)->getValue();
                    $course_name = $reader->getActiveSheet()->getCell('F' . $row)->getValue();
                    $lec = $reader->getActiveSheet()->getCell('G' . $row)->getValue();
                    $lab = $reader->getActiveSheet()->getCell('H' . $row)->getValue();
                    $units = $reader->getActiveSheet()->getCell('I' . $row)->getValue();

                    $uploaded[] = array(
                        'curriculum_year' => $curriculum_year, 
                        'period' => $period, 
                        'level' => $level, 
                        'program_code' => $program_code, 
                        'course_code' => $course_code, 
                        'course_name' => $course_name, 
                        'lec' => $lec,
                        'lab' => $lab,
                        'units' => $units);
                    $row++;
                } while (strlen($reader->getActiveSheet()->getCell('B' . $row)->getValue()) > 6);

                session()->flash('upload', $uploaded);
            });

            $upload = session('upload');
            return view ('reg_college.curriculum_management.upload_curriculum',compact('upload'));
        }else{
            return view('layouts.401');
        }
    }
    
    function save_changes(Request $request){
        if(Auth::user()->accesslevel == env('REG_COLLEGE')){
            for($x=0;$x<=count($request->curriculum_year);$x++){
                if(array_key_exists($x, $request->curriculum_year)){
                    $curricula = new \App\curriculum;
                    $curricula->curriculum_year = $request->curriculum_year[$x];
                    $curricula->program_code = $request->program_code[$x];
                    $curricula->program_name = \App\CtrAcademicProgram::where('program_code',$request->program_code[$x])->first()->program_name;
                    $curricula->control_code = $request->course_code[$x];
                    $curricula->course_code = $request->course_code[$x];
                    $curricula->course_name = $request->course_name[$x];
                    $curricula->lec = $request->lec[$x];
                    $curricula->lab = $request->lab[$x];
                    $curricula->units = $request->units[$x];
                    $curricula->level = $request->level[$x];
                    $curricula->period = $request->period[$x];
                    $curricula->percent_tuition = 100;
                    $curricula->is_complab = 0;
                    $curricula->save();
                }
            }
            
            Session::flash('success','Successfully Saved!');
            Log::info('User '.Helper::getName(Auth::user()->idno)." uploaded a new curriculum");
            Helper::addLogs('User '.Helper::getName(Auth::user()->idno)." uploaded a new curriculum");
            
            return redirect(url('/registrar_college/curriculum_management/curriculum'));
        }else{
            return view('layouts.401');
        }
    }
    
    function upload_backup(Request $request) {
        if (Auth::user()->accesslevel == env('REG_COLLEGE')) {
            $row = 9;
            $path = Input::file('import_file')->getRealPath();
//            Excel::selectSheets('curriculum')->load($path, function($reader) use ($row) {
//                $uploaded = array();
//                do {
//                    $course_code = $reader->getActiveSheet()->getCell('A' . $row)->getValue();
//                    $course_name = $reader->getActiveSheet()->getCell('B' . $row)->getValue();
//                    $lec = $reader->getActiveSheet()->getCell('G' . $row)->getValue();
//                    $lab = $reader->getActiveSheet()->getCell('H' . $row)->getValue();
//                    $hours = $reader->getActiveSheet()->getCell('I' . $row)->getValue();
//
//                    $uploaded[] = array('course_code' => $course_code, 'course_name' => $course_name, 'lec' => $lec, 'lab' => $lab, 'hours' => $hours);
//                    $row++;
//                } while (strlen($reader->getActiveSheet()->getCell('A' . $row)->getValue()) > 1);
//
//                session()->flash('courses', $uploaded);
//            });

            Excel::selectSheets('curriculum')->load($path, function($reader) {

                $program_code = $reader->getActiveSheet()->getCell('B1')->getValue();

                session()->flash('program_codes', $program_code);
            });

            Excel::selectSheets('curriculum')->load($path, function($reader) {

                $program_name = $reader->getActiveSheet()->getCell('B2')->getValue();

                session()->flash('program_name', $program_name);
            });
            
            Excel::selectSheets('curriculum')->load($path, function($reader) {

                $curriculum_year = $reader->getActiveSheet()->getCell('B3')->getValue();

                session()->flash('curriculum_year', $curriculum_year);
            });

            //$courses = session('courses');
            $program_codes = session('program_codes');
            $program_names = session('program_name');
            $curriculum_years = session('curriculum_year');

            return view('registrar_college.curriculum_management.upload', compact('program_codes', 'program_names', 'curriculum_years'));
//            return view('registrar.grades.upload_grade', compact('grades', 'course', 'prof', 'request'));
        }else{
            return view('layouts.401');
        }
    }
}
