<?php 
$layout = "";

if(Auth::user()->is_first_login == 1){
    $layout = 'layouts.first_login';
}else{
    if(Auth::user()->accesslevel == 100){
        $layout = 'layouts.superadmin';
    }elseif(Auth::user()->accesslevel == 1){
        $layout = 'layouts.instructor';
    }elseif(Auth::user()->accesslevel == 0){
        $layout = 'layouts.admin';
    }
}


?>
@extends($layout)

@section('main-content')
<section class="content-header">
      <h1><i class="fa  fa-spinner"></i>  
        Course Scheduling
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Academic Programs</li>
      </ol>
</section>


<div class="container-fluid" style="margin-top: 15px;">
    <div class="box box-default">
        <div class="box-header">
            <h5 class="box-title">Academic Programs</h5>
        </div>
        <div class="box-body">
            <div class='row'>
                <div class='col-sm-4'>
                    <div class='form-group'>
                        <label>Academic Program</label>
                        <select class='select2 form-control' id='program_code'>
                            <option>Please Select</option>
                            @foreach($programs as $program)
                            <option value='{{$program->program_code}}'>{{$program->program_code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='col-sm-4'>
                    <div class='form-group' id='displaylevel'>
                        <label>Level</label>
                        <select class='select2 form-control' id='level' onchange='getsection(program_code.value,this.value)'>
                            <option>Please Select</option>
                            <option value='1st Year'>1st Year</option>
                            <option value='2nd Year'>2nd Year</option>
                            <option value='3rd Year'>3rd Year</option>
                            <option value='4th Year'>4th Year</option>
                        </select>
                    </div>
                </div>
                <div class='col-sm-4'  id='displaysection'><div ></div></div>
            </div>
        </div>
    </div>
    <div id='displayoffered'></div>
</div>
@endsection

@section('footer-script')
<script>
    $(document).ready(function(){
        $('#displaylevel').hide();
        
        $('#program_code').on('change',function(){
            $('#displaylevel').fadeIn();
        })
    })
    
    
    function getsection(program_code,level){
        var array = {};
        array['program_code'] = program_code;
        array['level'] = level;
        $.ajax({
            type: "GET",
            url: "/ajax/admin/course_scheduling/get_sections",
            data: array,
            success: function(data){
                $('#displaysection').html(data).fadeIn();
                $('.select2').select2();
            }
        })
    }
    
    function getcoursesoffered(program_code,level,section_name){
        var array = {};
        array['program_code'] = program_code;
        array['level'] = level;
        array['section_name'] = section_name;
        $.ajax({
            type: "GET",
            url: "/ajax/admin/course_scheduling/get_courses_offered",
            data: array,
            success: function(data){
                $('#displayoffered').html(data).fadeIn();
            }
        })
    }
</script>
@endsection
