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
    <br>
    <div class="row">
        <div class="col">
        <form action = "{{route('accounts.update', $account) }}" method="post" class="form-group">
            @csrf
            @method('put')
            <div class="form-group row">
                <label for="inputPasswordConfirmation">Type</label>
                
                    <select name="account_type_id" id="inputType" class="form-control">
                
                    <option {{ old('type', $account->account_type_id) == '1' ? 'selected' : '' }} value="1">Bank Account</option>
                    <option {{old('type', $account->account_type_id) == '2' ? 'selected' : ''}} value="2">Pocket Money</option>
                    <option {{old('type',$account->account_type_id) == '3' ? 'selected' : ''}} value="3">PayPal Account</option>
                    <option {{old('type',  $account->account_type_id) == '4' ? 'selected' : ''}} value="4">Credit Card</option>
                    <option {{old('type',  $account->account_type_id) == '5' ? 'selected' : ''}} value="5">Meal Card</option>
                </select>
        
        </select>
            </div>
            <div class="form-group row">
                <label>Code</label>
                <input type="text" class="form-control" name="code" id="code" value="{{ old('code' , $account->code) }}"/>
            </div>
            <div class="form-group row">
                <label for="inputPasswordConfirmation">Description</label>
                <input
                    type="text" class="form-control"
                    name="description" id="description"
                    value="{{ old('description' , $account->description) }}"/>
            </div>
            <div class="form-group row">
                <label for="inputPasswordConfirmation">Start Balance</label>
                <input
                    type="text" class="form-control"
                    name="start_balance" id="start_balance"
                    value="{{ old('start_balance' , $account->start_balance) }}"/>
            </div>
            <div class="form-group row">
                <label for="inputPasswordConfirmation">Date</label>
                <input
                    type="text" class="form-control"
                    name="start_balance" id="start_balance"
                    value="{{ old('date' , $account->date) }}"/>
            </div>
            <div class="form-group row" >
                <button type="submit" class="btn btn-primary">Edit</button>
                <a  class="btn btn-default"  href="{{ URL::previous() }}" name="cancel">Cancel</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection('content') 
