<!-- Comments Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Location Field -->
<div class="form-group col-sm-6">
    {!! Form::label('location', 'Ubicación:') !!}
    <div class="row">
        <div class="col-sm-8">
            {!! Form::text('location', null, ['class' => 'form-control', 'readonly' => True]) !!}
        </div>
        <div class="col-sm-4" align="center">
                <a class="btn btn-success text-white" style='width:6rem' id="getCurrentLocation"><i class='fa fa-thumbtack fa-xs'></i> Actual</a>
                <a class="btn btn-primary text-white" style='width:6rem' id="getLocationLink"><i class='fa fa-map-marker fa-xs'></i> Link</a>
        </div>
    </div>
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Dirección:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- City Field -->
<div class="form-group col-sm-6">
    {!! Form::label('city', 'Ciudad:') !!}
    {!! Form::text('city', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Teléfono:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Accounting Account Field -->
<div class="form-group col-sm-6">
    {!! Form::label('accountign_account', 'Cuenta contable:') !!}
    {!! Form::text('accountign_account', null, ['class' => 'form-control']) !!}
</div>

<!-- Role Field -->
@if(!Request::is('customers*'))
<div class="form-group col-sm-6">
    {!! Form::label('roles[0]', 'Rol:') !!}
    {!! Form::select('roles[0]',[null => 'Seleccionar'] + $roles, isset($user) ? $user->roles->first()->name : null, ['class' => 'form-control']) !!}
</div>
@endif


@push('page_scripts')
<script>
var x = document.getElementById("demo");
$('#getCurrentLocation').click(function(){
    getLocation();
});
$('#getLocationLink').click(function(){
    result = window.prompt('Por favor ingrese el link de localización');
    if(result.length > 0){
        try {
            url = new URL(result);
        } catch (e) {
            alert('No se pudo obtener la ubicación del link seleccionado, asegúrate de que sea un link de waze o google maps válido');
            return;
        }
        if(url.hostname == "www.waze.com"){
            loc = url.searchParams.get('ll');
            $('#location').val(loc);
        } else if(url.hostname == "maps.google.com"){
            loc = url.searchParams.get('q');
            $('#location').val(loc);
        } else {
            alert('No se pudo obtener la ubicación del link seleccionado, asegúrate de que sea un link de waze o google maps válido');
        }
    }
});
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(setLocation);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function setLocation(position) {
    $('#location').val(position.coords.latitude + ',' + position.coords.longitude);
}
</script>
@endpush

