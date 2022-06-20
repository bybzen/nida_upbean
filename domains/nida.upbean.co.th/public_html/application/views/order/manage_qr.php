<style>
    .margin-10 {
        margin: 7px;
    }

    .label-margin {
        margin-top: 8px;
    }
</style>
<div class="layout-content">
    <div class="layout-content-body">
        <div class="row gutter-xs">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-body" style="padding-top:0px !important;">
                    <div class="g24-col-sm-24">
                        <h3>จัดการ QRCODE</h3>
                        <button id='add_btn' class="btn btn-primary" style="float: right; margin: 10px">เพิ่มรายการ</button>
                    </div>
                    <div class="g24-col-sm-24">
                        <table class="table">
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">วันที่สร้าง</th>
                                <th class="text-center">สาขา</th>
                                <th class="text-center">เลขที่คำสั่งซื้อ</th>
                                <th class="text-center">ยอดเงิน</th>
                                <th class="text-center">Ref1</th>
                                <th class="text-center">Ref2</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">ยอดชำระ</th>
                                <th class="text-center">วันที่ชำระ</th>
                                <th class="text-center"></th>
                            </tr>
                            <?php foreach ($orders as $index => $order){ ?>
                                <tr>
                                    <td class="text-center"><?php echo $index+1 ?></td>
                                    <td class="text-center"><?php echo $this->center_function->ConvertToThaiDate($order['created_at']) ?></td>
                                    <td class="text-left"><?php echo $order['branch_name'] ?></td>
                                    <td class="text-center"><?php echo $order['order_no'] ?></td>
                                    <td class="text-right"><?php echo number_format($order['value'],2) ?></td>
                                    <td class="text-center"><?php echo $order['ref_1'] ?></td>
                                    <td class="text-center"><?php echo $order['ref_2'] ?></td>
                                    <td class="text-center"><?php echo $order['payment_status'] == 1 ? 'ชำระแล้ว' : 'ยังไม่ได้ชำระ'; ?></td>
                                    <td class="text-right"><?php echo $order['payment_status'] == 1 ? number_format($order['payment_amt'],2) : ''; ?></td>
                                    <td class="text-center"><?php echo $order['payment_status'] == 1 ? $this->center_function->ConvertToThaiDate($order['payment_date']) : ''; ?></td>
                                    <td>
                                        <a onclick="print_qr(<?php echo $order['id'] ?>)">
                                            พิมพ์ QR CODE
                                        </a>
                                        <?php if ($order['is_print'] == 0  || true){ ?>
                                            <div id="edit-del-<?php echo $order['id'] ?>" style="display: inline-block">
                                                |
                                                <a id = "edit_<?php echo $order['id'] ?>" onclick="edit(<?php echo $order['id'] ?>)">
                                                    แก้ไข
                                                </a>
                                                |
                                                <a onclick="del(<?php echo $order['id'] ?>)" style="color:red;">
                                                    ลบ
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_modal" role="dialog" style="overflow-x: hidden;overflow-y: auto;">
    <div class="modal-dialog modal-dialog-data">
        <div class="modal-content data_modal">
            <div class="modal-header modal-header-confirmSave">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h2 class="modal-title" id="type_name">เพิ่มรายการ</h2>
            </div>
            <div class="modal-body clearfix">
                <form id="modal_form">
                    <input type="hidden" id="modal_type">
                    <input type="hidden" id="order_id" name="order_id">
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">สาขา</label>
                        <div class="g24-col-sm-14">
                            <select id="branch" name="branch_id" class="form-control" onchange="">
                                    <option value="0" selected>--เลือกสาขา--</option>
                                <?php foreach ($branch as $value) { ?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">เลขที่การสั่งซื้อ</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="order_no" name="order_no">
                        </div>
                    </div>
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">ยอดเงิน</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="value" name="value">
                        </div>
                    </div>
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">Ref1</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="ref_1" name="ref_1" readonly>
                        </div>
                    </div>
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">Ref2</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="ref_2" name="ref_2" readonly>
                        </div>
                    </div>
                    <div id="payment_wrap">
                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">สถานะ</label>
                            <div class="g24-col-sm-14">
                                <label>
                                    <input type="radio" name="payment_status" value="1" class="payment_status"> ชำระแล้ว 
                                </label> &nbsp;
                                <label>
                                    <input type="radio" name="payment_status" value="0" class="payment_status"> ยังไม่ได้ชำระ 
                                </label>
                            </div>
                        </div>
                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">ยอดชำระ</label>
                            <div class="g24-col-sm-14">
                                <input type="text" class="form-control" id="payment_amt" name="payment_amt">
                            </div>
                        </div>
                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">วันที่ชำระ</label>
                            <div class="g24-col-sm-8">
                                <input type="text" class="form-control my-date" id="payment_date_d" name="payment_date_d" data-date-language="th-th">
                            </div>
                            <div class="g24-col-sm-3">
                                <select id="payment_date_h" name="payment_date_h" class="form-control">
                                    <?php for($h = 0; $h <= 23; $h++) { ?><option value="<?php printf("%02d", $h); ?>"><?php printf("%02d", $h); ?></option><?php } ?>
                                </select>
                            </div>
                            <div class="g24-col-sm-3">
                                <select id="payment_date_m" name="payment_date_m" class="form-control">
                                    <?php for($m = 0; $m <= 59; $m++) { ?><option value="<?php printf("%02d", $m); ?>"><?php printf("%02d", $m); ?></option><?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="post" target="_blank" action="" id="print_qr_form" action="">
                    <input type="hidden" id="qr_id" name="order_id">
                </form>
                <div class="g24-col-sm-24" style="margin-top: 10px">
                    <div class="text-center">
                        <button class="btn btn-primary" id="save_btn">บันทึก</button>
                        <button class="btn btn-danger" id="cancle_btn">ยกเลิก</button>
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

        $('#add_btn').click(function(){
            $('#modal_type').val(1);
            $('#branch').val(0);
            $('#order_no').val('');
            $('#value').val('');
            $('#ref_1').val('');
            $('#ref_2').val('');
            $('#branch').attr('onchange','generate_ref()');
            $('#payment_wrap').addClass('hidden');
            $('#add_modal').modal('show');
        });

        $('#save_btn').click(function(){
            let branch_id = $('#branch').val();
            let order_no = $('#order_no').val();
            let value = $('#value').val();
            let modal_type = $('#modal_type').val();
            let url;
            let warning_text = "";
            if (branch_id == 0){
                warning_text += '-สาขา\n';
            }
            if (order_no == ''){
                warning_text += '-เลขที่การสั่งซื้อ\n';
            }
            if (value == ''){
                warning_text += '-ยอดเงิน\n';
            }
            if (modal_type == 1){
                url = base_url + "order/ajax_create_order";
            } else if (modal_type == 2){
                url = base_url + "order/ajax_edit_order";
            }
            if (warning_text == ''){
                $.ajax({
                   type:'POST',
                   url:url,
                   data: $('#modal_form').serialize(),
                    success : function(result){
                       location.reload();
                    }
                });
            } else {
                swal('กรุณากรอกข้อมูล',warning_text,'warning');
            }
        });

        $('#cancle_btn').click(function(){
            $('#add_modal').modal('hide');
        });
    });

    function generate_ref(){
        let branch_id = $('#branch').val();
        if (branch_id != 0){
            $.ajax({
                type:'POST',
                url:base_url+'order/ajax_generate_ref',
                data : {
                    branch_id : branch_id
                } ,
                success : function(result){
                    data = JSON.parse(result);
                    $('#ref_1').val(data.ref_1);
                    $('#ref_2').val(data.ref_2);
                }
            });
        } else {
            $('#ref_1').val('');
            $('#ref_2').val('');
        }
    }

    function edit_ref(){
        let branch_id = $('#branch').val();
        let order_id = $('#order_id').val();
        if (branch_id != 0){
            $.ajax({
                type:'POST',
                url:base_url+'order/ajax_edit_ref',
                data : {
                    branch_id : branch_id ,
                    order_id : order_id
                } ,
                success : function(result){
                    data = JSON.parse(result);
                    $('#ref_1').val(data.ref_1);
                    $('#ref_2').val(data.ref_2);
                }
            });
        } else {
            $('#ref_1').val('');
            $('#ref_2').val('');
        }
    }

    function edit(order_id){
        $('#branch').attr('onchange','edit_ref()');
        $.ajax({
            type:'POST',
            url:base_url+'order/ajax_get_order_data',
            data: {
                order_id : order_id
            } ,
            success : function(result){
                data = JSON.parse(result);
                $('#branch').val(data.branch_id);
                $('#order_no').val(data.order_no);
                $('#value').val(data.value);
                $('#ref_1').val(data.ref_1);
                $('#ref_2').val(data.ref_2);
                $('.payment_status[value=' + data.payment_status + ']').prop('checked', true);
                $('#payment_amt').val(data.payment_amt);
                $('#payment_date_d').val(data.payment_date_d);
                $('#payment_date_h').val(data.payment_date_h);
                $('#payment_date_m').val(data.payment_date_m);
            }
        });
        $('#order_id').val(order_id);
        $('#modal_type').val(2);
        $('#payment_wrap').removeClass('hidden');
        $('#add_modal').modal('show');
    }

    function del(order_id){
        swal({
                title: "ท่านต้องการลบข้อมูลใช่หรือไม่",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'ลบ',
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
                closeOnCancel: true ,
            },
            function (isConfirm){
                if (isConfirm){
                    $.ajax({
                        type:'POST',
                        url: base_url+"order/ajax_delete_order",
                        data : {
                            order_id : order_id
                        } ,
                        success: function(data){
                            location.reload();
                        }
                    });
                }
            });
    }

    function print_qr(order_id){
        $.ajax({
            type:'POST',
            url:base_url + 'order/ajax_print',
            data : {
                order_id : order_id
            },
            success:function(result){
                let a_edit = '#edit-del-' + order_id ;
                $(a_edit).attr('style','display:none');
                $('#print_qr_form').attr('action',base_url+"order/bill_payment");
                $('#qr_id').val(order_id);
                $('#print_qr_form').submit();
            }
        });
    }
</script>
