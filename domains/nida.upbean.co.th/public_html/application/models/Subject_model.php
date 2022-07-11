<?php

class Subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function get_subject(){
        $sql = "SELECT * from coop_subject where is_deleted = 0";
        return $this->db->query($sql)->result_array();
    }

    function create_subject($param){
        $data_insert = array();
        $data_insert['name'] = $param['name'];
        $data_insert['code'] = $param['code'];
        $data_insert['cost'] = $param['cost'];
        $this->db->insert('coop_subject', $data_insert);
    }

    function edit_subject($param){
        $data_insert = array();
        $data_insert['name'] = $param['name'];
        $data_insert['code'] = $param['code'];
        $data_insert['cost'] = $param['cost'];
        $this->db->where('id', $param['subject_id']);
        $this->db->update('coop_subject', $data_insert);
    }

    function get_subject_data($id=null){
        if(!empty($id)){
            $where = "where id = ".$id;
        }
        $sql = "SELECT * FROM coop_subject ".$where;
        $result = $this->db->query($sql)->result_array();
        return $result[0];
    }

    function delete_subject($id){
        $data_insert = array();
        $data_insert['is_deleted'] = 1;
        $this->db->where('id', $id);
        $this->db->update('coop_subject', $data_insert);
    }

    function get_subject_name($id){
        $sql = "SELECT * from coop_subject where id = ".$id;
        $result = $this->db->query($sql)->result_array();
        return $result[0];
    }

    function check_code_subject($code = null){
        $sql = "select count(code) as num from coop_subject where is_deleted = 0 and code = ".$code;
        $res = $this->db->query($sql)->result_array();
        return $res[0];
    }
}

?>