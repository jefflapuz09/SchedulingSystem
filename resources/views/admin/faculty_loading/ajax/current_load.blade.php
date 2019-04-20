<?php 

if(!$schedules->isEmpty()){
    foreach($schedules as $sched){
        $course_detail = \App\curriculum::join('offerings_infos','offerings_infos.curriculum_id','curricula.id')
                ->where('offerings_infos.id',$sched->offering_id)->first(['curricula.course_code','offerings_infos.section_name']);
        if($sched->day == 'M'){
            $day = 'Monday';
            $color = 'LightSalmon';
        }else if($sched->day == 'T'){
            $day = 'Tuesday';
            $color = 'lightblue';
        }else if($sched->day == 'W'){
            $day = 'Wednesday';
            $color = 'LightSalmon';
        }else if($sched->day == 'Th'){
            $day = 'Thursday';
            $color = 'lightblue';
        }else if($sched->day == 'F'){
            $day = 'Friday';
            $color = 'LightSalmon';
        }else if($sched->day == 'Sa'){
            $day = 'Saturday';
            $color = 'lightblue';
        }else if($sched->day == 'Su'){
            $day = 'LightSalmon';
        }
        $event_array[] = array(
            'id' => $sched->id,
            'title' => $course_detail->course_code.'<br>'.$sched->room.'<br>'.$course_detail->section_name,
            'start' => date('Y-m-d', strtotime($day. ' this week')).'T'.$sched->time_starts,
            'end' => date('Y-m-d', strtotime($day. ' this week')).'T'.$sched->time_end,
            'color' => $color,
            "textEscape"=> 'false' ,
            'textColor' => 'black',
            'offering_id' => $sched->offering_id
        );
    }
    $get_schedule = json_encode($event_array);
}else{
    $get_schedule = NULL;
}




?>
<?php $employee_type = \App\instructors_infos::where('instructor_id',$instructor)->first();?>
<div class='box box-default'>
     <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="active"><a href="#tab_1-1" data-toggle="tab">Calendar View</a></li>
          <li><a href="#tab_2-2" data-toggle="tab">Tabular View</a></li>
          <li class="pull-left header"><i class="fa fa-calendar "></i> Faculty Loading  <b><span>({{$employee_type->employee_type}})</b> <br><small>Total No. of Units Loaded: {{$loads->sum('units')}}</small></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1-1">
            <div id='calendar'></div>
          </div>
          <div class="tab-pane" id="tab_2-2">
              <div class="table-responsive">
                  @if(!$tabular_schedules->isEmpty())
                  <table class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>Code</th> 
                              <th>Description</th>
                              <th>Units</th>
                              <th>Section</th>
                              <th>Schedule</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($tabular_schedules as $schedule)
                          <?php
                          $course_detail = \App\curriculum::join('offerings_infos','offerings_infos.curriculum_id','curricula.id')
                            ->where('offerings_infos.id',$schedule->offering_id)->first(['curricula.course_code','curricula.course_name','offerings_infos.section_name','curricula.units']);
                          ?>
                          <tr onclick="remove_faculty_load('{{$schedule->offering_id}}')">
                              <td>{{$course_detail->course_code}}</td>
                              <td>{{$course_detail->course_name}}</td>
                              <td>{{$course_detail->units}}</td>
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
                  <div class="col-sm-12">
                      <a href="{{url('/admin/faculty_loading/generate_schedule',array($instructor))}}" target="_blank" class="btn btn-flat btn-primary btn-block">Generate Schedule</a>
                  </div>
                  @else
                  <div class="callout callout-warning">
                      <div align="center"><h5>No Faculty Loading Found!</h5></div>
                  </div>
                  @endif
              </div>
          </div>
        </div>
      </div>
</div>

<script>
$('#calendar').fullCalendar({
    firstDay: 0,
    columnFormat: 'ddd',
    defaultView: 'agendaWeek',
    minTime: '07:00:00',
    maxTime: '22:00:00',
    droppable: true,
    hiddenDays: [0],

    header: false,
    //// uncomment this line to hide the all-day slot
    allDaySlot: false,
    eventSources: [<?php echo "$get_schedule"?>],
     eventRender: function(event, element) {
        element.find('div.fc-title').html(element.find('div.fc-title').text());
     },
             //kapag naclick yung mismong event magtitrigger tong function na to
    eventClick: function(event){
            remove_faculty_load(event.offering_id);
    },
            //kaapg nadrag magtitrigger tong function na to
    drop: function(date) {
         var originalEventObject = $(this).data('eventObject')
         var array = {};
         array['instructor'] = "{{$instructor}}";
         array['offering_id'] = originalEventObject.title;
         $.ajax({
             type: "GET",
             url: "/ajax/admin/faculty_loading/add_faculty_load",
             data: array,
             success: function(data){
                 displaycourses('{{$level}}',"{{$instructor}}");
                 getCurrentLoad("{{$instructor}}",'{{$level}}');
                 toastr.success('Successfully loaded the subject to the Instructor!','Notification!');
             },error: function(xhr, status, error){
                 if(xhr.status==500){
                    toastr.error('Conflict in Schedule Found!','Notification!');
                 }
                 if(xhr.status==404){
                    var boolean = confirm('The no. of units loaded exceeds. Do you want to override?');
                    if(boolean==true){
                        getunitsloaded(array['offering_id']);
                    }
                 }
             }
         })
      }
 });
 
 function getunitsloaded(offering_id){
     var array = {};
     array['offering_id'] = offering_id;
     array['instructor'] = "{{$instructor}}";
     array['level'] = "{{$level}}";
     $.ajax({
         type: "GET",
         url: "/ajax/admin/faculty_loading/get_units_loaded",
         data: array,
         success: function(data){
             $('#displaygetunitsloaded').html(data).fadeIn();
             $('#modalunits').modal('toggle');
         },error: function(){
             toastr.error('Something Went Wrong!','Notification!');
         }
     })
 }
 
 function remove_faculty_load(offering_id){
    var boolean = confirm('By clicking the ok button will unload the subject from the instructor. Do you wish to continue?');
    if(boolean == true){
         var array = {};
        array['offering_id'] = offering_id;
        array['instructor'] = "{{$instructor}}";
        $.ajax({
            type: "GET",
            url: "/ajax/admin/faculty_loading/remove_faculty_load",
            data: array,
            success: function(data){
                displaycourses('{{$level}}',"{{$instructor}}");
                getCurrentLoad("{{$instructor}}",'{{$level}}');
                toastr.error('Removal of Faculty Loading','Notification!');
            }
        })
    }
 }
</script>