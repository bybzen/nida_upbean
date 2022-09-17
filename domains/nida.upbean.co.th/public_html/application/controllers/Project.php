<?php

class Project extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Project_model", "Project");
        $this->load->model("Province_model","Province");
    }

    function index(){
        $arr_data = array();
        $result = $this->Project->get_project();
        $arr_data['project'] = $result;
        $this->libraries->template('project/index',$arr_data);
    }

    function ajax_create_project(){
        $this->Project->create_project($_POST);
    }

    function ajax_edit_project(){
        $this->Project->edit_project($_POST);
    }
    
    function ajax_get_project_data(){
        $result = $this->Project->get_project_data($_POST['id']);
        echo json_encode($result);
        exit;
    }

    function ajax_delete_project(){
        $this->Project->delete_project($_POST['id']);
    }

    function select_subject($id = null){
        $arr_data = array();
        $res = $this->Project->get_project_data();
        $arr_data['project'] = $res;
        $res = $this->Project->get_subject();
        $arr_data['subject'] = $res;
        $this->load->view('template/navbar');        
        $this->load->view('enroll/select_subject',$arr_data);
    }

    function ajax_check_code_project(){
        $res = $this->Project->check_code_project($_POST['code']);
        echo json_encode($res);
        exit;
    }

    function enroll(){
        $arr_data = array();
        $res = $this->Project->get_project_data();
        $arr_data['project'] = $res;
        $res = $this->Project->get_subject_for_enroll();
        $arr_data['subject'] = $res;
        $res = $this->Project->get_province();
        $arr_data['province'] = $res;
        $res = $this->Province->get_open_province_subject();
        $arr_data['open_province'] = $res;
        $this->load->view('template/navbar'); 
        $this->load->view('enroll/create',$arr_data);
    }
}
?>