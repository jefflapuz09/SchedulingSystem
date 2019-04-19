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
        <h1><i class="fa fa-bullhorn"></i>
        Room Management (Archive Rooms)
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Room Management</li>
        <li class="active">Archive Rooms</li>
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
                <h5 class="box-title">List of Inactive Rooms</h5>
                <div class="box-tools pull-right">
                    <a href="{{url('/admin/room_management')}}" class="btn btn-flat btn-success"><i class="fa fa-check-circle"></i> Active Records</a>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                                <tr>
                                    <th width='20%'>Room</th>
                                    <th width='20%'>Floor</th>
                                    <th width='20%'>Description</th>
                                    <th width='20%'>Status</th>
                                    <th width='20%'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$rooms->isEmpty())
                                @foreach($rooms as $room)
                                <tr>
                                    <td>{{$room->room}}</td>
                                    <td>{{$room->building}}</td>
                                    <td>{{$room->description}}</td>
                                    <td>
                                        @if($room->is_active == 1)
                                        <label class='label label-success'>Active</label>
                                        @else
                                        <label class='label label-danger'>Inactive</label>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('/admin/room_management/archive',array($room->id))}}" class="btn btn-flat btn-success" title="Change to Active Status?" onclick="return confirm('Do you wish to restore the Record?')"><i class="fa fa-recycle"></i></a>
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
