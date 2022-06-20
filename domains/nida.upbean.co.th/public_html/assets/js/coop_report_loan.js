var base_url = $('#base_url').attr('class');
$( document ).ready(function() {
	$(".mydate").datepicker({
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
		autoclose: true,
	});
});

function change_loan_type(id){
	var link_to = '';
	//if($('#loan_type'+id).val() == '1' || $('#loan_type'+id).val() == '2' || $('#loan_type'+id).val() == '5'){
	//	link_to =  base_url+'/report_loan_data/coop_report_loan_normal_preview';
		//link_to =  base_url+'/report_loan_data/coop_report_loan_normal_excel';
		//link_to = '/coop_report_loan_normal_excel.php';
	//}else{
	//	link_to =  base_url+'/report_loan_data/coop_report_loan_emergent_preview';
		//link_to =  base_url+'/report_loan_data/coop_report_loan_emergent_excel';
		//link_to = '/coop_report_loan_emergent_excel.php';
	//}
	link_to =  base_url+'/report_loan_data/coop_report_loan_emergent_preview';
	$('#form'+id).attr('action', link_to);
}

function check_empty(type){
	var report_date = '';
	var month = '';
	var year = '';
	var loan_type = $('#loan_type'+type).val();
	if(type == '1'){
		report_date = $('#report_date').val();
	}else if(type == '2'){
		month = $('#report_month').val();
		year = $('#report_year').val();
	}else{
		year = $('#report_only_year').val();
	}
	$.ajax({
		 url: base_url+'/report_loan_data/check_report_loan',	
		 method:"post",
		 data:{ 
			 report_date: report_date, 
			 month: month,
			 year: year,
			 loan_type: loan_type
		 },
		 dataType:"text",
		 success:function(data){
			//console.log(data); return false;
			if(data == 'success'){				
				if(month!='' || report_date!=''){
					$('#form'+type).submit();
				}else{
					window.open('coop_report_loan_emergent_preview?loan_type='+loan_type+'&year='+year,'_blank');
					//window.open('coop_report_loan_normal_preview?loan_type='+loan_type+'&year='+year,'_blank');
					//window.open('coop_report_loan_normal_preview?loan_type='+loan_type+'&year='+year+'&second_half=1','_blank');
					
					//window.open('coop_report_loan_normal_excel?loan_type='+loan_type+'&year='+year,'_blank');
					//window.open('coop_report_loan_normal_excel?loan_type='+loan_type+'&year='+year+'&second_half=1','_blank');
				}
			}else{
				$('#alertNotFindModal').appendTo("body").modal('show');
			}
		 }
	});
	
}

function check_loan_person_empty(){
	var month = '';
	var year = '';
	var loan_type = $('#loan_type').val();
	var member_id = $('#member_id').val();
	
	if($('#check_loan_debt').is(':checked')){
		 var check_loan_debt = '1';
	 }else{
		 var check_loan_debt = '';
	 }

	month = $('#report_month').val();
	year = $('#report_year').val();
	
	
	if(member_id.trim() == ''){
		swal("กรุณากรอกรหัสสมาชิก");
	}else if(month !='' && year ==''){
		swal("กรุณาเลือกปี");
	}else{
		$.ajax({
			 url: base_url+'/report_loan_data/check_report_loan_person',	
			 method:"post",
			 data:{ 
				 member_id: member_id,
				 check_loan_debt: check_loan_debt,
				 month: month,
				 year: year,
				 loan_type: loan_type
			 },
			 dataType:"text",
			 success:function(data){
				//console.log(data); return false;
				if(data == 'success'){				
					$('#form1').submit();
				}else{
					$('#alertNotFindModal').appendTo("body").modal('show');
				}
			 }
		});
	}
}
