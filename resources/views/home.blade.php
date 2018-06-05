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
		<div class="col-2">
			<div class="card border-primary" style="margin-bottom:10px;">
				<div class="card-header text-center bg-primary text-white">
					Total Balance
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item text-center">{{ number_format($total, 2, '.', ',') }}</li>
				</ul>
			</div>
			<div class="card border-primary" style="margin-bottom:10px;">
				<div class="card-header bg-primary text-white text-center">
					Total Revenue
				</div>
				<ul class="list-group list-group-flush text-center">
					<li class="list-group-item">{{ number_format($totalExpense, 2, '.', ',') }}</li>
				</ul>
			</div>
			<div class="card border-primary">
				<div class="card-header text-center bg-primary text-white">
					Total Expense
				</div>
				<ul class="list-group list-group-flush">
					<li class="list-group-item text-center">{{ number_format($totalRevenue, 2, '.', ',') }}</li>
				</ul>
			</div>
		</div>
		<div class="col-4">
			<div class="card border-primary text-center" style="height:100%;">
				<div class="card-header bg-primary text-white">
					Revenues
				</div>
				<div class="card-body">
					<div id="revenue-chart"></div>
					@piechart('Revenue', 'revenue-chart')
				</div>
			</div>
		</div>
		<div class="col-4">
			<div class="card border-primary text-center" style="height:100%;">
				<div class="card-header bg-primary text-white">
					Expenses
				</div>
				<div class="card-body">
					<div id="expense-chart"></div>
					@piechart('Expense', 'expense-chart')
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card border-primary text-center" style="height:100%;">
				<div class="card-header bg-primary text-white">
					Filter
				</div>
				<div class="card-body">
					<form>
						<div class="form-group">
							<label>Start Date</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group">
							<label>End Date</label>
							<input type="text" class="form-control">
						</div>
						<button type="submit" class="btn btn-primary">Filter</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col">
			<div class="card border-primary">
				<div class="card-header bg-primary text-white">
					Accounts
				</div>
				<div class="card-body">
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
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="d-flex justify-content-end">
							{{$accounts->appends($_GET)->links()}}
						</div>
					@endif
				</div>
			</div>	
		</div>
	</div>
	<div class="row">
		<div class="col">

		</div>
	</div>
</div>
@endsection
