@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7" style="margin-top: 2%">
                <div class="box">
                    <img src="{{asset('img/GuayabaPRINV.jpg')}}"
                         class="user-image elevation-2" alt="User Image">
                    <h3 class="box-title" style="padding: 2%">Verificar Email</h3>

                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">Se te ha enviado un link para verificar tu correo
                            </div>
                        @endif
                        <p>Antes de continuar, por favor verifica tu correo. si no has recibido el link </p>
                        <a href="{{ route('verification.resend') }}">haz clic aquí para solicitar uno nuevo'</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection