<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-2">
                                    <label for="fecha_desde" class="form-control-label">Fecha Desde</label>
                                    <input class="form-control" type="date" id="fecha_desde" name="fecha_desde">
                                </div>
                                <div class="col-lg-2">
                                    <label for="fecha_hasta" class="form-control-label">Fecha Hasta</label>
                                    <input class="form-control" type="date" id="fecha_hasta" name="fecha_hasta">
                                </div>
                                <div class="col-lg-2 mt-4">
                                    <a id="buscar_reporte_movimientos" onclick="buscar_datos_reporte_movimientos()" class="btn btn-primary text-white"><i class="fa fa-search"></i> Buscar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-capitalize" id="d">
                                    <tr>
                                        <th>#</th>
                                        <th>RECURSO</th>
                                        <th>INGRESO</th>
                                        <th>SALIDA</th>
                                        <th>SALDO</th>
                                    </tr>
                                    </thead>
                                    <tbody id="cuerpo_tabla_reporte_movimientos">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
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
<script src="<?php echo _SERVER_ . _JS_;?>reporte.js"></script>
