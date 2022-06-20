<?php
$start_date_sql = $this->center_function->ConvertToSQLDate($param['start_date']);
$end_date_sql = $this->center_function->ConvertToSQLDate($param['end_date']);
$date = "วันที่ ".$this->center_function->ConvertToThaiDate($start_date_sql,1,0)
    ." ถึงวันที่ ".$this->center_function->ConvertToThaiDate($end_date_sql,1,0);
if ($param['branch'] == 0){
    $br_name = "ทั้งหมด";
} else {
    $br_name = $branch['name'];
}

if ($_GET['type_not_found'] == 'on'){
    $type_and_branch = "การชำระเงิน   รายการที่ไม่พบ";
} else if ($_GET['type_found'] == 'on'){
    $type_and_branch = "การชำระเงิน   รายการที่พบ    สาขา    ".$br_name;
} else {
    $type_and_branch = "การชำระเงิน   ทั้งหมด    สาขา    ".$br_name;
}
?>
<?php
header("Content-type: application/vnd.ms-excel;charset=utf-8;");
header("Content-Disposition: attachment; filename=รายงานสรุปการชำระเงิน".$date.".xls");
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
						<th class="table_title" colspan="8">รายงานสรุปการชำระเงิน</th>
					</tr>
					<tr>
						<th class="table_title" colspan="8"><?php echo $date ?></th>
					</tr>
                    <tr>
                        <th class="table_title" colspan="8" rowspan="2"><?php echo $type_and_branch ?></th>
					</tr>
                </tr>
			</table>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">ลำดับ</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">วันที่/เวลา</th>
                        <th class="table_header_top" colspan="3"  style="vertical-align: middle;">จำนวนเงิน</th>
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
                                <td class="table_body" colspan="3" style="text-align: center;"><?php echo $this->center_function->ConvertToThaiDate($data['created_at']); ?></td>
								<td class="table_body" colspan="3" style="text-align: right;"><?php echo number_format($data['amount'],2) ?></td>
						  </tr>
                    <?php
                    $total += $data['amount'];
                }
                ?>
                            <tr>
                                <td class="table_body" colspan="8" style="text-align: right;"><?php echo "รวม ".number_format($total,2) ?></td>
                            </tr>
					</tbody>
			    </table>
		</body>
	</html>
</pre>