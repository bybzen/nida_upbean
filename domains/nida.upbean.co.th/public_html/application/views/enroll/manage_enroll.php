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
                                <input  id="filter_search" class="" name="filter_search" type="text" style="width:350px;  height : 35px; margin-left : 10px;"  placeholder="ชื่อนามสกุล/เบอร์โทร/เลขบัตรประชาชน">
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
                                <th class="text-center">วันที่/เวลา</th>
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

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin">Ref1</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="ref_1" name="ref_1" readonly>
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> วันที่ลงทะเบียน</label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="created_at" name="created_at" >
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> ชื่อนามสกุล </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> เบอร์โทร </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="tel" name="tel" placeholder="ex.0888888xxx">
                        </div>
                    </div>

                    <div class="g24-col-sm-24 margin-10">
                        <label class="g24-col-sm-6 text-right label-margin"> เลขบัตรประชาชน </label>
                        <div class="g24-col-sm-14">
                            <input type="text" class="form-control" id="id_card" name="id_card">
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
                            <input type="text" class="form-control" id="cost" name="cost">
                        </div>
                    </div>
                    
                    

                    <div id="payment_wrap">
                        <div class="g24-col-sm-24 margin-10">
                            <label class="g24-col-sm-6 text-right label-margin">สถานะ</label>
                            <div class="g24-col-sm-14">
                                <label>
                                    <input type="radio" name="payment_status" value="ชำระเงินแล้ว" class="payment_status"> ชำระเงินแล้ว 
                                </label> &nbsp;
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
            let firstname = $('#firstname').val();
            let lastname = $('#lastname').val();

            let warning_text = "";

            if (warning_text == ''){

                toSplitName(name) 

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

            return numOfDay + " " + month + " " + year + " " + time + " น.";
      
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


    function edit(ref_1){
        $('#ref_1').attr('onchange');
        $.ajax({
            type:'POST',
            url:base_url+'enroll/ajax_show_page_edit_enroll',
            data: {
                ref_1 : ref_1,
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
                $('#tel').val(data.tel);
                $('#id_card').val(data.id_card);
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
                    console.log("มีค่า", data)
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
                            table_data += ` 
                            <tr>
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

</script>
