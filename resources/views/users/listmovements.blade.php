@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 10px">
    <div class="row">
        <div class="col">
          <h1> Accounts of {{ Auth::user()->name }}</h1> 

          <img src="{{ asset('storage/profiles/' . Auth::user()->profile_photo )}}" style ="width:150px; height:150px; float:left; border-radius: 50%; margin-right: 25px; ">
            

        </div>

        <div> <a class="btn btn-xs btn-primary">Adicionar Movimentos</a></div>
       

        
        
        <table class="table" style="margin-top: 50px">
            <thead>
                <tr>
                    <th>  Start Balance</th>
                    <th>  Current Value</th>
                    <th>  End Balance</th>
                    <th>  Actions    </th>
                
                    
                </tr>
            </thead>
<<<<<<< HEAD
            <tbody>  
         
=======
            <tbody>
           
>>>>>>> e448d24e242094c2812c6802f484936b294c4341
               @foreach($movements as $movement)
                <tr>
                    
                    <td> 
                        {{$movement->start_balance}}
                    </td>
                    <td> 
                        {{$movement->value}}
                    </td>
                     <td> 
                        {{$movement->end_balance}}
                    </td>
                    <td>
                        <a class="btn btn-xs btn-primary">Editar</a>
                        <a class="btn btn-xs btn-primary">Delete</a>
                    </td>                              
                   
                </tr>
                @endforeach
            </tbody>
            

        </table> 


    </div>

   


		
</div>
@endsection
