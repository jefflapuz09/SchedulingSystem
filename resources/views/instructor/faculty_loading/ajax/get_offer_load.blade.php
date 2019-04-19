<div class="modal fade" id="modal-primary">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header bg-primary">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Are you willing to accept the faculty load?</h4>
    </div>
      <div class="modal-body">
          <div class="table-responsive">
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
                    @foreach($schedules as $schedule)
                    <?php
                    $course_detail = \App\curriculum::join('offerings_infos','offerings_infos.curriculum_id','curricula.id')
                      ->where('offerings_infos.id',$schedule->offering_id)->first(['curricula.course_code','curricula.course_name','offerings_infos.section_name']);
                    ?>
                    <tr>
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
          </div>
          <div class="form-group">
              <br>
              <label>If reject, please state your reason.</label>
              <textarea class="form-control" id="reason"></textarea>
          </div>
      </div>
    <div class="modal-footer">
      <button type="button" onclick="reject_offer('{{$offering_id}}',reason.value)" class="btn btn-danger btn-flat btn-outline pull-left">Reject Load</button>
      <button type="button" onclick="accept_load('{{$offering_id}}')" class="btn btn-primary btn-flat btn-outline">Accept Load</button>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>