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

    function print_pay_in($id = null){
        $sql = "SELECT * FROM coop_enroll where ref_1 = ".'\''.$id.'\'';
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
}

?>