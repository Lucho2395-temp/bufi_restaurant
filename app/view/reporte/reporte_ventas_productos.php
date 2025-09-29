


<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <form method="post" action="<?= _SERVER_ ?>Reporte/reporte_ventas_productos">
                <input type="hidden" id="enviar_fecha" name="enviar_fecha" value="1">
                <div class="row">
                    <div class="col-lg-3">
                        <label for="turno">Desde:</label>
                        <input type="date" class="form-control" id="fecha_filtro" name="fecha_filtro" step="1" value="<?php echo $fecha_filtro;?>">
                    </div>
                    <div class="col-lg-3">
                        <label for="turno">Hasta:</label>
                        <input type="date" class="form-control" id="fecha_filtro_fin" name="fecha_filtro_fin" value="<?php echo $fecha_filtro_fin;?>">
                    </div>
                    <div class="col-lg-3">
                        <button style="margin-top: 35px;" class="btn btn-success" ><i class="fa fa-search"></i> Buscar Registro</button>
                    </div>
                </div>
            </form>
            <br>

            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-9">
                    <div class="card shadow mb-4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="border-color: black">
                                <thead>
                                <tr style="background-color: #ebebeb">
                                    <!--<th style="text-align: center">FECHAS</th>-->
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
                                        <!--<td><?= $fecha_filtro?> / <?= $fecha_filtro_fin?></td>-->
                                        <td><?= $p->venta_detalle_nombre_producto?></td>
                                        <td>S/. <?= $p->venta_detalle_precio_unitario;?></td>
                                        <td><?= $p->total?></td>
                                        <td>S/. <?= $p->total_suma?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr><td colspan="3" style="text-align: right">TOTAL :</td><td style="background-color: #f9f17f"><b> S/. <?php echo number_format($venta_total,2) ?? 0;?></b></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1"></div>
            </div>

            <div class="row">
                <div class="col-lg-12" style="text-align: center">
                    <a href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=reporte_ventas_productos_pdf&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> PDF</a>
                    <a style="color: white;" class="btn btn-success" target="_blank" href="<?= _SERVER_ ; ?>index.php?c=Reporte&a=excel_solo_productos&fecha_filtro=<?= $_POST['fecha_filtro']?>&fecha_filtro_fin=<?= $_POST['fecha_filtro_fin']?>"><i class="fa fa-file-excel-o"></i> EXCEL</a>
                    <!--<a id="imprimir_ticket_productos" style="color: white;" class="btn btn-primary mr-5" target="_blank" onclick="ticket_productos_('<?= $fecha_filtro; ?>','<?= $fecha_filtro_fin?>')"><i class="fa fa-print"></i> Ticket</a>-->
                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script>
    function ticket_productos_(fecha_i,fecha_f){
        var boton = 'imprimir_ticket_productos';

        $.ajax({
            type: 'POST',
            url: urlweb + "api/Reporte/ticket_productos",
            data: "fecha_i=" + fecha_i + "&fecha_f=" + fecha_f,
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