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
<?php use Carbon\Carbon; 

?>
@extends($layout)

@section('main-content')
<link rel="stylesheet" href="{{ asset ('plugins/datatables/dataTables.bootstrap.css')}}">
<section class="content-header">
      <h1><i class="fa fa-bell-o"></i>  
        Notifications
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Notifications</li>
      </ol>
</section>


<div class="container-fluid" style="margin-top: 15px;">
    <div class="box box-default">
        <div class="box-header">
            <div class="box-tools pull-right">
                <label class="label label-warning">Tap the unread status.</label>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive" id="reloadtabular">
                @if(count($notifications)>0)
                <table class="table table-bordered table-striped" id="example2">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="20%">Date Time</th>
                            <th width="70%">Content</th>
                            <th width="5%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notif)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{Carbon::parse($notif->date_time)->diffForHumans()}}</td>
                            <td>{{$notif->content}}</td>
                            <td>
                                @if($notif->is_trash == 0)
                                <label onclick="changenotifstatus('{{$notif->id}}')" class="label label-warning">Unread</label>
                                @else
                                <label class="label label-info">Read</label>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="callout callout-warning">
                    <div align="center"><h5>No Notifications!</h5></div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer-script')
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script>
    $('#example2').DataTable({})
    
    function changenotifstatus(notif_id){
        var array = {};
        array['notif_id'] = notif_id;
        $.ajax({
            type: "GET",
            url: "/ajax/admin/faculty_loading/reloadnotif",
            data: array,
            success: function(data){
                toastr.info('Updated the status of the notification','Notification!');
                $('#reloadtabular').html(data).fadeIn();
                $('#example2').DataTable({})
            },error: function(){
                toastr.error('Something Went Wrong!','Notification!');
            }
        })
    }
</script>
@endsection
