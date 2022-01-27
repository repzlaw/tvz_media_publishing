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
                            @if (Auth::user()->type ==='Admin')
                                <a class="btn btn-warning me-2" href="{{route('task.review-view',['id'=>$task->id])}}">
                                    <i class="fa fa-pencil mr-2" aria-hidden="true"></i>
                                    Review Task
                                </a>
                            @else

                            @endif
                            <a class="btn btn-primary me-2" href="{{route('task.submit-view',['id'=>$task->id])}}">
                                <i class="fa fa-upload mr-2" aria-hidden="true"></i>
                                Upload document
                            </a>
                            @if ($task->file_path)
                                <a class="btn btn-success" href="/storage/tasks/{{$task->file_path}}" download="{{$task->task}}">
                                    <i class="fa fa-download mr-2" aria-hidden="true"></i>
                                    Download document
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container text-center">
                            <h5><strong>{{$task->instructions}}</strong> </h5>
                        </div>
                        <hr>
                        @if (count($conversations))
                            @foreach ( $conversations as $conversation)
                                <div class="posts">
                                    <span class="ms-2 me-2 badge bg-pill {{$conversation->sender_id == Auth::id() ? 
                                        'bg-success' : 'bg-info'}} posts "> {{$conversation->user->name}}</span>
                                    <small>{{$conversation->created_at}}</small>
                                    <div class="ms-3 mb-2">{{$conversation->message}} </div> 
                                    @if ($conversation->file_path)
                                        <div class="ms-5">
                                            <a class="btn btn-outline-secondary" href="/storage/tasks/attachments/{{$conversation->file_path}}" 
                                                download="attachment">
                                                    <i class="fa fa-file me-2"></i> {{$conversation->file_path}} </a>
                                        </div>
                                    @endif

                                </div>
                                <hr>
                                
                            @endforeach
                            

                        @else
                            <div class="alert alert-info text-center mb-3">
                                <b>Start conversation</b>
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
                                            <i class="fa fa-paperclip me-2" style="cursor: pointer" id="attach-button"></i>
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

</script>

@endsection
