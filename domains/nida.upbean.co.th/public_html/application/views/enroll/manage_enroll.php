<style>
    .margin-10 {
        margin: 7px ;
    }

    .label-margin {
        margin-top: 8px ;
    }


</style>


<div class="layout-content">
    <div class="layout-content-body">
        <div class="row gutter-xs">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-body" style="padding-top:0px !important;">
                    <div class="g24-col-sm-24" style="margin-bottom: 0px">
                        <h2>ข้อมูลการสมัคร</h2>
                    </div>
                       
                        <form method="GET" id="search_form">
                            <div class="" style="margin-bottom: 20px">
                                <label><h2>ค้นหา</h2></label>
                                <input  id="filter_search" class="" name="filter_search" type="text" style="width:350px;  height : 35px; margin-left : 10px;"  placeholder="ชื่อนามสกุล/เบอร์โทร">
                            </div>  
                        </form>
                        
                        <!-- margin: top, right, bottom, left -->
                        <div style=" margin:-65px 0px 20px 427px " > 
                            <button id='btn_search' class="btn btn-primary"  name="btn_search" >ค้นหา</button>                   
                        </div>
                        
                     
                    <div class="g24-col-sm-24">
                        <table class="table" >
                            <tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">Ref1</th>
                                <th class="text-center">วันเวลาที่ลงทะเบียน</th>
                                <th class="text-center">ชื่อนามสกุล</th>
                                <th class="text-center">เบอร์โทร</th>
                                <th class="text-center">หลักสูตร</th>
                                <th class="text-center">จำนวนเงิน</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center"></th>
                            </tr>
                            <?php foreach ($enroll as $index => $value){ ?>
                                
                                <tr>
                                    <!-- <?php print_r($value['name']) ?>  print array  -->
                                    <td class="text-center"><?php echo $index+1 ?></td> <!-- ลำดับ -->
                                    <td class="text-center"><?php echo $value['ref_1'] ?></td> <!-- ref 1 -->
                                    <!-- วันที่ลงทะเบียน -->
                                    <td class="text-center"><?php echo $this->center_function->ConvertToThaiDate($value['created_at']) ?></td>
                                    <td class="text-center"><?php echo $value['firstname']." "." ".$value['lastname'] ?></td> <!-- ชื่อนามสกุล -->
                                    <td class="text-center"><?php echo $value['tel'] ?></td> <!-- เบอร์ + บัตร ปชช -->
                                    <td class="text-center"><?php echo $value['enroll_subject'] ?></td> <!-- หลักสูตร -->
                                    <td class="text-center"><?php echo number_format($value['enroll_cost'],2) ?></td>
                                    <!-- สถานะ -->
                                    <?php if($value['payment_status'] == "ชำระเงินแล้ว"){ ?>
                                        <td class=" text-center" style="color:#006633;" ><?php echo $value['payment_status']?></td>
                                    <?php } else{?>
                                        <td class="text-center" style="color:#CB824AFF" ><?php echo $value['payment_status']?></td>
                                    <?php }?>

                                    <td>
                                        <a  id = "edit_<?php echo $value['ref_1'] ?>" onclick="edit(<?php echo $value['ref_1'] ?>)">
                                            จัดการ 
                                        </a>
                                        |
                                        <a onclick="del(<?php echo $value['ref_1'] ?>)" style="color:red;">
                                            ลบ
                                        </a> 
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
                <h2 class="modal-title" id="type_name">ข้อมูลการสมัคร</h2>
            </div>
            <div class="modal-body clearfix">
                <form id="modal_form" method="POST">
                    <input type="hidden" id="firstname" name="firstname">
                    <input type="hidden" id="lastname" name="lastname">
                    <input type="hidden" id="birthday" name="birthday">
                    
                    <div class="g24-col-sm-24 margin-10" style="margin-top: -10px";>
                        <h3><b><u> ข้อมูลส่วนตัวผู้สมัคร </u></b></h3>
                    </div>                    
                    
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">Ref1</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="ref_1" name="ref_1" readonly>
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> วันที่ลงทะเบียน</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="created_at" name="created_at" readonly >
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อนามสกุล </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <!-- <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> วันเกิด </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="birthday" name="birthday">
                        </div>
                    </div> -->

                    <div class="g24-col-sm-24 margin-10">
                        <label for="birthday" class="g24-col-sm-6 text-right label-margin">วัน/เดือน/ปี เกิด</label>
                            <div class="g24-col-sm-4">
                                    <select class="form-control" id="day" name="day">
                                        <option selected></option>
                                    </select>
                            </div>     

                            <div class="g24-col-sm-6">  
                                    <select class="form-control" id="month" name="month">
                                        <option selected></option>
                                    </select>
                            </div>    

                            <div class="g24-col-sm-4">           
                                    <select class="form-control" id="year" name="year">
                                        <option selected></option>
                                    </select>
                            </div>
                    </div> 

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> เบอร์โทร </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="tel" name="tel" placeholder="ex.0888888xxx">
                        </div>
                    </div>
                    
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> Email </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อหน่วยงาน </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="cop" name="cop">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ตำแหน่ง </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="position" name="position">
                        </div>
                    </div>
                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ที่อยู่ที่ทำงาน </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ถนน </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="road" name="road">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> เขต/อำเภอ </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="sub_area" name="sub_area">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> แขวง/ตำบล </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="area" name="area">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> จังหวัด </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="province" name="province">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> รหัสไปรษณีย์ </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-7 text-left label-margin"> บุคคลที่ติดต่อได้ในกรณีฉุกเฉิน </label>
                        <div class="g24-col-sm-13">
                            <input type="text" class="form-control" id="person_to_notify" name="person_to_notify">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10" >
                        <label class="g24-col-sm-7 text-left label-margin"> หมายเลขบุคคลที่ติดต่อได้ในกรณีฉุกเฉิน </label>
                        <div class="g24-col-sm-13">
                            <input type="text" class="form-control" id="tel_person_to_notify" name="tel_person_to_notify">
                        </div>
                    </div>
                    
                    <div class="g24-col-sm-24 margin-10 " style=" margin-top: 10px">
                        <h3><b><u> ที่อยู่ที่ต้องการออกใบเสร็จ </u></b></h3>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อที่ใช้ออกใบเสร็จ </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_name" name="bill_name">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ที่อยู่เลขที่ </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_house" name="bill_house">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ถนน </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_road" name="bill_road">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> เขต/อำเภอ </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_sub_area" name="bill_sub_area">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> แขวง/ตำบล </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_area" name="bill_area">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> จังหวัด </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_province" name="bill_province">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> รหัสไปรษณีย์ </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="bill_postal_code" name="bill_postal_code">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10 " style=" margin-top: 10px">
                        <h3><b><u> เอกสารประกอบการสมัคร  </u></b></h3>
                    </div>
                    
                    <div class="g24-col-sm-24 margin-10">
                        <label for="form-label" class="g24-col-sm-24 text-left label-margin" >1. รูปถ่ายสี</label>
                            <!-- <input type="file" name="image" id="image"> -->
                        <div class="preview">
                            <img src="" id="show_photo1" width="100" height="100">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10 ">
                        <label for="form-label" class="g24-col-sm-24 text-left label-margin" >
                            2. สำเนาบัตรราชการหรือสำเนาบัตรประจำตัวผู้สมัคร พร้อมรับรองสำเนาถูกต้อง</label>
                        <!-- <input type="file" name="image02" id="image02"> -->
                        <div class="preview">
                            <img src="" id="show_photo2" width="100" height="100">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10 " style=" margin-top: 10px">
                        <h3><b><u>รับประทานอาหาร</u></b></h3>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                            <!-- <label class="g24-col-sm-6 text-right label-margin">อาหาร</label> -->
                            <div class="g24-col-sm-14">
                                <label><input type="radio" name="food_type" value="มังสวิรัติ" class="food_type" > มังสวิรัติ </label> 
                                &nbsp; &nbsp;
                                
                                <label><input type="radio" name="food_type" value="ฮาลาล" class="food_type" > ฮาลาล </label>
                                &nbsp; &nbsp;

                                <label> <input type="radio" name="food_type" value="ปกติ" class="food_type"> ปกติ </label>
                            </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10" style=" margin-top: 20px">
                        <label class="g24-col-sm-6 text-right label-margin">โครงการ</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="project" name="project" readonly>
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">หลักสูตร</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="subject" name="subject" readonly>
                        </div>
                    </div>
                    
                    <!-- ของเก่า -->
                    <!-- <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">สาขา</label>
                        <div class="g24-col-sm-14">
                            <select id="subject_name" name="subject_name" class="form-control" onchange="">
                                    <option value="0" selected>--หลักสูตร--</option>
                                <?php foreach ($subject_name as $index => $value) { ?>
                                    <option value="<?php echo $value['name'] ?>"><?php echo $value['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> -->
                    <!-- ของเก่า -->

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">จำนวนเงิน</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="cost" name="cost" readonly>
                        </div>
                    </div>
                    
                    

                    <div id="payment_wrap">
                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">สถานะ</label>
                            <div class="g24-col-sm-14">
                                <label>
                                    <input type="radio" name="payment_status" value="ชำระเงินแล้ว" class="payment_status"> ชำระเงินแล้ว 
                                </label> &nbsp; &nbsp;
                                <label>
                                    <input type="radio" name="payment_status" value="รอชำระเงิน" class="payment_status"> รอชำระเงิน 
                                </label>
                            </div>
                        </div>

                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">วันที่ชำระ</label>
                            <div class="g24-col-sm-8">
                                <input type="text" class="form-control my-date" id="payment_date_d" name="payment_date_d" data-date-language="th-th">
                            </div>


                        </div>

                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">เวลาที่ชำระ</label>

                            <div class="g24-col-sm-4 ">
                                    <select id="payment_date_h" name="payment_date_h" class="form-control">
                                        <?php for($h = 0; $h <= 23; $h++) { ?><option value="<?php printf("%02d", $h); ?>"><?php printf("%02d", $h); ?></option><?php } ?>
                                    </select>
                            </div>
                            <div class="g24-col-sm-4">
                                <select id="payment_date_m" name="payment_date_m" class="form-control">
                                    <?php for($m = 0; $m <= 59; $m++) { ?><option value="<?php printf("%02d", $m); ?>"><?php printf("%02d", $m); ?></option><?php } ?>
                                </select>
                            </div>

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


        $('#save_btn').click(function(){

            let name = $('#name').val(); //เอาค่าจาก id = name
            // let firstname = $('#firstname').val();
            // let lastname = $('#lastname').val();

            let day = $('#day').val();
            let month = $('#month').val();
            let year = $('#year').val();


            let warning_text = "";

            if (warning_text == ''){

                toSplitName(name)
                birthdayToDB(day, month, year)

                $.ajax({
                   type:'POST',
                   url:base_url + "enroll/ajax_edit_data_enroll",
                   data: $('#modal_form').serialize(),

                    success : function(result){
                        
                        // let fname = $('#firstname').val()
                        // let lname = $('#lastname').val()
                        // console.log("---After---")
                        // console.log("fname = ", fname)
                        // console.log("lnaem = ", lname)

                        location.reload();
                    },
                });
                
            } else {
                swal('กรุณากรอกข้อมูล',warning_text,'warning');
            }
        });

        $('#cancle_btn').click(function(){
            $('#add_modal').modal('hide');
        });
    });

    

    function toThaiDateString(day, time) {

        let monthNames = [
            "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.",
            "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.",
            "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
        ];

        let year = parseInt(day[0]) + 543;
        let month = monthNames[day[1]-1];
        let numOfDay = day[2];

        // console.log(numOfDay, month, year, time)

        if(day != null && time != null)
            return numOfDay + " " + month + " " + year + " " + time + " น.";
        
        else if(day != null && time == null)
            return numOfDay + " " + month + " " + year;
    }

    function toSplitDate(date) {

        let date_str = date.toString();
        let date_split = date_str.split(" ");
        let day = date_split[0].split('-')

        // console.log('show',date_split);
        // console.log('day',day)
        
        return toThaiDateString(day, date_split[1]);
    }

    function toSplitName(name) {

        let name_trim = name.trim()
        let name_split = name_trim.split(/\s+/);
        let firstname = name_split[0];
        let lastname = name_split[1];

        $('#firstname').val(firstname);
        $('#lastname').val(lastname);

    }

    //จัดรูปแบบวันที่ลง DB
    function birthdayToDB(d, m, y){
        // let birthday = d.concat(m, y);
        let birthday = d + " " + m + " " + y;
        
        $('#birthday').val(birthday);
        // console.log(birthday);
    }

    //โชว์หน้าข้อมูลสมัคร
    function toSplitBirthday(bd) {

        let birthday_trim = bd.trim();
        let birthday_split = birthday_trim.split(' ');
        let day = birthday_split[0];
        let month = birthday_split[1];
        let year = birthday_split[2];

        $('#day').val(day);
        $('#month').val(month);
        $('#year').val(year);

        // console.log("d = ", day)
        // console.log("m = ", month)
        // console.log("y = ", year)

    }


    function edit(ref_1){
        $('#ref_1').attr('onchange');
        
        // var action = "fetch";
        $.ajax({
            type:'POST',
            url:base_url+'enroll/ajax_show_page_edit_enroll',
            data: {
                ref_1 : ref_1,
                // action : action
            } ,
            success : function(result){
                data = JSON.parse(result);
                let firstname = data.firstname;
                let lastname = data.lastname;
                // $('#firstname').val(data.firstname);
                // $('#lastname').val(data.lastname);
                // console.log("---Before---")
                // console.log("fname = ", firstname)
                // console.log("lname = ", lastname)

                $('#ref_1').val(data.ref_1);
                $('#created_at').val(toSplitDate(data.created_at));
                $('#name').val(firstname.concat("  ", lastname));

                toSplitBirthday(data.birthday);
                
                $('#tel').val(data.tel);
                $('#email').val(data.email);
                $('#cop').val(data.cop);
                $('#position').val(data.position);
                $('#address').val(data.address);
                $('#road').val(data.road);
                $('#sub_area').val(data.sub_area);
                $('#area').val(data.area);
                $('#province').val(data.province);
                $('#postal_code').val(data.postal_code);
                $('#person_to_notify').val(data.person_to_notify);
                $('#tel_person_to_notify').val(data.tel_person_to_notify);
                $('.food_type[value=' + data.food_type + ']').prop('checked', true);
                
                $('#show_photo1').attr('src', "/uploads/" + data.img_path);
                $('#show_photo2').attr('src', "/uploads/" + data.img_path_02);
                $('.preview img').show();

                $('#bill_name').val(data.bill_name);
                $('#bill_house').val(data.bill_house);
                $('#bill_road').val(data.bill_road);
                $('#bill_sub_area').val(data.bill_sub_area);
                $('#bill_area').val(data.bill_area);
                $('#bill_province').val(data.bill_province);
                $('#bill_postal_code').val(data.bill_postal_code);

                $('#project').val(data.enroll_project)
                $('#subject').val(data.enroll_subject);
                $('#cost').val(data.enroll_cost);
                $('.payment_status[value=' + data.payment_status + ']').prop('checked', true);
                $('#payment_date_d').val(data.payment_date_d);
                $('#payment_date_h').val(data.payment_date_h);
                $('#payment_date_m').val(data.payment_date_m);
                
            }
        });
        // $('#ref_1').val(ref_1);
        // $('#modal_type').val(2);
        $('#payment_wrap').removeClass('hidden');
        $('#add_modal').modal('show');
    }

    function del(ref_1){
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
                    // console.log(ref_1)
                    $.ajax({
                        type:'POST',
                        url: base_url+"enroll/ajax_delete_enroll",
                        data : {
                            ref_1: ref_1
                        } ,
                        success: function(data){
                            location.reload();
                        }
                    });
                }
            });
    }


    $('#btn_search').click(function() {
            console.log("filter = " , $('#filter_search').val())

            let filter_search = $('#filter_search').val()
            event.preventDefault()

            $.ajax({
                type: "GET",
                url: base_url + "enroll/ajax_search",
                data: {
                    filter_search: filter_search
                    
                },
                success:function(result){
                    
                    if(result.length != 2)
                {
                    data = JSON.parse(result)
                    // console.log("มีค่า", data)
                    var table_data ="";
                    var count_row = 1;

                    $.each(data, function(key, value){
                        // developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/NumberFormat

                        // หัวข้อตาราง
                        if(count_row == 1){
                            table_data +=    
                            `<tr>
                                <th class="text-center">ลำดับ</th>
                                <th class="text-center">Ref1</th>
                                <th class="text-center">วันที่/เวลา</th>
                                <th class="text-center">ชื่อนามสกุล</th>
                                <th class="text-center">เบอร์โทร/เลขบัตร ปชช</th>
                                <th class="text-center">หลักสูตร</th>
                                <th class="text-center">จำนวนเงิน</th>
                                <th class="text-center">สถานะ</th>
                            </tr>`;
                        }
                        // แสดงค่าลงในตาราง
                        if(value.payment_status == "ชำระเงินแล้ว")
                        {
                            table_data += 
                            `<tr>
                                <td class="text-center">${count_row}</td>
                                <td class="text-center">${value.ref_1}</td>
                                <td class="text-center">${toSplitDate(value.created_at)}</td>
                                <td class="text-center">${value.firstname} ${value.lastname}</td>
                                <td class="text-center">${value.tel}</td>
                                <td class="text-center">${value.enroll_subject}</td>
                                <td class="text-center">${new Intl.NumberFormat('en-US', {minimumFractionDigits: 2}).format(value.enroll_cost)}</td>
                                <td class="text-center" style="color:#006633;">${value.payment_status}</td>

                                <td>
                                    <a  id = "edit_${value.ref_1}" onclick="edit(${value.ref_1})">
                                        จัดการ 
                                    </a>
                                    |
                                    <a onclick="del(${value.ref_1})" style="color:red;">
                                        ลบ
                                    </a> 
                                </td>
                            </tr>`;
                            $('table tbody').html(table_data);
                            count_row++;
                        }

                        else{
                            table_data += ` 
                            <tr>
                                <td class="text-center">${count_row}</td>
                                <td class="text-center">${value.ref_1}</td>
                                <td class="text-center">${toSplitDate(value.created_at)}</td>
                                <td class="text-center">${value.firstname} ${value.lastname}</td>
                                <td class="text-center">${value.tel}</td>
                                <td class="text-center">${value.enroll_subject}</td>
                                <td class="text-center">${new Intl.NumberFormat('en-US', {minimumFractionDigits: 2}).format(value.enroll_cost)}</td>
                                <td class="text-center" style="color:#CB824AFF;">${value.payment_status}</td>
                                
                                <td>
                                    <a  id = "edit_${value.ref_1}" onclick="edit(${value.ref_1})">
                                        จัดการ 
                                    </a>
                                    |
                                    <a onclick="del(${value.ref_1})" style="color:red;">
                                        ลบ
                                    </a> 
                                </td>
                            </tr>`;
                            $('table tbody').html(table_data);
                            count_row++;
                        }
                    }); 
                }
                    else{
                        console.log("len",result.length," --> ", result[0], result[1])
                        swal('ไม่พบข้อมูล',"",'warning');
                    }
            },
                error: function(err){
                    console.log("ไม่มีค่า", err)
                    swal('ไม่พบข้อมูล',"",'warning');
                }
            })
        });

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
