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
                            <h5>regions</h5>
                        </div>
                        <div class=" float-end">
                            <p><a href="#" class="btn btn-primary btn-sm"  id="create-button"
                                >Create region</a></p>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($regions))
                            <p>page {{ $regions->currentPage() }} of {{ $regions->lastPage() }} , displaying {{ count($regions) }} of {{ $regions->total() }} record(s) </p>

                            <table id="region_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                    <th width="5%">#</th>
                                    <th >name</th>
                                    <th width="13%">code</th>
                                    <th width="13%">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($regions as $key =>$region )
                                        <tr>
                                            <td >{{$key+1}}</td>
                                            <td>{{$region->name}}</td>
                                            <td>{{$region->code}}</td>
                                            <td class="text-center m-auto">
                                                <i class='fa fa-edit text-success me-3' style='cursor: pointer;' onclick='editregion({{$region}})'></i>
                                                <a href="{{ route('admin.region.delete',[ 'id'=>$region->id])}}">
                                                    <i class='fa fa-trash text-danger me-3' style='cursor: pointer;' ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $regions->links() }}

                        @else
                            <div class="alert alert-info text-center">
                                <b>No regions found</b>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- create region modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create region</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.region.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Name</span>
                    </div>
                    <input  type="text" name="name"class="form-control" placeholder="region name" value="{{ old('name') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> code</span>
                    </div>
                    <input  type="code" name="code" class="form-control" placeholder="code" value="{{ old('code') }}" required>
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

  <!-- edit region modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit region</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.region.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Name</span>
                    </div>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Fullname" value="{{ old('name') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> code</span>
                    </div>
                    <input type="code" name="code" id="code"  class="form-control" placeholder="code" value="{{ old('code') }}" required>
                </div>

                <input type="hidden" name="region_id" id="region_id" class="form-control">

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id = "modal-edit-save">Save changes</button>
              </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>

@endsection

@section('scripts')
<script>
//create modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal('show');
});

//modal to edit region
function editregion(region){
    $('#name').val(region.name);
    $('#code').val(region.code);
    $('#region_id').val(region.id);
    $('#edit-modal').modal('show');
}

</script>

@endsection
