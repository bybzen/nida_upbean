<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_menu extends CI_Controller {
	function __construct()
	{
		parent::__construct();

	}
	public function index()
	{
		$arr_data = array();
		$this->libraries->template('main_menu/index',$arr_data);
	}

	function profile(){
		if($this->input->post()){
			//echo"<pre>";print_r($_POST);print_r($_COOKIE);exit;
			$data = array(
				'password' => $this->input->post('password'),
				'user_department' => $this->input->post('user_department')
			);
			$output_dir = $_SERVER["DOCUMENT_ROOT"].PROJECTPATH."/assets/uploads/user_pic/";
			if(@$_POST['user_pic'] != '') {
				$user_pic = explode('/', $_POST['user_pic']); 
				$user_pic_name = $user_pic[(count($user_pic)-1)];
				$member_pic = $this->center_function->create_file_name($output_dir,$user_pic_name);
				@copy($_POST['user_pic'],$output_dir.$member_pic);
				@unlink($_SERVER["DOCUMENT_ROOT"].PROJECTPATH."/assets/uploads/tmp/".$user_pic_name);
				//@unlink($output_dir.$row[0]['user_pic']);
				setcookie("is_upload", "", time()-3600);
				setcookie("IMG", "", time()-3600);
				$data['user_pic'] = $member_pic;
			}

			$this->db->where('user_id', $_SESSION['USER_ID']);
			$this->db->update('coop_user', $data);
			header("location: ".PROJECTPATH."/main_menu/profile");
		}
		$arr_data = array();

		$user_id = (int) $_SESSION["USER_ID"] ;

		$this->db->select('*');
		$this->db->from('coop_user');
		$this->db->where("user_id = '".$user_id."'");
		$user = $this->db->get()->result_array();
		$arr_data['user'] = $user[0];

		$this->libraries->template('main_menu/profile',$arr_data);
	}
	function logout(){
		$_SESSION["USER_ID"] = "" ;
		session_destroy();
		if(@$_GET['res']){
			$return_url = '/auth?return_url='.urlencode(@$_GET['res']);
		}
		
		header("location: ".base_url(PROJECTPATH.@$return_url));
		exit;
	}
	function member_lb_upload(){
		$this->load->library('image');
		$this->load->view('manage_member_share/member_lb_upload');
	}

	function get_image(){
		if($_COOKIE["is_upload"]) {
			echo base_url(PROJECTPATH."/assets/uploads/tmp/".$_COOKIE["IMG"]);
		}
		exit();
	}
}
