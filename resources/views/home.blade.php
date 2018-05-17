@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 10px">
    <div class="row">
        <div class="col">
          <h1> Accounts of {{ Auth::user()->name }}</h1> 

          <img src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}" style ="width:150px; height:150px; float:left; border-radius: 50%; margin-right: 25px; ">
            

        </div>

        
        
        <table class="table" style="margin-top: 50px">
        	<thead>
        		<tr>
        			<th>  Start Balance</th>
        			<th>  Current Balance</th>
        			<th>  Actions</th>
        		
        			
        		</tr>
        	</thead>
        	<tbody>
        		@foreach($accounts as $account)
        		<tr>
        			@if($account->owner_id == Auth::user()->id)
        			<td> 
        				{{$account->start_balance}}
        			</td>
        			<td> 
        				{{$account->current_balance}}
        			</td>
        			<td> 
        				<a href="{{route('accounts.edit', $account)}}" class="btn btn-xs btn-primary">Editar dados de Conta</a>
        			</td>
                    <td> 
                        <a href="{{route('movements.list', $account->id)}}" class="btn btn-xs btn-primary">Consultar Movimentos da Conta</a>
                    </td>
        			       			
        			@endif
        		</tr>
        		@endforeach
        	</tbody>
        	

        </table>


    </div>

   


		
</div>
@endsection
