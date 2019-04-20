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
<section class="content-header">
    <h1><i class="fa  fa-cubes"></i>
        Section Management
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Section Management</li>
      </ol>
</section>


<div class="container-fluid" style="margin-top: 15px;">
    @if(Session::has('success'))
    <div class='col-sm-12'>
        <div class='callout callout-success'>
            {{Session::get('success')}}
        </div>
    </div>
    @endif
    
    @if(Session::has('error'))
    <div class='col-sm-12'>
        <div class='callout callout-danger'>
            {{Session::get('error')}}
        </div>
    </div>
    @endif
    
    <div class='row'>
        <div class='col-sm-5'>
            <div class='box box-solid box-default'>
                <div class='box-header bg-navy-active'>
                    <h5 class="box-title">New Section</h5>
                </div>
                <div class='box-body'>
                    <form action="{{url('/admin/section_management/post')}}" method="post">
                    {{csrf_field()}}
                    <div class='form-group'>
                        <label>Academic Program</label>
                        <select class="select2 form-control" class="select2 form-control"name="program_code" id="program_code" required class='form-control'>
                            <option>Please Select</option>
                            @foreach($programs as $program)
                            <option>{{$program->program_code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label>Level</label>
                        <select name="level" required class='select2 form-control'>
                            <option>1st Year</option>
                            <option>2nd Year</option>
                            <option>3rd Year</option>
                            <option>4th Year</option>
                            <option>5th Year</option>
                            
                        </select>
                    </div>
                    <div class='form-group'>
                        <label>Section</label>
                        <input id="section_name" required name="section_name" type="text" class="form-control">
                    </div>
                    <div class='form-group'>
                        <button onclick='return confirm("Clicking the OK button will save the record? Do you wish to continue?")' type='submit' class='btn btn-flat btn-success btn-block'>Save and Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class='col-sm-7'>
            <div class="box box-default">
                <div class="box-header">
                    <h5 class="box-title">List of Created Sections</h5>
                    <div class="box-tools pull-right">
                        <a href="{{url('/admin/section_management/archive')}}" class="btn btn-flat btn-danger"><i class="fa fa-warning"></i> Archive Section</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width='20%'>Program Code</th>
                                    <th width='20%'>Level</th>
                                    <th width='20%'>Section Name</th>
                                    <th width='20%'>Status</th>
                                    <th width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$sections->isEmpty())
                                @foreach($sections as $section)
                                <tr>
                                    <td>{{$section->program_code}}</td>
                                    <td>{{$section->level}}</td>
                                    <td>{{$section->section_name}}</td>
                                    <td>
                                        @if($section->is_active == 1)
                                        <label class='label label-success'>Active</label>
                                        @else
                                        <label class='label label-danger'>Inactive</label>
                                        @endif
                                    </td>
                                    <td>
                                        <button data-toggle="modal" data-target="#myModal" onclick="editsection('{{$section->id}}')" title="Edit Record" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></button>
                                        <a href="{{url('/admin/section_management/archive',array($section->id))}}" class="btn btn-flat btn-danger" title="Change to Inactive Status?" onclick="confirm('Do you wish to archive the Record?')"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="myModal" class="modal fade" role="dialog">
    <div id='displayedit'>
    </div>
</div>
@endsection

@section('footer-script')
<script src='{{asset('plugins/select2/select2.js')}}'></script>
<script>
$('#program_code').on('change',function(){
    if(this.value!='Please Select'){
        $('#section_name').val(this.value+'-');
    }else{
        $('#section_name').val(' ');
    }
})    
    
function editsection(section_id){
    var array = {};
    array['section_id'] = section_id;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/section_management/edit_section",
        data: array,
        success: function(data){
            $('#displayedit').html(data).fadeIn();
            $('#myModal').modal('show');
        }
    })
}
</script>
@endsection
