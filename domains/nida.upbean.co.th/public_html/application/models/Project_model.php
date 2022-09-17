<?php

class Project_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function get_project(){
        $sql = "SELECT * from coop_project where is_deleted = 0";
        return $this->db->query($sql)->result_array();
    }

    function create_project($param){
        $process_time = date("Y-m-d H:i:s");
        $data_insert = array();
        $data_insert['project_name'] = $param['name'];
        $data_insert['created_at'] = $process_time;
        $data_insert['updated_at'] = $process_time;
        $this->db->insert('coop_project', $data_insert);
    }

    function edit_project($param){
        $process_time = date("Y-m-d H:i:s");
        $data_insert = array();
        $data_insert['project_name'] = $param['name'];
        $data_insert['updated_at'] = $process_time;
        $this->db->where('id', $param['project_id']);
        $this->db->update('coop_project', $data_insert);
    }

    function delete_project($id){
        $process_time = date("Y-m-d H:i:s");
        $data_insert = array();
        $data_insert['is_deleted'] = 1;
        $data_insert['updated_at'] = $process_time;
        $this->db->where('id', $id);
        $this->db->update('coop_project', $data_insert);
    }

    function get_project_data($id = null){
        if(!empty($id)){
            $where = "where id = ".$id;
            $sql = "SELECT * FROM coop_project ".$where;
            $result = $this->db->query($sql)->result_array();
            return $result[0];
        }
        elseif(isset($_GET['project_id'])){
            $where = "where id = ".$_GET['project_id'];
            $sql = "SELECT * FROM coop_project ".$where;
            $result = $this->db->query($sql)->result_array();
            return $result[0];
        }
    }

    function check_code_project($code){
        $sql = "select count(project_id) as num from coop_project where is_deleted = 0 and project_id = ".$code;
        $res = $this->db->query($sql)->result_array();
        return $res[0];
    }

    function get_province(){
        $sql = "SELECT * FROM data_province order by province_name asc";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    function get_subject(){
        $now = date('Y-m-d');
        if(isset($_GET['project_id'])){
            $where = "where project_id = ".$_GET['project_id']." and is_deleted = 0 and date(start_date) <= '".$now."' and date(end_date) >= '".$now."'";
        }
        $sql = "SELECT * FROM coop_subject ".$where;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    function get_subject_for_enroll(){
        if(isset($_GET['subject_id'])){
            $where = "where id = ".$_GET['subject_id']." and is_deleted = 0";
        }
        $sql = "SELECT * FROM coop_subject ".$where;
        $result = $this->db->query($sql)->result_array();
        return $result[0];
    }
}
?>