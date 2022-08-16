<?php

class Province extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Province_model", "Province");
    }

    function ajax_get_province(){
        $res = $this->Province->get_province($_POST['id']);
        echo json_encode($res);
        exit;
    }

    function ajax_get_amphure(){
        $res = $this->Province->get_amphure($_POST['province_id']);
        echo json_encode($res);
        exit;
    }

    function ajax_get_district(){
        $res = $this->Province->get_district($_POST['amphure_id']);
        echo json_encode($res);
        exit;
    }

    function ajax_get_zipcode(){
        $res = $this->Province->get_zipcode($_POST['district_code']);
        echo json_encode($res);
        exit;
    }
}
?>