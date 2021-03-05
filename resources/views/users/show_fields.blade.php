<!-- Comments Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Ubicación:') !!}
    <p>{{ $user->location }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Dirección:') !!}
    <p>{{ $user->address }}</p>
</div>

<!-- City Field -->
<div class="col-sm-12">
    {!! Form::label('city', 'Ciudad:') !!}
    <p>{{ $user->city }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'Teléfono:') !!}
    <p>{{ $user->phone }}</p>
</div>

<!-- Accounting Account Field -->
<div class="col-sm-12">
    {!! Form::label('accountign_account', 'Cuenta contable:') !!}
    <p>{{ $user->accountign_account }}</p>
</div>

<!-- Role Field -->
<div class="col-sm-12">
    {!! Form::label('role', 'Rol:') !!}
    <p>{{ $user->roles->first()->name }}</p>
</div>
