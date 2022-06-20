var condition_garantor_id = "";
var value_check = "";
var garantor_condition = [];
var not_condition = [];
var template_garantor = [];
var operator = {
	'>': function (x, y) { return x > y },
	'>=': function (x, y) { return x >= y },
	'<': function (x, y) { return x < y },
	'<=': function (x, y) { return x <= y },
	'=': function (x, y) { return x = y },
	'!=': function (x, y) { return x != y }
}


$(document).on('change', '.validation', function(e) { 
	// alert("Change to " + this.value, this.id);
	var thisValue = parseInt(removeCommas(this.value));
	var meta = $(this).data("meta");
	var key_optional = $(this).data("optional");
	var optional = removeCommas($("#"+key_optional).val());
	console.log("key_optional", key_optional)
	console.log("optional", optional)

	let ele = new Validation(e)
	ele.meta = meta;
	ele.loanTypeId = $("#loan_type_select").val();
	ele.memberId = $("#member_id").val();
	
	console.log(ele.meta);
	var value= ele.rule(optional);
	$(this).prop('max', value.valueMax);

	if(thisValue > value.valueMax){
		swal("ระบบแจ้งเตือน", "ไม่สามารถกรอกค่า ได้มากกว่า "+ (ele.is_numeric( value.valueMax ) ? addCommas(value.valueMax) : "" ) );
		if(ele.is_numeric(value.valueMax))
			$(this).val(addCommas(value.valueMax));
		else
			$(this).val(value.valueMax);
	}
	if(value.message)
		swal("ระบบแจ้งเตือน", (value.valueMax!="" ? "" : "เงื่อนไขไม่ถูกต้อง \n")+"\t\t"+value.message);
	console.log(thisValue);
	console.log("value=======: ", value);
});
$('#search_member_loan').keyup(function(){
   var txt = $(this).val();
   if(txt != ''){
		$.ajax({
			 url:base_url+"/ajax/search_member_jquery",
			 method:"post",
			 data:{search:txt, member_id_not_allow: $('#member_id').val()},
			 dataType:"text",
			 success:function(data)
			 {
			 //console.log(data);
			  $('#result_member_search').html(data);
			 }
		});
   }else{
	   
   }
});
function search_member_modal(id){
	$('#input_id').val(id);
	$('#search_member_loan_modal').modal('show');
}
function get_guarantee_person_data(member_id){
	$.ajax({
		 url:base_url+"/ajax/ajax_get_guarantee_person_data",
		 method:"post",
		 data:{ member_id: member_id},
		 dataType:"text",
		 success:function(data)
		 {
			$('#guarantee_person_data').html(data);
			$('#guarantee_person_data_modal').modal('show');
		 }
	});
}
function get_data(member_id, member_name , member_group){
	console.log("selected : ", member_id);
	// return;
	//var num_guarantee = $('#loan_rule_'+$('#loan_type').val()).attr('num_guarantee');
	$.post(base_url+"/ajax/get_member", 
			{	
				member_id: member_id,
				for_loan:'1',
				loan_type: $('#loan_type').val(),
				value_check: member_id,
				not_condition: () => {
					var arr = [];
					not_condition.forEach(element => {
						console.log(element)
						arr.push(element.value);
					});
					return arr.join(",");
				},
				condition_garantor_id: condition_garantor_id
			}
			, function(result){
				var obj = JSON.parse(result);
				console.log(obj);
				if(typeof obj === 'object' && obj !== null){
					console.log("is object");
					if(obj.check_id!=null){
						not_condition.push({key: member_id, value: obj.check_id});
					}
					
					result = obj.message;
				}

				var garantee_amount = obj.garantee_amount;

				if(result.text!=''){
					swal({
					  title: result.title,
					  text: result.text,
					  type: "warning",
					  showCancelButton: false,
					  closeOnConfirm: true
					},
					function(){
						
					});
				}else{
					var dupp_count = 0;
					$('.guarantee_person_id').each(function(){
						if($(this).val() == member_id){
							dupp_count++;
						}
					});
					if(dupp_count>0){
						swal({
						  title: "เกิดข้อผิดพลาด",
						  text: "ท่านไม่สามารถเลือกผู้ค้ำประกันซ้ำกันได้",
						  type: "warning",
						  showCancelButton: false,
						  closeOnConfirm: true
						},
						function(){
							
						});
					}else{
						var id = $('#input_id').val();
						$('#guarantee_person_id_'+id).val(member_id);
						$('#guarantee_person_name_'+id).val(member_name);
						$('#guarantee_person_dep_'+id).val(member_group);
						if(garantee_amount == '0'){
							var text_count_guarantee = garantee_amount;
						}else{
							var text_count_guarantee = '<a style="cursor:pointer" onclick="get_guarantee_person_data(\''+member_id+'\')">'+garantee_amount+'</a>';
						}
						$('#count_guarantee_'+id).html(text_count_guarantee);
						$('#btn_delete_'+id).show();
						$('#search_member_loan_modal').modal('hide');
						$('.guarantee_person_'+id).removeAttr('disabled');
						cal_guarantee_person();
					}
				}
			});
}
function cal_guarantee_person(){
	var count_guarantee_person = 0;
	$('.guarantee_person_id').each(function(){
		if($(this).val()!=''){
			count_guarantee_person++;
		}
	});
	var loan_amount = $('#loan_amount').val();
	loan_amount = removeCommas(loan_amount);
	loan_amount = parseInt(loan_amount);
	var per_person = loan_amount/count_guarantee_person;
	per_person = per_person.toFixed(2);
	per_person = parseFloat(per_person);
	per_person = per_person.toLocaleString();
	$('.guarantee_person_id').each(function(){
		var guarantee_person_id = $(this).attr('guarantee_person_id');
		if($(this).val()!='' && $('#loan_amount').val()!=''){
			$('#guarantee_person_amount_'+guarantee_person_id).val(per_person);
		}else{
			$('#guarantee_person_amount_'+guarantee_person_id).val('');
		}
	});
}

function create_input_garantor(){
	console.log("create_input_garantor");
	$("#sec_garantor").empty();
	if(garantor_condition == null) return false;
	template_garantor = [];
	var loan_amount = $('#loan_amount').val();
	loan_amount = removeCommas(loan_amount);
	loan_amount = parseInt(loan_amount);
	garantor_condition.forEach(element => {
		// console.log(element);
		var condition = element.condition
		var check = true;
		var count_condition = 0;
		condition.forEach(cond => {
			var operator = {
				'>': function (x, y) { return x > y },
				'>=': function (x, y) { return x >= y },
				'<': function (x, y) { return x < y },
				'<=': function (x, y) { return x <= y },
				'=': function (x, y) { return x = y },
				'!=': function (x, y) { return x != y }
			}
			console.log("cond: ",cond);
			// console.log(loan_amount, cond.operation, cond.value);
			if(cond.meta_condition_id==="0"){
				console.log("true");
			}else{
				if(operator[cond.operation](loan_amount, parseInt(cond.value))){
					console.log("true");
				}else{
					console.log("false");
					check = false;
				}
			}
			
		});

		if(check){
			count_condition++;
			console.log("USE : ", element.detail_text);
			condition_garantor_id = element.col_id;
			var garantor = element.garantor_condition;
			console.log(garantor);
			var j = 1;
			var tmp = "";
			garantor.forEach(ele_garantor => {
				var html = blue_print.replace(/no\[\]/g, j);
				j++;
				tmp += html;
				
			});
			template_garantor.push({
				html: tmp,
				title: element.detail_text
			});

		}

	});

	if(template_garantor.length == 1){
		$("#sec_garantor").append(template_garantor[0].html);
	}else if(template_garantor.length > 1){
		console.log("over");
		swal("โปรดเลือกเงื่อนไขผู้ค้ำ");
		$('#modal_select_garantor').modal('show');

		var html = "<ul>";
		var c = 0;
		template_garantor.forEach(element => {
			console.log(element);
			html += `
				<li><a href=`+"#"+` data-template_garantor_id = '`+c+`' onclick='selected_garantor(`+c+`)'>`+element.title+`</a></li>
			`;
			c++;
		});
		html += '</ul>';
		$("#modal_select_garantor_body").html(html);
	}else{

	}
	console.log("template: ",template_garantor);
	// $("#sec_garantor").append(html);
}

function selected_garantor(key){
	console.log("click", key);
	console.log(template_garantor[key]);
	$("#sec_garantor").html(template_garantor[key].html);
}

function delete_guarantee_person(id){
	var member_id = $('#guarantee_person_id_'+id).val();
	console.log("delete", member_id);
	for( var i = not_condition.length-1; i--;){
		if ( not_condition[i].key == member_id) not_condition.splice(i, 1);
	}
	console.log(not_condition);
	$('#guarantee_person_id_'+id).val('');
	$('#guarantee_person_name_'+id).val('');
	$('#guarantee_person_dep_'+id).val('');
	$('#count_guarantee_'+id).html('');
	$('#btn_delete_'+id).hide();
	$('.guarantee_person_'+id).attr('disabled','true');
	cal_guarantee_person();
}

function format_the_number(ele){
	var value = $('#'+ele.id).val();
	value = value.replace(/[^0-9]/g, '');	
	if(value!=''){
		if(value == 'NaN'){
			$('#'+ele.id).val('');
		}else{		
			value = parseInt(value);
			value = value.toLocaleString();
			$('#'+ele.id).val(value);
		}			
	}else{
		$('#'+ele.id).val('');
	}
}

function format_the_number_decimal(ele){
	var value = $('#'+ele.id).val();
	value = value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
	var num = value.split(".");
	var decimal = '';	
	var num_decimal = '';	
	if(typeof num[1] !== 'undefined'){
		if(num[1].length > 2){
			num_decimal = num[1].substring(0, 2);
		}else{
			num_decimal =  num[1];
		}
		decimal =  "."+num_decimal;
		
	}
	
	if(value!=''){
		if(value == 'NaN'){
			$('#'+ele.id).val('');
		}else{		
			value = (num[0] == '')?0:parseInt(num[0]);
			value = value.toLocaleString()+decimal;
			$('#'+ele.id).val(value);
		}			
	}else{
		$('#'+ele.id).val('');
	}
}

function check_trem_of_loan(){
	 var member_id = $('#member_id').val();
	 var loan_type = $('#loan_type').val();
	 var loan_amount = $('#loan_amount').val();
	 var share_total = $('#share_total').val();
	 var share_amount = $('#guarantee_amount_2').val();
	 var period_amount = $('#period_amount').val();
	 var fund_total = $('#guarantee_other_price_2').val();
	 var last_date_period = $('#last_date_period').val();
	 var first_pay = $('#money_period_1').val();
	 //console.log(last_date_period);
	 if($('#guarantee_1').is(':checked')){
		 var person_guarantee = '1';
	 }else{
		 var person_guarantee = '';
	 }
	 if($('#guarantee_2').is(':checked')){
		 var share_guarantee = '1';
	 }else{
		 var share_guarantee = '';
	 }
		
		 $.post(base_url+"/loan/ajax_check_term_of_loan", 
			{	
				member_id: member_id,
				loan_type: loan_type,
				loan_amount: loan_amount,
				share_amount: share_amount,
				share_total: share_total,
				period_amount:period_amount,
				fund_total:fund_total,
				person_guarantee:person_guarantee,
				share_guarantee:share_guarantee,
				last_date_period:last_date_period,
				first_pay:first_pay
			}
			, function(result){
				obj = JSON.parse(result);
				if(obj.result=='success'){
					//console.log(result);
					submit_form();
				}else{
					//swal('ท่านไม่สามารถกู้เงินได้เนื่องจาก', result , 'warning');
					$('#check_term_of_loan_result').html(obj.text_return);
					$('#check_term_of_loan_result_modal').modal('show');
				}
			});
 }
 function submit_form(){
	 $("#submit_button").attr('disabled','disabled');
	 $('#form_normal_loan').submit();
 }
function check_submit(){
	var alert_text = '';
	if($('#loan_amount').val()==''){
		alert_text += '- จำนวนเงินที่ขอกู้\n';
	}
	if($('#loan_reason').val()==''){
		alert_text += '- เหตุผลการกู้\n';
	}
	//if($('#salary').val()==''){
		//alert_text += '- เงินเดือน\n';
	//}
	if($('#guarantee_1').is(':checked')){
		if($('#guarantee_person_name_1').val() == '' && $('#guarantee_person_name_2').val() == '' && $('#guarantee_person_name_3').val() == '' && $('#guarantee_person_name_4').val() == ''){
			alert_text += '- ผู้ค้ำประกัน\n';
		}
	}
	if($('#guarantee_2').is(':checked')){
		if($('#guarantee_amount_2').val() == ''){
			alert_text += '- จำนวนหุ้นสะสม\n';
		}
	}
	if($('#guarantee_3').is(':checked')){
		if($('#guarantee_amount_3').val() == ''){
			alert_text += '- จำนวนกองทุนสำรองเลี้ยงชีพ\n';
		}
	}
	if($('#already_cal').val()!='1'){
		alert_text += '- กรุณาคำนวณการส่งค่างวด\n';
	}
	if(alert_text!=''){
		$("#submit_button").removeAttr('disabled');
		swal('กรุณากรอกข้อมูลต่อไปนี้' , alert_text , 'warning');
	}else{
		check_trem_of_loan();
	}
}
function re_already_cal(){
	$('#already_cal').val('');
}

function chkNumber(ele){
	var vchar = String.fromCharCode(event.keyCode);
	if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
	ele.onKeyPress=vchar;
}
function change_table(id){
	//$('.hidden_table').hide();
	//$('.btn_show').attr('class','btn btn-primary btn_show');
	if($('#show_status_'+id).val()==''){
		$('#table_'+id).show();
		$('#button_'+id).attr('class','btn btn-success btn_show');
		$('#show_status_'+id).val('1');
	}else{
		$('#table_'+id).hide();
		$('#button_'+id).attr('class','btn btn-primary btn_show');
		$('#show_status_'+id).val('');
	}
	
} 
function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
function printElem(divId) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');

    mywindow.document.write('<html><head><title>Print</title>');
    mywindow.document.write('</head><body ><center>');
    mywindow.document.write(content);
    mywindow.document.write('</center></body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
function copy_value(from_ele, to_ele){
	$('#'+to_ele).val($('#'+from_ele).val());
}
function close_modal(id){
	$('#'+id).modal('hide');
}
function cal_share_result(share_num){
	 var share_value = $('#share_value').val();
	 if(share_num!=''){
		$('.share_price').val(parseFloat(share_num)*parseFloat(share_value));
	 }else{
		$('.share_price').val('');
	 }
 }
 function change_modal(loan_type_edit = null){
	return new Promise(resolve => {
		if(loan_type_edit == null){
			var loan_type = $('#loan_type_select').val();
			$('#loan_id').val('');
			$('#petition_number').val('');
			$('#loan_amount').val('');
			$('#loan').val('');
			$('#salary').val('');
			$('#loan_reason').val('');
			$('#interest_per_year').val('');
			$('#period_amount').val('');
			$('#date_start_period').val('');
			$('#date_start_period_label').val('');
			$('#date_period_1').val('');
			$('#money_period_1').val('');
			$('#date_period_2').val('');
			$('#money_period_2').val('');
			$('#period_type').val('1');
			$('#period').val('');
			$('#period_old').val('');
			$('#day').val('');
			$('#month').val('');
			$('#year').val('');
			$('#contract_number').val('');
			$('.contract_number').hide();
			// $('#school_benefits').val('');
			// $('#saving').val('');
			// $('#ch_p_k').val('');
			// $('#pension').val('');
			//$('.loan_cost').val('');
			$('.loan_deduct').val('');
			$('.prev_loan_amount').val('');
			$('.estimate_value').val('');

			$('#guarantee_1').removeAttr('checked');
			$('#guarantee_2').removeAttr('checked');
			$('.guarantee_2').attr('disabled','disabled');
			//$('#guarantee_amount_2').val('');
			//$('#guarantee_price_2').val('');
			$('#guarantee_other_price_2').val('');
				
			for (i = 1; i <= 4; i++) {
				$('#guarantee_person_id_'+i).val('');
				$('#guarantee_person_name_'+i).val('');
				$('#guarantee_person_dep_'+i).val('');
				$('#guarantee_person_contract_number_'+i).val('');
				$('#guarantee_person_amount_'+i).val('');
			}	
			$('#result_wrap').html('');
			$('#btn_show_file').hide();
			$('#submit_button').html('บันทึกคำร้อง');
			
			$('#real_estate_position_1').val('');
			$('#real_estate_position_2').val('');
			$('#province_id').val('');
			change_province('province_id','amphure','amphur_id','district','district_id','','');
			//$('#amphur_id').val(obj.coop_loan_guarantee_real_estate.amphur_id);
			//$('#district_id').val(obj.coop_loan_guarantee_real_estate.district_id);
			$('#land_number').val('');
			$('#survey_page').val('');
			$('#deed_number').val('');
			$('#deed_book').val('');
			$('#deed_page').val('');
			$('#rai').val('');
			$('#ngan').val('');
			$('#tarangwah').val('');
			$('.prev_loan_checkbox').attr('checked',false);
			$('.prev_loan_amount').val('');
			get_max_period();
			get_max_loan_amount();
			get_money_use_balance();
			get_money_use_balance_baht();
		}else{
			var loan_type = loan_type_edit;
		}
		
		if(loan_type == ''){
			swal('กรุณาเลือกชื่อสินเชื่อ');
		}else{
			var share_total = $('#share_total').val();
			var member_id = $('#member_id').val();
			$.post(base_url+"/loan/ajax_check_term_of_loan_before", 
				{	
					member_id:member_id,
					loan_type: loan_type,
					share_total:share_total
				}
				, function(result){
					obj = JSON.parse(result);
					garantor_condition = obj.condition_garantor;
					if(obj.share_guarantee == '1' || obj.person_guarantee == '1' || obj.real_estate_guarantee == '1' || obj.deposit_guarantee == '1'){
						$('#type_1').show();
						$('#type_2').hide();
						if( obj.person_guarantee == '1'){
							$('#type_1_1').show();
							if(loan_type_edit==null){
								$('#guarantee_1').attr('checked',true);
								choose_guarantee('guarantee_1');
							}
						}else{
							$('#type_1_1').hide();
							$('#guarantee_1').attr('checked',false);
						}
						if( obj.share_guarantee == '1'){
							$('#type_1_2').show();
							if(loan_type_edit==null){
								$('#guarantee_2').attr('checked',true);
								choose_guarantee('guarantee_2');
							}
							
						}else{
							$('#type_1_2').hide();
							$('#guarantee_2').attr('checked',false);
						}
						
						if( obj.deposit_guarantee == '1'){
							$('#type_1_3').show();
							if(loan_type_edit==null){
								$('#guarantee_3').attr('checked',true);
								choose_guarantee('guarantee_3');
							}
							
						}else{
							$('#type_1_3').hide();
							$('#guarantee_3').attr('checked',false);
						}

						if( obj.real_estate_guarantee == '1'){
							$('#type_1_4').show();
							if(loan_type_edit==null){
							$('#guarantee_4').attr('checked',true);
							choose_guarantee('guarantee_4');
							}
						
						}else{
							$('#type_1_4').hide();
							$('#guarantee_4').attr('checked',false);
						}
					}
					$('#loan_type').val(loan_type);
					$('#type_name').html($('#loan_rule_'+loan_type).attr('type_name'));
					$('.interest_rate').val($('#loan_rule_'+loan_type).attr('interest_rate'));
					//$('#deduct_share').val(obj.loan_deduct_share); 
					
					//console.log("loan_deduct_share="+obj.loan_deduct_share);
					//console.log("debug="+obj.debug);
					
					//$('#deduct_pay_prev_loan').val(obj.prev_loan_amount_balance); 
					if(obj.result=='success'){
						open_modal('normal_loan');
					}else{
						//swal('ท่านไม่สามารถกู้เงินได้เนื่องจาก', obj.text_return,'warning');
						if(loan_type_edit == null){
							$('#check_term_of_loan_before_result').html(obj.text_return);
							$('#check_term_of_loan_before_result_modal').modal('show');
						}
					}
				});
		}

	 	setTimeout(() => {
			resolve('resolved');
		}, 2000);
	});
 }
 function open_modal(id){
	 $('#'+id).modal('show');
	 $('#check_term_of_loan_before_result_modal').modal('hide');
 }
 function search_member(id){
	 var member_id = $('#guarantee_person_id_'+id).val();
	  var loan_type = $('#loan_type').val();
	 $('.btn_search_member').hide();
	 $('.loading_icon').show();
	 if(member_id !=''){
		 $.post(base_url+"/ajax/get_member", 
			{	
				member_id: member_id,
				for_loan:'1',
				loan_type:loan_type
			}
			, function(result){
				if(result=='over_guarantee'){
					swal('ไม่สามารถใช้สมาชิกท่านนี้ค้ำประกันได้ เนื่องจาก' , 'สมาชิกที่ท่านเลือกได้ค้ำประกันเงินกู้เต็มจำนวนที่กำหนดแล้ว', 'warning');
				}else{
					var obj = JSON.parse(result);
					//console.log(obj);
					if(obj.member_name == ' '){
						swal('ไม่พบข้อมูล');
					}
					$('#guarantee_person_id_'+id).val(obj.member_id);
					$('#guarantee_person_name_'+id).val(obj.member_name);
					$('#guarantee_person_dep_'+id).val(obj.member_group_name);
					$('.btn_search_member').show();
					$('.loading_icon').hide();
				}
			});
	 }else{
		 swal('กรุณากรอกรหัสสมาชิกที่ต้องการค้นหา');
		 $('.btn_search_member').show();
		$('.loading_icon').hide();
	 }
 }

 function choose_guarantee(id){
	 if($('#'+id).is(':checked')){
		 $('.'+id).removeAttr('disabled');
	 }else{
		 $('.'+id).attr('disabled','true');
	 }
	 
	check_share();
 }
 function del_loan(loan_id, member_id, status_to){
	 if(status_to=='1'){
		 var title = 'ท่านต้องการยกเลิกการยกเลิกรายการใช่หรือไม่';
	 }else{
		 var title = 'ท่านต้องการยกเลิกคำขอกู้เงินใช่หรือไม่';
	 }
	 swal({
        title: title,
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
			$.ajax({
				url: base_url+'/loan/coop_loan_delete',
				method: 'GET',
				data: {
					'loan_id': loan_id,
					'status_to': status_to,
					'member_id': member_id
				},
				success: function(msg){
				  // console.log(msg); return false;
					if(msg == 1){
					  document.location.href = base_url+'loan?member_id='+member_id;
					}else{

					}
				}
			});
        } else {
			
        }
    });
 }
 function show_period_table(loan_id){
	$.post( base_url+"/loan/ajax_coop_loan_period_table", 
	{	
		loan_id: loan_id
	}
	, function(result){
		$('.period_table').html(result);
		$('#period_table').modal('show');
	});
}
function show_file(){
	 $('#show_file_attach').modal('show');
}
function del_file(id){
	swal({
        title: "ท่านต้องการลบไฟล์ใช่หรือไม่?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
			$.post( base_url+"/loan/ajax_delete_loan_file_attach", 
			{	
				id: id
			}
			, function(result){
				if(result=='success'){
					$('#file_'+id).remove();
					
					var i=0;
					$('.file_row').each(function(index){
						i++;
						//console.log(i);
					});
					
					if(i<=0){
						$('#show_file_attach').modal('hide');
						$('#btn_show_file').hide();
					}
				}else{
					swal('ไม่สามารถลบไฟล์ได้');
				}
			});
			
		}else{
			
		}
	});
}

function change_type(){
	$('#type_name').val($('#type_id :selected').text());
	var loan_type_id = $("#loan_type_choose").find(':selected').data('loan_type_id');
	$("#loan_type_select option").prop("hidden", true);
	$("#loan_type_select option[data-loan_type_id='" + loan_type_id + "']").prop("hidden", false);
	$("#loan_type_select option[value='']").prop("hidden", false);
	$("#loan_type_select").val("");
}

async function edit_loan(loan_id , loan_type_id, loan_type){
	$("#loan_type_choose").val(loan_type_id);
	change_type();
	$("#loan_type_select").val(loan_type);
	$('#deduct_insurance').prop('readonly', true);
	await change_modal();
	// get_max_period();
	// get_max_loan_amount();
	// get_money_use_balance();
	// get_money_use_balance_baht();
	 $.post( base_url+"/loan/ajax_get_loan_data",
			{	
				loan_id: loan_id
			}
			, function(result){
				var obj = JSON.parse(result);
				var type_deduct = obj.coop_loan.type_deduct;
				if(type_deduct == '2'){
					$('#type_deduct_2').attr('checked', true);
				}else{
					$('#type_deduct_1').attr('checked', true);
				}
				var transfer_type = obj.coop_loan.transfer_type;
				//console.log(transfer_type);
				//console.log(obj);
				//console.log('period_amount='+obj.coop_loan.period_amount);
				//console.log('period_amount_bath='+obj.coop_loan.period_amount_bath);
				$('.transfer_type').attr('checked', false);
				$('#transfer_type_'+transfer_type).attr('checked', true);
				$('#transfer_bank_account_id').val(obj.coop_loan.transfer_bank_account_id);
				$('#transfer_bank_id').val(obj.coop_loan.transfer_bank_id);
				$('#transfer_account_id').val(obj.coop_loan.transfer_account_id);
				choose_transfer_type();
				
				$('#loan_id').val(loan_id);
				$('#petition_number').val(obj.coop_loan.petition_number);
				$('#loan_amount').val(obj.coop_loan.loan_amount);
				$('#loan').val(obj.coop_loan.loan_amount);
				$('#salary').val(obj.coop_loan.salary);
				$('#loan_reason').val(obj.coop_loan.loan_reason);
				$('#interest_per_year').val(obj.coop_loan.interest_per_year);
				$('#period_amount').val(obj.coop_loan.period_amount);
				$('#period_amount_bath').val(obj.coop_loan.period_amount_bath);
				$('#date_start_period').val(obj.coop_loan.date_start_period);
				$('#date_start_period_label').val(obj.coop_loan.date_start_period);
				$('#date_period_1').val(obj.coop_loan.date_period_1);
				$('#money_period_1').val(obj.coop_loan.money_period_1);
				$('#date_period_2').val(obj.coop_loan.date_period_2);
				$('#money_period_2').val(obj.coop_loan.money_period_2);
				$('#period_type').val(obj.coop_loan.period_type);
				$('#period').val(obj.coop_loan.period_amount);
				$('#period_old').val(obj.coop_loan.period_amount);
				$('#day').val(obj.coop_loan.day_start);
				$('#month').val(obj.coop_loan.month_start);
				$('#year').val(obj.coop_loan.year_start);
				$('#pay_type').val(obj.coop_loan.pay_type);
				$('#contract_number').val(obj.coop_loan.contract_number);
				$('#interest').val(obj.coop_loan.interest_per_year);

				$('#is_compromise').val(obj.is_compromise);
				if(obj.coop_loan.contract_number!=''){
					$('.contract_number').show();
				}
				if(obj.coop_loan.loan_status == '1'){
					$('#submit_button').html('บันทึกการกู้เงิน');
				}else{
					$('#submit_button').html('บันทึกคำร้อง');
				}
				var date_receive_money_arr = obj.coop_loan_deduct_profile.date_receive_money.split('-');
				var date_receive_money = date_receive_money_arr[2]+'/'+date_receive_money_arr[1]+'/'+(parseInt(date_receive_money_arr[0])+543);
				$('#date_receive_money').val(date_receive_money);
				$('#date_first_period').val(obj.coop_loan_deduct_profile.date_first_period);
				$('#first_interest').val(obj.coop_loan_deduct_profile.first_interest);
				$('#estimate_receive_money').val(obj.coop_loan_deduct_profile.estimate_receive_money);
				
				
				$('.prev_loan_checkbox').attr('checked',false);
				$('.prev_loan_amount').val('');
				for(var key in obj.coop_loan_prev_deduct){
					$('.prev_loan_checkbox').each(function(){
						if(obj.coop_loan_prev_deduct[key].ref_id == $(this).attr('ref_id') && obj.coop_loan_prev_deduct[key].data_type == $(this).attr('data_type')){
							var index = $(this).attr('attr_index');
							$(this).attr('checked',true);
							if(obj.coop_loan_prev_deduct[key].pay_type == 'principal'){
								$('#prev_loan_pay_type_1_'+index).attr('checked',true);
								$('#prev_loan_pay_type_2_'+index).attr('checked',false);
							}else if(obj.coop_loan_prev_deduct[key].pay_type == 'all'){
								$('#prev_loan_pay_type_1_'+index).attr('checked',false);
								$('#prev_loan_pay_type_2_'+index).attr('checked',true);
							}
							$('#prev_loan_amount_'+index).val(addCommas(obj.coop_loan_prev_deduct[key].pay_amount));
							
						}
					});
				}
				change_prev_loan_pay_type();
				
				for(var key in obj.coop_loan_guarantee){
					//console.log(obj.coop_loan_guarantee[key].guarantee_type);
					$('#guarantee_'+obj.coop_loan_guarantee[key].guarantee_type).attr('checked','checked');
					$('.guarantee_'+obj.coop_loan_guarantee[key].guarantee_type).removeAttr('disabled');
					$('#guarantee_amount_'+obj.coop_loan_guarantee[key].guarantee_type).val(obj.coop_loan_guarantee[key].amount);
					$('#guarantee_price_'+obj.coop_loan_guarantee[key].guarantee_type).val(obj.coop_loan_guarantee[key].price);
					$('#guarantee_other_price_'+obj.coop_loan_guarantee[key].guarantee_type).val(obj.coop_loan_guarantee[key].other_price);
				}
				var i=1;
				for(var key in obj.coop_loan_guarantee_person){
					console.log("CREATE : ", obj.coop_loan_guarantee_person[key].guarantee_person_id);
					$('#guarantee_person_id_'+i).val(obj.coop_loan_guarantee_person[key].guarantee_person_id);
					$('#guarantee_person_name_'+i).val(obj.coop_loan_guarantee_person[key].firstname_th+" "+obj.coop_loan_guarantee_person[key].lastname_th);
					$('#guarantee_person_dep_'+i).val(obj.coop_loan_guarantee_person[key].mem_group_name);
					$('#guarantee_person_contract_number_'+i).val(obj.coop_loan_guarantee_person[key].guarantee_person_contract_number);
					$('#guarantee_person_amount_'+i).val(obj.coop_loan_guarantee_person[key].guarantee_person_amount);
					if(obj.coop_loan_guarantee_person[key].count_guarantee == '0'){
						var text_count_guarantee = obj.coop_loan_guarantee_person[key].count_guarantee;
					}else{
						var text_count_guarantee = '<a style="cursor:pointer" onclick="get_guarantee_person_data(\''+obj.coop_loan_guarantee_person[key].guarantee_person_id+'\')">'+obj.coop_loan_guarantee_person[key].count_guarantee+'</a>';
					}
					$('#count_guarantee_'+i).html(text_count_guarantee);
					choose_guarantee(i)
					$('#guarantee_1').attr('checked',true);

					$('#btn_delete_'+i).show();
					$('#search_member_loan_modal').modal('hide');
					$('.guarantee_person_'+i).removeAttr('disabled');
					$('.guarantee_1').removeAttr('disabled');

					i++;
				}
				
				if(obj.coop_loan_guarantee_real_estate != null){
					$('#real_estate_position_1').val(obj.coop_loan_guarantee_real_estate.real_estate_position_1);				
					$('#real_estate_position_2').val(obj.coop_loan_guarantee_real_estate.real_estate_position_2);
					$('#province_id').val(obj.coop_loan_guarantee_real_estate.province_id);
					change_province('province_id','amphure','amphur_id','district','district_id',obj.coop_loan_guarantee_real_estate.amphur_id,obj.coop_loan_guarantee_real_estate.district_id);
					//$('#amphur_id').val(obj.coop_loan_guarantee_real_estate.amphur_id);
					//$('#district_id').val(obj.coop_loan_guarantee_real_estate.district_id);
					$('#land_number').val(obj.coop_loan_guarantee_real_estate.land_number);
					$('#survey_page').val(obj.coop_loan_guarantee_real_estate.survey_page);
					$('#deed_number').val(obj.coop_loan_guarantee_real_estate.deed_number);
					$('#deed_book').val(obj.coop_loan_guarantee_real_estate.deed_book);
					$('#deed_page').val(obj.coop_loan_guarantee_real_estate.deed_page);
					$('#rai').val(obj.coop_loan_guarantee_real_estate.rai);
					$('#ngan').val(obj.coop_loan_guarantee_real_estate.ngan);
					$('#tarangwah').val(obj.coop_loan_guarantee_real_estate.tarangwah);
				}
				var txt_file_attach = '<table width="100%">';
				var i=1;
				for(var key in obj.coop_loan_file_attach){
					txt_file_attach += '<tr class="file_row" id="file_'+obj.coop_loan_file_attach[key].id+'">\n';
					//txt_file_attach += '<td align="center" width="10%">'+i+'. </td>\n';
					txt_file_attach += '<td><a href="'+base_url+'/assets/uploads/loan_attach/'+obj.coop_loan_file_attach[key].file_name+'" target="_blank">'+obj.coop_loan_file_attach[key].file_old_name+'</a></td>\n';
					txt_file_attach += '<td style="color:red;font-size: 20px;cursor:pointer;" align="center" width="10%"><span class="icon icon-ban" onclick="del_file(\''+obj.coop_loan_file_attach[key].id+'\')"></span></td>\n';
					txt_file_attach += '</tr>\n';
					i++;
				}
				txt_file_attach += '</table>';
				$('#show_file_space').html(txt_file_attach);
				if(i>1){
					$('#btn_show_file').show();
				}
				cal();				
			});
	 //alert(loan_type);		
	
	 $('#normal_loan').modal('show');
 }
 function send_debt_settlement(loan_id){
	 swal({
        title: "",
        text: "ท่านต้องการสร้างสัญญากู้ใหม่ให้แก่ผู้ค้ำประกันใช่หรือไม่?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
			document.location.href = base_url+'loan/debt_settlement/'+loan_id;
        } else {
			
        }
    });
 }
 function print_estimate(){
	var member_id = $('#member_id').val();
	var loan_amount = $('#loan').val();
	var deduct_pay_prev_loan = $('#deduct_pay_prev_loan').val();
	var deduct_share = $('#deduct_share').val();
	var deduct_blue_deposit = $('#deduct_blue_deposit').val();
	var deduct_insurance = $('#deduct_insurance').val();
	var deduct_person_guarantee = $('#deduct_person_guarantee').val();
	var deduct_loan_fee = $('#deduct_loan_fee').val();

	var second_summonth = $('#second_summonth').val();
	var pay_per_month = $('#first_pay').val();
	if(second_summonth  = '31'){
		pay_per_month =  $('#second_pay').val();
	 }else{
		pay_per_month =   $('#first_pay').val();
	 }
	var date_receive_money = $('#date_receive_money').val();
	var date_first_period_label = $('#date_first_period_label').val();
	var first_interest = $('#first_interest').val();
	var estimate_receive_money = $('#estimate_receive_money').val();
	var pay_type = $('#pay_type').val();
	var buy_s_s_o_k = $('#buy_s_s_o_k').val();
	var buy_ch_s_o = $('#buy_ch_s_o').val();
	var buy_s_o_s_p = $('#buy_s_o_s_p').val();
	var buy_share = $('#buy_share').val();
	var deduct_loan_other_buy = $('#deduct_loan_other_buy').val();
	var param = "member_id="+member_id+"&loan_amount="+loan_amount+"&deduct_pay_prev_loan="+deduct_pay_prev_loan+"&deduct_share="+deduct_share+"&deduct_blue_deposit="+deduct_blue_deposit+"&deduct_insurance="+deduct_insurance+"&deduct_person_guarantee="+deduct_person_guarantee+"&deduct_loan_fee="+deduct_loan_fee+"&pay_per_month="+pay_per_month+"&date_receive_money="+date_receive_money+"&date_first_period_label="+date_first_period_label+"&first_interest="+first_interest+"&estimate_receive_money="+estimate_receive_money+"&pay_type="+pay_type+"&buy_s_s_o_k="+buy_s_s_o_k+"&buy_ch_s_o="+buy_ch_s_o+"&buy_s_o_s_p="+buy_s_o_s_p+"&buy_share="+buy_share+"&deduct_loan_other_buy="+deduct_loan_other_buy
	window.open(base_url+'report_loan_data/coop_report_loan_deduct_tmp?'+param, '_blank');
 }
 function removeCommas(str) {
	str = str || "";
    return(str.replace(/,/g,''));
}
function addCommas(x){
	x = x || "";
  	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function check_share(){
	
}
function check_loan_deduct(){
		var loan_type = $('#loan_type').val();
		var member_id = $('#member_id').val();
		var loan_amount = removeCommas($('#loan_amount').val());
		var deduct_pay_prev_loan = removeCommas($('#deduct_pay_prev_loan').val());
		var prev_checkbox_array = [];
		var prev_data_type_array = [];
		var prev_pay_type_array = [];
		$('.prev_loan_checkbox').each(function(){
			var index = $(this).attr('attr_index');
			var data_type = $(this).attr('data_type');
			if($(this).is(':checked')){
				prev_checkbox_array.push($('#prev_loan_checkbox_'+index).val());
				prev_data_type_array.push(data_type);
				if($('#prev_loan_pay_type_1_'+index).is(':checked')){
					prev_pay_type_array.push($('#prev_loan_pay_type_1_'+index).val());
				}else if($('#prev_loan_pay_type_2_'+index).is(':checked')){
					prev_pay_type_array.push($('#prev_loan_pay_type_2_'+index).val());
				}
			}
		});
	
		$.post(base_url+"/loan/get_loan_deduct", 
		{	
			loan_type:loan_type,
			member_id:member_id,
			loan_amount:loan_amount,
			deduct_pay_prev_loan:deduct_pay_prev_loan,
			prev_checkbox_array:prev_checkbox_array,
			prev_pay_type_array:prev_pay_type_array,
			prev_data_type_array:prev_data_type_array
		}
		, function(result){
			obj = JSON.parse(result);
			//console.log(obj);
			$('#deduct_person_guarantee').val(obj.percent_guarantee);
			// $('#deduct_loan_fee').val(obj.loan_fee);
			$('#guarantee_amount_2').val(obj.share_collect);
			$('#guarantee_price_2').val(obj.share_collect_value);
			
				if($('#guarantee_2').is(':checked')){
					$.post(base_url+"/loan/get_share_or_blue_acc", 
					{	
						loan_type:loan_type,
						member_id:member_id,
						loan_amount:loan_amount
					}
					, function(result){
						if($('#type_deduct_1').is(':checked')){
							$("#deduct_share").val(addCommas(result));
							$("#deduct_blue_deposit").val("");
						}else{
							$("#deduct_share").val("");
							$("#deduct_blue_deposit").val(addCommas(result));
						}
						change_prev_loan_pay_type();
						cal_estimate_money();
						check_life_insurance();
					});
				}else{
					$('#deduct_share').val('');
					change_prev_loan_pay_type();
					cal_estimate_money();
					check_life_insurance();
				}
		});
		$('#updatetimestamp').val($('#datenow_is').val());
}
function update_salary(){
	update_income();
	update_expenses();
	$.post(base_url+"/loan/update_salary", 
	{	
		member_id: $('#member_id').val(),
		salary: $('#update_salary').val(),
		other_income: $('#update_other_income').val()
	}
	, function(result){
		close_modal('update_salary_modal');
	});
}

function update_income(){
	$('.income').each(function(){
		var income_id = $(this).data("key");
		var income_value = numeral($(this).val()).value();
		$.post(base_url+"/loan/update_income", 
		{	
			member_id: $('#member_id').val(),
			income_id: income_id,
			income_value: income_value
		}
		, function(result){
			// console.log("update !!!");
		});
	});

}

function update_expenses (){
	$('.expenses').each(function(){
		var expenses_id = $(this).data("key");
		var expenses_value = numeral($(this).val()).value();
		$.post(base_url+"/loan/update_expenses", 
		{	
			member_id: $('#member_id').val(),
			expenses_id: expenses_id,
			expenses_value: expenses_value
		}
		, function(result){
			// console.log("update !!!");
		});
	});
}

function change_prev_loan_pay_type(){
	//@start หายอดหักกลบ กรณีมีการเปลี่ยนแปลงวันที่ทำรายการได้

	$.post(base_url+"/loan/check_prev_loan",
	{
		member_id: $('#member_id').val(),
		createdatetime: $('#createdatetime').val()
	}
	, function(result) {
			var obj = result;
			for (var key in obj.prev_loan_active) {
				$('.prev_loan_checkbox').each(function () {
					if (obj.prev_loan_active[key].ref_id == $(this).attr('ref_id')) {
						var index = $(this).attr('attr_index');
						var prev_loan_total = obj.prev_loan_active[key].prev_loan_total;
						var principal_without_finance_month = obj.prev_loan_active[key].principal_without_finance_month;
						if ($(this).is(':checked')) {
							if ($('#prev_loan_pay_type_1_' + index).is(':checked')) {
								console.log("principal_without_finance_month_", $('#principal_without_finance_month_' + index).val());
								$('#prev_loan_amount_' + index).val($('#principal_without_finance_month_' + index).val());
							} else if ($('#prev_loan_pay_type_2_' + index).is(':checked')) {
								console.log("prev_loan_total", prev_loan_total);
								$('#prev_loan_amount_' + index).val(addCommas(principal_without_finance_month));
								$("input[name='prev_loan[" + index + "][interest]']").val(obj.prev_loan_active[key].interest);
								$('#prev_loan_total_' + index).val(addCommas(prev_loan_total));
							}
							$('#prev_loan_interest_' + index).val(obj.prev_loan_active[key].interest);
							// $('#prev_loan_amount_' + index).val(obj.prev_loan_active[key].prev_loan_total);
							sum_prev_loan_amount(key);
							$("input[type='text'][data-loan-id='"+$(this).attr('ref_id')+"']").removeClass("expenses");
							$("input[type='text'][data-loan-id='"+$(this).attr('ref_id')+"']").addClass("line-through");
						} else {
							$('#prev_loan_amount_' + index).val('');
							$("input[type='text'][data-loan-id='"+$(this).attr('ref_id')+"']").addClass("expenses");
							$("input[type='text'][data-loan-id='"+$(this).attr('ref_id')+"']").removeClass("line-through");
						}
					}
					sum_income();
					sum_expenses();
					cal_estimate_money();
				});
				//@end หายอดหักกลบ กรณีมีการเปลี่ยนแปลงวันที่ทำรายการได้

				// $('.prev_loan_checkbox').each(prev_loan_checkbox);

				cal_prev_loan();
				check_deduct_person_guarantee();
				check_life_insurance();
				// deduct_fund();
				// deduct_bank_fee();
			}
	});

}

function prev_loan_checkbox(n, obj){
	var index = $(this).attr('attr_index');
	console.log("index",index);
	if($("#prev_loan_checkbox_"+index).is(':checked')){
		if($("#prev_loan_pay_type_1_"+index).is(':checked')){
			var principal = parseFloat( removeCommas($('#principal_without_finance_month_'+index).val()) );
			var interest = parseFloat( removeCommas($("input[name='prev_loan["+index+"][interest]']").val()) );
			// console.log('#principal_without_finance_month_'+index, principal);
			// console.log("prev_loan["+index+"][interest]", interest);
			var total = principal;
			console.log("prev_loan_checkbox", total);
			$('#prev_loan_amount_'+index).val(addCommas(total));
			var loan_old_amount = principal;
			var loan_new_amount = parseFloat(removeCommas( $("#loan").val() ));
			var percent_fee = 0.1;
			var fee = window.fee(loan_old_amount, loan_new_amount, percent_fee);
			$("input[name='prev_loan["+index+"][fee]']").val(fee);
		}else{
			var principal = parseFloat( removeCommas($('#principal_without_finance_month_'+index).val()) );
			var interest = parseFloat( removeCommas($("input[name='prev_loan["+index+"][interest]']").val()) );
			// console.log('#principal_without_finance_month_'+index, principal);
			// console.log("prev_loan["+index+"][interest]", interest);
			var total = principal + interest;
	
			$('#prev_loan_amount_'+index).val(addCommas(total));
			$("input[name='prev_loan["+index+"][fee]']").val("");
		}
	}else{
		$('#prev_loan_amount_'+index).val("");
		$("input[name='prev_loan["+index+"][fee]']").val("");
	}
	
}

function fee(loan_old_amount, loan_new_amount, percent_fee){
	loan_new_amount = loan_new_amount || 0;
	var fee = Math.round((Math.abs((loan_new_amount-loan_old_amount))*percent_fee/100)) 
	return (fee < 20) ? 20 : fee;
}

function cal_prev_loan(){
	var deduct_pay_prev_loan = 0;
	$('.prev_loan_amount').each(function(){
		var index = $(this).attr('attr_index');
		if($('#prev_loan_checkbox_'+index).is(':checked') && $(this).val()!=''){
			deduct_pay_prev_loan += parseFloat(removeCommas($(this).val()));
		}
	});
	deduct_pay_prev_loan = addCommas(deduct_pay_prev_loan);
	$('#deduct_pay_prev_loan').val(deduct_pay_prev_loan);
	cal_estimate_money();
}
function choose_transfer_type(){
	if($('#transfer_type_2').is(':checked')){
		$('.transfer_bank_id').show();
		$('.transfer_account_id').hide();
	}else if($('#transfer_type_1').is(':checked')){
		$('.transfer_bank_id').hide();
		$('.transfer_account_id').show();
	}else{
		$('.transfer_bank_id').hide();
		$('.transfer_account_id').hide();
	}
}
function change_province(id, id_to, id_input_amphur, district_space, id_input_district, amphur_value='',district_value=''){
    var province_id = $('#'+id).val();
    $.ajax({
        method: 'POST',
        url: base_url+'manage_member_share/get_amphur_list',
        data: {
            province_id : province_id,
            id_input_amphur : id_input_amphur,
            district_space : district_space,
            id_input_district : id_input_district
        },
        success: function(msg){
            $('#'+id_to).html(msg);
			if(amphur_value != ''){
				$('#'+id_input_amphur).val(amphur_value);
				change_amphur(id_input_amphur,district_space,id_input_district,district_value);
			}
        }
    });
}
function change_amphur(id, id_to, id_input_district, district_value=''){
    var amphur_id = $('#'+id).val();
    $.ajax({
        method: 'POST',
        url: base_url+'manage_member_share/get_district_list',
        data: {
            amphur_id : amphur_id,
            id_input_district : id_input_district
        },
        success: function(msg){
            $('#'+id_to).html(msg);
			if(district_value != ''){
				$('#'+id_input_district).val(district_value);
			}
        }
    });
}

function check_deduct_person_guarantee(){
	var loan_type = $('#loan_type').val();
	var member_id = $('#member_id').val();
	var loan_amount = removeCommas($('#loan_amount').val());
	var deduct_pay_prev_loan = removeCommas($('#deduct_pay_prev_loan').val());
	var prev_checkbox_array = [];
	var prev_data_type_array = [];
	var prev_pay_type_array = [];
	$('.prev_loan_checkbox').each(function(){
		var index = $(this).attr('attr_index');
		var data_type = $(this).attr('data_type');
		if($(this).is(':checked')){
			prev_checkbox_array.push($('#prev_loan_checkbox_'+index).val());
			prev_data_type_array.push(data_type);
			if($('#prev_loan_pay_type_1_'+index).is(':checked')){
				prev_pay_type_array.push($('#prev_loan_pay_type_1_'+index).val());
			}else if($('#prev_loan_pay_type_2_'+index).is(':checked')){
				prev_pay_type_array.push($('#prev_loan_pay_type_2_'+index).val());
			}
		}
	});

	$.post(base_url+"/loan/get_loan_deduct", 
	{	
		loan_type:loan_type,
		member_id:member_id,
		loan_amount:loan_amount,
		deduct_pay_prev_loan:deduct_pay_prev_loan,
		prev_checkbox_array:prev_checkbox_array,
		prev_pay_type_array:prev_pay_type_array,
		prev_data_type_array:prev_data_type_array
	}
	, function(result){
		obj = JSON.parse(result);
		//console.log(obj);
		$('#deduct_person_guarantee').val(obj.percent_guarantee);
		// $('#deduct_loan_fee').val(obj.loan_fee);
		$('#guarantee_amount_2').val(obj.share_collect);
		$('#guarantee_price_2').val(obj.share_collect_value);
		
	});
}

$('#member_loan_search').click(function(){
	if($('#member_search_list').val() == '') {
		swal('กรุณาเลือกรูปแบบค้นหา','','warning');
	} else if ($('#member_search_text').val() == ''){
		swal('กรุณากรอกข้อมูลที่ต้องการค้นหา','','warning');
	} else {
		$.ajax({
			url: base_url+"ajax/search_member_by_type_jquery",
			method:"post",  
			data: {
				search_text : $('#member_search_text').val(), 
				search_list : $('#member_search_list').val()
			},  
			dataType:"text",  
			success:function(data) {
				$('#result_member_search').html(data);  
			}  ,
			error: function(xhr){
				console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			}
		});  
	}
	
});

$(document).ready(function(){
	$(".maxlength_number_decimal").attr('maxlength','15');
});

//ระบบประกันชีวิต
function check_life_insurance(excel=''){
		var member_id = $('#member_id').val();
		var loan_amount = removeCommas($('#loan_amount').val());
		var date_receive_money = $('#date_receive_money').val();
		var cremation_all_total = $('#cremation_all_total').val();
		var loan_id = $('#loan_id').val();
		var blue_deposit_loan = ($('#deduct_blue_deposit').val() == '')?0:removeCommas($('#deduct_blue_deposit').val());
		var buy_share =  ($('#buy_share').val() == '')?0:removeCommas($('#buy_share').val());
		var deduct_share =  ($('#deduct_share').val() == '')?0:removeCommas($('#deduct_share').val());
		var share_loan = parseFloat(buy_share)+parseFloat(deduct_share);
		var loan_type = $('#loan_type').val();
		//var loan_type = $("#normal_loan").find('.modal-body #loan_type').val();
		//alert(loan_type);	
		//alert($('#loan_type').val());	
		var prev_checkbox_array = [];
		var prev_data_type_array = [];
		$('.prev_loan_checkbox').each(function(){
			var index = $(this).attr('attr_index');
			var data_type = $(this).attr('data_type');
			if($(this).is(':checked')){
				prev_checkbox_array.push($('#prev_loan_checkbox_'+index).val());
				prev_data_type_array.push(data_type);
			}
		});		
		
		$.post(base_url+"/loan/get_life_insurance", 
		{	
			member_id:member_id,
			loan_amount:loan_amount,
			date_receive_money:date_receive_money,
			cremation_all_total:cremation_all_total,
			loan_id:loan_id,
			blue_deposit_loan:blue_deposit_loan,
			share_loan:share_loan,
			prev_checkbox_array:prev_checkbox_array,
			prev_data_type_array:prev_data_type_array,
			excel:excel,
			loan_type: loan_type
		}
		, function(result){
			obj = JSON.parse(result);
			//console.log(obj);			
			if(obj.check_life_insurance != '1'){
				$('.cremation_show').hide();
				$('#insurance_old').html('');	
				$('#insurance_new').html('');						
				$('#insurance_new_input').val('');		
				$('#insurance_old_input').val('');						
				$('#deduct_insurance').val('');
				$('#insurance_year').val('');
				$('#insurance_date').val('');
				$('#insurance_amount').val('');
				$('#insurance_premium').val('');
			}else{
				$('.cremation_show').show();
				$('#insurance_old').html(addCommas(obj.insurance_old));	
				$('#insurance_new').html(addCommas(obj.insurance_new));						
				$('#insurance_new_input').val(addCommas(obj.insurance_new));		
				$('#insurance_old_input').val(addCommas(obj.insurance_old));						
				$('#deduct_insurance').val(addCommas(obj.deduct_insurance));
				$('#insurance_year').val(obj.year_receive_money);
				$('#insurance_date').val(obj.start_date_protection);
				$('#insurance_amount').val(obj.additional_insured);
				$('#insurance_premium').val(obj.deduct_insurance);
			}
			//console.log(obj);
			if(excel == 'excel'){
				var data_array = JSON.stringify(obj);
				document.location.href = base_url+'loan/calc_insurance_csv?data_array='+data_array;
			}
			
		});
}

function change_cremation_type(){
	var cremation_all = 0;
	$('.cremation_checkbox').each(function(){
		var index = $(this).attr('attr_index');		
		var attr_data = $(this).attr('attr_data');		
		if($(this).is(':checked')){
			cremation_all += parseFloat(attr_data);
		}else{
			
		}		
		
	});
	
	$('#cremation_all_total').val(cremation_all);
	check_life_insurance();
}

function edit_life_insurance(){
		var member_id = $('#member_id').val();
		var loan_amount = removeCommas($('#loan_amount').val());
		var date_receive_money = $('#date_receive_money').val();
		var cremation_all_total = $('#cremation_all_total').val();
		var loan_id = $('#loan_id').val();
		var blue_deposit_loan = ($('#deduct_blue_deposit').val() == '')?0:removeCommas($('#deduct_blue_deposit').val());
		var buy_share =  ($('#buy_share').val() == '')?0:removeCommas($('#buy_share').val());
		var deduct_share =  ($('#deduct_share').val() == '')?0:removeCommas($('#deduct_share').val());
		var share_loan = parseFloat(buy_share)+parseFloat(deduct_share);
		var loan_type = $('#loan_type').val();
		//alert(loan_type);
		//console.log(loan_type);

		var prev_checkbox_array = [];
		var prev_data_type_array = [];
		$('.prev_loan_checkbox').each(function(){
			var index = $(this).attr('attr_index');
			var data_type = $(this).attr('data_type');
			if($(this).is(':checked')){
				prev_checkbox_array.push($('#prev_loan_checkbox_'+index).val());
				prev_data_type_array.push(data_type);
			}
		});		
		
		$.post(base_url+"/loan/get_life_insurance", 
		{	
			member_id:member_id,
			loan_amount:loan_amount,
			date_receive_money:date_receive_money,
			cremation_all_total:cremation_all_total,
			loan_id:loan_id,
			blue_deposit_loan:blue_deposit_loan,
			share_loan:share_loan,
			prev_checkbox_array:prev_checkbox_array,
			prev_data_type_array:prev_data_type_array,
			loan_type: loan_type
		}
		, function(result){
			obj = JSON.parse(result);
			//console.log(obj);
			
			$('#insurance_old').html(addCommas(obj.insurance_old));	
			$('#insurance_new').html(addCommas(obj.insurance_new));	
			$('#insurance_new_input').val(addCommas(obj.insurance_new));		
			$('#insurance_old_input').val(addCommas(obj.insurance_old));			
			if(loan_id != ''){
				if(obj.check_life_insurance != '1'){
					$('.cremation_show').hide();
					$('#deduct_insurance').val('');
					$('#insurance_year').val('');
					$('#insurance_date').val('');
					$('#insurance_amount').val('');
					$('#insurance_premium').val('');
				}else{
					$('.cremation_show').show();
					$('#deduct_insurance').val(addCommas(obj.deduct_insurance));
					if(obj.row_life_insurance != null){
						$('#insurance_year').val(obj.row_life_insurance.insurance_year);
						$('#insurance_date').val(obj.row_life_insurance.insurance_date);
						$('#insurance_amount').val(obj.row_life_insurance.insurance_amount);
						$('#insurance_premium').val(obj.row_life_insurance.insurance_premium);
					}
					
					for(var key in obj.row_cremation_type){
						$('.cremation_checkbox').each(function(){
							var index = $(this).attr('attr_index');	
							if(index == obj.row_cremation_type[key].import_cremation_type){
								$('#cremation_type_'+index).attr('checked',true);									
							}		
						})
					}
					check_ch_s_o();
					check_s_s_o_k();
				}	
			}
			
		});
}

$(".btn-excel").click(function(e){
	check_life_insurance('excel');
});	

$("#cal_period_btn").click(function(e){
	var loan_id = $('#loan_id').val();
	if(loan_id != ''){
		edit_life_insurance();
	}else{
		check_life_insurance();
	}
	var str = " "; 
	if($("#period_type").val() == '1'){
		str += "งวด";  
		// $("#period_amount_bath").hide();
		// $("#period").show();
	}else{
		str += "บาท";		
		// $("#period_amount_bath").show();
		// $("#period").hide();	
	}
	$("#type_period").text(str);
	$('#deduct_insurance').prop('readonly', true);
});	

$("#buy_s_s_o_k").blur(function(e){
	var buy_s_s_o_k = parseFloat(removeCommas($(this).val()));
	check_s_s_o_k();
});

$("#buy_ch_s_o").blur(function(e){
	var buy_ch_s_o = parseFloat(removeCommas($(this).val()));	
	check_ch_s_o();
});

function check_s_s_o_k(){
	var cremation_2 = parseFloat($('#cremation_import_2').val());
	var buy_s_s_o_k = parseFloat(removeCommas($("#buy_s_s_o_k").val()));
	if(cremation_2 > 0){
		cremation_amount_2 = cremation_2;
	}else if(buy_s_s_o_k > 0){
		cremation_amount_2 = 600000;
		
	}else{
		cremation_amount_2 = 0;
	}
	$('#cremation_amount_2').val(cremation_amount_2);
	$('#text_s_s_o_k').html(addCommas(cremation_amount_2));
	$('input').attr('attr_data', cremation_amount_2);
}

function check_ch_s_o(){
	var cremation_1 = parseFloat($('#cremation_import_1').val());
	var buy_ch_s_o = parseFloat(removeCommas($("#buy_ch_s_o").val()));
	if(cremation_1 > 0){
		cremation_amount_1 = cremation_1;
	}else if(buy_ch_s_o > 0){
		cremation_amount_1 = 600000;		
	}else{
		cremation_amount_1 = 0;	
	}
	$('#cremation_amount_1').val(cremation_amount_1);
	$('#text_ch_s_o').html(addCommas(cremation_amount_1));
	$('input').attr('attr_data', cremation_amount_1);
}	

$("#date_receive_money").change(function(e){
	check_life_insurance();
});

function check_salary_balance(){

};
$("body").on('change', '.is_numeric', function(){    // 2nd (B)
	var val = numeral($(this).val()).value();
	
	val = numeral(val).format('0,0.00');
	console.log("is_numeric", val);
	$(this).val(val);
});

$("body").on('change', '.deduct_loan_fee', function(){  
	var total = 0;
	$('.deduct_loan_fee').each(function(){
		console.log("deduct_loan_fee", $(this).val());
		total += numeral($(this).val()).value();
	})
	var val = numeral(total).format('0,0.00');
	$("#deduct_loan_fee").val(val);
	cal_estimate_money();
});

function sum_prev_loan_amount(index){
	console.log("call sum_prev_loan_amount", index);
	var prev_loan_principal = numeral($("#prev_loan_principal_"+index).val()).value();
	var prev_loan_interest = numeral($("#prev_loan_interest_"+index).val()).value();
	console.log("prev_loan_principal", prev_loan_principal);
	console.log("prev_loan_interest", prev_loan_interest);
	var total = prev_loan_principal + prev_loan_interest;
	$("#prev_loan_amount_"+index).val(numeral(total).format('0,0.00'));
	cal_prev_loan();
}

$("body").on('change', '.prev_loan_checkbox', function(){
	var index = $(this).attr('attr_index');
	sum_prev_loan_amount(index)
});

$("body").on('change', '.prev_principal', function(){
	var index = $(this).attr('attr_index');
	sum_prev_loan_amount(index)
});
$("body").on('change', '.prev_interest', function(){
	var index = $(this).attr('attr_index');
	sum_prev_loan_amount(index)
});

function get_max_period(){
	var loan_type_select = $("#loan_type_select").val();
	$.ajax({
		url:base_url+"/loan/get_data_in_term_loan?loan_type="+loan_type_select+"&req_name=max_period",
		method:"get",
		dataType:"text",
		success:function(data)
		{
			$("#period").val(data);
		}
   });
}
function get_money_use_balance(){
	var loan_type_select = $("#loan_type_select").val();
	$.ajax({
		url:base_url+"/loan/get_data_in_term_loan?loan_type="+loan_type_select+"&req_name=money_use_balance",
		method:"get",
		dataType:"text",
		success:function(data)
		{
			$("#money_use_balance").val(data);
		}
   });
}
function get_money_use_balance_baht(){
	var loan_type_select = $("#loan_type_select").val();
	$.ajax({
		url:base_url+"/loan/get_data_in_term_loan?loan_type="+loan_type_select+"&req_name=money_use_balance_baht",
		method:"get",
		dataType:"text",
		success:function(data)
		{
			$("#money_use_balance_baht").val(data);
		}
   });
}
function get_max_loan_amount(){
	var loan_type_select = $("#loan_type_select").val();
	$.ajax({
		url:base_url+"/loan/get_data_in_term_loan?loan_type="+loan_type_select+"&req_name=credit_limit",
		method:"get",
		dataType:"text",
		success:function(data)
		{
			$("#loan_amount").val(numeral(data).format('0,0.00'));
			setTimeout(() => {
				cal();
				re_already_cal();
				cal_guarantee_person();
				check_share();
				check_loan_deduct();
				create_input_garantor();
				cal_estimate_money();
			}, 2000);
		}
   });
}

$("body").on('change', '#update_salary', function(){
	var salary = numeral($("#update_salary").val()).value();
	console.log("update_salary", salary);
	var val = numeral(salary).format('0,0.00');
	$("#salary_amount").val(val);
	baht_salary_balance();
	percent_salary_balance();
	cal_estimate_money();
});
$("body").on('change', '.income', function(){  
	sum_income();
	cal_estimate_money();
});
$("body").on('change', '.expenses', function(){  
	sum_expenses();
	cal_estimate_money();
});

function sum_income(){
	var total = 0;
	$('.income').each(function(){
		total += numeral($(this).val()).value();
	})
	var salary = numeral($("#salary_amount").val()).value();
	var val = numeral(total).format('0,0.00');
	$("#total_income").val(val);
	var html = `<div class="row m-b-1">
		<div class="col-sm-12">
			<div class="form-group">
				<label class="control-label col-sm-6">รวม</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" data-amount="`+numeral(total+salary).format('0,0.00')+`" value="`+numeral(total+salary).format('0,0.00')+`" disabled>
				</div>
			</div>
		</div>
	</div>`;
	$("#total_summary_income").html(html);
}
function sum_expenses(){
	var loan_id_prev = [];
	var total = 0;
	var period_amount_bath = numeral($("#period_amount_bath").val()).value();
	$('.prev_loan_checkbox').each(function(){
		var ref_id = $(this).val();
		if($(this).is(':checked')){
			loan_id_prev.push(ref_id);
		}
	})
	$('.expenses').each(function(){
		
		var loan_id = $(this).data("loan-id")+"";
		if(loan_id_prev.includes(loan_id)){
			
		}else{
			total += numeral($(this).val()).value();
		}
	})
	var val = numeral(total+period_amount_bath).format('0,0.00');
	$("#total_expenses").val(val);

	var html = `<div class="row m-b-1">
		<div class="col-sm-12">
			<div class="form-group">
				<label class="control-label col-sm-6">รวม</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" data-amount="`+val+`" value="`+val+`" disabled>
				</div>
			</div>
		</div>
	</div>`;
	$("#total_summary_expenses").html(html);
}

function baht_salary_balance(){
	var salary = numeral($("#salary_amount").val()).value();
	var total_income = numeral($("#total_income").val()).value();
	var total_expenses = numeral($("#total_expenses").val()).value();
	var remain_amount = salary+total_income-total_expenses;
	if(remain_amount < numeral($("#money_use_balance_baht").val()).value()){
		$("#msg_salary_balance").html("ยอดเงินคงเหลือไม่น้อยกว่า "+numeral($("#money_use_balance_baht").val()).format('0,0')+" บาท");
	}else{
		$("#msg_salary_balance").html("");
	}
	$("#salary_balance").val(numeral(remain_amount).format('0,0.00'));
}

function percent_salary_balance(){
	var salary = numeral($("#salary_amount").val()).value();
	var total_income = numeral($("#total_income").val()).value();
	var total_expenses = numeral($("#total_expenses").val()).value();
	var remain_amount = salary+total_income-total_expenses;
	var percent = remain_amount*100/(salary+total_income);
	if(percent < numeral($("#money_use_balance").val()).value()){
		$("#msg_percent_salary_balance").html("ยอดเงินคงเหลือไม่น้อยกว่าร้อยละ "+numeral($("#money_use_balance").val()).format('0,0')+" ของเงินเดือน");
	}else{
		$("#msg_percent_salary_balance").html("");
	}
	$("#percent_salary_balance").val(numeral(percent).format('0,0.00'));
}

function cal_estimate_money(){
	if($("#loan_amount").val() != ''){
		var estimate_receive_money = parseFloat($("#loan_amount").val().replace(/,/g, ""));
		$('.loan_deduct').each(function(){
			var deduct_amount = $(this).val().replace(/,/g, "");
			if(deduct_amount!='' && deduct_amount > 0){
				estimate_receive_money = parseFloat(estimate_receive_money).toFixed(2) - parseFloat(deduct_amount).toFixed(2);
			}
		});

		$('.deduct_return').each(function(){
			var deduct_return = parseFloat(removeCommas( $(this).val()));
			
			if(deduct_return!='' && deduct_return > 0){
				console.log("ADD", deduct_return);
				estimate_receive_money = parseFloat(estimate_receive_money) + deduct_return;
			}
		});

		if(estimate_receive_money < 0){
			$('#estimate_receive_money').val('0');
		}else{
			$('#estimate_receive_money').val(estimate_receive_money.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
		}
		baht_salary_balance();
		percent_salary_balance();
	}
}

function get_data_from_modal(){
	$("#period_amount_bath").val(numeral($("#calc_money_per_period").val()).format('0,0.00'));
	// $('.period_amount').val($('#max_period').val());
	$('.date_start_period_label').val($('#first_date_period_label').val());
	$('.date_start_period').val($('#first_date_period').val());
	$('#last_date_period').val($('#last_period').val());
	 
	$('#date_period_1').val($('#first_date_period_label').val());
	$('#date_period_2').val($('#second_date_period_label').val());
	$('#money_period_1').val($('#first_pay').val());
	$('#money_period_2').val($('#second_pay').val());
	$('#summonth_period_1').val($('#first_summonth').val());
	$('#summonth_period_2').val($('#second_summonth').val());
	$('#money_per_period').val($('#calc_money_per_period').val());

	$('#date_first_period').val($('#first_date_period').val());
	$('#date_first_period_label').val($('#first_date_period_label').val());
	$('#first_interest').val($('#first_interest_amount').val());

	//create html display อัพเดท รายได้/รายจ่าย
	var html = `<div class="row m-b-1">
		<div class="col-sm-12">
			<div class="form-group">
				<label class="control-label col-sm-6">คำขอกู้เงิน `+$("#type_name").html()+`</label>
				<div class="col-sm-6">
					<input type="text" id="" class="form-control" data-loan-id="" data-amount="`+numeral($("#calc_money_per_period").val()).format('0,0.00')+`" value="`+numeral($("#calc_money_per_period").val()).format('0,0.00')+`" onkeyup="format_the_number_decimal(this)">
				</div>
			</div>
		</div>
	</div>`;
	$("#deduct_new_loan").html(html);

	
	cal_estimate_money();
}

function cal(){
	var date = $('#date_receive_money').val().split('/');
	var day = date[0];
	var month = date[1];
	var year = date[2];
	buy_share();
	$("#period_amount").val($("#period").val().replace(/,/g, ""));
	  $.ajax({
			type: "POST"
			, url: base_url+"/loan/ajax_calculate_loan"
			, data: {
					"ajax" : 1
					, "do" : "cal"
					, "loan" : $("#loan_amount").val().replace(/,/g, "")
					, "pay_period" : $("#pay_period").val()
					, "pay_type" : $("#pay_type").val()
					, "day" : day
					, "month" : month
					, "year" : year
					, "period_type" : $("#period_type").val()
					, "period" : $("#period").val().replace(/,/g, "") //งวด
					, "interest" : 6.25
					, "_time" : Math.random()
					, "loan_type" : $("#loan_type_select").val()
					, "money_period_2" : $("#money_period_2").val().replace(/,/g, "")
					, "period_old" : $("#period_old").val()
					, "period_amount_bath" : $("#period_amount_bath").val().replace(/,/g, "")
					// , "every_day" : $("#every_day").val()
					, "every_day" : "26"
			}
			, async: true
			, success: function(msg) {
				$("#result_wrap").html(msg);
				hide_cal_table(); //ปิดไว้พี่รสปิดส่วนของการแสดงตารางการคำนวณงวดส่ง 2019-02-25
				get_data_from_modal();
				check_salary_balance();

				sum_expenses();
				sum_income();
			}
		});
}

function buy_share(){
	var loan = numeral($('#loan_amount').val()).value();
	var loan_type = $("#loan_type_select").val();
	var member_id = $("#member_id").val();
	$.post(base_url+"/loan/get_buy_share", 
	{	
		loan_type: loan_type,
		loan_amount: loan,
		member_id: member_id
	}
	, function(result){
		obj = result;
		
		var minimum_share_percent = parseFloat(obj.result);
		if(minimum_share_percent > 0){
			$("#buy_share").val( numeral(minimum_share_percent).format('0,0') );
		}else{
			$("#buy_share").val( "0" );
		}
	});
}