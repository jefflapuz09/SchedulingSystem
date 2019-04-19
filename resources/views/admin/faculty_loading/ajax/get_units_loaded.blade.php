<div class="modal fade" id="modalunits">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-red">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Schedules</h4>
    </div>
    <div class="modal-body">
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
        <p>Do you want to override the units given by the Admin? <b>{{$units}}</b></p>
        <div class="form-group">
            <label>Maximun no. of Units Loaded</label>
            <input id="overrideval" type="text" class="form-control" value="{{$units}}">
        </div>
        @else
        <div class="callout callout-warning">
            <div align="center"><h5>No Faculty Loading Found!</h5></div>
        </div>
        @endif
    </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
      <button type="button" onclick="overridebtn(overrideval.value)" class="btn btn-primary">Override</button>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<script>
function overridebtn(override){
    var array = {};
    array['instructor'] = "{{$instructor}}";
    array['offering_id'] = "{{$offering_id}}";
    array['override'] = override;
    $.ajax({
        type: "GET",
        url: "/ajax/admin/faculty_loading/override_add",
        data: array,
        success: function(data){
            displaycourses('{{$level}}',"{{$instructor}}");
            getCurrentLoad("{{$instructor}}",'{{$level}}');
            $('#modalunits').modal('toggle');
        }, error: function(xhr){
            if(xhr.status == 500){
                toastr.error('Conflict in Schedule Found!!','Message!');
            }else{
                toastr.error('Something Went Wrong!','Message!');
            }
        }
    })
}
</script>