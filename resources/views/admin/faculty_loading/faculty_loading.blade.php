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
<link rel='stylesheet' href='{{asset('plugins/select2/select2.css')}}'>
<link rel="stylesheet" href="{{ asset ('plugins/toastr/toastr.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/fullcalendar/fullcalendar.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/datatables/jquery.dataTables.css')}}">
<section class="content-header">
      <h1><i class="fa fa-calendar "></i>
        Faculty Loading
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Faculty Loading</li>
      </ol>
</section>


<div class="container-fluid" style="margin-top: 15px;">
    <div class="box box-danger">
        <div class="box-header">
            <h5 class="box-title">Search by Instructor</h5>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group" id="displaylevel">
                        <label>Level</label>
                        <select class="select2 form-control" id="level">
                            <option>Please Select</option>
                            <option value="1st Year">1st Year</option>
                            <option value="2nd Year">2nd Year</option>
                            <option value="3rd Year">3rd Year</option>
                            <option value="4th Year">4th Year</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" id="displayinstructor">
                        <label>Instructor</label>
                        <select class="select2 form-control" id="instructor">
                            <option>Please Select</option>
                            @foreach($instructors as $instructor)
                            <option value="{{$instructor->id}}">{{strtoupper($instructor->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-sm-4" id="displaysearch">
                    <label>Search</label>
                    <button class='btn btn-flat btn-primary btn-block' onclick='displaycourses(level.value,instructor.value)'>Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-5' id='displaycourses'></div>
        <div class='col-sm-7' id='displaycalendar'></div>
    </div>
</div>

<div id="displaygetunitsloaded"></div>
@endsection

@section('footer-script')
<script src='{{asset('plugins/select2/select2.js')}}'></script>
<script type="text/javascript" src="{{ asset('/plugins/moment/moment.js') }}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>
<script src="{{asset('plugins/jQueryUI/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script>
$(document).ready(function(){
    $('.draggable').data('duration', '03:00');
    //hide yung instructor at search button
    $('#displayinstructor').hide();
    $('#displaysearch').hide();
    
    //lalabas yung instructor
    $('#displaylevel').on('change',function(){
        $('#displayinstructor').fadeIn();
    })
    
    //lalabas yung search button
    $('#displayinstructor').on('change',function(){
        $('#displaysearch').fadeIn();
    })
})


//upon clicking the search button
//kukuninniya lang yung available at walang nakafaculty load
function displaycourses(level,instructor){
    var array = {};
    array['level'] = level;
    array['instructor'] = instructor;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/courses_to_load",
        data: array,
        success: function(data){
            $('#displaycourses').html(data).fadeIn();
            init_events($('.draggable div.callout'));
            getCurrentLoad(instructor,level);
        }
    })
}

function search(event,value,level){
   var array = {};
   array['value'] = value;
   array['level'] = level;
   $.ajax({
       type: "GET",
       url: "/ajax/admin/faculty_loading/search_courses",
       data: array,
       success: function(data){
           $('#searchcourse').html(data).fadeIn();
           init_events($('.draggable div.callout'));
       }
   })
}

//mga nakafaculty load sa kanya sa ngayon.
function getCurrentLoad(instructor,level){
    var array = {};
    array['instructor'] = instructor;
    array['level'] = level;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/current_load",
        data: array,
        success: function(data){
            $('#displaycalendar').html(data).fadeIn();
        }
    })
}


function init_events(ele) {
    ele.each(function () {
      var eventObject = {
        title: $(this).attr("data-object")
      }
      $(this).data('eventObject', eventObject);
      $(this).draggable({
        zIndex        : 1070,
        revert        : true,
        revertDuration: 0 
      })
    })
}
</script>
@endsection