<!-- User Field -->
<div class="col-sm-12">
    {!! Form::label('user', 'Usuario:') !!}
    <p>{{ $purchase->user_relation->name }}</p>
</div>

<!-- Supplier Field -->
<div class="col-sm-12">
    {!! Form::label('supplier', 'Proveedor:') !!}
    <p>{{ $purchase->supplier_relation->name }}</p>
</div>

<!-- Products Field -->
<div class="col-sm-12">
    {!! Form::label('products', 'Productos:') !!}
    <ul>
    @foreach(json_decode($purchase->products) as $product)
        <li>{{$products[$product->producto]->name}}: {{$product->cantidad}} (Presentación: {{$product->presentacion->kg}} kg)</li>
    @endforeach
    </ul>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>$ {{ number_format ($purchase->total) }}</p>
</div>

<!-- Cash Field -->
<div class="col-sm-12">
    {!! Form::label('cash', 'Contado:') !!}
    <p>$ {{ number_format ($purchase->cash) }}</p>
</div>

<!-- Credit Field -->
<div class="col-sm-12">
    {!! Form::label('credit', 'Crédito:') !!}
    <p>$ {{ number_format ($purchase->credit) }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Estado:') !!}
    <p>{{ $purchase->status }}</p>
</div>

<!-- Payment Status Field -->
<div class="col-sm-12">
    {!! Form::label('payment_status', 'Estado de pago:') !!}
    <p>{{ $purchase->payment_status }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $purchase->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $purchase->updated_at }}</p>
</div>