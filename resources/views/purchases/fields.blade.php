<!-- User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user', 'Usuario:') !!}
    {!! Form::select('user',[null => 'Seleccionar'] + $users, null, ['class' => 'form-control']) !!}
</div>

<!-- Supplier Field -->
<div class="form-group col-sm-6">
    {!! Form::label('supplier', 'Proveedor:') !!}
    {!! Form::select('supplier',[null => 'Seleccionar'] + $suppliers, null, ['class' => 'form-control']) !!}
</div>

<!-- Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::number('total', null, ['class' => 'form-control', 'min' => 0]) !!}
</div>

<!-- Cash Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cash', 'Contado:') !!}
    {!! Form::number('cash', null, ['class' => 'form-control', 'min' => 0]) !!}
</div>

<!-- Credit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit', 'Crédito:') !!}
    {!! Form::number('credit', null, ['class' => 'form-control', 'min' => 0]) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Estado:') !!}
    {!! Form::select('status', ['Pendiente' => 'Pendiente', 'En transporte' => 'En transporte', 'Recibido' => 'Recibido'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Payment Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('payment_status', 'Estado de Pago:') !!}
    {!! Form::select('payment_status', ['Pendiente' => 'Pendiente', 'Parcial' => 'Parcial', 'Pagado' => 'Pagado'], null, ['class' => 'form-control custom-select']) !!}
</div>

<div class="col-sm-6"></div>

<!-- Products Field -->

<div class="form-group col-sm-12 text-center table-responsive">
{!! Form::label('products', 'Productos:') !!}
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
    <tbody id="products_container">

    <!-- 
        * To avoid notation mixing, the products in the purchase will be called items, 
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
        var items = {!! isset($purchase->products) ? $purchase->products : '[]' !!};            
        var id_primero = 0;
        $(document).ready(function(){
            items = items.length == 0 ? [{'producto':1,'presentacion':{'kg':''},'cantidad':0}] : items;
            console.log(items);
            
            render(items,products);
        });
        
        function add(idstr){
            items = parseItems();
            id=parseInt(idstr.substring(4));
            items.splice(id+1, 0, {'producto':1,'presentacion':{'kg':''},'cantidad':0});
            console.log(items);
            render(items,products);      
        }
        function del(idstr){
            items = parseItems();
            id=parseInt(idstr.substring(4));
            items.splice(id, 1);
            items = items.length == 0 ? [{'producto':1,'presentacion':{'kg':''},'cantidad':0}] : items;
            render(items,products);            
        }
        function parseItems(){
            product_ids = $('.product-id');
            presentations = $('.presentation');
            ammounts = $('.ammount');
            items = []
            for(i=0;i<product_ids.length;i++){
                items.push({'producto':product_ids[i].value,'presentacion':{'kg':presentations[i].value},'cantidad':ammounts[i].value});
            }
            return items;
        }
        function render(items,products){
            htmlstr = '';
            total = 0;
            var productKeys = Object.keys(products);
            for(i=0;i<items.length;i++){
                htmlstr += `
                    <tr class="product col-sm-12" id="products[${i}]">
                        <td class="form-group">
                            <select class="form-control product-id" id="products[${i}][producto]" name="products[${i}][producto]" value="${items[i].producto}">
                `;  
                for(j=0;j<productKeys.length;j++){
                    key = productKeys[j];
                    selected = items[i].producto == key ? 'selected' : '';
                    htmlstr += `
                        <option ${selected} value="${key}">${products[key].name}</option>
                    `;
                }
                htmlstr += `
                            </select>
                        </td>
                        <td class="form-group">
                            <select class="form-control presentation" id="products[${i}][presentacion][kg]" name="products[${i}][presentacion][kg]" value="${items[i].presentacion.kg}">
                `;
                presentations = JSON.parse(products[items[i].producto].metadata).presentacion;
                cost = 0;
                sale_price = 0;
                for(p=0;p<presentations.length;p++){
                    selected = items[i].presentacion.kg == presentations[p].kg ? 'selected' : '';
                    cost =  items[i].presentacion.kg == presentations[p].kg ? presentations[p].costo : 0;
                    sale_price =  items[i].presentacion.kg == presentations[p].kg ? presentations[p].precio_venta : 0;
                    htmlstr += `
                    <option ${selected} value="${presentations[p].kg}">${presentations[p].kg}</option>
                    `;
                }
                temp = parseFloat(items[i].cantidad) * cost;
                temp = isNaN(temp) ? 0: temp;
                total += temp;
                htmlstr += `
                            </select>
                            <input type="hidden" id="products[${i}][presentacion][costo]" name="products[${i}][presentacion][costo]" value="${cost}" min="0" required>
                            <input type="hidden" id="products[${i}][presentacion][precio_venta]" name="products[${i}][presentacion][precio_venta]" value="${sale_price}" min="0" required>
                        </td>
                        <td class="form-group">
                            <input type="number" class="form-control ammount" id="products[${i}][cantidad]" name="products[${i}][cantidad]" value="${items[i].cantidad}" min="0" required>
                        </td>
                        <td class="form-group">
                            $ ${new Number(temp).toLocaleString("es-CO")}
                        </td>
                        <td class="form-group">
                            <div class='btn-group'>
                                <button id='del_${i}' type="button" class="btn btn-danger btn_del" ><i class="fa fa-trash fa-xs"></i></button>
                                <button id='add_${i}' type="button" class="btn btn-success btn_add" ><i class="fa fa-ad fa-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
            }
            $("#total").val(total);
            $("#products_container").html(htmlstr);
            $(".btn_del").click(function(){
                del(this.id);
            });
            $(".btn_add").click(function(){
                add(this.id);
            });
            $('.ammount').change(function(){
                items = parseItems();
                render(items,products);
            })
            $('.product-id').change(function(){
                items = parseItems();
                render(items,products);
            })
            $('.presentation').change(function(){
                items = parseItems();
                render(items,products);
            })
            $( "#total" ).trigger( "change" )
        }
        $("#total").change(function(){
            credit = parseInt($("#credit").val());
            total = parseInt(this.value);
            credit = isNaN(credit) ? 0: credit;
            total = isNaN(total) ? 0: total;
            credit = credit > total ? total : credit;
            $("#cash").val(total - credit);
            $("#credit").val(credit);
        })
        $("#cash").change(function(){
            cash = parseInt(this.value);
            total = parseInt($("#total").val());
            cash = isNaN(cash) ? 0: cash;
            total = isNaN(total) ? 0: total;
            cash = cash > total ? total : cash;
            $("#credit").val(total - cash);
            $("#cash").val(cash);
        })
        $("#credit").change(function(){
            credit = parseInt(this.value);
            total = parseInt($("#total").val());
            credit = isNaN(credit) ? 0: credit;
            total = isNaN(total) ? 0: total;
            credit = credit > total ? total : credit;
            $("#cash").val(total - credit);
            $("#credit").val(total - cash);
        })
    </script>
@endpush