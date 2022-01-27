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
                           {{-- Create User --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.user.update')}}" method="post" class="form-group" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> Name</span>
                                            </div>
                                            <input  type="text" name="name"class="form-control" placeholder="Fullname" value="{{$user->name }}" required>
                                        </div>

                                        <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> Email</span>
                                            </div>
                                            <input  type="email" name="email" class="form-control" placeholder="email" value="{{$user->email }}" required>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">User Type</span>
                                                    </div>
                                                    <select class="form-control custom-select" id="user_type" name="type" required>
                                                        <option value='Writer'>Writer </option>
                                                        <option value='Editor'>Editor </option>
                                                        <option value='Admin'>Admin </option>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4 col-md-6" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Country</span>
                                                    </div>
                                                    <select class="form-control custom-select" id="country" name="country" required>
                                                        <option value="">-- Select Region -- </option>
                                                        @foreach ($regions as $region)
                                                        <option value="{{$region->id}}">{{$region->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <textarea name="bank_details" class="form-control mb-4"  placeholder="Enter Bank Details" required>{{$user->bank_details }}</textarea>

                                        <div class="row">
                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Payout Per Word</span>
                                                    </div>
                                                    <input type="number" name="payout_per_word"class="form-control" placeholder="Payout Per Word" value="{{$user->payout_per_word }}" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Fixed Monthly Payout</span>
                                                    </div>
                                                    <input type="number" name="fixed_monthly_payout"class="form-control" placeholder="fixed monthly payout" value="{{$user->fixed_monthly_payout }}" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Total Payout</span>
                                                    </div>
                                                    <input type="number" name="total_payout"class="form-control" placeholder="total payout" value="{{$user->total_payout }}" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6" >
                                                <div class="input-group mb-4" >
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"> Currency</span>
                                                    </div>
                                                    <select class="form-control custom-select" id="currency" name="currency" required>
                                                        <option value="">-- Select Currency -- </option>
                                                        @foreach ($currencys as $currency)
                                                        <option value="{{$currency->id}}">{{$currency->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        {{-- <div class="input-group mb-4" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"> Password</span>
                                            </div>
                                            <input  type="password" name="password" class="form-control" placeholder="password" value="{{$user->password}}" required>
                                        </div> --}}
                                        <input type="hidden" name="user_id" value="{{$user->id}}" class="form-control">

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id = "modal-save">Save changes</button>
                                        </div>
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#country').val("{{$user->country}}");
    $('#user_type').val("{{$user->type}}");
    $('#currency').val("{{$user->currency}}");
});
</script>

@endsection
