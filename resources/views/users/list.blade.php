@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div>
		
		</div>
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
				<form action="" method="GET">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
						<h6 class="card-subtitle mb-2 text-muted">Name</h6>
						<input class="form-control" id="exampleInputEmail1">
						</li>
						<li class="list-group-item">
							<h6 class="card-subtitle mb-2 text-muted">Type</h6>
							<div class="custom-control custom-radio">
									<input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
									<label class="custom-control-label" for="customRadio1">Admin</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
								<label class="custom-control-label" for="customRadio2">Normal</label>
							</div>
						</li>
						<li class="list-group-item">
						<h6 class="card-subtitle mb-2 text-muted">Status</h6>
							<div class="custom-control custom-radio">
									<input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
									<label class="custom-control-label" for="customRadio1">Unblocked</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
								<label class="custom-control-label" for="customRadio2">Blocked</label>
							</div>
						</li>
						<li class="list-group-item text-right">
							<button type="submit" class="btn btn-primary">Filter</button>
							<button type="reset" class="btn btn-primary">Clear</button>
						</li>
					</ul>
				</form>
			</div>
		</div>
		<div class="col">
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
					<th></th>
				</tr> 
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->adminToString() }}</td>
						<td>{{ $user->blockedToString() }}</td>
						<td><a href="{{ route('users.create')}}" class="btn btn-xs btn-danger">Add Movement</a></td>
						<td>
							<form action="#" method="post">
								<input type="hidden" name="id"  value="{{$user->id}}">
								<input type="submit" type="submit" class="btn btn-xs btn-danger" value="Delete">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="d-flex justify-content-center">
				{{$users->links()}}
			</div>
		</div>
	</div>
</div>


@endsection('content') 