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
        Room Management
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Room Management</li>
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
                    <h5 class="box-title">New Room</h5>
                </div>
                <div class='box-body'>
                    <form action="{{url('/admin/room_management/post')}}" method="post">
                    {{csrf_field()}}
                    <div class='form-group'>
                        <label>Room</label>
                        <input type='text' required class='form-control' name='room'>
                    </div>
                    <div class='form-group'>
                        <label>Floor</label>
                        <input type='text' required class='form-control' name='building'>
                    </div>
                    <div class='form-group'>
                        <label>Description</label>
                        <input type='text'  class='form-control' name='description'>
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
                    <h5 class="box-title">List of Created Rooms</h5>
                    <div class="box-tools pull-right">
                        <a href="{{url('/admin/room_management/archive')}}" class="btn btn-flat btn-danger"><i class="fa fa-warning"></i> Archive Rooms</a>
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
                                        <button data-toggle="modal" data-target="#myModal" onclick="editroom('{{$room->id}}')" title="Edit Record" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></button>
                                        <a href="{{url('/admin/room_management/archive',array($room->id))}}" class="btn btn-flat btn-danger" title="Change to Inactive Status?" onclick="confirm('Do you wish to archive the Record?')"><i class="fa fa-times"></i></a>
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

<script>
function editroom(room_id){
    var array = {};
    array['room_id'] = room_id;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/room_management/edit_room",
        data: array,
        success: function(data){
            $('#displayedit').html(data).fadeIn();
            $('#myModal').modal('show');
        }
    })
}
</script>
@endsection
