<?php


class Branch extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model("Branch_model", "Branch");
    }

    function index(){
        $arr_data = array();
        $result = $this->Branch->get_branch(1);
        $arr_data['branch'] = $result;
        $this->libraries->template('branch/index',$arr_data);
    }

    function ajax_create_branch(){
        $this->Branch->create_branch($_POST);
    }

    function ajax_edit_branch(){
        $this->Branch->edit_branch($_POST);
    }

    function ajax_delete_branch(){
        $this->Branch->delete_branch($_POST['id']);
    }

    function ajax_get_branch_data(){
        $result = $this->Branch->get_branch_data($_POST['id']);
        echo json_encode($result);
        exit;
    }

    function ajax_check_can_delete(){
        $result = $this->Branch->check_can_delete($_POST['branch_id']);
        echo json_encode($result);
        exit;
    }



}