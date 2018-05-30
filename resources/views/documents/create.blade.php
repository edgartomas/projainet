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
            <form action="{{ route('document.index', $movement) }}" method="post" class="form-group" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row">
                    <label>Document</label>
                    <input type="file" class="form-control" name="document_file">
                </div>
                <div class="form-group row">
                    <label>Document description</label>
                    <input type="text" class="form-control" name="document_description" value="{{ old('document_description') }}">
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