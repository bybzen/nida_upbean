<?php
function U2T($text) { return @iconv("UTF-8", "TIS-620//IGNORE", ($text)); }
function num_format($text) {
    if($text!=''){
        return number_format($text,2);
    }else{
        return '';
    }
}

$col_x_1 = 10;
$col_w_1 = 15;
$col_x_2 = $col_w_1 + $col_x_1;
$col_w_2 = 30;
$col_x_3 = $col_w_2 + $col_x_2;
$col_w_3 = 35;
$col_x_4 = $col_w_3 + $col_x_3;
$col_w_4 = 30;
$col_x_5 = $col_w_4 + $col_x_4;
$col_w_5 = 50;
$col_x_6 = $col_w_5 + $col_x_5;
$col_w_6 = 30;

$pdf = new FPDI('P','mm', "A4");
$pdf->AddFont('c','','THSarabunNew.php');
$pdf->AddFont('b','','THSarabunNew-Bold.php');

$count = 0;
$first = 0;
$total = 0;
$date = "วันที่ ".$this->center_function->ConvertToThaiDate($import_data['created_at'],1,0);
//รายการที่พบ
if (!empty($datas)){
    foreach ($datas as $data){
        if ($data['order_id'] == null){
            continue;
        }
        if($first == 0 || (($y_point + 42) > 297)) {
            $first++;
            $y_point = 10;
            $pdf->AddPage();

            $pdf->SetMargins(0, 0, 0);
            $border = 0;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetAutoPageBreak(true,0);

            $pdf->SetFont('b', '', 17 );
            $pdf->SetXY( 0, $y_point );
            $pdf->MultiCell(210, 10, U2T("รายงานนำเข้าไฟล์ธนาคารกรุงไทย"), 0, "C");

            $y_point += 10;
            $pdf->SetXY( 0, $y_point );
            $pdf->MultiCell(210, 10, U2T($date), 0, "C");

            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(210, 10, U2T("รายการที่พบ"), 0, "L");

            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(190, 10, "", "B", "C");
            $pdf->SetFont('b', '', 15 );
            $pdf->setXY($col_x_1,$y_point);
            $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

            $pdf->setXY($col_x_2,$y_point);
            $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

            $pdf->setXY($col_x_3,$y_point);
            $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

            $pdf->setXY($col_x_4,$y_point);
            $pdf->MultiCell($col_w_4, 10, U2T("เลขที่การสั่งชื้อ"), 0, "C");

            $pdf->setXY($col_x_5,$y_point);
            $pdf->MultiCell($col_w_5, 10, U2T("ชื่อสาขา"), 0, "C");

            $pdf->setXY($col_x_6,$y_point);
            $pdf->MultiCell($col_w_6, 10, U2T("จำนวนเงิน"), 0, "C");
        }
        $count++;
        $y_point += 10;
        $pdf->SetFont('c', '', 12 );
        $pdf->setXY($col_x_1,$y_point);
        $pdf->MultiCell($col_w_1, 10, U2T($count), 0, "C");

        $pdf->setXY($col_x_2,$y_point);
        $pdf->MultiCell($col_w_2, 10, U2T($this->center_function->ConvertToThaiDate($data['created_at'])), 0, "C");

        $pdf->setXY($col_x_3,$y_point);
        $pdf->MultiCell($col_w_3, 10, U2T($data['ref_1']), 0, "C");

        $pdf->setXY($col_x_4,$y_point);
        $pdf->MultiCell($col_w_4, 10, U2T($data['order_no']), 0, "C");

        $pdf->setXY($col_x_5,$y_point);
        $pdf->MultiCell($col_w_5, 10, U2T($data['name']), 0, "L");

        $pdf->setXY($col_x_6,$y_point);
        $pdf->MultiCell($col_w_6, 10, U2T(number_format($data['amount'],2)), 0, "R");
        $total += $data['amount'];
    }
}
if ($count == 0){
    $y_point = 10;
    $pdf->AddPage();

    $pdf->SetMargins(0, 0, 0);
    $border = 0;
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetAutoPageBreak(true,0);

    $pdf->SetFont('b', '', 17 );
    $pdf->SetXY( 0, $y_point );
    $pdf->MultiCell(210, 10, U2T("รายงานนำเข้าไฟล์ธนาคารกรุงไทย"), 0, "C");

    $y_point += 10;
    $pdf->SetXY( 0, $y_point );
    $pdf->MultiCell(210, 10, U2T($date), 0, "C");

    $y_point += 10;
    $pdf->SetXY( $col_x_1, $y_point );
    $pdf->MultiCell(210, 10, U2T("รายการที่พบ"), 0, "L");

    $y_point += 10;
    $pdf->SetXY( $col_x_1, $y_point );
    $pdf->MultiCell(190, 10, "", "B", "C");
    $pdf->SetFont('b', '', 15 );
    $pdf->setXY($col_x_1,$y_point);
    $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

    $pdf->setXY($col_x_2,$y_point);
    $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

    $pdf->setXY($col_x_3,$y_point);
    $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

    $pdf->setXY($col_x_4,$y_point);
    $pdf->MultiCell($col_w_4, 10, U2T("เลขที่การสั่งชื้อ"), 0, "C");

    $pdf->setXY($col_x_5,$y_point);
    $pdf->MultiCell($col_w_5, 10, U2T("ชื่อสาขา"), 0, "C");

    $pdf->setXY($col_x_6,$y_point);
    $pdf->MultiCell($col_w_6, 10, U2T("จำนวนเงิน"), 0, "C");
}
$y_point += 10;
$pdf->SetXY( $col_x_1, $y_point );
$pdf->MultiCell(190, 10, "", "T", "C");
$pdf->SetFont('b', '', 15 );
$pdf->setXY($col_x_6,$y_point);
$pdf->MultiCell($col_w_6, 10, U2T("รวม   ".number_format($total,2)), 0, "R");

//รายการที่ไม่พบ
$col_x_1 = 10;
$col_w_1 = 15;
$col_x_2 = $col_w_1 + $col_x_1;
$col_w_2 = 50;
$col_x_3 = $col_w_2 + $col_x_2;
$col_w_3 = 95;
$col_x_4 = $col_w_3 + $col_x_3;
$col_w_4 = 30;
$count = 0;
$total = 0;
$first = 0;
if (!empty($datas)){
    foreach ($datas as $data){
        if ($data['order_id'] != null){
            continue;
        }
        if((($y_point + 42) > 297)) {
            $first++;
            $y_point = 10;
            $pdf->AddPage();

            $pdf->SetMargins(0, 0, 0);
            $border = 0;
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetAutoPageBreak(true,0);

            $pdf->SetFont('b', '', 17 );
            $pdf->SetXY( 0, $y_point );
            $pdf->MultiCell(210, 10, U2T("รายงานนำเข้าไฟล์ธนาคารกรุงไทย"), 0, "C");

            $y_point += 10;
            $pdf->SetXY( 0, $y_point );
            $pdf->MultiCell(210, 10, U2T($date), 0, "C");

            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(210, 10, U2T("รายการที่ไม่พบ"), 0, "L");

            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(190, 10, "", "B", "C");
            $pdf->SetFont('b', '', 15 );
            $pdf->setXY($col_x_1,$y_point);
            $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

            $pdf->setXY($col_x_2,$y_point);
            $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

            $pdf->setXY($col_x_3,$y_point);
            $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

            $pdf->setXY($col_x_4,$y_point);
            $pdf->MultiCell($col_w_4, 10, U2T("จำนวนเงิน"), 0, "C");
        } else if ($first == 0){
            $first++;
            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(210, 10, U2T("รายการที่ไม่พบ"), 0, "L");

            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(190, 10, "", "B", "C");
            $pdf->SetFont('b', '', 15 );
            $pdf->setXY($col_x_1,$y_point);
            $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

            $pdf->setXY($col_x_2,$y_point);
            $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

            $pdf->setXY($col_x_3,$y_point);
            $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

            $pdf->setXY($col_x_4,$y_point);
            $pdf->MultiCell($col_w_4, 10, U2T("จำนวนเงิน"), 0, "C");

        }
        $count++;
        $y_point += 10;
        $pdf->SetFont('c', '', 12 );
        $pdf->setXY($col_x_1,$y_point);
        $pdf->MultiCell($col_w_1, 10, U2T($count), 0, "C");

        $pdf->setXY($col_x_2,$y_point);
        $pdf->MultiCell($col_w_2, 10, U2T($this->center_function->ConvertToThaiDate($import_data['created_at'])), 0, "C");

        $pdf->setXY($col_x_3,$y_point);
        $pdf->MultiCell($col_w_3, 10, U2T($data['ref']), 0, "C");

        $pdf->setXY($col_x_4,$y_point);
        $pdf->MultiCell($col_w_4, 10, U2T(number_format($data['amount'],2)), 0, "R");
        $total += $data['amount'];
    }
}
if ($count == 0){
    $y_point += 10;

    $pdf->SetMargins(0, 0, 0);
    $border = 0;
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetAutoPageBreak(true,0);

    $pdf->SetFont('b', '', 17 );

    $y_point += 10;
    $pdf->SetXY( $col_x_1, $y_point );
    $pdf->MultiCell(210, 10, U2T("รายการที่ไม่พบ"), 0, "L");

    $y_point += 10;
    $pdf->SetXY( $col_x_1, $y_point );
    $pdf->MultiCell(190, 10, "", "B", "C");
    $pdf->SetFont('b', '', 15 );
    $pdf->setXY($col_x_1,$y_point);
    $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

    $pdf->setXY($col_x_2,$y_point);
    $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

    $pdf->setXY($col_x_3,$y_point);
    $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

    $pdf->setXY($col_x_4,$y_point);
    $pdf->MultiCell($col_w_4, 10, U2T("จำนวนเงิน"), 0, "C");
}
$y_point += 10;
$pdf->SetXY( $col_x_1, $y_point );
$pdf->MultiCell(190, 10, "", "T", "C");
$pdf->SetFont('b', '', 15 );
$pdf->setXY($col_x_4,$y_point);
$pdf->MultiCell($col_w_4, 10, U2T("รวม   ".number_format($total,2)), 0, "R");



$pdf->Output();
?>
