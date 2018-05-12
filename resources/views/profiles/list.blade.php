@extends('layouts.app')
@section('content')
@php 
$associates = Auth::user()->associate;
$associatesOf = Auth::user()->associateOf
@endphp
<div class="container-fluid">
	<div>
		<div class="row">
			<div class="col">
				@if ($errors->any())
					<div class="alert alert-danger">
						{{ $errors->first() }}
					</div>
			@endif
			@if (session('status'))
			<div class="alert alert-success">
					{{ session('status') }}
				</div>
			@endif
			</div>
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
				<form action="{{ action('ProfileController@index') }}" method="GET" id="filterForm">
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
						@if($user->profile_photo != null)
							<img src="{{ asset('storage/profiles/' . $user->profile_photo )}}" style ="width:40px; height:40px; float:left; border-radius: 50%; margin-right: 25px;">
						@endif	
						</td>
						<td>{{ $user->name }}</td>
                        <td>
							@foreach ($associates as $associate)
								@if($associate->id == $user->id)
								<span class="badge badge-pill badge-success">Associate</span>
								@endif
							@endforeach
						</td>
                        <td>
							@foreach ($associatesOf as $associate)
								@if($associate->id == $user->id)
									<span class="badge badge-pill badge-success">Associate-Of</span>
								@endif
							@endforeach
						</td>
                        <td>
							<button type="button" class="btn btn-primary">Associate/Desassociate</button>
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