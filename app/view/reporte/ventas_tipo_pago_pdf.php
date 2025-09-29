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
$pdf->Cell(130,10,'Reporte desde'." ".$fecha_hoy." ". 'hasta'." ".$fecha_fin,0,1,'C');
$pdf->Ln();
$pdf->SetFont('Arial','BU',12);
$pdf->Cell(80,6,'Ingresos '." ".$pago_nombre,0,2,'L',0);
$pdf->Ln();
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,'Fecha',1,0,'C',1);
$pdf->Cell(20,6,'Tipo Pago',1,0,'C',1);
$pdf->Cell(35,6,'Comprobante',1,0,'C',1);
$pdf->Cell(30,6,'N° Comprobante',1,0,'C',1);
$pdf->Cell(55,6,'Cliente',1,0,'C',1);
$pdf->Cell(20,6,'Total',1,0,'C',1);
$pdf->Ln();
$total = 0;
$total_soles = 0;
$pdf->SetFont('Arial','',9);
foreach ($tipo_pago as $tp){
    $stylee="style= 'text-align: center;'";
    if ($tp->anulado_sunat == 1){
        $stylee="style= 'text-align: center; text-decoration: line-through'";
    }

    if($tp->venta_tipo == "03"){
        $tipo_comprobante = "BOLETA";
        if($tp->anulado_sunat == 0){
            $total_soles = round($total_soles + $tp->venta_total, 2);
        }
    }elseif ($tp->venta_tipo == "01"){
        $tipo_comprobante = "FACTURA";
        if($tp->anulado_sunat == 0){
            $total_soles = round($total_soles + $tp->venta_total, 2);
        }
    }elseif($tp->venta_tipo == "07"){
        $tipo_comprobante = "NOTA DE CRÉDITO";
    }elseif($tp->venta_tipo == "08"){
        $tipo_comprobante = "NOTA DE DÉBITO";
        if($tp->anulado_sunat == 0){
            $total_soles = round($total_soles + $tp->venta_total, 2);
        }
    }else{
        $tipo_comprobante = "--";
    }
    $pdf->CellFitSpace(20,6,date('d-m-Y', strtotime($tp->venta_fecha)),1,0,'C',0);
    $pdf->CellFitSpace(20,6,$tp->tipo_pago_nombre,1,0,'C',0);
    $pdf->CellFitSpace(35,6,$tipo_comprobante,1,0,'C',0);
    $pdf->CellFitSpace(30,6,$tp->venta_serie.' - '.$tp->venta_correlativo,1,0,'C',0);
    $pdf->CellFitSpace(55,6,$tp->cliente_nombre.' '.$tp->cliente_razonsocial,1,0,'C',0);
    $pdf->CellFitSpace(20,6,'S/. '.$tp->venta_total,1,1,'R',0);
}



$pdf->Ln();
$pdf->Ln();
$pdf->Output();
?>