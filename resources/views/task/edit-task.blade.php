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
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left"></div>
                        </div>
                        <div class="card-body">
                            <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Task</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('task.update')}}" method="post" class="form-group" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                        <div class="form-group row">
                                            <div class="input-group mb-4" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Task</span>
                                                </div>
                                                <input type="text" name="task" class="form-control"  value="{{$task->task }}" required>
                                            </div>
                                            <div class="input-group mb-4" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Topic</span>
                                                </div>
                                                <input  type="text" name="topic" class="form-control" value="{{ $task->topic }}" required>
                                            </div>
                                            <div class="input-group mb-4 col-md-6" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Region</span>
                                                </div>
                                                <select class="form-control custom-select" id="region_target" name="region_target" required>
                                                    <option value="">-- Select Region -- </option>
                                                    @foreach ($regions as $region)
                                                    <option value="{{$region->id}}">{{$region->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="mb-4 col-md-6" >
                                                    <div class="input-group">

                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Website</span>
                                                        </div>
                                                        <select class="form-control custom-select" id="website_id" name="website_id" required>
                                                            <option value="">-- Select Website -- </option>
                                                            @foreach ($websites as $website)
                                                                <option value="{{$website->id}}">{{$website->url}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class=" mb-4 col-md-6" >
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Status</span>
                                                        </div>
                                                        <select class="form-control custom-select" name="status" id="status" required>
                                                            <option value="">-- Select Status -- </option>
                                                            <option value="Pending">Pending </option>
                                                            <option value="Submitted">Submitted </option>
                                                            <option value="Correction Required">Correction Required </option>
                                                            <option value="Approved">Approved </option>
                                                            <option value="Acknowledged">Acknowledged </option>
                                                            <option value="Cancelled">Cancelled </option>
                                                            <option value="Feedback">Feedback </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-12 col-md-6 mb-3">
                                                <input placeholder="search User" autocomplete="off" type="text" size="30" name="user_name" class="form-control" id="user_name" value="{{$assigned_user->name}}" onkeyup="searchUser(this.value)" required>
                                                <ul id="user-search" class="list-group"></ul>
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

                                            <div class="mb-3 col-md-6" id="internal_url" style="display: none">
                                                <div class="input-group" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Published URL</span>
                                                    </div>
                                                    <input type="url"  name="published_url" placeholder="enter link" class="form-control" value="{{ old('published_url') }}" >
                                                </div>
                                            </div>

                                            <div class="mb-4 col-md-6" id="external_url" style="display: none">
                                                External Published URL <a href="#" id="create-link-button">Add Link</a> | 
                                                <a href="#" id="search-link-button">Find And Map Link</a>
                                            </div>

                                            <div class="row">
                                                <div class="mb-4 col-md-6">
                                                    <div class="input-group" >
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Payout Amount</span>
                                                        </div>
                                                        <input type="number" name="payout_amount" id="payout_amount" placeholder="enter amount" class="form-control" value="{{ old('payout_amount') }}" >
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
                                            </div>

                                            <input type="hidden" name="task_id" id="task_id" class="form-control" value="{{ $task->id }}" required>
                                            <input type="hidden" name="payout_id" id="payout_id" class="form-control" value="{{ $task->payout_id }}" required>
                                            <input type="hidden" name="assigned_to" id="user_id" class="form-control" value="{{ $task->assigned_to }}" required>
                                            <input type="hidden" name="published_date" id="published_date" class="form-control" value="{{ $task->published_date }}" required>
                                            <input type="hidden" name="published_url" id="published_url" class="form-control" value="{{ $task->published_url }}" required>
                                            <input type="hidden" name="link_id" id="link_id" class="form-control" value="{{ $task->link_id }}" required>

                                            <div class="mb-4 col-md-6">
                                                Payout Management <a href="#" id="create-payout-button">Add Payout</a> | 
                                                <a href="#" id="search-payout-button">Search Payout</a>
                                            </div>
                                            <textarea name="instructions" id="instructions" rows="5" class="form-control"  placeholder="type instructions ..." value="{{ old('instructions') }}" required>{{ $task->instructions }}</textarea>
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
</div>

<!-- create payout modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="create-payout">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Payout</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.payout.store')}}" id="add-payout-form" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Amount</span>
                    </div>
                    <input type="number" name="amount" class="form-control" placeholder="amount" value="{{ old('amount') }}" required>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control custom-select" name="status" id="payout_status" required>
                        <option value="">-- Select Status -- </option>
                        <option value="Pending">Pending </option>
                        <option value="Completed">Completed </option>
                    </select>
                </div>

                <input type="hidden" name="task_id" id="payout_task_id" class="form-control" value="{{ $task->id }}" required>
                <input type="hidden" name="user_id" id="payout_user_id" class="form-control" value="{{ $task->assigned_to }}" required>

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

  <!-- search payout modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="search-payout">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Search Payout</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.payout.map')}}" id="map-payout-form" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Payout</span>
                    </div>
                    <select class="form-control custom-select" name="payout_id" id="payout_status" required>
                        <option value="">-- Select Payout -- </option>
                        @foreach ($payouts as $payout)
                            <option value="{{$payout->id}}">{{$payout->amount}} </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="task_id" class="form-control" value="{{ $task->id }}" required>
                <input type="hidden" name="user_id" id="map_payout_user_id" class="form-control" value="{{ $task->assigned_to }}" required>

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

  <!-- create link modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="create-link">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create Link</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.link.store')}}" id="add-link-form" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Title</span>
                    </div>
                    <input type="text" name="title" class="form-control" placeholder="title" value="{{ old('title') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> URL</span>
                    </div>
                    <input type="url" name="url" class="form-control" placeholder="url" value="{{ old('url') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> content</span>
                    </div>
                    <input type="text" name="content" class="form-control" placeholder="content" value="{{ old('content') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Cost</span>
                    </div>
                    <input type="number" name="cost" class="form-control" placeholder="cost" value="{{ old('cost') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> USD Cost</span>
                    </div>
                    <input type="text" name="usd_cost" class="form-control" placeholder="usd_cost" value="{{ old('usd_cost') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Currency</span>
                    </div>
                    <input type="text" name="currency" class="form-control" placeholder="currency" value="{{ old('currency') }}" required>
                </div>
                
                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Published Date</span>
                    </div>
                    <input type="datetime-local" name="published_date" class="form-control" placeholder="published_date" value="{{ old('published_date') }}" required>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Publisher</span>
                    </div>
                    <select class="form-control custom-select" name="publisher_id" required>
                        <option value="">-- Select Publisher -- </option>
                        @foreach ($publishers as $publisher)
                            <option value="{{$publisher->id}}">{{$publisher->name}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Website</span>
                    </div>
                    <select class="form-control custom-select" id="website_id" name="website_id" required>
                        <option value="">-- Select Website -- </option>
                        @foreach ($websites as $website)
                            <option value="{{$website->id}}">{{$website->url}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Status</span>
                    </div>
                    <select class="form-control custom-select" name="status" id="link_status" required>
                        <option value="">-- Select Status -- </option>
                        <option value="Inactive">Inactive </option>
                        <option value="Live">Live  </option>
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
</div>
  <!-- /.modal -->

  <!-- search link modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="search-link">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Search link</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.link.map')}}" id="map-link-form" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">link</span>
                    </div>
                    <select class="form-control custom-select" name="link_id" id="link_status" required>
                        <option value="">-- Select link -- </option>
                        @foreach ($links as $link)
                            <option value="{{$link->id}}">{{$link->title}} </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="task_id" class="form-control" value="{{ $task->id }}" required>
                <input type="hidden" name="user_id" id="map_link_user_id" class="form-control" value="{{ $task->assigned_to }}" required>

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
    $('#region_target').val({{$task->region_target}});
    $('#website_id').val({{$task->website_id}});
    $('#status').val('{{$task->status}}');
});
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
    $('#payout_user_id').val(user.id);
    $('#map_payout_user_id').val(user.id);
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

//search payout modal
$('#search-payout-button').on('click',function(event){
    event.preventDefault();
    $('#search-payout').modal('show');
});

//add payout submit
$("#add-payout-form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
                $('#payout_id').val(data.id);
                $('#payout_amount').val(data.amount);
                $('#create-payout').modal('hide');
        }
     });
});

//map payout submit
$("#map-payout-form").submit(function(e) {

e.preventDefault(); // avoid to execute the actual submit of the form.

var form = $(this);
var url = form.attr('action');
$.ajax({
       type: "POST",
       url: url,
       data: form.serialize(), // serializes the form's elements.
       success: function(data)
       {
            $('#payout_id').val(data.id);
            $('#payout_amount').val(data.amount);
            $('#search-payout').modal('hide');
       }
     });
});

//create link modal
$('#create-link-button').on('click',function(event){
    event.preventDefault();
    $('#create-link').modal('show');
});

//search link modal
$('#search-link-button').on('click',function(event){
    event.preventDefault();
    $('#search-link').modal('show');
});

//add link submit
$("#add-link-form").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            $('#link_id').val(data.link.id);
            $('#published_date').val(data.link.published_date);
            $('#published_url').val(data.link.url);
            $('#create-link').modal('hide');
        }
    });
});

//map link submit
$("#map-link-form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            $('#link_id').val(data.id);
            $('#published_date').val(data.published_date);
            $('#published_url').val(data.url);
            $('#search-link').modal('hide');
        }
     });
});

</script>

@endsection
