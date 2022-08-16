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

    function get_project_data($id=null, $subject=null){
        if(!empty($id) && empty($subject)){
            $where = "where id = ".$id;
            $sql = "SELECT * FROM coop_project ".$where;
            $result = $this->db->query($sql)->result_array();
            return $result[0];
        }
        else{
            $sql = "SELECT t1.id,t1.project_name, t2.code as subject_code, t2.name as subject_name from coop_project as t1 
                    INNER JOIN coop_subject as t2 on (t2.project_id = ".$id." and t2.is_deleted = 0 and t1.id = ".$id.")";
            $result = $this->db->query($sql)->result_array();
            return $result;
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
}
?>