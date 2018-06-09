@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
		<div class="col text-center">
			<h1>{{ $title }}</h1>
		</div>
	</div>
    <br>
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
    <br>
    <div class="row">
        <div class="col">
        <form action="{{ route('movement.update', $movement->id) }}" method="post" class="form-group" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                    <input type="text" class="form-control" name="value" value="{{ $movement->value < 0 ? -$movement->value : $movement->value }}">
                </div>
                <div class="form-group row">
                    <label>Date</label>
                    <input type="text" class="form-control" name="date" value="{{ $movement->date }}">
                </div>
                <div class="form-group row">
                    <label>Description</label>
                    <input type="text" class="form-control" name="description" value="{{ $movement->description }}">
                </div>
                <div class="form-group row">
                    <label>Document description</label>

                   
                    <input type="text" class="form-control" name="document_description">

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
