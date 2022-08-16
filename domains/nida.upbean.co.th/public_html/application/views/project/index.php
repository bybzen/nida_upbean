<style>
    .margin-10 {
        margin: 7px;
    }
    .margin-left-5 {
        /* margin-left: -2px; */
        margin-top: 7px;
        /* margin-right: 7px; */
        margin-bottom: 7px;
    }
    .margin-label-cost{
        margin-right: -20px;
        margin-left: -20px;
    }
    .m-top {
        margin-top: 10px;
        margin-left: 11px;
    }

    .pointer {
        cursor: pointer;
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
                        <h3>จัดการโครงการ</h3>
                        <button id='add_btn' class="btn btn-primary" style="float: right; margin: 10px">เพิ่มโครงการ</button>
                    </div>
                    <div class="g24-col-sm-24">
                        <table class="table">
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">รหัสโครงการ</th>
                                <th class="text-center">ชื่อโครงการ</th>
                                <th class="text-center"></th>
                            </tr>
                            <tbody id = 'project_data'>
                                <?php
                                foreach ($project as $index => $value) {?>
                                    <tr>
                                        <td class="text-center"><?php echo $index+1 ?></td>
                                        <td class="text-center">
                                            <a onclick="enroll(<?php echo $value['id'] ?>)" class="pointer" style="color: blue">
                                                <?php echo $value['project_name'] ?>
                                            </a>
                                        </td>
                                        <td class="text-center">    
                                            <a onclick="add_subject(<?php echo $value['id'] ?>)">จัดการหลักสูตร</a>
                                            |
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
                <h2 class="modal-title" id="type_name">โครงการ</h2>
            </div>
            <div class="modal-body" style="height: 120px">
                <form id="modal_form">
                    <input type="hidden" id="modal_type">
                    <input type="hidden" id="project_id" name="project_id">
                    <input type="hidden" id="check" name="check">

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-4 text-right label-margin"> ชื่อโครงการ </label>
                        <div class="g24-col-sm-18">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>                    
                </form>
                <div class="g24-col-sm-24" style="margin-top: 5px">
                    <div class="text-center">
                        <button class="btn btn-primary" id="save_btn">บันทึก</button>
                        <button class="btn btn-danger" id="cancle_btn">ยกเลิก</button>
                    </div>
                </div>
                <form id="enroll_form" action="" method="post" target="_blank">
                    <input type="hidden" name="pj_id" id="pj_id">
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
            $('#modal_type').val(1);
            $('#add_modal').modal('show');
        });

        $('#save_btn').click(function (){
            let modal_type = $('#modal_type').val();
            let url = "";
            let warning_text = "";
            let name = $('#name').val();
            let code = $('#code').val();
            if(name === ''){
                warning_text+='-กรุณาใช่ชื่อโครงการ'
            }
            if (warning_text != ''){
                swal('กรุณากรอกข้อมูล',warning_text,'warning');
            } 
            else {
                if (modal_type == 1){
                    url = base_url+"project/ajax_create_project";
                } else if (modal_type == 2){
                    url = base_url+"project/ajax_edit_project";
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

    function add_subject(id){
        $("#pj_id").val(id)
        $.ajax({
            type: 'POST',
            url: base_url + 'project/ajax_get_project_data',
            data: {
                id: $("#pj_id").val()
            },
            success: function(res){
                data = JSON.parse(res)
                console.log(data.id)
                document.location.href = window.location.origin + '/subject/index/' + data.id
            }
        })
    }

    function enroll(id){
        $("#pj_id").val(id)
        $('#enroll_form').attr('action', base_url + 'project/enroll_subject');
        $('#enroll_form').submit();
    }

    function edit(id){
        let pj_id = id;
        $('#project_id').val(pj_id);
        $('#modal_type').val(2);
        $.ajax({
            type:'POST',
            url:base_url+'project/ajax_get_project_data',
            data: {
                id :  pj_id
            },
            success: function(res){
                data = JSON.parse(res);
                $('#name').val(data.project_name);
                $('#code').val(data.project_code);
                $('#add_modal').modal('show');
            }

        });
    }

    function del(id){
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
                    url: base_url+"project/ajax_delete_project",
                    data:{
                        id : id
                    },
                    success: function(data){
                        location.reload();
                    }
                });
            }
        });
    }
</script>
