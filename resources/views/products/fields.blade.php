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
@php
$presentacion_kg = 40;
$presentacion_costo = 0;
$presentacion_precio_venta = 0;
$descripcion = '';
if(isset($product->metadata)){
    if(isset(json_decode($product->metadata)->presentacion[0]->kg)){
        $presentacion_kg = json_decode($product->metadata)->presentacion[0]->kg;
    }
    if(isset(json_decode($product->metadata)->presentacion[0]->costo)){
        $presentacion_costo = json_decode($product->metadata)->presentacion[0]->costo;
    }
    if(isset(json_decode($product->metadata)->presentacion[0]->precio_venta)){
        $presentacion_precio_venta = json_decode($product->metadata)->presentacion[0]->precio_venta;
    }
    if(isset(json_decode($product->metadata)->descripcion)){
        $descripcion = json_decode($product->metadata)->descripcion;
    }
}
@endphp
<div class="form-group col-sm-6">
    {!! Form::label('metadata', 'Presentación (kg):') !!}
    {!! Form::number('metadata[presentacion][0][kg]', $presentacion_kg, ['class' => 'form-control', 'required' => TRUE, 'min' => 0]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('metadata', 'Presentación (costo):') !!}
    {!! Form::number('metadata[presentacion][0][costo]', $presentacion_costo, ['class' => 'form-control', 'required' => TRUE, 'min' => 0]) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('metadata', 'Presentación (precio venta):') !!}
    {!! Form::number('metadata[presentacion][0][precio_venta]', $presentacion_precio_venta, ['class' => 'form-control', 'required' => TRUE, 'min' => 0]) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('metadata', 'Descripción:') !!}
    {!! Form::text('metadata[descripcion]', $descripcion, ['class' => 'form-control', 'required' => TRUE]) !!}
</div>

