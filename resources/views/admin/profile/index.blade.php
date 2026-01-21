@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="row mt-sm-4">

                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate=""
                            action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <div>
                                            <img alt="image" src="{{ asset(Auth::user()->profile_image) }}"
                                                class="rounded-circle" width="80" height="80">
                                        </div>
                                        <label>Profile Image</label>
                                        <input type="file" name="image" class="form-control">

                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input name="name" type="text" class="form-control"
                                            value="{{ Auth::user()->name }}">
                                        @if ($errors->has('name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input name="email" type="email" class="form-control"
                                            value="{{ Auth::user()->email }}" required="">
                                        @if ($errors->has('email'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate=""
                            action="{{ route('admin.profile.update.password') }}">
                            @csrf
                            <div class="card-header">
                                <h4>Update Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (session('current_password_error'))
                                        <div class="alert alert-danger alert-dismissible show fade">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert">
                                                    <span>&times;</span>
                                                </button>
                                                {{ session('current_password_error') }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group col-12">
                                        <label>Current Password</label>
                                        <input name="current_password" type="text" class="form-control" required>
                                        @if ($errors->has('current_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('current_password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group col-12">
                                        <label>New Password</label>
                                        <input name="new_password" type="text" class="form-control" required="">
                                        @if ($errors->has('new_password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('new_password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Confirm New Password</label>
                                        <input name="new_password_confirmation" type="text" class="form-control"
                                            required="">
                                        @if ($errors->has('new_password_confirmation'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('new_password_confirmation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
