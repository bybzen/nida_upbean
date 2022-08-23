<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>Document</title>
    <style>
        .mt-5{
            margin-top: 2vw !important;
        }
    </style>
</head>
<body>
    <div class="mt-5 d-flex justify-content-center">
        <div class="text-center">
            <img src="<?php echo "/assets/images/correct.png" ?>" class="mb-3" style="width: 9vw; height: 9vw" alt="correct">
            <p>ท่านได้ทำการลงทะเบียนหลักสูตร</p>
            <p><?php echo $enroll_data[0]['enroll_subject'] ?></p>
            <p>เรียบร้อยแล้ว</p>
            <p>ท่านสามาถสแกน QRCODE เพื่อชำระเงิน</p>
            <p>หรือพิมพ์ใบ Pay-in Slip เพื่อนำไปชำระเงินที่ธนาคารได้ทั่วประเทศ</p>
            <button onclick="print_qr(<?php echo $enroll_data[0]['ref_1'] ?>)" class="my-4 btn bg-success text-white border-0">พิมพ์ใบ Pay-in Slip</button>
            <p>หลังจากชำระเงินแล้ว 48 ชั่วโมง สามาถตรวจสอบการชำระเงินของท่าน</p>
            <p>ได้ที่เมนูตรวจสอบการชำระเงิน</p>
        </div>
        <form method="post" target="_blank" action="" id="print_qr_form" action="">
            <input type="hidden" id="qr_ref_1" name="qr_ref_1">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function print_qr(ref_1){
            // console.log(ref_1)
            // $.ajax({
            //     type: 'POST',
            //     url: window.location.origin + '/enroll/ajax_print',
            //     data: {
            //         ref_1 : ref_1
            //     },
            //     success:function(result){
            //         let a_edit = '#edit-del-' + order_id ;
            //         $(a_edit).attr('style','display:none');
            //         $('#print_qr_form').attr('action',window.location.origin+"/enroll/bill_payment");
            //         $('#qr_ref_1').val(ref_1);
            //         $('#print_qr_form').submit();
            //         document.location.href = window.location.origin + '/enroll/bill_payment';   
            //     }
            // });
            // $('#print_qr_form').attr('action',window.location.origin+"/enroll/bill_payment");
            // $('#qr_ref_1').val(ref_1);
            // $('#print_qr_form').submit();
            document.location.href = window.location.origin + '/enroll/bill_payment/' + ref_1;
        }
    </script>
</body>
</html>