<?php

function chk_permission($id, $s_user = NULL, $s_permissions = NULL, $user, $permissions) {
   // global $user, $permissions;
    //echo"<pre>";print_r($user);print_r($permissions);echo"</pre>";//exit;
    if($s_user !== NULL) {
        $_user = $s_user;
        $_permissions = $s_permissions;
    }
    else {
        $_user = $user;
        $_permissions = $permissions;
    }

    $is_permission = FALSE;

    if(@$_permissions[$id]) {
        $is_permission = TRUE;
    }
    /*if($id == 10 && $_user["user_type_id"] != 1) {
        $is_permission = FALSE;
    }*/
    if($_user["user_type_id"] == 1) {
        $is_permission = TRUE;
    }

    return $is_permission;
}
function get_menu($menus, $url) {
    $_menu = array();
    foreach ($menus as $menu) {
        if ($menu["url"] == $url) {
            return $menu;
        } else if (!empty($menu["submenus"]) && empty($_menu)) {
            $_menu = get_menu($menu["submenus"], $url);
        }
    }
    return $_menu;
}

function get_menu_id($menus, $url) {
    $id = -1;
    if(!empty($menus)) {
        foreach ($menus as $menu) {
            if ($menu["url"] == $url  && $url != '') {
                return $menu["id"];
            } else if (!empty($menu["submenus"]) && $id == -1) {
                $id = get_menu_id($menu["submenus"], $url);
            }
        }
    }

    return $id;
}
?>
<style>
    .sidenav-label {
        margin-left: 15px;
    }

    .navbar-default .navbar-account-btn {
        color: #888888;
    }
    .circle {
        margin-right: 10px;
    }
</style>
<div class="layout-header">
    <div class="navbar navbar-default">
        <div class="navbar-header">
            <a class="navbar-brand navbar-brand-center" href="/">
                <span style="font-size: 28px;font-family: 'upbean';letter-spacing:3px;font-weight:bold;">GSPA NIDA</span>
            </a>
            <button class="navbar-toggler visible-xs-block collapsed" type="button" data-toggle="collapse" data-target="#sidenav">
                <span class="sr-only">Toggle navigation</span>
            <span class="bars">
              <span class="bar-line bar-line-1 out"></span>
              <span class="bar-line bar-line-2 out"></span>
              <span class="bar-line bar-line-3 out"></span>
            </span>
            <span class="bars bars-x">
              <span class="bar-line bar-line-4"></span>
              <span class="bar-line bar-line-5"></span>
            </span>
            </button>
            <button class="navbar-toggler visible-xs-block collapsed" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="arrow-up"></span>
            <span class="ellipsis ellipsis-vertical">
                <?php
                    $image_properties = array(
                        'src'   => 'assets/images/templete_img/0180441436.jpg',
                        'alt'   => 'Teddy Wilson',
                        'class' => 'ellipsis-object',
                        'width' => '32',
                        'height'=> '32',
                    );
                    img($image_properties);
                ?>
            </span>
            </button>
        </div>
        <div class="navbar-toggleable">
            <nav id="navbar" class="navbar-collapse collapse" style="background-color: #eceff1">
                <button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" aria-expanded="true" type="button">
                    <span class="sr-only">Toggle navigation</span>
              <span class="bars">
                <span class="bar-line bar-line-1 out"></span>
                <span class="bar-line bar-line-2 out"></span>
                <span class="bar-line bar-line-3 out"></span>
                <span class="bar-line bar-line-4 in"></span>
                <span class="bar-line bar-line-5 in"></span>
                <span class="bar-line bar-line-6 in"></span>
              </span>
                </button>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown hidden-xs" id="dropdown_li" open_now="false">
                        <button class="navbar-account-btn" id="dropdown_btn" data-toggle="dropdown" aria-haspopup="true" >
							<?php 
								if(@$user['user_pic']!=''){
									$user_pic = PROJECTPATH."/assets/uploads/user_pic/".$user['user_pic'];
								}else{
									$user_pic = PROJECTPATH."/assets/images/member/1.jpg";
								}
							?>
                            <img class="circle" width="36" height="36" src="<?php echo $user_pic; ?>" alt=""> <?php echo $_SESSION['USER_NAME']; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo PROJECTPATH; ?>/main_menu/profile">เปลี่ยนรหัสผ่าน</a></li>
                            <li><a href="<?php echo PROJECTPATH; ?>/main_menu/logout" class="logout">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                    <script>
                        /*function click_dropdown(){
                            if($('#dropdown_li').attr('open_now')=='false'){
                                $('#dropdown_li').addClass('open');
                                $('#dropdown_li').attr('open_now','true')
                            }else{
                                $('#dropdown_li').removeClass('open');
                                $('#dropdown_li').attr('open_now','false')
                            }

                        }*/
                    </script>
                    <li class="visible-xs-block">
                        <a href="<?php echo PROJECTPATH; ?>/main_menu/profile">
                            <span class="icon icon-user icon-lg icon-fw"></span>
                            เปลี่ยนรหัสผ่าน
                        </a>
                    </li>
                    <li class="visible-xs-block">
                        <a href="<?php echo PROJECTPATH; ?>/main_menu/logout" class="logout">
                            <span class="icon icon-power-off icon-lg icon-fw"></span>
                            ออกจากระบบ
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="layout-main">
    <div class="layout-sidebar">
        <div class="layout-sidebar-backdrop"></div>
        <div class="layout-sidebar-body">
            <div class="custom-scrollbar">
                <nav id="sidenav" class="sidenav-collapse collapse">
                    <?php
                    $start_menu_id = @$menu_paths[0]["id"];
                    $current_path = $_SERVER["REQUEST_URI"];
                    ?>
                    <ul class="sidenav">
                        <li class="sidenav-heading">เมนูหลัก</li>
                        <?php if (!empty($left_menu)){
                            foreach ($left_menu as $index => $val){
                                ?>
                                <li class="sidenav-item<?php if($current_path == $val['menu_url']) { ?> active<?php } ?>">
                                    <a href="<?php echo $val['menu_url']; ?>">
                                        <span class="sidenav-label"><?php echo $val['menu_name'] ?></span>
                                    </a>
                                </li>
                        <?php

                            }
                        } ?>

                        <li class="sidenav-item<?php if($current_path == '/enroll/manage_qr') { ?> active<?php } ?>">
                            <a href="<?php echo PROJECTPATH; ?>/enroll/manage_enroll">
                                <span class="sidenav-label">ข้อมูลการสมัคร</span>
                            </a>
                        </li>
                        <li class="sidenav-item<?php if($current_path == '/enroll/report_pay') { ?> active<?php } ?>">
                            <a href="<?php echo PROJECTPATH; ?>/enroll/report_pay">
                                <span class="sidenav-label">รายงานการสมัคร</span>
                            </a>
                        </li>



                        <li class="sidenav-item<?php if($current_path == '/main_menu/profile') { ?> active<?php } ?>">
                            <a href="<?php echo PROJECTPATH; ?>/main_menu/profile">
                                <span class="sidenav-label">เปลี่ยนรหัสผ่าน</span>
                            </a>
                        </li>
                        <li class="sidenav-item">
                            <a href="<?php echo PROJECTPATH; ?>/main_menu/logout">
                                <span class="sidenav-label">ออกจากระบบ</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>


