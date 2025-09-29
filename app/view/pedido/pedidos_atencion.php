
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
										<th>Mesa</th>
										<th>Producto</th>
										<th>Cantidad</th>
										<th>Precio</th>
										<th>Despacho</th>
										<th>Total</th>
										<th>Observación</th>
										<th>Fecha / Hora</th>
										<th>Acción</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$a=1;
									foreach ($pedidos_pendientes as $p){
										?>
										<tr>
											<td><?= $a ?></td>
											<td><?= $p->mesa_nombre ?></td>
											<td><?= $p->producto_nombre ?></td>
											<td><?= $p->comanda_detalle_cantidad ?></td>
											<td><?= $p->comanda_detalle_precio ?></td>
											<td><?= $p->comanda_detalle_despacho ?></td>
											<td><?= $p->comanda_detalle_total ?></td>
											<td><?= $p->comanda_detalle_observacion ?></td>
											<td><?= $p->comanda_detalle_fecha_registro ?></td>
											<td>
                                                <a onclick="preguntar('¿Está seguro de despachar este pedido a la <?= $p->mesa_nombre ?> ?','despachar_pedido_pendiente','SI','NO',<?= $p->id_comanda_detalle?>)" class="btn btn-success text-white"><i class="fa fa-check"></i>Despachado</a></td>
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

