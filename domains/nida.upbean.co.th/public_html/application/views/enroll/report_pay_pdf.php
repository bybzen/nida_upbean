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
$col_w_3 = 45;
$col_x_4 = $col_w_3 + $col_x_3;
$col_w_4 = 50;
$col_x_5 = $col_w_4 + $col_x_4 + 5;
$col_w_5 = 20;
$col_x_6 = $col_w_5 + $col_x_5 - 5;
$col_w_6 = 30;

$pdf = new FPDI('P','mm', "A4");
$pdf->AddFont('c','','THSarabunNew.php');
$pdf->AddFont('b','','THSarabunNew-Bold.php');

$count = 0;
$first = 0;
$total = 0;

$start_date_sql = $this->center_function->ConvertToSQLDate($param['start_date']);
$end_date_sql = $this->center_function->ConvertToSQLDate($param['end_date']);
$date = "วันที่ ".$this->center_function->ConvertToThaiDate($start_date_sql,1,0)
       ." ถึงวันที่ ".$this->center_function->ConvertToThaiDate($end_date_sql,1,0);

if ($param['subject'] != ''){
    $subject_name = $subject['name'];
    // print_r($subject);
} 
else {
    $subject_name = "ทั้งหมด";
}


 if ($_GET['paid'] == 'on'){
    $type_and_subject = "สถานะ   ชำระเงินแล้ว   หลักสูตร   ".$subject_name;


} 
else if ($_GET['unpaid'] == 'on'){
    $type_and_subject = "สถานะ   รอชำระเงิน   หลักสูตร   ".$subject_name;
    
}

else{
    $type_and_subject = "สถานะ   ทั้งหมด   หลักสูตร   ".$subject_name;
}



if(!empty($datas)){
    foreach ($datas as $data){
    //    print_r($data);
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
            $pdf->MultiCell(210, 10, U2T("รายงานการชำระเงิน"), 0, "C");

            $y_point += 10;
            $pdf->SetXY( 0, $y_point );
            $pdf->MultiCell(210, 10, U2T($date), 0, "C");

            $y_point += 10;
            $pdf->SetXY( 0, $y_point );
            $pdf->MultiCell(210, 10, U2T($type_and_subject), 0, "C");


            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(195, 10, "", "B", "C");
            $pdf->SetFont('b', '', 15 );
            $pdf->setXY($col_x_1,$y_point);
            $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

            $pdf->setXY($col_x_2,$y_point);
            $pdf->MultiCell($col_w_2, 10, U2T("วันที่ลงทะเบียน"), 0, "C");

            $pdf->setXY($col_x_3,$y_point);
            $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

            
            $pdf->setXY($col_x_4,$y_point);
            $pdf->MultiCell($col_w_4, 10, U2T("ชื่อนามสกุล"), 0, "C");
            
            $pdf->setXY($col_x_5,$y_point);
            $pdf->MultiCell($col_w_5, 10, U2T("สถานะ"), 0, "C");

            $pdf->setXY($col_x_6,$y_point);
            $pdf->MultiCell($col_w_6, 10, U2T("จำนวนเงิน"), 0, "R");

        }

        $count++;
        $y_point += 10;
        $pdf->SetFont('c', '', 12 );
        $pdf->setXY($col_x_1,$y_point);
        $pdf->MultiCell($col_w_1, 10, U2T($count), 0, "C");

        $pdf->setXY($col_x_2,$y_point);
        $pdf->MultiCell($col_w_2, 10, U2T($this->center_function->ConvertToThaiDate($data['order_created'])), 0, "C");
        

        $pdf->setXY($col_x_3,$y_point);
        $pdf->MultiCell($col_w_3, 10, U2T($data['ref_1']), 0, "C");
        

        
        $pdf->setXY($col_x_4, $y_point);
        $pdf->MultiCell($col_w_4, 10, U2T($data['firstname']."   ".$data['lastname']), 0, "C");
        
        $pdf->setXY($col_x_5, $y_point);
        $pdf->MultiCell($col_w_5, 10, U2T($data['payment_status']), 0, "C");
        

        $pdf->setXY($col_x_6,$y_point);
        $pdf->MultiCell($col_w_6, 10, U2T(number_format($data['enroll_cost'],2)), 0, "R");
        $total += $data['enroll_cost'];
        
    }
} 

else {
    //ปริ้น Header กรณีไม่มี Data
    $y_point = 10;
    $pdf->AddPage();

    $pdf->SetMargins(0, 0, 0);
    $border = 0;
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetAutoPageBreak(true,0);

    $pdf->SetFont('b', '', 17 );
    $pdf->SetXY( 0, $y_point );
    $pdf->MultiCell(210, 10, U2T("รายงานการชำระเงิน"), 0, "C");

    $y_point += 10;
    $pdf->SetXY( 0, $y_point );
    $pdf->MultiCell(210, 10, U2T($date), 0, "C");

    $y_point += 10;
    $pdf->SetXY( 0, $y_point );
    $pdf->MultiCell(210, 10, U2T($type_and_subject), 0, "C");


    $y_point += 10;
    $pdf->SetXY( $col_x_1, $y_point );
    $pdf->MultiCell(190, 10, "", "B", "C");
    $pdf->SetFont('b', '', 15 );
    $pdf->setXY($col_x_1,$y_point);
    $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

    $pdf->setXY($col_x_2,$y_point);
    $pdf->MultiCell($col_w_2, 10, U2T("วันที่สมัคร"), 0, "C");

    $pdf->setXY($col_x_3,$y_point);
    $pdf->MultiCell($col_w_3, 10, U2T("Ref1"), 0, "C");

    
    $pdf->setXY($col_x_4,$y_point);
    $pdf->MultiCell($col_w_4, 10, U2T("ชื่อนามสกุล"), 0, "C");
    
    $pdf->setXY($col_x_5,$y_point);
    $pdf->MultiCell($col_w_5, 10, U2T("สถานะ"), 0, "C");

    $pdf->setXY($col_x_6,$y_point);
    $pdf->MultiCell($col_w_6, 10, U2T("จำนวนเงิน"), 0, "R");
}
$y_point += 10;
$pdf->SetXY( $col_x_1, $y_point );
$pdf->MultiCell(195, 10, "", "T", "C");
$pdf->SetFont('b', '', 15 );
$pdf->setXY($col_x_6,$y_point);
$pdf->MultiCell($col_w_6, 10, U2T("รวม   ".number_format($total,2)), 0, "R");

$pdf->Output();
?>
