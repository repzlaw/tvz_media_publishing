@extends('layouts.app')
@section('links')
@endsection
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            Tasks
                        </div>
                        <div class="float-end">
                            @if (Auth::user()->type ==='Admin')
                                <p><a href="{{route('task.create-view')}}" class="btn btn-primary btn-sm"  id="create-button">Create Task</a></p>

                            @else

                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <p>page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }} , displaying {{ count($tasks) }} of {{ $tasks->total() }} record(s) </p>

                        <table id="task_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="27%">task</th>
                                    <th width="27%">topic</th>
                                    <th width="30%">instructions</th>
                                    <th width="10%">status</th>
                                    <th width="5%">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $key =>$task)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$task->task}}</td>
                                        <td>{{$task->topic}}</td>
                                        <td>{{$task->instructions}}</td>
                                        <td>{{$task->status}}</td>
                                        <td class="text-center">

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-th"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if (Auth::user()->type ==='Admin')
                                                        <a href="{{route('task.edit-view',['id'=>$task->id])}}" class="dropdown-item btn btn-outline-dark btn-sm mr-3" > Edit</a>
                                                        @if ($task->status !== 'Pending')
                                                            <a href="{{route('task.review-view',['id'=>$task->id])}}" class="dropdown-item btn btn-outline-dark btn-sm mr-3" > Review</a>

                                                        @endif
                                                    @else
                                                        <a href="{{route('task.submit-view',['id'=>$task->id])}}" class="dropdown-item btn btn-outline-dark btn-sm mr-3" > Submit</a>

                                                        {{-- <a href="{{route('task.submit-view',['id'=>$task->id])}}">
                                                            <button class=" btn-icon btn-hover-shine btn-shadow btn-dashed btn btn-outline-success btn-sm">Submit</button>
                                                        </a> --}}
                                                    @endif
                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $tasks->links() }}

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
