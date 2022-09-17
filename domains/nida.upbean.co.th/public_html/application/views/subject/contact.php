<?php
	session_start();
	require "config.inc.php" ;
	require "session.inc.php" ;
	require "menu.inc.php" ;
 	
	$cmpper->check("contact") ;
	
	header("Content-Type:text/html;charset=utf-8");
	date_default_timezone_set('Asia/Bangkok');
 	 
	if($_POST)
	{
 		 
		exit();
	} 
	
	if( @in_array(@$_GET["do"] , array("delete")) && @in_array(@$_GET["in"] , array("contact"))  )
	{
		$contact_id = (int) @$_GET["cid"] ;  
 		$sql = "DELETE FROM cmp_contact WHERE contact_id = {$contact_id} LIMIT 1 " ;
		$mysqli->query($sql);
		echo $mysqli->error ;
 
		$msg->add("s" , "! ลบข้อมูลแล้ว" ) ; 
		echo "<script> window.location.href = \"?\"</script>" ;
		exit();
	}
	
	  
	ob_start();
?>
	<link href="/html/meter/admin1/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css">

	<meta name="keywords" content="<?php echo KEYWORD; ?>" />
	<meta name="description" content="<?php echo DESC; ?>" />
	<style>
		@media print {
		   .page-breadcrumb{display:none;}
		   .form-group-print-hide{display:none;}
		   .form-control{ border : 0 }
		   .pace {display:none}
		}

	</style>
 <?php
	$header = ob_get_contents();
	ob_end_clean();
	$smarty->assign("header", $header);
 
	ob_start();
?>
 
<?php
	$scripts = ob_get_contents();
	ob_end_clean();
	$smarty->assign("scripts", $scripts);
  
	ob_start();
?>
<script type="text/javascript" src="/html/meter/admin1/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script>
	$(function(){
		function printExternal(url) {
			var printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
			printWindow.addEventListener('load', function(){
				printWindow.print();
				printWindow.close();
			}, true);
		}
		
		function auto_grow() {
			var element = document.getElementById("contact_detail") ; 
            element.style.height = "150px";
            element.style.height = (element.scrollHeight + 100 )+"px";
        }
		
		$("#frm_journal").validate();
		$(".date-picker").datepicker({
			orientation: "top auto" ,
			autoclose: true , 
			format : "yyyy-mm-dd"
		});
		$(document).on("click" , "#btnPrint" , function(){
			window.print();
		});
		$(document).on("click" , ".btnPrintItem" , function(){
			//printExternal($(this).attr("href")) ; 
		});
		auto_grow() ; 
		<?php if(@$_GET["print"] == "1"  ){ ?>
		window.print();
		<?php } ?>
		
	})
</script>

<?php
	$footer = ob_get_contents();
	ob_end_clean();
	$smarty->assign("footer", $footer);
	 
	
 	if(@in_array($_GET["do"] , array("add" , "edit") ) )
	{
		
		if(@in_array($_GET["do"] , array("edit"))){
			$contact_id = (int) @$_GET["cid"] ; 
			$sql = "SELECT * FROM cmp_contact WHERE contact_id = {$contact_id} LIMIT 0 , 1 " ;
			$rs = $mysqli->query($sql);
			echo $mysqli->error ;
			$row = $rs->fetch_assoc() ;
			$btitle = "แก้ไขข้อมูล" ;
		}else{
			$btitle = "เพิ่มข้อมูล" ;
			
		}
		
		$smarty->assign("title", "ข้อร้องเรียนและข้อเสนอแนะ" );
		$smarty->assign("page_title", "ข้อร้องเรียนและข้อเสนอแนะ" );
 		$smarty->assign("breadcrumb", array("ข้อร้องเรียนและข้อเสนอแนะ" => "?" ,  "{$btitle}" => "#"  ) );
 
 
		$contact_id = (int) @$row["contact_id"]  ; 
		
 		
		ob_start();
?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-white">
				<div class="panel-heading clearfix">
					<h4 class="panel-title">ข้อร้องเรียนและข้อเสนอแนะ</h4>
				</div>
				<div class="panel-body">
					<?php echo $msg->display() ;  ?>
					<form id="frm_journal" class="form-horizontal" action="?" method="post"  enctype="multipart/form-data" >
					  <input type="hidden" name="contact_id" value="<?php echo $contact_id ;  ?>"/>
  						
						<div class="form-group">
							<label for="contact_name" class="col-sm-3 control-label">ชื่อผู่ติดต่อ</label>
							<div class="col-sm-9">
								<input type="text"  class="form-control" id="contact_name" name="contact_name" placeholder="" value="<?php echo @$row["contact_name"] ?>" disabled  >
 							</div>
						</div>
						
						<div class="form-group">
							<label for="contact_name" class="col-sm-3 control-label">เบอร์โทร</label>
							<div class="col-sm-9">
								<input type="text"  class="form-control" id="contact_tel" name="contact_tel" placeholder="" value="<?php echo @$row["contact_tel"] ?>" disabled  >
 							</div>
						</div>
						
						<div class="form-group">
							<label for="contact_name" class="col-sm-3 control-label">อีเมล์</label>
							<div class="col-sm-9">
								<input type="text"  class="form-control" id="contact_email" name="contact_email" placeholder="" value="<?php echo @$row["contact_email"] ?>" disabled  >
 							</div>
						</div>
						
						<div class="form-group">
							<label for="contact_name" class="col-sm-3 control-label">เรือง</label>
							<div class="col-sm-9">
								<input type="text"  class="form-control" id="contact_title" name="contact_title" placeholder="" value="<?php echo @$row["contact_title"] ?>" disabled >
 							</div>
						</div>
						
						<div class="form-group">
							<label for="contact_name" class="col-sm-3 control-label">รายละเอียด</label>
							<div class="col-sm-9">
								<textarea class="form-control" id="contact_detail" name="contact_detail"  rows="15" disabled  ><?php echo htmlspecialchars(@$row["contact_detail"]) ?></textarea>
 							</div>
						</div>
					 
					 
						<div class="form-group form-group-print-hide">
							<div class="col-sm-offset-3 col-sm-10">
								<a id="btnPrint" href="#" class="btn btn-primary" style="margin-left:5px;"><i class="fa fa-print"></i> พิมพ์ </a>  
 								<a href="?" class="btn btn-danger" style="margin-left:5px;">ออก</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	 </div>
 
<?php 
		$content = ob_get_contents();
		ob_end_clean();
	}
	else
	{
 		$page = (int) @$_GET["page"]  ; 
		
		$smarty->assign("title", "ข้อร้องเรียนและข้อเสนอแนะ" );
		$smarty->assign("page_title", "ข้อร้องเรียนและข้อเสนอแนะ" );
		$smarty->assign("breadcrumb", array("ข้อร้องเรียนและข้อเสนอแนะ" => "#") );
		
		ob_start();
		
		$sql = "SELECT COUNT(contact_id) as _c FROM cmp_contact" ;
		$rs = $mysqli->query($sql);
		echo $mysqli->error ; 
		
		$count = $rs->fetch_assoc();
		$num_rows = $count["_c"] ; 
		$per_page = 10 ; 
		$page = isset($_GET["page"]) ? ((int) $_GET["page"]) : 1;
		
		$pagination = (new Pagination());
		$pagination->setCurrent($page);
		$pagination->setRPP($per_page);
		$pagination->setTotal($num_rows);
		$pagination->setCrumbs(25);
		$paging = $pagination->parse();
		
		$page_start = (($per_page * $page) - $per_page ) ; 
		
		$sql = "SELECT * FROM  cmp_contact ORDER BY createdate DESC LIMIT {$page_start} , {$per_page}   " ;
		$rs = $mysqli->query($sql);
		echo $mysqli->error; 
		 
		
		
		$i =  1; 
	 
?>

	<div class="row">
	<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">ข้อร้องเรียนและข้อเสนอแนะ</h4>
		</div>
		<div class="panel-body">
			 <?php echo $msg->display() ;  ?>
 			 <div style="clear: both;margin-bottom:15px"></div>
			
			 <button onclick='delete_all()'>ลบทั้งหมด</button>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th><input type="checkbox" name="check_all" id="check_all" onchange="auto_check_all()">เลือกทั้งหมด</th>
						<th width="100" style="text-align:center" >ลำดับ</th>
						<th width="225" style="text-align:center" > วันที่ติดต่อ  </th>
						<th width="" style="text-align:center" > ชื่อผู้่ติดต่อ</th>
						<th width="150" style="text-align:center" >จัดการ</th>
						
					</tr>
				</thead>
				<tbody>
					<!-- <td>
						<input type="checkbox" name="test" id="test" value="test">
					</td> -->
					<?php 
					while($row = $rs->fetch_assoc()){
					?>
					 <tr>
						<td>
							<input type="checkbox" name="delete_id" id="delete_id" class="checkbox" value="<?php echo @$row['contact_id']?>">
							<label for="show_contact_id"><?php echo @$row['contact_id']?></label>
						</td>
						<td style="text-align:center" ><?php echo $i ++  ?></td>
						<td><?php echo @mysqldate2thaidate(@$row["createdate"] , "long" , true )  ?></td>
						<td><?php echo @$row["contact_name"] ?></td>
  						<td style="text-align:center" >
 							<a target="_blank" class="btnPrintItem" href="?in=contact&do=edit&cid=<?php echo @$row["contact_id"] ?>&print=1" title="พิมพ์"  ><i class="fa fa-print" ></i></a> |
							<a href="?in=contact&do=edit&cid=<?php echo @$row["contact_id"] ?>" title="ดูรายละเอียด" ><i class="fa fa-eye" ></i></a> | 
							<a href="?in=contact&do=delete&cid=<?php echo @$row["contact_id"] ?>" title="ลบข้อมูล"  onclick="return confirm('ต้องการลบข้อมูลนี้')  ; "  ><i class="fa fa-trash-o" ></i></a>
						</td>
                      </tr>
					<?php 
						} 
					?>
				</tbody>
			</table>
			<?php echo $paging  ?>
		</div>
	</div>
	</div>
	</div>
	<script>
		function auto_check_all(){
			var checkBox_1 = document.getElementById("check_all");
			if(checkBox_1.checked === true){
				$('.checkbox').each(function(){
					this.checked = true
				})
			}
			else{
				$('.checkbox').each(function(){
					this.checked = false
				})
			}
		}

		function delete_all(){
			var x = []
			$.each($("input:checkbox[name='delete_id']:checked"), function () {
                let str = $(this).val()
                str = str.replace(/\s/g, '')
                x.push(str)
            });
			console.log(x)
			
		}
	</script>
 
<?php 	
		$content = ob_get_contents();
		ob_end_clean();
		
	}
	
	
	
	$smarty->assign("content", $content);
	$smarty->display(THEME.".tpl");
 