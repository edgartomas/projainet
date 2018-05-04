@extends('master') <!-- temos que por o ficheiro html que queremos usar -->
@section('content')

<table class="table table-striped">
	<thead> <tr> <th><font color="black">Name </font></th> <th><font color="black">Email </font></th> <th><font color="black">Actions </font></th> <th></th> </tr> </thead>

 

	 
	<tbody>
		@foreach ($users as $user)
		<tr>
			<td> <font color="black">{{ $user->name }} </font> </td>
			<td> <font color="black">{{ $user->email }} </font> </td>
			<td><a href="{{ route('users.create')}}" class="btn btn-xs btn-danger">Add Movement</a></td>
		
			<td>
				<form action="#" method="post">
					<input type="hidden" name="id"  value="{{$user->id}}">
					<input type="submit" type="submit" class="btn btn-xs btn-danger" value="Delete">
				</form>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="text-center">
{{$users->links()}}	
@endsection('content') 
<!-- yeald tem o mesmo nome do content