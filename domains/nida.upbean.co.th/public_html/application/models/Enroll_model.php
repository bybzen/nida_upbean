<?php

class Enroll_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    // นับหลักสูตรนั้นว่ามีลงทะเบียนแล้วกี่คน
    function count_subject_enroll($code){
        $sql = "SELECT COUNT(ref_1) AS number from coop_enroll where ref_1 LIKE ".'\''.(date("Y")+543).$code.'%'.'\'';
        return $this->db->query($sql)->result_array();
    }

    //เอาค่าจากตาราง coop_subject มา เพื่อเอามาใส่ในตาราง coop_enroll
    function get_subject_data($id){
        $sql = "SELECT * from coop_subject where id = ".$id;
        $res = $this->db->query($sql)->result_array();
        return $res[0];
    }

    //บันทึกค่าต่างลงใน ตาราง coop_enroll
    function create_enroll($param){
        $process_time = date("Y-m-d H:i:s");
        $subject = $this->get_subject_data($param['enroll_id']);
        $data_insert = array();
        $number = $this->count_subject_enroll($subject['code']);
        $ref_1 = (date("Y")+543).$subject['code'].str_pad($number[0]['number']+1, 5, '0', STR_PAD_LEFT);
        $data_insert['ref_1'] = $ref_1;
        $data_insert['ref_2'] = $param['tel'];
        $data_insert['id_card'] = $param['id'];
        $data_insert['firstname'] = $param['firstname'];
        $data_insert['lastname'] = $param['lastname'];
        $data_insert['tel'] = $param['tel'];
        $data_insert['enroll_subject'] = $subject['name'];
        $data_insert['enroll_cost'] = $subject['cost'];
        $data_insert['created_at'] = $process_time;
        $data_insert['updated_at'] = $process_time;
        $this->db->insert('coop_enroll', $data_insert);
        return $data_insert;
    }
}

?>