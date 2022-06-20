$(document).ready(function() {
    //option A

    $( "#save" ).click(function() {
        var loan_id = $("input[name='loan_id']").val();
        var member_id = $("input[name='member_id']").val();
        var name = $("#name_"+loan_id).html();
        var contract_number = $("#contract_number_"+loan_id).html();
        var loan_amount_balance = $("#loan_amount_balance_"+loan_id).html();
        var loan_amount_fund = numeral($("#amount_"+loan_id).html()).value();
    
        var val = numeral(loan_amount_balance).value();

        var return_amount =  numeral($("#modal_return_amount").val()).value();
        // val = numeral(val).format('0,0.00');
        // console.log("is_numeric", val);
        if(return_amount <= 0){
            swal("โปรดกรอก ยอดเงินที่ต้องการคืน.");
            return false;
        }else if(return_amount > loan_amount_fund){
            swal("ไม่สามารถกรอกยอดเงินคืน \r\n เกินยอดเงินประกันกองทุนที่มีอยู่ได้.");
            return false;
        }
        
        if(val > 0){
            swal({
                title: "ระบบแจ้งเตือน",
                text: "สัญญาเงินกู้นี้ยังมีหนี้เหลืออยู่ "+ numeral(val).format('0,0.00') + " บาท \r\n ท่าต้องการดำเนินการต่อหรือไม่",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true
            }, function(){
                console.log("SUBMIT!");
                _submit();
                return true;
            });
        }else{
            swal({
                title: "ระบบแจ้งเตือน",
                text: "ยืนยันการทำรายการคืนเงิน รหัสสัญญา "+contract_number+" \r\n"+"จำนวนเงิน "+ numeral(return_amount).format('0,0.00') +" บาท" ,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true
            }, function(){
                _submit();
                return true;
            });
        }

    });
});

function _submit(){
	$('#frm_modal').submit();
}

function open_transfer_modal(member_id, loan_id){
    // alert(member_id+loan_id);
    var name = $("#name_"+loan_id).html();
    var contract_number = $("#contract_number_"+loan_id).html();
    var loan_amount_balance = $("#loan_amount_balance_"+loan_id).html();
    var loan_amount_fund = $("#amount_"+loan_id).html();

    $("#modal_name").html(name);
    $("#modal_contract_number").html(contract_number);
    $("#modal_loan_amount_balance").html(loan_amount_balance);
    $("#modal_loan_amount_fund").html(loan_amount_fund);
    $("input[name='member_id']").val(member_id);
    $("input[name='loan_id']").val(loan_id);
    $('#transfer_modal').modal('show'); 
}
$("body").on('change', '.is_numeric', function(){    // 2nd (B)
	var val = numeral($(this).val()).value();
	val = numeral(val).format('0,0.00');
	$(this).val(val);
});

$("#fix_date").datepicker({
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