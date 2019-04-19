<div class="modal fade" id="editModal">
    <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{url('/curriculum_management/edit_curriculum')}}" method="post">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">{{$course->course_code}} - {{$course->course_name}}</h4>
        </div>
        <div class="modal-body">
            {{csrf_field()}}
            <input type="hidden" name="curriculum_id" value="{{$course->id}}">
                <div class="form-group">
                    <label>Course Code</label>
                    <input type="text" name="course_code" class="form-control" value="{{$course->course_code}}">
                </div>
                <div class="form-group">
                    <label>Course Name</label>
                    <input type="text" name="course_name" class="form-control" value="{{$course->course_name}}">
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Lec</label>
                            <input type="text" name="lec" class="form-control" value="{{$course->lec}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Lab</label>
                            <input type="text" name="lab" class="form-control" value="{{$course->lab}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Units</label>
                            <input type="text" name="units" class="form-control" value="{{$course->units}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Computer Lab?</label>
                    <select class='form-control' name='complab'>
                        <option @if($course->is_complab == 0) selected='selected' @endif value='0'>No</option>
                        <option @if($course->is_complab == 1) selected='selected' @endif value='1'>Yes</option>
                    </select>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-flat btn-primary">Save changes</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>