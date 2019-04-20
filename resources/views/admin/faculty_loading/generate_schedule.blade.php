<link rel="stylesheet" href="{{ asset ('plugins/fullcalendar/fullcalendar.css')}}">
<script type="text/javascript" src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment/moment.js') }}"></script>
<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<style>
    .a{
        text-align: center;
        text-transform: uppercase;
        font-size: 15px;
    }
    .b{
        text-align: center;
        text-transform: uppercase;
        font-size: 15px;
    }
    .c{
        text-align: center;
        font-size: 12px;
    }
    
  @page {
    size: letter;
    margin: 10px;
  }
  
  #calendar{
      height:150px;
  }
  
    @media print{
        
        
        .no-print{
            display: none !important;
        }
        html, body {
            width: 210mm;
            height: 150mm;
          }
          
          #header{
            position: absolute;
            top:350px;
            right: 0;
        }
          
                 .fc-time{
                     font-size:6pt !important;
                    /*text-align: center;*/
                }
                .fc-title{
                    font-size: 7pt;
/*                    text-align: center;*/
                }   
               
                .fc tr {
                    border: 2px solid black;
                }
                .fc td {
                    border: 2px solid black;
                }
                .fc th {
                    border: 2px solid black;
                }
                .fc-today {
                  background-color:inherit !important;
                }
                .fc-ltr .fc-axis {
                text-align: center;
                }

                .fc tr:nth-child(even) {
                background-color: #f2f2f2;
                background-position: bottom;
                }
    }
    
 
    
</style>
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
            'title' => '<div style="font-size:5pt;">'.$course_detail->course_code.'<br>'.$sched->room.'<br>'.$course_detail->section_name.'</div>',
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

$faculty = \App\User::find($instructor);
//$year = \App\curriculum::find
$info = \App\instructors_infos::where('instructor_id' ,$instructor)->first();
?>
<button class="no-print" onclick="myFunction()">Print Schedule</button>
    <!--<div style='position:absolute;top:40px;'><img style='width:50px; height:50px;' src="{{asset('/images/rsz_logo.png')}}"></div>-->
<!--     <div style='position:absolute;top:45px; left:70px;'>
         <span id="schoolname">{{env("SCHOOL_NAME")}}</span> <br><small> {{env("SCHOOL_ADDRESS1")}}{{env("SCHOOL_ADDRESS2")}}</small>
     </div>-->
<div id="header" style="position: absolute; top:350; right:0px;">
<div class="a">
    <b>Sample University</b>
     </div>
<div class="b">
<!--         <b> {{$faculty->lastname}}, {{$faculty->name}} </b>-->
    Class/Faculty Room Schedule
    </div>
<div class="c">
<!--         {{$info->department}} -->
Second SEMESTER SY <b>2018-2019</b>
</div>
    
<div class="form form-group" align="center">
    <b>Name:</b> {{$faculty->name}} {{$faculty->lastname}}
</div>
<div class="form form-group" align="center">
    <b>Email:</b> {{$faculty->email}}
</div>
<div class="form form-group" align="center">
    <b>Subjects Preferred:</b>
</div>    
</div>
<div id="calendar" style="position: absolute; top:60px; ">

<br>

<br>
<br><br>

</div>
 




<script>
$('#calendar').fullCalendar({
    contentHeight: 'auto',
    firstDay: 1,
    columnFormat: 'ddd',
    defaultView: 'agendaWeek',
    hiddenDays: [0],
    droppable: true,
    minTime: '07:00:00',
    maxTime: '22:00:00',
    header: false,
    //// uncomment this line to hide the all-day slot
    allDaySlot: false,
    eventSources: [<?php echo "$get_schedule"?>],
    eventRender: function(event, element) {
       element.find('div.fc-title').html(element.find('div.fc-title').text());
    }
 });
             $('#calendar').css('width', '7.5in');
             $('#calendar').css('height', '5.5in');
 
   
function myFunction() {
    window.print();     
}
 </script>
 
        