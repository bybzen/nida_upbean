<?php


class Order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_order_data($search=null){
        $where = "t1.status = 1 AND t2.name = ".'"'.'สาขากรุงเทพ'.'"';
        $where = "t1.status = 1 ";
        $where = "t1.status = 1";
        if (!empty($id)){
            $where .= " AND t1.id = ".$id;
        }

        if (!empty($search)){
            $where .= " AND t2.id = ".$search;
            // $where .= " AND t2.name = 'สาขากรุงเทพ'";
        }

        $sql = "SELECT t1.* , t2.name AS branch_name , t2.tel as branch_tel FROM coop_order AS t1
                INNER JOIN coop_branch AS t2 ON t1.branch_id = t2.id where ".$where." ORDER BY t1.created_at DESC";
        $rs = $this->db->query($sql)->result_array();
        $data = [];
        foreach($rs as $row) {
            $payment_date = explode(" ", !empty($id) && empty($row['payment_date']) ? date('Y-m-d H:i:s') : $row['payment_date']);
            $row['payment_date_d'] = $this->center_function->C2Pickdate(@$payment_date[0]);
            $row['payment_date_h'] = @explode(":", @$payment_date[1])[0];
            $row['payment_date_m'] = @explode(":", @$payment_date[1])[1];
            $data[] = $row;
        }
        return $data;
    }


    function generate_ref($branch_id){
        $sql = "SELECT * FROM coop_branch WHERE id = ".$branch_id;
        $result = $this->db->query($sql)->result_array();
        $branch_code = $result[0]['code'];
        $branch_tel = $result[0]['tel'];
        $sql = "SELECT t1.no , t1.created_at FROM coop_order AS t1 ORDER BY t1.created_at desc";
        $res = $this->db->query($sql)->result_array();
        $now_year = date('Y') + 543;
        if (empty($res)){
            $last_no = '00000';
        } else {
            $last_year_exp = explode('-',$res[0]['created_at']);
            $last_year = $last_year_exp[0] + 543;
            if ($last_year == $now_year){
                $last_no = $res[0]['no'];
            } else {
                $last_no = '00000';
            }
        }
        $no = sprintf('%05d',(int) $last_no + 1);
        $ref_1 = $branch_code.substr($now_year,2,2).$no;
        $data = array();
        $data['ref_1'] = $ref_1;
        $data['ref_2'] = $branch_tel;
        $data['no'] = $no;
        return $data;
    }


    function create_order($param){
        $process_time = date("Y-m-d H:i:s");
        $ref_data = $this->generate_ref($param['branch_id']);
        $data_insert = array();
        $data_insert['branch_id'] = $param['branch_id'];
        $data_insert['order_no'] = $param['order_no'];
        $data_insert['value'] = $param['value'];
        $data_insert['ref_1'] = $ref_data['ref_1'];
        $data_insert['ref_2'] = $ref_data['ref_2'];
        $data_insert['created_at'] = $process_time;
        $data_insert['updated_at'] = $process_time;
        $data_insert['no'] = $ref_data['no'];
        $data_insert['status'] = 1;
        $data_insert['is_print'] = 0;
        $data_insert['payment_amt'] = $param['value'];
        $this->db->insert('coop_order',$data_insert);
    }

    function edit_order($param){
        $new_ref = array();
        $data_insert = array();
        $process_time = date("Y-m-d H:i:s");
        $new_ref = $this->re_generate_ref(
            array('order_id' => $param['order_id'] ,
                'branch_id' => $param['branch_id']
            ));
        $data_insert['ref_1'] = $new_ref['ref_1'];
        $data_insert['ref_2'] = $new_ref['ref_2'];
        $data_insert['branch_id'] = $param['branch_id'];
        $data_insert['order_no'] = $param['order_no'];
        $data_insert['value'] = $param['value'];
        $data_insert['payment_status'] = (int)$param['payment_status'];
        $data_insert['payment_amt'] = (double)$param['payment_amt'];
        $data_insert['payment_date'] = $this->center_function->ConvertToSQLDate($param['payment_date_d'])." ".$param['payment_date_h'].":".$param['payment_date_m'];
        $data_insert['updated_at'] = $process_time;
        $this->db->where('id',$param['order_id']);
        $this->db->update('coop_order',$data_insert);

        $sql = "SELECT coop_import_detail.* 
                FROM coop_import_detail
                    INNER JOIN coop_import ON coop_import_detail.import_id = coop_import.id
                WHERE coop_import.status = 1 AND coop_import_detail.order_id = {$param['order_id']}";
        $row = $this->db->query($sql)->row_array();
        if(empty($row) && $param['payment_status'] == 1) {
            $sql = "SELECT * 
                    FROM coop_import
                    WHERE status = 1 AND DATE(created_at) = DATE('{$process_time}')";
            $_row = $this->db->query($sql)->row_array();
            if(empty($_row)) {
                $_data_insert = [];
                $_data_insert['created_at'] = $process_time;
                $_data_insert['status'] = 1;
                $this->db->insert('coop_import', $_data_insert);
                $import_id = $this->db->insert_id();
            }
            else {
                $import_id = $_row['id'];
            }

            $_data_insert = [];
            $_data_insert['import_id'] = $import_id;
            $_data_insert['ref'] = $new_ref['ref_1'];
            $_data_insert['amount'] = (double)$param['payment_amt'];
            $_data_insert['order_id'] = $param['order_id'];
            $this->db->insert('coop_import_detail', $_data_insert);
        }
        elseif(!empty($row) && $param['payment_status'] == 0) {
            $this->db->delete('coop_import_detail', ['order_id' => $param['order_id']]);
        }
    }

    function delete_order($id){
        $data_insert = array();
        $data_insert['status'] = 0;
        $this->db->where('id',$id);
        $this->db->update('coop_order',$data_insert);

        $this->db->delete('coop_import_detail', ['order_id' => $id]);
    }

    //ใช้กรณีแก้ไข สาขา
    function re_generate_ref($param){
        $data = array();
        $order_id = $param['order_id'];
        $new_branch_id = $param['branch_id'];
        $sql = "SELECT created_at , no FROM coop_order WHERE id = ".$order_id;
        $result = $this->db->query($sql)->result_array();
        $no = $result[0]['no'];
        $created = explode('-',$result[0]['created_at']);
        $year = substr((int) $created[0] + 543,2,2);
        $sql = "SELECT code , tel FROM coop_branch WHERE id = ".$new_branch_id;
        $branch_data = $this->db->query($sql)->result_array();
        $code = $branch_data[0]['code'];
        $tel = $branch_data[0]['tel'];
        $data['ref_1'] = $code.$year.$no;
        $data['ref_2'] = $tel;
        return $data;
    }

    //update status is_print to 1 = printed
    function print_order($order_id){
        $data_insert = array();
        $data_insert['is_print'] = 1;
        $this->db->where('id',$order_id);
        $this->db->update('coop_order',$data_insert);
    }

    function get_import_data($id = null){
        $where = "t1.status = 1 ";
        if (!empty($id)){
            $where .= " AND t1.id = ".$id;
        }
        $sql = "SELECT t2.import_id  , t1.created_at , SUM(t2.amount) AS amount , COUNT(t2.id) AS total_count FROM coop_import AS t1
                INNER JOIN coop_import_detail AS t2 ON t1.id = t2.import_id
                WHERE ".$where."
                GROUP BY t2.import_id ORDER BY t1.created_at DESC";
        $result =  $this->db->query($sql)->result_array();
        foreach ($result as $index => $value){
            $sql = "SELECT COUNT(*) AS found_count 
                    FROM coop_import_detail WHERE import_id = ".$value['import_id']." AND order_id IS NOT null";
            $res = $this->db->query($sql)->result_array();
            $result[$index]['found_count'] = $res[0]['found_count'];
        }
        return $result;
    }

    function delete_import($id){
        $data_insert = array();
        $data_insert['status'] = 0;
        $this->db->where('id',$id);
        $this->db->update('coop_import',$data_insert);

        $process_time = date("Y-m-d H:i:s");
        $sql = "SELECT order_id FROM coop_import_detail WHERE import_id = {$id}";
        $rs = $this->db->query($sql)->result_array();
        foreach($rs as $row) {
            $_data_update = [];
            $_data_update['payment_status'] = 0;
            $_data_update['updated_at'] = $process_time;
            $this->db->where('id', $row['order_id']);
            $this->db->update('coop_order', $_data_update);
        }
    }

    function get_import_detail($import_id){
        $sql = "SELECT t1.* , t2.ref_1 , t2.created_at ,t2.order_no, t3.name FROM coop_import_detail AS t1
                LEFT JOIN coop_order AS t2 ON t1.order_id = t2.id
                LEFT JOIN coop_branch AS t3 ON t2.branch_id = t3.id
                WHERE t1.import_id = ".$import_id;
         return $this->db->query($sql)->result_array();
    }

    function get_report_data($param){
        // $where = "t4.status = 1 AND (t2.status IS NULL OR t2.status = 1)";
        // if (!empty($param['type'])){
        //     $type = $param['type'];
        //     if ($type == 1){
        //         $where .= " AND t1.order_id IS NOT NULL ";
        //     } else if ($type == 2){
        //         $where .= " AND t1.order_id IS NULL ";
        //     }
        // }

        // $start_date =  "'".$this->center_function->ConvertToSQLDate($param['start_date'])." 00:00:00'";
        // $end_date = "'".$this->center_function->ConvertToSQLDate($param['end_date'])." 23:59:59'";
        // $where .= " AND t4.created_at BETWEEN ".$start_date." AND ".$end_date;
        // if ($param['branch'] != 0 and $param['type'] != 2){
        //     $where .= " AND t3.id = ".$param['branch'];
        // }
        // $sql = "SELECT t1.* , t2.ref_1 , t2.created_at AS order_created ,t4.created_at AS import_created ,t2.order_no, t3.name FROM coop_import_detail AS t1
        //         left JOIN coop_order AS t2 ON t1.order_id = t2.id
        //         LEFT JOIN coop_branch AS t3 ON t2.branch_id = t3.id
        //         LEFT JOIN coop_import AS t4 ON t4.id = t1.import_id where ".$where;


        // ----- new -----
        $where ="";

        if ($param['branch'] != 0){
            $where .= " AND t2.id = ".$param['branch'];
        }

        // else if ($param['branch'] != 0){
        //     $where .= " AND t2.id = ".$param['branch'];
        // }

        if (!empty($param['type'])){
                $type = $param['type'];
                if ($type == 1){
                    $sql = "SELECT t1.* ,  t1.created_at AS order_created ,t1.order_no, t2.name FROM coop_order AS t1
                    LEFT JOIN coop_branch AS t2 ON t1.branch_id = t2.id
                    WHERE t1.payment_status = 1".$where;
                    
                } else if ($type == 2){
                    $sql = "SELECT t1.* ,  t1.created_at AS order_created ,t1.order_no, t2.name FROM coop_order AS t1
                    LEFT JOIN coop_branch AS t2 ON t1.branch_id = t2.id
                    WHERE t1.payment_status = 0".$where;
                   
                }
            }

        return $this->db->query($sql)->result_array();
    }

    function get_report_total_data($param){
        $where = "t1.status = 1 AND (t3.status IS NULL OR t3.status = 1) ";
        if (!empty($param['type'])){
            $type = $param['type'];
            if ($type == 1){
                $where .= " AND t2.order_id IS NOT NULL ";
            } else if ($type == 2){
                $where .= " AND t2.order_id IS NULL ";
            }
        }
        $start_date =  "'".$this->center_function->ConvertToSQLDate($param['start_date'])." 00:00:00'";
        $end_date = "'".$this->center_function->ConvertToSQLDate($param['end_date'])." 23:59:59'";
        $where .= " AND t1.created_at BETWEEN ".$start_date." AND ".$end_date;
        if ($param['branch'] != 0 and $param['type'] != 2){
            $where .= " AND t3.branch_id = ".$param['branch'];
        }
        $sql = "SELECT t1.id , CAST(t1.created_at AS DATE) as created_at , SUM(t2.amount) as amount  from coop_import AS t1
                inner JOIN coop_import_detail AS t2 ON t1.id = t2.import_id
                left JOIN coop_order AS t3 ON t3.id = t2.order_id
                WHERE ".$where."
                GROUP BY CAST(t1.created_at AS DATE)";
        return $this->db->query($sql)->result_array();
    }

    
}