<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $product->name }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', 'Tipo:') !!}
    <p>{{ $product->type }}</p>
</div>

<!-- Input Price Field -->
<div class="col-sm-12">
    {!! Form::label('input_price', 'Precio de compra / producción (kg):') !!}
    <p>{{ $product->input_price }}</p>
</div>

<!-- Sale Price Field -->
<div class="col-sm-12">
    {!! Form::label('sale_price', 'Precio de venta (kg):') !!}
    <p>{{ $product->sale_price }}</p>
</div>

<!-- Stock Field -->
<div class="col-sm-12">
    {!! Form::label('stock', 'Existencias:') !!}
    <ul>
    <li>{{ $product->stock }} kg</li>
    @if(json_decode($product->metadata) != null)
    @if(isset(json_decode($product->metadata)->presentacion_kg))
    @if(json_decode($product->metadata)->presentacion_kg)
    @foreach(json_decode($product->metadata)->presentacion_kg as $key => $value)
    <li>{{ $product->stock / $value }} (presentación: {{$value}} kg)</li>
    @endforeach
    @endif
    @endif
    @endif
    </ul>
</div>

<!-- Metadata Field -->
<div class="col-sm-12">
    {!! Form::label('metadata', 'Metadata:') !!}
    @if(json_decode($product->metadata) != null)
    <ul>
    @foreach(json_decode($product->metadata) as $key => $value)
    <li>{{ $key }}: {{ json_encode($value) }}</li>
    @endforeach
    </ul>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $product->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $product->updated_at }}</p>
</div>

