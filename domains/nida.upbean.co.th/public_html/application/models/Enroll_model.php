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
        if(!$this->FormatID($param['id'])){
            throw new Exception();
        }
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
        $data_insert['payment_status'] = 'รอชำระเงิน';
        $data_insert['enroll_date'] = $process_time;
        $data_insert['created_at'] = $process_time;
        $data_insert['updated_at'] = $process_time;
        $this->db->insert('coop_enroll', $data_insert);
        return $data_insert;
    }


     // หน้า manage_qr show data
     function get_enroll_data(){
        $sql = "SELECT * from coop_enroll ORDER BY created_at";
        return $this->db->query($sql)->result_array();
    }

    // หน้า report_pay เงื่อนไข select
    function get_subject(){
        
        $sql = "SELECT t1.name from coop_subject AS t1 WHERE is_deleted = 0";
        return $this->db->query($sql)->result_array();
    }

    function get_province(){
        
        $sql = "SELECT t1.province_name from data_province AS t1 ";
        return $this->db->query($sql)->result_array();
    }

     // เอาชื่อ subject จากที่ select
     function get_header_subject($subject){
        $sql = "SELECT * FROM coop_subject where name = '".$subject."'";
        $result = $this->db->query($sql)->result_array();
        return $result[0];
    }

    function get_header_province($province){
        $sql = "SELECT * FROM data_province where province_name = '".$province."'";
        $result = $this->db->query($sql)->result_array();
        return $result[0];
    }

    // print data pdf-excel
    function get_report_data($param){
        
        $subject ="";
        $province = "";
        $start_date_sql = $this->center_function->ConvertToSQLDate($param['start_date']);
        $end_date_sql = $this->center_function->ConvertToSQLDate($param['end_date']);

        //เลือกจังหวัด
        if($param['province'] != ''){
            $province .= " AND t1.province = '".$param['province']."'";
        }
        
        //เลือกหลักสูตร
        if ($param['subject'] != ''){
            $subject .= " AND t1.enroll_subject = '".$param['subject']."'";
        }

        $type = $param['type'];
            if ($type == 1){
                $sql = "SELECT *, t1.created_at AS order_created FROM coop_enroll AS t1 INNER JOIN coop_bill AS t2 ON t1.ref_1 = t2.ref_1
                        WHERE enroll_date BETWEEN "."'".$start_date_sql."'"." AND "."'".$end_date_sql."'"
                        ." AND t1.payment_status = 'ชำระเงินแล้ว'".$subject.$province;
                
            } 
            else if ($type == 2){
                $sql = "SELECT *, t1.created_at AS order_created FROM coop_enroll AS t1 INNER JOIN coop_bill AS t2 ON t1.ref_1 = t2.ref_1
                        WHERE enroll_date BETWEEN "."'".$start_date_sql."'"." AND "."'".$end_date_sql."'"
                        ." AND t1.payment_status = 'รอชำระเงิน'".$subject.$province;
                
            }
            else if ($type == 3){
                $sql = "SELECT *, t1.created_at AS order_created FROM coop_enroll AS t1 INNER JOIN coop_bill AS t2 ON t1.ref_1 = t2.ref_1
                        WHERE enroll_date BETWEEN "."'".$start_date_sql."'"." AND "."'".$end_date_sql."'"
                        ." AND (t1.payment_status = 'ชำระเงินแล้ว' OR t1.payment_status = 'รอชำระเงิน')".$subject.$province;
                
            }
        return $this->db->query($sql)->result_array();
    }

    // function get_data_bill(){
        
    //     $sql = "SELECT * FROM coop_bill";
        
    //     return $this->db->query($sql)->result_array();
    // }

    


    //โชว์ข้อมูลหน้าแก้ไข enroll
    function show_page_edit_enroll($search=null){

        $sql = "SELECT *, t1.created_at AS order_created FROM coop_enroll AS t1 
                WHERE  t1.ref_1 = '".$search."'";
        $rs = $this->db->query($sql)->result_array();

        foreach($rs as $row) {
            $payment_date = explode(" ", !empty($id) && empty($row['payment_date']) ? date('Y-m-d H:i:s') : $row['payment_date']);
            $row['payment_date_d'] = $this->center_function->C2Pickdate(@$payment_date[0]);
            $row['payment_date_h'] = @explode(":", @$payment_date[1])[0];
            $row['payment_date_m'] = @explode(":", @$payment_date[1])[1];
            $data[] = $row;
        }

        return $data;
    }

    //แก้ไขข้อมูล enroll
    function edit_data_enroll($param){
       
        $data_insert = array();
        $process_time = date("Y-m-d H:i:s");
        
        $data_insert['firstname'] = $param['firstname'];
        $data_insert['lastname'] = $param['lastname'];
        $data_insert['tel'] = $param['tel'];
        $data_insert['id_card'] = $param['id_card'];
        $data_insert['enroll_cost'] = $param['cost'];
        $data_insert['payment_status'] = $param['payment_status'];
        // $data_insert['payment_amt'] = (double)$param['payment_amt'];
        $data_insert['payment_date'] = $this->center_function->ConvertToSQLDate($param['payment_date_d'])." ".$param['payment_date_h'].":".$param['payment_date_m'];
        $data_insert['updated_at'] = $process_time;
        $this->db->where('ref_1',$param['ref_1']);
        $this->db->update('coop_enroll',$data_insert);

        
    }

    function delete_enroll($ref_1){

        $this->db->where('ref_1',$ref_1);
        $this->db->delete('coop_enroll', ['ref_1' => $ref_1]);
    }

    function DB_search($filter_search){
        // ตัด whitespace หน้า-หลัง
        $filter_search = trim($filter_search," ");
        if(!empty($filter_search))
        {   
            // หา เบอร์โทร or เลขบปชช
            if(is_numeric($filter_search))  
            {
                $sql = "SELECT * from coop_enroll as t1 
                WHERE t1.tel = '".$filter_search."'"." OR t1.id_card = '".$filter_search."'"
                ." ORDER BY created_at";
            }
            
            // หาชื่อ-นามสกุล
            else 
            {
                // spilt ตัด whitespace ตรงกลาง
                $spilt_name = preg_split('/\s+/', $filter_search);
                $firstname = $spilt_name[0];
                $lastname = $spilt_name[1];
                
                $sql = "SELECT * from coop_enroll as t1 
                WHERE t1.firstname LIKE '%$firstname%' AND t1.lastname LIKE '%$lastname%'"
                ." ORDER BY created_at";
            }
        }

        else{
            $sql = "SELECT * from coop_enroll as t1 ORDER BY created_at";
        }

        return $this->db->query($sql)->result_array();
    }

    function FormatID($id){
        $check = 0;
        $minus = 13;
        for($i=0; $i<12; $i++){
            $check += (intval($id[$i]) * $minus);
            $minus--;
        }
        $check = 11 - ($check % 11);
        $string = strval($check);
        if($string[strlen($string)-1] != $id[strlen($id)-1]){
            return false;
        }
        else{
            return true;
        }
        // return $string[strlen($string)-1];
    }
}

?>