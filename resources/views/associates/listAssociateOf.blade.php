@extends('layouts.app')
@section('content')
<div class="container">
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
						E-Mail
					</th>
					<th>Operation</th>
				</tr> 
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>
						@isset($user->profile_photo)	
							<img class="rounded" src="{{ asset('storage/profiles/' . $user->profile_photo )}}" style ="width:40px; height:40px; float:left; border-radius: 50%;">
						@endisset	
						</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td><a class="btn btn-primary" href="{{ route('dashboard', $user)}}" role="button">View</a></td>
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