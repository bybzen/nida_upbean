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
                            <tbody id = 'subject_data'>
                                <?php
                                foreach ($subject as $index => $value) {?>
                                <tr>
                                    <td class="text-center"><?php echo $index+1 ?></td>
                                    <td class="text-center"><?php echo $value['code'] ?></td>
                                    <td class="text-center">
                                        <a onclick="enroll(<?php echo $value['id'] ?>)" style="color: blue">
                                            <?php echo $value['name'] ?>
                                        </a>
                                    </td>
                                    <td class="text-center"><?php echo $value['cost'] ?></td>
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
                <h2 class="modal-title" id="type_name">หลักสูตร</h2>
            </div>
            <div class="modal-body" style="height: 180px">
                <form id="modal_form">
                    <input type="hidden" id="modal_type">
                    <input type="hidden" id="subject_id" name="subject_id">
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-4 text-right label-margin"> ชื่อหลักสูตร </label>
                        <div class="g24-col-sm-10">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <label class="g24-col-sm-3 text-right label-margin">รหัส</label>
                        <div class="g24-col-sm-5">
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                        <label class="g24-col-sm-3 text-right label-margin">ค่าลงทะเบียน</label>
                        <div class="g24-col-sm-5">
                            <input type="number" class="form-control" id="cost" name="cost">
                        </div>
                    </div>
                </form>
                <div class="g24-col-sm-24" style="margin-top: 10px">
                    <div class="text-center">
                        <button class="btn btn-primary" id="save_btn">บันทึก</button>
                        <button class="btn btn-danger" id="cancle_btn">ยกเลิก</button>
                    </div>
                </div>
                <form id="enroll_form" action="" method="post" target="_blank">
                    <input type="hidden" name="sj_id" id="sj_id">
                </form>
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
            $('#cost').val();
            $('#modal_type').val(1);
            $('#add_modal').modal('show');
        });

        $('#save_btn').click(function (){
            let modal_type = $('#modal_type').val();
            let url = "";
            let warning_text = "";
            let name = $('#name').val();
            let code = $('#code').val();
            let tel = $('#cost').val();
            if (name == ''){
                warning_text += '-ชื่อหลักสูตร\n';
            }
            if (code == ''){
                warning_text += '-รหัสหลักสูตร\n';
            }
            if(code != '' && onlyNumber(code)){
                warning_text += '-รหัสหลักสูตรต้องประกอบด้วยตัวเลขเท่านั้น\n'
            }
            if (tel == ''){
                warning_text += '-ค่าลงทะเบียน\n';
            }
            if (warning_text != ''){
                swal('กรุณากรอกข้อมูล',warning_text,'warning');
            } 
            else {
                if (modal_type == 1){
                    url = base_url+"subject/ajax_create_subject";
                } else if (modal_type == 2){
                    url = base_url+"subject/ajax_edit_subject";
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

    function onlyNumber(code){
        if(!code.match(/^[0-9]+$/)){
            return true;
        }
    }

    function enroll(id){
        $('#sj_id').val(id);
        $('#enroll_form').attr('action', base_url + 'subject/enroll_subject');
        $('#enroll_form').submit();
    }

    function edit(subject_id){
        let sj_id = subject_id;
        $('#subject_id').val(sj_id);
        $('#modal_type').val(2);
        $.ajax({
            type:'POST',
            url:base_url+'subject/ajax_get_subject_data',
            data: {
                id :  sj_id
            },
            success: function(res){
                data = JSON.parse(res);
                $('#name').val(data.name);
                $('#code').val(data.code);
                $('#cost').val(data.cost);
                $('#add_modal').modal('show');
            }

        });
    }

    function del(subject_id){
        swal({
            title: "ท่านต้องการลบข้อมูลใช่หรือไม่",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#098907',
            confirmButtonText: 'ลบ',
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false,
            closeOnCancel: true ,
        },
        function (isConfirm){
            if (isConfirm){
                $.ajax({
                    type:'POST',
                    url: base_url+"subject/ajax_delete_subject",
                    data:{
                        id : subject_id
                    },
                    success: function(data){
                        location.reload();
                    }
                });
            }
        });
    }
</script>
