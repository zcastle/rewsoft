<?php

require_once('../../lib/fpdf17/fpdf.php');
require_once('../../lib/dbapdo.class.php');

function toTitulo($val){
	return ucwords(strtolower(utf8_decode($val)));
}

class PDF extends FPDF{
	private $nu_orden_compra;
	private $forma_pago;
	private $no_atencion;
	private $va_neto;
	private $va_igv;
	private $va_total;

	public function setNuCotizacion($nu_orden_compra){
		$this->nu_orden_compra = $nu_orden_compra;
	}

	public function setFormaPago($forma_pago){
		$this->forma_pago = $forma_pago;
	}

	public function setNoAtencion($no_atencion){
		$this->no_atencion = $no_atencion;
	}

	public function setVaTotal($va_total){
		$this->va_total = $va_total;
		$this->va_neto = $this->va_total / 1.18;
		$this->va_igv = $this->va_neto * 0.18;
	}

	function Header(){
	    $this->SetFont('Arial', 'B', 12);
	    $this->Image('melygin-logo-2.png', 10, 5, 25);
	    $this->sety(5);
	    $this->setX(40);
	    $this->Cell(0, 5, 'DROGUERIA E IMPORTADORA MELYGIN S.R.L.', 0, 1);
	    $this->SetFont('Arial', '', 8);
	    $this->setX(40);
	    $this->Cell(0, 5, 'JR.CHANCAY No.634', 0, 0);
	    $this->setX(152);
	    $this->Cell(50, 5, 'RUC: 20507848517', 0, 1, 'R');
	    $this->setX(40);
	    $this->Cell(0, 5, 'CERCADO LIMA', 0, 0);
	    $this->setX(152);
	    $this->Cell(50, 5, 'ORDEN de COMPRA No.: '.$this->nu_orden_compra, 0, 1, 'R');
	    $this->setX(40);
	    $this->Cell(0, 5, 'Telf.:330-1255 / 827*1418 Fax: 592-0282', 0, 1);
	    $this->setX(40);
	    $this->Cell(0, 5, 'EMail:ventasmelygin@hotmail.com', 0, 1);
	}
	function Footer(){
	    #$this->SetFont('Arial','I',8);
	    $this->SetFont('Arial', 'B', 9);
	    $this->SetY(-77);
	    #$this->Cell(0, 10, toTitulo('Página '.$this->PageNo().'/{nb}'), 0, 0, 'R');
	    $w = array(50, 50, 60, 30);
	    $this->Cell($w[0], 8, 'Gerencia', 'LTRB', 0, 'C');
	    $this->Cell($w[1], 8, 'Logistica', 'TRB', 0, 'C');
	    $this->Cell($w[2], 5, 'Bruto', 'T', 0, 'R');
	    $this->SetFont('Arial', '', 9);
	    $this->Cell($w[3], 5, number_format($this->va_neto, 2), 'TR', 0, 'R');
	    $this->ln();
	    $this->Cell($w[0], 8, '', 'L');
	    $this->Cell($w[1], 8, '', 'R');
	    $this->SetFont('Arial', 'B', 9);
	    $this->Cell($w[2], 5, 'Dscto', '', 0, 'R');
	    $this->SetFont('Arial', '', 9);
	    $this->Cell($w[3], 5, '0.00', 'R', 0, 'R');
	    $this->ln();
	    $this->Cell($w[0], 8, '', 'L');
	    $this->Cell($w[1], 8, '', 'R');
	    $this->SetFont('Arial', 'B', 9);
	    $this->Cell($w[2], 5, 'Valor Venta', '', 0, 'R');
	    $this->SetFont('Arial', '', 9);
	    $this->Cell($w[3], 5, number_format($this->va_neto, 2), 'R', 0, 'R');
	    $this->ln();
	    $this->Cell($w[0], 8, '', 'L');
	    $this->Cell($w[1], 8, '', 'R');
	    $this->SetFont('Arial', 'B', 9);
	    $this->Cell($w[2], 5, 'IGV 18%', '', 0, 'R');
	    $this->SetFont('Arial', '', 9);
	    $this->Cell($w[3], 5, number_format($this->va_igv, 2), 'R', 0, 'R');
	    $this->ln();
	    $this->Cell($w[0], 8, '', 'LB');
	    $this->Cell($w[1], 8, '', 'RB');
	    $this->SetFont('Arial', 'B', 9);
	    $this->Cell($w[2], 8, 'Total Compra', 'B', 0, 'R');
	    $this->SetFont('Arial', '', 9);
	    $this->Cell($w[3], 8, number_format($this->va_total, 2), 'RB', 0, 'R');
		$this->ln();
		$this->SetFont('Arial', '', 8);
		$this->Cell($w[0], 5, 'Observaciones:');
		$this->ln(15);
		$this->Cell($w[0], 5, 'ADJUNTAR PROTOCOLO Y REGISTRO SANITARIO', 0, 1);
		$this->Cell($w[0], 5, 'EN LA FACTURA QUE INDIQUE EL LOTE', 0, 1);
		$this->Cell($w[0], 5, 'HORARIO DE RECEPCION DE MERCADERIA DE 9:00 A 6:30 P.M.', 0, 1);
		$this->Cell($w[0], 5, 'ENTREGA INMEDIATA', 0, 1);
		$this->Cell($w[0], 5, 'VENCIMIENTO NO MENOR A 2 AÑOS', 0, 1);
	    $this->Image('sello.png', 150, 261, 29);
	}
}

//QUERY
$conn = new dbapdo();
$nu_documento = $_REQUEST["nu_documento"]; //$_REQUEST["nu_documento"];

$query = "SELECT DATE_FORMAT(cc.fe_orden_compra, '%d/%m/%Y') AS fe_orden_compra, cc.nu_orden_compra, 
			mc.nu_ruc AS co_proveedor, mc.no_razon_social, mc.de_direccion, cc.va_orden, 
			cc.co_usuario, mfp.no_forma_pago
			FROM (c_orden_compra AS cc
			LEFT JOIN m_proveedores AS mc ON cc.co_proveedor=mc.nu_ruc)
			LEFT JOIN m_forma_pago AS mfp ON mc.co_forma_pago=mfp.co_forma_pago
			WHERE cc.nu_orden_compra = ?;";

$queryD = "SELECT mp.co_producto, mp.no_producto, msc.no_sub_categoria, mum.no_unidad, dc.ca_producto,
			dc.va_producto, (dc.ca_producto * dc.va_producto) AS va_total
			FROM ((d_orden_compra AS dc
			INNER JOIN m_productos AS mp ON dc.co_producto=mp.co_producto)
			INNER JOIN m_sub_categorias AS msc ON mp.co_sub_categoria=msc.co_sub_categoria)
			INNER JOIN m_unidades_medida AS mum ON mp.co_unidad=mum.id
			WHERE dc.nu_orden_compra = ?
			ORDER BY dc.nu_linea;";

$stmt = $conn->prepare($query);
$stmt->bindParam(1, $nu_documento);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_OBJ);

$stmtD = $conn->prepare($queryD);
$stmtD->bindParam(1, $nu_documento);
$stmtD->execute();
$resultD = $stmtD->fetchAll(PDO::FETCH_OBJ);

//FINQUERY
$pdf = new PDF('P','mm','A4');

$pdf->setNuCotizacion($result->nu_orden_compra);
$pdf->setFormaPago($result->no_forma_pago);
$pdf->setNoAtencion($result->co_usuario);
$pdf->setVaTotal($result->va_orden);

$pdf->AliasNbPages();
$pdf->AddPage();

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$pdf->ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(18, 5, toTitulo('Señores:'), 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(130, 5, $result->no_razon_social, 0, 1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(18, 5, 'Direccion:', 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(130, 5, substr($result->de_direccion, 0, 70) , 0, 0);
$pdf->ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(18, 5, 'RUC:', 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(110, 5, $result->co_proveedor, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 5, toTitulo('Moneda:'), 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(35, 5, 'NUEVOS SOLES', 0, 1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(18, 5, toTitulo('Telefono:'), 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(110, 5, '0000000', 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 5, 'Fecha de Emision:', 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(35, 5, $result->fe_orden_compra, 0, 1);

$w = array(8, 15, 65, 35, 10, 17, 20, 20);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell($w[0], 5, toTitulo('Item'), 1, 0);
$pdf->Cell($w[1], 5, toTitulo('Codigo'), 1, 0);
$pdf->Cell($w[2], 5, toTitulo('Descripción'), 1, 0);
$pdf->Cell($w[3], 5, toTitulo('Marca y Procedencia'), 1, 0);
$pdf->Cell($w[4], 5, 'UM', 1, 0);
$pdf->Cell($w[5], 5, toTitulo('Cantidad'), 1, 0, 'R');
$pdf->Cell($w[6], 5, toTitulo('Precio'), 1, 0, 'R');
$pdf->Cell($w[7], 5, toTitulo('Total'), 1, 1, 'R');

for ($i=0; $i < 32; $i++) { 
	$pdf->Cell($w[0], 5, '', 'LR', 0);
	$pdf->Cell($w[1], 5, '', 'R', 0);
	$pdf->Cell($w[2], 5, '', 'R', 0);
	$pdf->Cell($w[3], 5, '', 'R', 0);
	$pdf->Cell($w[4], 5, '', 'R', 0);
	$pdf->Cell($w[5], 5, '', 'R', 0);
	$pdf->Cell($w[6], 5, '', 'R', 0);
	$pdf->Cell($w[7], 5, '', 'R', 0);
	$pdf->ln();
}

$pdf->setY(60);
$ln = 1;
foreach ($resultD as $row) {
	$pdf->Cell($w[0], 5, $ln, 0, 0, 'C');
	$pdf->Cell($w[1], 5, $row->co_producto, 0, 0);
	$pdf->Cell($w[2], 5, $row->no_producto, 0, 0);
	$pdf->Cell($w[3], 5, $row->no_sub_categoria, 0, 0);
	$pdf->Cell($w[4], 5, $row->no_unidad, 0, 0);
	$pdf->Cell($w[5], 5, number_format($row->ca_producto, 2), 0, 0, 'R');
	$pdf->Cell($w[6], 5, number_format($row->va_producto, 2), 0, 0, 'R');
	$pdf->Cell($w[7], 5, number_format($row->va_total, 2), 0, 0, 'R');
	$pdf->ln();
	$ln += 1;
}

$pdf->Output('Cotizacion No.pdf', 'I'); //I Mostrar - D Descargar

?>