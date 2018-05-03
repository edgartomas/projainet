@extends('master') <!-- temos que por o ficheiro html que queremos usar -->
@section('content')


<table>
	<thead> <tr> <th>Name</th> <th>Age</th> <th></th> <th></th> </tr> </thead>

	 <button class="btn btn-xs btn-danger"> Add User</button> 

	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{{ $user->name }} </td>
			<td>{{ $user->age }} </td>
			
			
		</tr>
		@endforeach
	</tbody>
</table>
@endsection('content') 
<!-- yeald tem o mesmo nome do content