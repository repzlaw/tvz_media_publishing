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
                           {{-- Create Tasks --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Create Task</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('task.store')}}" method="post" class="form-group" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                      <div class="form-group row">

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
                                        <div class="input-group mb-4 col-md-6" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Region</span>
                                            </div>
                                            <select class="form-control custom-select" name="region_target" required>
                                                <option value="">-- Select Region -- </option>
                                                @foreach ($regions as $region)
                                                <option value="{{$region->id}}">{{$region->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="input-group mb-4 col-md-6" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Website</span>
                                            </div>
                                            <select class="form-control custom-select" name="website_id" required>
                                                <option value="">-- Select Website -- </option>
                                                @foreach ($websites as $website)
                                                <option value="{{$website->id}}">{{$website->url}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div  class="col-12 col-md-6 mb-3">
                                            <input placeholder="search User" autocomplete="off" type="text" size="30" name="user_name" class="form-control" id="user_name" onkeyup="searchUser(this.value)" required>
                                            <ul id="user-search" class="list-group"></ul>

                                        </div>
                                         <input type="hidden" name="assigned_to" id="user_id" class="form-control" value="{{ old('assigned_to') }}" required>
                                        <textarea name="instructions" id="instructions" rows="5" class="form-control"  placeholder="type instructions ..." value="{{ old('instructions') }}" required></textarea>
                                      <div class="modal-footer">
                                        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
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
</div>

<!-- create task modal -->

  <!-- /.modal -->
@endsection

@section('scripts')
<script>
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
