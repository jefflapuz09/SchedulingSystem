@if(!$tabular_schedules->isEmpty())
<div align="center" style="margin-bottom:10px;">
    <label class="label label-danger">Schedules Suggested</label>
</div>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Code</th>
            <th>Section</th>
            <th>Schedule</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tabular_schedules as $schedule)
        <?php
        $course_detail = \App\curriculum::join('offerings_infos','offerings_infos.curriculum_id','curricula.id')
          ->where('offerings_infos.id',$schedule->offering_id)->first(['curricula.course_code','curricula.course_name','offerings_infos.section_name']);
        ?>
        @if($schedule->is_loaded == 0)
        <tr style="background:lightsalmon;" onclick="show_offer('{{$schedule->offering_id}}')">
        @else
        <tr style="background:lightblue;">
        @endif
            <td>{{$course_detail->course_code}}</td>
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
@else
<div class="callout callout-warning">
    <div align="center"><h5>No Faculty Loading Found!</h5></div>
</div>
@endif