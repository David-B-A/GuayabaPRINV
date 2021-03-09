<!-- User Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('user', 'Usuario:') !!}
    {!! Form::select('user',[null => 'Seleccionar'] + $users, null, ['class' => 'form-control']) !!}
</div> -->

<!-- Responsible Field -->
<div class="form-group col-sm-6">
    {!! Form::label('responsible', 'Responsable:') !!}
    {!! Form::select('responsible', [null => 'Seleccionar'] + $responsibles, null, ['class' => 'form-control']) !!}
</div>

<!-- Process Template Field -->
<div class="form-group col-sm-6">
    {!! Form::label('process_template', 'Proceso Estándar:') !!}
    {!! Form::select('process_template', [null => 'Seleccionar'] + $process_templates->pluck('name','id')->toarray(), null, ['class' => 'form-control']) !!}
</div>

<!-- Comments Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comments', 'Comentarios:') !!}
    {!! Form::text('comments', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Estado:') !!}
    {!! Form::select('status', ['Pendiente' => 'Pendiente', 'Realizado' => 'Realizado', 'Cancelado' => 'Cancelado'], null, ['class' => 'form-control custom-select']) !!}
</div>

@php
$data = '';
if(isset($process->metadata)){
    if(isset(json_decode($process->metadata)->data)){
        $data = json_decode($process->metadata)->data;
    }
}
@endphp

<!-- Metadata Field -->
<div class="form-group col-sm-6">
    {!! Form::label('metadata[data]', 'Metadata:') !!}
    {!! Form::text('metadata[data]', $data, ['class' => 'form-control']) !!}
</div>

<!-- Scheduled Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('scheduled_date', 'Fecha Planeada:') !!}
    {!! Form::date('scheduled_date', isset($process) ? $process->scheduled_date : date('Y-m-d'), ['class' => 'form-control']) !!}
</div>

<!-- Executed Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('executed_date', 'Fecha Ejecutada:') !!}
    {!! Form::date('executed_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Inputs Field -->

<div class="form-group col-sm-12 text-center table-responsive">
{!! Form::label('inputs', 'Entradas:') !!}
<table class="table">
    <thead>
        <tr>
            <th style="width: 50%">Producto</th>
            <th style="width: 15%">Presentación</th>
            <th style="width: 15%">Cantidad</th>
            <th style="width: 10%">Valor</th>
            <th style="width: 10%"></th>
        </tr>
    <thead>
    <tbody id="inputs_container">

    <!-- 
        * To avoid notation mixing, the input products in the process will be called inputs, 
        * and the list of available products will be called products.
        * The only exception is the select tag name and id
        * Notice that the json keys and values are in spanish, not english
    -->

    
    </tbody>
</table>
</div>

@push('page_scripts')
    <script>
        var products = {!! json_encode($products->toarray()) !!};            
        var process_templates = {!! json_encode($process_templates->toarray()) !!};
        var inputs = {!! isset($process->inputs) ? $process->inputs : '[]' !!};            
        var id_primero = 0;
        $(document).ready(function(){
            inputs = inputs.length == 0 ? [{'producto':1,'presentacion':{'kg':''},'cantidad':0}] : inputs;
            renderInputs(inputs,products);
        });
        $('#process_template').change(function(){
            inputs = JSON.parse(process_templates[this.value].inputs);
            renderInputs(inputs,products);
        });
        function addInput(idstr){
            inputs = parseInputs();
            id=parseInt(idstr.substring(8));
            inputs.splice(id+1, 0, {'producto':1,'presentacion':{'kg':''},'cantidad':0});
            console.log(inputs);
            renderInputs(inputs,products);      
        }
        function delInput(idstr){
            inputs = parseInputs();
            id=parseInt(idstr.substring(8));
            inputs.splice(id, 1);
            inputs = inputs.length == 0 ? [{'producto':1,'presentacion':{'kg':''},'cantidad':0}] : inputs;
            renderInputs(inputs,products);            
        }
        function parseInputs(){
            product_ids = $('.input-id');
            presentations = $('.input-presentation');
            ammounts = $('.input-ammount');
            inputs = []
            for(i=0;i<product_ids.length;i++){
                inputs.push({'producto':product_ids[i].value,'presentacion':{'kg':presentations[i].value},'cantidad':ammounts[i].value});
            }
            return inputs;
        }
        function renderInputs(inputs,products){
            htmlstr = '';
            total = 0;
            var productKeys = Object.keys(products);
            for(i=0;i<inputs.length;i++){
                htmlstr += `
                    <tr class="product col-sm-12" id="products[${i}]">
                        <td class="form-group">
                            <select class="form-control input-id" id="inputs[${i}][producto]" name="inputs[${i}][producto]" value="${inputs[i].producto}">
                `;  
                for(j=0;j<productKeys.length;j++){
                    key = productKeys[j];
                    selected = inputs[i].producto == key ? 'selected' : '';
                    htmlstr += `
                        <option ${selected} value="${key}">${products[key].name}</option>
                    `;
                }
                htmlstr += `
                            </select>
                        </td>
                        <td class="form-group">
                            <select class="form-control input-presentation" id="inputs[${i}][presentacion][kg]" name="inputs[${i}][presentacion][kg]" value="${inputs[i].presentacion.kg}">
                `;
                presentations = JSON.parse(products[inputs[i].producto].metadata).presentacion;
                cost = 0;
                sale_price = 0;
                for(p=0;p<presentations.length;p++){
                    selected = inputs[i].presentacion.kg == presentations[p].kg ? 'selected' : '';
                    cost =  inputs[i].presentacion.kg == presentations[p].kg ? presentations[p].costo : 0;
                    sale_price =  inputs[i].presentacion.kg == presentations[p].kg ? presentations[p].precio_venta : 0;
                    htmlstr += `
                    <option ${selected} value="${presentations[p].kg}">${presentations[p].kg}</option>
                    `;
                }
                temp = parseFloat(inputs[i].cantidad) * cost;
                temp = isNaN(temp) ? 0: temp;
                total += temp;
                htmlstr += `
                            </select>
                            <input type="hidden" id="inputs[${i}][presentacion][costo]" name="inputs[${i}][presentacion][costo]" value="${cost}" min="0" required>
                            <input type="hidden" id="inputs[${i}][presentacion][precio_venta]" name="inputs[${i}][presentacion][precio_venta]" value="${sale_price}" min="0" required>
                        </td>
                        <td class="form-group">
                            <input type="number" class="form-control input-ammount" id="inputs[${i}][cantidad]" name="inputs[${i}][cantidad]" value="${inputs[i].cantidad}" min="0" required>
                        </td>
                        <td class="form-group">
                            $ ${new Number(temp).toLocaleString("es-CO")}
                        </td>
                        <td class="form-group">
                            <div class='btn-group'>
                                <button id='inp_del_${i}' type="button" class="btn btn-danger btn_inp_del" ><i class="fa fa-trash fa-xs"></i></button>
                                <button id='inp_add_${i}' type="button" class="btn btn-success btn_inp_add" ><i class="fa fa-ad fa-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            $("#total").val(total);
            $("#inputs_container").html(htmlstr);
            $(".btn_inp_del").click(function(){
                delInput(this.id);
            });
            $(".btn_inp_add").click(function(){
                addInput(this.id);
            });
            $('.input-ammount').change(function(){
                inputs = parseInputs();
                renderInputs(inputs,products);
            });
            $('.input-id').change(function(){
                inputs = parseInputs();
                renderInputs(inputs,products);
            });
            $('.input-presentation').change(function(){
                inputs = parseInputs();
                renderInputs(inputs,products);
            });
        }
    </script>
@endpush


<!-- Outputs Field -->

<div class="form-group col-sm-12 text-center table-responsive">
{!! Form::label('outputs', 'Salidas:') !!}
<table class="table">
    <thead>
        <tr>
            <th style="width: 50%">Producto</th>
            <th style="width: 15%">Presentación</th>
            <th style="width: 15%">Cantidad</th>
            <th style="width: 10%">Valor</th>
            <th style="width: 10%"></th>
        </tr>
    <thead>
    <tbody id="outputs_container">

    <!-- 
        * To avoid notation mixing, the products in the process will be called outputs, 
        * and the list of available products will be called products.
        * The only exception is the select tag name and id
        * Notice that the json keys and values are in spanish, not english
    -->

    
    </tbody>
</table>
</div>

@push('page_scripts')
    <script>
        var products = {!! json_encode($products->toarray()) !!};            
        var process_templates = {!! json_encode($process_templates->toarray()) !!};   
        var outputs = {!! isset($process->outputs) ? $process->outputs : '[]' !!};
        var id_primero = 0;
        $(document).ready(function(){
            outputs = outputs.length == 0 ? [{'producto':1,'presentacion':{'kg':''},'cantidad':0}] : outputs;
            renderOutputs(outputs,products);
        });
        $('#process_template').change(function(){
            outputs = JSON.parse(process_templates[this.value].outputs);
            renderOutputs(outputs,products);
        });
        
        function addOutput(idstr){
            outputs = parseOutputs();
            id=parseInt(idstr.substring(8));
            outputs.splice(id+1, 0, {'producto':1,'presentacion':{'kg':''},'cantidad':0});
            console.log(outputs);
            renderOutputs(outputs,products);      
        }
        function delOutput(idstr){
            outputs = parseOutputs();
            id=parseInt(idstr.substring(8));
            outputs.splice(id, 1);
            outputs = outputs.length == 0 ? [{'producto':1,'presentacion':{'kg':''},'cantidad':0}] : outputs;
            renderOutputs(outputs,products);            
        }
        function parseOutputs(){
            product_ids = $('.output-id');
            presentations = $('.output-presentation');
            ammounts = $('.output-ammount');
            outputs = []
            for(i=0;i<product_ids.length;i++){
                outputs.push({'producto':product_ids[i].value,'presentacion':{'kg':presentations[i].value},'cantidad':ammounts[i].value});
            }
            return outputs;
        }
        function renderOutputs(outputs,products){
            htmlstr = '';
            total = 0;
            var productKeys = Object.keys(products);
            for(i=0;i<outputs.length;i++){
                htmlstr += `
                    <tr class="product col-sm-12" id="products[${i}]">
                        <td class="form-group">
                            <select class="form-control output-id" id="outputs[${i}][producto]" name="outputs[${i}][producto]" value="${outputs[i].producto}">
                `;  
                for(j=0;j<productKeys.length;j++){
                    key = productKeys[j];
                    selected = outputs[i].producto == key ? 'selected' : '';
                    htmlstr += `
                        <option ${selected} value="${key}">${products[key].name}</option>
                    `;
                }
                htmlstr += `
                            </select>
                        </td>
                        <td class="form-group">
                            <select class="form-control output-presentation" id="outputs[${i}][presentacion][kg]" name="outputs[${i}][presentacion][kg]" value="${outputs[i].presentacion.kg}">
                `;
                presentations = JSON.parse(products[outputs[i].producto].metadata).presentacion;
                cost = 0;
                sale_price = 0;
                for(p=0;p<presentations.length;p++){
                    selected = outputs[i].presentacion.kg == presentations[p].kg ? 'selected' : '';
                    cost =  outputs[i].presentacion.kg == presentations[p].kg ? presentations[p].costo : 0;
                    sale_price =  outputs[i].presentacion.kg == presentations[p].kg ? presentations[p].precio_venta : 0;
                    htmlstr += `
                    <option ${selected} value="${presentations[p].kg}">${presentations[p].kg}</option>
                    `;
                }
                temp = parseFloat(outputs[i].cantidad) * cost;
                temp = isNaN(temp) ? 0: temp;
                total += temp;
                htmlstr += `
                            </select>
                            <input type="hidden" id="outputs[${i}][presentacion][costo]" name="outputs[${i}][presentacion][costo]" value="${cost}" min="0" required>
                            <input type="hidden" id="outputs[${i}][presentacion][precio_venta]" name="outputs[${i}][presentacion][precio_venta]" value="${sale_price}" min="0" required>
                        </td>
                        <td class="form-group">
                            <input type="number" class="form-control output-ammount" id="outputs[${i}][cantidad]" name="outputs[${i}][cantidad]" value="${outputs[i].cantidad}" min="0" required>
                        </td>
                        <td class="form-group">
                            $ ${new Number(temp).toLocaleString("es-CO")}
                        </td>
                        <td class="form-group">
                            <div class='btn-group'>
                                <button id='out_del_${i}' type="button" class="btn btn-danger btn_out_del" ><i class="fa fa-trash fa-xs"></i></button>
                                <button id='out_add_${i}' type="button" class="btn btn-success btn_out_add" ><i class="fa fa-ad fa-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            $("#total").val(total);
            $("#outputs_container").html(htmlstr);
            $(".btn_out_del").click(function(){
                delOutput(this.id);
            });
            $(".btn_out_add").click(function(){
                addOutput(this.id);
            });
            $('.output-ammount').change(function(){
                outputs = parseOutputs();
                renderOutputs(outputs,products);
            });
            $('.output-id').change(function(){
                outputs = parseOutputs();
                renderOutputs(outputs,products);
            });
            $('.output-presentation').change(function(){
                outputs = parseOutputs();
                renderOutputs(outputs,products);
            });
        }
    </script>
@endpush