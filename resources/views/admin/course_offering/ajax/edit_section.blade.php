
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{$section->section_name}}</h4>
      </div>
      <div class="modal-body">
        <form action="{{url('/admin/section_management/update')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="section_id" value="{{$section->id}}">
        <div class='form-group'>
            <label>Academic Program</label>
            <select name="program_code" class='form-control'>
                @foreach($programs as $program)
                <option @if($section->program_code == $program->program_code) selected="selected" @endif>{{$program->program_code}}</option>
                @endforeach
            </select>
        </div>
        <div class='form-group'>
            <label>Level</label>
            <select name="level" class='form-control'>
                <option @if($section->level == '1st Year') selected="selected" @endif>1st Year</option>
                <option @if($section->level == '2nd Year') selected="selected" @endif>2nd Year</option>
                <option @if($section->level == '3rd Year') selected="selected" @endif>3rd Year</option>
                <option @if($section->level == '4th Year') selected="selected" @endif>4th Year</option>
                <option @if($section->level == '5th Year') selected="selected" @endif>5th Year</option>

            </select>
        </div>
        <div class='form-group'>
            <label>Section</label>
            <input id="section_name" value="{{$section->section_name}}" name="section_name" type="text" class="form-control">
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
