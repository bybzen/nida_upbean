<?php
	
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/elephant.min.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
	$link = array(
          'src' => PROJECTJSPATH.'assets/js/application.min.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
	  $link = array(
          'src' => PROJECTJSPATH.'assets/js/jquery-migrate-1.4.1.min.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/bootstrap-datepicker/bootstrap-datepicker-thai.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/bootstrap-datepicker/locales/bootstrap-datepicker.th.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);

      $link = array(
          'src' => PROJECTJSPATH.'assets/js/fancybox/jquery.fancybox.js?v=2.1.5',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/fancybox/jquery.mousewheel-3.0.6.pack.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);

      $link = array(
          'src' => PROJECTJSPATH.'assets/js/toast.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);

      $link = array(
          'src' => PROJECTJSPATH.'assets/js/jquery.blockUI.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/sweetalert.min.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/moment.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
      $link = array(
          'src' => PROJECTJSPATH.'assets/js/bootstrap-datetimepicker.min.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);

		$link = array(
          'src' => PROJECTJSPATH.'assets/js/center_js.js',
          'language' => 'javascript',
          'type' => 'text/javascript'
      );
      echo script_tag($link);
		$link = array(
			'src' => PROJECTJSPATH.'assets/js/jquery.number_format.js',
			'type' => 'text/javascript'
		);
		echo script_tag($link);
?>
    <div class="layout-footer" style="z-index:-1 !important;">
        <div class="layout-footer-body">
            <small class="version">Version 1.0.0</small>
            <small class="copyright">GSPA NIDA by <a href="http://upbean.co.th/">Upbean Co.,Ltd</a></small>
        </div>
    </div>
</div>

<div class="theme">
    <div class="theme-panel theme-panel-collapsed">
        <div class="theme-panel-body">
            <div class="custom-scrollbar">
                <div class="custom-scrollbar-inner">
                    <ul class="theme-settings">
                        <li class="theme-settings-heading">
                            <div class="divider">
                                <div class="divider-content">ใบเสร็จล่าสุด</div>
                            </div>
                        </li>
                        <?php if(!empty($receipt_box)):?>
                        <?php foreach($receipt_box as $key => $value):?>
                        <li class="theme-settings-item" style="display: flex;flex: 1;border-bottom: 1px solid #31313114;">
                            <div class="" style="flex: 1;"><i class="fa fa-user-circle" aria-hidden="true"></i> <?php echo $value['member_id']?></div>
                            <div class="" style="flex: 1;white-space: nowrap;">
                                <a href="/admin/receipt_form_pdf/<?php echo $value['receipt_id']?>" target="_blank" title="<?php echo number_format($value['sumcount'], 2)." บาท"?>" <?php echo ($value['receipt_status']=="2") ? "style='color: red;'" : "" ?>>
                                    <span style="cursor: pointer;" class="icon icon-print"></span> <?php echo $value['receipt_id']?>
                                </a>
                            </div>
                        </li>
                        <?php endforeach;?>
                        <?php endif;?>

                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $( document ).ready(function() {
        $('#myModal').on('shown.bs.modal', function() {
            $('#search_mem').focus();
        });
        $('.modal').on('shown.bs.modal', function() {
            $.blockUI({
                message: '',
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                },
                baseZ: 2000,
                bindEvents: false
            });
        });
        var prev_id;
        $('.modal').on('hide.bs.modal', function () {
            if(this.id != 'cal_period_normal_loan' && this.id != 'show_file_attach' && this.id != 'search_member_loan_modal'){
                $.unblockUI();
            }

        });

        // Toast
        var toast = "<?php echo isset($_COOKIE['toast']) ? $_COOKIE['toast'] : "" ?>";
        if(toast) {
            toastNotifications(toast);
        }
        // Toast Danger
        var toast_e = "<?php echo isset($_COOKIE['toast_e']) ? $_COOKIE['toast_e'] : "" ?>";
        if(toast_e) {
            toastDanger(toast_e);
        }
		bodyOnload();
    });
function bodyOnload(){
	// call_notification();
	// setTimeout("doLoop();",10000);
}
function doLoop(){
	bodyOnload();
}
function call_notification(){
	$.ajax({
        type: "POST"
        , url: base_url+'notification/call_notification'
        , data: {
            "do" : "call_notification"
        }
        , success: function(data) {
			var obj = jQuery.parseJSON( data );
			$('.notification_count').html(obj.notification_count);
            $('#notification_space').html(obj.notification_body);
        }
    });
}
function open_menu_modal(id){
	$('#'+id).modal('show');
}

function toggle_receipt_box(){
    $( ".receipt-box" ).toggleClass( "receipt-box-collapsed" );
    $( ".theme-panel" ).toggleClass( "theme-panel-collapsed" );
    if($( ".receipt-box" ).hasClass( "receipt-box-collapsed" )){
        $("#receipt_box_text").html("ใบเสร็จ");
    }else{
        $("#receipt_box_text").html('<i class="fa fa-times" aria-hidden="true" style="font-size: 20px;"></i>');
    }
}
</script>
<!-- search_member -->
<?php
    $link = array(
        'src' => PROJECTJSPATH.'assets/js/search_member.js',
        'language' => 'javascript',
        'type' => 'text/javascript'
    );
    echo script_tag($link);
?>
<!-- search_member -->

<!-- check_bt_submit -->
<?php
	$v = date('YmdHis');
    $link = array(
        'src' => PROJECTJSPATH.'assets/js/check_bt_submit.js?v='.$v,
        'language' => 'javascript',
        'type' => 'text/javascript'
    );
    echo script_tag($link);
?>
<!-- check_bt_submit -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <strong></strong>
                </div>
                <div></div>
            </footer>
    </body>
</html>
