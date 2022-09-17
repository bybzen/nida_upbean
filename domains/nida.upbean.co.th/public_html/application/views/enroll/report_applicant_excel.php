<?php
$start_date_sql = $this->center_function->ConvertToSQLDate($param['start_date']);
$end_date_sql = $this->center_function->ConvertToSQLDate($param['end_date']);
$date = $this->center_function->ConvertToThaiDate($start_date_sql,1,0)
    ." ถึง ".$this->center_function->ConvertToThaiDate($end_date_sql,1,0);

if ($param['project'] != ''){
    $project_name = $project['project_name'];
    // print_r($subject);
}
else {
    $project_name = "ทั้งหมด";
}

if ($param['subject'] != ''){
$subject_name = $subject['name'];
// print_r($subject);
} 
else {
    $subject_name = "ทั้งหมด";
}

if ($param['province'] != ''){
    $province_name = $province['province_name'];
    // print_r($subject);
    } 
    else {
        $province_name = "ทั้งหมด";
    }

$subject_and_province ="โครงการ: ".$project_name."   หลักสูตร: ".$subject_name."   จังหวัด: ".$province_name;
$total_size = 37;

?>
<?php
header("Content-type: application/vnd.ms-excel;charset=utf-8;");
header("Content-Disposition: attachment; filename=".$date.".xls");
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
						<th class="table_title" colspan="<?php echo $total_size ?>">รายงานผู้สมัครตามจังหวัดและหลักสูตร</th>
					</tr>
					<tr>
						<th class="table_title" colspan="<?php echo $total_size ?>"><?php echo $date ?></th>
					</tr>
                    <tr>
                        <th class="table_title" colspan="<?php echo $total_size ?>" rowspan="2"><?php echo $subject_and_province ?></th>
					</tr>
                </tr>
			</table>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="table_header_top" colspan="1" style="vertical-align: middle;">ลำดับ</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">ชื่อนามสกุล</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">โครงการ</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">หลักสูตร</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">วันเกิด</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">เบอร์</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">E-mail</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">ชื่อบุคคลที่ติดต่อได้ในกรณีฉุกเฉิน</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">หมายเลขบุคคลที่ติดต่อได้ในกรณีฉุกเฉิน</th>
                        <th class="table_header_top" colspan="1" style="vertical-align: middle;">ที่อยู่เลขที่</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">ถนน</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">เขต</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">แขวง</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">จังหวัด</th>
                        <th class="table_header_top" colspan="1" style="vertical-align: middle;">รหัสไปรษณีย์</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">รับประทานอาหาร</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">จำนวนเงิน</th>
                        <th class="table_header_top" colspan="2" style="vertical-align: middle;">สถานะ</th>
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
                        <td class="table_body" colspan="1" style="text-align: center;"><?php echo $count;?></td>
                        <td class="table_body" colspan="3" style="text-align: center;"><?php echo $data['firstname']."   ".$data['lastname']?></td>
                        <td class="table_body" colspan="3" style="text-align: center;"><?php echo $data['enroll_project']?></td>
                        <td class="table_body" colspan="3" style="text-align: center;"><?php echo $data['enroll_subject']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['birthday']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['tel'] ?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['email']?></td>
                        <td class="table_body" colspan="3" style="text-align: center;"><?php echo $data['person_to_notify']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['tel_person_to_notify']?></td>
                        <td class="table_body" colspan="1" style="text-align: center;"><?php echo $data['bill_house']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['bill_road']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['bill_sub_area']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['bill_area']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['bill_province']?></td>
                        <td class="table_body" colspan="1" style="text-align: center;"><?php echo $data['bill_postal_code']?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['food_type'] ?></td>
                        <td class="table_body" colspan="2" style="text-align: right;"><?php echo number_format($data['enroll_cost'],2) ?></td>
                        <td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['payment_status'] ?></td>
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