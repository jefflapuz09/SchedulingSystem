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
      <h1><i class="fa  fa-calendar-check-o"></i>
        Section Management (Archive Section)
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Section Management</li>
        <li class="active">Archive Section</li>
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
    
    
    <div class='col-sm-12'>
        <div class="box box-danger">
            <div class="box-header">
                <h5 class="box-title">List of Inactive Sections</h5>
                <div class="box-tools pull-right">
                    <a href="{{url('/admin/section_management')}}" class="btn btn-flat btn-success"><i class="fa fa-check-circle"></i> Active Section</a>
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
                                    <a href="{{url('/admin/section_management/archive',array($section->id))}}" class="btn btn-flat btn-success" title="Change to active Status?" onclick="return confirm('Do you wish to restore the Record?')"><i class="fa fa-recycle"></i></a>
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


@endsection

@section('footer-script')

@endsection
