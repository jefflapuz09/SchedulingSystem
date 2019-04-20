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
      <h1><i class="fa fa-calendar-check-o "></i>  
        Course Offerings
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Curriculum Management</li>
        <li class="active">Course Offerings</li>
      </ol>
</section>


<div class="container-fluid" style="margin-top: 15px;">
    <div class="box box-default">
        <div class="box-header">
            <h5 class="box-title">Academic Programs</h5>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="15%">Program Code</th>
                            <th>Name</th>
                            <th width="5%">Offerings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$programs->isEmpty())
                        @foreach($programs as $program)
                        <tr>
                            <td>{{$program->program_code}}</td>
                            <td>{{$program->program_name}}</td>
                            <td class="text-center"><a href="{{url('/admin/course_offerings',array($program->program_code))}}" class="btn btn-success">></a></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
    