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
    <h1><i class="fa   fa-folder"></i>  
        View Curriculum
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a>Add Curriculum</a></li>
    </ol>
</section>
@endsection
@section('main-content')
@if(Session::has('success'))
<script type="text/javascript">
    toastr.success(' <?php echo Session::get('success'); ?>', 'Message!');
</script>
@endif

<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Academic Programs</h3>
                    <div class="box-tools pull-right">
                        <a href="{{url('/admin/curriculum_management/add_curriculum')}}" class="btn btn-flat btn-success" ><i class="fa fa-upload"></i> New Curriculum</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class='table-responsive'>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Program Code</th>
                                <th>Program Name</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $program)
                            <tr>
                                <td>{{$program->program_code}}</td>
                                <td>{{$program->program_name}}</td>
                                <td class="text-center"><a href="{{url('/admin', array('curriculum_management','view_curriculums',$program->program_code))}}" class="btn btn-flat btn-primary"><i class="fa fa-eye"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="{{url('/registrar_college/curriculum_management/curriculum/add_course')}}" method="post">
            {{csrf_field()}}
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">ADD COURSE TO CURRICULUM</h5>
      </div>
      <div class="modal-body">
          <?php $programs= \App\academic_programs::distinct()->get(['program_name','program_code']);?>
          <div class="form-group">
              <label>Academic Program</label>
              <select name="program_code" id="program" class="form-control select2" style="width:100%">
                  <option>Please Select</option>
                  @foreach($programs as $program)
                  <option value="{{$program->program_code}}">{{$program->program_code}} - {{$program->program_name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="form-group">
              <label>Course</label>
              <div class="row">
                  <div class="col-sm-4">
                      <input type="text" class="form-control" name="course_code" placeholder="Course Code">
                  </div>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="course_name" placeholder="Course Name">
                  </div>
              </div>
          </div>
          
          <div class="form-group" id="displaycurriculum">
              <div class="row">
                  <div class="col-sm-4">
                      <label>Curriculum Year</label>
                      <input type="text" name="curriculum_year" class="form-control">
                  </div>
                  <div class="col-sm-4">
                      <label>Level</label>
                      <select name="level" class="form-control">
                          <option>Please Select</option>
                          <option>1st Year</option>
                          <option>2nd Year</option>
                          <option>3rd Year</option>
                          <option>4th Year</option>
                          <option>5th Year</option>
                      </select>
                  </div>
                  <div class="col-sm-4">
                      <label>Period</label>
                      <select name="period" class="form-control">
                          <option>Please Select</option>
                          <option>1st Trimester</option>
                          <option>2nd Trimester</option>
                      </select>
                  </div>
              </div>
              <div class="row" style="margin-top:10px">
                  <div class="col-sm-4">
                    <div class="form form-group">
                        <label>Lec</label>
                        <input type="text" id="lec" name="lec" class="form-control">
                    </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form form-group">
                            <label>Lab</label>
                            <input type="text" id="lab" name="lab" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form form-group">
                            <label>Units</label>
                            <input type="text" id="units" name="units" class="form-control">
                        </div>
                    </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-flat">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('footerscript')
<script>

</script>
