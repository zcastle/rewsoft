<?php

require_once '../lib/config.php';
require_once('../lib/tcpdf/config/lang/spa.php');
require_once('../lib/tcpdf/tcpdf.php');

//if ($_POST) {
$detalle = $_REQUEST['detalle'];
$detalle = stripcslashes($detalle);
$detalle = json_decode($detalle);

$ruc = "20545487889";
$razonSocial = "GRUPO OPEN BUSINESS S.A.C.";

$numeroTicket = '001-0000123';

class MYPDF extends TCPDF {

    private $razonSocial;
    private $ruc;
    private $nombreComercial;
    private $direccion;
    private $telefono;
    private $tipoTicket;
    private $numeroTicket;
    private $serieTicketera;
    private $autorizacion;
    private $vendedor;
    
    public function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    public function setRuc($ruc) {
        $this->ruc = $ruc;
    }
    
    public function setNombreComercial($nombreComercial) {
        $this->nombreComercial = $nombreComercial;
    }
    
    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    public function setTipoTicket($tipoTicket) {
        $this->tipoTicket = $tipoTicket;
    }
    
    public function setNumeroTicket($numeroTicket) {
        $this->numeroTicket = $numeroTicket;
    }
    
    public function setSerieTicketera($serieTicketera) {
        $this->serieTicketera = $serieTicketera;
    }
    
    public function setAutorizacion($autorizacion) {
        $this->autorizacion = $autorizacion;
    }
    
    public function setVendedor($vendedor) {
        $this->vendedor = $vendedor;
    }

    public function Header() {
        $this->SetY(5);
        $this->SetFont('courier', '', 9, '', true);
        $this->Cell(80, 0, $this->razonSocial, 0, true, 'C');
        $this->Cell(80, 0, $this->direccion, 0, true, 'C');
        $this->Cell(80, 0, 'RUC: '.$this->ruc.' TLF.: '.$this->telefono, 0, true, 'C');
        $this->Ln();
        $this->Cell(80, 0, 'TICKET: '.$this->tipoTicket.' '.$this->numeroTicket, 0, true, 'C');
        $this->Ln();
        $this->Cell(80, 0, 'N/S: '.$this->serieTicketera.'      FECHA: '. date("d/m/Y"), 0, true, 'C');
        $this->Cell(80, 0, 'AUT: '.$this->autorizacion.'       HORA:   '. date("H:i:s"), 0, true, 'C');
        $this->Ln();
        $this->Cell(80, 0, ' VENDEDOR: '.$this->vendedor, 0, true, 'L');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('courier', '', 9);
        $this->Cell(80, 0, 'GRACIAS POR SU PREFERENCIA', 0, true, 'C');
        $this->Cell(80, 0, 'VUELVA PRONTO', 0, true, 'C');
        $this->Cell(80, 0, 'ventasmelygin@hotmail.com', 0, true, 'C');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setRazonSocial("EMPRESA SAC");
$pdf->setRuc("00000000000");
$pdf->setDireccion("AV.");
$pdf->setTelefono("000-0000");
$pdf->setTipoTicket("FV");
$pdf->setNumeroTicket($numeroTicket);
$pdf->setSerieTicketera('000000000000');
$pdf->setAutorizacion('000000000000');
$pdf->setVendedor("Caja");


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('JC');
$pdf->SetTitle('Guia de Remision');

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->SetFont('courier', '', 9, '', true);

$pdf->SetLeftMargin(0);

$resolution = array(80, 112 + (15 * count($detalle)));
//$pdf->getPageSizeFromFormat('C7')
//$pdf->setPrintFooter(false);
$pdf->AddPage('P', $resolution);

$w = array(23, 15, 20, 20);
$h = 0;
$pdf->SetY(45);
$pdf->Cell(0, $h, '----------------------------------------');
$pdf->Ln();
$pdf->Cell($w[0], $h, 'PRODUCTO');
$pdf->Cell($w[1], $h, 'CANT.', 0, 0, 'R');
$pdf->Cell($w[2], $h, 'P.UNIT', 0, 0, 'R');
$pdf->Cell($w[3], $h, 'TOTAL', 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(0, $h, '----------------------------------------');
$pdf->Ln();

$total = 0;

foreach ($detalle as $linea) {
    //$coProducto = $linea[0]->codigo;
    $noProducto = $linea[0]->no_producto;
    $caProducto = $linea[0]->cantidad;
    $unidadventaProducto = $linea[0]->unidad;
    $precioProducto = number_format($linea[0]->precio0, 2);
    $totalProducto = number_format($linea[0]->total, 2);
    $lote = $linea[0]->lote;
    $vencimiento = $linea[0]->vencimiento;
    $total += $linea[0]->total;
    
    $pdf->Cell($w[0], 0, $noProducto, 0);
    $pdf->Ln();
    $pdf->Cell($w[0], 0, '', 0);
    $pdf->Cell($w[1], 0, $caProducto.' '.$unidadventaProducto, 0, 0, 'R');
    $pdf->Cell($w[2], 0, $precioProducto, 0, 0, 'R');
    $pdf->Cell($w[3], 0, $totalProducto, 0, 0, 'R');
    $pdf->Ln();
    $pdf->Cell($w[0], 0, '', 0);
    $pdf->Cell($w[1], 0, '', 0);
    $pdf->Cell($w[2], 0, '', 0);
    $pdf->Cell($w[3], 0, 'LOTE/VENC.: '.$lote.' '. $vencimiento, 0, 0, 'R');
    $pdf->Ln();
}

$pdf->Cell(0, $h, '----------------------------------------');
$pdf->Ln();
$pdf->Ln();

$pdf->Cell(0, 0, 'CLIENTE:', 0, true);
$pdf->Cell(0, 0, $razonSocial, 0, true);
$pdf->Cell(0, 0, 'RUC: '.$ruc, 0, true);
//$pdf->Cell(0, 0, count($detalle), 0, true);



$stotal = $total / 1.18;
$igv = $stotal * 0.18;

$stotal = substr('         '.number_format($stotal, 2), -10);
$igv = substr('         '.number_format($igv, 2), -10);
$total = substr('         '.number_format($total, 2), -10);

$pdf->Ln();

$pdf->Cell(80, 0, 'VALOR DE VENTA            S/. '.$stotal, 0, true);
$pdf->Cell(80, 0, 'I.G.V. 18%                S/. '.$igv, 0, true);
$pdf->Cell(80, 0, 'TOTAL                     S/. '.$total, 0, true);

$pdf->Output("factura$numeroTicket.pdf", "I");
//echo "{success: true}";
/* } else {
  echo "{success: false, msg: 'Ha ocurrido algun Error'}";
  } */
?>
