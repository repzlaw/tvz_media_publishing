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
                           Create Tasks
                        </div>
                        <div class=" float-right">
                            <p><a href="{{route('admin.task.create-view')}}" class="btn btn-primary btn-sm"  id="create-button">Create Task</a></p>
                        </div>
                    </div>
                    <div class="card-body">

                        <table id="log_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                            <thead>
                                <tr>
                                <th width="3%">#</th>
                                <th width="7%">task</th>
                                <th width="7%">topic</th>
                                <th width="10%">instructions</th>
                                <th width="10%">Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $key =>$log)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$log->task}}</td>
                                        <td>{{$log->topic}}</td>
                                        <td>{{$log->instructions}}</td>
                                        <td>{{$log->created_at}}</td>
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

<!-- create task modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create task</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.task.create-view')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Task</span>
                    </div>
                    <input  type="text" name="task" class="form-control"  value="{{ old('task') }}" required>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Topic</span>
                    </div>
                    <input  type="text" name="topic" class="form-control" value="{{ old('topic') }}" required>
                </div>
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Assign to</span>
                    </div>
                    <input  type="text" name="instructions" class="form-control" placeholder="select user ..." value="{{ old('instructions') }}" required>
                </div>
                <!-- <input type="file" name="featured_image" id="featured_image" class="form-control" placeholder="Upload Team Image ..." value="{{ old('featured_image') }}" required> -->
                <!-- <br>
                </div> -->
                <textarea name="instructions" id="instructions" rows="5" class="form-control"  placeholder="enter instructions ..." value="{{ old('instructions') }}" required></textarea>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id = "modal-save">Save changes</button>
              </div>
          </form>
        </div>
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
//create modal
// $('#create-button').on('click',function(event){
//     event.preventDefault();
//     $('#create-modal').modal();
// });

//modal to edit sport
function edit(sport){
    // console.log(sport);
    $('#meta_description').val(sport.meta_description);
    $('#page_title').val(sport.page_title);
    $('#sport_type').val(sport.sport_type);
    $('#sport_id').val(sport.id);
    $('#edit-modal').modal();
}

</script>

@endsection
