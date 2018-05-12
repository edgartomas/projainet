<!DOCTYPE html>
<html lang="en">
  	<head>
		<meta charset="utf-8">
		<title>Gestão Finanças</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	</head>
  <body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="{{ action('WelcomeController@index') }}">Gestão Finanças</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
			</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			@auth
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('home') }}">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('home') }}">Accounts</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Profiles
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="{{ action('ProfileController@index') }}">List</a>
					<a class="dropdown-item" href="{{ action('AssociatesController@index') }}">Associates</a>
					<a class="dropdown-item" href="{{ action('AssociateOfController@index') }}">Associate-Of</a>
					</div>
				</li>
				@if(Auth::user()->admin == 1)
				<li class="nav-item">
					<a class="nav-link" href="{{ action('UserController@index' )}}">Users</a>
				</li>
				@endif
			</ul>
			@endauth
		</div class="d-flex justify-content-end">
			@guest
				<a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
				&nbsp
				<a class="btn btn-outline-primary" href="{{ route('register') }}">Register</a>
			@endguest
			@auth
				@isset(Auth::user()->profile_photo)	
					<img class="rounded" src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}" style ="width:40px; height:40px; float:left; border-radius: 50%;">
				@endisset
				@empty(Auth::user()->profile_photo)
                	<img class="rounded" src="{{ asset('storage/profiles/default.jpg') }}" style ="width:40px; height:40px; float:left; border-radius: 50%;">
            	@endempty
				<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ Auth::user()->name }}
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ action('MyProfileController@index')}}">Profile</a>
						<div class="dropdown-divider"></div>
							<form id="frm-logout" action="{{ route('logout') }}" method="POST">
								{{ csrf_field() }}
								<button type="submit" class="dropdown-item" href="#">Logout</a>
							</form>
					</div>
				</li>
				</ul>
				@if(Auth::user()->admin == 1)
					<span class="badge badge-info">Admin</span>
				@endif
			@endauth
		<div>

		</div>
	</nav>
    <br>
	
    @yield('content')
   
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	
  	</body>
</html>