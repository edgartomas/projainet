@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <br>
            <div class="jumbotron">
                <h1 class="display-4">{{ $title }}</h1>
                <p>Aplicação para gestão de finanças pessoais.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card border-primary mb-3">
                <div class="card-header text-white bg-primary text-center">
                   Number of Users
                </div>
                <p class="card-text">
                    <h5 class="text-center">{{ $numUsers }}</h5>
                </p>
            </div>
        </div>
        <div class="col">
            <div class="card border-primary mb-3">
                <div class="card-header text-white bg-primary text-center">
                   Number of Accounts
                </div>
                <p class="card-text">
                    <h5 class="text-center">{{ $numAccounts }}</h5>
                </p>
            </div>
        </div>
        <div class="col">
            <div class="card border-primary mb-3">
                <div class="card-header text-white bg-primary text-center">
                   Number of Movements
                </div>
                <p class="card-text">
                    <h5 class="text-center">{{ $numMovements }}</h5>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection('content') 