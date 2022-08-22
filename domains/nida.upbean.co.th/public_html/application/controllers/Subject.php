<?php

class Subject extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Subject_model", "Subject");
    }

    function index($id = null){
        $arr_data = array();
        $arr_province = array();
        $result = $this->Subject->get_subject($id);
        $arr_data['subject'] = $result['subject'];
        $arr_data['province'] = $result['province'];
        $arr_data['project_id'] = $id;
        $this->libraries->template('subject/index',$arr_data);
    }

    function ajax_create_subject(){
        $this->Subject->create_subject($_POST);
    }

    function ajax_edit_subject(){
        $this->Subject->edit_subject($_POST);
    }

    function ajax_get_subject_data(){
        $result = $this->Subject->get_subject_data($_POST['id']);
        echo json_encode($result);
        exit;
    }

    function ajax_delete_subject(){
        $this->Subject->delete_subject($_POST['id']);
    }
    
    function enroll_subject(){
        $arr_data = array();
        $result = $this->Subject->get_subject_data($_POST['sj_id']);
        $arr_data['subject'] = $result;
        $this->load->view('template/navbar');        
        $this->load->view('enroll/create',$arr_data);
    }

    function ajax_check_code_subject(){
        $res = $this->Subject->check_code_subject($_POST['code']);
        echo json_encode($res);
        exit;
    }

    function ajax_get_open_province(){
        $res = $this->Subject->get_open_province($_POST['geo_id'],$_POST['subject_code']);
        echo json_encode($res);
        exit;
    }

    function get_subject_in_geo(){
        $res = $this->Subject->subject_in_geo($_POST['geo_id'],$_POST['project_id']);
        echo json_encode($res);
        exit;
    }
}

?>