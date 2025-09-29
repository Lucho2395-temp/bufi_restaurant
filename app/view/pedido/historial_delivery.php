
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <!--<div class="col-lg-12" style="text-align: center; padding-bottom:5px; "><h2><b>Pedido # <?= $dato_pedido->comanda_correlativo;?></b></h2></div> -->
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <input class="form-control" type="password" id="password"  placeholder="Ingrese su Contraseña AQUÍ para Permitir Cambios...">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha / Hora</th>
                                        <th>Nombre Persona</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Productos</th>
                                        <th>N° Pedido</th>
                                        <th>Total</th>
                                        <th>Detalle Pedido</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($pedidos as $p){
                                        $listar_detalle_comanda = $this->pedido->jalar_valor($p->id_comanda);
                                        if($p->comanda_nombre_delivery != ""){
                                            $nombre = $p->comanda_nombre_delivery;
                                        }else{
                                            $nombre = $p->cliente_nombre . $p->cliente_razonsocial;
                                        }

                                        ?>
                                        <tr id="comanda<?= $p->id_comanda;?>">
                                            <td><?= $a;?></td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($p->comanda_detalle_fecha_registro));?></td>
                                            <td><?= $nombre;?></td>
                                            <td><?= $p->comanda_direccion_delivery;?></td>
                                            <td><?= $p->comanda_telefono_delivery;?></td>
                                            <td>
                                            <?php
                                            $jalar_producto = $this->pedido->jalar_producto($p->id_comanda);

                                            //$cantidad_productos = $this->pedido->cantidad_x_productos($p->id_producto, $p->id_comanda);

                                            if(count($jalar_producto)>0){
                                                foreach ($jalar_producto as $jp){
                                                    ?>
                                                    - <?= $jp->producto_nombre;?> <b>X</b> <?= $jp->comanda_detalle_cantidad;?>
                                                    <br>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </td>
                                            <td><?= $p->comanda_correlativo;?></td>
                                            <td><?= $listar_detalle_comanda->total;?></td>
                                            <td>
                                                <a type="button" class="btn btn-xs btn-primary btne" href="<?php echo _SERVER_. 'Pedido/detalle_delivery/' . $p->id_comanda;?>" >Ver Detalle</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger" type="button" id="btn-eliminar_pedido" onclick="preguntar('¿Está seguro que desea eliminar este pedido?','eliminar_comanda_delivery','Si','No',<?= $p->id_comanda_detalle;?>,'<?= $p->id_comanda?>')" data-toggle="tooltip" title='Eliminar'><i class='fa fa-times text-white eliminar margen'></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $a++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
