<html>
    <head>
        <style>
        .a{
            text-align: center;
            text-transform: uppercase;
            font-size: 20px;
        }
        .b{
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
        }
        .c{
            text-align: center;
            font-size: 15px;
        }
        </style>
    </head>
    <body>
        <div class="a">
            <b>Sample School</b>
             </div>
        <div class="b">
        
            Rooms with Occupied Schedule
            </div>
        <div class="c">
        
        Report as of {{date('Y-m-d')}}
        </div>
        <table border="1" style="margin-top:20px;" width="100%" cellspacing="0" cellpadding="2px">
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
    </body>
</html>