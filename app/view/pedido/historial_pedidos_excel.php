<?php
/**
 * Created by PhpStorm.
 * User: Luis
 * Date: 03/10/2025
 * Time: 9:48
 */
?>


<div class="row">

    <div class="col-lg-12">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Solicitado por: <?/*= utf8_decode($usuario. ' - El día: '.date('d-m-Y')) */?></h6>
                <h6 class="m-0 font-weight-bold text-primary">Historial de Ventas Enviadas a SUNAT</h6>
                <h6 class="m-0 font-weight-bold text-primary">Tipo de Venta : <?/*= utf8_decode($tipo_comprobante); */?></h6>
                <h6 class="m-0 font-weight-bold text-primary"><strong><?/*= $fecha_vacio; */?></strong></h6>
            </div>-->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="" width="100%" cellspacing="0" border="1">
                        <!--filtro para buscar alumno por nombre, apellido y dni-->

                        <h2 style="">HISTORIAL DE PEDIDOS</h2>

                        <thead class="text-capitalize">
                        <br><br>
                        <tr style="background: deepskyblue;">
                            <th>#</th>
                            <th>Fecha de Pedido</th>
                            <th>Mesa</th>
                            <th>Numero de Pedido</th>
                            <th>Total</th>
                            <th>Atendido por</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $a = 1;
                        $total = 0;
                        $total_soles = 0;
                        foreach ($pedidos as $al){
                            $stylee="style= 'text-align: center;'";

                            ?>
                            <tr <?= $stylee?>>
                                <td><?= $a;?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($al->comanda_fecha_registro));?></td>
                                <td><?= $al->mesa_nombre;?></td>
                                <td><?= $al->comanda_correlativo;?></td>
                                <td><?= $al->comanda_total;?></td>
                                <td>
                                    <?= utf8_decode($al->persona_nombre.' '.$al->persona_apellido_paterno);?>
                                </td>
                            </tr>
                            <?php
                            $a++;
                            $total = $total + $al->comanda_total;
                        }
                        ?>
                        </tbody>
                        <tfooter>
                            <tr>
                                <td></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">TOTAL:</td>
                                <td style="text-align: center;"><?= number_format($total,2);?></td>
                            </tr>
                        </tfooter>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
