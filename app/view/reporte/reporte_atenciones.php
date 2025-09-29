<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION['controlador'] . ' / ' . $_SESSION['accion'];?></h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="text-capitalize" id="d">
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Mesa</th>
                                        <th>Hora Solicitud</th>
                                        <th>Hora Atención</th>
                                        <th>Diferencia</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php
									$a=1;
									foreach ($reporte_atendidos as $r){
                                        if($r->comanda_detalle_hora_atencion != null){
                                            $registro = strtotime($r->comanda_fecha_registro);
                                            $atencion = strtotime($r->comanda_detalle_hora_atencion);
                                            $diferencia_segundos = $atencion - $registro;
                                            $horas = floor($diferencia_segundos / 3600);
                                            $minutos = floor(($diferencia_segundos % 3600) / 60);
                                            $segundos = $diferencia_segundos % 60;
                                            $diferencia_formateada = "";
                                            if ($horas > 0) {
                                                $diferencia_formateada .= $horas . " horas, ";
                                            }
                                            if ($minutos > 0) {
                                                $diferencia_formateada .= $minutos . " minutos, ";
                                            }
                                            $diferencia_formateada .= $segundos . " segundos";
									?>
                                    <tr>
                                        <td><?= $a ?></td>
                                        <td><?= $r->producto_nombre ?></td>
                                        <td><?= $r->mesa_nombre ?></td>
                                        <td><?= date("H:i:s", strtotime($r->comanda_fecha_registro)) ?></td>
                                        <td><?= date("H:i:s", strtotime($r->comanda_detalle_hora_atencion)) ?></td>
                                        <td><?= $diferencia_formateada ?></td>
										<?php
										$a++;
                                        }
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
