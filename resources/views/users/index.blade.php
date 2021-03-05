@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{Request::is('customers*') ? 'Clientes' : 'Usuarios'}}</h1>
                </div>
                <div class="col-sm-6">
                
                    @if(Request::is('customers*'))
                    <a class="btn btn-primary float-right m-2"
                       href="{{ route('customers.create') }}">
                        Añadir Cliente
                    </a>                    
                    @else
                    <a class="btn btn-primary float-right m-2"
                       href="{{ route('users.create') }}">
                        Añadir Usuario
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-2">
                @include('users.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

