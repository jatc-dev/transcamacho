<?php
declare(strict_types=1);

require 'conexion.php';
require 'funciones.php';
include('fpdf/fpdf.php');

// Validar que se hayan enviado los datos requeridos por POST
$required = ['numfuec', 'idcontrato', 'contratante', 'nitcontratante', 'objetocontrato', 'origen', 'destino', 'emprvehi', 'fechainicial', 'fechafinal', 'placa', 'modelo', 'marca', 'clase', 'numinterno', 'numtarjeta', 'nombcond1', 'docucond1', 'licecond1', 'vigecond1', 'respcont', 'docuresp', 'teleresp', 'direresp', 'timestamp'];
$missing = [];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || $_POST[$field] === '') {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    error_log("genpdf campos faltantes: " . implode(', ', $missing));
    http_response_code(400);
    echo 'Datos incompletos para generar el PDF.';
    exit;
}

// Función auxiliar para sanitizar datos de entrada del PDF
$esc = function ($val) {
    return htmlspecialchars((string) ($val ?? ''), ENT_QUOTES, 'UTF-8');
};

$numfuec = $esc($_POST['numfuec']);
$anoexped = $esc($_POST['anoexped'] ?? '');
$idcontrato = $esc($_POST['idcontrato']);
$contratante = $esc($_POST['contratante']);
$nitcontratante = $esc($_POST['nitcontratante']);
$objetocontrato = $esc($_POST['objetocontrato']);
$origen = $esc($_POST['origen']);
$destino = $esc($_POST['destino']);
$emprvehi = $esc($_POST['emprvehi']);
$fechainicial = $esc($_POST['fechainicial']);
$fechafinal = $esc($_POST['fechafinal']);
$placa = $esc($_POST['placa']);
$modelo = $esc($_POST['modelo']);
$marca = $esc($_POST['marca']);
$clase = $esc($_POST['clase']);
$numinterno = $esc($_POST['numinterno']);
$numtarjeta = $esc($_POST['numtarjeta']);
$nombcond1 = $esc($_POST['nombcond1']);
$docucond1 = $esc($_POST['docucond1']);
$licecond1 = $esc($_POST['licecond1']);
$vigecond1 = $esc($_POST['vigecond1']);
$nombcond2 = $esc($_POST['nombcond2']);
$docucond2 = $esc($_POST['docucond2']);
$licecond2 = $esc($_POST['licecond2']);
$vigecond2 = $esc($_POST['vigecond2']);
$nombcond3 = $esc($_POST['nombcond3']);
$docucond3 = $esc($_POST['docucond3']);
$licecond3 = $esc($_POST['licecond3']);
$vigecond3 = $esc($_POST['vigecond3']);
$respcont = $esc($_POST['respcont']);
$docuresp = $esc($_POST['docuresp']);
$teleresp = $esc($_POST['teleresp']);
$direresp = $esc($_POST['direresp']);
$timestamp = $esc($_POST['timestamp']);

class PDF extends FPDF
{
}

// Cell(largo, alto, texto, borde, saltodelinea, alineacion )

$pdf = new PDF();

$pdf->SetMargins(15, 15);
$pdf->AddPage();

$pdf->Rect(10, 10, 190, 270, '');


$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(185, 20, '', 0, 1, 'C', false);
$pdf->Image('img/head.jpg', 16, 16, 180);
$pdf->Image('img/marca.jpg', 35, 75, 140);
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(180, 4, utf8_decode('FORMATO ÚNICO DE EXTRACTO DEL CONTRATO'), 0, 1, 'C', false);
$pdf->Cell(180, 4, utf8_decode('DEL SERVICIO PÚBLICO DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL'), 0, 1, 'C', false);
$pdf->Cell(180, 4, 'No. 208204520' . $anoexped . $idcontrato . $numfuec, 0, 1, 'C', false);

$pdf->Ln(4);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 4, utf8_decode('RAZÓN SOCIAL DE LA EMPRESA'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 4, utf8_decode(''), 0, 1, 'L', false);


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 4, utf8_decode('DE TRANSPORTE ESPECIAL:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 4, utf8_decode('TRANS CAMACHO TOURS S.A.S.'), 0, 1, 'L', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 6, utf8_decode('NIT:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 6, utf8_decode('901.363.632-0'), 0, 1, 'L', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 6, utf8_decode('CONTRATO No:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 6, utf8_decode('' . $idcontrato), 0, 1, 'L', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 6, utf8_decode('CONTRATANTE:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 6, utf8_decode('' . $contratante), 0, 1, 'L', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 6, utf8_decode('NIT/CC:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 6, utf8_decode('' . $nitcontratante), 0, 1, 'L', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 6, utf8_decode('OBJETO CONTRATO:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(120, 4, utf8_decode('' . $objetocontrato), 0, 'L', false);

$pdf->Ln(1);

$pdf->SetY(104);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 8, utf8_decode('ORIGEN - DESTINO:'), 0, 0, 'L', false);

$pdf->SetY(104);
$pdf->SetX(75);
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(120, 4, utf8_decode('' . $origen . ' - ' . $destino . ' - ' . $origen), 0, 'L', false);


$pdf->SetY(112);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 8, utf8_decode('CONVENIO DE COLABORACIÓN:'), 0, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 8, utf8_decode('' . $emprvehi), 0, 1, 'L', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(180, 6, utf8_decode('VIGENCIA DEL CONTRATO'), 1, 1, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 6, utf8_decode('FECHA INICIAL'), 1, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 6, utf8_decode('' . $fechainicial), 1, 0, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 6, utf8_decode('FECHA VENCIMIENTO'), 1, 0, 'L', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 6, utf8_decode('' . $fechafinal), 1, 1, 'C', false);

$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(180, 6, utf8_decode('CARACTERÍSTICAS DEL VEHÍCULO'), 1, 1, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(45, 6, utf8_decode('PLACA'), 1, 0, 'C', false);
$pdf->Cell(45, 6, utf8_decode('MODELO'), 1, 0, 'C', false);
$pdf->Cell(45, 6, utf8_decode('MARCA'), 1, 0, 'C', false);
$pdf->Cell(45, 6, utf8_decode('CLASE'), 1, 1, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 6, utf8_decode('' . $placa), 1, 0, 'C', false);
$pdf->Cell(45, 6, utf8_decode('' . $modelo), 1, 0, 'C', false);
$pdf->Cell(45, 6, utf8_decode('' . $marca), 1, 0, 'C', false);
$pdf->Cell(45, 6, utf8_decode('' . $clase), 1, 1, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(90, 6, utf8_decode('NÚMERO INTERNO'), 1, 0, 'C', false);
$pdf->Cell(90, 6, utf8_decode('TARJETA DE OPERACIÓN'), 1, 1, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(90, 6, utf8_decode('' . $numinterno), 1, 0, 'C', false);
$pdf->Cell(90, 6, utf8_decode('' . $numtarjeta), 1, 1, 'C', false);



$pdf->SetY(164);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C', false);
$pdf->Cell(50, 6, utf8_decode('NOMBRES Y APELLIDOS'), 1, 0, 'C', false);
$pdf->Cell(30, 6, utf8_decode('CÉDULA'), 1, 0, 'C', false);
$pdf->Cell(30, 6, utf8_decode('LICENCIA'), 1, 0, 'C', false);
$pdf->Cell(30, 6, utf8_decode('VIGENCIA'), 1, 1, 'C', false);

$pdf->SetY(170);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Multicell(40, 6, utf8_decode('DATOS DEL CONDUCTOR 1'), 1, 'L', false);

$pdf->SetY(170);
$pdf->SetX(55);
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(50, 6, utf8_decode('' . $nombcond1), 'LTR', 'C', false);

$pdf->SetY(170);
$pdf->SetX(105);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $docucond1), 1, 0, 'C', false);

$pdf->SetY(170);
$pdf->SetX(135);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $licecond1), 1, 0, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $vigecond1), 1, 1, 'C', false);



$pdf->SetY(182);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Multicell(40, 6, utf8_decode('DATOS DEL CONDUCTOR 2'), 1, 'L', false);

$pdf->SetY(182);
$pdf->SetX(55);
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(50, 6, utf8_decode('' . $nombcond2), 'LTR', 'C', false);

$pdf->SetY(182);
$pdf->SetX(105);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $docucond2), 1, 0, 'C', false);



$pdf->SetY(182);
$pdf->SetX(135);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $licecond2), 1, 0, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $vigecond2), 1, 1, 'C', false);

$pdf->SetY(194);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Multicell(40, 6, utf8_decode('DATOS DEL CONDUCTOR 3'), 1, 'L', false);

$pdf->SetY(194);
$pdf->SetX(55);
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(50, 6, utf8_decode('' . $nombcond3), 'LTR', 'C', false);

$pdf->SetY(194);
$pdf->SetX(105);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $docucond3), 1, 0, 'C', false);

$pdf->SetY(194);
$pdf->SetX(135);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $licecond3), 1, 0, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $vigecond3), 1, 1, 'C', false);

$pdf->SetY(206);
$pdf->SetX(15);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C', false);

$pdf->SetY(206);
$pdf->SetX(55);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 6, utf8_decode('NOMBRES Y APELLIDOS'), 1, 0, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 6, utf8_decode('CÉDULA'), 1, 0, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 6, utf8_decode('TELÉFONO'), 1, 0, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 6, utf8_decode('DIRECCIÓN'), 1, 1, 'C', false);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Multicell(40, 6, utf8_decode('RESPONSABLE DEL CONTRATANTE'), 1, 'L', false);

$pdf->SetY(212);
$pdf->SetX(55);
$pdf->SetFont('Arial', '', 9);
$pdf->Multicell(50, 6, utf8_decode('' . $respcont), 1, 'C', false);

$pdf->SetY(212);
$pdf->SetX(105);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $docuresp), 1, 0, 'C', false);

$pdf->SetY(212);
$pdf->SetX(135);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 12, utf8_decode('' . $teleresp), 1, 0, 'C', false);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(30, 6, utf8_decode('' . $direresp), 1, 'C', false);



$pdf->SetY(225);
$pdf->SetX(15);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(65, 45, utf8_decode(''), 1, 'C', false);

$pdf->SetY(227);
$pdf->SetX(21);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Write(9, 'TRANS CAMACHO TOURS S.A.S.');

$pdf->SetY(231);
$pdf->SetX(34);
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Write(9, 'NIT 901363632-0');

$pdf->SetY(235);
$pdf->SetX(22);
$pdf->Write(9, utf8_decode('RESOLUCIÓN MINTRANSPORTE'));

$pdf->SetY(239);
$pdf->SetX(34);
$pdf->Write(9, utf8_decode('20203040012045'));

$pdf->SetY(243);
$pdf->SetX(20);
$pdf->Write(9, utf8_decode('CRA 79F No 51A-12 S BQ1 IN3 AP203'));

$pdf->SetY(247);
$pdf->SetX(30);
$pdf->Write(9, utf8_decode('BOGOTA D.C. - COLOMBIA'));

$pdf->SetY(251);
$pdf->SetX(30);
$pdf->Write(9, utf8_decode('TELÉFONO: 3125780760'));

$pdf->SetY(255);
$pdf->SetX(26);
$pdf->Write(9, utf8_decode('transcamachotours@outlook.com'));

$pdf->SetY(259);
$pdf->SetX(30);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(6, 69, 173);
$pdf->Write(9, 'www.transcamacho.com', 'http://www.transcamacho.com');



$pdf->SetY(225);
$pdf->SetX(80);
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(45, 45, utf8_decode(''), 1, 0, 'C', false);
$pdf->Image('img/qr.jpg', 82, 227, 41);



$pdf->SetY(225);
$pdf->SetX(125);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(70, 45, utf8_decode(''), 1, 0, 'C', false);
$pdf->Image('img/sign.jpg', 140, 227, 40);
$pdf->SetFont('Arial', '', 7);
$pdf->Text(134, 244, utf8_decode('Firmado digitalmente - ' . $timestamp));
$pdf->SetFont('Arial', '', 9);
$pdf->Text(132, 245, utf8_decode('______________________________'));
$pdf->Text(142, 250, utf8_decode('Representante Legal'));
$pdf->Text(136, 254, utf8_decode('TRANS CAMACHO TOURS S.A.S.'));

$pdf->SetFont('Arial', '', 7);
$pdf->Text(130, 265, utf8_decode('Firma digital según resolución 6652 de 2019 Art. 8.'));
$pdf->Text(134, 268, utf8_decode('Ley 527 de 1999 – Decreto 1074 de 2015.'));
$pdf->Text(15, 278, utf8_decode('Formato de acuerdo a los establecido en la resolución 6652 de 2019.'));

$pdf->Output('D', 'FUEC' . $numfuec . '.pdf');

?>
