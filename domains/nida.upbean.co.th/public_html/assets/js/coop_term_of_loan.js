var base_url = $('#base_url').attr('class');
$( document ).ready(function() {
	edit_setting($('#loan_name_id').val());
	$("#start_date").datepicker({
        prevText : "ก่อนหน้า",
        nextText: "ถัดไป",
        currentText: "Today",
        changeMonth: true,
        changeYear: true,
        isBuddhist: true,
        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        constrainInput: true,
        dateFormat: "dd/mm/yy",
        yearRange: "c-50:c+10",
		startDate: '+0d',
		autoclose: true,
    });
	if ($("#money_per_period").val() !='') {
		document.getElementById("conditions").checked = true;
	}else{
		document.getElementById("conditions").checked = false;
		$('#conditioin_set').attr("style", "display:none");
	}
	
});
function condi() {
	$cb = $('input#conditions');
	if ($cb.prop('checked')==false) {
		$('#conditioin_set').attr("style", "display:none");
	} else {
		$('#conditioin_set').removeAttr("style");
	}
}
function check_form(){
	var text_alert = '';
	if($.trim($('#type_name').val())== ''){
		text_alert += ' - ประเภทการกู้เงิน\n';
	}
	if($.trim($('#interest_rate').val())== ''){
		text_alert += ' - อัตราดอกเบี้ย\n';
	}
	if($.trim($('#prefix_code').val())== ''){
		text_alert += ' - รหัสนำหน้าสัญญา\n';
	}
	
	if(text_alert != ''){
		swal('กรุณากรอกข้อมูลต่อไปนี้',text_alert,'warning');
	}else{
		$('#form_save').submit();
	}
	
}

function del_coop_credit_data(id){	
	swal({
        title: "ท่านต้องการลบข้อมูลนี้ใช่หรือไม่",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ลบ',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {			
			$.ajax({
				url: base_url+'/setting_credit_data/del_coop_credit_data',
				method: 'POST',
				data: {
					'table': 'coop_term_of_loan',
					'id': id,
					'field': 'id'
				},
				success: function(msg){
				  //console.log(msg); return false;
					if(msg == 1){
					  document.location.href = base_url+'setting_credit_data/coop_term_of_loan';
					}else{

					}
				}
			});
        } else {
			
        }
    });
	
}
function add_type(){
	$('#loan_type_modal').modal('show');
}
function save_type(){
	$('#form1').submit();
}
function edit_type(id,type_name,loan_type_status){
	$('#loan_type_id').val(id);
	$('#loan_type').val(type_name);
	if(loan_type_status == '1'){
		$('#loan_type_status').attr('checked',true);
	}else{
		$('#loan_type_status').removeAttr('checked');
	}
}

function del_type(id){	
	swal({
        title: "คุณต้องการที่จะลบ",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ลบ',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
			
			$.ajax({
				url: base_url+'/setting_credit_data/check_use_type',
				method: 'POST',
				data: {
					'id': id
				},
				success: function(msg){
				   //console.log(msg); return false;
					if(msg == 'success'){		
					  document.location.href = base_url+'setting_credit_data/del_loan_type?id='+id;		
					}else{
						swal("ไม่สามารถลบประเภทนี้ได้ \nเนื่องจากได้ตั้งค่าชื่อสินเชื่อสำหรับประเภทนี้แล้ว");
					}
				}
			});		
			
			
        } else {
			
        }
    });
}

function add_loan_name(){
	$('#loan_name_modal').modal('show');
}
function save_loan_name(){
	$('#form2').submit();
}
function edit_loan_name(loan_name_id,loan_type_id,loan_name,loan_name_description,loan_name_status){
	$('#choose_loan_type_id').val(loan_type_id);
	$('#loan_name_id').val(loan_name_id);
	$('#loan_name').val(loan_name);
	$('#loan_name_description').val(loan_name_description);
	
	if(loan_name_status == '1'){
		$('#loan_name_status').attr('checked',true);
	}else{
		$('#loan_name_status').removeAttr('checked');
	}
}
function del_loan_name(id){	
	swal({
        title: "คุณต้องการที่จะลบ",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ลบ',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: true
    },
    function(isConfirm) {
        if (isConfirm) {
			
			$.ajax({
				url: base_url+'/setting_credit_data/check_use_name',
				method: 'POST',
				data: {
					'id': id
				},
				success: function(msg){
				   //console.log(msg); return false;
					if(msg == 'success'){		
					  document.location.href = base_url+'setting_credit_data/del_loan_name?id='+id;		
					}else{
						swal("ไม่สามารถลบประเภทนี้ได้ \nเนื่องจากได้ตั้งค่าเงื่อนไขการกู้เงินสำหรับชื่อสินเชื่อนี้แล้ว");
					}
				}
			});		
			
			
        } else {
			
        }
    });
}

function change_type(data_id){
	$("#type_pdf_id option[value]").remove();
	$("#transfer_pdf_id option[value]").remove();
	$("#append_pdf_id option[value]").remove();
	$("#surety_pdf_id option[value]").remove();
	$("#transfer_surety_pdf_id option[value]").remove();
	$("#type_pdf_condition_id option[value]").remove();
	$.ajax({
		url: base_url+'setting_credit_data/change_loan_type',
		method: 'POST',
		data: {
			'type_id': data_id
		},
		success: function(msg){
		   $('#loan_name_id').html(msg);
		}
	});
		/*-----------------------------รูปแบบหนังสือสัญญา------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': data_id
			},
			success: function(msg){
				$('#type_pdf_id').append("<option value='' selected disabled>กรุณาเลือกหนังสือสัญญา</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#type_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}

		});
		/*------------------------------------------------------------------ */
		/*-----------------------------รูปแบบสัญญาส่งมอบ------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '02'
			},
			success: function(msg){
				$('#transfer_pdf_id').append("<option value='' selected disabled>กรุณาเลือกรูปแบบสัญญาส่งมอบ</option>");
				$('#transfer_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#transfer_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*----------------------------รูปแบบต่อท้ายสัญญา-------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '01'
			},
			success: function(msg){
				$('#append_pdf_id').append("<option value='' selected disabled>กรุณาเลือกต่อท้ายสัญญา</option>");
				$('#append_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#append_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*-----------------------------รูปแบบสัญญาค้ำประกัน------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '00'
			},
			success: function(msg){
				$('#surety_pdf_id').append("<option value='' selected disabled>กรุณาเลือกสัญญาค้ำประกัน</option>");
				$('#surety_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#surety_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*---------------------------รูปแบบสัญญาต่อท้ายค้ำประกัน--------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '09'
			},
			success: function(msg){
				$('#transfer_surety_pdf_id').append("<option value='' selected disabled>กรุณาเลือกสัญญาต่อท้ายค้ำประกัน</option>");
				$('#transfer_surety_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#transfer_surety_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */

		/*-----------------------------รูปแบบหนังสือสัญญา------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': $('#type_id').val()
			},
			success: function(msg){
				$('#type_pdf_condition_id').append("<option value='' selected disabled>กรุณาเลือกหนังสือสัญญา</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#type_pdf_condition_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */

	$('#type_name').val($('#type_id :selected').text());
}
function change_loan_name(){
	$('#loan_name').val($('#loan_name_id :selected').text());
}
$( document ).ready(function() {
	$("#various1").fancybox({
	  'titlePosition'		: 'inside',
	  'transitionIn'		: 'none',
	  'transitionOut'		: 'none',
	}); 


	//class for check input number
	$('.check_number').on('input', function () {
		this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
	});
});
function change_type_id(){
	var type_id = $('#type_id').val();
	document.location.href = '?type_id='+type_id;
}

function change_close_loan(){
	$.ajax({
		url: base_url+'setting_credit_data/change_loan_type',
		method: 'POST',
		data: {
			'type_id': $('#close_loan_type_id').val()
		},
		success: function(msg){
		   $('#close_loan_name_id').html(msg);
		}
	});		
	$('#close_type_name').val($('#close_loan_type_id :selected').text());
}
function change_close_loan_name(){
	$('#close_loan_name').val($('#close_loan_name_id :selected').text());
}
function link_perview(data) {
	if (data == 'type_pdf_id') {
		$.ajax({
			url: base_url+'setting_credit_data/get_link_pdf',
			method: 'POST',
			dataType: 'json',
			data: {
				'data': $('#type_pdf_id').val()
			},
			success: function(msg){
				$('#pdf_preview_type_pdf_id').attr("href",window.location.origin+"/assets/document/"+msg[0]['path_data']);
			}
		});
	}
	if (data == 'transfer_pdf_id') {
		if ($('#transfer_pdf_id').val() != '') {
			$.ajax({
				url: base_url+'setting_credit_data/get_link_pdf',
				method: 'POST',
				dataType: 'json',
				data: {
					'data': $('#transfer_pdf_id').val()
				},
				success: function(msg){
					$('#pdf_preview_transfer_pdf_id').attr("href",window.location.origin+"/assets/document/"+msg[0]['path_data']);
				}
			});
			$('#pdf_preview_transfer_pdf_id').attr('style','color:#3daede')
		} else {
			$('#pdf_preview_transfer_pdf_id').removeAttr('href')
			$('#pdf_preview_transfer_pdf_id').attr('style','color:gray')
		}
	}
	if (data == 'append_pdf_id') {
		if ($('#transfer_pdf_id').val() != '') {
			$.ajax({
				url: base_url+'setting_credit_data/get_link_pdf',
				method: 'POST',
				dataType: 'json',
				data: {
					'data': $('#append_pdf_id').val()
				},
				success: function(msg){
					$('#pdf_preview_append_pdf_id').attr("href",window.location.origin+"/assets/document/"+msg[0]['path_data']);
				}
			});
			$('#pdf_preview_append_pdf_id').attr('style','color:#3daede')
		} else {
			$('#pdf_preview_append_pdf_id').removeAttr('href')
			$('#pdf_preview_append_pdf_id').attr('style','color:gray')
		}
	}
	if (data == 'surety_pdf_id') {
		if ($('#transfer_pdf_id').val() != '') {
			$.ajax({
				url: base_url+'setting_credit_data/get_link_pdf',
				method: 'POST',
				dataType: 'json',
				data: {
					'data': $('#surety_pdf_id').val()
				},
				success: function(msg){
					$('#pdf_preview_surety_pdf_id').attr("href",window.location.origin+"/assets/document/"+msg[0]['path_data']);
				}
			});
			$('#pdf_preview_surety_pdf_id').attr('style','color:#3daede')
		} else {
			$('#pdf_preview_surety_pdf_id').removeAttr('href')
			$('#pdf_preview_surety_pdf_id').attr('style','color:gray')
		}
	}
	if (data == 'transfer_surety_pdf_id') {
		if ($('#transfer_pdf_id').val() != '') {
			$.ajax({
				url: base_url+'setting_credit_data/get_link_pdf',
				method: 'POST',
				dataType: 'json',
				data: {
					'data': $('#transfer_surety_pdf_id').val()
				},
				success: function(msg){
					$('#pdf_preview_transfer_surety_pdf_id').attr("href",window.location.origin+"/assets/document/"+msg[0]['path_data']);
				}
			});
			$('#pdf_preview_transfer_surety_pdf_id').attr('style','color:#3daede')
		} else {
			$('#pdf_preview_transfer_surety_pdf_id').removeAttr('href')
			$('#pdf_preview_transfer_surety_pdf_id').attr('style','color:gray')
		}
	}
	if (data == 'type_pdf_condition_id') {
		$.ajax({
			url: base_url+'setting_credit_data/get_link_pdf',
			method: 'POST',
			dataType: 'json',
			data: {
				'data': $('#type_pdf_condition_id').val()
			},
			success: function(msg){
				$('#pdf_preview_type_pdf_condition_id').attr("href",window.location.origin+"/assets/document/"+msg[0]['path_data']);
			}
		});
	}
}
function edit_setting(){
		/*-----------------------------รูปแบบหนังสือสัญญา------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': $('#type_id').val()
			},
			success: function(msg){
				for (let index = 0; index < msg.length; index++) {
					$('#type_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*-----------------------------รูปแบบสัญญาส่งมอบ------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '02'
			},
			success: function(msg){
				$('#transfer_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#transfer_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*----------------------------รูปแบบต่อท้ายสัญญา-------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '01'
			},
			success: function(msg){
				$('#append_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#append_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*-----------------------------รูปแบบสัญญาค้ำประกัน------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '00'
			},
			success: function(msg){
				$('#surety_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#surety_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */
		/*---------------------------รูปแบบสัญญาต่อท้ายค้ำประกัน--------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': '09'
			},
			success: function(msg){
				$('#transfer_surety_pdf_id').append("<option value='' >ไม่ต้องการ</option>");
				for (let index = 0; index < msg.length; index++) {
					$('#transfer_surety_pdf_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */

		/*-----------------------------รูปแบบหนังสือสัญญา------------------------------------- */
		$.ajax({
			url: base_url+'setting_credit_data/pdf_type',
			method: 'POST',
			dataType: 'json',
			data: {
				'type_id': $('#type_id').val()
			},
			success: function(msg){
				for (let index = 0; index < msg.length; index++) {
					$('#type_pdf_condition_id').append("<option value='"+msg[index]['id']+"'>ฉบับที่ "+(index+1)+" "+msg[index]['details']+"</option>");
				}
			}
		});
		/*------------------------------------------------------------------ */

	$('#type_name').val($('#type_id :selected').text());
}