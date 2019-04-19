<div class='form-group'>
    <label>Section</label>
    <select class='select2 form-control' id='section' onchange='getcoursesoffered(program_code.value,level.value,this.value)'>
        <option>Please Select</option>
        @foreach($sections as $section)
        <option value='{{$section->section_name}}'>{{$section->section_name}}</option>
        @endforeach
    </select>
</div>