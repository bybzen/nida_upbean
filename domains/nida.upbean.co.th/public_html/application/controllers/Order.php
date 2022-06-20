<?php


class Order extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model("Order_model", "Order");
        $this->load->model("Branch_model", "Branch");
    }

    function manage_qr(){
        $arr_data = array();
        $result = $this->Branch->get_branch(1);
        $arr_data['branch'] = $result;
        $orders = $this->Order->get_order_data();
        $arr_data['orders'] = $orders;
        $this->libraries->template('order/manage_qr',$arr_data);
    }

    function gen_qr(){
        $arr_data = array();
        $data = str_replace('*',"\r",$_GET['data']);
        $arr_data['data'] = $data;
        $this->load->view('order/gen_qr',$arr_data);
    }

    function import_kt(){
        $arr_data = array();
        $arr_data['datas'] = $this->Order->get_import_data();
        $this->libraries->template('order/import_kt',$arr_data);
    }

    function import_file_kt(){
        $file = $_FILES['file'];
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
            $data_insert['import_id'] = $id;
            foreach ($sheetData as $index => $value){
                if ($value['A'] == 'D'){
                    $ref = $value['H'];
                    $amount = (float)substr_replace($value['P'], '.', -2, 0);
                    $data_insert['ref'] = $ref;
                    $data_insert['amount'] = $amount;
                    $sql = "SELECT * FROM coop_order WHERE ref_1 = ".$ref." AND status = 1";
                    $result = $this->db->query($sql)->result_array();
                    if (!empty($result[0])){
                        $data_insert['order_id'] = $result[0]['id'];

                        $_data_update = [];
                        $_data_update['payment_status'] = 1;
                        $_data_update['payment_amt'] = $amount;
                        $_data_update['payment_date'] = $process_time;
                        $_data_update['updated_at'] = $process_time;
                        $this->db->where('id', $result[0]['id']);
                        $this->db->update('coop_order', $_data_update);
                    } else {
                        $data_insert['order_id'] = null;
                    }
                    $this->db->insert('coop_import_detail',$data_insert);
                }
            }
        }
        echo"<script> document.location.href='".PROJECTPATH."/order/import_kt' </script>";
    }

    function import_report(){
        $import_id = $_POST['import_id'];
        $arr_data = array();
        $arr_data['datas'] = $this->Order->get_import_detail($import_id);
        $import_data =  $this->Order->get_import_data($import_id);
        $arr_data['import_data'] = $import_data[0];
        $this->load->view('order/report_import_pdf',$arr_data);
    }

    function import_report_excel(){
        $import_id = $_POST['import_id'];
        $arr_data = array();
        $arr_data['datas'] = $this->Order->get_import_detail($import_id);
        $import_data =  $this->Order->get_import_data($import_id);
        $arr_data['import_data'] = $import_data[0];
        $this->load->view('order/report_import_excel',$arr_data);
    }

    function bill_payment(){
        $order_id = $_POST['order_id'];
        $arr_data = array();
        $arr_data['order'] = $this->Order->get_order_data($order_id);
        $sql = "SELECT value FROM coop_setting WHERE code = 'TAX_ID'";
        $result = $this->db->query($sql)->result_array();
        $arr_data['tax_id'] = $result[0]['value'];
        $sql = "SELECT value FROM coop_setting WHERE code = 'SUFFIX'";
        $result = $this->db->query($sql)->result_array();
        $arr_data['suffix'] = $result[0]['value'];
        $this->load->view('order/bill_payment',$arr_data);
    }

    function report_pay(){
        $arr_data = array();
        $result = $this->Branch->get_branch(1);
        $arr_data['branch'] = $result;
        $this->libraries->template('order/report_pay',$arr_data);
    }

    function report_pay_pdf(){
        $arr_data = array();
        if ($_GET['type_found'] == 'on'){
            $_GET['type'] = 1;
        } else if ($_GET['type_not_found'] == 'on'){
            $_GET['type'] = 2;
        }
        $arr_data['datas'] = $this->Order->get_report_data($_GET);
        $arr_data['param'] = $_GET;
        if ($_GET['branch'] != 0){
            $arr_data['branch'] = $this->Branch->get_branch_data($_GET['branch']);
        }
        $this->load->view('order/report_pay_pdf',$arr_data);
    }

    function report_pay_excel(){
        $arr_data = array();
        if ($_GET['type_found'] == 'on'){
            $_GET['type'] = 1;
        } else if ($_GET['type_not_found'] == 'on'){
            $_GET['type'] = 2;
        }
        $arr_data['datas'] = $this->Order->get_report_data($_GET);
        $arr_data['param'] = $_GET;
        if ($_GET['branch'] != 0){
            $arr_data['branch'] = $this->Branch->get_branch_data($_GET['branch']);
        }
        $this->load->view('order/report_pay_excel',$arr_data);
    }

    function report_all_pay(){
        $arr_data = array();
        $result = $this->Branch->get_branch(1);
        $arr_data['branch'] = $result;
        $this->libraries->template('order/report_all_pay',$arr_data);
    }

    function report_all_pay_pdf(){
        $arr_data = array();
        if ($_GET['type_found'] == 'on'){
            $_GET['type'] = 1;
        } else if ($_GET['type_not_found'] == 'on'){
            $_GET['type'] = 2;
        }
        $arr_data['datas'] = $this->Order->get_report_total_data($_GET);
        $arr_data['param'] = $_GET;
        if ($_GET['branch'] != 0){
            $arr_data['branch'] = $this->Branch->get_branch_data($_GET['branch']);
        }
        $this->load->view('order/report_all_pay_pdf',$arr_data);
    }

    function report_all_pay_excel(){
        $arr_data = array();
        if ($_GET['type_found'] == 'on'){
            $_GET['type'] = 1;
        } else if ($_GET['type_not_found'] == 'on'){
            $_GET['type'] = 2;
        }
        $arr_data['datas'] = $this->Order->get_report_total_data($_GET);
        $arr_data['param'] = $_GET;
        if ($_GET['branch'] != 0){
            $arr_data['branch'] = $this->Branch->get_branch_data($_GET['branch']);
        }
        $this->load->view('order/report_all_pay_excel',$arr_data);
    }

    function ajax_generate_ref(){
        $branch_id = $_POST['branch_id'];
        $result = $this->Order->generate_ref($branch_id);
        echo json_encode($result);
    }

    function ajax_create_order(){
        $this->Order->create_order($_POST);
    }

    function ajax_edit_order(){
        $this->Order->edit_order($_POST);
    }

    function ajax_delete_order(){
        $this->Order->delete_order($_POST['order_id']);
    }

    function ajax_get_order_data(){
        $result = $this->Order->get_order_data($_POST['order_id']);
        echo json_encode($result[0]);
        exit;
    }

    function ajax_edit_ref(){
        $param = array();
        $param['order_id'] = $_POST['order_id'];
        $param['branch_id'] = $_POST['branch_id'];
        $result = $this->Order->re_generate_ref($param);
        echo json_encode($result);
    }

    function ajax_print(){
        $order_id = $_POST['order_id'];
        $this->Order->print_order($order_id);
    }

    function ajax_delete_import(){
        $this->Order->delete_import($_POST['id']);
    }

}