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
                            Submit Task
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">{{$task->task }}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('task.submit-task')}}" method="post" class="form-group" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                      <div class="form-group ">
                                        <div class="row p-3">
                                            @if ($task->feedback)
                                                <div class="mb-3">
                                                    <h6><strong>Feedback: </strong> {{$task->feedback }}</h6>
                                                </div>
                                            @endif
                                            <div class="input-group mb-4" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Add Document</span>
                                                </div>
                                                <input  type="file" name="document" class="form-control"  value="{{$task->task}}" required>
                                            </div>
                                            <input type="hidden" name="task_id" id="task_id" class="form-control" value="{{ $task->id }}" required>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
                                      </div>
                                  </form>
                              </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>
</div>

<!-- Edit task modal -->

  <!-- /.modal -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#region_target').val({{$task->region_target}});
    $('#website_id').val({{$task->website_id}});
});
//function for player live search
function searchUser(str) {
    $.ajax({
        method: 'POST',
        url: '{{ route('search-user')}}',
        data:{q: str,"_token": "{{ csrf_token() }}", from:'admin'}

    })
    .done(function(msg){
        if (msg.length) {
            $('#user-search').html(msg);
        }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });

}

//select user

function selectUser(user) {
    $('#user_id').val(user.id);
    $('#user_name').val(user.name);
    $('#user-search').html('');

}

</script>

@endsection
