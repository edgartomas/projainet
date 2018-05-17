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
        </div>
    </div>
    <div class="row">
		<div class="col text-center">
			<h1>{{ $title }}</h1>
		</div>
	</div>
    <br>
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <form action="{{ route('account.store') }}" method="post" class="form-group">
                @csrf
                <div class="form-group row">
                    <label>Owner</label>
                    <input type="text" readonly class="form-control-plaintext" value="{{ Auth::user()->name}}">
                </div>
                <div class="form-group row">
                    <label>Code</label>
                    <input type="text" class="form-control" name="code">
                </div>
                <div class="form-group row">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date">
                </div>
                <div class="form-group row">
                    <label>Account Type</label>
                    <select class="form-control" name="account_type_id">
                        <option value="1">Bank Account</option>
                        <option value="2">Pocket Money</option>
                        <option value="3">PayPal Account</option>
                        <option value="4">Credit Card</option>
                        <option value="5">Meal Card</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label>Start Balance</label>
                    <input type="text" class="form-control" name="start_balance">
                </div>
                <div class="form-group row">
                    <label>Description</label>
                    <input type="text" class="form-control" name="description">
                </div>
                <div class="form-group row ">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    &nbsp
                    <a class="btn btn-primary" href="{{ URL::previous() }}" role="button">Cancel</a>
                </div>  
            </form>
        </div>
    </div>
</div>
@endsection('content')