<?php

namespace App\Http\Controllers\Users\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Helper;


class AddNewInstructorController extends Controller
{
    //
        //
    public function __construct() {
        $this->middleware('auth');
    }

    function index() {
        if (Auth::user()->accesslevel == env('REG_COLLEGE') || Auth::user()->accesslevel == env("DEAN")) {
            return view('/admin/instructor/add_instructor');
        }else{
            return view('layouts.401');
        }
    }

    function view_add() {
        if (Auth::user()->accesslevel == env('REG_COLLEGE') || Auth::user()->accesslevel == env("DEAN")) {
            return view('reg_college.instructor.view_add_instructor');
        }else{
            return view('layouts.401');
        }
    }

    function add(Request $request) {
        if (Auth::user()->accesslevel == env('REG_COLLEGE') || Auth::user()->accesslevel == env("DEAN")) {
            
            $validate = $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'municipality' => 'nullable',
                'province' => 'nullable',
                'birthdate' => 'nullable',
                'gender' => 'nullable',
                'email' => 'nullable|unique:users',
                'employee_type' => 'nullable',
                'idno' => 'required|unique:users',
            ]);

            if($validate){
            return $this->create_new_instructor($request);
            }else{
                Session::flash('error','Message');
                return redirect(url('/registrar_college/instructor/view_instructor'));
            }
        }else{
            return view('layouts.401');
        }
    }

    function create_new_instructor($request) {
        DB::beginTransaction();
        $this->adduser($request);
        $this->addinstructorinfo($request);
        DB::commit();
        Session::flash('success','Instructor Added!');
        Log::info("Instructor Account of ".$request->lastname.", ".$request->firstname." added by ".Auth::user()->lastname.", ".Auth::user()->firstname);
        Helper::addLogs("Instructor Account of ".$request->lastname.", ".$request->firstname." added by ".Auth::user()->lastname.", ".Auth::user()->firstname);
        return redirect(url('/registrar_college/instructor/view_instructor'));
    }

    function adduser($request) {
        $add_new_user = new \App\User;
        $add_new_user->idno = $request->idno;
        $add_new_user->firstname = $request->firstname;
        $add_new_user->middlename = $request->middlename;
        $add_new_user->lastname = $request->lastname;
        $add_new_user->extensionname = $request->extensionname;
        $add_new_user->accesslevel = 1;
        $add_new_user->status = 1; //active or not
        $add_new_user->email = $request->email;
        $add_new_user->password = bcrypt($request->password);
        $add_new_user->save();
    }

    function addinstructorinfo($request) {
        $add_info = new \App\InstructorsInfo;
        $add_info->idno = $request->idno;
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

    function view_modify($idno) {
        if (Auth::user()->accesslevel == env('REG_COLLEGE') || Auth::user()->accesslevel == env("DEAN")) {
            $user_info = \App\User::where('idno', $idno)->first();
            $instructor_info = \App\InstructorsInfo::where('idno', $idno)->first();

            return view('reg_college.instructor.view_modify', compact('user_info', 'instructor_info', 'idno'));
        }
}
}

 