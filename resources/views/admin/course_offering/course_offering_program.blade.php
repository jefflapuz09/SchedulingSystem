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
<link rel="stylesheet" href="{{asset('plugins/select2/select2.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/toastr/toastr.css')}}">
<section class="content-header">
      <h1><i class="fa  fa-hourglass-half"></i>  
        Course Offering
        <small>{{$program_code}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Curriculum Management</li>
        <li class="active">Course Offerings</li>
      </ol>
</section>


<div class="container-fluid" style="margin-top: 15px;">
    <div class="row">
        <div class="col-sm-5">
            <div class="box box-solid box-default">
                <div class="box-header bg-navy-active">
                    <h5 class="box-title">{{$program->program_name}}</h5>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Level</label>
                        <select class="select2 form-control" onchange="getsections(this.value)">
                            <option>Please Select</option>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                            
                        </select>
                    </div>
                    <div class="form-group" id="displaysections">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="box box-default" id="displaysearchcourse">
                <div class="box-header">
                    <h5 class="box-title">Search Course</h5>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Curriculum Year</label>
                                <select class="form-control" id='cy'>
                                    @foreach($curriculum_year as $cy)
                                    <option value="{{$cy->curriculum_year}}">{{$cy->curriculum_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Level</label>
                                <select class="form-control" id='level'>
                                    <option>1st Year</option>
                                    <option>2nd Year</option>
                                    <option>3rd Year</option>
                                    <option>4th Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Period</label>
                                <select class="form-control" id='period'>
                                    <option>1st Semester</option>
                                    <option>2nd Semester</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-flat btn-block btn-success" onclick='searchcourse(cy.value,level.value,period.value,section_name.value)'>Search</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6" id="displaycourses">
            
        </div>
        <div class="col-sm-6" id="displayoffered"></div>
    </div>
</div>
@endsection 

@section('footer-script')
<script src="{{asset('plugins/select2/select2.css')}}"></script>
<script>
    function getsections(level){
        var array = {};
        array['level'] = level;
        array['program_code'] = "{{$program_code}}";
        $.ajax({
            type: "GET",
            url: "/ajax/admin/course_offerings/get_sections",
            data: array,
            success: function(data){
                $('#displaysections').html(data).fadeIn();
                $('#displaysearcourse').fadeIn();
            }
        })
    }
    
    
    function searchcourse(cy,level,period,section_name){
        var array = {};
        array['cy'] = cy;
        array['level'] = level;
        array['period'] = period;
        array['section_name'] = section_name;
        array['program_code'] = "{{$program_code}}";
        if(section_name != ""){
            $.ajax({
                type: "GET",
                url: "/ajax/admin/course_offerings/get_courses",
                data: array,
                success: function(data){
                    $('#displaycourses').html(data).fadeIn();
                    searchoffering(cy,level,period,section_name)
                }, error: function(){

                }
            })
        }else{
            toastr.error('Please input a section','Notification!');
        }
    }
    
    function searchoffering(cy,level,period,section_name){
        var array = {};
        array['cy'] = cy;
        array['level'] = level;
        array['period'] = period;
        array['section_name'] = section_name;
        $.ajax({
            type: "GET",
            url: "/ajax/admin/course_offerings/get_courses_offered",
            data: array,
            success: function(data){
                $('#displayoffered').html(data).fadeIn();
            }, error: function(){
                
            }
        })
    }
</script>
@endsection
