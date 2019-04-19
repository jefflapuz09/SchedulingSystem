<?php

namespace App\Http\Controllers\Instructor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class FacultyLoading extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkIfActivated');
    }
    
    function faculty_loading(){
        if(Auth::user()->accesslevel == 1){
            return view('instructor.faculty_loading.faculty_loading');
        }
    }
}
