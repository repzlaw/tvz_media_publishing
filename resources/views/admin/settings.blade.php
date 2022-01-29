@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-md-9 m-auto">
                <div class="card-hover-shadow-2x mb-3 mt-3 card">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal float-left">
                            <h5>Settings</h5> 
                        </div>
                    </div> 
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                          <h5 class="ms-3 mb-3">Configurations for emails</h5>
                          <form action="{{ route('admin.setting.save')}}" method="post">
                            {{ csrf_field() }}
                            <div class="row ms-2">
                              
                              <div class="mb-2 col-12 col-md-4">
                                <div class="input-group" >
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">New task</span>
                                  </div>
                                  <select class="form-control custom-select" name="new_task_email" id="new_task_email" required>
                                    <option value="0">disable </option>                           
                                    <option value="1">enable </option>                           
                                  </select>
                                </div>
                              </div>

                              <div class="mb-2 col-12 col-md-4">
                                <div class="input-group" >
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">Task Conversation</span>
                                  </div>
                                  <select class="form-control custom-select" name="task_coversation_email" id="task_coversation_email" required>
                                    <option value="0">disable </option>                           
                                    <option value="1">enable </option>                           
                                  </select>
                                </div>
                              </div>

                              <div class="mb-2 col-12 col-md-4">
                                <div class="input-group" >
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">Login</span>
                                  </div>
                                  <select class="form-control custom-select" name="login_email" id="login_email" required>
                                    <option value="0">disable </option>                           
                                    <option value="1">enable </option>                           
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="float-right mt-3">
                              <button class="btn btn-success" type="submit">Save</button>
                            </div>
                          </form>
                        </li>
                      <li class="list-group-item"></li>

                    </ul>
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function() {
    $('#login_email').val({{$login_email}});
    $('#new_task_email').val({{$new_task_email}});
    $('#task_coversation_email').val({{$task_coversation_email}});
});


</script>
    
@endsection