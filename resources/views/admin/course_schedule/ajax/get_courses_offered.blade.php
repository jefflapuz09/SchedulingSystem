@if(!$courses->isEmpty())
<div class="box box-default">
    <div class='box-header'>
        <h5 class='box-title'>Courses Offered</h5>
    </div>
    <div class='box-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Description</th>
                        <th width="40%">Schedule</th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <?php $curricula = \App\curriculum::find($course->curriculum_id); ?>
                    <tr>
                        <td>{{$curricula->course_code}}</td>
                        <td>{{$curricula->course_name}}</td>
                        <td>
                            <div align="center">
                            <?php
                            $schedule3s = \App\room_schedules::distinct()->where('offering_id', $course->id)->get(['room']);
                            ?>   
                            @foreach ($schedule3s as $schedule3)
                            {{$schedule3->room}}
                            @endforeach
                            <br>
                            <?php
                            $schedule2s = \App\room_schedules::distinct()->where('offering_id', $course->id)->get(['time_starts', 'time_end', 'room']);
                            ?>
                            @foreach ($schedule2s as $schedule2)
                            <?php
                            $days = \App\room_schedules::where('offering_id', $course->id)->where('time_starts', $schedule2->time_starts)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
                            ?>
                            <!--                @foreach ($days as $day){{$day->day}}@endforeach {{$schedule2->time}} <br>-->
                            [@foreach ($days as $day){{$day->day}}@endforeach {{date('g:iA', strtotime($schedule2->time_starts))}}-{{date('g:iA', strtotime($schedule2->time_end))}}]<br>
                            @endforeach
                            </div>
                        </td>
                        <td><a href="{{url('/admin/course_scheduling/schedule',array($course->id,$section_name))}}" target="_blank" class="btn btn-flat btn-success"><i class="fa fa-pencil"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="box box-default">
    <div class='box-header'>
        <h5 class='box-title'>Courses Offered</h5>
    </div>
    <div class='box-body'>
        <div class='callout callout-warning'>
            <div align='center'>No Courses Offered Found!</div>
        </div>
    </div>
</div>
@endif