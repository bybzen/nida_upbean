<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>select subject</title>
</head>
<style>
    body{
        font-family: 'Kanit', sans-serif;
        font-size: calc(60% + 0.6vmin);
    }
    .btn.btn-primary{
        background-color: #097969;
        border-color: #097969;
    }
    .btn.btn-primary:hover{
        background-color: #50C878;
        border-color: #50C878;
    }
    .set-btn{
        position: relative;
    }
    button {
        position: absolute;
        bottom: 0;
    }
</style>
<body>
    <div class="container">
    <input type="hidden" name="project_id" id="project_id">
        <div class="row mt-4">
            <?php foreach ($subject as $index => $value) { ?>
                <div class="col-md-3 m-4 set-btn" style="">
                    <div class="card text-center" style="background-color: #EEDC82; border: none;">
                        <div class="p-1">
                            <label for="name_short">
                                <?php echo $value['name_short'] ?>
                            </label>
                        </div>
                        <div class="p-1">
                            <label for="name">
                                <?php echo $value['name'] ?>
                            </label>
                        </div>
                        <div class="p-1">
                            <label for="name_eng">
                                <?php echo $value['name_eng'] ?>
                            </label>
                        </div>
                        <div class="p-1" style="text-align:left">
                            <?php echo $value['detail'] ?>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <button class="btn btn-primary" onclick="enroll_subject(<?php echo $value['id'] ?>,'<?php echo $value['code'] ?>')">สมัครเข้าร่วมโครงการ</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#project_id").val(<?php echo $project['id'] ?>)
    });
    function enroll_subject(id,code){
        let project_id = $("#project_id").val()
        window.open(window.location.origin + '/enroll?project_id=' + project_id + '&' + 'subject_id=' + id + '&' + 'subject_code=' + code, "_self")
    }
</script>
</body>
</html>