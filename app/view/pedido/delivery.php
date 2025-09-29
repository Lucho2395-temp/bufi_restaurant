


<div class="modal fade" id="agregar_cliente_nuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente Nuevo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="cliente">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Tipo de documento</label>
                                    <select class="form-control" id="id_tipodocumento" name="id_tipodocumento" onchange="tipo_documento()">
                                        <option value="">Seleccione</option>
                                        <?php
                                        foreach ($tipos_documento as $td){
                                            echo "<option value='".$td->id_tipodocumento."'>".$td->tipodocumento_identidad."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Nro Documento:</label>
                                    <input class="form-control" type="text" id="cliente_numero" onchange="consultar_documento(this.value)" onkeyup="return validar_numeros(this.id)" name="cliente_numero" maxlength="15" placeholder="Ingrese Telefono...">
                                </div>
                            </div>
                            <div class="col-lg-12" id="div_nombre">
                                <div class="form-group">
                                    <label class="col-form-label">Nombre Completo:</label>
                                    <input class="form-control" type="text" id="cliente_nombre" name="cliente_nombre" maxlength="500" placeholder="Ingrese Nombre...">
                                </div>
                            </div>
                            <!--<div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Apellido Paterno:</label>
                                    <input class="form-control" type="text" id="cliente_apellido_paterno" name="cliente_apellido_paterno" maxlength="200" placeholder="Ingrese Apellido...">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Apellido Materno:</label>
                                    <input class="form-control" type="text" id="cliente_apellido_materno" name="cliente_apellido_materno" maxlength="200" placeholder="Ingrese Apellido...">
                                </div>
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="col-lg-12" id="div_razon_social">
                                <div class="form-group">
                                    <label class="col-form-label">Razón Social:</label>
                                    <textarea rows="2" class="form-control" type="text" id="cliente_razonsocial" name="cliente_razonsocial" maxlength="500" placeholder="Ingrese Razón Social..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="div_direcciones">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Dirección:</label>
                                    <textarea rows="2" class="form-control" type="text" id="cliente_direccion" name="cliente_direccion" maxlength="500" placeholder="Ingrese Dirección..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="div_telefono_correo">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Teléfono:</label>
                                    <input class="form-control" type="text" id="cliente_telefono" onkeyup="return validar_numeros(this.id)" name="cliente_telefono" maxlength="30" placeholder="Ingrese Telefono...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="limpiar()" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                <button type="submit" class="btn btn-success" onclick="agregar_cliente_nuevo()" "><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="asignar_pedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div id="persona">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Producto</label>
                                    <input type="text" readonly class="form-control" id="producto_nombre" name="producto_nombre">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Precio</label>
                                    <input type="text" class="form-control" id="comanda_detalle_precio" name="comanda_detalle_precio">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Cantidad</label>
                                    <input type="number" value="1" class="form-control" id="comanda_detalle_cantidad" name="comanda_detalle_cantidad">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Tipo Entrega</label>
                                    <select class="form-control" id="comanda_detalle_despacho" name="comanda_detalle_despacho">
                                        <option value="delivery">Delivery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Observacion</label>
                                    <textarea rows="3" class="form-control" type="text" id="comanda_detalle_observacion" name="comanda_detalle_observacion" maxlength="200" placeholder="Ingrese Alguna Observacion...">-</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="agregar()" class="btn btn-success" id="btn-agregar"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" >
                                <div class="row">
                                    <div class="form-group col-lg-8">
                                        <input required autocomplete="off" name="parametro" onkeyup="productos()" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar Productos">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <button type="submit" class="btn btn-success" style="width: 80%"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="producto" class="table-responsive">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                <?php
                                foreach ($familia as $f){
                                    $productos_familia = $this->pedido->listar_productos_x_familia($f->id_producto_familia);
                                    ?>
                                    <h3 data-toggle="collapse" href="#tipo_<?= $f->id_producto_familia;?>"><?= $f->producto_familia_nombre?><i class="fa fa-arrow-down" style="float: right"></i></h3><br>

                                    <div id="tipo_<?= $f->id_producto_familia;?>" class="collapse">
                                        <table class='table table-bordered' width='100%'>
                                            <thead class='text-capitalize'>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($productos_familia as $pf){
                                                $anho = date('Y');
                                                if($anho == "2021"){
                                                    $icbper = 0.30;
                                                }elseif($anho == "2022"){
                                                    $icbper = 0.40;
                                                }else{
                                                    $icbper = 0.50;
                                                }
                                                $op_gravadas=0.00;
                                                $op_exoneradas=0.00;
                                                $op_inafectas=0.00;
                                                $op_gratuitas=0.00;
                                                $igv=0.0;
                                                $igv_porcentaje=0.18;
                                                if($pf->producto_precio_codigoafectacion == 10){
                                                    $op_gravadas = $pf->producto_precio_venta;
                                                    $igv = $op_gravadas * $igv_porcentaje;
                                                    $total = $op_gravadas + $igv;
                                                }else{
                                                    $total = $pf->producto_precio_venta;
                                                }
                                                if($pf->id_receta == "0"){
                                                    $total = $total + $icbper;
                                                }
                                                ?>
                                                <tr>
                                                    <td><?=$pf->producto_nombre?></td>
                                                    <td><?=$total ?></td>
                                                    <td><button class='btn btn-success' data-toggle='modal' onclick="guardar_pedido(<?=$pf->id_producto?>,'<?=$pf->producto_nombre?>','<?=$total?>')" data-target='#asignar_pedido'><i class='fa fa-check'></i></button><td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                                <input type="hidden" id="contenido" name="contenido">
                                <input type="hidden" class="form-control" id="id_producto" name="id_producto">
                                <input type="hidden" class="form-control" id="comanda_total" name="comanda_total">

                                <div class="form-group col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr style="font-weight: bold;text-align: center">
                                            <td>PRODUCTO</td>
                                            <td>PU</td>
                                            <td>CANT</td>
                                            <td>ENTR</td>
                                            <td>OBS</td>
                                            <td>TOTAL</td>
                                            <td>ACCIÓN</td>
                                        </tr>
                                        </thead>
                                        <tbody id="contenido_detalle_compra">
                                        </tbody>
                                        <!--<tr>
                                            <td id="conteo"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>-->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td><span id="comanda_total_">S/ 0.00</span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-9">
                                        <input required autocomplete="off" name="parametro_delivery" onkeyup="buscar_cliente_delivery()" type="text" class="form-control" id="parametro_delivery" placeholder="Buscar Cliente">
                                    </div>
                                    <div class="form-group col-lg-3">
                                        <button data-toggle="modal" data-target="#agregar_cliente_nuevo" class="btn btn-success" style="width: 99%"> Cliente Nuevo</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="cliente_delivery" class="table-responsive">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Cliente</label><br>
                                            <!--<label for="" id="cliente_nombre"></label>-->
                                            <input class="form-control" id="cliente_nombre_d" name="cliente_nombre_d" value="ANONIMO">
                                            <input type="hidden" id="id_cliente" name="id_cliente" value="3">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">DNI / RUC </label><br>
                                            <input class="form-control" id="cliente_numero_d" name="cliente_numero_d" value="11111111">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Dirección</label><br>
                                            <textarea rows="3" class="form-control" id="cliente_direccion_d" name="cliente_direccion_d"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Telefono</label><br>
                                            <input class="form-control" id="cliente_telefono_d" name="cliente_telefono_d">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-2" style="margin-top: 12px">
                                        <button onclick="guardar_comanda_delivery()" class="btn btn-primary"><i class="fa fa-check"></i> Generar</button>
                                    </div>
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-2" style="margin-top: 12px">
                                        <a class="btn btn-secondary" href="javascript:history.back()" role="button"><i class="fa fa-backward"></i> Regresar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>pedido.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>cliente.js"></script>


<script>

    $(document).ready(function (){
        $('#div_razon_social').hide();
        $('#div_nombre').hide();
        $("#div_direcciones").hide();
        $("#div_telefono_correo").hide();
    });

    var contenido = "";
    var conteo = 1;
    var total_total = 0;

    function productos(){
        var param = $("#parametro").val();
        $("#producto").html("");
        $.ajax({
            type: "POST",
            url: urlweb + "api/Pedido/ver_productos/" + param,
            data:"&parametro=" + param,
            dataType: 'json',
            success:function (r) {
                $("#producto").html(r);
            }
        });
    }

    function show_table() {
        var llenar="";
        conteo=1;
        var monto_total = 0;
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    var celdas =filas[i].split('-.-.');
                    llenar += "<tr>"+
                        "<td>"+celdas[1]+"</td>"+
                        "<td>"+celdas[2]+"</td>"+
                        "<td>"+celdas[3]+"</td>"+
                        "<td>"+celdas[4]+"</td>"+
                        "<td>"+celdas[5]+"</td>"+
                        "<td>"+celdas[6]+"</td>"+
                        "<td><a data-toggle=\"tooltip\" onclick='delete_detalle("+i+")' title=\"Eliminar\" type=\"button\" class=\"text-danger\" ><i class=\"fa fa-times ver_detalle\"></i></a></td>"+
                        "</tr>";
                    conteo++;
                    var monto_total = monto_total + celdas[6] * 1;
                    var total = monto_total.toFixed(2);
                }
            }
        }
        $("#contenido_detalle_compra").html(llenar);
        $("#conteo").html(conteo);
        $("#comanda_total").val(total);
        $("#comanda_total_").html("S/ " + total);
        $("#contenido").val(contenido);
    }

    function clean() {
        $('#asignar_pedido').modal('toggle');
        $("#comanda_detalle_cantidad").val("1");
        $("#comanda_detalle_precio").val("");
        $("#comanda_detalle_observacion").val("-");
        $("#producto_nombre").val("");

        $("#comanda_detalle_despacho option[value='']").attr('selected','selected');
        $("#comanda_detalle_despacho").val();
        $("#comanda_detalle_despacho").select().trigger('change');
        $("#parametro").val("");
        $("#producto").html("");
    }


    function delete_detalle(ind) {
        var contenido_artificio ="";
        if (contenido.length>0){
            var filas=contenido.split('/./.');
            if(filas.length>0){
                for(var i=0;i<filas.length - 1;i++){
                    if(i!=ind){
                        var celdas =filas[i].split('-.-.');
                        contenido_artificio += celdas[0] + "-.-."+celdas[1] + "-.-." + celdas[2] + "-.-." + celdas[3] + "-.-." +celdas[4] + "-.-."+ celdas[5] + "-.-."+ celdas[6] + "/./.";
                    }else{
                        var celdas =filas[i].split('-.-.');
                    }
                }
            }
        }
        contenido = contenido_artificio;
        show_table();
    }


    function agregar(){
        var comanda_detalle_despacho_val = $("#comanda_detalle_despacho").val();
        if(comanda_detalle_despacho_val!=""){
            var comanda_detalle_despacho = $("select[name='comanda_detalle_despacho'] option:selected").text();
        }else{
            var comanda_detalle_despacho = "";
        }

        var comanda_detalle_observacion = $("#comanda_detalle_observacion").val();
        var producto_nombre = $("#producto_nombre").val();
        var id_producto = $("#id_producto").val();
        var comanda_detalle_cantidad = $("#comanda_detalle_cantidad").val() * 1;
        var comanda_detalle_precio = $("#comanda_detalle_precio").val() * 1;


        var subtotal = comanda_detalle_cantidad * comanda_detalle_precio;
        subtotal.toFixed(2);
        subtotal = subtotal.toFixed(2);

        /*total_total = total_total + subtotal;
        total_total.toFixed(2);
        total_total = parseFloat(total_total);*/

        if(id_producto !="" && comanda_detalle_cantidad!="" && comanda_detalle_precio!="" && producto_nombre!="" && comanda_detalle_observacion !="" && subtotal!="" && comanda_detalle_despacho !="" ){
            contenido += id_producto + "-.-." + producto_nombre + "-.-."+ comanda_detalle_precio+"-.-." + comanda_detalle_cantidad +"-.-."+comanda_detalle_despacho+"-.-." + comanda_detalle_observacion+"-.-."+subtotal+"/./.";
            $("#contenido").val(contenido);
            //$("#comanda_total_pedido").val(subtotal);
            respuesta('¡Producto Agregado!','success');
            show_table();
            clean();
        }else{
            respuesta('Ingrese todos los campos');
        }
    }


    function guardar_comanda_delivery(){

        var valor = true;
        var contenido = $('#contenido').val();
        var id_cliente = $('#id_cliente').val();
        var comanda_total = $('#comanda_total').val();
        var cliente_nombre_d = $('#cliente_nombre_d').val();
        var comanda_direccion_delivery = $('#cliente_direccion_d').val();
        var comanda_telefono_delivery = $('#cliente_telefono_d').val();

        valor = validar_campo_vacio('contenido', contenido, valor);
        //valor = validar_campo_vacio('id_mesa', id_mesa, valor);
        if (valor){
            var cadena = "contenido=" + contenido +
                "&comanda_total=" + comanda_total +
                "&id_cliente=" + id_cliente +
                "&cliente_nombre_d=" + cliente_nombre_d +
                "&comanda_direccion_delivery=" + comanda_direccion_delivery +
                "&comanda_telefono_delivery=" + comanda_telefono_delivery;

            $.ajax({
                type:"POST",
                url: urlweb + "api/Pedido/guardar_delivery",
                data: cadena,
                dataType: 'json',
                success:function (r) {
                    switch (r.result.code) {
                        case 1:
                            respuesta('¡Guardado con Exito!','success');
                            setTimeout(function () {
                                location.href = urlweb +  'Pedido/historial_delivery';
                            }, 1000);
                            break;
                        case 2:
                            respuesta("Fallo el guardado, intentelo de nuevo", 'error');
                            break;
                        case 6:
                            respuesta("Algún dato fue ingresado de manera erronéa. Recargue la página por favor.",'error');
                            break;
                        default:
                            respuesta("ERROR DESCONOCIDO", 'error');
                    }
                }
            });
        }
    }
    //INICIO - AGREGAR CLIENTE
    function tipo_documento(){
        var tipo_doc = $('#id_tipodocumento').val();
        if(tipo_doc != ""){
            if(tipo_doc != "4"){
                $('#div_razon_social').hide();
                $('#div_nombre').show();
                $('#cliente_razonsocial').val('');

            }else{
                $('#div_razon_social').show();
                $('#div_nombre').hide();
                $('#cliente_nombre').val('');
            }
            $("#div_direcciones").show();
            $("#div_telefono_correo").show();
        }else{
            $('#div_razon_social').hide();
            $('#div_nombre').hide();
            $("#div_direcciones").hide();
            $("#div_telefono_correo").hide();
        }
    }

    function consultar_documento(valor){
        var tipo_doc = $('#id_tipodocumento').val();

        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }

        }
    }
    function consultar_documento_e(valor){
        var tipo_doc = $('#id_tipodocumento_e').val();
        if(tipo_doc == "2"){
            if(valor.length==8){
                ObtenerDatosDni_e(valor);
            }else{
                alert('El numero debe tener 8 digitos');
            }
        }else if(tipo_doc == "4"){
            if (valor.length==11){
                ObtenerDatosRuc_e(valor);
            }else{
                alert('El numero debe tener 11 digitos');
            }
        }
    }

    function ObtenerDatosDni(valor){
        var numero_dni =  valor;
        var cliente_nombre = 'cliente_nombre';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_nombre, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_nombre, "", false);
                $("#cliente_nombre").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }
    function ObtenerDatosRuc(valor){
        var numero_ruc =  valor;
        var cliente_razonsocial = 'cliente_razonsocial';

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(cliente_razonsocial, 'buscando...', true);
            },
            success:function (r) {
                cambiar_estado_boton(cliente_razonsocial, "", false);
                $("#cliente_razonsocial").val(r.result.razon_social);
            }
        });
    }
    function ObtenerDatosDni_e(valor){
        var numero_dni =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_dni",
            data: "numero_dni="+numero_dni,
            dataType: 'json',
            success:function (r) {
                $("#cliente_nombre_e").val(r.result.name+ ' ' + r.result.first_name+ ' ' + r.result.last_name);
            }
        });
    }
    function ObtenerDatosRuc_e(valor){
        var numero_ruc =  valor;

        $.ajax({
            type: "POST",
            url: urlweb + "api/Cliente/obtener_datos_x_ruc",
            data: "numero_ruc="+numero_ruc,
            dataType: 'json',
            success:function (r) {
                $("#cliente_razonsocial_e").val(r.result.razon_social);
            }
        });
    }
    //FIN - AGREGAR CLIENTE


</script>