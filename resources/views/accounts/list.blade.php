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
		<div class="col text-right">
			<a class="btn btn-primary" href="{{ route('account.create') }}" role="button">Create new account</a>
			@yield('buttons')
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col">
		@if(count($accounts) == 0)
			<h4>No accounts found</h4>
		@else
			<table class="table">
				<thead> 
				<tr>
					<th>
						Code
					</th>
                    <th>Type</th>
                    <th>Balance</th>
					<th></th>
				</tr> 
				</thead>
				<tbody>
					@foreach ($accounts as $account)
					<tr>
						<td>
                            {{ $account->code}}
						</td>
						<td>{{ $account->accountType->name }}</td>
						<td>
							{{ $account->current_balance }}
						</td>
						<td>
							@if($account->trashed())
							<form class="form-inline" method="post" action="{{ route('accounts.reopen', $account)}}" style="display: inline;">
								@csrf
								@method('patch')
								<button type="submit" class="btn btn-primary">Open</button>
							</form>
							@else
								<a class="btn btn-primary" href="{{ route('movements.list', $account )}}" role="button">View Movements</a>
								<a class="btn btn-primary" href="{{ route('accounts.edit', $account )}}" role="button">Edit</a>
								<form class="form-inline" method="post" action="{{ route('accounts.close', $account)}}" style="display: inline;">
								@csrf
								@method('patch')
									<button type="submit" class="btn btn-primary">Close</button>
								</form>
							@endif
							@empty($account->last_movement_date)
								<form class="form-inline" method="post" action="{{ route('accounts.destroy', $account)}}" style="display: inline;">
								@csrf
								@method('delete')
									<button type="submit" class="btn btn-danger">Remove</button>
								</form>
							@endempty
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="d-flex justify-content-center">
				{{ $accounts->links()}}
			</div>
			@endif
		</div>
	</div>
</div>
@endsection('content')