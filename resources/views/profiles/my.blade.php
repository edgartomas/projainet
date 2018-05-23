@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
			<div class="col">
				@if ($errors->any())
					<div class="alert alert-danger">
						{{ $errors->first() }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
			@endif
			@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif
			</div>
	</div>
    <div class="row">
        <div class="col">
            <h1 class="text-center">{{ $title }}</h1>
            <hr class="my-4">
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            @isset(Auth::user()->profile_photo)
                <img class="img-fluid rounded my-4" src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}">
            @endisset
        </div>
        <div class="col">
        <h5 class="text-center my-4">Update Profile</h5>
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name"  aria-describedby="emailHelp" value="{{ $user->name }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">E-Mail</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="profile_photo" class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" id="profile_photo" name="profile_photo">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
            <hr class="my-4">
            <h5 class="text-center my-4">Update Password</h5>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('patch')
                <div class="form-group row">
                    <label for="old_password" class="col-sm-3 col-form-label">Old Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="old_password" name="old_password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">New Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Password Confirmation</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection('content') 