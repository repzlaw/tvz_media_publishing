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
                                        <li class="list-group-item p-4 " style="background:{{$lo->status === 'unseen' ?  '#e7f1fc' : 'white'}}; border-radius:5%">
                                            <a href="{{route('notification.single',['log'=>$lo->id])}}" 
                                                style="text-decoration: none;">
                                                {{$lo->message}}
                                                <span class="float-end">{{$lo->created_at->diffForHumans()}} </span>
                                            </a>
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

</script>

@endsection
