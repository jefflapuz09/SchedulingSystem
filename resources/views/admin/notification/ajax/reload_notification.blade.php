<?php use Carbon\Carbon;?>
@if(count($notifications)>0)
<table class="table table-bordered table-striped" id="example2">
    <thead>
        <tr>
            <th width="2%">#</th>
            <th width="20%">Date Time</th>
            <th width="70%">Content</th>
            <th width="5%">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notifications as $notif)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{Carbon::parse($notif->date_time)->diffForHumans()}}</td>
            <td>{{$notif->content}}</td>
            <td>
                @if($notif->is_trash == 0)
                <label onclick="changenotifstatus('{{$notif->id}}')" class="label label-warning">Unread</label>
                @else
                <label class="label label-info">Read</label>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="callout callout-warning">
    <div align="center"><h5>No Notifications!</h5></div>
</div>
@endif