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
	@can('add-movement', $account->owner->id)
		<a class="btn btn-primary" href="{{ route('movements.create', $account )}}" role="button">Add Movements</a>
		&nbsp
		@endcan
		<a class="btn btn-primary" href="{{ route('accounts.opened', $account->owner )}}" role="button">Accounts</a>
	</div>
	<br>
	<div class="row">
		<div class="col">
		@if(count($movements) == 0)
			<h4>No movements found</h4>
		@else
			<table class="table">
				<thead> 
				<tr>
					<th>Date</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Start balance</th>
                    <th>Value</th>
					<th>End Balance</th>
					<th></th>
					<th>Document</th>
					
					
					
				</tr> 
				</thead>
				<tbody>
					@foreach ($movements as $movement)
					<tr>
						<td>
                            {{ $movement->date}}
						</td>
						<td>
                            {{ $movement->movementCategory->name }}
                        </td>
						<td>
							{{ $movement->type }}
						</td>
						<td>
							{{ $movement->start_balance }}
						</td>
                        <td>
                            {{ $movement->value }}
                        </td>
                        <td>
                            {{ $movement->end_balance }}
                        </td>
						<td>
							@can('edit-movement', $movement->account->owner_id)
								<a class="btn btn-primary" href="{{ route('movement.edit', $movement )}}" role="button">Edit</a>
							@endcan
							@can('remove-movement', $movement)
								<form class="form-inline" method="post" action="{{ route('movement.delete', $movement)}}" style="display: inline;">
									@csrf
									@method('delete')
										<button type="submit" class="btn btn-danger">Remove</button>
								</form>
							@endcan
						</td>
						<td>
							@can('add-document', $movement)
								<a class="btn btn-primary" href="{{ route('document.edit', $movement->id )}}" role="button">Upload</a>
							@endcan
							@isset($movement->document_id)
								<a class="btn btn-primary" href="{{ action('DocumentController@download', $movement->document_id)}}" role="button">Download</a>
								@can('add-document', $movement)
									<form class="form-inline" method="post" action="{{ route('document.delete', $movement) }}" style="display: inline;">
									@csrf
									@method('delete')
										<button type="submit" class="btn btn-danger">Remove</button>
									</form>
								@endcan
							@endisset
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="d-flex justify-content-center">
				{{ $movements->links()}}
			</div>
			@endif
		</div>
	</div>
</div>
@endsection('content')