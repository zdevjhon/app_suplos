<?php
/**
 * Exportar datos a Excel
 *
 * @author jhonz
 *
 */

require_once '../../vendor/autoload.php';
require_once '../../globals.php';

use App\Models\OfferModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$documento = new Spreadsheet();
$styleCabecera = [
    'font' => [
        'bold' => false,
        'name' => 'Calibri',
        'color' => array('rgb' => '282828'),
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders'=>['allBorders'=>['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'808080']]],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
];

$styleRegistro = [
	    'font' => [
	        'bold' => false,
	        'name' => 'Calibri'
	    ],
	    'alignment' => [
	        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
	    ],
	    'borders'=>['allBorders'=>['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'808080' ]]]
	];

$documento
    ->getProperties()
    ->setCreator("jhon Correa Coz (zdev)")
    ->setLastModifiedBy('zdev')
    ->setTitle('Procesos o eventos')
    ->setDescription('Registro de Procesos o eventos');

$documento->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleCabecera);
header('Content-Type: application/vnd.ms-excel');
# Como ya hay una hoja por defecto, la obtenemos, no la creamos
$hojaCliente = $documento->getActiveSheet();
$hojaCliente->setTitle("EVENTOS");
$hojaCliente->setCellValue('A1', 'Creador oferta')
            ->setCellValue('B1', 'Objeto')
            ->setCellValue('C1', 'Actividad')
			->setCellValue('D1', 'Descripción')
			->setCellValue('E1', 'Moneda')
            ->setCellValue('F1', 'Presupuesto')
            ->setCellValue('G1', 'Fecha de inicio')
            ->setCellValue('H1', 'Hora de inicio')
            ->setCellValue('I1', 'Fecha de cierre')
            ->setCellValue('J1', 'Estado');

/// para cuota 1 ************************
$encabezado = [
    'font' => [
        'bold' => false,
        'name' => 'Calibri',
        'color' => array('rgb' => 'F7F0F0'),
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
    'borders'=>['allBorders'=>['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,'color'=>['rgb'=>'#8C8C8C']]],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => '141F30',
        ],
        'endColor' => [
            'argb' => '21262E',
        ],
    ],
];

$datos = OfferModel::searchOffer($_GET["off_obeject"], $_GET["off_description"], $_GET["user_usu_id"], $_GET["off_status"]);
# Comenzamos en la 2 porque la 1 es del encabezado
$index = 2;
foreach ($datos as $val) {
    $estado = '';
    if ($val["off_status"] == ST_ACTIVO) {
        $estado = 'ACTIVO';
    }
    else if ($val["off_status"] == ST_PUBLICADO) {
        $estado = 'PUBLICADO';
    }else{
        $estado = 'EVALUACION';
    }

    $inicio = (new DateTime($val["off_start_date"]))->format('d/m/Y');
    $fin = (new DateTime($val["off_end_date"]))->format('d/m/Y');

    $currency = 'COP';
    if ($row["off_currency"]=='2') {
        $currency = 'USD';
    }
    if ($row["off_currency"]=='3') {
        $currency = 'EUR';
    }

    $hojaCliente->setCellValue('A'.$index, $val["usu_name"]);
    $hojaCliente->setCellValue('B'.$index, $val["off_obeject"]);
    $hojaCliente->setCellValue('C'.$index, $val["pro_name"]);
    $hojaCliente->setCellValue('D'.$index, $val["off_description"]);
    $hojaCliente->setCellValue('E'.$index, $currency);
    $hojaCliente->setCellValue('F'.$index, $val["off_amount"]);    
	$hojaCliente->setCellValue('G'.$index, $inicio);
    $hojaCliente->setCellValue('H'.$index, $val["off_start_time"]);
	$hojaCliente->setCellValue('I'.$index, $fin);
	$hojaCliente->setCellValue('J'.$index, $estado);

	$hojaCliente->getStyle('A1'.':J'.$index)->applyFromArray($styleRegistro);
    $index++;
}

$hojaCliente->setAutoFilter('B1:J1');
$hojaCliente->getColumnDimension('A')->setAutoSize(true);
$hojaCliente->getColumnDimension('B')->setAutoSize(true);
$hojaCliente->getColumnDimension('C')->setAutoSize(true);
$hojaCliente->getColumnDimension('D')->setAutoSize(true);
$hojaCliente->getColumnDimension('E')->setAutoSize(true);
$hojaCliente->getColumnDimension('F')->setAutoSize(true);
$hojaCliente->getColumnDimension('G')->setAutoSize(true);
$hojaCliente->getColumnDimension('H')->setAutoSize(true);
$hojaCliente->getColumnDimension('I')->setAutoSize(true);
$hojaCliente->getColumnDimension('J')->setAutoSize(true);

$fecha = new DateTime();
$nombre = "PO - ".Date("Y").' - '.$fecha->getTimestamp();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nombre.'.xlsx"');
header('Cache-Control: max-age=0');
header('Set-Cookie: fileDownload=true; path=/');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($documento, 'Xlsx');
ob_end_clean();
$writer->save('php://output');
exit;
