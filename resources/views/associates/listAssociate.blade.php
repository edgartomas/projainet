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
		<div class="col text-center">
			<h1>{{ $title }}</h1>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col">
		@if(count($users) == 0)
			<h4>No users found</h4>
		@else
			<table class="table">
				<thead> 
				<tr> 
					<th>#</th>
					<th>
						Name
					</th>
					<th>
						Name
					</th>
					<th>Operation</th>
				</tr> 
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>
						@isset(Auth::user()->profile_photo)	
							<img class="rounded" src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}" style ="width:40px; height:40px; float:left; border-radius: 50%;">
						@endisset
						@empty(Auth::user()->profile_photo)
							<img class="rounded" src="{{ asset('storage/profiles/default.jpg') }}" style ="width:40px; height:40px; float:left; border-radius: 50%;">
						@endempty	
						</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>
							<form method="post" action="{{ action('AssociatesController@destroy', $user->id) }}">
								@csrf
								@method('delete')
								<button type="submit" class="btn btn-danger" href="">Desassociate</a>
							</form>
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