{!! Form::open(['route' => ['products.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('products.show', $id) }}" class='btn btn-success btn-xs'>
        <i class="fa fa-eye fa-xs"></i>
    </a>
    <a href="{{ route('products.edit', $id) }}" class='btn btn-primary btn-xs'>
        <i class="fa fa-edit fa-xs"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash fa-xs"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
