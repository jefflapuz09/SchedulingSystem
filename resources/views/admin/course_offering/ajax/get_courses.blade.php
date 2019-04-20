@if(!$courses->isEmpty())
<div class="box box-default">
    <div class="box-header"><h5 class="box-title">Courses to Offer</h5></div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th width="35%">Description</th>
                        <th>Lec</th>
                        <th>Lab</th>
                        <th>Units</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{$course->course_code}}</td>
                        <td>{{$course->course_name}}</td>
                        <td>{{$course->lec}}</td>
                        <td>{{$course->lab}}</td>
                        <td>{{$course->units}}</td>
                        <td class="text-center"><button  onclick="addoffer('{{$course->id}}')" class="btn btn-success btn-flat"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="box box-default">
    <div class="box-header"><h5 class="box-title">Courses to Offer</h5></div>
    <div class="box-body">
        <div class="callout callout-warning">
            <h5>No Courses to Offer Found!</h5>
        </div>
    </div>
</div>
@endif

<script>
function addoffer(course_id){
    var array = {};
    if('{{$section_name}}' != ""){
        array['course_id'] = course_id;
        array['section_name'] = '{{$section_name}}';
        
        
        $.ajax({
            type: "GET",
            url: "/ajax/admin/course_offerings/add_course_offer",
            data: array,
            success: function(data){
                toastr.success(data,'Notification!');
                searchcourse('{{$curriculum_year}}','{{$level}}','{{$period}}','{{$section_name}}')
            }
        })
    }else{
        alert('Please input a section name');
    }
}
</script>