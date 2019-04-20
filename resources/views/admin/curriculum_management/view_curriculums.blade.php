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
$program = \App\academic_programs::where('program_code', $program_code)->first();
    
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
    <h1><i class="fa  fa-folder-o"></i>
        View Curriculum
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a>View Curriculum</a></li>
    </ol>
</section>
@endsection
@section('main-content')
<section class="content">
    <div class="row">
        <div class="col-sm-12" id="displaycurriculum">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">{{$program->program_name}}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class='table-responsive'>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Curriculum Year</th>
                                <th class="text-center" width="30%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($curricula as $curriculum)
                            <tr>
                                <td>{{$curriculum->curriculum_year}} - {{$curriculum->curriculum_year+1}}</td>
                                <td class="text-center"><a href="{{url('/admin', array('curriculum_management','list_curriculum',$program_code,$curriculum->curriculum_year))}}" class="btn btn-flat btn-success"><i class="fa fa-eye"></i></a>
                                    <a onclick="displayedityear('{{$curriculum->curriculum_year}}','{{$program_code}}')" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="editmodal" class="modal fade" role="dialog">
            <div id="displayedit"></div>
        </div>
    </div>
</section>

@endsection
@section('footer-script')
<script>
    function displayedityear(curriculum_year,program_code){
        var array = {};
        array['curriculum_year'] = curriculum_year;
        array['program_code'] = program_code;
        $.ajax({
            type: "GET",
            url: "/admin/curriculum_management/ajax/edityear",
            data: array,
            success: function(data){
                $('#displayedit').html(data).fadeIn();
                $('#editmodal').modal('show');
                
                toastr.clear();
            }, error: function(){
                toastr.error('Something Went Wrong!', 'Error!');
            }
        })
    }
    
    function refreshtable(curriculum_year,program_code){
        var array = {};
        array['curriculum_year'] = curriculum_year;
        array['program_code'] = program_code;
        $.ajax({
            type: "GET",
            url: "/admin/curriculum_management/ajax/refreshcurriculum",
            data: array,
            success: function(data){
                $('#displaycurriculum').html(data).fadeIn();
            }, error: function(){
                toastr.error('Something Went Wrong!', 'Error!');
            }
        })
    }
</script>
@endsection