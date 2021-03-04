<!-- User Field -->
<div class="col-sm-12">
    {!! Form::label('user', 'User:') !!}
    <p>{{ $process->user }}</p>
</div>

<!-- Responsible Field -->
<div class="col-sm-12">
    {!! Form::label('responsible', 'Responsible:') !!}
    <p>{{ $process->responsible }}</p>
</div>

<!-- Process Template Field -->
<div class="col-sm-12">
    {!! Form::label('process_template', 'Process Template:') !!}
    <p>{{ $process->process_template_relation->name }}</p>
</div>

<!-- Comments Field -->
<div class="col-sm-12">
    {!! Form::label('comments', 'Comments:') !!}
    <p>{{ $process->comments }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $process->status }}</p>
</div>

<!-- Inputs Field -->
<div class="col-sm-12">
    {!! Form::label('inputs', 'Inputs:') !!}
    <p>{{ $process->inputs }}</p>
</div>

<!-- Outputs Field -->
<div class="col-sm-12">
    {!! Form::label('outputs', 'Outputs:') !!}
    <p>{{ $process->outputs }}</p>
</div>

<!-- Metadata Field -->
<div class="col-sm-12">
    {!! Form::label('metadata', 'Metadata:') !!}
    <p>{{ $process->metadata }}</p>
</div>

<!-- Scheduled Date Field -->
<div class="col-sm-12">
    {!! Form::label('scheduled_date', 'Scheduled Date:') !!}
    <p>{{ $process->scheduled_date }}</p>
</div>

<!-- Executed Date Field -->
<div class="col-sm-12">
    {!! Form::label('executed_date', 'Executed Date:') !!}
    <p>{{ $process->executed_date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $process->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $process->updated_at }}</p>
</div>

