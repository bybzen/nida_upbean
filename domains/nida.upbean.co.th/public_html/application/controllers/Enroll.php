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

    function report_pay(){
        $arr_data = array();
        $result = $this->Enroll->get_subject();
        $arr_data['subject'] = $result;
        $this->libraries->template('enroll/report_pay',$arr_data);
    }

    function report_applicant(){
        $arr_data = array();
        $result = $this->Enroll->get_subject();
        $arr_data['subject'] = $result;

        $result = $this->Enroll->get_province();
        $arr_data['province'] = $result;
        $this->libraries->template('enroll/report_applicant',$arr_data);
    }

    function report_receipts(){
        $arr_data = array();
        $result = $this->Enroll->get_subject();
        $arr_data['subject'] = $result;

        $result = $this->Enroll->get_province();
        $arr_data['province'] = $result;
        $this->libraries->template('enroll/report_receipts',$arr_data);
    }

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
        if ($_GET['subject'] != ''){
            $arr_data['subject'] = $this->Enroll->get_header_subject($_GET['subject']);
        }
        if ($_GET['province'] != ''){
            $arr_data['province'] = $this->Enroll->get_header_province($_GET['province']);
        }
        $this->load->view('enroll/report_receipts_excel',$arr_data);
    }

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
}

?>