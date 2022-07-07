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
$col_w_3 = 65;
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

$start_date_sql = $this->center_function->ConvertToSQLDate($param['start_date']);
$end_date_sql = $this->center_function->ConvertToSQLDate($param['end_date']);
$date = "วันที่ ".$this->center_function->ConvertToThaiDate($start_date_sql,1,0)
       ." ถึงวันที่ ".$this->center_function->ConvertToThaiDate($end_date_sql,1,0);

if ($param['branch'] != 0){
    $br_name = $branch['name'];
    // print_r($branch);
} 
else {
    $br_name = "ทั้งหมด";
}

// if ($_GET['unpaid'] == 'on'){
//     $type_and_branch = "การชำระเงิน   รายการที่ไม่พบ";
//     $col_x_2 += 10;
//     $col_x_3 += 15;

// } 

 if ($_GET['paid'] == 'on'){
    $type_and_branch = "สถานะ   ชำระแล้ว   หลักสูตร    ".$br_name;
    $stat = 1;
    // echo $stat;
} 
else if ($_GET['unpaid'] == 'on'){
    $type_and_branch = "สถานะ   รอชำระเงิน  หลักสูตร    ".$br_name;
    $stat = 0;
    // echo $stat;
}
// else {
//     $type_and_branch = "สถานะ   ทั้งหมด    หลักสูตร    ".$br_name;
// }


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
            $pdf->MultiCell(210, 10, U2T($type_and_branch), 0, "C");


            $y_point += 10;
            $pdf->SetXY( $col_x_1, $y_point );
            $pdf->MultiCell(190, 10, "", "B", "C");
            $pdf->SetFont('b', '', 15 );
            $pdf->setXY($col_x_1,$y_point);
            $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

            $pdf->setXY($col_x_2,$y_point);
            $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

            $pdf->setXY($col_x_3,$y_point);
            $pdf->MultiCell($col_w_3, 10, U2T("Ref1/เลขที่คำสั่งซื้อ/รหัสการทำรายการ"), 0, "C");

            // if ($_GET['unpaid'] != 'on'){
                $pdf->setXY($col_x_4,$y_point);
                $pdf->MultiCell($col_w_4, 10, U2T("หลักสูตร"), 0, "C");
            // }

            $pdf->setXY($col_x_5,$y_point);
            $pdf->MultiCell($col_w_5, 10, U2T("จำนวนเงิน"), 0, "C");

        }

        

        $count++;
        $y_point += 10;
        $pdf->SetFont('c', '', 12 );
        $pdf->setXY($col_x_1,$y_point);
        $pdf->MultiCell($col_w_1, 10, U2T($count), 0, "C");

        $pdf->setXY($col_x_2,$y_point);
        if (empty($data['order_created'])){
            $pdf->MultiCell($col_w_2, 10, U2T($this->center_function->ConvertToThaiDate($data['import_created'])), 0, "C");
        } else {
            $pdf->MultiCell($col_w_2, 10, U2T($this->center_function->ConvertToThaiDate($data['order_created'])), 0, "C");
        }

        $pdf->setXY($col_x_3,$y_point);
        if (!empty($data['ref_1'])){
            $pdf->MultiCell($col_w_3, 10, U2T($data['ref_1']), 0, "C");
        } else {
            $pdf->MultiCell($col_w_3, 10, U2T($data['ref']), 0, "C");
        }

        // if ($_GET['unpaid'] != 'on') {
            $pdf->setXY($col_x_4, $y_point);
            $pdf->MultiCell($col_w_4, 10, U2T($data['name']), 0, "L");
            
        // }

        $pdf->setXY($col_x_5,$y_point);
        $pdf->MultiCell($col_w_5, 10, U2T(number_format($data['payment_amt'],2)), 0, "R");
        $total += $data['payment_amt'];
        
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
    $pdf->MultiCell(210, 10, U2T($type_and_branch), 0, "C");


    $y_point += 10;
    $pdf->SetXY( $col_x_1, $y_point );
    $pdf->MultiCell(190, 10, "", "B", "C");
    $pdf->SetFont('b', '', 15 );
    $pdf->setXY($col_x_1,$y_point);
    $pdf->MultiCell($col_w_1, 10, U2T("ลำดับ"), 0, "C");

    $pdf->setXY($col_x_2,$y_point);
    $pdf->MultiCell($col_w_2, 10, U2T("วันที่/เวลา"), 0, "C");

    $pdf->setXY($col_x_3,$y_point);
    $pdf->MultiCell($col_w_3, 10, U2T("Ref1/เลขที่คำสั่งซื้อ/รหัสการทำรายการ"), 0, "C");

    // if ($_GET['unpaid'] != 'on'){
        $pdf->setXY($col_x_4,$y_point);
        $pdf->MultiCell($col_w_4, 10, U2T("หลักสูตร"), 0, "C");
    // }

    $pdf->setXY($col_x_5,$y_point);
    $pdf->MultiCell($col_w_5, 10, U2T("จำนวนเงิน"), 0, "C");
}
$y_point += 10;
$pdf->SetXY( $col_x_1, $y_point );
$pdf->MultiCell(190, 10, "", "T", "C");
$pdf->SetFont('b', '', 15 );
$pdf->setXY($col_x_5,$y_point);
$pdf->MultiCell($col_w_5, 10, U2T("รวม   ".number_format($total,2)), 0, "R");

$pdf->Output();
?>
