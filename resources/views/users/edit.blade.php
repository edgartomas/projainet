@extends('layouts.app')
@section('content')



<form action = "{{route('accounts.edit', $account )}}" method="post" class="form-group">
    @csrf
    @method('put')

   
   
    <div class="form-group" style="margin-left: 20px">
        <label for="inputPasswordConfirmation">Type</label>
        
            <select name="type" id="inputType" class="form-control">
           
            <option {{ old('type', $account->account_type_id) == '1' ? 'selected' : ''}} value="1">Bank Account</option>
            <option {{ old('type', $account->account_type_id) == '2' ? 'selected' : ''}} value="2">Pocket Money</option>
            <option {{ old('type',  $account->account_type_id) == '3' ? 'selected' : ''}} value="3">PayPal Account</option>
            <option {{ old('type',  $account->account_type_id) == '4' ? 'selected' : ''}} value="4">Credit Card</option>
            <option {{ old('type',  $account->account_type_id) == '5' ? 'selected' : ''}} value="5">Meal Card</option>
        </select>
 
</select>
    </div>
    <div class="form-group" style="margin-left: 20px">
        <label for="inputPasswordConfirmation">Code</label>
        <input
            type="text" class="form-control"
            name="code" id="code"
            value="{{ old('code' , $account->code) }}"/>
    </div>
    <div class="form-group" style="margin-left: 20px">
        <label for="inputPasswordConfirmation">Description</label>
        <input
            type="text" class="form-control"
            name="description" id="description"
            value="{{ old('description' , $account->description) }}"
           "/>
    </div>
    <div class="form-group" style="margin-left: 20px">
        <label for="inputPasswordConfirmation">Start Balance</label>
        <input
            type="text" class="form-control"
            name="start_balance" id="start_balance"
             value="{{ old('start_balance' , $account->start_balance) }}"/>
    </div>
    <div class="form-group" >
        <button type="submit" class="btn btn-success" name="ok">Edit</button>
        <a  class="btn btn-default"  href="{{ route('users.index')}}" name="cancel">Cancel</button>
    </div>
</form>

@endsection('content') 
