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
                        <h3>จัดการหลักสูตร</h3>
                        <button id='add_btn' class="btn btn-primary" style="float: right; margin: 10px">เพิ่มหลักสูตร</button>
                    </div>
                    <div class="g24-col-sm-24">
                        <table class="table">
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">รหัสหลักสูตร</th>
                                <th class="text-center">ชื่อหลักสูตร</th>
                                <th class="text-center">ค่าลงทะเบียน</th>
                                <th class="text-center"></th>
                            </tr>
                            <tbody id = 'branch_data'>
                                <?php
                                foreach ($branch as $index => $value) {?>
                                <tr>
                                    <td class="text-center"><?php echo $index+1 ?></td>  <!--- ลำดับ --->
                                    <td class="text-center"><?php echo $value['code'] ?></td>  <!--- รหัสหลักสูตร --->
                                    <td class="text-left"><?php echo $value['name'] ?></td>   <!--- ชื่อหลักสูตรเป็น link --->
                                    <td class="text-center"><?php echo $index+1 ?></td> <!-- ค่าลงทะเบียน -->

                                    <td class="text-center">
                                        <a onclick="edit(<?php echo $value['id'] ?>)">แก้ไข</a>
                                        |
                                        <a onclick="del(<?php echo $value['id'] ?>)" style="color: red">ลบ</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
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
                <h2 class="modal-title" id="type_name">เพิ่มหลักสูตร</h2>
            </div>
            <div class="modal-body" style="height: 300px">
                <form id="modal_form">
                    <input type="hidden" id="modal_type">
                    <input type="hidden" id="branch_id" name="id">
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-5 text-right label-margin"> ชื่อหลักสูตร </label>
                        <div class="g24-col-sm-10">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <label class="g24-col-sm-4 text-right label-margin">รหัสหลักสูตร </label>
                        <div class="g24-col-sm-5">
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                    </div>
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-5 text-right label-margin">ค่าลงทะเบียน</label>
                        <div class="g24-col-sm-10">
                            <input type="text" class="form-control" id="" name="">
                        </div>
                    </div>
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
    //modal_type 1 = add , 2 = edit
    $(document).ready(function (){
        $('#add_btn').click(function (){
            $('#name').val('');
            $('#code').val('');
            $('#tel').val('');
            $('#modal_type').val(1);
            $('#add_modal').modal('show');
        });

        $('#save_btn').click(function (){
            let modal_type = $('#modal_type').val();
            let url = "";
            let warning_text = "";
            let name = $('#name').val();
            let code = $('#code').val();
            let tel = $('#tel').val();
            if (name == ''){
                warning_text += '-ชื่อหลักสูตร\n';
            }
            if (code == ''){
                warning_text += '-รหัสหลักสูตร\n';
            }
            if (tel == ''){
                warning_text += '-ค่าลงทะเบียน\n';
            }
            if (warning_text != ''){
                swal('กรุณากรอกข้อมูล',warning_text,'warning');
            } else {
                if (modal_type == 1){
                    url = base_url+"branch/ajax_create_branch";
                } else if (modal_type == 2){
                    url = base_url+"branch/ajax_edit_branch";
                }
                $.ajax({
                    type:'POST' ,
                    url: url ,
                    data: $('#modal_form').serialize(),
                    success:function(res){
                        location.reload();
                    }
                });
            }
        });

        $('#cancle_btn').click(function(){
            $('#add_modal').modal('hide');
        });
    });

    function edit(branch_id){
        let br_id = branch_id;
        $('#branch_id').val(br_id);
        $('#modal_type').val(2);
        $.ajax({
            type:'POST',
            url:base_url+'branch/ajax_get_branch_data',
            data: {
                id :  br_id
            },
            success: function(res){
                data = JSON.parse(res);
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#tel').val(data.tel);
                $('#add_modal').modal('show');
            }

        });
    }

    function del(branch_id){
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
                    url: base_url+"branch/ajax_check_can_delete",
                    data : {
                        branch_id : branch_id
                    } ,
                    success: function(data){
                        result = JSON.parse(data);
                        if (result.can_delete == false){
                            swal('Error','ไม่สามารถลบสาขานี้ได้','warning');
                        } else {
                            $.ajax({
                                type:'POST',
                                url: base_url+"branch/ajax_delete_branch",
                                data : {
                                    id : branch_id
                                } ,
                                success: function(data){
                                    location.reload();
                                }
                            });
                        }
                    }
                });
            }
        });
    }
</script>
