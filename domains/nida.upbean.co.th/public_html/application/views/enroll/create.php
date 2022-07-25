<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Enroll Subject</title>
    <style>
        .mx-5{
            margin-left: 37vw !important;
            margin-right: 37vw !important;
            margin-top: 4vw !important;
        }
        .button-center{
            margin-left: 11vw;
            margin-right: 11vw;
        }
    </style>
</head>
<body>
    <div class="card border-0 mx-5" style="width: 25rem;">
        <h4 class="text-center my-3">ลงทะเบียนหลักสูตร</h4>
        <form id="modal_form">
            <div class="mb-3">
                <label for="firstname" class="form-label">ชื่อจริง</label>
                <input id="firstname" name="firstname" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">นามสกุล</label>
                <input id="lastname" name="lastname" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="id" class="form-label">เลขบัตรประจำตัวประชาชน</label>
                <input id="id" name="id" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">เบอร์มือถือ</label>
                <input id="tel" name="tel" type="text" class="form-control" required>
            </div>

            <input id="enroll_id" name="enroll_id" type="hidden">

            <button  id="save_btn" class="btn btn-primary button-center" style="center" >Submit</button>
            <!-- <button  onclick="FormatID('1104300278064')" class="btn btn-primary button-center" style="center" >Submit</button> -->
        </form>
    </div>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){   
            $('#enroll_id').val(<?php echo $subject['id'] ?>)
            
            $('#save_btn').click(function (){
                event.preventDefault()
                let url = window.location.origin + "/Enroll/ajax_create_enroll"
                let firstname = $('#firstname').val()
                let lastname = $('#lastname').val()
                let id = $('#id').val()
                let tel = $('#tel').val()
                if(firstname !== '' && lastname !== '' && id !== '' && tel !== ''){
                    $.ajax({
                        type:'POST',
                        url: url,
                        data: $('#modal_form').serialize(),                    
                        success:function(res){
                            data = JSON.parse(res)           
                            document.location.href = window.location.origin + '/pay/' + data.ref_1;                    
                        },
                        error: function(xhr, ajaxOptions, thrownError){
                            swal("ผิดพลาด", "เลขบัตรประชาชนไม่ถูกต้อง", "error");
                        }
                    });  
                }            
            });      
        });
        function FormatID(id){
            console.log(id)
            let check = 0
            let minus = 13;
            for(let i=0; i<12; i++){
                check += (parseInt(id[i])*minus)
                minus--
            }
            check = 11 - (check % 11)
            let string = check.toString()
            return string[string.length - 1]
        }
    </script>
</body>
</html>