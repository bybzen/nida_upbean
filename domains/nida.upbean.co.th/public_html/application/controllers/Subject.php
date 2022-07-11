<?php

class Subject extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Subject_model", "Subject");
    }

    function index(){
        $arr_data = array();
        $result = $this->Subject->get_subject();
        $arr_data['subject'] = $result;
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
}

?>