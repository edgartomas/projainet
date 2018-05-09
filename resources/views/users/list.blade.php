@extends('layouts.app')
@section('content')
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
				<form action="{{ action('UserController@index') }}" method="GET" id="filterForm">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<h6 class="card-subtitle mb-2 text-muted">Name</h6>
							<input type="text" class="form-control" id="name" name="name" value="{{ request()->name }}">
						</li>
						<li class="list-group-item">
							<h6 class="card-subtitle mb-2 text-muted">Type</h6>
							<div class="custom-control custom-radio">
								<input type="radio" id="typeRadio1" name="type" class="custom-control-input" value="admin" {{ request()->type == 'admin' ? 'checked' : ''}}>
								<label class="custom-control-label" for="typeRadio1">Admin</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="typeRadio2" name="type" class="custom-control-input" value="normal" {{ request()->type == 'normal' ? 'checked' : ''}}>
								<label class="custom-control-label" for="typeRadio2">Normal</label>
							</div>
						</li>
						<li class="list-group-item">
						<h6 class="card-subtitle mb-2 text-muted">Status</h6>
							<div class="custom-control custom-radio">
								<input type="radio" id="statusRadio1" name="status" class="custom-control-input" value="unblocked" {{ request()->status == 'unblocked' ? 'checked' : ''}}>
								<label class="custom-control-label" for="statusRadio1">Unblocked</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="statusRadio2" name="status" class="custom-control-input" value="blocked" {{ request()->status == 'blocked' ? 'checked' : ''}}>
								<label class="custom-control-label" for="statusRadio2">Blocked</label>
							</div>
						</li>
						<li class="list-group-item text-right">
							<button type="submit" class="btn btn-primary">Filter</button>
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
					<th>
						Name
					</th>
					<th>
						Email
					</th>
					<th>
						Type
					</th>
					<th>
						Status
					</th>
					<th>
						Operation
					</th>
				</tr> 
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->adminToString() }}</td>
						<td>{{ $user->blockedToString() }}</td>
						<td>
						@if($user != Auth::user())
							@if($user->admin == 0)
								<form class="from-inline" action="{{ action('UserController@promote', $user->id) }}" style="display:inline;">
									<button type="submit" class="btn btn-primary btn-sm">Promote</button>
								</form> 
							@else
								<form class="from-inline" action="{{ action('UserController@demote', $user->id) }}" style="display:inline;">
									<button type="submit" class="btn btn-primary btn-sm">Demote</button>
								</form> 
							@endif

							@if($user->blocked == 0)
								<form class="form-inline" action="{{ action('UserController@block', $user->id) }}" style="display:inline;">
									<button type="submit" class="btn btn-info btn-sm">Block</button>
								</form> 
							@else
								<form class="form-inline" action="{{ action('UserController@unblock', $user->id) }}" style="display:inline;">
									<button type="submit" class="btn btn-info btn-sm">unblock</button>
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