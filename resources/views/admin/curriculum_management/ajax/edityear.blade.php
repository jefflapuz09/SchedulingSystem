<div class="modal-dialog">
    <!--Modal Content-->
    <div class="modal-content">
        <div class="modal-header bg-maroon">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><b>Edit Year</b></h4>
        </div>
        <div class="modal-body bg-gray-light">
            <input type="hidden" id="curriculum_year" value="{{$edityear->curriculum_year}}">
            <div class="row">
                <div class="col-sm-12">
                    {{ csrf_field() }}
                    <div class="form form-group">
                        <label for="refid"><b>Year</b></label>
                        <input type="text" id="year_val" class="form-control" value="{{$edityear->curriculum_year}}" class="form form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer bg-gray-light">
            <div class="row">
                <div class="col-sm-6">
                    <button type="button" class="btn btn-danger form form-control" data-dismiss="modal">Close</button>
                </div>
                <div class="col-sm-6">
                    <button value="Add" onclick="updateyear(curriculum_year.value,year_val.value)" class="btn-success form form-control">Update</button>
                </div>
            </div>            
        </div>
    </div>
</div>
<script>
    function updateyear(curriculum_year, year_val){
        var array = {};
        array['curriculum_year'] = curriculum_year;
        array['year_val'] = year_val;
        array['program_code'] = "{{$program_code}}";
        $.ajax({
            type: "GET",
            url: "/admin/curriculum_management/ajax/updateyear",
            data: array,
            success: function(data){
                status = data['status'];
                message = data['message'];
                
                    $('#editmodal').modal('toggle');
                    
                    toastr.success('Updated Successfully!', 'Success!');
                    refreshtable(year_val,'{{$program_code}}');
            },error: function(){
              toastr.error('Something Went Wrong!', 'Error!');  
            }
        })
    }
</script>