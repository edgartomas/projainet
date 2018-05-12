@extends('layouts.app')
@section('content')
<div class="container">
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
					<th>Operation</th>
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
						<td><button type="button" class="btn btn-danger">Desassociate</button></td>
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