

<div class="row">

    <div class="col-lg-12">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">

                    <div class="row">
                        <?php
                        foreach ($cajas_totales as $ct){
                            $datitos = $this->reporte->datitos_caja($ct->id_caja);
                            ?>
                            <div class="card-header py-3">
                                <h3 class="m-0 font-weight-bold text-primary">Apertura : <?= $datitos->caja_fecha_apertura?></h3>
                                <h3 class="m-0 font-weight-bold text-primary">Fecha de Cierre : <?=$datitos->caja_fecha_cierre?></h3>
                                <h3 class="m-0 font-weight-bold text-primary">Monto de Cierre : <?= $datitos->caja_cierre?></h3>
                            </div>
                            <div class="col-lg-10">
                                <div class="card shadow mb-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="border-color: black">
                                                <?php
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

                                                ?>
                                                <thead>
                                                <tr style="background-color: #ebebeb">
                                                    <th>TOTAL VENTAS DEL DIA</th>
                                                    <th>INGRESOS - EGRESOS</th>
                                                    <th>APERTURA DE CAJA</th>
                                                    <th>INGRESOS DE CAJA CHICA</th>
                                                    <th>TOAL DE VENTAS DE SALON</th>
                                                    <th>PAGOS EFECTIVO</th>
                                                    <th>PAGOS TARJETA</th>
                                                    <th>PAGOS TRANSFERENCIA</th>
                                                    <th>SALIDA DE CAJA CHICA</th>
                                                    <th>TOTAL EN EFECTIVO</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td style="text-align: center"><?= $ingresos_total_de_ventas ?? 0?></td>
                                                    <td style="text-align: center"><?= $ingresos_generales ?? 0?></td>
                                                    <td style="text-align: center"><?= $caja ?? 0?></td>
                                                    <td style="text-align: center"><?= $reporte_ingresos_movi ?? 0?></td>
                                                    <td style="text-align: center"><?= $ingresos_totales_salon ?? 0?></td>
                                                    <td style="text-align: center"><?= $ingresos ?? 0?></td>
                                                    <td style="text-align: center"><?= $reporte_ingresos_tarjeta ?? 0?></td>
                                                    <td style="text-align: center"><?= $reporte_ingresos_transferencia ?? 0?></td>
                                                    <td style="text-align: center"><?= $reporte_egresos_movi ?? 0?></td>
                                                    <td style="text-align: center"><?= $diferencia ?? 0?></td>
                                                </tr>
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-6">
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
                                                    <td style="text-align: center"><?= utf8_decode($p->producto_nombre)?></td>
                                                    <td style="text-align: center"><?= $p->total?></td>
                                                    <td style="text-align: center">S/. <?= $p->venta_detalle_precio_unitario;?></td>
                                                    <td style="text-align: center">S/. <?= $p->total_suma?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr><td colspan="3" style="text-align: right">TOTAL :</td><td style="background-color: #f9f17f; text-align: center" ><b> S/. <?php echo number_format($venta_total,2) ?? 0;?></b></td></tr>
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
                </div>
            </div>
        </div>

    </div>
</div>











