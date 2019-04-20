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
<?php
$programs = \App\academic_programs::distinct()->orderBy('program_code')->get(array('program_code', 'program_name'));
?>
@extends($layout)
@section('messagemenu')
<li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"></span>
            </a>
</li>
<li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"></span>
            </a>
</li>
          
<li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger"></span>
            </a>
</li>
@endsection
@section('header')
<section class="content-header">
    <h1>
        Upload Curriculum
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a href="{{ url ('/registrar_college', array('curriculum_management','upload_curriculum'))}}"> Upload Curriculum</a></li>
    </ol>
</section>
@endsection
@section('maincontent')

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">Upload</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
            <form action="{{ URL::to('registrar_college', array('curriculum_management','upload')) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-12">
                        <label> Excel File Type Only!</label>
                        <input type="file" required name="import_file" />
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <button class="btn btn-primary col-sm-12" type="submit">Upload Curriculum</button>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
    
        
    @if(Session::has('upload'))
    <div class='box box-primary'>
        <form action='{{url('/registrar_college/curriculum_management/upload/save_changes')}}' method='post'>
            {{csrf_field()}}
        <div class='box-header'>
            <p class='box-title text-muted'><small>By clicking the 'Save Changes' button, the following will be save into the database.</small></p>
        </div>
        <div class='box-body'>
            <div class='table-responsive'>
                <table class='table table-bordered'>
                    <tr>
                        <th>Currnnkniculum Year</th>
                        <th>Period</th>
                        <th>Level</th>
                        <th>Program Code</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Lec</th>
                        <th>Lab</th>
                        <th>Units</th>
                    </tr>
                        @foreach($upload as $key=>$load)
                    <tr>
                        <input type='hidden' name='curriculum_year[]' value='{{$load['curriculum_year']}}'>
                        <input type='hidden' name='period[]' value='{{$load['period']}}'>
                        <input type='hidden' name='level[]' value='{{$load['level']}}'>
                        <input type='hidden' name='program_code[]' value='{{$load['program_code']}}'>
                        <input type='hidden' name='course_code[]' value='{{$load['course_code']}}'>
                        <input type='hidden' name='course_name[]' value='{{$load['course_name']}}'>
                        <input type='hidden' name='lec[]' value='{{$load['lec']}}'>
                        <input type='hidden' name='lab[]' value='{{$load['lab']}}'>
                        <input type='hidden' name='units[]' value='{{$load['units']}}'>
                        <td>{{$load['curriculum_year']}}</td>
                        <td>{{$load['period']}}</td>
                        <td>{{$load['level']}}</td>
                        <td>{{$load['program_code']}}</td>
                        <td>{{$load['course_code']}}</td>
                        <td>{{$load['course_name']}}</td>
                        <td>{{$load['lec']}}</td>
                        <td>{{$load['lab']}}</td>
                        <td>{{$load['units']}}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
            <div class='box-footer'>
                <div class='box-tools pull-right'>
                    <button type='submit' class='btn btn-flat btn-success'><i class='fa fa-check-circle-o'></i> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
    @endif
</section>

@endsection
@section('footerscript')

@endsection