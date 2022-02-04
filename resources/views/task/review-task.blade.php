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
                            Review Task
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">{{$task->task }}</h4>
                                  {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('task.submit-review')}}" method="post" class="form-group" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                      <div class="form-group ">
                                          <div class="row p-3">

                                            <div class="ml-5 col-md-5 mb-3" >
                                                <a class="btn btn-success" href="/storage/tasks/{{$task->file_path}}" download>
                                                    <i class="fa fa-download mr-2" aria-hidden="true"></i>
                                                    Download document
                                                </a>
                                            </div>

                                            <div class="input-group mb-4 col-md-6 col-6">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Status</span>
                                                </div>
                                                <select class="form-control custom-select" name="status" id="status" required>
                                                    <option value="Submitted">Submitted </option>
                                                    <option value="Pending">Pending </option>
                                                    <option value="Correction Required">Correction Required </option>
                                                    <option value="Approved">Approved </option>
                                                </select>
                                            </div>
                                            <textarea name="feedback" id="feedback" rows="5" class="form-control"  placeholder="Enter Feedback ..." value="{{ old('feedback') }}" required>{{ $task->feedback }}</textarea>
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
window.onload = function () {
    // console.log('23');
    $('#status').val("{{$task->status}}");
};

//download document
function downloadDocument(task){
    $.ajax({
        method: 'POST',
        url: '{{ route('task.download-document')}}',
        data:{task_id:task.id, "_token": "{{ csrf_token() }}"}

    })
    .done(function(msg){
        console.log(msg);
        // if (msg.length) {
        //     $('#user-search').html(msg);
        // }
    })
    .fail(function(xhr, status, error) {
        // alert(error)
    });
}


</script>

@endsection
