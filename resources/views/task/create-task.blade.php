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
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('task.store')}}" method="post" class="form-group" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                      <div class="form-group row">

                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Task Description</span>
                                            </div>
                                            <input  type="text" name="task" class="form-control"  value="{{ old('task') }}" required>
                                        </div>
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Topic</span>
                                            </div>
                                            <input  type="text" name="topic" class="form-control" value="{{ old('topic') }}" required>
                                        </div>
                                        <div class="row">
                                            <div class="mb-4 col-md-6" >
                                                <div class="input-group" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Word Limit(in words)</span>
                                                    </div>
                                                    <input  type="number" name="word_limit" class="form-control" value="{{ old('word_limit') }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-4 col-md-6" >
                                                <div class="input-group" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Time Limit(in hours)</span>
                                                    </div>
                                                    <input  type="number" name="time_limit" class="form-control" value="{{ old('time_limit') }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6" >
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
                                            </div>
                                            <div class="mb-3 col-md-6" >
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
                                            </div>
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Attachment</span>
                                                    </div>
                                                    <input type="file" name="attachment" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <textarea name="references" class="form-control" placeholder="Add references"></textarea>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Task Type</span>
                                                    </div>
                                                    <select class="form-control custom-select" name="task_type" id="task_type" required>
                                                        <option value="">-- Select Type -- </option>
                                                        <option value="Internal">Internal </option>
                                                        <option value="External">External </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="col-12 col-md-6 mb-3">
                                            <input placeholder="Assign User" autocomplete="off" type="text" size="30" name="user_name" class="form-control" id="user_name" onkeyup="searchUser(this.value)" required>
                                            <ul id="user-search" class="list-group"></ul>
                                        </div>
                                         <input type="hidden" name="assigned_to" id="user_id" class="form-control" value="{{ old('assigned_to') }}" required>

                                        {{-- <div class="mb-3 col-md-6" >
                                            <div class="input-group mb-4 col-md-6" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Task Type</span>
                                                </div>
                                                <select class="form-control custom-select" name="task_type" id="task_type" required>
                                                    <option value="">-- Select Type -- </option>
                                                    <option value="Internal">Internal </option>
                                                    <option value="External">External </option>
                                                </select>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="mb-3 col-md-6" id="internal_url" style="display: none">
                                            <div class="input-group" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Published URL</span>
                                                </div>
                                                <input type="url"  name="published_url" placeholder="enter link" class="form-control" value="{{ old('published_url') }}" >
                                            </div>
                                        </div>

                                        <div class="mb-4 col-md-6" id="external_url" style="display: none">
                                            External Published URL <a href="">Add Link</a> | <a href="">Find And Map Link</a>
                                        </div> --}}

                                        {{-- <div class="row">
                                            <div class="mb-4 col-md-6">
                                                <div class="input-group" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Payout Amount</span>
                                                    </div>
                                                    <input type="number"  name="published_url" placeholder="enter amount" class="form-control" value="{{ old('published_url') }}" >
                                                </div>
                                            </div>
                                            <div class="mb-4 col-md-6" >
                                                <div class="input-group" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">USD Payout Amount</span>
                                                    </div>
                                                    <input type="number"  name="published_url" class="form-control" value="{{ old('published_url') }}" disabled>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="mb-4 col-md-6">
                                            Payout Management <a href="#" id="create-payout-button">Add Payout</a> | <a href="#">Search Payout</a>
                                        </div> --}}
                                        {{-- <input type="hidden" name="task_id" id="user_id" class="form-control" value="{{ old('assigned_to') }}" required> --}}
                                        <div class="row">
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <textarea name="admin_notes" class="form-control" placeholder="Add notes"></textarea>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <textarea name="instructions" class="form-control" placeholder="Add instructions" required></textarea>
                                                </div>
                                            </div>
                                        </div>

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

<!-- create payout modal -->
{{-- <div class="modal fade" tabindex="-1" role="dialog" id="create-payout">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Payout</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.payout.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Name</span>
                    </div>
                    <input  type="text" name="name"class="form-control" placeholder="payout name" value="{{ old('name') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Amount</span>
                    </div>
                    <input type="number" name="amount" class="form-control" placeholder="amount" value="{{ old('code') }}" required>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control custom-select" name="task_type" id="task_type" required>
                        <option value="">-- Select Status -- </option>
                        <option value="Pending">Pending </option>
                        <option value="Completed">Completed </option>
                    </select>
                </div>

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
</div> --}}
  <!-- /.modal -->
@endsection

@section('scripts')
<script>
//function for user live search
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

//toggle between external and internal task
$(function() {
    $('#task_type').change(function(){
        if($('#task_type').val() == 'Internal') {
            $('#external_url').hide();
            $('#internal_url').show();
        } else if ($('#task_type').val() == 'External'){
            $('#internal_url').hide();
            $('#external_url').show();
        } else{
            $('#internal_url').hide();
            $('#external_url').hide();
        }
    });
});

//create payout modal
$('#create-payout-button').on('click',function(event){
    event.preventDefault();
    $('#create-payout').modal('show');
});

</script>

@endsection
