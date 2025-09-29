<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form class="form-row" method="post" action="<?= _SERVER_ . 'Ordencompra/ver_facturas';?>">
                                <div class="form-group col-md-4">
                                    <input name="parametro" type="text" value="<?= $parametro;?>" class="form-control" id="parametro" placeholder="Buscar por N° de factura">
                                </div>
                                <div class="form-group col-md-4" >
                                    <button type="submit" class="btn btn-success">Buscar Ahora</button>
                                </div>
                            </form>
                            <br>
                            <?php
                            if($datos){
                            ?>
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable2" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Numero Orden</th>
                                        <th>Numero Comprobante</th>
                                        <th>Fecha de Registro</th>
                                        <th>Recurso</th>
                                        <th>Proveedor</th>
                                        <th>Cantidad Solilitada</th>
                                        <th>Precio Compra</th>
                                        <th>Comprobante</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($facturas as $f){
                                        ?>

                                        <tr>
                                            <td><?= $a;?></td>
                                            <td><?= $f->orden_compra_numero?></td>
                                            <td><?= $f->orden_compra_numero_doc?></td>
                                            <td><?= $f->orden_compra_fecha?></td>
                                            <td><?= $f->recurso_nombre; ?></td>
                                            <td><?= $f->proveedor_nombre; ?></td>
                                            <td><?= $f->detalle_compra_cantidad; ?></td>
                                            <td><?= $f->detalle_compra_precio_compra; ?></td>
                                            <td>
                                                <?php
                                                $docs = $this->ordencompra->listar_detalle_($f->id_orden_compra);
                                                if(!empty($docs->orden_compra_doc_adjuntado)){
                                                    ?>
                                                    - <a href="<?= _SERVER_ . $docs->orden_compra_doc_adjuntado?>" target="_blank"><?= $docs->orden_compra_tipo_doc;?></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= $f->detalle_compra_total_pedido ?? 0?></td>
                                        </tr>
                                        <?php
                                        $a++;
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
                </div>
            </div>

        </div>
    </div>
</div>

<!-- End of Main Content -->
<script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
<script src="<?php echo _SERVER_ . _JS_;?>orden_compra.js"></script>