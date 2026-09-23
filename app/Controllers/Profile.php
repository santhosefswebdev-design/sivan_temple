<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Profile extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{

		$data['profile'] = $this->db->table('admin_profile')
			->join('login', 'login.profile_id = admin_profile.id')
			->select('admin_profile.*')
			->select('login.profile_id')
			->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile', $data);
		echo view('template/footer');
	}
	public function myprofile()
	{
		$data['data'] = $this->db->table("login")->where('id', $_SESSION['log_id'])->get()->getRowArray();
		$data['role'] = $this->db->table("role_list")->where('id', $_SESSION['role'])->get()->getRowArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile/userprofile', $data);
		echo view('template/footer');
	}
	public function profile_edit()
	{
		if (!$this->model->permission_validate('temple_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['profile'] = $this->db->table('admin_profile')
			->join('login', 'login.profile_id = admin_profile.id')
			->select('admin_profile.*')
			->select('login.profile_id')
			->get()->getRowArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile/edit', $data);
		echo view('template/footer');
	}
	public function save()
	{
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['name_tamil'] = $_POST['name_tamil'];
		$data['address1'] = $_POST['address1'];
		$data['address2'] = $_POST['address2'];
		$data['city'] = $_POST['city'];
		$data['postcode'] = $_POST['postcode'];
		$data['telephone'] = $_POST['telephone'];
		$data['regno'] = $_POST['regno'];
		$data['mobile'] = $_POST['mobile'];
		$data['email'] = $_POST['email'];
		$data['gstno'] = $_POST['gstno'];
		$data['fax_no'] = $_POST['fax_no'];
		$data['website'] = $_POST['website'];
		$data['bankid'] = $_POST['bankid'];
		$data['donation_courtesy_grace_amount'] = $_POST['donation_courtesy_grace_amount'];
		$data['ubayam_courtesy_grace_amount'] = $_POST['ubayam_courtesy_grace_amount'];
		$data['booking_range_year'] = $_POST['booking_range_year'];

		$data['hall_remind'] = $_POST['hall_remind'];
		$data['image'] = $_SESSION['logo_img'];
		if (!empty ($_FILES['logo_img']['name']) > 0) {
			echo $_FILES['logo_img']['name'];
			$logoimg = time() . '_' . $_FILES['logo_img']['name'];
			$target_dir = "uploads/main/";
			move_uploaded_file($_FILES['logo_img']['tmp_name'], $target_dir . $logoimg);
			$data['image'] = $logoimg;
		}
		if (!empty ($_FILES['ar_logo_img']['name']) > 0) {
			echo $_FILES['ar_logo_img']['name'];
			$logoimg1 = time() . '_' . $_FILES['ar_logo_img']['name'];
			$target_dir = "uploads/main/";
			move_uploaded_file($_FILES['ar_logo_img']['tmp_name'], $target_dir . $logoimg1);
			$data['ar_image'] = $logoimg1;
		}
		$daily_closing_phone_array = array();
		$item_id = $_POST['daily_closing_phone'];
		$total_item = count($item_id);
		for ($i = 0; $i < $total_item; $i++) {
			$daily_closing_phone_array[] = array(
				'phonecode' => $_POST['phonecode'][$i],
				'phoneno' => $_POST['daily_closing_phone'][$i]
			);
		}
		$daily_closing_phone_re = json_encode($daily_closing_phone_array);
		$data['daily_closing_phone'] = $daily_closing_phone_re;

		$res = $this->db->table('admin_profile')->where('id', $id)->update($data);
		if ($res) {
			$session = array(
				'username' => $_SESSION['username'],
				'ic_number' => $_SESSION['ic_number'],
				'log_id' => $_SESSION['log_id'],
				'role' => $_SESSION['role'],
				'profile_id' => $_SESSION['profile_id'],
				'booking_range_year' => $_POST['booking_range_year'],
				'email' => $_POST['email'],
				'site_title' => $_POST['name'],
				'site_title_tamil' => $_POST['name_tamil'],
				'address1' => $_POST['address1'],
				'address2' => $_POST['address2'],
				'city' => $_POST['city'],
				'postcode' => $_POST['postcode'],
				'telephone' => $_POST['telephone'],
				'regno' => $_POST['regno'],
				'mobile' => $_POST['mobile'],
				'gstno' => $_POST['gstno'],
				'website' => $_POST['website'],
				'logo_img' => $data['image'],
				'login' => true
			);
			/*$val = $this->session->get('telephone');
					 print_r($val);*/



			$this->session->set($session);
			$this->session->setFlashdata('succ', 'Profile Updated Successfully');
			header("Location: " . base_url() . "/profile/profile_edit");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/profile/profile_edit");
		}
	}

	public function booking_setting(){
		if (!$this->model->permission_validate('temple_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$booking_settings = $this->db->table('booking_setting')->get()->getResultArray();
		$setting = array();
		if(count($booking_settings) > 0){
			foreach($booking_settings as $bs){
				$setting[$bs['meta_key']] = $bs['meta_value'];
			}
		}
		$data['setting'] = $setting;
		$data['discount_ledgers'] = $this->db->query("SELECT * FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (6000) or parent_id in (SELECT id FROM `groups` WHERE code in (6000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (6000))))")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('profile/booking_setting', $data);
		echo view('template/footer');
	}
	public function save_booking_setting(){
		try{
			if(count($_REQUEST['setting']) > 0){
				$setting = $_REQUEST['setting'];
				$temp_data = ['meta_value' => '0'];
				// Checkbox default uncheck
				$this->db->table('booking_setting')->whereIn('meta_key', ['ubayam_discount', 'archanai_discount', 'hall_discount', 'prasadam_discount'])->update($temp_data);
				foreach($setting as $key => $value){
					$count = $this->db->table('booking_setting')->where('meta_key', $key)->countAllResults();
					if(empty($count)){
						$ins_data = array();
						$ins_data['meta_key'] = $key;
						$ins_data['meta_value'] = $value;
						$this->db->table('booking_setting')->insert($ins_data);
					}else{
						$up_data = array();
						$up_data['meta_value'] = $value;
						$this->db->table('booking_setting')->where('meta_key', $key)->update($up_data);
					}
				}
				$this->session->setFlashdata('succ', 'Setting Updated Successfully');
				header("Location: " . base_url() . "/dashboard");
				exit;
			}
		}catch (Exception $e) {
			$this->db->transRollback(); // Rollback the transaction if an error occurs
			$this->session->setFlashdata('fail', $e->getMessage());
			return redirect()->to("/dashboard");
		}
	}
}


