@if(!$offerings->isEmpty())
<div class="box box-default">
    <div class="box-header"><h5 class="box-title">Courses Offered</h5></div>
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
                    @foreach($offerings as $offering)
                    <?php $curriculum = \App\curriculum::find($offering->curriculum_id); ?>
                    <tr>
                        <td>{{$curriculum->course_code}}</td>
                        <td>{{$curriculum->course_name}}</td>
                        <td>{{$curriculum->lec}}</td>
                        <td>{{$curriculum->lab}}</td>
                        <td>{{$curriculum->units}}</td>
                        <td class="text-center"><button  onclick="removeoffer('{{$curriculum->id}}','{{$section_name}}')" class="btn btn-danger btn-flat"><i class="fa fa-times"></i></button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="box box-default">
    <div class="box-header"><h5 class="box-title">Courses Offered</h5></div>
    <div class="box-body">
        <div class="callout callout-warning">
            <h5>No Course Offered Found!</h5>
        </div>
    </div>
</div>
@endif

<script>
    function removeoffer(curriculum_id,section_name){
        var array = {};
        array['curriculum_id'] = curriculum_id;
        array['section_name'] = section_name;

        $.ajax({
            type: "GET",
            url :"/ajax/admin/course_offerings/remove_course_offer",
            data: array,
            success: function(data){
                toastr.error(data,'Notification!');
                searchcourse('{{$curriculum_year}}','{{$level}}','{{$period}}','{{$section_name}}')
            }, error: function(){
                alert('Something Went Wrong');
            }
        })
    }
</script>