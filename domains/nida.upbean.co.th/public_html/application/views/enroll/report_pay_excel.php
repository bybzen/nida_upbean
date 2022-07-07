<?php
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

if ($_GET['unpaid'] == 'on'){
    $type_and_subject = "สถานะ   รอชำระเงิน   หลักสูตร   ".$subject_name;
    $total_size = 14;
} 
else if ($_GET['paid'] == 'on'){
    $type_and_subject = "สถานะ   ชำระเงินแล้ว   หลักสูตร   ".$subject_name;
    $total_size = 14;
} 
else {
    $type_and_subject = "สถานะ   ทั้งหมด   หลักสูตร   ".$subject_name;
    $total_size = 14;
} 

?>
<?php
header("Content-type: application/vnd.ms-excel;charset=utf-8;");
header("Content-Disposition: attachment; filename=รายงานการชำระเงิน".$date.".xls");
date_default_timezone_set('Asia/Bangkok');
?>
<pre>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<style>
				.num {
                    mso-number-format:General;
                }
                .text{
                    mso-number-format:"\@";/*force text*/
                }
                .text-center{
                    text-align: center;
                }
                .text-left{
                    text-align: left;
                }
                .table_title{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 22px;
                    font-weight: bold;
                    text-align:center;
                }
                .table_title_right{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 16px;
                    font-weight: bold;
                    text-align:right;
                }
                .table_header_top{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 19px;
                    font-weight: bold;
                    text-align:center;
                    border-top: thin solid black;
                    border-left: thin solid black;
                    border-right: thin solid black;
                }
                .table_header_mid{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 19px;
                    font-weight: bold;
                    text-align:center;
                    border-left: thin solid black;
                    border-right: thin solid black;
                }
                .table_header_bot{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 19px;
                    font-weight: bold;
                    text-align:center;
                    border-bottom: thin solid black;
                    border-left: thin solid black;
                    border-right: thin solid black;
                }
                .table_header_bot2{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 19px;
                    font-weight: bold;
                    text-align:center;
                    border: thin solid black;
                }
                .table_body{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 21px;
                    border: thin solid black;
                }
                .table_body_right{
                    font-family: AngsanaUPC, MS Sans Serif;
                    font-size: 21px;
                    border: thin solid black;
                    text-align:right;
                }
			</style>
		</head>
		<body>
			<table class="table table-bordered">
				<tr>
					<tr>
						<th class="table_title" colspan="<?php echo $total_size ?>">รายงานการชำระเงิน</th>
					</tr>
					<tr>
						<th class="table_title" colspan="<?php echo $total_size ?>"><?php echo $date ?></th>
					</tr>
                    <tr>
                        <th class="table_title" colspan="<?php echo $total_size ?>" rowspan="2"><?php echo $type_and_subject ?></th>
					</tr>
                </tr>
			</table>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">ลำดับ</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">วันที่ลงทะเบียน</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">Ref1</th>
                        <th class="table_header_top" colspan="3" style="vertical-align: middle;">ชื่อนามสกุล</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">สถานะ</th>
                        <th class="table_header_top" colspan="2"  style="vertical-align: middle;">จำนวนเงิน</th>
					</tr>
				</thead>
				<tbody>
				
                <?php
                $count = 0;
                $total = 0;
                foreach($datas as  $data){
                    $count++;
                    ?>
                    <tr>
								<td class="table_body" colspan="2" style="text-align: center;"><?php echo $count;?></td>
                                <td class="table_body" colspan="3" style="text-align: center;"><?php echo $this->center_function->ConvertToThaiDate($data['order_created']); ?></td>
                                <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['ref_1']?></td>
                                <td class="table_body" colspan="3" style="text-align: left;"><?php echo $data['firstname']."   ".$data['lastname'] ?></td>
                                <td class="table_body" colspan="2" style="text-align: left;"><?php echo $data['payment_status'] ?></td>
								<td class="table_body" colspan="2" style="text-align: right;"><?php echo number_format($data['enroll_cost'],2) ?></td>
						  </tr>
                    <?php
                        $total += $data['enroll_cost'];
                    }
                ?>
                            <tr>
                                <td class="table_body" colspan="<?php echo $total_size ?>" style="text-align: right;"><?php echo "รวม ".number_format($total,2) ?></td>
                            </tr>
					</tbody>
			    </table>
		</body>
	</html>
</pre>