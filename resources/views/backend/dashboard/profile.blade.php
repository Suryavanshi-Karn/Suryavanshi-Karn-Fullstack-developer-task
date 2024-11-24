@extends('backend.layouts.app')
@section('content')
<div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <section class="users-list-wrapper">
        	<div class="users-list-table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="card-title text-center">My Profile Info</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="profileForm" action="updateProfile">
                                        @csrf
                                        <h4 class="form-section"><i class="ft-info"></i> Details</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Email ID</label>
                                                <input class="form-control" type="text" name="email" value="{{$data->email}}"><br/>
                                            </div>


                                            <div class="col-sm-6">
                                                <label>Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" value="{{$data->name}}" required><br/>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-left">
                                                    @if ($message = Session::get('success'))
                                                        <div class="successAlert alert text-success">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="pull-left">
                                                    <a href="{{URL('/updatePassword')}}" class="btn btn-primary px-3 py-1">Change Password</a>
                                                </div>
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success" onclick="submitForm('profileForm','post')">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection