{!! Form::open(['route' => ['users.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('users.show', $id) }}" class='btn btn-success btn-xs'>
        <i class="fa fa-eye fa-xs"></i>
    </a>
    <a href="{{ route('users.edit', $id) }}" class='btn btn-primary btn-xs'>
        <i class="fa fa-edit fa-xs"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash fa-xs"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
