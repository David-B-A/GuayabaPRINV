<!-- User Field -->
<div class="col-sm-12">
    {!! Form::label('user', 'Usuario:') !!}
    <p>{{ $sale->user }}</p>
</div>

<!-- Customer Field -->
<div class="col-sm-12">
    {!! Form::label('customer', 'Cliente:') !!}
    <p>{{ $sale->customer }}</p>
</div>

<!-- Products Field -->
<div class="col-sm-12">
    {!! Form::label('products', 'Productos:') !!}
    <ul>
    @foreach(json_decode($sale->products) as $product)
        <li>{{$products[$product->producto]->name}}: {{$product->cantidad}} (Presentación: {{$product->presentacion->kg}} kg)</li>
    @endforeach
    </ul>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $sale->total }}</p>
</div>

<!-- Cash Field -->
<div class="col-sm-12">
    {!! Form::label('cash', 'Contado:') !!}
    <p>{{ $sale->cash }}</p>
</div>

<!-- Credit Field -->
<div class="col-sm-12">
    {!! Form::label('credit', 'Credito:') !!}
    <p>{{ $sale->credit }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Estado:') !!}
    <p>{{ $sale->status }}</p>
</div>

<!-- Payment Status Field -->
<div class="col-sm-12">
    {!! Form::label('payment_status', 'Estado de pago:') !!}
    <p>{{ $sale->payment_status }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $sale->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $sale->updated_at }}</p>
</div>

