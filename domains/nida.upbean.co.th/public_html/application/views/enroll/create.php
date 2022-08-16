<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <title>Enroll Subject</title>
    <style>
        body{
            font-family: 'Kanit', sans-serif;
            background-color: #E8E8E8;
        }
        label{
            font-size: calc(60% + 0.6vmin);
        }
        select option{
            font-size: calc(60% + 0.8vmin);
        }
        .tab {
            display: none;
        }
        .btn.btn-primary{
            background-color: #097969;
            border-color: #097969;
        }
        .btn.btn-primary:hover{
            background-color: #50C878;
            border-color: #50C878;
        }
        .btn.btn-prev{
            background-color: #AEAEAE;
            border-color: #AEAEAE;
        }
        .btn.btn-prev:hover{
            background-color: #C5C5C5;
            border-color: #C5C5C5;
        }
        .font-size-p{
            font-size: calc(60% + 0.2vmin);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 col-sm-4 offset-sm-4 mt-4">
                <div class="card border-0" >
                    <h3 class="text-center mt-3">ลงทะเบียน</h3>
                    <h5 class="text-center mt-3"><?php echo $project[0]['project_name'] ?></h5>

                    <form id="modal_form" method="post" enctype="multipart/form-data" class="px-2">

                        <div class="my-3">
                            <label for="work_province" class="form-label">จังหวัดที่ท่านทำงานอยู่</label>
                            <select class="form-control" id="work_province" name="work_province" onchange="show_subject()">
                                <option selected></option>  
                                <?php foreach($province as $index => $value) { ?>
                                        <option value="<?php echo $value['geo_id'] ?>">
                                            <?php echo $value['province_name'] ?>
                                        </option>
                                 <?php } ?>                              
                            </select>
                        </div>

                        <div class="my-3">
                            <label for="subject_name" class="form-label">เลือกหลักสูตร</label>
                            <select class="form-control" id="subject_name" name="subject_name" onchange="show_open_province()">
                                <option selected></option>
                            </select>
                        </div>

                        <div class="my-3">
                            <label for="open_province" class="form-label">เลือกจังหวัด</label>
                            <select class="form-control" id="open_province" name="open_province">
                                <option selected></option>                                
                            </select>
                        </div>

                        <div id="st-1">
                            <p class="mt-5">ข้อมูลส่วนตัวผู้สมัคร</p>
                            <div class="my-3">
                                <label for="email" class='form-label'>อีเมล</label>
                                <input id='email' name='email' type="text" class='form-control' required>
                            </div>
                            <div class="row mb-3">                                                   
                                <div class="col-6 justify-content-left">
                                    <label for="name_title" class="form-label">คำนำหน้าชื่อ</label>
                                    <input id="name_title" name="name_title" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label">ชื่อจริง</label>
                                <input id="firstname" name="firstname" type="text" class="form-control">   
                            </div> 
                            <div class="mb-3">
                                <label for="lastname" class="form-label">นามสกุล</label>
                                <input id="lastname" name="lastname" type="text" class="form-control">
                            </div>                      
                            <!-- <div class="mb-3">
                                <label for="id" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                                <input id="id" name="id" type="text" class="form-control">
                            </div>-->                        
                            <div class="row my-3">
                                <label for="birthday" class="form-label">วัน/เดือน/ปี เกิด</label>
                                <div class="col-3">
                                    <select class="form-control" id="day" name="day">
                                        <option selected></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" id="month">
                                        <option selected></option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" id="year">
                                        <option selected></option>
                                    </select>                                    
                                </div>
                            </div>
                            <div class="row">                            
                                <div class='col mb-3'>
                                    <label for="phone_number" class='form-label'>โทรศัพท์</label>
                                    <input id='phone_number' name='phone_number' type="text" class='form-control'>                                
                                </div>
                                <div class="col mb-3">
                                    <label for="tel" class='form-label'>มือถือ</label>
                                    <input id='tel' name='tel' type="text" class='form-control'>
                                </div>
                            </div>
                            <div class='mb-3'>
                                <label for="person_to_notify" class='form-label'>ชื่อบุคคลที่ติดต่อได้ในกรณีฉุกเฉิน</label>
                                <input id='person_to_notify' name='person_to_notify' type="text" class='form-control'>
                            </div>
                            <div class='mb-3'>
                                <label for="tel_person_to_notify" class='form-label'>หมายเลขโทรศัพท์มือถือบุคคลที่ติดต่อได้ในกรณีฉุกเฉิน</label>
                                <input id='tel_person_to_notify' name='tel_person_to_notify' type="text" class='form-control'>
                            </div>                        
                            <div class="my-3">
                                <label for="cop" class='form-label'>ชื่อหน่วยงาน</label>
                                <input id='cop' name='cop' type="text" class="form-control">
                            </div>
                            <div class='mb-3'>
                                <label for="position" class='form-label'>ตำแหน่ง</label>
                                <input id='position' name='position' type="text" class='form-control'>
                            </div>
                            <div class='row mb-3'>
                                <div class='col'>
                                    <label for="address" class='form-label'>ที่อยู่ที่ทำงาน</label>
                                    <input id='address' name='address' type="text" class='form-control'>
                                </div>
                                <div class='col'>
                                    <label for="road" class='form-label'>ถนน</label>
                                    <input id='road' name='road' type="text" class='form-control'>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col'>
                                    <label for="province" class='form-label'>จังหวัด</label>
                                    <!-- <input id='province' name='province' type="text" class='form-control'> -->
                                    <select class="form-control" id="province" name="province" onchange="showAmphure()">
                                        <option selected></option>  
                                        <?php foreach($province as $index => $value) { ?>
                                                <option value="<?php echo $value['province_id'] ?>">
                                                    <?php echo $value['province_name'] ?>
                                                </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class='col'>
                                    <label for="area" class='form-label'>เขต/อำเภอ</label>
                                    <!-- <input id="area" name="area" type="text" class='form-control'> -->
                                    <select class="form-control" id="area" name="area" onchange="showDistrict()">
                                        <option selected></option>                         
                                    </select>
                                </div>
                            </div>
                            <div class='row mb-3'>
                                <div class='col'>
                                    <label for="sub_area" class='form-label'>แขวง/ตำบล</label>
                                    <!-- <input id='sub_area' name='sub_area' type="text" class='form-control'> -->
                                    <select class="form-control" id="sub_area" name="sub_area" onchange="showZipcode()">
                                        <option selected></option>                         
                                    </select>
                                </div>
                                <div class='col'>
                                    <label for="postal_code" class='form-label'>รหัสไปรษณีย์</label>
                                    <input id='postal_code' name='postal_code' type="text" class='form-control'>
                                </div>
                            </div>
                        </div>
                        <div id="st-4">
                            <p class="pt-3">ที่อยู่ที่ต้องการออกใบเสร็จ</p>
                            <div> 
                                <input type="checkbox" id="check" name="check" onclick="getSameAddress()">
                                <label for="check">ชื่อหน่วยงานและที่อยู่เดียวกับที่ทำงาน</label>
                            </div>
                            <div class="my-3">
                                <label for="bill_name" class='form-label'>ชื่อที่ใช้ในการออกใบเสร็จ</label>
                                <input id='bill_name' name='bill_name' type="text" class="form-control">
                            </div>
                            <div class="my-3">
                                <label for="bill_cop" class='form-label'>ชื่อหน่วยงาน</label>
                                <input id='bill_cop' name='bill_cop' type="text" class="form-control">
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <label for="bill_house" class='form-label'>ที่อยู่เลขที่</label>
                                    <input id='bill_house' name='bill_house' type="text" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="bill_road" class='form-label'>ถนน</label>
                                    <input id='bill_road' name='bill_road' type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <label for="bill_sub_area" class='form-label'>แขวง/ตำบล</label>
                                    <input id='bill_sub_area' name='bill_sub_area' type="text" class="form-control">
                                    <!-- <label for="bill_province" class='form-label'>จังหวัด</label> -->
                                    <!-- <select class="form-control" id="bill_province" name="bill_province" onchange="showAmphure(2)">
                                        <option selected></option>  
                                        <?php foreach($province as $index => $value) { ?>
                                                <option value="<?php echo $value['province_id'] ?>">
                                                    <?php echo $value['province_name'] ?>
                                                </option>
                                        <?php } ?>
                                    </select> -->
                                </div>
                                <div class="col">
                                    <label for="bill_area" class='form-label'>เขต/อำเภอ</label>
                                    <input id='bill_area' name='bill_area' type="text" class="form-control">
                                    <!-- <select class="form-control" id="bill_area" name="bill_area" onchange="showDistrict(2)">
                                        <option selected></option>                         
                                    </select> -->
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    <label for="bill_province" class='form-label'>จังหวัด</label>
                                    <input id='bill_province' name='bill_province' type="text" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="bill_postal_code" class='form-label'>รหัสไปรษณีย์</label>
                                    <input id='bill_postal_code' name='bill_postal_code' type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div id="st-5">
                            <p class="pt-3">เอกสารประกอบการสมัคร</p>
                            <div class="m-3">
                                <label for="form-label">1. รูปถ่ายสี</label>
                                <input type="file" name="image" id="image">
                            </div>
                            <div class="mx-3 my-3">
                                <label for="form-label">2. สำเนาบัตรราชการหรือสำเนาบัตรประจำตัวผู้สมัคร พร้อมรับรองสำเนาถูกต้อง</label>
                                <input type="file" name="image02" id="image02">
                            </div>                            
                        </div>
                        <div>
                            <p class="pt-3">รับประทานอาหาร</p>
                            <div class="mx-3 my-3">
                                <label for="food_type" class='form-label'>เลือกอาหาร</label>
                                <select id="food_type" name="food_type" class="form-select" aria-label="Default select example">
                                    <option selected></option>
                                    <option value="มังสวิรัติ">มังสวิรัติ</option>
                                    <option value="ฮาลาล">ฮาลาล</option>
                                    <option value="ปกติ">ปกติ</option>
                                </select>
                            </div>                               
                        </div>
                        <div>
                            <p class="pt-3">การยินยอมให้เปิดเผยข้อมูลส่วนบุคคล</p>
                            <div class="m-2">
                                <input type="checkbox" id="check_01" name="check_01" onclick="policy_enroll_check()">
                                <p class="font-size-p" style="display: inline;">ข้าพเจ้าได้อ่านและยอมรับนโยบายคุ้มครองข้อมูลส่วนบุคคลนี้แล้ว
                                    <span id="dot01">...</span>
                                    <span id="read01" onclick="showMore(1)">อ่านต่อ...</span> 
                                    <span id="more01" style="display: none;">ข้าพเจ้ายินยอมให้หลักสูตรฯ เก็บรวบรวม ใช้ หรือเปิดเผยข้อมูลส่วนบุคคลของข้าพเจ้า
                                    เพื่อให้บรรลุวัตถุประสงค์ในการฝึกอบรมรวมถึงการรับบริการวิชาการและวัตถุประสงค์อื่นใดที่เกี่ยวเนื่องกัน</span>
                                </p><br>
                                <input type="checkbox" id="check_02" name="check_02" onclick="policy_enroll_check()">
                                <p class="font-size-p" style="display: inline;">ข้าพเจ้ายินยอมให้หลักสูตรฯ เก็บรวบรวม ใช้ หรือเปิดเผยข้อมูลส่วนบุคคลของข้าพเจ้า
                                    <span id="dot02">...</span>
                                    <span id="read02" onclick="showMore(2)">อ่านต่อ...</span>
                                    <span id="more02" style="display: none;">เพื่อให้บรรลุวัตถุประสงค์ในการทำการตลาดแบบตรง ประชาสัมพันธ์เพื่อส่งเสริมการขายต่างๆ สถาบันบัณฑิตพัฒนบริหารศาสตร์ผ่านทางอีเมล 
                                    (email) ข้อความสั้น(SMS/MMS) และโซเชียลมีเดีย (social media) ให้กับข้าพเจ้าได้ ทั้งนี้ ข้าพเจ้าเข้าใจดีว่า 
                                    ข้าพเจ้าสามารถยกเลิกการรับข้อความการสื่อสารทางการตลาดจากหลักสูตรฯ เมื่อใดก็ได้ โดยกดลิงค์ขอยกเลิกการรับข้อความการสื่อสารทางการตลาด 
                                    (unsubscribe) หรือแจ้งยกเลิกการรับข้อความการสื่อสารทางการตลาดไปยังหลักสูตรฯ เบอร์โทรศัพท์ 098-6397859 
                                    อีเมล modern.budgeting.management@gmail.com</span>
                                </p><br>
                                <input type="checkbox" id="check_03" name="check_03" onclick="policy_enroll_check()">
                                <p class="font-size-p" style="display: inline;">ข้าพเจ้ายินยอมให้หลักสูตรฯ เก็บรวบรวม ใช้ หรือเปิดเผยข้อมูลส่วนบุคคลชนิดพิเศษของข้าพเจ้า
                                    <span id="dot03">...</span>
                                    <span id="read03" onclick="showMore(3)">อ่านต่อ...</span>                                    
                                    <span id="more03" style="display: none;">อาทิเช่น ข้อมูลจำลองใบหน้า เป็นต้น เพื่อให้บรรลุวัตถุประสงค์ในการรักษาความปลอดภัยของสถานที่ 
                                    รวมทั้งป้องกันหรือระงับอันตรายต่อชีวิต ร่างกาย สุขภาพและทรัพย์สินของบุคคลเท่านั้น ทั้งนี้ ข้าพเจ้าเข้าใจดีว่า 
                                    ข้าพเจ้ามีสิทธิถอนความยินยอมข้างต้นเสียเมื่อใดก็ได้ โดยส่งข้อความไปยัง หลักสูตรฯ การถอนความยินยอมไม่ส่งผลกระทบต่อเก็บรวบรวม ใช้ หรือเปิดเผยข้อมูลส่วนบุคคล
                                    ที่ได้ดำเนินการไปแล้วบนฐานความยินยอมนั้น</span>
                                </p>
                            </div>
                        </div>

                        <!-- enroll_id ประกาศมาเพื่อเก็บข้อมูลไว้ทำ ref_1 -->
                        <input id="enroll_id" name="enroll_id" type="hidden">

                        <!-- project_id ประกาศมาเพื่อดึงข้อมูลว่าใน project_id นี้มี หลักสูตรอะไรอยู่บ้าง -->
                        <input id="project_id" name="project_id"type="hidden">

                        <!-- project_name ประกาศมาเพื่อเก็บข้อมูลใน database ช่อง enroll_project -->
                        <input id="project_name" name="project_name" type="hidden">

                        <!-- date ประกาศมาเพื่อเก็บ birthday ให้เป็นรูปแบบที่ต้องการ y-m-d -->
                        <input id="date" name="date" type="hidden">

                        <input type="hidden" name="province_name" id="province_name">
                        <input type="hidden" name="amphur_name" id="amphur_name">
                        <input type="hidden" name="district_name" id="district_name">
                    </form>
                    <div class="d-flex justify-content-center mb-3 px-2">
                        <!-- <button id="prev_btn" class="btn btn-prev tab mx-2" onclick="prev_step()">ก่อนหน้า</button>
                        <button id="next_btn" class="btn btn-primary" onclick="next_step()">ถัดไป</button> -->
                        <button id="save_btn" class="btn btn-primary" disabled>ลงทะเบียน</button>                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#project_id").val(<?php echo $project[0]['id'] ?>)
            $("#project_name").val('<?php echo $project[0]['project_name'] ?>')
            
            $('#save_btn').click(function (){
                event.preventDefault()
                let url = window.location.origin + "/Enroll/ajax_create_enroll"
                let date = $('#year').val() + '-' + $('#month').val() + '-' + $('#day').val()
                $('#date').val(date)
                $.ajax({
                    type:'POST',
                    url: url,
                    data: $('#modal_form').serialize(),           
                    success:function(res){
                        data = JSON.parse(res)
                        let url = window.location.origin + "/Enroll/upload"
                        let form_data = new FormData()
                        let img = $("#image")[0].files
                        let img02 = $('#image02')[0].files
                        form_data.append('my_image', img[0])
                        form_data.append('my_image02',img02[0])
                        form_data.append('ref_1', data.ref_1)
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: form_data,
                            contentType: false,
                            processData: false,
                            success: function(res){
                                document.location.href = window.location.origin + '/pay/' + data.ref_1; 
                            }
                        });                           
                    },
                    // error: function(xhr, ajaxOptions, thrownError){
                    //     swal("ผิดพลาด", "เลขบัตรประชาชนไม่ถูกต้อง", "error");
                    // }
                });            
            });      
        });

        function show_subject(){
            // เลือก จังหวัดที่ท่านทำงานอยู่ จากนั้นแสดงวิชาที่เปิด
            let x = $("#work_province").val()
            let project_id = $('#project_id').val()
            $('#subject_name').empty()
            $.ajax({
                type: 'POST',
                url: window.location.origin + '/subject/get_subject_in_geo',
                data:{
                    geo_id: x,
                    project_id: project_id
                },
                success: function(res){
                    data = JSON.parse(res)
                    createOptionTag(data, 'subject_name', 'code', 'name')
                }
            })
        }

        function show_open_province(){
            //เลือกวิชาเสร็จ แสดงจังหวัดที่เปิดสอน
            var x = document.getElementById("subject_name").value;
            $("#enroll_id").val(x)
            $("#open_province").empty()
            $.ajax({
                type:'POST',
                url: window.location.origin + '/subject/ajax_get_open_province',
                data: {
                    subject_code : x
                },
                success: function(res){
                    data = JSON.parse(res)
                    createOptionTag(data, 'open_province', 'open_province', 'open_province')
                }
            });
        }

        function showAmphure(type){
            let province_id = ''
            if(type === 2){
                province_id = $("#bill_province").val()
                console.log(province_id)
            }
            else{
                province_id = $("#province").val()
                var x = document.getElementById('province')
                $("#province_name").val(x.options[x.selectedIndex].text)
                // reset value in select tag and input id postal_code
                $('#area').empty()
                $("#sub_area").empty()
                document.getElementById("postal_code").defaultValue = ""
            }            
            $.ajax({
                type: 'POST',
                url: window.location.origin + '/province/ajax_get_amphure',
                data: {
                    province_id: province_id
                },
                success: function(res){
                    data = JSON.parse(res)
                    if(type == 2){
                        createOptionTag(data, 'bill_area', 'amphur_id', 'amphur_name')
                    }
                    else{
                        createOptionTag(data, 'area', 'amphur_id', 'amphur_name')
                    }
                    
                }
            })
        }

        function showDistrict(type){
            let amphure = ""
            if(type === 2){

            }
            else{
                amphure = $("#area").val()
                var x = document.getElementById('area')
                $("#amphur_name").val(x.options[x.selectedIndex].text)                
                // reset value in select tag id sub_area and input id postal_code
                $('#sub_area').empty()
                document.getElementById("postal_code").defaultValue = ""
            }            
            $.ajax({
                type: 'POST',
                url: window.location.origin + '/province/ajax_get_district',
                data: {
                    amphure_id: amphure
                },
                success: function(res){
                    data = JSON.parse(res)
                    if(type === 2){

                    }else{
                        createOptionTag(data, 'sub_area', 'district_code', 'district_name')
                    }                    
                }
            })
        }

        function showZipcode(){
            let district_code = $("#sub_area").val()
            var x = document.getElementById('sub_area')
            $("#district_name").val(x.options[x.selectedIndex].text)

            //reset value in postal_code when district name change
            document.getElementById("postal_code").defaultValue = ''
            $.ajax({
                type: 'POST',
                url: window.location.origin + '/province/ajax_get_zipcode',
                data: {
                    district_code: district_code
                },
                success: function(res){
                    data = JSON.parse(res)
                    document.getElementById("postal_code").defaultValue = data.zipcode
                }
            })
        }

        function createOptionTag(data, elm_id, value, textNode){
            var elm = document.getElementById(elm_id),
                df = document.createDocumentFragment()
            for (var i = -1; i < data.length; i++) {
                if(i !== -1){
                    var option = document.createElement('option')
                    option.value = data[i][value]
                    option.appendChild(document.createTextNode(data[i][textNode]))  
                    df.appendChild(option)
                }
                else{
                    var option = document.createElement('option')
                    option.value = ''
                    option.appendChild(document.createTextNode(''))
                    df.appendChild(option)
                }
            }
            elm.appendChild(df)
        }

        function getSameAddress() {
            var checkBox = document.getElementById("check");
            var cop = $("#cop").val()
            var address = $("#address").val()
            var road = $("#road").val()
            var sub_area = $("#sub_area").val()
            var area = $("#area").val()
            var province = $("#province").val()
            var postal_code = $("#postal_code").val()
            if (checkBox.checked == true){
                document.getElementById("bill_cop").defaultValue = cop
                document.getElementById("bill_house").defaultValue = address
                document.getElementById("bill_road").defaultValue = road
                document.getElementById("bill_sub_area").defaultValue = $("#district_name").val()
                document.getElementById("bill_area").defaultValue = $("#amphur_name").val()
                document.getElementById("bill_province").defaultValue = $("#province_name").val()
                document.getElementById("bill_postal_code").defaultValue = postal_code
            } else {
                document.getElementById("bill_cop").defaultValue = ''
                document.getElementById("bill_house").defaultValue = ''
                document.getElementById("bill_road").defaultValue = ''
                document.getElementById("bill_sub_area").defaultValue = ''
                document.getElementById("bill_area").defaultValue = ''
                document.getElementById("bill_province").defaultValue = ''
                document.getElementById("bill_postal_code").defaultValue = ''
            }
        }

        function showMore(hide){
            let dot = "dot0" + hide
            let read = "read0" + hide
            let more = "more0" + hide
            document.getElementById(dot).style.display = "none"
            document.getElementById(read).style.display = "none"
            document.getElementById(more).style.display = "inline"
        }

        function policy_enroll_check(){
            var checkBox_1 = document.getElementById("check_01");
            var checkBox_2 = document.getElementById("check_02");
            var checkBox_3 = document.getElementById("check_03");
            console.log(checkBox_1.checked,checkBox_2.checked,checkBox_3.checked)
            if(checkBox_1.checked == true && checkBox_2.checked == true && checkBox_3.checked == true){
                document.querySelector('#save_btn').disabled = false;
            }
            else{
                document.querySelector('#save_btn').disabled = true;
            }
        }

        (function() {
            var elm_day = document.getElementById('day'),
                df_day = document.createDocumentFragment()
            for (var i = 1; i <= 31; i++) {
                var option_day = document.createElement('option')
                option_day.value = i
                option_day.appendChild(document.createTextNode(i))
                df_day.appendChild(option_day)
            }
            elm_day.appendChild(df_day)

            var arr_month = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"]
            var elm_month = document.getElementById('month'),
                df_month = document.createDocumentFragment()
            for(var i = 0; i <= 11;i++){
                var option_month = document.createElement('option')
                option_month.value = arr_month[i]
                option_month.appendChild(document.createTextNode(arr_month[i]))
                df_month.appendChild(option_month)
            }
            elm_month.appendChild(df_month)

            var elm_year = document.getElementById('year'),
                df_year = document.createDocumentFragment()
            var year = new Date()
            var i = year.getFullYear() + 543
            console.log(i)
            for(var j = i; j >= i-100;j--){
                var option_year = document.createElement('option')
                option_year.value = j
                option_year.appendChild(document.createTextNode(j))
                df_year.appendChild(option_year)
            }
            elm_year.appendChild(df_year)
        }())
    </script>
</body>
</html>