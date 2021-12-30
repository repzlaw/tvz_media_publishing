@extends('layouts.app')
@section('style')
    a:visited {
        color: #1a0dab;
    }
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
                        @if (Auth::user()->type =='Admin')
                            <form action="{{ route('task.search')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Search by</span>
                                            </div>
                                            <select class="form-control custom-select" name="search_column" id="search_column" required>
                                                <option value="">-- select column -- </option>
                                                <option value="name">User's name </option>
                                                <option value="date">Date Assigned </option>
                                                <option value="desc">Task Description </option>
                                                <option value="type">Task Type </option>
                                                <option value="region">Region </option>
                                                <option value="website">Website </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4" id="search_div">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="query" name="query" placeholder="Search..." aria-label="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <p>page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }} , displaying {{ count($tasks) }} of {{ $tasks->total() }} record(s) </p>

                        <table id="task_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th width="27%">task</th>
                                    <th width="27%">topic</th>
                                    <th width="30%">instructions</th>
                                    <th width="10%">assigned on</th>
                                    <th width="5%">status</th>
                                    <th width="10%">type</th>
                                    <th width="5%">word count</th>
                                    <th width="10%">submitted on</th>
                                    @if (Auth::user()->type =='Admin')
                                        <th width="5%">action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tasks as $key =>$task)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><a href="{{route('task.conversation.all',['task_id'=>$task->id])}}">{{$task->task}} </a></td>
                                        <td>{{$task->topic}}</td>
                                        <td>{{$task->instructions}}</td>
                                        <td>{{$task->task_given_on}}</td>
                                        <td>
                                            @if ($task->status == 'Pending' )
                                                <span class="ms-2 me-2 badge bg-pill bg-info"> {{$task->status}}</span>
                                            @elseif ($task->status == 'Submitted')
                                                <span class="ms-2 me-2 badge bg-pill bg-primary"> {{$task->status}}</span>
                                            @elseif ($task->status == 'Approved')
                                                <span class="ms-2 me-2 badge bg-pill bg-success"> {{$task->status}}</span>
                                            @else
                                                <span class="ms-2 me-2 badge bg-pill bg-warning"> {{$task->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{$task->task_type}}</td>
                                        <td>{{$task->word_count}}</td>
                                        <td>{{$task->task_submitted_on}}</td>
                                        @if (Auth::user()->type =='Admin')
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-th"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        @if (Auth::user()->type ==='Admin')
                                                            <a href="{{route('task.edit-view',['id'=>$task->id])}}" class="dropdown-item btn btn-outline-dark btn-sm mr-3" > Edit</a>
                                                            @if ($task->status !== 'Pending')
                                                                {{-- <a href="{{route('task.review-view',['id'=>$task->id])}}" class="dropdown-item btn btn-outline-dark btn-sm mr-3" > Review</a> --}}
                                                            @endif
                                                        @else
                                                            {{-- <a href="{{route('task.submit-view',['id'=>$task->id])}}" class="dropdown-item btn btn-outline-dark btn-sm mr-3" > Submit</a> --}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <div class="alert alert-info text-center">
                                        <b>No Task found</b>
                                    </div>
                                @endforelse 
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
//hide/show search based on select dropdown
$("#search_column").change(function() {
  if ($(this).val() !== "") {
    $('#search_div').show();
    if ($(this).val() == "name") {
        $('#query').attr('type', 'text');
    }else if($(this).val() == "date"){
        $('#query').attr('type', 'date');
    }else if($(this).val() == "desc"){
        $('#query').attr('type', 'text');
    }else if($(this).val() == "type"){
        $('#query').attr('type', 'text');
    }else if($(this).val() == "region"){
        $('#query').attr('type', 'text');
    }else if($(this).val() == "website"){
        $('#query').attr('type', 'text');
    }
    $('#query').attr('required', '');
    $('#query').attr('data-error', 'This field is required.');
  } else {
    $('#search_div').hide();
    $('#query').removeAttr('required');
    $('#query').removeAttr('data-error');
  }
});
$("#search_column").trigger("change");

</script>

@endsection
