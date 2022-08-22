<?php

class Subject_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    function get_subject($id = null){
        // $sql = "SELECT * from coop_subject where is_deleted = 0 and project_id = ".$id;
        $sql = "SELECT t1.id, t1.project_id, t1.name, t1.code, t1.cost, t1.start_date, t1.end_date, 
                t1.geography, t1.is_deleted, GROUP_CONCAT(t2.open_province SEPARATOR ',') as open_province from coop_subject as t1 
                INNER JOIN subject_open_province as t2 ON ( t1.is_deleted = 0 and t1.project_id = ".$id." and t1.code = t2.subject_code) 
                GROUP BY t1.code";
        $array['subject'] = $this->db->query($sql)->result_array();
        $sql = "SELECT * FROM data_province order by province_name";
        $array['province'] = $this->db->query($sql)->result_array();
        return $array;
    }

    function create_subject($param){
        $data_insert = array();
        $data_insert['project_id'] = $param['project_id'];
        $data_insert['name'] = $param['name'];
        $data_insert['code'] = $param['code'];
        $data_insert['cost'] = $param['cost'];
        $data_insert['start_date'] = $param['start_date'];
        $data_insert['end_date'] = $param['end_date'];
        $data_insert['geography'] = $param['open_geo'];
        $this->build_open_province($param);
        $this->db->insert('coop_subject', $data_insert);
    }

    function build_open_province($param){
        $data_insert = array();
        $str = $param['pv'];
        $arr = array();
        $arr = explode(",",$str);
        for($i = 0; $i < count($arr); $i++){
            $data_insert['subject_code'] = $param['code'];
            $data_insert['open_province'] = $arr[$i];
            $this->db->insert('subject_open_province',$data_insert);
        }
    }

    function edit_subject($param){
        $data_insert = array();
        $data_insert['name'] = $param['name'];
        $data_insert['code'] = $param['code'];
        $data_insert['cost'] = $param['cost'];
        $data_insert['start_date'] = $param['start_date'];
        $data_insert['end_date'] = $param['end_date'];
        if($param['pv'] != ''){
            $this->db->where('subject_code',$param['subject_id']);
            $this->db->delete('subject_open_province', ['subject_code' => $param['subject_id']]);
            $this->build_open_province($param);
        }
        if($param['open_geo'] != ''){
            $data_insert['geography'] = $param['open_geo'];
        }
        $this->db->where('code', $param['subject_id']);
        $this->db->update('coop_subject', $data_insert);
    }

    function get_subject_data($id=null){
        if(!empty($id)){
            $where = "where code = ".$id;
        }
        $sql = "SELECT * FROM coop_subject ".$where;
        $result = $this->db->query($sql)->result_array();
        return $result[0];
        // return $sql;
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

    function get_open_province($geo_id = null,$subject_code = null){
        //ที่ comment คือ เอาชื่อวิชามาด้วย แต่ยังไม่ได้พิจารณา subject ที่มีอยู่ใน project 
        // SELECT t1.subject_code, t1.open_province, t2.name from subject_open_province as t1 
        // INNER JOIN coop_subject as t2 ON (t1.subject_code = 002 and t2.code = 002)
        // $sql = "SELECT * FROM subject_open_province where subject_code = ".$subject_code;
        $sql = "SELECT t1.id, t1.subject_code, t1.open_province FROM subject_open_province as t1 
                JOIN (SELECT province_name from data_province WHERE geo_id = ".$geo_id.") data_province 
                ON data_province.province_name = t1.open_province AND t1.subject_code = ".$subject_code;
        $res = $this->db->query($sql)->result_array();
        return $res;
        // return $sql;
    }

    function subject_in_geo($geo_id = null, $project_id = null){
        $sql = "SELECT * FROM coop_subject where geography LIKE '%".$geo_id."%' and project_id = ".$project_id." and is_deleted = 0";
        return $this->db->query($sql)->result_array();
        // return $sql;
    }
}

?>