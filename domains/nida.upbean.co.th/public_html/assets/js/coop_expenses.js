var base_url = $('#base_url').attr('class');

function check_form(){
	var text_alert = '';
	if($.trim($('#expenses_name').val())== ''){
		text_alert += ' - รายได้\n';
	}
	
	if(text_alert != ''){
		swal('กรุณากรอกข้อมูลต่อไปนี้',text_alert,'warning');
	}else{
		$('#form_save').submit();
	}
}

function del_coop_expenses_data(id){	
	swal({
		title: "ท่านต้องการลบข้อมูลนี้ใช่หรือไม่ ! ",
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
				url: base_url+'/setting_member_data/del_coop_expenses_data',
				method: 'POST',
				data: {
					'table': 'coop_expenses',
					'id': id,
					'field': 'expenses_name'
				},
				success: function(msg){
				  // console.log(msg); return false;
					if(msg == 1){
					  document.location.href = base_url+'setting_member_data/coop_expenses';
					}else{

					}
				}
			});
		} else {
			
		}
	});
	
}