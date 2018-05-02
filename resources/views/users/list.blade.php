@extends('master') <!-- temos que por o ficheiro html que queremos usar -->
@section('content')

<table class="table table-striped">
	<thead> <tr> <th>Name</th> <th>Age</th> <th></th> <th></th> </tr> </thead>

	 <a href="{{ route('users.create')}}" class="btn btn-xs btn-danger">Add User</a>

	<tbody>
		@foreach ($users as $user)
		<tr>
			<td>{{ $user->name }} </td>
			<td>{{ $user->age }} </td>
			<td><a href="/users/{{ $user->id }}/edit" class="btn btn-xs btn-primary" >Edit</a></td>
			<td><a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-xs btn-primary" >Edit</a></td>
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
@endsection('content') 
<!-- yeald tem o mesmo nome do content