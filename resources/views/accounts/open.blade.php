@extends('accounts.list')
@section('buttons')
<a class="btn btn-primary" href="{{ route('accounts.index', Auth::user()) }}" role="button">All Accounts</a>
<a class="btn btn-primary" href="{{ route('accounts.closed', Auth::user()) }}" role="button">Closed Accounts</a>
@endsection('buttons') 