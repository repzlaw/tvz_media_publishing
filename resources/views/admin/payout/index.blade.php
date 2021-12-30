@extends('layouts.app')
@section('content')
<div class="container mt-2">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-2 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>payouts</h5>
                        </div>
                        <div class=" float-end">
                            <p><a href="{{route('admin.payout.create-view')}}" class="btn btn-primary btn-sm"  id="create-button"
                                >Create payout</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($payouts))
                            <p>page {{ $payouts->currentPage() }} of {{ $payouts->lastPage() }} , displaying {{ count($payouts) }} of {{ $payouts->total() }} record(s) </p>
                            <table id="payout_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                    <th width="5%">#</th>
                                    <th>task topic</th>
                                    <th width="13%">amount</th>
                                    <th width="13%">assigned to</th>
                                    <th width="13%">status</th>
                                    <th width="13%">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payouts as $key =>$payout )
                                        <tr>
                                            <td >{{$key+1}}</td>
                                            <td>{{$payout->task ? $payout->task->topic : 'No task mapped' }}</td>
                                            <td>{{$payout->amount}}</td>
                                            <td>{{$payout->user->name}}</td>
                                            <td>
                                                @if ($payout->status === 'Completed')
                                                    <div class="ml-1 badge bg-pill bg-success"> {{$payout->status}}</div></td>
                                                @else
                                                    <div class="ml-1 badge bg-pill bg-warning"> {{$payout->status}}</div></td>
                                                @endif
                                            </td>
                                            <td class="text-center m-auto">
                                                <a href="{{ route('admin.payout.edit-view',['id'=>$payout->id])}}">
                                                    <i class='fa fa-edit text-success me-3' style='cursor: pointer;'></i>
                                                </a>
                                                {{-- <a href="{{ route('admin.payout.delete',[ 'id'=>$payout->id])}}">
                                                    <i class='fa fa-trash text-danger me-3' style='cursor: pointer;' ></i>
                                                </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $payouts->links() }}

                        @else
                            <div class="alert alert-info text-center">
                                <b>No payouts found</b>
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
