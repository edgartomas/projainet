@extends('accounts.list')
@section('buttons')
<a class="btn btn-primary" href="{{ route('accounts.index', Auth::user()) }}" role="button">All Accounts</a>
<a class="btn btn-primary" href="{{ route('accounts.opened', Auth::user()) }}" role="button">Open Accounts</a>
@endsection('buttons') 