<?php
//Llamamos a la libreria
require_once 'app/view/pdf/pdf_base.php';
//creamos el objeto
$pdf=new PDF();
//Añadimos una pagina
$pdf->AddPage();
//Define el marcador de posición usado para insertar el número total de páginas en el documento
$pdf->AliasNbPages();
$pdf->SetFont('Arial','BU',14);
//Mover
$pdf->Cell(30);
$pdf->Cell(130,10,'Reporte General desde'." ".$fecha_i." ". 'hasta'." ".$fecha_f,0,1,'C');

$pdf->Ln();
$pdf->Ln();
$caja_total = 0;
$ingresos_total = 0;
$egresos_totales = 0;
$ingresos_tarjeta_total = 0;
$ingresos_totales = 0;
$movimientos_caja_chica = 0;
$salida_caja_chica = 0;
$orden_pedido_total = 0;
for($i=$fecha_filtro;$i<=$fecha_filtro_fin;$i+=86400){

    $reporte_ingresos = $this->reporte->listar_datos_ingresos(date("Y-m-d",$i));
    $reporte_orden_pedido = $this->reporte->listar_monto_op(date("Y-m-d",$i));
    $reporte_ingresos_tarjeta = $this->reporte->listar_datos_ingresos_tarjeta(date("Y-m-d",$i));
    $caja = $this->reporte->sumar_caja(date("Y-m-d",$i));
    $reporte_egresos_movi = $this->reporte->listar_datos_egresos(date("Y-m-d",$i));
    $reporte_ingresos_movi = $this->reporte->listar_datos_ingresos_caja(date("Y-m-d",$i));

    $reporte_ingresos_movi = $reporte_ingresos_movi->total;
    $reporte_egresos_movi = $reporte_egresos_movi->total;
    $caja = $caja->total;
    $reporte_ingresos_tarjeta = $reporte_ingresos_tarjeta->total;
    $ingresos = $reporte_ingresos->total;
    $reporte_orden_pedido = $reporte_orden_pedido->total;

    $caja_total = $caja_total + $caja;
    $ingresos_total = $ingresos_total + $ingresos;
    $orden_pedido_total = $orden_pedido_total + $reporte_orden_pedido;
    $ingresos_tarjeta_total = $ingresos_tarjeta_total + $reporte_ingresos_tarjeta;
    $movimientos_caja_chica = $movimientos_caja_chica + $reporte_ingresos_movi;
    $salida_caja_chica = $salida_caja_chica + $reporte_egresos_movi;
}
$egresos_totales = $egresos_totales + $salida_caja_chica + $orden_pedido_total;
$ingresos_totales = $ingresos_totales + $ingresos_tarjeta_total + $ingresos_total;
$diferencia = $caja_total + $movimientos_caja_chica + $ingresos_total - $salida_caja_chica - $orden_pedido_total;

$pdf->SetFont('Arial','U',12);
$pdf->Cell(70,6,'Balance General :',0,1,'L',0);
$pdf->Ln();
$pdf->SetFont('Arial','',12);
$pdf->Cell(100,6,'INGRESOS',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$ingresos_totales ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'- Apertura de Caja',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$caja_total ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'- Ingresos caja chica',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$movimientos_caja_chica ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'VENTAS',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$ingresos_total ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'- Pagos Efectivo:',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$ingresos_total ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'- Pagos Tarjeta:',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$ingresos_tarjeta_total ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'EGRESOS',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$egresos_totales ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'- Orden de Compras:',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$orden_pedido_total ?? 0,0,1,'C',0);
$pdf->Cell(100,6,'- Salida caja chica :',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$salida_caja_chica ?? 0,0,1,'C',0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,6,'TOTAL EFECTIVO',0,0,'L',0);
$pdf->Cell(18,6,'S/. '.$diferencia ?? 0,0,1,'C',0);

$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','BU',14);
$pdf->Cell(30);
$pdf->Cell(130,10,'CANTIDAD DE VENTAS POR PRODUCTOS',0,1,'C');
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','',10);
$pdf->Cell(25);
$pdf->Cell(60,6,'PRODUCTO',1,0,'C',1);
$pdf->Cell(47,6,'RANGO DE FECHAS',1,0,'C',1);
$pdf->Cell(43,6,'CANTIDAD VENDIDA',1,0,'C',1);
$pdf->Ln();
$cantidad_vendida = 0;
$pdf->SetFont('Arial','',9);
foreach ($productos as $p){
    $pdf->Cell(25);
    $pdf->CellFitSpace(60,6,$p->producto_nombre,1,0,'C',0);
    $pdf->CellFitSpace(47,6,$fecha_i.' / '.$fecha_f,1,0,'C',0);
    $pdf->CellFitSpace(43,6,$p->total,1,1,'C',0);
    $cantidad_vendida = $cantidad_vendida +$p->total;

}
$pdf->SetFont('Arial','',12);
$pdf->Cell(118,10,'TOTAL DE PRODUCTOS VENDIDOS',0,0,'C',0);
$pdf->Cell(30,10,$cantidad_vendida,0,1,'R',0);





$pdf->Ln();
$pdf->Ln();
$pdf->Output();
?>