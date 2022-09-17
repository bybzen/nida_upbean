<?php

class Province_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function get_province($id = null){
        $sql = "SELECT * FROM data_province where geo_id = ".$id;
        $arr = $this->db->query($sql)->result_array();
        return $arr;
    }

    function get_amphure($province_id = null){
        // $sql = "SELECT * FROM data_amphure where province_id = ".$province_id." order by amphur_name ASC";
        $sql = "SELECT * FROM data_amphure where province_id = ".$province_id." and amphur_name NOT LIKE '%*%' order by amphur_name ASC";
        return $this->db->query($sql)->result_array();
        // return $sql;
    }

    function get_district($amphure_id = null){
        // $sql = "SELECT * FROM data_district where amphur_id = ".$amphure_id." order by district_name ASC";
        $sql = "SELECT * FROM data_district where amphur_id = ".$amphure_id." and district_name NOT LIKE '%*%' order by district_name asc";
        return $this->db->query($sql)->result_array();
        // return $sql;
    }

    function get_zipcode($district_code = null){
        $sql = "SELECT * FROM data_zipcode where district_code = ".$district_code;
        $res = $this->db->query($sql)->result_array();
        return $res[0];
    }

    function get_open_province_subject(){
        if(isset($_GET['subject_code'])){
            $where = 'where subject_code = '.$_GET['subject_code'];
        }
        $sql = "SELECT * FROM subject_open_province ".$where;
        return $this->db->query($sql)->result_array();
    }
}
?>