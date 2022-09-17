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
                        <h3>นำเข้าข้อมูล Excel</h3>
                        <button id='add_btn' class="btn btn-primary" style="float: right; margin: 10px ; width: 130px">นำเข้าข้อมูล</button>
                    </div>
                    <div class="g24-col-sm-24">
                        <table class="table">
                            <tr>
                                <th class="text-center">วันที่ชำระ</th>
                                <th class="text-center">ยอดเงิน</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                            <?php foreach ($datas as $index => $data) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $this->center_function->toSplitDate($data['pay_date'])  ?></td>
                                    <td class="text-center"><?php echo number_format($data['total_amount'],2)?></td>
                                    
                                    <td class="text-center">
                                        <a   onclick="report_show('<?php echo $data['pay_date'] ?>')">
                                            ดูรายละเอียด 
                                            <!-- <?php echo $data['pay_date'] ?> -->
                                        </a>
                                        <!-- |
                                        <a onclick="del('<?php echo $data['pay_date'] ?>')" style="color: red">
                                            ลบ
                                        </a> -->
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
                <h2 class="modal-title" id="type_name">นำเข้าข้อมูล Excel</h2>
            </div>
            <div class="modal-body" style="height: 110px">
                <div class="g24-col-sm-24" style="margin-top: 10px">
                    <form id="form_1"  action="<?=base_url('enroll/import_file_kt');?>" type="file" enctype="multipart/form-data" name="file" method="POST">
                        <input id="file" type="file" name="file">
                    </form>
                </div>
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

       $('#cancle_btn').click(function(){
            $('#add_modal').modal('hide');
        });
    });

    function report_show(pay_date){
        console.log(pay_date)
        
        document.location.href=window.location.origin+"/enroll/import_show_report/"+pay_date
    }

</script>
