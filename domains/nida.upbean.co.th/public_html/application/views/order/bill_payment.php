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

$filename = $_SERVER["DOCUMENT_ROOT"] . PROJECTPATH . "/assets/document/Bill_Payment.pdf";
if (sizeof($order) == 1){
    $order = $order[0];
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

//$pdf->setXY(30,62.5);
//$pdf->multiCell(50,15,U2T($order['branch_name']),0,"L");

$pdf->setXY(133,62.5);
$pdf->multiCell(50,15,U2T($order['ref_1']),0,"L");

$pdf->setXY(133,70.5);
$pdf->multiCell(50,15,U2T($order['ref_2']),0,"L");

$pdf->setXY(165,100);
$pdf->multiCell(30,10,U2T(number_format($order['value'],2)),0,"R");

$pdf->setXY(90,107);
$pdf->multiCell(70,10,U2T($this->center_function->convert($order['value'])),0,"C");


//$pdf->setXY(30,202);
//$pdf->multiCell(50,15,U2T($order['branch_name']),0,"L");

$pdf->setXY(133,202);
$pdf->multiCell(50,15,U2T($order['ref_1']),0,"L");

$pdf->setXY(133,210);
$pdf->multiCell(50,15,U2T($order['ref_2']),0,"L");

$pdf->setXY(165,239.5);
$pdf->multiCell(30,10,U2T(number_format($order['value'],2)),0,"R");

$pdf->setXY(90,246.5);
$pdf->multiCell(70,10,U2T($this->center_function->convert($order['value'])),0,"C");

$code = "|".$tax_id.$suffix."*".$order['ref_1']."*".$order['ref_2']."*".str_replace(",", "", str_replace(".", "", number_format($order['value'], 2)));
$full_code = str_replace('*',"\t",$code);

$pdf->Image(base_url('order/gen_qr?data='.$code),7.5,117,	20,	20,'PNG');
$pdf->Image(base_url('order/gen_qr?data='.$code),7.5,257,	20,	20,'PNG');

// barcode
$code = "|".$tax_id.$suffix."\r".$order['ref_1']."\r".$order['ref_2']."\r".str_replace(",", "", str_replace(".", "", number_format($order['value'], 2)));
$full_code = "| ".$tax_id." ".$suffix." ".get_code_text($order['ref_1'],18)." ".get_code_text($order['ref_2'],18)." ".get_code_text(str_replace(",", "", str_replace(".", "", number_format($order['value'], 2))),10);

$barcodebase64 = base64_encode($generatorPNG->getBarcode($code, $generatorPNG::TYPE_CODE_128));
$pic = 'data:image/png;base64,' . $barcodebase64;

$pdf->SetFont('THSarabunNew','',11);

$pdf->Image($pic, 100,121.5, 100,10, 'png');
$pdf->setXY(100,128.5);
$pdf->multiCell(100,10,U2T($full_code),0,"L");

$pdf->Image($pic, 100,260, 100,10, 'png');
$pdf->setXY(100,266.9);
$pdf->multiCell(100,10,U2T($full_code),0,"L");

$pdf->Output();
?>
