
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$room->room}} {{$room->building}}</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('/admin/room_management/update')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="room_id" value="{{$room->id}}">
        <div class='form-group'>
            <label>Room</label>
            <input type='text' value="{{$room->room}}" class='form-control' name='room'>
        </div>
        <div class='form-group'>
            <label>Building</label>
            <input type='text' value="{{$room->building}}" class='form-control' name='building'>
        </div>
        <div class='form-group'>
            <label>Description</label>
            <input type='text' value="{{$room->description}}" class='form-control' name='description'>
        </div>
        <div class='form-group'>
            <button onclick='return confirm("Clicking the OK button will modify the record? Do you wish to continue?")' type='submit' class='btn btn-flat btn-success btn-block'>Save and Submit</button>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
