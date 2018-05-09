@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col">
          <h1>{{ Auth::user()->name }}</h1> 

          <img src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}" style ="width:150px; height:150px; float:left; border-radius: 50%; margin-right: 25px; ">
        </div>
        
        <table>
        @foreach ($accounts as $account)
					<tr>
						<td>{{ $account->start_balance }}</td>
						<td>{{ $account->current_balance }}</td>
						<td>{{ $account->owner_id }}</td>
						
							
						
					</tr>
					@endforeach
		</table>
    </div>
</div>
@endsection
