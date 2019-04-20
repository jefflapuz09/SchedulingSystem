<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">{{$program->program_name}}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class='table-responsive'>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Curriculum Year</th>
                    <th class="text-center" width="30%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($curricula as $curriculum)
                <tr>
                    <td>{{$curriculum->curriculum_year}} - {{$curriculum->curriculum_year+1}}</td>
                    <td class="text-center"><a href="{{url('/admin', array('curriculum_management','list_curriculum',$program_code,$curriculum->curriculum_year))}}" class="btn btn-flat btn-success"><i class="fa fa-eye"></i></a>
                        <a onclick="displayedityear('{{$curriculum->curriculum_year}}','{{$program_code}}')" class="btn btn-flat btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>