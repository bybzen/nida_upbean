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
                        <h3>ข้อมูลชำระเงิน
                        <?php if($report_pay != null) { ?>
                           <?php echo "วันที่ ".$this->center_function->toSplitDate($report_pay[0]['pay_date'])?></h3>  
                        <?php }?>

                        <button id="excel_btn" class="btn btn-primary" style="float: right; margin: 10px ; width: 130px">EXCEL</button>
                    </div>
                
                    <form method="GET" action="" id="excel_form" target="_blank">
                        <input type="hidden" name="target_date" id="target_date" value=<?php echo $report_pay[0]['pay_date'] ?>>
                        <div class="g24-col-sm-24">
                            <table class="table">
                                <tr>
                                <th class="text-center">ลำดับ</th>
                                    <th class="text-center">วันเวลาที่ชำระ</th>
                                    <th class="text-center">Ref1</th>
                                    <th class="text-center">ชื่อสกุล</th>
                                    <th class="text-center">หลักสูตร</th>
                                    <th class="text-center">ยอดเงิน</th>
                                    <th class="text-center">สถานะ</th>
                                </tr>
                                <?php foreach ($report_pay as $index => $data) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo $index+1 ?></td>
                                        <td class="text-center" id="pay_date"><?php echo $this->center_function->toSplitDate($data['pay_date'])." ".$data['pay_time']  ?></td>
                                        <td class="text-center"><?php echo $data['t2_ref_1'] ?></td>
                                        <td class="text-center"><?php echo $data['enroll_name'] ?></td>
                                        <td class="text-center"><?php echo $data['enroll_subject'] ?></td>
                                        <td class="text-right"><?php echo number_format($data['amount'],2) ?></td>
                                        <?php if($data['status'] == "ชำระเงินแล้ว"){ ?>
                                        <td class="text-center" style="color:#006633;"><?php echo $data['status'] ?></td>
                                        <?php } else{?>
                                            <td class="text-center" style="color:red" ><?php echo $data['status']?></td>
                                        <?php }?>
                                        <td class="text-center" id="pay_date"></td>
                                    </tr>
                                <?php } ?></tr>
                                    <tr>
                                        <td class="text-right" colspan="6" style="text-align: right;">รวม &nbsp;&nbsp;&nbsp;&nbsp;<?php echo number_format($report_pay[0]['total_amount'],2)?></td>
                                        <td class="text-right" colspan="6" style="text-align: right;"></td>
                                    </tr>
                            </table>
                        </div>
                    </form> 

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

    $('#excel_btn').click(function (){
    
        // console.log("วันที่ = ",$('#target_date').val())
        // $('#target_date').val(pay_date);
        $('#excel_form').attr("action",base_url + "enroll/import_report_excel");
        $('#excel_form').submit();
        });


    // function pdf(import_id){
    //     $('#import_id').val(import_id);
    //     $('#print_form').attr('action',base_url + 'enroll/import_report_pdf');
    //     $('#print_form').submit();
    // }

    // function del(import_id){
    //     swal({
    //             title: "ท่านต้องการลบข้อมูลใช่หรือไม่",
    //             text: "",
    //             type: "warning",
    //             showCancelButton: true,
    //             confirmButtonColor: '#DD6B55',
    //             confirmButtonText: 'ลบ',
    //             cancelButtonText: "ยกเลิก",
    //             closeOnConfirm: false,
    //             closeOnCancel: true ,
    //         },
    //         function (isConfirm){
    //             if (isConfirm){
    //                 $.ajax({
    //                     type:'POST',
    //                     url: base_url+"enroll/ajax_delete_import",
    //                     data : {
    //                         id : import_id
    //                     } ,
    //                     success: function(data){
    //                         location.reload();
    //                     }
    //                 });
    //             }
    //         });
    // }

    

</script>
