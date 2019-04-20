<?php 
$collection = collect([]);

if(!$courses->isEmpty()){
    foreach($courses as $course){
        $detail = \App\offerings_infos_table::find($course->offering_id);
        if(!empty($detail)){
            $collection->push((object)[
               'level' => $detail->level,
               'offering_id' => $course->offering_id,
               'section_name' => $detail->section_name,
               'curriculum_id' => $detail->curriculum_id
            ]);
        }
    }
}

$color_array = ['info','danger','warning','success'];
$ctr = 0;
?>

<div class='box box-default box-solid'>
    <div class='box-header bg-navy-active'><h5 class='box-title'>Courses to Load</h5></div>
    <div class="box-body">
        <div class="col-sm-12">
            <input type="text" onkeyup="search(event,this.value,'{{$level}}')" class="form-control" placeholder="Enter the course code to search..">
        </div>
    </div>
    <div class='box-body' id="searchcourse">
        <div class='col-sm-12' >
            <div class="draggable" data-duration="03:00">
                <table class="table table-bordered table-condensed">
                <tr>
                    <th width="30%">Course</th>
                    <th>Schedule (Drag the Schedule to the Calendar)</th>
                </tr>
                @foreach($collection->where('level',$level) as $data)
                <?php $curricula = \App\curriculum::find($data->curriculum_id);
                ?>
                <tr>
                    <td>
                        <div align="center">{{$curricula->course_code}}<br>{{$data->section_name}}
                        </div>    
                    </td>
                    <td><div data-object="{{$data->offering_id}}" class='callout callout-warning'>
                            <div align="center">
                            <?php
                            $schedule3s = \App\room_schedules::distinct()->where('offering_id', $data->offering_id)->get(['room']);
                            ?>   
                            @foreach ($schedule3s as $schedule3)
                            {{$schedule3->room}}
                            @endforeach
                            <br>
                            <?php
                            $schedule2s = \App\room_schedules::distinct()->where('offering_id', $data->offering_id)->get(['time_starts', 'time_end', 'room']);
                            ?>
                            @foreach ($schedule2s as $schedule2)
                            <?php
                            $days = \App\room_schedules::where('offering_id', $data->offering_id)->where('time_starts', $schedule2->time_starts)->where('time_end', $schedule2->time_end)->where('room', $schedule2->room)->get(['day']);
                            ?>
                            <!--                @foreach ($days as $day){{$day->day}}@endforeach {{$schedule2->time}} <br>-->
                            [@foreach ($days as $day){{$day->day}}@endforeach {{date('g:iA', strtotime($schedule2->time_starts))}}-{{date('g:iA', strtotime($schedule2->time_end))}}]<br>
                            @endforeach
                            </div>
                        </div>
                    </td>
                </tr>
                <?php $ctr++; ?>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<script>

</script>
