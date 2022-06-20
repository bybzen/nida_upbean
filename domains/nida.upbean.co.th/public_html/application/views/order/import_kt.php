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
                        <h3>นำเข้าไฟล์ ธ.กรุงไทย</h3>
                        <button id='add_btn' class="btn btn-primary" style="float: right; margin: 10px ; width: 130px">นำเข้าไฟล์ ธ.กรุงไทย</button>
                    </div>
                    <div class="g24-col-sm-24">
                        <table class="table">
                            <tr>
                                <th class="text-center">วันที่ทำรายการ</th>
                                <th class="text-center">รายการที่พบ</th>
                                <th class="text-center">รายการที่ไม่พบ</th>
                                <th class="text-center">รวมจำนวนเงิน</th>
                                <th></th>
                            </tr>
                            <?php foreach ($datas as $index => $data) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $this->center_function->ConvertToThaiDate($data['created_at']) ?></td>
                                    <td class="text-center"><?php echo $data['found_count'] ?></td>
                                    <td class="text-center"><?php echo $data['total_count'] - $data['found_count'] ?></td>
                                    <td class="text-right"><?php echo number_format($data['amount'],2) ?></td>
                                    <td class="text-center">
                                        <a onclick="pdf(<?php echo $data['import_id'] ?>)">
                                            PDF
                                        </a>
                                        |
                                        <a onclick="excel(<?php echo $data['import_id'] ?>)">
                                            EXCEL
                                        </a>
                                        |
                                        <a onclick="del(<?php echo $data['import_id'] ?>)" style="color: red">
                                            ลบ
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <form id="print_form" action="" method="post" target="_blank">
                    <input type="hidden" name="import_id" id="import_id">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_modal" role="dialog" style="overflow-x: hidden;overflow-y: auto;">
    <div class="modal-dialog modal-dialog-data">
        <div class="modal-content data_modal">
            <div class="modal-header modal-header-confirmSave">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h2 class="modal-title" id="type_name">นำเข้า</h2>
            </div>
            <div class="modal-body" style="height: 110px">
                <div class="g24-col-sm-24" style="margin-top: 10px">
                    <form id="form_1"  action="<?=base_url('order/import_file_kt');?>" type="file" enctype="multipart/form-data" name="file" method="POST">
                        <input id="file" type="file" name="file">
                    </form>
                </div>
                <div class="g24-col-sm-24" style="margin-top: 10px">
                    <div class="text-center">
                        <button class="btn btn-primary" id="save_btn">นำเข้า</button>
                        <button class="btn btn-danger" id="cancle_btn">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       $('#add_btn').click(function(){
            $('#add_modal').modal('show');
       });

       $('#save_btn').click(function(){
           if (document.getElementById('file').value == ''){
               swal('กรุณาอัพโหลดไฟล์','','warning')
           } else {
               $('#form_1').submit();
           }

       });
    });

    function pdf(import_id){
        $('#import_id').val(import_id);
        $('#print_form').attr('action',base_url + 'order/import_report');
        $('#print_form').submit();
    }

    function excel(import_id){
        $('#import_id').val(import_id);
        $('#print_form').attr('action',base_url + 'order/import_report_excel');
        $('#print_form').submit();
    }

    function del(import_id){
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
                        url: base_url+"order/ajax_delete_import",
                        data : {
                            id : import_id
                        } ,
                        success: function(data){
                            location.reload();
                        }
                    });
                }
            });
    }
</script>
