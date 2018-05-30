@extends('layouts.app')
@section('content')
@php 
$associates = Auth::user()->associate;
$associatesOf = Auth::user()->associateOf
@endphp
<div class="container-fluid">
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
		<div class="col text-center">
			<h1>{{ $title }}</h1>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-2">
			<div class="card border-secondary">
				<div class="card-header">
					Filter
				</div>
				<form action="{{ route('users.profiles') }}" method="GET" id="filterForm">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<h6 class="card-subtitle mb-2 text-muted">Name</h6>
							<input type="text" class="form-control" id="name" name="name" value="{{ request()->name }}">
						</li>
						<li class="list-group-item text-right">
							<button type="submit" class="btn btn-primary">Filter</button>
							<a role="button" class="btn btn-danger" href="{{ action('ProfileController@index')}}">Clear</a>
						</li>
					</ul>
				</form>
			</div>
		</div>
		<div class="col">
		@if(count($users) == 0)
			<h4>No users found</h4>
		@else
			<table class="table">
				<thead> 
				<tr> 
					<th></th>
					<th>
						Name
					</th>
                    <th></th>
                    <th></th>
                    <th>Operations</th>
				</tr> 
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>
						@isset($user->profile_photo)
							<img class="img-fluid rounded" src="{{ asset('storage/profiles/' . $user->profile_photo )}}" style ="width:40px; height:40px; float:left; border-radius: 50%;">
						@endisset	
						</td>
						<td>{{ $user->name }}</td>
						<td>
							@if($associates->contains($user))
								<span>associate</span>
							@endif
						</td>
						<td>
							@if($associatesOf->contains($user))
								<span>associate-of</span>
							@endif
						</td>
						<td>
							@if($associates->contains($user))
								<form method="post" action="{{ route('desassociate.user', $user->id) }}">
									@csrf
									@method('delete')
									<button type="submit" class="btn btn-danger" href="">Desassociate</a>
								</form>
							@else
								@if($user->id != Auth::user()->id)
								<form method="post" action="{{ route('associate.user') }}">
									@csrf
									<input type="text" class="form-control" name="associated_user" style="display: none;" value="{{ $user->id }}">
									<button type="submit" class="btn btn-primary">Associate</button>
								</form>
								@endif
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="d-flex justify-content-center">
				{{$users->appends($_GET)->links()}}
			</div>
			@endif
		</div>
	</div>
</div>
@endsection('content') 