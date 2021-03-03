<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{{ $processTemplate->name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Descripción:') !!}
    <p>{{ $processTemplate->description }}</p>
</div>

<!-- Inputs Field -->
<div class="col-sm-12">
    {!! Form::label('inputs', 'Entradas:') !!}
    <ul>
    @foreach(json_decode($processTemplate->inputs) as $input)
        <li>{{$products[$input->producto]->name}}: {{$input->cantidad}} (Presentación: {{$input->presentacion->kg}} kg)</li>
    @endforeach
    </ul>
</div>

<!-- Outputs Field -->
<div class="col-sm-12">
    {!! Form::label('outputs', 'Salidas:') !!}
    <ul>
    @foreach(json_decode($processTemplate->outputs) as $output)
        <li>{{$products[$output->producto]->name}}: {{$output->cantidad}} (Presentación: {{$output->presentacion->kg}} kg)</li>
    @endforeach
    </ul>
</div>

<!-- Metadata Field -->
<div class="col-sm-12">
    {!! Form::label('metadata', 'Metadata:') !!}
    <p>{{ $processTemplate->metadata }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $processTemplate->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $processTemplate->updated_at }}</p>
</div>

