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
                        <div class="card-body">
                            <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Edit Payout</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.payout.update')}}" method="post" class="form-group" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                        <div class="form-group row">

                                            <div  class="col-12 col-md-6 mb-3">
                                                <input placeholder="search User" autocomplete="off" type="text" size="30" name="user_name" class="form-control" id="user_name" value="{{$payout->user->name}}" onkeyup="searchUser(this.value)" required>
                                                <ul id="user-search" class="list-group"></ul>
                                            </div>

                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Status</span>
                                                    </div>
                                                    <select class="form-control custom-select" name="status" id="status" required>
                                                        <option value="">-- Select Status -- </option>
                                                        <option value="Pending">Pending </option>
                                                        <option value="Completed">Completed </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-4 col-md-6">
                                                    <div class="input-group" >
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Amount</span>
                                                        </div>
                                                        <input type="number" name="amount" id="payout_amount" placeholder="enter amount" class="form-control" value="{{$payout->amount}}" >
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="user_id" id="user_id" class="form-control" value="{{$payout->user_id}}" required>
                                            <input type="hidden" name="payout_id" class="form-control" value="{{$payout->id}}" required>
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
@endsection

@section('scripts')
<script>
$(function() {
    $('#status').val("{{$payout->status}}");
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
    $('#user_name').val(user.name);
    $('#user-search').html('');
}


</script>

@endsection
