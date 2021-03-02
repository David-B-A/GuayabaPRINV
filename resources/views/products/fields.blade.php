<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Tipo:') !!}
    {!! Form::select('type', [null=>'Seleccionar', 'Producto' => 'Producto', 'Subproducto' => 'Subproducto', 'Materia Prima' => 'Materia Prima'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Input Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('input_price', 'Precio de compra / producción (kg):') !!}
    {!! Form::text('input_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Sale Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sale_price', 'Precio de venta (kg):') !!}
    {!! Form::text('sale_price', null, ['class' => 'form-control']) !!}
</div>

<!-- Stock Field -->
<div class="form-group col-sm-6">
    {!! Form::label('stock', 'Existencias (kg):') !!}
    {!! Form::number('stock', null, ['class' => 'form-control']) !!}
</div>

<!-- Metadata Field -->

<div class="form-group col-sm-6">
    {!! Form::label('metadata', 'Presentación (kg):') !!}
    @php
    $presentacion_kg = 40
    @endphp
    @if(isset($product->metadata))
    @if(isset(json_decode($product->metadata)->presentacion_kg[0]))
    @php
    $presentacion_kg = json_decode($product->metadata)->presentacion_kg[0]
    @endphp
    @endif
    @endif
    {!! Form::number('metadata[presentacion_kg][0]', $presentacion_kg, ['class' => 'form-control', 'required' => TRUE, 'min' => 0]) !!}

</div>

<div class="form-group col-sm-6">
    {!! Form::label('metadata', 'Descripción:') !!}
    @php
    $descripcion = ''
    @endphp
    @if(isset($product->metadata))
    @if(isset(json_decode($product->metadata)->descripcion))
    @php
    $descripcion = json_decode($product->metadata)->descripcion
    @endphp
    @endif
    @endif
    {!! Form::text('metadata[descripcion]', $descripcion, ['class' => 'form-control', 'required' => TRUE]) !!}
</div>

