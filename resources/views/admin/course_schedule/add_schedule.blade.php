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
<link rel="stylesheet" href="{{ asset ('plugins/timepicker/bootstrap-timepicker.min.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/fullcalendar/fullcalendar.css')}}">
<section class="content-header">
      <h1><i class="fa fa-bullhorn"></i>  
        Course Scheduling
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Course Scheduling</li>
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
    
    <div class="row">
        <div class="col-sm-4">
             <div class="box box-solid box-default">
                <div class="box-header  bg-navy-active">
                    <h5 class="box-title">Inactive Schedules</h5>
                </div>
                <div class="box-body">
                    @if(!$inactive->isEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Schedule</th>
                                    <th>Attach</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inactive as $schedule)
                                <tr>
                                    <td>{{$schedule->day}} {{date('g:iA',strtotime($schedule->time_starts))}}-{{date('g:iA',strtotime($schedule->time_end))}}</td>
                                    <td><a href="{{url('/admin/course_scheduling/attach_schedule',array($schedule->id,$offering_id))}}" class="btn btn-flat btn-block btn-success"><i class="fa fa-plus-circle"></i></a></td>
                                    <td><a href="{{url('/admin/course_scheduling/delete_schedule',array($schedule->id,$offering_id))}}" onclick="return confirm('Do you wish to continue?')" class="btn btn-flat btn-block btn-danger"><i class="fa fa-times"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="callout callout-warning">
                        <div align="center"><h5>No Inactive Schedule Available!</h5></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box box-default">
                <div class="box-header">
                    <h5 class="box-title">Schedule</h5>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Day</label>
                                <select class="form-control" id="day">
                                    <option>Day</option>
                                    <option value="M">Monday</option>
                                    <option value="T">Tuesday</option>
                                    <option value="W">Wednesday</option>
                                    <option value="Th">Thursday</option>
                                    <option value="F">Friday</option>
                                    <option value="Sa">Saturday</option>
                                    <option value="Su">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Time Start</label>
                                <div class="bootstrap-timepicker">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="time_start">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Time End</label>
                                <div class="bootstrap-timepicker">
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="time_end">

                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <label>Add</label>
                            <a  onclick="addschedule(day.value,time_start.value,time_end.value)" class="btn btn-flat btn-success"><i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="box-footer no-padding">
                    <div class="col-sm-12">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div id='displayroom'>
    </div>
</div>
@endsection

@section('footer-script')
<script src="{{asset('plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment/moment.js') }}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>
<script>
$('.timepicker').timepicker({
    showInputs: false,
});

$('#time_start').on('change',function(){
    if("{{$is_complab}}" == 1){
        $('#time_end').val(moment(this.value, "hh:mm TT").add(3, 'hours').format("hh:mm A"));
    }
})


function addschedule(day,time_start,time_end){
    if(day!="Day"){
        var array = {};
        array['day'] = day;
        array['time_start'] = time_start;
        array['time_end'] = time_end;
        array['offering_id'] = "{{$offering_id}}";
        array['section_name'] = "{{$section_name}}";
        $.ajax({
            type: "GET",
            url: "/ajax/admin/course_scheduling/get_rooms_available",
            data: array,
            success: function(data){
                $('#displayroom').html(data).fadeIn();
                $('#myModal').modal('show');
            }
        })
    }else{
        toastr.warning('Please select a day of the week!');
    }
}



$('#calendar').fullCalendar({
    firstDay: 1,
    columnFormat: 'ddd',
    defaultView: 'agendaWeek',
    hiddenDays: [0],
    minTime: '07:00:00',
    maxTime: '22:00:00',
    header: false,
    //// uncomment this line to hide the all-day slot
    allDaySlot: false,
    eventSources: [<?php echo "$get_schedule"?>],
     eventRender: function(event, element) {
        element.find('div.fc-title').html(element.find('div.fc-title').text()) ;
     },
    eventClick: function(event){
        var boolean = confirm('Clicking the OK button button will change the status of the schedule. Do you wish to continue?');
        if(boolean == true){
            window.open('/admin/course_scheduling/remove_schedule/'+event.id+'/'+event.offering_id,'_self');
        }
    }
 });
</script>
@endsection
