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
$pdf->Cell(130,10,'REPORTE DE CANTIDAD VENDIDA POR PRODUCTO SEGUN FILTRO',0,1,'C');

$pdf->Ln();
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','',10);


$pdf->Cell(42,6,'FECHAS',1,0,'C',1);
$pdf->Cell(70,6,'PRODUCTO',1,0,'C',1);
$pdf->Cell(28,6,'PRECIO UNIT.',1,0,'C',1);
$pdf->Cell(25,6,'CANT.',1,0,'C',1);
$pdf->Cell(25,6,'TOTAL',1,0,'C',1);
$pdf->Ln();
$cantidad_vendida = 0;
$total = 0;
$pdf->SetFont('Arial','',9);
foreach ($productos as $p){

    $pdf->CellFitSpace(42,6,$fecha_filtro.' / '.$fecha_filtro_fin,1,0,'C',0);
    $pdf->CellFitSpace(70,6,$p->venta_detalle_nombre_producto,1,0,'C',0);
    $pdf->CellFitSpace(28,6,"S/. ".$p->venta_detalle_precio_unitario,1,0,'C',0);
    $pdf->CellFitSpace(25,6,$p->total,1,0,'C',0);
    $pdf->CellFitSpace(25,6,$p->total_suma,1,1,'C',0);
    $cantidad_vendida = $cantidad_vendida +$p->total;
    $total = $total + $p->total_suma;

}
$pdf->SetFont('Arial','',12);
$pdf->Cell(140,10,'TOTAL DE PRODUCTOS VENDIDOS',0,0,'L',0);
$pdf->Cell(25,10,$cantidad_vendida,0,0,'C',0);
$pdf->Cell(25,10,number_format($total, 2),0,1,'C',0);

$pdf->Ln();
$pdf->Ln();
$pdf->Output();
?>