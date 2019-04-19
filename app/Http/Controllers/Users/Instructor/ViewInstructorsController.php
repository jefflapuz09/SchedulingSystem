<?php

namespace App\Http\Controllers\Users\Instructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ViewInstructorsController extends Controller
{
       //
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
        $this->middleware('admin');
        
    }

    function index() {
      
            return view('/admin/instructor/add_instructor');
        
    }

    function view_add() {
        
            $instructors = \App\User::where('accesslevel',1)->get();
            return view('/admin/instructor/view_instructor',compact('instructors'));
        
    }
    
    function view_info($id){
       
            $user = \App\User::find($id);
            $info = \App\instructors_infos::where('instructor_id',$id)->first();
            return view('/admin/instructor/view_info',compact('user','info'));
        
    }

    function add(Request $request) {
        
           $this->create_new_instructor($request);
           Session::flash('success','Instructor Added!');
           return redirect(url('/admin/instructor/add_instructor'));
        
    }

    function create_new_instructor($request) {
        DB::beginTransaction();
        $this->adduser($request);
        $this->addinstructorinfo($request);
        $this->addload($request);
        DB::commit();
        
    }
    
    function addload($request){
        $user = \App\User::orderBy('id','DESC')->first()->id;
        $info = \App\instructors_infos::where('instructor_id',$user)->first()->employee_type;
        
        $record = new \App\UnitsLoad;
        $record->instructor_id = $user;
        $record->employee_type = $info;
        if($info == 'Full Time'){
            $record->units = 36;
        }else{
            $record->units = 15;
        }
        $record->save();
    }

    function adduser($request) {
        $add_new_user = new \App\user;
        $add_new_user->username=$request->username;
        $add_new_user->name=$request->name;
        $add_new_user->middlename=$request->middlename;
        $add_new_user->lastname=$request->lastname;
        $add_new_user->extensionname=$request->extensionname;        
        $add_new_user->accesslevel = 1;
        $add_new_user->email=$request->email;   
        $add_new_user->password=bcrypt($request->password);
        $add_new_user->save();
    }

    function addinstructorinfo($request) {
        $add_info = new \App\instructors_infos;
        $add_info->instructor_id = \App\User::orderBy('id','DESC')->first()->id;
        $add_info->college=$request->college;
        $add_info->department=$request->department;
        $add_info->gender=$request->gender;
        $add_info->street=$request->street; 
        $add_info->barangay=$request->barangay;
        $add_info->municipality=$request->municipality;
        $add_info->tel_no=$request->tel_no;
        $add_info->cell_no=$request->cell_no;   
        $add_info->degree_status=$request->degree_status;
        $add_info->program_graduated=$request->program_graduated;
        $add_info->employee_type = $request->employee_type;
        $add_info->save();
    }

    function view_modify($idno) {
       
            $user_info = \App\User::where('idno', $idno)->first();
            $instructor_info = \App\InstructorsInfo::where('idno', $idno)->first();

            return view('reg_college.instructor.view_modify', compact('user_info', 'instructor_info', 'idno'));
       
    }

    function modify(Request $request) {
       
            $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'municipality' => 'nullable',
                'province' => 'nullable',
                'birthdate' => 'nullable',
                'gender' => 'nullable',
                'email' => 'nullable',
                'employee_type' => 'nullable',
                'idno' => 'required',
            ]);

            return $this->modify_old_instructor($request);
        
    }

    function modify_old_instructor($request) {
        Log::warning("Account of ".$request->lastname.", ".$request->firstname." has been updated by ".Auth::user()->lastname.", ".Auth::user()->firstname);
        Helper::addLogs("Account of ".$request->lastname.", ".$request->firstname." has been updated by ".Auth::user()->lastname.", ".Auth::user()->firstname);
        DB::beginTransaction();
        $this->modifyuser($request);
        $this->modifyinstructorinfo($request);
        DB::commit();

        return redirect(url('registrar_college', array('instructor', 'view_instructor')));
    }
    
    function modifyuser($request){
        $idno = $request->idno;

        $modify_user = \App\User::where('idno', $idno)->first();
        $modify_user->firstname = $request->firstname;
        $modify_user->middlename = $request->middlename;
        $modify_user->lastname = $request->lastname;
        $modify_user->extensionname = $request->extensionname;
        $modify_user->accesslevel = 1;
        $modify_user->status = 1; //active or not
        $modify_user->email = $request->email;
        $modify_user->password = bcrypt($request->password);
        $modify_user->save();      
    }
    
    function modifyinstructorinfo($request){
        $idno = $request->idno;

        $add_info = \App\InstructorsInfo::where('idno', $idno)->first();
        $add_info->employment_status = $request->employment_status;
        $add_info->academic_type = $request->academic_type;
        $add_info->college = $request->college;
        $add_info->department = $request->department;
        $add_info->birthdate = $request->birthdate;
        $add_info->place_of_birth = $request->place_of_birth;
        $add_info->gender = $request->gender;
        $add_info->civil_status = $request->civil_status;
        $add_info->nationality = $request->nationality;
        $add_info->religion = $request->religion;
        $add_info->street = $request->street;
        $add_info->barangay = $request->barangay;
        $add_info->municipality = $request->municipality;
        $add_info->province = $request->province;
        $add_info->zip = $request->zip;
        $add_info->tel_no = $request->tel_no;
        $add_info->cell_no = $request->cell_no;
        $add_info->degree_status = $request->degree_status;
        $add_info->program_graduated = $request->program_graduated;
        $add_info->employee_type = $request->employee_type;
        $add_info->save();        
    }
    
    function updateinstructor($id, Request $request){
        $this->validate($request, [
        ]);
        
        $updateinstructor = \App\User::find($id);
        $updateinstructor->username = $request->username;
        $updateinstructor->name = $request->name;
        $updateinstructor->middlename = $request->middlename;
        $updateinstructor->lastname = $request->lastname;
        $updateinstructor->extensionname = $request->extensionname;
        $updateinstructor->update();
        
        $updateinfo = \App\instructors_infos::where('instructor_id', $id)->first();
        $updateinfo->street = $request->street;
        $updateinfo->barangay = $request->barangay;
        $updateinfo->municipality = $request->municipality;
//        $updateinfo->province = $request->province;
        $updateinfo->gender = $request->gender;
        $updateinfo->tel_no = $request->tel_no;
        $updateinfo->cell_no = $request->cell_no;
        $updateinfo->college = $request->college;
        $updateinfo->department = $request->department;
        $updateinfo->employee_type = $request->employee_type;
        $updateinfo->update();
        
        $load = \App\UnitsLoad::where('instructor_id', $id)->first();
        $load->employee_type = $request->employee_type;
        $load->update();
        
        return redirect(url('/admin/instructor/view_instructor_account'));
        
    }

    function edityear(){
        $curriculum_year = Input::get('curriculum_year');
        $program_code = Input::get('program_code');
        $edityear = \App\curriculum::where('program_code',$program_code)->where('curriculum_year',$curriculum_year)->first();
        return view('admin.curriculum_management.ajax.edityear', compact('edityear','program_code','curriculum_year'));

    }
    
    function updateyear(){
        $curriculum_year = Input::get('curriculum_year');
        $program_code = Input::get('program_code');
        $year_val = Input::get('year_val');
        
        $edityear = \App\curriculum::where('program_code',$program_code)->where('curriculum_year',$curriculum_year)->get();
        if(count($edityear)){
            foreach($edityear as $year){
                $year->curriculum_year = $year_val;
                $year->update();
            }
        }        
    }
    
    function refreshcurriculum(){
        $curriculum_year = Input::get('curriculum_year');
        $program_code = Input::get('program_code');
        $program = \App\academic_programs::where('program_code',$program_code)->first();
        $curricula = \App\curriculum::distinct()->where('program_code',$program_code)->where('curriculum_year',$curriculum_year)->get(['program_code','curriculum_year']);
        return view('admin.curriculum_management.ajax.refresh_curriculum',compact('curricula','program','program_code'));
    }
    
    
}
