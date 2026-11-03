<?php
require_once("fpdf/fpdf.php");
require_once("phpqrcode/qrlib.php");

class PDF extends FPDF
{

} // FIN Class PDF

// Cell(largo, alto, texto, borde, saltodelinea, alineacion )

//$pdf = new PDF();
$pdf = new FPDF('P','mm','A4');

$numfuec = ''.$_POST['numfuec'];
$numfuecweb = 'http://fuec.transcamacho.com/fuec/FUEC'.$numfuec.'.pdf';
$code = $numfuecweb;
//$code = 'http://fuec.transcamacho.com/fuec/';
//$code = 'http://localhost/fuec/FUEC'.$_POST['numfuec']

$pdf->SetMargins(15, 15);
$pdf->AddPage();

$pdf->Rect(10, 10, 190, 270, '');


$pdf->SetFont('Arial','B',11);
$pdf->Cell(185,20,'',0,1,'C',false);
$pdf->Image('img/head.jpg',16,16,180);
$pdf->Image('img/marca.jpg',35,75,140);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(180,4,utf8_decode('FORMATO ÚNICO DE EXTRACTO DEL CONTRATO'),0,1,'C',false);
$pdf->Cell(180,4,utf8_decode('DEL SERVICIO PÚBLICO DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL'),0,1,'C',false);
$pdf->Cell(180,4,'No. 208204520'.$_POST['anoexped'].$_POST['idcontrato'].$_POST['numfuec'],0,1,'C',false);

$pdf->Ln(4);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,4,utf8_decode('RAZÓN SOCIAL DE LA EMPRESA'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,4,utf8_decode(''),0,1,'L',false);


$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,4,utf8_decode('DE TRANSPORTE ESPECIAL:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,4,utf8_decode('TRANS CAMACHO TOURS S.A.S.'),0,1,'L',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,6,utf8_decode('NIT:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,6,utf8_decode('901.363.632-0'),0,1,'L',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,6,utf8_decode('CONTRATO No:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,6,utf8_decode(''.$_POST['idcontrato']),0,1,'L',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,6,utf8_decode('CONTRATANTE:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,6,utf8_decode(''.$_POST['contratante']),0,1,'L',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,6,utf8_decode('NIT/CC:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,6,utf8_decode(''.$_POST['nitcontratante']),0,1,'L',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,6,utf8_decode('OBJETO CONTRATO:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Multicell(120,4,utf8_decode(''.$_POST['objetocontrato']),0,'L',false);

$pdf->Ln(1);

$pdf->SetY(104); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,8,utf8_decode('ORIGEN - DESTINO:'),0,0,'L',false);

$pdf->SetY(104); /* Set 20 Eje Y */
$pdf->SetX(75); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Multicell(120,4,utf8_decode(''.$_POST['origen'].' - '.$_POST['destino'].' - '.$_POST['origen']),0,'L',false);


$pdf->SetY(112); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,8,utf8_decode('CONVENIO DE COLABORACÍON:'),0,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(120,8,utf8_decode(''.$_POST['emprvehi']),0,1,'L',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(180,6,utf8_decode('VIGENCIA DEL CONTRATO'),1,1,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,6,utf8_decode('FECHA INICIAL'),1,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(45,6,utf8_decode(''.$_POST['fechainicial']),1,0,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,6,utf8_decode('FECHA VENCIMIENTO'),1,0,'L',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(45,6,utf8_decode(''.$_POST['fechafinal']),1,1,'C',false);

$pdf->Ln(1);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(180,6,utf8_decode('CARACTERÍSTICAS DEL VEHÍCULO'),1,1,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,6,utf8_decode('PLACA'),1,0,'C',false);
$pdf->Cell(45,6,utf8_decode('MODELO'),1,0,'C',false);
$pdf->Cell(45,6,utf8_decode('MARCA'),1,0,'C',false);
$pdf->Cell(45,6,utf8_decode('CLASE'),1,1,'C',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(45,6,utf8_decode(''.$_POST['placa']),1,0,'C',false);
$pdf->Cell(45,6,utf8_decode(''.$_POST['modelo']),1,0,'C',false);
$pdf->Cell(45,6,utf8_decode(''.$_POST['marca']),1,0,'C',false);
$pdf->Cell(45,6,utf8_decode(''.$_POST['clase']),1,1,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(90,6,utf8_decode('NÚMERO INTERNO'),1,0,'C',false);
$pdf->Cell(90,6,utf8_decode('TARJETA DE OPERACIÓN'),1,1,'C',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(90,6,utf8_decode(''.$_POST['numinterno']),1,0,'C',false);
$pdf->Cell(90,6,utf8_decode(''.$_POST['numtarjeta']),1,1,'C',false);



$pdf->SetY(164); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,6,utf8_decode(''),1,0,'C',false);
$pdf->Cell(50,6,utf8_decode('NOMBRES Y APELLIDOS'),1,0,'C',false);
$pdf->Cell(30,6,utf8_decode('CÉDULA'),1,0,'C',false);
$pdf->Cell(30,6,utf8_decode('LICENCIA'),1,0,'C',false);
$pdf->Cell(30,6,utf8_decode('VIGENCIA'),1,1,'C',false);

$pdf->SetY(170); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Multicell(40,6,utf8_decode('DATOS DEL CONDUCTOR 1'),1,'L',false);

$pdf->SetY(170); /* Set 20 Eje Y */
$pdf->SetX(55); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Multicell(50,6,utf8_decode(''.$_POST['nombcond1']),'LTR','C',false);

$pdf->SetY(170); /* Set 20 Eje Y */
$pdf->SetX(105); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['docucond1']),1,0,'C',false);

$pdf->SetY(170); /* Set 20 Eje Y */
$pdf->SetX(135); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['licecond1']),1,0,'C',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['vigecond1']),1,1,'C',false);


$pdf->SetY(182); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Multicell(40,6,utf8_decode('DATOS DEL CONDUCTOR 2'),1,'L',false);

$pdf->SetY(182); /* Set 20 Eje Y */
$pdf->SetX(55); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Multicell(50,6,utf8_decode(''.$_POST['nombcond2']),'LTR','C',false);

$pdf->SetY(182); /* Set 20 Eje Y */
$pdf->SetX(105); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['docucond2']),1,0,'C',false);


$pdf->SetY(182); /* Set 20 Eje Y */
$pdf->SetX(135); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['licecond2']),1,0,'C',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['vigecond2']),1,1,'C',false);

$pdf->SetY(194); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Multicell(40,6,utf8_decode('DATOS DEL CONDUCTOR 3'),1,'L',false);

$pdf->SetY(194); /* Set 20 Eje Y */
$pdf->SetX(55); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Multicell(50,6,utf8_decode(''.$_POST['nombcond3']),'LTR','C',false);

$pdf->SetY(194); /* Set 20 Eje Y */
$pdf->SetX(105); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['docucond3']),1,0,'C',false);

$pdf->SetY(194); /* Set 20 Eje Y */
$pdf->SetX(135); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['licecond3']),1,0,'C',false);

$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['vigecond3']),1,1,'C',false);

$pdf->SetY(206); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,6,utf8_decode(''),1,0,'C',false);

$pdf->SetY(206); /* Set 20 Eje Y */
$pdf->SetX(55); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,6,utf8_decode('NOMBRES Y APELLIDOS'),1,0,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,6,utf8_decode('CÉDULA'),1,0,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,6,utf8_decode('TELÉFONO'),1,0,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,6,utf8_decode('DIRECCIÓN'),1,1,'C',false);

$pdf->SetFont('Arial','B',9);
$pdf->Multicell(40,6,utf8_decode('RESPONSABLE DEL CONTRATANTE'),1,'L',false);

$pdf->SetY(212); /* Set 20 Eje Y */
$pdf->SetX(55); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Multicell(50,6,utf8_decode(''.$_POST['respcont']),1,'C',false);

$pdf->SetY(212); /* Set 20 Eje Y */
$pdf->SetX(105); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['docuresp']),1,0,'C',false);

$pdf->SetY(212); /* Set 20 Eje Y */
$pdf->SetX(135); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(30,12,utf8_decode(''.$_POST['teleresp']),1,0,'C',false);

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(30,6,utf8_decode(''.$_POST['direresp']),1,'C',false);


$pdf->SetY(225); /* Set 20 Eje Y */
$pdf->SetX(15); /* Set 20 Eje X */
$pdf->SetFont('Arial','',8);
$pdf->Cell(65,45,utf8_decode(''),1,'C',false);

$pdf->SetY(227); /* Set 20 Eje Y */
$pdf->SetX(21); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Write(9,'TRANS CAMACHO TOURS S.A.S.');

$pdf->SetY(231); /* Set 20 Eje Y */
$pdf->SetX(34); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->Write(9,'NIT 901363632-0');

$pdf->SetY(235); /* Set 20 Eje Y */
$pdf->SetX(22); /* Set 20 Eje X */
$pdf->Write(9,utf8_decode('RESOLUCIÓN MINTRANSPORTE'));

$pdf->SetY(239); /* Set 20 Eje Y */
$pdf->SetX(34); /* Set 20 Eje X */
$pdf->Write(9,utf8_decode('20203040012045'));

$pdf->SetY(243); /* Set 20 Eje Y */
$pdf->SetX(20); /* Set 20 Eje X */
$pdf->Write(9,utf8_decode('CRA 79F No 51A-12 S BQ1 IN3 AP203'));

$pdf->SetY(247); /* Set 20 Eje Y */
$pdf->SetX(30); /* Set 20 Eje X */
$pdf->Write(9,utf8_decode('BOGOTA D.C. - COLOMBIA'));

$pdf->SetY(251); /* Set 20 Eje Y */
$pdf->SetX(30); /* Set 20 Eje X */
$pdf->Write(9,utf8_decode('TELÉFONO: 3125780760'));

$pdf->SetY(255); /* Set 20 Eje Y */
$pdf->SetX(26); /* Set 20 Eje X */
$pdf->Write(9,utf8_decode('transcamachotours@outlook.com'));

$pdf->SetY(259); /* Set 20 Eje Y */
$pdf->SetX(30); /* Set 20 Eje X */
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(6,69,173);
$pdf->Write(9,'www.transcamacho.com','http://www.transcamacho.com');



$pdf->SetY(225); /* Set 20 Eje Y */
$pdf->SetX(80); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(45,45,utf8_decode(''),1,0,'C',false);
//$pdf->Image('img/qr.jpg',82,227,41);


//add qr code  EJE X, EJE Y, ANCHO, ALTO, EXTENSION
//$pdf->Image("http://localhost/fuec/qr_generator.php?code=".$code, 81, 226, 42, 42, "png");
$pdf->Image("http://transcamacho.com/fuec/qr_generator.php?code=".$code, 81, 226, 42, 42, "png");

$pdf->SetY(225); /* Set 20 Eje Y */
$pdf->SetX(125); /* Set 20 Eje X */
$pdf->SetFont('Arial','',9);
$pdf->Cell(70,45,utf8_decode(''),1,0,'C',false);
$pdf->Image('img/sign.jpg',140,227,40);
$pdf->SetFont('Arial','',7);
$pdf->Text(134,244,utf8_decode('Firmado digitalmente - '.$_POST['timestamp'] ));
$pdf->SetFont('Arial','',9);
$pdf->Text(132,245,utf8_decode('______________________________'));
$pdf->Text(142,250,utf8_decode('Representante Legal'));
$pdf->Text(136,254,utf8_decode('TRANS CAMACHO TOURS S.A.S.'));

$pdf->SetFont('Arial','',7);
$pdf->Text(130,265,utf8_decode('Firma digital según resolución 6652 de 2019 Art. 8.'));
$pdf->Text(134,268,utf8_decode('Ley 527 de 1999 - Decreto 1074 de 2015.'));
$pdf->Text(15,278,utf8_decode('Formato de acuerdo a los establecido en la resolución 6652 de 2019.'));

$pdf->Output('D', 'FUEC'.$numfuec.'.pdf');
$pdf->Output('F', 'fuec/FUEC'.$numfuec.'.pdf');
?>