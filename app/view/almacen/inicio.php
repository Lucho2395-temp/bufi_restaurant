<?php
/**
 * Created by PhpStorm
 * User: Franz
 * Date: 15/03/2021
 * Time: 09:54
 */
?>
<!-- Modal Agregar Almacen-->
<div class="modal fade" id="gestionAlmacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar/Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="gestionarInfoAlmacen">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="almacen">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Negocio:</label>
                                        <select class="form-control" onchange="actualizar_almacen()" id= "id_negocio" name="id_negocio">
                                            <option selected value="">Seleccionar Negocio</option>
                                            <?php
                                            foreach($negocios as $n){
                                                ?>
                                                <option value="<?php echo $n->id_negocio;?>"><?php echo $n->negocio_nombre;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Sucursal:</label>
                                        <div id="datos_almacen"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Almacén: </label>
                                        <input class="form-control" type="text" id="almacen_nombre" name="almacen_nombre" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Capacidad:</label>
                                        <input class="form-control" type="text" id="almacen_capacidad" onkeyup="return validar_numeros(this.id)" name="almacen_capacidad" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label">Estado: </label>
                                        <select id="almacen_estado" name="almacen_estado" class="form-control" onchange="cambiar_color_estado('almacen_estado')">
                                            <option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
                                            <option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-agregar-almacen"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Editar Almacen-->
<div class="modal fade" id="editarDatosAlmacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Editar Almacen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data" method="post" id="editarInformacionAlmacen">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div id="almacen">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="col-form-label">Nombre Almacén: </label>
                                        <input class="form-control" type="hidden" id="id_almacen" name="id_almacen" maxlength="11" readonly>
                                        <input class="form-control" type="text" id="almacen_nombre_e" name="almacen_nombre_e" maxlength="100" placeholder="Ingrese Información...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Capacidad: </label>
                                    <input class="form-control" type="text" id="almacen_capacidad_e" onkeyup="return validar_numeros(this.id)" name="almacen_capacidad_e" maxlength="100" placeholder="Ingrese Información...">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Estado: </label>
                                    <select id="almacen_estado_e" name="almacen_estado_e" class="form-control" onchange="cambiar_color_estado('almacen_estado_e')">
                                        <option value="1" style="background-color: #17a673; color: white;" selected>HABILITADO</option>
                                        <option value="0" style="background-color: #e74a3b; color: white;">DESHABILITADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Negocio:</label>
                                    <select class="form-control" onchange="actualizar_almacen()" id= "id_negocio" name="id_negocio">
                                        <option value="">Seleccionar Negocio</option>
                                        <?php
                                        foreach($negocios as $c){
                                            ?>
                                            <option value="<?php echo $c->id_negocio;?>"><?php echo $c->negocio_nombre;?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Sucursal:</label>
                                    <div id="datos_almacen"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close fa-sm text-white-50"></i> Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-editar-almacen"><i class="fa fa-save fa-sm text-white-50"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . '/' . $_SESSION['accion'];?></h1>
                <button data-toggle="modal" data-target="#gestionAlmacen" onclick="cambiar_texto_formulario('exampleModalLabel', 'Agregar Nuevo Almacen'); agregacion_almacen()" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Agregar Nuevo</button>
            </div>
            <!-- /.row (main row) -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary">Lista de Almacenes Registrados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-earning" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="text-capitalize">
                                    <tr>
                                        <th>ID</th>
                                        <th>Negocio</th>
                                        <th>Sucursal</th>
                                        <th>Nombre</th>
                                        <th>Capacidad</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($almacenes as $m){
                                        $estado = "DESHABILITADO";
                                        $estilo_estado = "class=\"texto-deshabilitado\"";
                                        if($m->almacenes_estado == 1){
                                            $estado = "HABILITADO";
                                            $estilo_estado = "class=\"texto-habilitado\"";
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $a;?></td>
                                            <td id="negocionombre<?= $m->id_negocio;?>"><strong><?= $m->negocio_nombre;?></strong></td>
                                            <td id="sucursalnombre<?= $m->id_sucursal;?>"><strong><?= $m->sucursal_nombre;?></strong></td>
                                            <td id="almacennombre<?= $m->id_almacen;?>"><?= $m->almacen_nombre;?></td>
                                            <td id="almacencapacidad<?php echo $m->id_almacen;?>"><?php echo $m->almacen_capacidad;?></td>
                                            <td <?=$estilo_estado;?> id="almacenestado<?= $m->id_almacen?>"><?= $estado;?></td>
                                            <td>
                                                <div id="botonalmacen<?= $m->id_almacen;?>">
                                                    <button data-toggle="modal" data-target="#editarDatosAlmacen" onclick="editar_almacen(<?= $m->id_almacen;?>,'<?= $m->id_negocio;?>','<?= $m->id_sucursal;?>','<?= $m->almacen_nombre;?>','<?= $m->almacen_capacidad;?>','<?= $m->almacen_estado;?>')" class="btn btn-sm btn-info btne" ><i class="fa fa-pencil"></i></button>
                                                </div>
                                                <button id="btn-eliminaralmacen<?= $m->id_almacen;?>" class="btn btn-sm btn-secondary btn-danger" onclick="preguntar('¿Está seguro que desea eliminar esta almacen?','eliminar_almacen','Si','No',<?= $m->id_almacen;?>)"><i class="fa fa-trash"></i></button>
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
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <script src="<?php echo _SERVER_ . _JS_;?>domain.js"></script>
    <script src="<?php echo _SERVER_ . _JS_;?>almacen.js"></script>
