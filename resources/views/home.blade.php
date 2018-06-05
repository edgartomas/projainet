@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 10px">
    <div class="row">
        <div class="col text-center">
          <h1>{{ $title }}</h1> 
        </div>
	</div>
	<br>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header bg-primary text-white">
					Balance
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Total: {{ number_format($total, 2, '.', ',') }}</li>
				</ul>
			</div>
		</div>
		<div class="col">
			<div class="card">
				<div class="card-header bg-primary text-white">
					Revenue
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Total: {{ number_format($totalExpense, 2, '.', ',') }}</li>
					
				</ul>
			</div>
		</div>
		<div class="col">
			<div class="card">
				<div class="card-header bg-primary text-white">
					Expense
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item">Total: {{ number_format($totalRevenue, 2, '.', ',') }}</li>
				</ul>
			</div>
		</div>		
	</div>
	<hr>
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
						<th>Percent</th>
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
							<td>{{ $account->current_balance }}</td>
							<td>
							@if($total != 0 )
								{{ number_format(($account->current_balance * 100 / $total), 2) }}%
							@endif
							</td>
							<td>
							@if(!$account->trashed())
							<a class="btn btn-primary" href="{{ route('movements.list', $account )}}" role="button">View Movements</a>
							@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				{{$accounts->appends($_GET)->links()}}
				@endif
		</div>
	</div>
</div>
@endsection
