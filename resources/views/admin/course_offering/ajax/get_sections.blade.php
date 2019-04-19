<label>Section</label>
<select class="form-control" id="section_name">
    @foreach($sections as $section)
    <option value="{{$section->section_name}}">{{$section->section_name}}</option>
    @endforeach
</select>