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
		<div class="col-3">
			<h4>Total balance: {{ $total }}</h4>
			<br>
			<h4>Total revenue: {{ number_format($totalRevenue, 2) }}</h4>
			<br>
			<h4>Total expense: {{ number_format($totalExpense, 2) }}</h4>
		</div>
		<div class="col-9">
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
							<td>
							{{ abs(number_format($account->current_balance / $totalAbs * 100, 2)) }}%
							</td>
							<td>
							<a class="btn btn-primary" href="{{ route('movements.list', $account )}}" role="button">View Movements</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@endif
		</div>		
	</div>
	<hr>
</div>
@endsection
