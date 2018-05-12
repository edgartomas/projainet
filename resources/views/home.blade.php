@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 10px">
    <div class="row">
        <div class="col">
          <h1>{{ Auth::user()->name }}</h1> 

          <img src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}" style ="width:150px; height:150px; float:left; border-radius: 50%; margin-right: 25px; ">
        </div>
        
        <table class="table" style="margin-top: 50px">
        	<thead>
        		<tr>
        			<th>  Teste</th>
        			<th>  Teste</th>
        			<th>  Teste</th>
        			<th>  Teste</th>
        			<th>  {{Auth::user()->id}}</th>
        		</tr>
        	</thead>
        	<tbody>
        		@foreach($accounts as $account)
        		<tr>
        			@if($account->owner_id == Auth::user()->id)
        			<td> 
        				{{$account->id}}
        			</td>
        			<td> 
        				{{$account->owner_id}}
        			</td>
        			<td> 
        				{{$account->start_balance}}
        			</td>
        			<td> 
        				{{$account->start_balance}}
        			</td>
        			@endif
        		</tr>
        		@endforeach
        	</tbody>
        	

        </table>


    </div>

		<a href="{{route('home.user', $account)}}" class="btn btn-xs btn-primary">Ver Contas</a>
</div>
@endsection
