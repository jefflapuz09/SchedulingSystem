@if(count($schedules)>0)
<div class="box box-default">
    <div class="box-header">
        <h5 class="box-title">Search Results</h5>
        <div class="box-tools pull-right">
            <a href="{{url('/admin/reports/print_rooms_occupied',array($room))}}" target="_blank" class="btn btn-flat btn-primary"><i class="fa fa-print"></i> Generate PDF</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th>Day</th>
                        <th>Schedule</th>
                        <th>Room</th>
                        <th>Building</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                    <?php $detail_room = \App\CtrRoom::where('room',$schedule->room)->first(); ?>
                    <tr>
                        <td>{{$loop->iteration}}</td> 
                        <td>{{$schedule->day}}</td>
                        <td>{{date('g:i A',strtotime($schedule->time_starts))}} - {{date('g:i A',strtotime($schedule->time_end))}}</td>
                        <td>{{$schedule->room}}</td>
                        <td>{{$detail_room->building}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="box box-danger">
    <div class="box-header"><h5 class="box-title">Search Results</h5></div>
    <div class="box-body">
        <div align="callout callout-warning">
            <div align="center">
                <h5>No Results Found!</h5>
            </div>
        </div>
    </div>
</div>
@endif