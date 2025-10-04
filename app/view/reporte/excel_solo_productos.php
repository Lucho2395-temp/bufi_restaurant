

<div class="row">

    <div class="col-lg-12">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow mb-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" style="border-color: black">
                                            <thead>
                                            <tr style="background-color: #ebebeb">
                                                <th style="text-align: center">PRODUCTO</th>
                                                <th style="text-align: center">PRECIO UNITARIO</th>
                                                <th style="text-align: center">CANTIDAD VENDIDA</th>
                                                <th style="text-align: center">PRECIO TOTAL</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $ingresos_productos = 0;
                                            $sumasa = 0;
                                            $nuevo_valor_inicial = 0;
                                            $venta_total = 0;
                                            foreach ($productos as $p){
                                                $venta_total = $venta_total + $p->total_suma;
                                                ?>
                                                <tr>
                                                    <td style="text-align: center"><?= utf8_decode($p->venta_detalle_nombre_producto)?></td>
                                                    <td style="text-align: center"><?= $p->venta_detalle_precio_unitario;?></td>
                                                    <td style="text-align: center"><?= $p->total?></td>
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
                        <br>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>











