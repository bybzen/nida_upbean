<?php
$date = "วันที่ ".$this->center_function->ConvertToThaiDate($import_data['created_at'],1,0);
?>
<?php
header("Content-type: application/vnd.ms-excel;charset=utf-8;");
header("Content-Disposition: attachment; filename=รายงานนำเข้าธนาคารกรุงไทย".$date.".xls");
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
						<th class="table_title" colspan="12">รายงานนำเข้าไฟล์ธนาคารกรุงไทย</th>
					</tr>
					<tr>
						<th class="table_title" colspan="12"><?php echo $date ?></th>
					</tr>
                    <tr>
						<th class="table_title" colspan="12" rowspan="2">รายการที่พบ</th>
					</tr>
                </tr>
			</table>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">ลำดับ</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">วันที่/เวลา</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">Ref1</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">เลขที่การสั่งชื้อ</th>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">ชื่อสาขา</th>
                        <th class="table_header_top" colspan="2"  style="vertical-align: middle;">จำนวนเงิน</th>
					</tr>
				</thead>
				<tbody>
				<?php
                $count = 0;
                $total = 0;
                foreach($datas as  $data){
                    if ($data['order_id'] == null){
                        continue;
                    }
                    $count++;
                    ?>
                    <tr>
								<td class="table_body" colspan="2" style="text-align: center;"><?php echo $count;?></td>
								<td class="table_body" colspan="2" style="text-align: center;"><?php echo $this->center_function->ConvertToThaiDate($data['created_at']); ?></td>
								<td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['ref_1'];?></td>
								<td class="table_body" colspan="2" style="text-align: center;"><?php echo $data['order_no'];?></td>
								<td class="table_body" colspan="2" style="text-align: left;"><?php echo $data['name'] ?></td>
								<td class="table_body" colspan="2" style="text-align: right;"><?php echo number_format($data['amount'],2) ?></td>
						  </tr>
                    <?php
                    $total += $data['amount'];
                }
                ?>
                            <tr>
                                <td class="table_body" colspan="12" style="text-align: right;"><?php echo "รวม ".number_format($total,2) ?></td>
                            </tr>
					</tbody>
			    </table>
            <table class="table table-bordered">
				    <tr>
					    	<th class="table_title " colspan="12" rowspan="2">รายการที่ไม่พบ</th>
                    </tr>
			    </table>
                <table class="table table-bordered">
				<thead>
					<tr>
						<th class="table_header_top" colspan="2" style="vertical-align: middle;">ลำดับ</th>
						<th class="table_header_top" colspan="3" style="vertical-align: middle;">วันที่/เวลา</th>
						<th class="table_header_top" colspan="5" style="vertical-align: middle;">Ref1</th>
                        <th class="table_header_top" colspan="2"  style="vertical-align: middle;">จำนวนเงิน</th>
					</tr>
				</thead>
				<tbody>
				<?php
                $count = 0;
                $total = 0;
                foreach($datas as  $data){
                    if ($data['order_id'] != null){
                        continue;
                    }
                    $count++;
                    ?>
                    <tr>
								<td class="table_body" colspan="2" style="text-align: center;"><?php echo $count;?></td>
								<td class="table_body" colspan="3" style="text-align: center;"><?php echo $this->center_function->ConvertToThaiDate($import_data['created_at']); ?></td>
								<td class="table_body" colspan="5" style="text-align: center;"><?php echo $data['ref'];?></td>
								<td class="table_body" colspan="2" style="text-align: right;"><?php echo number_format($data['amount'],2) ?></td>
						  </tr>
                    <?php
                    $total += $data['amount'];
                }
                ?>
                            <tr>
                                <td class="table_body" colspan="12" style="text-align: right;"><?php echo "รวม ".number_format($total,2) ?></td>
                            </tr>
					</tbody>
                </table>
		</body>
	</html>
</pre>