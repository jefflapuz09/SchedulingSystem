
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Available Rooms</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('/admin/course_scheduling/add_schedule')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="offering_id" value="{{$offering_id}}">
        <input type="hidden" name="day" value="{{$day}}">
        <input type="hidden" name="time_start" value="{{$time_start}}">
        <input type="hidden" name="time_end" value="{{$time_end}}">
        <input type="hidden" name="section_name" value="{{$section_name}}">
        <div class='form-group'>
            <label>Available Rooms</label>
            <select name="room" class='form-control'>
                @foreach($rooms as $room)
                <option value='{{$room->room}}'>{{$room->room}} {{$room->building}}</option>
                @endforeach
            </select>
        </div>
        <div class='form-group'>
            <button  type='submit' class='btn btn-flat btn-success btn-block'>Save and Submit</button>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
