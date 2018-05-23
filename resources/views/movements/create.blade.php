@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
				@if ($errors->any())
					<div class="alert alert-danger">
						{{ $errors->first() }}
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
			@endif
        </div>
    </div>
    <div class="row">
		<div class="col text-center">
			<h1>{{ $title }}</h1>
		</div>
	</div>
    <br>
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <form action="{{ route('movements.store', $account) }}" method="post" class="form-group">
                @csrf
                <div class="form-group row">
                    <label>Movement Type</label>
                    <select class="form-control" name="movement_category_id">
                    @foreach($categories as $category)
                        <option {{ old('movement_category_id') == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{ $category->name . " - " . $category->type}}</option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label>Value</label>
                    <input type="text" class="form-control" name="value" value="{{ old('value') }}">
                </div>
                <div class="form-group row">
                    <label>Date</label>
                    <input type="text" class="form-control" name="date" value="{{ old('date') }}">
                </div>
                <div class="form-group row">
                    <label>Description</label>
                    <input type="text" class="form-control" name="description" value="{{ old('description') }}">
                </div>
                <div class="form-group row">
                    <label>Document description</label>
                    <input type="text" class="form-control" name="document_description" value="{{ old('document_description') }}">
                </div>
                <div class="form-group row">
                    <label>Document</label>
                    <input type="file" class="form-control" name="document_file">
                </div>
                <div class="form-group row ">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    &nbsp
                    <a class="btn btn-primary" href="{{ URL::previous() }}" role="button">Cancel</a>
                </div>  
            </form>
        </div>
    </div>
</div>
@endsection('content')