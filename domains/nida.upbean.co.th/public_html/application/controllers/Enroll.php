<?php
class Enroll extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model("Enroll_model", "Enroll");
    }

    // function index($data=null){
    //     $this->load->view('enroll/create',$data);
    // }

    function ajax_create_enroll(){
        $res = $this->Enroll->create_enroll($_POST);
        echo json_encode($res);
        exit;
    }

    function print_pay_in(){
        $sql = "SELECT * FROM coop_enroll where ref_1 = ".'\''.$_GET['ref_1'].'\'';
        $res['enroll_data'] = $this->db->query($sql)->result_array();
        $this->load->view('template/navbar');
        $this->load->view('enroll/print_pay_in', $res);
    }

    function print_qr($ref_1 = null){
        $sql = "SELECT ref_1, ref_2, CONCAT(firstname,' ', lastname) as name, enroll_subject, enroll_cost, GROUP_CONCAT(value SEPARATOR '') as tax from coop_enroll JOIN coop_setting ON coop_enroll.ref_1 = ".$ref_1;
        $res['bill_payment'] = $this->db->query($sql)->result_array();
        $this->load->view('enroll/bill_payment', $res);
    }

    function gen_qr(){
        $arr_data = array();
        $data = str_replace('*',"\r",$_GET['data']);
        $arr_data['data'] = $data;
        $this->load->view('enroll/gen_qr',$arr_data);
    }
    function manage_enroll(){
        $arr_data = array();
        $enroll = $this->Enroll->get_enroll_data();
        $arr_data['enroll'] = $enroll;

        // $arr_subject = array();
        // $subject_name = $this->Enroll->get_subject();
        // $arr_subject['subject_name'] = $subject_name;

        // print_r($arr_data);
        $this->libraries->template('enroll/manage_enroll', $arr_data);
    }
// --------------------------------------- รายการ select  ---------------------------------------
    function report_pay(){
        $arr_data = array();

        $result = $this->Enroll->get_subject();
        $arr_data['subject'] = $result;

        $result = $this->Enroll->get_project();
        $arr_data['project'] = $result;
        
        $this->libraries->template('enroll/report_pay',$arr_data);
    }

    function report_applicant(){
        $arr_data = array();

        $result = $this->Enroll->get_project();
        $arr_data['project'] = $result;

        $result = $this->Enroll->get_subject();
        $arr_data['subject'] = $result;

        $result = $this->Enroll->get_province();
        $arr_data['province'] = $result;
        $this->libraries->template('enroll/report_applicant',$arr_data);
    }

    function report_receipts(){
        $arr_data = array();

        $result = $this->Enroll->get_project();
        $arr_data['project'] = $result;

        $result = $this->Enroll->get_subject();
        $arr_data['subject'] = $result;

        $result = $this->Enroll->get_province();
        $arr_data['province'] = $result;
        $this->libraries->template('enroll/report_receipts',$arr_data);
    }
// --------------------------------------- รายการ select  ---------------------------------------


// --------------------------------------- header and data report---------------------------------------
    function report_pay_pdf(){
        $arr_data = array();
        if ($_GET['paid'] == 'on'){
            $_GET['type'] = 1;
        } 
        else if ($_GET['unpaid'] == 'on'){
            $_GET['type'] = 2;
        }
        else if ($_GET['paid_all'] == 'on'){
            $_GET['type'] = 3;
        }

        $arr_data['datas'] = $this->Enroll->get_report_data($_GET);
        $arr_data['param'] = $_GET;

        if ($_GET['project'] != ''){
            $arr_data['project'] = $this->Enroll->get_header_project($_GET['project']);
        }

        if ($_GET['subject'] != ''){
            $arr_data['subject'] = $this->Enroll->get_header_subject($_GET['subject']);
        }
        $this->load->view('enroll/report_pay_pdf',$arr_data);
    }

    function report_pay_excel(){
        $arr_data = array();
        if ($_GET['paid'] == 'on'){
            $_GET['type'] = 1;
        } 
        else if ($_GET['unpaid'] == 'on'){
            $_GET['type'] = 2;
        }
        else if ($_GET['paid_all'] == 'on'){
            $_GET['type'] = 3;
        }
        
        // เรียก function ใน Model
        $arr_data['datas'] = $this->Enroll->get_report_data($_GET);
        $arr_data['param'] = $_GET;

        if ($_GET['project'] != ''){
            $arr_data['project'] = $this->Enroll->get_header_project($_GET['project']);
        }

        if ($_GET['subject'] != ''){
            $arr_data['subject'] = $this->Enroll->get_header_subject($_GET['subject']);
        }
        $this->load->view('enroll/report_pay_excel',$arr_data);
    }

    function report_applicant_excel(){
        $arr_data = array();
        if ($_GET['paid'] == 'on'){
            $_GET['type'] = 1;
        } 
        else if ($_GET['unpaid'] == 'on'){
            $_GET['type'] = 2;
        }
        else if ($_GET['paid_all'] == 'on'){
            $_GET['type'] = 3;
        }
        
        // เรียก function ใน Model
        $arr_data['datas'] = $this->Enroll->get_report_data($_GET);
        // $arr_data['data_bill'] = $this->Enroll->get_data_bill();
        $arr_data['param'] = $_GET;

        if ($_GET['project'] != ''){
            $arr_data['project'] = $this->Enroll->get_header_project($_GET['project']);
        }

        if ($_GET['subject'] != ''){
            $arr_data['subject'] = $this->Enroll->get_header_subject($_GET['subject']);
        }
        if ($_GET['province'] != ''){
            $arr_data['province'] = $this->Enroll->get_header_province($_GET['province']);
        }
        $this->load->view('enroll/report_applicant_excel',$arr_data);
    }

    function report_receipts_excel(){
        $arr_data = array();
        if ($_GET['paid'] == 'on'){
            $_GET['type'] = 1;
        } 
        else if ($_GET['unpaid'] == 'on'){
            $_GET['type'] = 2;
        }
        else if ($_GET['paid_all'] == 'on'){
            $_GET['type'] = 3;
        }
        
        // เรียก function ใน Model
        $arr_data['datas'] = $this->Enroll->get_report_data($_GET);
        $arr_data['param'] = $_GET;

        if ($_GET['project'] != ''){
            $arr_data['project'] = $this->Enroll->get_header_project($_GET['project']);
        }

        if ($_GET['subject'] != ''){
            $arr_data['subject'] = $this->Enroll->get_header_subject($_GET['subject']);
        }
        if ($_GET['province'] != ''){
            $arr_data['province'] = $this->Enroll->get_header_province($_GET['province']);
        }
        $this->load->view('enroll/report_receipts_excel',$arr_data);
    }
// --------------------------------------- header and data report---------------------------------------

    function ajax_show_page_edit_enroll(){
        $result = $this->Enroll->show_page_edit_enroll($_POST['ref_1']);
        echo json_encode($result[0]);
        exit;
    }

    function ajax_edit_data_enroll(){
        $this->Enroll->edit_data_enroll($_POST);
    }
    
    function ajax_delete_enroll(){
        
        $this->Enroll->delete_enroll($_POST['ref_1']);
    }

    function ajax_search(){
        $arr_data = array();
        $arr_data = $this->Enroll->DB_search($_GET['filter_search']);
        echo json_encode($arr_data);
     }

    function upload() {
        if (isset($_FILES['my_image']) && isset($_FILES['my_image02'])) {    

            $img_name = $_FILES['my_image']['name'];
            $img_size = $_FILES['my_image']['size'];
            $tmp_name = $_FILES['my_image']['tmp_name'];
            $error    = $_FILES['my_image']['error'];

            $img_name_02 = $_FILES['my_image02']['name'];
            $img_size_02 = $_FILES['my_image02']['size'];
            $tmp_name_02 = $_FILES['my_image02']['tmp_name'];
            $error_02    = $_FILES['my_image02']['error'];

            $ref_1 = $_POST['ref_1'];
                
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $img_ex_02 = pathinfo($img_name_02, PATHINFO_EXTENSION);                    
            $img_ex_lc_02 = strtolower($img_ex_02);

            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;                      
            $img_upload_path = "uploads/".$new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);
            
            $new_img_name_02 = uniqid("IMG-", true).'.'.$img_ex_lc_02;
            $img_upload_path_02 = "uploads/".$new_img_name_02;
            move_uploaded_file($tmp_name_02, $img_upload_path_02);

            $sql = "UPDATE coop_enroll set img_path = '$new_img_name', img_path_02 = '$new_img_name_02' where ref_1 = '$ref_1'";
            $this->db->query($sql);            
            $res = array('error' => 0, 'src'=> $new_img_name);
            echo json_encode($sql);
        }
    }

    // --------------------------------------- import file bank---------------------------------------

    function import_file_bank(){
        
        $arr_data = array();
        $arr_data['datas'] = $this->Enroll->show_import_page();

        $this->libraries->template('enroll/import_file_bank',$arr_data);
    }
    
    // หน้ารายละเอียดวันที่ชำระเงิน
    function import_show_report($pay_date){
        
        $arr_data['report_pay'] = $this->Enroll->get_import_data($pay_date);
        $this->libraries->template('enroll/import_show_report',$arr_data); 
        
        // $test = $this->Enroll->get_import_data($pay_date);
        // echo $test;
    }

    // เอาข้อมูล excel ลง DB
    function import_file_kt(){
        $file = $_FILES['file'];
        $objPHPExcel = new PHPExcel();

        if (!empty($file)) {
            $objPHPExcel = PHPExcel_IOFactory::load($file['tmp_name']);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $arr_data['datas'] = $sheetData;
            
        }
        if (!empty($sheetData)){
            $process_time = date("Y-m-d H:i:s");
            $sql = "INSERT INTO coop_import (created_at , status)
                    VALUES ('".$process_time."' , 1);";
            $this->db->query($sql);

            $sql = "SELECT * from coop_import order by created_at DESC";
            $result = $this->db->query($sql)->result_array();
            $id = $result[0]['id'];

            $data_insert = array();
            $data_insert['ref_import'] = $id;

            $row = 8;
            $i = 0;
            while(true){
                
                if($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row+$i)->getValue() == null 
                    || $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row+$i)->getValue() == "SUMMARY DETAIL")
                {
                    break;
                }

                else{
                    $ref_1 =  $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row+$i)->getValue();  //(col A = 0, row เริ่ม 1)
                    $enroll_name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row+$i)->getValue();
                    
                    // ------------------------- จัด format วันที่ -------------------------
                    $temp = '';
                    $pay_date = str_replace("/", "-", $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $row+$i)->getValue());
                    $date_split = explode("-",$pay_date);
                    $temp = $date_split[0];
                    $date_split[0] = $date_split[2];
                    $date_split[2] = $temp;
                    $day = $date_split[0]."-".$date_split[1]."-".$date_split[2];
                    // ------------------------- จัด format วันที่ -------------------------
                    
                    $time = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row+$i)->getValue();
                    $amount = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $row+$i)->getValue();
                    if($ref_1 != null ){
                        
                        $status = "ชำระเงินแล้ว";
                    }
                    else{
                        $status = "รออนุมัติ";
                    }
                    $data_insert['ref_1'] = $ref_1;
                    $data_insert['enroll_name'] = $enroll_name;
                    $data_insert['pay_date'] = $day;
                    $data_insert['pay_time'] = $time;
                    $data_insert['amount'] = $amount;
                    $data_insert['status'] = $status;

                    $data_payment= array();
                    $target = "SELECT t1.pay_date from coop_payment as t1 WHERE t1.pay_date = '$day'";
                    $target_date = $this->db->query($target)->result_array();
                    $date_db = $target_date[0]['pay_date'];

                // --------------- มีวันที่ชำระเงินแล้วใน DB ---------------
                    if($date_db != null || $date_db == $day){
                        $target = "SELECT t1.total_amount from coop_payment as t1 INNER JOIN coop_import_detail as t2 ON t1.pay_date = t2.pay_date
                        INNER JOIN coop_enroll as t3 ON t2.ref_1 = t3.ref_1
                        WHERE t1.pay_date = '$day' ";
                        $target_amount = $this->db->query($target)->result_array();
                        $amount_db = $target_amount[0]['total_amount'];

                        $data_payment['total_amount'] = $amount_db+$amount;
                        $this->db->where('pay_date',$day);
                        $this->db->update('coop_payment',$data_payment);

                    }
                // --------------- ยังไม่มีวันที่ชำระใน DB ---------------
                    else{
                        $data_payment['pay_date'] = $day;
                        $data_payment['total_amount'] = $amount;
                        $this->db->insert('coop_payment',$data_payment);
                        
                    }
                    $this->db->insert('coop_import_detail',$data_insert);
                    $i++;

                }
            }
        }
        echo"<script> document.location.href='".PROJECTPATH."/enroll/import_file_bank' </script>";
    }


    // function import_report_pdf(){
        // $import_id = $_POST['import_id'];
        // $arr_data = array();
        // $arr_data['datas'] = $this->Order->get_import_detail($import_id);
        // $import_data =  $this->Order->get_import_data($import_id);
        // $arr_data['import_data'] = $import_data[0];
        // $this->load->view('enroll/report_import_pdf',$arr_data);
    // }

    function import_report_excel(){
        
        // เรียก function ใน Model
        $arr_data['datas'] = $this->Enroll->get_import_detail($_GET['target_date']);
        $arr_data['param'] = $_GET;
        $this->load->view('enroll/import_report_excel',$arr_data);
    }

    // function ajax_delete_import(){
    //     $this->Order->delete_import($_POST['date']);
    // }

    // --------------------------------------- import file bank---------------------------------------
}

?>