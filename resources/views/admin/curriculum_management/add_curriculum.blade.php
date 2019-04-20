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
$programs = \App\academic_programs::distinct()->orderBy('program_code')->get(array('program_code', 'program_name'));?>
@extends($layout)

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('main-content') 
<link rel='stylesheet' href='{{asset('plugins/select2/select2.css')}}'>
<section class="content-header">
    <h1><i class="fa fa-bullhorn"></i>  
        Add Curriculum
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"> Curriculum Management</a></li>
        <li class="active"><a>Add Curriculum</a></li>
    </ol>
</section>
<section class="content container-fluid">
                    
    <div class="box box-default">
        <form action="{{url('admin/curriculum_management/upload/save_changes')}}" method="post">
        {{csrf_field()}}
        <div class="box-header"><i ></i>
            <h5 class='box-title'></h5>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_field">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Curriculum Year</th>
                            <th width="15%">Period</th>
                            <th width="12%">Level</th>
                            <th width="12%">Program Code</th>
                            <th width="10%">Course Code</th>
                            <th width="25%">Course Name</th>
                            <th width="7%">Lec</th>
                            <th width="7%">Lab</th>
                            <th width="7%">Units</th>
                            <th width="7%">Complab</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><button class="add btn btn-flat btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                            <td><input type="text" class="form-control" name="curriculum_year[]" id="c_year1"></td>
                            <td>
                                <select class="select2 form-control" id="period1" name="period[]">
                                    <option value="1st Semester">1st Semester</option>
                                    <option value="2nd Semester">2nd Semester</option>
                                </select>
                            </td>
                            <td>
                                <select class="select2 form-control" id="level1" name="level[]">
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                    <option value="5th Year">5th Year</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" id="program1" name="program_code[]">
                                    <option>BSIT</option>
                                    <option>BSBA MM</option>
                                    <option>BSED </option>
                                    <option>BSCA</option>
                                    <option>BSA</option>
                                    <option>BSED MATH</option>
                                    <option>BSED PE</option>
                                    <option>BSBA HRDM</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="course_code[]" id="code1"></td>
                            <td><input type="text" class="form-control" name="course_name[]" id="name1"></td>
                            <td><input type="text" class="form-control" name="lec[]" id="lec1"></td>
                            <td><input type="text" class="form-control" name="lab[]" id="lab1"></td>
                            <td><input type="text" class="form-control" name="units[]" id="units1"></td>
                            <td align="center"><select class='form-control' name='complab[]' id='complab1'><option value='0'>No</option><option value='1'>Yes</option></select></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button onclick="submit()" class="btn btn-flat btn-success"><i class="fa fa-check-circle"></i> Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script></script>
@endsection

@section('footer-script')
<script src='{{asset('plugins/select2/select2.js')}}'></script>
<script></script>
<script>
   var no = 1;
    $('.add').on('click',function(e){
    if($("#c_year"+no).val()=="" || $("#code" + no).val()=="" || $("#name" + no).val()=="" || $("#lec" + no).val()=="" || $("#lab" + no).val()=="" || $("#units" + no).val()==""){
        toastr.warning("Please Fill-up Required Fields ");
    }else{
        no++;
        $('#dynamic_field').append("<tr id='row"+no+"'>\n\
                <td><button class='btn btn-flat btn-danger remove' id='"+no+"'><i class='fa fa-close'></i></button></td>\n\
                <td><input type='text' name='curriculum_year[]' class='form-control' id='c_year"+no+"'></td>\n\
                <td><select class='form-control' name='period[]' id='period"+no+"'><option value='1st Semester'>1st Semester</option><option value='2nd Semester'>2nd Semester</option></select></td>\n\
                <td><select class='form-control' name='level[]' id='level"+no+"'><option value='1st Year'>1st Year</option><option value='2nd Year'>2nd Year</option><option value='3rd Year'>3rd Year</option><option value='4th Year'>4th Year</option><option value='5th Year'>5th Year</option></select></td>\n\
                <td><select class='form-control select2' name='program_code[]' id='program"+no+"'>"@foreach($programs as $program) + "<option>{{$program->program_code}}</option>"  @endforeach +"</select></td>\n\
                <td><input type='text' class='form-control' name='course_code[]' id='code"+no+"'></td>\n\
                <td><input type='text' class='form-control' name='course_name[]' id='name"+no+"'></td>\n\
                <td><input type='text' class='form-control' name='lec[]' id='lec"+no+"'></td>\n\
                <td><input type='text' class='form-control' name='lab[]' id='lab"+no+"'></td>\n\
                <td><input type='text' class='form-control' name='units[]' id='units"+no+"'></td>\n\
                <td align='center'><select class='form-control' id='complab"+no+"' name='complab[]'><option value='0'>No</option><option value='1'>Yes</option></select></td>\n\
            </tr>");
    }
    e.preventDefault();
    return false;
})

$('#dynamic_field').on('click','.remove', function(e    ){
    var button_id = $(this).attr("id");
    $("#row"+button_id+"").remove();
    i--;
    e.preventDefault();
    return false;
}); 

</script>
@endsection

