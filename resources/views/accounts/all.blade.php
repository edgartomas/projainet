@extends('accounts.list')
@section('buttons')
<a class="btn btn-primary" href="{{ route('accounts.opened', Auth::user()) }}" role="button">Open Accounts</a>
<a class="btn btn-primary" href="{{ route('accounts.closed', Auth::user()) }}" role="button">Closed Accounts</a>
@endsection('buttons') 