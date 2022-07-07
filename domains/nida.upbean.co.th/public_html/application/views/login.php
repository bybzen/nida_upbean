<?php

header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Bangkok');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Kanit:400&display=swap&subset=thai" rel="stylesheet">
    <style>
        .login { max-width: 800px; }
        .login-body { padding: 0; }
        .login-wrap { padding: 80px 30px; }
        .login-brand { margin-left: 0; margin-right: 0; width: 170px; }
        .banner_login { background: rgb(239, 176, 125); background: linear-gradient(45deg, #006633 0%, #003333 90%); }
        .banner_login img { width: 100%; }
    </style>
</head>
<body>
<div class="login">
    <div class="login-body">
        <div class="row">
            <div class="col-md-5" style="padding-right: 0;">
                <div class="login-wrap">
                    <h3 style="color: #000;">GSPA NIDA</h3>
                    <h4>ยินดีต้อนรับระบบแอดมิน</h4>
                    <h3 style="margin-top: 0; color: #000;">เข้าสู่ระบบ</h3>
                    <div class="login-form">
                        <?php if(@$_GET["error"] == 1) { ?><div class="alert alert-danger" role="alert">อีเมล์/รหัสผ่าน ไม่ถูกต้อง</div><?php } ?>
                        <form method="post" data-toggle="validator" action="">
                            <input type="hidden" name="do" value="login">
                            <div class="form-group">
                                <label for="email">อีเมล์</label>
                                <input id="email" class="form-control" type="text" name="username" value="" spellcheck="false" autocomplete="off" data-msg-required="กรุณาป้อนอีเมล์" required>
                            </div>
                            <div class="form-group">
                                <label for="password">รหัสผ่าน</label>
                                <input id="password" class="form-control" type="password" name="password" data-msg-required="กรุณาป้อนรหัสผ่าน" required>
                            </div>
                            <button class="btn btn-primary btn-block" type="submit">เข้าสู่ระบบ</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7" style="padding-left: 0;">
                <div class="banner_login hidden-xs hidden-sm">
                    <img src="/assets/images/login.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
