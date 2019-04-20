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
<?php $programs= \App\academic_programs::distinct()->get(['program_name','program_code'])?>

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
      <h1><i class="fa fa-chain"></i>  
        Instructor Reports
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Instructor Reports</li>
      </ol>
</section>
@endsection
@section('main-content')
<link rel='stylesheet' href='{{asset('plugins/datatables/jquery.dataTables.css')}}'>
<link rel='stylesheet' href='{{asset('plugins/datatables/dataTables.bootstrap.css')}}'>
<section class="content">
    <div class="container-fluid">
        <div class="box box-default">
            <div class="box-header"><h5 class="box-title">List of Instructors</h5></div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Number</th>
                  <th>Name</th>
                  <th width="40%">College</th>
                  <th width="5%">Faculty Loading</th>
                </tr>
                </thead>
                            </thead>
                            <tbody>
                                @foreach($instructors as $instructor)
                                <?php $users = \App\User::where('id',$instructor->id)->first(); ?>
                                <tr>
                                    <td>{{$instructor->username}}</td>
                                    <td>{{strtoupper($instructor->lastname)}}, {{strtoupper($instructor->name)}}</td>
                                <?php $info = \App\instructors_infos::where('instructor_id',$instructor->id)->first();?>
                                    <td>{{$info->department}} {{$info->college}}</td>
                                    <td><a href="{{url('/admin/instructor/edit_faculty_loading',array($instructor->id))}}" class="btn btn-flat btn-success"><i class="fa fa-calendar-check-o"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</section>

@endsection
@section('footer-script')
<script src='{{asset('plugins/datatables/jquery.dataTables.js')}}'></script>
<script src='{{asset('plugins/datatables/dataTables.bootstrap.js')}}'></script>
<script>
$('#example1').DataTable();
    </script>
@endsection
    
    
