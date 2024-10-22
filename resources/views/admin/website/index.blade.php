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
                            <h5>websites</h5>
                        </div>
                        <div class=" float-end">
                            <a href="#" class="btn btn-success btn-sm me-2"  id="add-parent-button"
                                >Add Parent</a>
                            <a href="#" class="btn btn-primary btn-sm"  id="create-button"
                            >Create website</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (count($parents))
                            {{-- <p>page {{ $websites->currentPage() }} of {{ $websites->lastPage() }} , displaying {{ count($websites) }} of {{ $websites->total() }} record(s) </p> --}}

                            <ul id="myUL">
                                @foreach ($parents as $parent)
                                    <li class="mt-3" style="color: black">
                                        <span @class(['caret'=>count($parent->websites),
                                                        'ms-3'=>count($parent->websites) === 0])>
                                                                {{$parent->name}}
                                        </span>
                                        <ul class="nested">
                                                <li>
                                                    @if (count($parent->websites))
                                                        <table id="website_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%">#</th>
                                                                    <th >url</th>
                                                                    <th width="13%">code</th>
                                                                    <th width="13%">region</th>
                                                                    <th width="13%">action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($parent->websites as $key=>$website)
                                                                    <tr>
                                                                        <td >{{$key+1}}</td>
                                                                        <td>{{$website->url}}</td>
                                                                        <td>{{$website->website_code}}</td>
                                                                        <td>{{$website->region->name}}</td>
                                                                        <td class="text-center m-auto">
                                                                            <i class='fa fa-edit text-success me-3' style='cursor: pointer;' onclick='editwebsite({{$website}})'></i>
                                                                            <a href="{{ route('admin.website.delete',[ 'id'=>$website->id])}}">
                                                                                <i class='fa fa-trash text-danger me-3' style='cursor: pointer;' ></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    @empty
                                                                @endforelse 
                                                            </tbody>
                                                        </table>
                                                        @else
                                                            <b>No website found</b>
                                                    @endif
                                                    {{-- <span class="me-3">
                                                        <strong>URL : </strong>
                                                        {{$website->url}} 
                                                    </span>
                                                    <span class="me-3">
                                                        <strong>CODE : </strong>
                                                        {{$website->website_code}} 
                                                    </span>
                                                    <span class="me-3">
                                                        <strong>REGION : </strong>
                                                        {{$website->region->name}} 
                                                    </span> --}}
                                                </li>
                                                
                                            {{-- <ul class="nested">
                                                <li>Black Tea</li>
                                                <li>White Tea</li>
                                                <li><span class="caret">Green Tea</span>
                                                <ul class="nested">
                                                    <li>Sencha</li>
                                                    <li>Gyokuro</li>
                                                    <li>Matcha</li>
                                                    <li>Pi Lo Chun</li>
                                                </ul>
                                                </li>
                                            </ul> --}}
                                            </li>
                                        </ul>
                                    </li>
                                    
                                @endforeach
                            </ul>
                        @endif
                        @if (count($websites))
                            {{-- <p>page {{ $websites->currentPage() }} of {{ $websites->lastPage() }} , displaying {{ count($websites) }} of {{ $websites->total() }} record(s) </p> --}}

                            <table id="website_table" class="table table-sm table-striped table-bordered table-hover table-responsive-sm mt-5">
                                <thead>
                                    <tr>
                                    <th width="5%">#</th>
                                    <th >url</th>
                                    <th width="13%">code</th>
                                    <th width="13%">region</th>
                                    <th width="13%">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($websites as $key =>$website )
                                        <tr>
                                            <td >{{$key+1}}</td>
                                            <td>{{$website->url}}</td>
                                            <td>{{$website->website_code}}</td>
                                            <td>{{$website->region->name}}</td>
                                            <td class="text-center m-auto">
                                                <i class='fa fa-edit text-success me-3' style='cursor: pointer;' onclick='editwebsite({{$website}})'></i>
                                                <a href="{{ route('admin.website.delete',[ 'id'=>$website->id])}}">
                                                    <i class='fa fa-trash text-danger me-3' style='cursor: pointer;' ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $websites->links() }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- create parent modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-parent-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create parent</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.parent.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> Name</span>
                    </div>
                    <input  type="text" name="name" class="form-control" placeholder="name" value="{{ old('website_code') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> URL</span>
                    </div>
                    <input  type="url" name="url"class="form-control" placeholder=" url" value="{{ old('url') }}" required>
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

<!-- create website modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "create-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Create website</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.website.create')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> URL</span>
                    </div>
                    <input  type="text" name="url"class="form-control" placeholder="website url" value="{{ old('url') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> code</span>
                    </div>
                    <input  type="text" name="website_code" class="form-control" placeholder="website_code" value="{{ old('website_code') }}" required>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Region</span>
                    </div>
                    <select class="form-control custom-select" name="region_id" required>
                        <option value="">-- Select Region -- </option>
                        @foreach ($regions as $region)
                        <option value="{{$region->id}}">{{$region->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Parent</span>
                    </div>
                    <select class="form-control custom-select" name="parent_id" >
                        <option value="">-- Select Parent -- </option>
                        @foreach ($parents as $parent)
                        <option value="{{$parent->id}}">{{$parent->name}} </option>
                        @endforeach
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

  <!-- edit website modal -->
<div class="modal fade" tabindex="-1" role="dialog" id= "edit-modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit website</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.website.edit')}}" method="post" class="form-group" enctype="multipart/form-data">
                    {{ csrf_field() }}
              <div class="form-group">

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> URL</span>
                    </div>
                    <input type="text" name="url" id="url" class="form-control" placeholder="URl" value="{{ old('url') }}" required>
                </div>

                <div class="input-group mb-4" >
                    <div class="input-group-prepend">
                        <span class="input-group-text"> code</span>
                    </div>
                    <input type="code" name="website_code" id="website_code"  class="form-control" placeholder="website_code" value="{{ old('website_code') }}" required>
                </div>

                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Region</span>
                    </div>
                    <select class="form-control custom-select" name="region_id" id="region_id" required>
                        <option value="">-- Select Region -- </option>
                        @foreach ($regions as $region)
                        <option value="{{$region->id}}">{{$region->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-4 col-md-6" >
                    <div class="input-group-prepend">
                        <span class="input-group-text">Parent</span>
                    </div>
                    <select class="form-control custom-select" name="parent_id" id="parent_id">
                        <option value="">-- Select Parent -- </option>
                        @foreach ($parents as $parent)
                        <option value="{{$parent->id}}">{{$parent->name}} </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="website_id" id="website_id" class="form-control">

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

//create parent modal
$('#add-parent-button').on('click',function(event){
    event.preventDefault();
    $('#create-parent-modal').modal('show');
});

//create website modal
$('#create-button').on('click',function(event){
    event.preventDefault();
    $('#create-modal').modal('show');
});

//modal to edit website
function editwebsite(website){
    $('#url').val(website.url);
    $('#website_code').val(website.website_code);
    $('#region_id').val(website.region_id);
    $('#parent_id').val(website.parent_id);
    $('#website_id').val(website.id);
    $('#edit-modal').modal('show');
}

//toggle table
var toggler = document.getElementsByClassName("caret");
var i;

for (i = 0; i < toggler.length; i++) {
  toggler[i].addEventListener("click", function() {
    this.parentElement.querySelector(".nested").classList.toggle("active");
    this.classList.toggle("caret-down");
  });
}

</script>

@endsection

@section('styles')
<style>
    /* Remove default bullets */
ul, #myUL {
  list-style-type: none;
}

/* Remove margins and padding from the parent ul */
#myUL {
  margin: 0;
  padding: 0;
}

/* Style the caret/arrow */
.caret {
  cursor: pointer;
  user-select: none; /* Prevent text selection */
}

/* Create the caret/arrow with a unicode, and style it */
.caret::before {
  content: "\25B6";
  color: black;
  display: inline-block;
  margin-right: 6px;
}

/* Rotate the caret/arrow icon when clicked on (using JavaScript) */
.caret-down::before {
  transform: rotate(90deg);
}

/* Hide the nested list */
.nested {
  display: none;
}

/* Show the nested list when the user clicks on the caret/arrow (with JavaScript) */
.active {
  display: block;
}
</style>

@endsection
