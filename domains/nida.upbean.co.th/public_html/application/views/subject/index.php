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
                                <th class="text-center">จังหวัดที่เปิด</th>
                                <th class="text-center"></th>
                            </tr>
                            <tbody id = 'subject_data'>
                                <?php
                                foreach ($subject as $index => $value) {?>
                                <tr>
                                    <td class="text-center"><?php echo $index+1 ?></td>
                                    <td class="text-center"><?php echo $value['code'] ?></td>
                                    <td class="text-center"><?php echo $value['name'] ?></td>
                                    <td class="text-center"><?php echo $value['cost'] ?></td>
                                    <td class="text-center"><?php echo $value['open_province']?></td>
                                    <td class="text-center">
                                        <a onclick="edit('<?php echo $value['code'] ?>')">แก้ไข</a>
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
            <div class="modal-body" style="height: 480px">
                <form id="modal_form">
                    <input type="hidden" id="modal_type">
                    <input type="hidden" id="subject_id" name="subject_id">
                    <input type="hidden" id="project_id" name="project_id">
                    <input type="hidden" id="pv" name="pv">
                    <input type="hidden" id="check" name="check">

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-4 text-right label-margin">รหัส</label>
                        <div class="g24-col-sm-5">
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-4 text-right label-margin"> ชื่อหลักสูตร </label>
                        <div class="g24-col-sm-18">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-5 text-right label-margin"> เปิดรับสมัครวันที่ </label>
                        <div class="g24-col-sm-6">
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <label class="g24-col-sm-2 text-right label-margin"> ถึง </label>
                        <div class="g24-col-sm-6">
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>                        
                    </div>

                    <div class="g24-col-sm-20 margin-10">
                        <label class="g24-col-sm-5 label-margin">ค่าลงทะเบียน</label>
                        <div class="g24-col-sm-5">
                            <input type="number" class="form-control" id="cost" name="cost">
                        </div>
                    </div>

                    <div class="g24-col-sm-20 margin-10">
                        <label class="g24-col-sm-5 text-right label-margin">ภาค</label>
                        <div class="g24-col-sm-16">
                            <select class="form-control" id="geography" name="geography" onchange="show_province($('#geography').val())">
                                <option value="0" selected></option>
                                <option value="1">ภาคเหนือ</option>
                                <option value="2">ภาคกลาง</option>
                                <option value="3">ภาคตะวันออกเฉียงเหนือ</option>
                                <option value="4">ภาคตะวันตก</option>
                                <option value="5">ภาคตะวันออก</option>
                                <option value="6">ภาคใต้</option>
                            </select>
                        </div>
                    </div>

                    <div id="province" class="g24-col-sm-24 margin-10">
                        <!-- <?php foreach ($province as $index => $value) {?>
                            <input type="checkbox" name="province_name" id="province_name" value="<?php echo $value['province_name'] ?>">
                            <label><?php echo $value['province_name']?></label>
                        <?php } ?> -->
                        <!-- <div id="row_1" class="g24-col-sm-6">

                        </div> -->
                    </div>
                </form>
                <div class="g24-col-sm-24" style="margin-top: 5px">
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
            $('#project_id').val(<?php echo $project_id ?>)
            $('#name').val('');
            $('#code').val('');
            $('#cost').val(0);
            $("#geography").val('');
            $('#province').empty()
            $('#modal_type').val(1);
            $('#add_modal').modal('show');
        });

        $('#save_btn').click(function (){
            var open = [];
            $.each($("input:checkbox[name='province_name']:checked"), function () {
                let str = $(this).val()
                str = str.replace(/\s/g, '')
                open.push(str);
            });
            $("#pv").val(open.join(","))
            console.log($("#pv").val())
            // let modal_type = $('#modal_type').val();
            // let url = "";
            // let warning_text = "";
            // let name = $('#name').val();
            // let code = $('#code').val();
            // let cost = $('#cost').val();
            // let start_date = $('#start_date').val();
            // let end_date = $('#end_date').val();
            // if(code != ''){
            //     checkCodeSubject($('#code').val())
            // }
            // let check_code = $('#check').val();
            // if (name == ''){
            //     warning_text += '-ชื่อหลักสูตร\n';
            // }
            // if (code == ''){
            //     warning_text += '-รหัสหลักสูตร\n';
            // }
            // if(code != '' && onlyNumber(code)){
            //     warning_text += '-รหัสหลักสูตรต้องประกอบด้วยตัวเลขเท่านั้น\n'
            // }
            // if (cost == 0){
            //     warning_text += '-ค่าลงทะเบียน\n';
            // }
            // if (check_code != 0 && modal_type == 1){
            //     warning_text += '-ตรวจพบรหัสวิชานี้แล้ว\n'
            // }
            // if(start_date == ''){
            //     warning_text += '-วันที่เปิดรับสมัคร\n'
            // }
            // if(end_date == ''){
            //     warning_text += '-วันที่ปิดรับสมัคร\n'
            // }
            // if($("#pv").val() == ''){
            //     warning_text += '-กรุณาเลือกจังหวัดที่เปิดรับสมัคร\n'
            // }
            // if (warning_text != ''){
            //     swal('กรุณากรอกข้อมูล',warning_text,'warning');
            // } 
            // else {
            //     if (modal_type == 1){
            //         url = base_url+"subject/ajax_create_subject";
            //     } else if (modal_type == 2){
            //         url = base_url+"subject/ajax_edit_subject";
            //     }
            //     $.ajax({
            //         type:'POST' ,
            //         url: url ,
            //         data: $('#modal_form').serialize(),
            //         success:function(res){
            //             location.reload();
            //         }
            //     });
            // }
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

    function checkCodeSubject(code){
        $.ajax({
            async: false,
            type: 'POST',
            url: base_url + 'subject/ajax_check_code_subject',
            data: {
                code: code
            },
            success: function(res){
                data = JSON.parse(res)
                $('#check').val(data.num);
            }
        });
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
                $('#start_date').val(data.start_date);
                $('#end_date').val(data.end_date);
                $("#geography").val(data.geography).change();
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

    function show_province(id){
        $("#province").empty()
        $.ajax({
            type:'POST',
            url:base_url+'province/ajax_get_province',
            data: {
                id : id
            },
            success: function(res){
                data = JSON.parse(res)
                for(let i=0;i<data.length;i++){
                    const newLabel = document.createElement("label")
                    newLabel.setAttribute("for", 'checkbox')
                    // newLabel.setAttribute("style", 'padding-right: 50px')
                    newLabel.innerHTML = data[i].province_name

                    const newCheckbox = document.createElement("input")
                    newCheckbox.setAttribute("type", 'checkbox')
                    newCheckbox.setAttribute("name", 'province_name')
                    newCheckbox.setAttribute("id", 'province_name')
                    newCheckbox.setAttribute("value", data[i].province_name)

                    const el = document.createElement('div')
                    el.setAttribute('id', 'my-id')
                    el.setAttribute('class', 'g24-col-sm-6')
                    el.appendChild(newCheckbox)
                    el.appendChild(newLabel)

                    province.appendChild(el)          
                }
            }
        });
    }
</script>
