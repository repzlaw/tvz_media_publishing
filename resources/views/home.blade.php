@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-md-9 m-auto">
                    <div class="card-hover-shadow-2x mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                                <h5>Notifications</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (count($logs))
                                {{-- <p>page {{ $logs->currentPage() }} of {{ $logs->lastPage() }} , displaying {{ count($logs) }} of {{ $logs->total() }} record(s) </p> --}}
                                @foreach ($logs as $key=>$log)
                                    <p>{{$key}}</p>
                                    <ul class="list-group list-group-flush">
                                        @foreach ($log as $keys=>$lo)
                                        <li class="list-group-item p-4" id="list-group{{$lo->id}}"
                                            style="background:{{$lo->status === 'unseen' ?  '#e7f1fc' : 'white'}}; border-radius:5%">
                                            <a href="{{route('notification.single',['log'=>$lo->id])}}" 
                                                style="text-decoration: none;" class="mt-5">
                                                {{$lo->message}}
                                            </a>
                                                <span class="float-end">{{ Carbon\Carbon::parse($lo->created_at)->format('g:i A' ) }} 
                                                    <button class="ms-3" id="status-button{{$lo->id}}"
                                                        style="border-radius:25%" onclick="notificationStatus('{{$lo->id}}')">{{$lo->status === 'unseen' ? 'mark read': 'mark unread'}} </button>
                                                </span>
                                                <br>
                                        </li>
                                        @endforeach 
                                    </ul>
                                @endforeach
                                {{-- {{ $logs->links() }} --}}

                            @else
                                <div class="alert alert-info text-center">
                                    <b>No notifications yet</b>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function notificationStatus(id) {
    $.ajax({
            method:'POST',
            url: '{{ route('notification.change-status')}}',
            data:{notification_id:id, cat:status, "_token":"{{csrf_token()}}"}
        })
        .done(function(res){
            if (res.status === 'seen') {
                $("#list-group"+res.id).css('background','white')
                $("#status-button"+res.id).text('mark unread')
            }else{
                $("#list-group"+res.id).css('background','#e7f1fc')
                $("#status-button"+res.id).text('mark read')
            }
        })
}
</script>

@endsection
