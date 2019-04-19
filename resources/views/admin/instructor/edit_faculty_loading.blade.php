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
$tabular_schedules = \App\room_schedules::distinct()->
                where('is_active', 1)->where('instructor',$instructor)->get(['offering_id', 'is_loaded']);
?>

@extends($layout)

@section('main-content')
<link rel="stylesheet" href="{{ asset ('plugins/toastr/toastr.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/fullcalendar/fullcalendar.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/datatables/dataTables.bootstrap.css')}}">
<link rel="stylesheet" href="{{ asset ('plugins/datatables/jquery.dataTables.css')}}">
<section class="content-header">
    <h1><i class="fa fa-bullhorn"></i>
        Faculty Loading Assignment
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Faculty Loading Assignment</li>
    </ol>
</section>

<div class="container-fluid" style="margin-top:20px;">
    <div class="row">
        <div class="col-sm-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Calendar View</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Tabular View</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">   
                        <div class="box-body no-padding">
                            <div id="calendar"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="table-responsive">
                            @if(!$tabular_schedules->isEmpty())
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Section</th>
                                        <th>Schedule</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tabular_schedules as $schedule)
                                    <?php
                                    $course_detail = \App\curriculum::join('offerings_infos', 'offerings_infos.curriculum_id', 'curricula.id')
                                                    ->where('offerings_infos.id', $schedule->offering_id)->first(['curricula.course_code', 'curricula.course_name', 'offerings_infos.section_name']);
                                    ?>
                                    <tr onclick="remove_faculty_load('{{$schedule->offering_id}}')">
                                        <td>{{$course_detail->course_code}}</td>
                                        <td>{{$course_detail->course_name}}</td>
                                        <td>{{$course_detail->section_name}}</td>
                                        <td>
                                            <div align="center">
                                                <?php
                                                $schedule3s = \App\room_schedules::distinct()->where('offering_id', $schedule->offering_id)->get(['room']);
                                                ?>   
                                                @foreach ($schedule3s as $schedule3)
                                                {{$schedule3->room}}
                                                @endforeach
                                                <br>
                                                <?php
                                                $schedule2s = \App\room_schedules::distinct()->where('offering_id', $schedule->offering_id)->get(['time_starts', 'time_end', 'room']);
                                                ?>
                                                @foreach ($schedule2s as $schedule2)
                                                <?php
                                                $days = \App\room_schedules::where('offering_id', $schedule->offering_id)->where('time_starts', $schedule2->time_starts)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
                                                ?>
                                                <!--                @foreach ($days as $day){{$day->day}}@endforeach {{$schedule2->time}} <br>-->
                                                [@foreach ($days as $day){{$day->day}}@endforeach {{date('g:iA', strtotime($schedule2->time_starts))}}-{{date('g:iA', strtotime($schedule2->time_end))}}]<br>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
</div>

<div id="displaymodal">

</div>
@endsection

@section('footer-script')
<script type="text/javascript" src="{{ asset('/plugins/moment/moment.js') }}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.js')}}"></script>
<script src="{{asset('plugins/jQueryUI/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
<script>

$('#calendar').fullCalendar({
header: false,
        hiddenDays: [0],
        firstDay: 1,
        height: 650,
        allDaySlot: false,
        columnFormat: 'ddd',
        defaultView: 'agendaWeek',
        eventSources: [<?php echo "$schedules"; ?>],
        eventRender: function(event, element) {
        element.find('div.fc-title').html(element.find('div.fc-title').text());
        }
})

</script>
@endsection