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
    textarea {
	    resize: none;
	    min-height: 150px;
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
                                <th class="text-center">ชื่อย่อหลักสูตร</th>
                                <th class="text-center">ชื่อหลักสูตร</th>
                                <th class="text-center">ชื่อหลักสูตรภาษาอังกฤษ</th>
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
                                    <td class="text-center"><?php echo $value['name_short'] ?></td>
                                    <td class="text-center"><?php echo $value['name'] ?></td>
                                    <td class="text-center"><?php echo $value['name_eng'] ?></td>
                                    <td class="text-center"><?php echo $value['cost'] ?></td>
                                    <td class="text-center"><?php echo $value['open_province']?></td>
                                    <td class="text-center">
                                        <a onclick="edit('<?php echo $value['code'] ?>')">แก้ไข</a>
                                        |
                                        <a onclick="del(<?php echo $value['id'] ?>, '<?php echo $value['code'] ?>')" style="color: red">ลบ</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div>
                    <textarea name="mytextarea" id="mytextarea"></textarea>
                </div> -->
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
            <div class="modal-body" style="height: 227rem">
                <form id="modal_form">
                    <input type="hidden" id="modal_type">
                    <input type="hidden" id="subject_id" name="subject_id">
                    <input type="hidden" id="project_id" name="project_id">
                    <input type="hidden" id="pv" name="pv">
                    <input type="hidden" id="open_geo" name="open_geo">
                    <input type="hidden" id="check" name="check">
                    <input type="hidden" id="detail" name="detail">

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">รหัส</label>
                        <div class="g24-col-sm-5">
                            <input type="text" class="form-control" id="code" name="code">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="padding: 0px;">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อย่อหลักสูตร </label>
                        <div class="g24-col-sm-9">
                            <input type="text" class="form-control" id="name_short" name="name_short">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อหลักสูตร </label>
                        <div class="g24-col-sm-18">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อหลักสูตร(Eng) </label>
                        <div class="g24-col-sm-18">
                            <input type="text" class="form-control" id="name_eng" name="name_eng">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label>รายละเอียดหลักสูตร</label>
                        <div>
                            <textarea name="mytextarea" id="mytextarea"></textarea>
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> เปิดรับสมัครวันที่ </label>
                        <div class="g24-col-sm-6">
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <label class="g24-col-sm-2 text-right label-margin"> ถึง </label>
                        <div class="g24-col-sm-6">
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>                        
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">ค่าลงทะเบียน</label>
                        <div class="g24-col-sm-5">
                            <input type="number" class="form-control" id="cost" name="cost">
                        </div>
                    </div>


                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="1" disabled>
                        <label for="geography"><h3><b><u> ภาคเหนือ </u></b></h3></label>
                    </div>
                    <div id='north' class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#north','1')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 1) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="2" disabled>
                        <label for="geography"><h3><b><u>ภาคกลางและภาคตะวันตก </u></b></h3></label>
                    </div>
                    <div id="central" class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#central','2')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 2 || $value['geo_id'] == 4) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="7" disabled>
                        <label for="geography"><h3><b><u>ภาคอีสานตอนบน</u></b></h3></label>
                    </div>
                    <div id="north_eastern_top" class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#north_eastern_top','7')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 7) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="8" disabled>
                        <label for="geography"><h3><b><u>ภาคอีสานตอนกลาง</u></b></h3></label>
                    </div>
                    <div id="north_eastern_center" class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#north_eastern_center','8')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 8) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="9" disabled>
                        <label for="geography"><h3><b><u>ภาคอีสานตอนล่าง</u></b></h3></label>
                    </div>
                    <div id="north_eastern_below" class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#north_eastern_below','9')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 9) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="5" disabled>
                        <label for="geography"><h3><b><u>ภาคตะวันออก </u></b></h3></label>
                    </div>
                    <div id="eastern" class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#eastern','5')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 5) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px;"><br>
                        <input type="checkbox" name="geography" id="geography" value="6" disabled>
                        <label for="geography"><h3><b><u>ภาคใต้ </u></b></h3></label>
                    </div>
                    <div id="south" class="g24-col-sm-24 margin-10" style="margin-top: -20px;" onchange="autocheck_geo('#south','6')"><br>
                        <?php foreach ($province as $index => $value) {?>
                            <?php if($value['geo_id'] == 6) {?>
                            <div class="g24-col-sm-6" style="margin-top: 10px;">
                                <input type="checkbox" name="province_name" id="province_name" 
                                    value="<?php echo $value['province_name'] ?>">
                                <label for="province_name"><?php echo $value['province_name'] ?></label>   
                            </div>                                 
                                <?php }?>
                        <?php } ?>
                    </div>


                    <!-- <div id="province" class="g24-col-sm-24 margin-10">

                    </div> -->
                </form>
                <div class="g24-col-sm-24" style="margin-top: 30px">
                    <div class="text-center">
                        <button class="btn btn-primary" id="save_btn">บันทึก</button>
                        <button class="btn btn-danger" id="cancle_btn">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.tiny.cloud/1/al73i07wbou1n4t1duftfqio9k4c030azqagvxjbdlg6sjd4/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    let checked_province = []
    let checked_geo = []

    tinymce.init({
        selector: '#mytextarea',
        plugins: ['lists'],
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        menubar: false,
    });
    //modal_type 1 = add , 2 = edit
    $(document).ready(function (){
        $('#add_btn').click(function (){
            $('#project_id').val(<?php echo $project_id ?>)
            $('#name').val('');
            $('#code').val('');
            $('#cost').val(0);
            // $("#geography").val('');
            $('#province').empty()
            $('#modal_type').val(1);
            $('#add_modal').modal('show');
        });

        $('#save_btn').click(function (){
            $("#detail").val(tinyMCE.get('mytextarea').getContent())
            var open_province = []
            var open_geography = []
            let modal_type = $('#modal_type').val();
            $.each($("input:checkbox[name='province_name']:checked"), function () {
                let str = $(this).val()
                str = str.replace(/\s/g, '')
                open_province.push(str)
            });
            $.each($("input:checkbox[name='geography']:checked"), function () {
                let str = $(this).val()
                str = str.replace(/\s/g, '')
                open_geography.push(str)
            });
            if(modal_type == 1){
                $("#pv").val(open_province.join(","))
                $("#open_geo").val(open_geography.join(","))
            }
            else if(modal_type == 2){
                if(JSON.stringify(checked_geo) === JSON.stringify(open_geography) && JSON.stringify(checked_province) === JSON.stringify(open_province)){
                    $("#pv").val('not change')
                    $("#open_geo").val('not change')
                }
                else{
                    $("#pv").val(open_province.join(","))
                    $("#open_geo").val(open_geography.join(","))
                }
            }
            let url = "";
            let warning_text = "";
            let name = $('#name').val();
            let name_eng = $('#name_eng').val();
            let name_short = $("#name_short").val();
            let code = $('#code').val();
            let cost = $('#cost').val();
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();
            let detail = tinyMCE.get('mytextarea').getContent()
            if(code != ''){
                checkCodeSubject($('#code').val())
            }
            if($("#name_short").val() == ''){
                warning_text += '-กรอกชื่อย่อหลักสูตร\n'
            }
            let check_code = $('#check').val();
            if (name == ''){
                warning_text += '-ชื่อหลักสูตร\n';
            }
            if($("#name_eng").val() == ''){
                warning_text += '-กรอกชื่อหลักสูตรภาษาอังกฤษ\n'
            }
            if (code == ''){
                warning_text += '-รหัสหลักสูตร\n';
            }
            if(code != '' && onlyNumber(code)){
                warning_text += '-รหัสหลักสูตรต้องประกอบด้วยตัวเลขเท่านั้น\n'
            }
            if (check_code != 0 && modal_type == 1){
                warning_text += '-ตรวจพบรหัสวิชานี้แล้ว\n'
            }
            if(start_date == ''){
                warning_text += '-วันที่เปิดรับสมัคร\n'
            }
            if(end_date == ''){
                warning_text += '-วันที่ปิดรับสมัคร\n'
            }
            if (cost == 0){
                warning_text += '-ค่าลงทะเบียน\n';
            }
            if($("#open_geo").val() == '' && $("#pv").val() == '' && modal_type == 2){
                console.log('edit fail')
                warning_text += '-กรุณาเลือกจังหวัด\n'
            }
            if($("#open_geo").val() == '' && $("#pv").val() == '' && modal_type == 1){
                console.log('create fail')
                warning_text += '-กรุณาเลือกจังหวัด\n'
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
            tinyMCE.get("mytextarea").setContent('')
            $('#add_modal').modal('hide');
            $('input[name="geography"]').prop("checked", false)
            $('input[name="province_name"]').prop("checked", false)
        });

    });

    function autocheck_geo(geography,value){
        let i = 0
        $('input[name="geography"][value="'+value+'"]').prop("checked", true)
        var checked = $(geography).find('input[name="province_name"]:checked');
        checked.each(function(){
            i++
        })
        if(i == 0){
            $('input[name="geography"][value="'+value+'"]').prop("checked", false)
        }
    }

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
        $('#subject_id').val(subject_id);
        $('#modal_type').val(2);
        checked_geo = []
        checked_province = []
        $.ajax({
            type:'POST',
            url:base_url+'subject/edit_subject_get_data',
            data: {
                id :  subject_id
            },
            success: function(res){
                data = JSON.parse(res);
                $('#name').val(data['subject'].name);
                $('#name_eng').val(data['subject'].name_eng);
                $('#name_short').val(data['subject'].name_short);
                $('#code').val(data['subject'].code);
                $('#cost').val(data['subject'].cost);
                $('#start_date').val(data['subject'].start_date);
                $('#end_date').val(data['subject'].end_date);
                // $("#geography").val(data.geography).change();
                tinyMCE.get("mytextarea").setContent(data['subject'].detail);
                let arr = data['subject'].geography.split(',')
                $('input:checkbox').removeAttr('checked');
                $.each(arr, function (index, value) {
                    checked_geo.push(value.toString())
                    $('input[name="geography"][value="' + value.toString() + '"]').prop("checked", true)
                });
                $.each(data['province'], function (index, value) {
                    checked_province.push(value.open_province.toString())
                    $('input[name="province_name"][value="' + value.open_province.toString() + '   "]').prop("checked", true)
                });
                $('#add_modal').modal('show');
            }
        });
    }

    function del(subject_id, code){
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
                        id : subject_id,
                        code: code
                    },
                    success: function(data){
                        location.reload();
                    }
                });
            }
        });
    }
</script>
