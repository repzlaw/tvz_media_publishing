@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-2 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Conversations</h5>
                        </div>
                        <div class="float-end">
                            <a class="btn btn-dark btn-sm me-1" href="{{route('task.view-notes',['task'=>$task->id])}}">
                                <i class="fa fa-book me-1" aria-hidden="true"></i>
                                View Notes
                            </a>
                            @if (Auth::user()->type ==='Admin')
                                <a class="btn btn-warning btn-sm me-1" href="{{route('task.review-view',['id'=>$task->id])}}">
                                    <i class="fa fa-pencil me-1" aria-hidden="true"></i>
                                    Review Task
                                </a>
                            @else
                                @if ($task->status === 'Pending')
                                    <a href="{{route('task.acknowledge',['task'=>$task->id])}}" 
                                        class="btn btn-secondary btn-sm me-1" > 
                                        <i class="fa fa-check me-1" aria-hidden="true"></i>
                                    Acknowledge</a>
                                @endif
                            @endif
                            <a class="btn btn-primary btn-sm me-1" href="{{route('task.submit-view',['id'=>$task->id])}}">
                                <i class="fa fa-upload me-1" aria-hidden="true"></i>
                                Upload document
                            </a>
                            @if ($task->file_path)
                                <a class="btn btn-success btn-sm" href="/storage/tasks/{{$task->file_path}}" download="{{$task->task}}">
                                    <i class="fa fa-download me-1" aria-hidden="true"></i>
                                    Download document
                                </a>
                            @endif
                            @if ($task->status !== 'Cancelled')
                                <a href="javascript:void(0)" id="cancel-task-button" onclick='cancelTask({{$task}})'
                                    class="btn btn-danger btn-sm" > 
                                    <i class="fa fa-times me-1" aria-hidden="true"></i>
                                    Cancel Task</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold"> name :</b>
                                            </div>
                                                <b class="ms-2 text">{{$task->task}}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold">status :</b>
                                            </div>
                                            <b class="ms-2 text">
                                                @if ($task->status == 'Pending' )
                                                    <span class="ms-2 me-1 badge bg-pill bg-info"> {{$task->status}}</span>
                                                @elseif ($task->status == 'Submitted')
                                                    <span class="ms-2 me-1 badge bg-pill bg-primary"> {{$task->status}}</span>
                                                @elseif ($task->status == 'Approved')
                                                    <span class="ms-2 me-1 badge bg-pill bg-success"> {{$task->status}}</span>
                                                @elseif ($task->status == 'Cancelled')
                                                    <span class="ms-2 me-1 badge bg-pill bg-danger"> {{$task->status}}</span>
                                                @elseif ($task->status == 'Acknowledged')
                                                    <span class="ms-2 me-1 badge bg-pill bg-secondary"> {{$task->status}}</span>
                                                @elseif ($task->status == 'Feedback')
                                                    <span class="ms-2 me-1 badge bg-pill bg-dark"> {{$task->status}}</span>
                                                @else
                                                    <span class="ms-2 me-1 badge bg-pill bg-warning"> {{$task->status}}</span>
                                                @endif    
                                            </b>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold">created by :</b>
                                            </div>
                                            <b class="ms-2 text">{{$task->created_by->name}}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold">assigned on :</b>
                                            </div>
                                            <b class="ms-2 text">{{$task->created_at}}</b>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="col-sm-12">
                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold">topic :</b>
                                            </div>
                                            <b class="ms-2 text">{{$task->topic}}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold">word limit :</b>
                                            </div>
                                            <b class="ms-2 text">{{$task->word_limit}}</b>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="input-group">
                                            <div class="input-group-prepend">
                                                <b class="ms-1 font-weight-bold">assigned to :</b>
                                            </div>
                                            <b class="ms-2 text">{{$task->assigner_user->name}}</b>
                                            </div>
                                        </div>

                                        
                                        
                                    </div>
                                </div>
                                @if ($task->feed_back)
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <b class="ms-1 font-weight-bold">feedback :</b>
                                        </div>
                                        <b class="ms-2 text">{{$task->feed_back ? $task->feed_back->feedback : ''}}</b>
                                        </div>
                                    </div>
                                    
                                @endif
                                <div class="col-md-12 mb-2">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <b class="ms-1 font-weight-bold">instructions :</b>
                                    </div>
                                    <b class="ms-2 text">{{$task->instructions}}</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if (count($conversations))
                            @foreach ( $conversations as $conversation)
                                <div class="posts">
                                    <span class="ms-2 me-1 badge bg-pill {{$conversation->sender_id == Auth::id() ? 
                                        'bg-success' : 'bg-info'}} posts "> {{$conversation->sender_id == Auth::id() ? 'You': $conversation->user->name}}</span>
                                    <small>{{$conversation->created_at}}</small>
                                    <div class="ms-3 mb-2">{{$conversation->message}} </div> 
                                    @if ($conversation->file_path)
                                        <div class="ms-5">
                                            <a class="btn btn-outline-secondary" href="/storage/tasks/attachments/{{$conversation->file_path}}" 
                                                download="attachment">
                                                    <i class="fa fa-file me-1"></i> {{$conversation->file_path}} </a>
                                        </div>
                                    @endif

                                </div>
                                <hr>
                                
                            @endforeach
                            

                        @else
                            <div class="alert alert-info text-center mb-3">
                                <b>{{$task->status !== 'Cancelled' ? 'Start conversation' : 'No conversation'}}</b>
                            </div>
                        @endif
                        <div id="div1">
                            @if ($task->status !== 'Cancelled')
                                <form action="{{route('task.conversation.store',['task_id'=>$task->id])}}" method="post" class="form-group mt-5" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="interaction mt-3 mb-3 row">
                                        <div class="col-10 col-sm-10" style="padding-right: 0;">
                                            <textarea placeholder="Add conversation ..." name="message" type="text" 
                                            class="form-control-lg form-control mb-3" style="border-radius: 20px !important;" required></textarea>
                                        </div>
                                        <div class="col-2 col-sm-2 mt-3 float-right">
                                            <i class="fa fa-paperclip me-1" style="cursor: pointer" id="attach-button"></i>
                                            <button type="submit" class="btn btn-primary b-circle ms-2">
                                                <i class="fa fa-paper-plane"></i>
                                            </button>
                                        </div> 
                                    </div>
                                    <input type="hidden" name="task_id" value="{{$task->id}}">
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- attach document modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "attach-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Attach Document</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('task.conversation.store')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-2" >
                    <div class="input-group-prepend">
                    </div>
                    <input type="file" name="attachment"class="form-control" value="{{ old('name') }}" required>
                </div>

                <input  type="text" name="message" class="form-control" placeholder="message" value="{{ old('message') }}" required>
                <input type="hidden" name="task_id" value="{{$task->id}}">

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-save">Save changes</button>
              </div>
            </div>
          </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
  <!-- /.modal -->

<!-- cancel task modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "cancel-task-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cancel task</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('task.cancel')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <div class="input-group mb-4" >
                    <textarea name="reason" placeholder="Type reason here" class="form-control" required></textarea>
                </div>
                <input type="hidden" name="task_id" id="task_id">
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-save">Save changes</button>
              </div>
          </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
  <!-- /.modal -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $("html, body").animate({ scrollTop: $(document).height() }, 0000);
});

//create modal
$('#attach-button').on('click',function(event){
    event.preventDefault();
    $('#attach-modal').modal('show');
});

//cancel-task modal
function cancelTask(task){
    $('#task_id').val(task.id);
    $('#cancel-task-modal').modal('show');
}

</script>

@endsection
