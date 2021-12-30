@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-12 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Users</h5>
                        </div>
                        <div class=" float-end">
                            <p><a href="{{route('admin.user.create-view')}}" class="btn btn-primary btn-sm"
                                >Create User</a>
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12 mb-2">
                            <form action="{{ route('admin.user.search')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Search by</span>
                                            </div>
                                            <select class="form-control custom-select" name="search_column" id="search_column" required>
                                                <option value="">-- select column -- </option>
                                                <option value="id">id </option>
                                                <option value="name">name </option>
                                                <option value="email">email </option>
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
                        </div>
                        @if (count($users))
                            <p>page {{ $users->currentPage() }} of {{ $users->lastPage() }} , displaying {{ count($users) }} of {{ $users->total() }} record(s) </p>

                            <table id="user_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                    <th width="12%">user ID</th>
                                    {{-- <th width="7%">username</th> --}}
                                    <th width="10%">fullname</th>
                                    <th width="10%">email</th>
                                    <th width="6%">type</th>
                                    <th width="3%">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key =>$user )
                                        <tr>
                                            <td >
                                                {{-- <a href="{{route('admin.user.profile',['id'=>$user->id])}}" title="view profile"> --}}
                                                    {{$user->id}}
                                                {{-- </a>     --}}
                                            </td>
                                            {{-- <td>{{$user->username}}</td> --}}
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                @if ($user->type === 'Writer')
                                                    <div class="ml-1 badge bg-pill bg-success"> {{$user->type}}</div></td>
                                                @elseif ($user->type === 'Editor')
                                                    <div class="ml-1 badge bg-pill bg-info"> {{$user->type}}</div></td>
                                                @else
                                                    <div class="ml-1 badge bg-pill bg-warning"> {{$user->type}}</div></td>

                                                @endif
                                            <td class="text-center m-auto">
                                                <a href="{{ route('admin.user.edit-view',[ 'id'=>$user->id])}}">
                                                    <i class='fa fa-edit text-success me-3' style='cursor: pointer;'></i>
                                                </a>
                                                <a href="{{ route('admin.user.delete',[ 'id'=>$user->id])}}">
                                                    <i class='fa fa-trash text-danger me-3' style='cursor: pointer;'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}

                        @else
                            <div class="alert alert-info text-center">
                                <b>No users found</b>
                            </div>
                        @endif

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
    if ($(this).val() == "id") {
        $('#query').attr('type', 'number');
    }else if($(this).val() == "name"){
        $('#query').attr('type', 'text');
    }else if($(this).val() == "email"){
        $('#query').attr('type', 'email');
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

//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal('show');
});

//modal to edit user
function editUser(user){
    $('#name').val(user.name);
    $('#user_type').val(user.type);
    $('#email').val(user.email);
    $('#user_id').val(user.id);
    $('#password').val(user.password);
    $('#edit-modal').modal('show');
}

</script>

@endsection
