

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_general">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3 col-xs-6 col-md-6 col-sm-6">
                        <label for="">Caja</label>
                        <select class="form-control" id="id_caja_numero" name="id_caja_numero">
                            <?php
                            (isset($caja_))?$cajita=$caja_->id_caja_numero:$cajita=0;
                            foreach($caja as $l){
                                ($l->id_caja_numero == $cajita)?$sele='selected':$sele='';
                                ?>
                                <option value="<?php echo $l->id_caja_numero;?>" <?= $sele; ?>><?php echo $l->caja_numero_nombre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_i;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_f;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>
            <div class="row">
                <?php
                foreach ($cajas_totales as $ct){
                    $datitos = $this->reporte->datitos_caja($ct->id_caja);
                    ?>
                    <div class="col-lg-6">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table">
                                        <p>Apertura : <?= $datitos->caja_fecha_apertura;?> // Cierre : <?= $datitos->caja_fecha_cierre?> // Monto Cierre : <?= $datitos->caja_cierre;?></p>
                                        <?php
                                        if($datos){
                                            $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                            if($datitos->caja_fecha_cierre==NULL){
                                                $fecha_fin_caja = date('Y-m-d H:i:s');
                                            }else{
                                                $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                            }

                                            $caja = $this->reporte->sumar_caja($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $reporte_ingresos_movi = $this->reporte->listar_datos_ingresos_caja($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            //FUNCIONES PARA LOS INGRESOS DE SALON
                                            $reporte_ingresos = $this->reporte->listar_datos_ingresos($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $reporte_ingresos_tarjeta = $this->reporte->listar_datos_ingresos_tarjeta($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $reporte_ingresos_transferencia = $this->reporte->listar_datos_ingresos_transferencia($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            //FUNCIONES PARA LOS INGRESOS DEL DELIVERY
                                            $reporte_ingresos_delivery = $this->reporte->listar_datos_ingresos_delivery($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $reporte_ingresos_tarjeta_delivery = $this->reporte->listar_datos_ingresos_tarjeta_delivery($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            $reporte_ingresos_transferencia_delivery = $this->reporte->listar_datos_ingresos_transferencia_delivery($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);
                                            //FUNCIONES DE MOVIMIENTOS DE CAJA
                                            $reporte_egresos_movi = $this->reporte->listar_datos_egresos($ct->id_caja, $fecha_ini_caja, $fecha_fin_caja);

                                            //DESGLOSE DE FUNCIONES
                                            $caja = $caja->total;
                                            $reporte_ingresos_movi = $reporte_ingresos_movi->total;
                                            //RESULTADO DE INGRESOS POR LOCAL
                                            $ingresos = $reporte_ingresos->total;
                                            $reporte_ingresos_tarjeta = $reporte_ingresos_tarjeta->total;
                                            $reporte_ingresos_transferencia = $reporte_ingresos_transferencia->total;
                                            //RESULTADO DE LAS FUNCIONES PARA DELIVERYS
                                            $reporte_ingresos_delivery = $reporte_ingresos_delivery->total;
                                            $reporte_ingresos_tarjeta_delivery = $reporte_ingresos_tarjeta_delivery->total;
                                            $reporte_ingresos_transferencia_delivery = $reporte_ingresos_transferencia_delivery->total;
                                            //salida de caja
                                            $reporte_egresos_movi = $reporte_egresos_movi->total;

                                            $ingresos_total_de_ventas =  $ingresos + $reporte_ingresos_tarjeta + $reporte_ingresos_transferencia + $reporte_ingresos_delivery +
                                                $reporte_ingresos_tarjeta_delivery + $reporte_ingresos_transferencia_delivery;

                                            $ingresos_generales = $caja + $reporte_ingresos_movi + $ingresos + $reporte_ingresos_tarjeta + $reporte_ingresos_transferencia +
                                                $reporte_ingresos_delivery + $reporte_ingresos_tarjeta_delivery + $reporte_ingresos_transferencia_delivery - $reporte_egresos_movi;

                                            $ingresos_totales_salon = $ingresos + $reporte_ingresos_tarjeta + $reporte_ingresos_transferencia;

                                            $ingresos_totales_delivery = $reporte_ingresos_delivery + $reporte_ingresos_tarjeta_delivery
                                                + $reporte_ingresos_transferencia_delivery;

                                            $egresos_totales = $reporte_egresos_movi;

                                            $diferencia = $caja + $reporte_ingresos_movi + $ingresos + $reporte_ingresos_delivery - $reporte_egresos_movi;
                                        }

                                        ?>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL DE VENTAS DEL DIA:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right"> S/.<?= $ingresos_total_de_ventas ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- INGRESOS - EGRESOS:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right"> S/.<?= $ingresos_generales ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Apertura de Caja</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right"> S/.<?= $caja ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Ingresos caja chica</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_ingresos_movi ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL VENTAS EN SALON:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ingresos_totales_salon ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Efectivo:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ingresos ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Tarjeta:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_ingresos_tarjeta ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_ingresos_transferencia ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL VENTAS DELIVERY:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $ingresos_totales_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Efectivo:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_ingresos_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Tarjeta:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_ingresos_tarjeta_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Pagos Transferencia:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_ingresos_transferencia_delivery ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL EGRESOS :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $egresos_totales ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row" style="display: none">
                                            <div class="col-md-8">
                                                <label>- Orden de Compras:</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $orden_pedido_total ?? 0?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- Salida caja chica :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $reporte_egresos_movi ?? 0?></label>
                                            </div>
                                        </div>
                                        <p style="border-bottom: 1px solid red"></p>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label>- TOTAL EFECTIVO :</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="text-align: right;"> S/.<?= $diferencia ?? 0?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h4 style="text-align: center;">DATOS EGRESOS</h4>
                            <?php
                            $egresos = 0;
                            ?>
                            <table class="table table-bordered table-hover" style="border-color: black">
                                <thead>
                                <tr style="background-color: #ebebeb">
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                    <th>Importe</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($datos){
                                    $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                    if($datitos->caja_fecha_cierre==NULL){
                                        $fecha_fin_caja = date('Y-m-d H:i:s');
                                    }else{
                                        $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                    }
                                    $listar_egresos = $this->reporte->listar_egresos_descripcion($fecha_ini_caja,$fecha_fin_caja);
                                    foreach ($listar_egresos as $le) {
                                        ?>
                                        <tr>
                                            <td><?php echo date('d-m-Y H:i:s',strtotime($le->egreso_fecha_registro));?></td>
                                            <td><?php echo $le->egreso_descripcion;?></td>
                                            <td>S/. <?php echo $le->egreso_monto;?></td>
                                        </tr>
                                        <?php
                                        $egresos = $egresos + $le->egreso_monto;
                                    }
                                    ?>
                                    <tr><td colspan="2" style="text-align: right">Total Egresos:</td><td style="background-color: #f9f17f"><b> S/. <?php echo $egresos ?? 0;?></b></td></tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </div>

                    <div class="col-lg-6">
                        <!--<div class="container">
                            <h4>Fechas -> Desde : <?= $fecha_i?> || Hasta : <?= $fecha_f?></h4>
                        </div>-->
                        <div class="card shadow mb-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" style="border-color: black">
                                    <thead>
                                    <tr style="background-color: #ebebeb">
                                        <th>PRODUCTO</th>
                                        <th>CANT.</th>
                                        <th>P.U</th>
                                        <th>TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $venta_total=0;
                                    if($datos){
                                        $fecha_ini_caja = $datitos->caja_fecha_apertura;
                                        if($datitos->caja_fecha_cierre==NULL){
                                            $fecha_fin_caja = date('Y-m-d H:i:s');
                                        }else{
                                            $fecha_fin_caja = $datitos->caja_fecha_cierre;
                                        }
                                        $productos = $this->reporte->reporte_productos_($fecha_ini_caja,$fecha_fin_caja);
                                        foreach ($productos as $p){
                                            $venta_total = $venta_total + $p->total_suma;
                                            ?>
                                            <tr>
                                                <td><?= $p->producto_nombre?></td>
                                                <td><?= $p->total?></td>
                                                <td><?= $p->venta_detalle_precio_unitario;?></td>
                                                <td><?= $p->total_suma?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <tr><td colspan="3" style="text-align: right">TOTAL :</td><td style="background-color: #f9f17f"><b> S/. <?php echo number_format($venta_total,2) ?? 0;?></b></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <br>
            </div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <a id="imprimir_ticket" style="color: white;" class="btn btn-primary mr-5" target="_blank" onclick="ticket_venta('<?= $fecha_i; ?>','<?= $fecha_f?>','<?= $id_caja_numero?>')"><i class="fa fa-print"></i> TICKET</a>
                    <a style="color: white;" class="btn btn-success" target="_blank" href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=excel_reporte_productos&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>"><i class="fa fa-file-excel-o"></i> EXPORTAR</a>
                    <!--<a href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=reporte_general_pdf&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>-->
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>

<script>
    function ticket_venta(fecha_i,fecha_f,id_caja_numero){
        var boton = 'imprimir_ticket';

        $.ajax({
            type: 'POST',
            url: urlweb + "api/Reporte/ticket_reporte",
            data: "fecha_i=" + fecha_i + "&fecha_f=" + fecha_f + "&id_caja_numero=" + id_caja_numero,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Imprimir", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }

    function ticket_productos(fecha_i,fecha_f,id_usuario){
        var boton = 'imprimir_ticket_productos';

        $.ajax({
            type: 'POST',
            url: urlweb + "api/Reporte/ticket_productos",
            data: "fecha_i=" + fecha_i + "&fecha_f=" + fecha_f + "&id_usuario=" + id_usuario,
            dataType: 'json',
            beforeSend: function () {
                cambiar_estado_boton(boton, 'imprimiendo...', true);
            },
            success:function (r) {
                cambiar_estado_boton(boton, "<i class=\"fa fa-print\"></i> Imprimir", false);
                switch (r.result.code) {
                    case 1:
                        respuesta('¡Éxito!...', 'success');
                        setTimeout(function () {
                            location.reload();
                        }, 400);
                        break;
                    default:
                        respuesta('¡Algo catastrofico ha ocurrido!', 'error');
                        break;
                }
            }
        });
    }
</script>