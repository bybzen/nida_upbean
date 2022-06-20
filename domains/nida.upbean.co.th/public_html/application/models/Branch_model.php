<?php


class Branch_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_branch($status=null){
        $where = "1=1 ";
        if (!empty($status)){
            $where .= ' AND status = '.$status;
        }
        $sql = "SELECT * from coop_branch where ".$where;
        return $this->db->query($sql)->result_array();
    }

    function create_branch($param){
        $data_insert = array();
        $data_insert['name'] = $param['name'];
        $data_insert['code'] = $param['code'];
        $data_insert['status'] = 1;
        $process_time = date("Y-m-d H:i:s");
        $data_insert['created_at'] = $process_time;
        $data_insert['updated_at'] = $process_time;
        if (!empty($param['tel'])){
            $data_insert['tel'] = $param['tel'];
        }
        $this->db->insert('coop_branch',$data_insert);
    }

    function edit_branch($param){
        $data_insert = array();
        $data_insert['name'] = $param['name'];
        $data_insert['code'] = $param['code'];
        $process_time = date("Y-m-d H:i:s");
        $data_insert['updated_at'] = $process_time;
        if (!empty($param['tel'])){
            $data_insert['tel'] = $param['tel'];
        }
        $this->db->where('id',$param['id']);
        $this->db->update('coop_branch',$data_insert);
    }

    function delete_branch($id){
        $data_insert = array();
        $data_insert['status'] = 2;
        $this->db->where('id',$id);
        $this->db->update('coop_branch',$data_insert);
    }

    function get_branch_data($id){
        $sql = "SELECT * FROM coop_branch where id = ".$id;
        $result = $this->db->query($sql)->result_array();
        return $result[0];
    }

    function check_can_delete($id){
        $sql = 'SELECT count(*) as count FROM coop_branch AS t1 
                INNER JOIN coop_order AS t2 ON t1.id = t2.branch_id
                WHERE t2.`status` = 1 AND t2.branch_id = '.$id;
        $result = $this->db->query($sql)->result_array();
        $return = array();
        if ($result[0]['count'] == 0){
            $return['can_delete'] = true;
            return $return;
        } else {
            $return['can_delete'] = false;
            return $return;
        }
    }

}