<style>
    .margin-10 {
        margin: 7px;
    }

    .label-margin {
        margin-top: 8px;
    }

    label {
        text-align: right;
        margin-top: 7px;
    }

    .mar-10 {
        margin-bottom: 7px;
    }

    radio {
        width: 15px;
    }

    .div-radio {
        margin-top: 7px;
    }

    .txt-left {
        padding : 0px;
        text-align: left;
    }


</style>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="row gutter-xs">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-body" style="padding-top:0px !important;">
                    <div class="g24-col-sm-24">
                        <h3>รายงานการชำระเงิน</h3>
                    </div>
                    <form method="GET" action="" id="pdf_excel_form" target="_blank">
                        <div class="g24-col-sm-24 mar-10">
                            <label class="g24-col-sm-8">วันที่</label>
                            <div class="g24-col-sm-7">
                                <input class="form-control my-date" type="text" name="start_date" id="start_date" data-date-language="th-th">
                            </div>
                        </div>
                        <div class="g24-col-sm-24 mar-10">
                            <label class="g24-col-sm-8">ถึงวันที่</label>
                            <div class="g24-col-sm-7">
                                <input class="form-control my-date" type="text" name="end_date" id="end_date" data-date-language="th-th">
                            </div>
                        </div>
                        <div class="g24-col-sm-24 mar-10">
                            <label class="g24-col-sm-8">การชำระเงิน</label>
                            <div class="g24-col-sm-1 div-radio">
                                <input class="radio-click" type="radio" id="radio-1" checked name="type_all">
                            </div>
                            <label class="g24-col-sm-2 txt-left">ทั้งหมด</label>
                            <div class="g24-col-sm-1 div-radio">
                                <input class="radio-click" type="radio" id="radio-2" name="type_found">
                            </div>
                            <label class="g24-col-sm-3 txt-left" >รายการที่พบ</label>
                            <div class="g24-col-sm-1 div-radio">
                                <input class="radio-click" type="radio" id="radio-3" name="type_not_found">
                            </div>
                            <label class="g24-col-sm-3 txt-left">รายการที่ไม่พบ</label>
                        </div>
                        <div class="g24-col-sm-24 mar-10" id="div-branch">
                            <label class="g24-col-sm-8">สาขา</label>
                            <div class="g24-col-sm-7">
                                <select id="branch" name="branch" class="form-control">
                                    <option value="0" selected>ทั้งหมด</option>
                                    <?php foreach ($branch as $value){ ?>
                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="g24-col-sm-24" style="margin-top: 10px">
                        <div class="text-center">
                            <button class="btn btn-primary" id="pdf_btn">PDF</button>
                            <button class="btn btn-primary" id="excel_btn">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".my-date").datepicker({
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

        $('#pdf_btn').click(function (){
            let warning_text = "";
            if ($('#start_date').val() == "" || $('#end_date').val() == ""){
                warning_text += "กรุณากรอกวันที่\n";
            }
            if (warning_text == ""){
                $('#pdf_excel_form').attr("action",base_url + "order/report_pay_pdf");
                $('#pdf_excel_form').submit();
            } else {
                swal("กรุณากรอกข้อมูล",warning_text,"warning")
            }
        });

        $('#excel_btn').click(function (){
            let warning_text = "";
            if ($('#start_date').val() == "" || $('#end_date').val() == ""){
                warning_text += "กรุณากรอกวันที่\n";
            }
            if (warning_text == ""){
                $('#pdf_excel_form').attr("action",base_url + "order/report_pay_excel");
                $('#pdf_excel_form').submit();
            } else {
                swal("กรุณากรอกข้อมูล",warning_text,"warning")
            }
        });

        $('.radio-click').click(function( el ){
            let id = el.target.id;
            if (id == 'radio-1'){
                $('#radio-2').prop('checked',false);
                $('#radio-3').prop('checked',false);
                $('#div-branch').attr('style','');
            } else if (id == 'radio-2'){
                $('#radio-1').prop('checked',false);
                $('#radio-3').prop('checked',false);
                $('#div-branch').attr('style','');
            } else if (id == 'radio-3'){
                $('#radio-1').prop('checked',false);
                $('#radio-2').prop('checked',false);
                $('#div-branch').attr('style','display:none');
            }
        });
    });
</script>
