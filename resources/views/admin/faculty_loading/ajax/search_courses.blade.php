<?php 
$collection = collect([]);

    if(!$curriculum->isEmpty()){
        foreach($curriculum as $curricula){
            $offering = \App\offerings_infos_table::where('curriculum_id',$curricula->id)->get();
            if(!$offering->isEmpty()){
                foreach($offering as $offer){
                    $schedules = \App\room_schedules::distinct()->where('offering_id',$offer->id)
                            ->where('instructor',NULL)
                            ->where('is_active',1)
                            ->get(['offering_id']);
                    if(!$schedules->isEmpty()){
                        $collection->push((object)[
                            'level' => $offer->level,
                            'offering_id' => $offer->id,
                            'section_name' => $offer->section_name,
                            'curriculum_id' => $curricula->id
                        ]);
                    }
                }
            }
        }
    }

$color_array = ['info','danger','warning','danger'];
$ctr = 0;
?>

<div class='col-sm-12'>
    <div class="draggable" data-duration="03:00">
        @if(!$collection->where('level',$level)->isEmpty())
        <table class="table table-bordered">
            <tr>
                <th width="30%">Course</th>
                <th>Schedule (Drag the Schedule to the Calendar)</th>
            </tr>
            @foreach($collection->where('level',$level) as $data)
            <?php $curricula = \App\curriculum::find($data->curriculum_id); ?>
            <tr>
                <td>
                    <div align="center">{{$curricula->course_code}}<br>{{$data->section_name}}
                    </div>
                </td>
                <td>
                    <div data-object="{{$data->offering_id}}" class='callout callout-{{$color_array[$ctr]}}'>
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
            <?php $ctr++;?>
            @endforeach
        </table>
        @else
        <div class='row'>
            <div class="callout callout-warning">
                <div align="center">
                    <h5>No Course to be Found!</h5>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
    