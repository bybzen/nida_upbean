<?php

require_once('barcode_lib.php');
include('application/libraries/phpqrcode/qrlib.php');

function U2T($text) { return @iconv("UTF-8", "TIS-620//IGNORE", trim($text)); }

function get_code_text($code, $fullLength) {
	if (strlen($code) < $fullLength) {
		$diff = $fullLength - strlen($code);
		for ($i = 0; $i < $diff; $i++) {
			$code = " ".$code;
		}
	}
	return $code;
}

$filename = $_SERVER["DOCUMENT_ROOT"] . PROJECTPATH . "/assets/document/Pay-in-Slip.pdf";
if (sizeof($bill_payment) == 1){
    $bill = $bill_payment[0];
}

$pdf = new FPDI();
$generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
$pdf->setSourceFile($filename);
$pdf->AddPage();
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->AddFont('THSarabunNewB','','THSarabunNew-Bold.php');
$pdf->SetFont('THSarabunNew','',14);

// สำหรับธนาคาร
$pdf->setXY(140,41);
$pdf->multiCell(50,15,U2T($bill['name']),0,"L");

$pdf->setXY(160,49);
$pdf->multiCell(50,15,U2T($bill['ref_1']),0,"L");

$pdf->setXY(165,57);
$pdf->multiCell(50,15,U2T($bill['ref_2']),0,"L");

$pdf->setXY(169,87);
$pdf->multiCell(30,10,U2T(number_format($bill['enroll_cost'],2)),0,"R");

$pdf->setXY(100,87);
$pdf->multiCell(70,10,U2T($this->center_function->convert($bill['enroll_cost'])),0,"C");

// สำหรับผู้ชำระเงิน
$pdf->setXY(140,156);
$pdf->multiCell(50,15,U2T($bill['name']),0,"L");

$pdf->setXY(160,165);
$pdf->multiCell(50,15,U2T($bill['ref_1']),0,"L");

$pdf->setXY(165,172);
$pdf->multiCell(50,15,U2T($bill['ref_2']),0,"L");

$pdf->setXY(169,202);
$pdf->multiCell(30,10,U2T(number_format($bill['enroll_cost'],2)),0,"R");

$pdf->setXY(100,202);
$pdf->multiCell(70,10,U2T($this->center_function->convert($bill['enroll_cost'])),0,"C");


// $code = "|".$tax_id.$suffix."*".$bill['ref_1']."*".$bill['ref_2']."*".str_replace(",", "", str_replace(".", "", number_format($bill['enroll_cost'], 2)));
$code = "|".$bill['tax']."*".$bill['ref_1']."*".$bill['ref_2']."*".str_replace(",", "", str_replace(".", "", number_format($bill['enroll_cost'], 2)));
$full_code = str_replace('*',"\t",$code);

$pdf->Image(base_url('enroll/gen_qr?data='.$code),7.5,98,	20,	20,'PNG');
$pdf->Image(base_url('enroll/gen_qr?data='.$code),7.5,212,	20,	20,'PNG');

// barcode
// $code = "|".$tax_id.$suffix."\r".$order['ref_1']."\r".$order['ref_2']."\r".str_replace(",", "", str_replace(".", "", number_format($order['value'], 2)));
// $full_code = "| ".$tax_id." ".$suffix." ".get_code_text($order['ref_1'],18)." ".get_code_text($order['ref_2'],18)." ".get_code_text(str_replace(",", "", str_replace(".", "", number_format($order['value'], 2))),10);

$code = "|".$bill['tax']."\r".$bill['ref_1']."\r".$bill['ref_2']."\r".str_replace(",", "", str_replace(".", "", number_format($bill['enroll_cost'], 2)));
$full_code = "| ".'0135560020655'." ".'22'." ".get_code_text($bill['ref_1'],18)." ".get_code_text($bill['ref_2'],18)." ".get_code_text(str_replace(",", "", str_replace(".", "", number_format($bill['enroll_cost'], 2))),10);

$barcodebase64 = base64_encode($generatorPNG->getBarcode($code, $generatorPNG::TYPE_CODE_128));
$pic = 'data:image/png;base64,' . $barcodebase64;

$pdf->SetFont('THSarabunNew','',11);

$pdf->Image($pic, 100,100, 100,10, 'png');
$pdf->setXY(100,108);
$pdf->multiCell(100,10,U2T($full_code),0,"L");

$pdf->Image($pic, 100,215, 100,10, 'png');
$pdf->setXY(100,223);
$pdf->multiCell(100,10,U2T($full_code),0,"L");

$pdf->Output();
?>
