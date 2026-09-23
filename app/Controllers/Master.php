<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Master extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper("common");
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function staff()
	{
		if (!$this->model->list_validate('staff_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('staff_setting');
		$data['list'] = $this->db->table('staff')->where('is_admin', 0)->orderBy('name', 'asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/staff', $data);
		echo view('template/footer');
	}

	public function add_staff()
	{
		if (!$this->model->permission_validate('staff_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['countries'] = $this->db->table('countries')->where('is_local', 0)->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_staff', $data);
		echo view('template/footer');
	}
	public function get_salary_epf_amount()
	{
		$basicpay = $_POST['basicpay'];
		$qry = $this->db->query("SELECT employee_contribution FROM epf WHERE from_amount <= '" . $basicpay . "' AND to_amount >= '" . $basicpay . "' AND status = 1")->getRowArray();
		$emp_amt = !empty($qry['employee_contribution']) ? $qry['employee_contribution'] : 0;
		echo number_format($emp_amt, 2);
	}
	public function get_salary_socso_amount()
	{
		$basicpay = $_POST['basicpay'];
		$qry = $this->db->query("SELECT employee_contribution FROM sosco WHERE from_amount <= '" . $basicpay . "' AND to_amount >= '" . $basicpay . "' AND status = 1")->getRowArray();
		$emp_amt = !empty($qry['employee_contribution']) ? $qry['employee_contribution'] : 0;
		echo number_format($emp_amt, 2);
	}
	public function get_salary_eis_amount()
	{
		$basicpay = $_POST['basicpay'];
		$qry = $this->db->query("SELECT employee_contribution FROM sosco_insurance WHERE from_amount <= '" . $basicpay . "' AND to_amount >= '" . $basicpay . "' AND status = 1")->getRowArray();
		$emp_amt = !empty($qry['employee_contribution']) ? $qry['employee_contribution'] : 0;
		echo number_format($emp_amt, 2);
	}
	public function save_staff()
	{
		$id = $_POST['id'];
		//echo '<pre>';
		$data['staff_type'] = $_POST['stafftype'];
		$data['name'] = trim($_POST['name']);
		$data['address1'] = trim($_POST['address1']);
		$data['address2'] = trim($_POST['address2']);
		$data['city'] = trim($_POST['city']);
		$data['mobile'] = trim($_POST['mobile']);

		$data['email'] = trim($_POST['email']);
		$data['basic_pay'] = !empty($_POST['basic_pay']) ? $_POST['basic_pay'] : 0;
		$data['allowance'] = !empty($_POST['allowance']) ? $_POST['allowance'] : 0;
		$data['salary'] = trim($_POST['salary']);
		$data['designation'] = trim($_POST['designation']);
		$data['date_of_birth'] = $_POST['date_of_birth'];
		$data['date_of_join'] = $_POST['date_of_join'];

		if ($_POST['stafftype'] == 1) {
			$data['ic_number'] = trim($_POST['ic_number']);
			if (!empty($_POST['epf'])) {
				$data['is_epf'] = $_POST['epf'];
				$data['epf_no'] = !empty($_POST['epf_no']) ? $_POST['epf_no'] : NULL;
				$data['epf_amount'] = !empty($_POST['epf_amount']) ? $_POST['epf_amount'] : 0;
			} else {
				$data['is_epf'] = 0;
				$data['epf_no'] = NULL;
				$data['epf_amount'] = 0;
			}
			if (!empty($_POST['socso'])) {
				$data['is_socso'] = $_POST['socso'];
				$data['socso_no'] = !empty($_POST['socso_no']) ? $_POST['socso_no'] : NULL;
				$data['socso_amount'] = !empty($_POST['socso_amount']) ? $_POST['socso_amount'] : 0;
			} else {
				$data['is_socso'] = 0;
				$data['socso_no'] = NULL;
				$data['socso_amount'] = 0;
			}
			if (!empty($_POST['eis'])) {
				$data['is_eis'] = $_POST['eis'];
				$data['eis_no'] = !empty($_POST['eis_no']) ? $_POST['eis_no'] : NULL;
				$data['eis_amount'] = !empty($_POST['eis_amount']) ? $_POST['eis_amount'] : 0;
			} else {
				$data['is_eis'] = 0;
				$data['eis_no'] = NULL;
				$data['eis_amount'] = 0;
			}
			$data['foreign_country_id'] = NULL;
			$data['foreign_passport_no'] = NULL;
			$data['foreign_passport_expiry_date'] = NULL;
			$data['foreign_visa_no'] = NULL;
			$data['foreign_visa_expiry_date'] = NULL;
			$data['foreign_types_of_visa'] = NULL;
		}
		if ($_POST['stafftype'] == 2) {

			$data['foreign_country_id'] = !empty($_POST['country_id']) ? $_POST['country_id'] : NULL;
			$data['foreign_passport_no'] = !empty($_POST['passport_no']) ? $_POST['passport_no'] : NULL;
			$data['foreign_passport_expiry_date'] = !empty($_POST['passport_expiry_date']) ? $_POST['passport_expiry_date'] : NULL;
			$data['foreign_visa_no'] = !empty($_POST['visa_no']) ? $_POST['visa_no'] : NULL;
			$data['foreign_visa_expiry_date'] = !empty($_POST['visa_expiry_date']) ? $_POST['visa_expiry_date'] : NULL;
			$data['foreign_types_of_visa'] = !empty($_POST['types_of_visa']) ? $_POST['types_of_visa'] : NULL;
			$data['ic_number'] = NULL;
			$data['is_epf'] = 0;
			$data['epf_no'] = NULL;
			$data['epf_amount'] = 0;
			$data['is_socso'] = 0;
			$data['socso_no'] = NULL;
			$data['socso_amount'] = 0;
			$data['is_eis'] = 0;
			$data['eis_no'] = NULL;
			$data['eis_amount'] = 0;
		}


		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('staff')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Staff Added Successfully');
				header("Location: " . base_url() . "/master/staff");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/staff");
			}
		} else {
			if ($_POST['status_staff'] == 2) {
				$data['status'] = $_POST['status_staff'];
				$data['resigned_date'] = $_POST['resign_date'];
				$data['resigned_remark'] = $_POST['resigned_remark'];
			} else {
				$data['resigned_date'] = NULL;
				$data['resigned_remark'] = NULL;
				$data['status'] = $_POST['status_staff'];
			}
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('staff')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Staff Update Successfully');
				header("Location: " . base_url() . "/master/staff");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/staff");
			}
		}
	}

	public function delete_staff()
	{
		if (!$this->model->permission_validate('staff_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('staff')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Staff Delete Successfully');
			header("Location: " . base_url() . "/master/staff");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/staff");
		}
	}

	public function edit_staff()
	{
		if (!$this->model->permission_validate('staff_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('staff')->where('id', $id)->get()->getRowArray();
		$data['countries'] = $this->db->table('countries')->where('is_local', 0)->where('status', 1)->get()->getResultArray();
		$data['staff_status'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_staff', $data);
		echo view('template/footer');
	}

	public function view_staff()
	{
		if (!$this->model->permission_validate('staff_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('staff')->where('id', $id)->get()->getRowArray();
		$data['countries'] = $this->db->table('countries')->where('is_local', 0)->where('status', 1)->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_staff', $data);
		echo view('template/footer');
	}

	public function hall()
	{
		if (!$this->model->list_validate('hall_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('hall_setting');
		$data['list'] = $this->db->table('booking_addonn')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/hall', $data);
		echo view('template/footer');
	}

	public function add_hall()
	{
		if (!$this->model->permission_validate('hall_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['checked_services'] = array();
		$data['services'] = $this->db->table("service")->where('status', 1)->get()->getResultArray();
		$data['group'] = $this->db->table('hall_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_hall', $data);
		echo view('template/footer');
	}
	public function get_service_amount()
	{
		$id = $_POST['id'];
		$res = $this->db->table("service")->where("id", $id)->get()->getRowArray();
		$amount = !empty($res['amount']) ? $res['amount'] : 0;
		echo $amount;
	}
	public function save_hall()
	{
		$id = $_POST['id'];
		//echo '<pre>';
		$data['name'] = trim($_POST['name']);
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		$data['commision'] = trim($_POST['commision']);
		$data['group_id'] = !empty($_POST['group_id']) ? trim($_POST['group_id']) : 0;
		//image_upload
		if (!empty($_FILES['hall_image']['name']) > 0) {
			echo $_FILES['hall_image']['name'];
			$name = time() . '_' . $_FILES['hall_image']['name'];
			$target_dir = "uploads/hall/";
			move_uploaded_file($_FILES['hall_image']['tmp_name'], $target_dir . $name);
			$data['image'] = $name;
		}

		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('booking_addonn')->insert($data);
			$bkadn_id = $this->db->insertID();
			if (!empty($_POST['services'])) {
				foreach ($_POST['services'] as $service_item) {
					$res = $this->db->table("service")->where("id", $service_item)->get()->getRowArray();
					$amount = !empty($res['amount']) ? $res['amount'] : 0;
					$addonn_service['booking_addon_id'] = $bkadn_id;
					$addonn_service['service_id'] = $service_item;
					$addonn_service['service_amount'] = $amount;
					$this->db->table("booking_addonn_service")->insert($addonn_service);
				}
			}
			if ($bkadn_id) {
				$this->session->setFlashdata('succ', 'Hall Added Successfully');
				header("Location: " . base_url() . "/master/hall");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/hall");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->table('booking_addonn_service')->delete(['booking_addon_id' => $id]);
			if (!empty($_POST['services'])) {
				foreach ($_POST['services'] as $service_item) {
					$res = $this->db->table("service")->where("id", $service_item)->get()->getRowArray();
					$amount = !empty($res['amount']) ? $res['amount'] : 0;
					$addonn_service['booking_addon_id'] = $id;
					$addonn_service['service_id'] = $service_item;
					$addonn_service['service_amount'] = $amount;
					$this->db->table("booking_addonn_service")->insert($addonn_service);
				}
			}
			$builder = $this->db->table('booking_addonn')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Hall Update Successfully');
				header("Location: " . base_url() . "/master/hall");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/hall");
			}
		}


	}

	public function delete_hall()
	{
		if (!$this->model->permission_validate('hall_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('booking_addonn')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Hall Delete Successfully');
			header("Location: " . base_url() . "/master/hall");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/hall");
		}
	}

	public function edit_hall()
	{
		if (!$this->model->permission_validate('hall_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('booking_addonn')->where('id', $id)->get()->getRowArray();
		$data['services'] = $this->db->table("service")->where('status', 1)->get()->getResultArray();
		$data['group'] = $this->db->table('hall_group')->orderBy('id', 'desc')->get()->getResultArray();
		$booking_addonn_services = $this->db->table("booking_addonn_service")->where('booking_addon_id', $id)->get()->getResultArray();
		$data_addonservice = array();
		foreach ($booking_addonn_services as $booking_addonn_service) {
			$data_addonservice[] = $booking_addonn_service['service_id'];
		}
		$data['checked_services'] = $data_addonservice;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_hall', $data);
		echo view('template/footer');
	}

	public function view_hall()
	{
		if (!$this->model->permission_validate('hall_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('booking_addonn')->where('id', $id)->get()->getRowArray();
		$data['services'] = $this->db->table("service")->where('status', 1)->get()->getResultArray();
		$data['group'] = $this->db->table('hall_group')->orderBy('id', 'desc')->get()->getResultArray();
		$booking_addonn_services = $this->db->table("booking_addonn_service")->where('booking_addon_id', $id)->get()->getResultArray();
		$data_addonservice = array();
		foreach ($booking_addonn_services as $booking_addonn_service) {
			$data_addonservice[] = $booking_addonn_service['service_id'];
		}
		$data['checked_services'] = $data_addonservice;
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_hall', $data);
		echo view('template/footer');
	}
	public function hall_group()
	{
		if (!$this->model->list_validate('hall_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('hall_setting');
		$data['list'] = $this->db->table('hall_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/hall_group', $data);
		echo view('template/footer');
	}

	public function save_hall_group()
	{
		$id = $_POST['id'];

		$data['name'] = trim($_POST['name']);
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('hall_group')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Hall group Added Successfully');
				header("Location: " . base_url() . "/master/hall_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/hall_group");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('hall_group')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Hall group Update Successfully');
				header("Location: " . base_url() . "/master/hall_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/hall_group");
			}
		}

	}

	public function delete_hall_group()
	{
		if (!$this->model->permission_validate('hall_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('hall_group')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Hall group Delete Successfully');
			header("Location: " . base_url() . "/master/hall_group");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/hall_group");
		}
	}

	public function edit_hall_group()
	{
		if (!$this->model->permission_validate('hall_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('hall_group')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_hall_group', $data);
		echo view('template/footer');
	}

	public function view_hall_group()
	{
		if (!$this->model->permission_validate('hall_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('hall_group')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		// print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_hall_group', $data);
		echo view('template/footer');
	}

	public function hall_group_validation()
	{
		$name = trim($_POST['name']);
		$data = array();
		if (empty($name)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function timing()
	{
		if (!$this->model->list_validate('timing')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('timing');
		$data['list'] = $this->db->table('booking_slot')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/timing', $data);
		echo view('template/footer');
	}
	public function add_timing()
	{
		if (!$this->model->permission_validate('timing', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_timing');
		echo view('template/footer');
	}

	public function save_timing()
	{
		$id = $_POST['id'];
		//echo '<pre>';

		$data['name'] = $_POST['name'];
		$data['description'] = $_POST['description'];

		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('booking_slot')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Timing Added Successfully');
				header("Location: " . base_url() . "/master/timing");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/timing");
			}
		} else {
			$builder = $this->db->table('booking_slot')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Timing Update Successfully');
				header("Location: " . base_url() . "/master/timing");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/timing");
			}
		}
	}

	public function delete_timing()
	{
		if (!$this->model->permission_validate('timing', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('booking_slot')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Timing Delete Successfully');
			header("Location: " . base_url() . "/master/timing");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/timing");
		}
	}

	public function edit_timing()
	{
		if (!$this->model->permission_validate('timing', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('booking_slot')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_timing', $data);
		echo view('template/footer');
	}

	public function view_timing()
	{
		if (!$this->model->permission_validate('timing', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('booking_slot')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_timing', $data);
		echo view('template/footer');
	}

	public function uom()
	{
		if (!$this->model->list_validate('uom')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('uom');
		$data['list'] = $this->db->table('uom_list')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/uom', $data);
		echo view('template/footer');
	}

	public function add_uom()
	{
		if (!$this->model->permission_validate('uom', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_uom');
		echo view('template/footer');
	}

	public function save_uom()
	{
		$id = $_POST['id'];
		//echo '<pre>';

		$data['symbol'] = $_POST['symbol'];
		$data['name'] = $_POST['name'];

		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('uom_list')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'UOM Added Successfully');
				header("Location: " . base_url() . "/master/uom");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/uom");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('uom_list')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'UOM Update Successfully');
				header("Location: " . base_url() . "/master/uom");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/uom");
			}
		}
	}

	public function delete_uom()
	{
		if (!$this->model->permission_validate('uom', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('uom_list')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'UOM Delete Successfully');
			header("Location: " . base_url() . "/master/uom");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/uom");
		}
	}

	public function edit_uom()
	{
		if (!$this->model->permission_validate('uom', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('uom_list')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_uom', $data);
		echo view('template/footer');
	}

	public function view_uom()
	{
		if (!$this->model->permission_validate('uom', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('uom_list')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_uom', $data);
		echo view('template/footer');
	}

	public function donation_group()
	{
		if (!$this->model->list_validate('donation_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('donation_setting');
		$data['list'] = $this->db->table('cashdonation_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/donation_group', $data);
		echo view('template/footer');
	}

	public function save_donation_group()
	{
		$id = $_POST['id'];

		$data['name'] = trim($_POST['name']);
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('cashdonation_group')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Hall group Added Successfully');
				header("Location: " . base_url() . "/master/donation_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/donation_group");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('cashdonation_group')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Hall group Update Successfully');
				header("Location: " . base_url() . "/master/donation_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/donation_group");
			}
		}

	}

	public function delete_donation_group()
	{
		if (!$this->model->permission_validate('donation_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('cashdonation_group')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Donation group Delete Successfully');
			header("Location: " . base_url() . "/master/donation_group");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/donation_group");
		}
	}

	public function edit_donation_group()
	{
		if (!$this->model->permission_validate('donation_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cashdonation_group')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_group', $data);
		echo view('template/footer');
	}

	public function view_donation_group()
	{
		if (!$this->model->permission_validate('donation_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cashdonation_group')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		// print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_group', $data);
		echo view('template/footer');
	}
	public function donation_group_validation()
	{
		$name = trim($_POST['name']);

		$data = array();
		if (empty($name)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
	public function donation_setting()
	{
		if (!$this->model->list_validate('donation_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('donation_setting');
		$data['list'] = $this->db->table('donation_setting')->orderBy('id', 'desc')->get()->getResultArray();
		$data['donation_category'] = $this->db->table('donation_category')->orderBy('name', 'ASC')->get()->getResultArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->orderBy('name', 'ASC')->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('cashdonation_group')->orderBy('name', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/donation_setting', $data);
		echo view('template/footer');
	}
	public function add_donation_setting()
	{
		if (!$this->model->permission_validate('donation_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['group'] = $this->db->table('cashdonation_group')->orderBy('id', 'desc')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_setting', $data);
		echo view('template/footer');
	}

	public function save_donation_setting()
	{
		$id = $_POST['id'];
		//echo '<pre>';

		$data['name'] = trim($_POST['name']);
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		$data['groupname'] = trim($_POST['groupname']);
		if (!empty($_POST['ledger_id']))
			$data['ledger_id'] = $_POST['ledger_id'];
		if (!empty($_POST['donation_cat']))
			$data['donation_cat_id'] = trim($_POST['donation_cat']);
		if (!empty($_FILES['donation_image']['name']) > 0) {
			echo $_FILES['donation_image']['name'];
			$name = time() . '_' . $_FILES['donation_image']['name'];
			$target_dir = "uploads/donation/";
			move_uploaded_file($_FILES['donation_image']['tmp_name'], $target_dir . $name);
			$data['image'] = $name;
		}


		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('donation_setting')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Donation Setting Added Successfully');
				header("Location: " . base_url() . "/master/donation_setting");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/donation_setting");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('donation_setting')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Donation Setting Update Successfully');
				header("Location: " . base_url() . "/master/donation_setting");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/donation_setting");
			}
		}
	}

	public function delete_donation_setting()
	{
		if (!$this->model->permission_validate('donation_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('donation_setting')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Donation Setting Delete Successfully');
			header("Location: " . base_url() . "/master/donation_setting");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/donation_setting");
		}
	}

	public function edit_donation_setting()
	{
		if (!$this->model->permission_validate('donation_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('donation_setting')->where('id', $id)->get()->getRowArray();
		$data['donation_category'] = $this->db->table('donation_category')->get()->getResultArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('cashdonation_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_setting', $data);
		echo view('template/footer');
	}

	public function view_donation_setting()
	{
		if (!$this->model->permission_validate('donation_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('donation_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('cashdonation_group')->orderBy('id', 'desc')->get()->getResultArray();
		$data['donation_category'] = $this->db->table('donation_category')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_setting', $data);
		echo view('template/footer');
	}

	public function donation_category()
	{
		$data['permission'] = $this->model->get_permission('donation_category');


		$builder = $this->db->table('donation_category');


		$builder->select('donation_category.*, funds.name AS fund_name');
		$builder->join('funds', 'donation_category.fund_id = funds.id', 'left');
		$data['list'] = $builder->get()->getResultArray();
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/donation_category', $data);
		echo view('template/footer');
	}

	public function add_donation_category()
	{

		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_category', $data);
		echo view('template/footer');
	}
	public function delete_donation_category()
	{

		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('donation_category')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Donation Category Delete Successfully');
			header("Location: " . base_url() . "/master/donation_category");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/donation_category");
		}
	}

	public function edit_donation_category()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('donation_category')->where('id', $id)->get()->getRowArray();
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_category', $data);
		echo view('template/footer');
	}
	public function view_donation_category()
	{

		$id = $this->request->uri->getSegment(3);
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
		$data['data'] = $this->db->table('donation_category')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_donation_category', $data);
		echo view('template/footer');
	}
	public function save_donation_category()
	{


		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);
		$data['description'] = trim($_POST['description']);

		if (!empty($_POST['fund_id']))
			$data['fund_id'] = trim($_POST['fund_id']);

		if (empty($id)) {
			$builder = $this->db->table('donation_category')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Donation Category Added Successfully');
				header("Location: " . base_url() . "/master/donation_category");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/donation_category");
			}
		} else {

			$builder = $this->db->table('donation_category')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Donation Category Update Successfully');
				header("Location: " . base_url() . "/master/donation_category");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/donation_category");
			}
		}

	}
	public function donation_category_validation()
	{
		$name = trim($_POST['name']);

		$data = array();
		if (empty($name)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
	public function ubayam_setting()
	{
		if (!$this->model->list_validate('ubayam_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ubayam_setting');
		$data['list'] = $this->db->table('ubayam_setting')->orderBy('id', 'desc')->get()->getResultArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->orderBy('name', 'ASC')->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('ubayam_group')->orderBy('name', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/ubayam_setting', $data);
		echo view('template/footer');
	}
	public function add_ubayam_setting()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['group'] = $this->db->table('ubayam_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_ubayam_setting');
		echo view('template/footer');
	}

	public function save_ubayam_setting()
	{
		$id = $_POST['id'];
		//echo '<pre>';

		$data['name'] = trim($_POST['name']);
		$data['ubayam_date'] = $_POST['ubayam_date'];
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		$data['event_type'] = $_POST['event_type'];
		$data['groupname'] = trim($_POST['groupname']);
		if (!empty($_POST['ledger_id']))
			$data['ledger_id'] = $_POST['ledger_id'];

		if (!empty($_FILES['ubayam_image']['name']) > 0) {
			echo $_FILES['ubayam_image']['name'];
			$name = time() . '_' . $_FILES['ubayam_image']['name'];
			$target_dir = "uploads/ubayam/";
			move_uploaded_file($_FILES['ubayam_image']['tmp_name'], $target_dir . $name);
			$data['image'] = $name;
		}

		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('ubayam_setting')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Ubayam Setting Added Successfully');
				header("Location: " . base_url() . "/master/ubayam_setting");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/ubayam_setting");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('ubayam_setting')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Ubayam Setting Update Successfully');
				header("Location: " . base_url() . "/master/ubayam_setting");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/ubayam_setting");
			}
		}
	}

	public function delete_ubayam_setting()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('ubayam_setting')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Ubayam Setting Delete Successfully');
			header("Location: " . base_url() . "/master/ubayam_setting");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/ubayam_setting");
		}
	}

	public function edit_ubayam_setting()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ubayam_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['group'] = $this->db->table('ubayam_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_ubayam_setting', $data);
		echo view('template/footer');
	}

	public function view_ubayam_setting()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ubayam_setting')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['view'] = true;
		$data['group'] = $this->db->table('ubayam_group')->orderBy('id', 'desc')->get()->getResultArray();
		// print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_ubayam_setting', $data);
		echo view('template/footer');
	}

	public function ubayam_group()
	{
		if (!$this->model->list_validate('ubayam_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ubayam_setting');
		$data['list'] = $this->db->table('ubayam_group')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/ubayam_group', $data);
		echo view('template/footer');
	}
	public function add_ubayam_group()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_ubayam_group');
		echo view('template/footer');
	}

	public function save_ubayam_group()
	{
		$id = $_POST['id'];

		$data['name'] = trim($_POST['name']);
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('ubayam_group')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Ubayam group Added Successfully');
				header("Location: " . base_url() . "/master/ubayam_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/ubayam_group");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('ubayam_group')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Ubayam group Update Successfully');
				header("Location: " . base_url() . "/master/ubayam_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/ubayam_group");
			}
		}

	}

	public function delete_ubayam_group()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('ubayam_group')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Ubayam group Delete Successfully');
			header("Location: " . base_url() . "/master/ubayam_group");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/ubayam_group");
		}
	}

	public function edit_ubayam_group()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ubayam_group')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_ubayam_group', $data);
		echo view('template/footer');
	}

	public function view_ubayam_group()
	{
		if (!$this->model->permission_validate('ubayam_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ubayam_group')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		// print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_ubayam_group', $data);
		echo view('template/footer');
	}
	public function ubayam_g_validation()
	{
		$name = trim($_POST['name']);
		$data = array();
		if (empty($name)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function stock_group()
	{
		if (!$this->model->list_validate('stock_group')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('stock_group');
		$data['list'] = $this->db->table('stock_group')
			->select('stock_group.*')
			->get()
			->getResultArray();
		$data['category'] = $this->db->table('stock_group')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/stock_group', $data);
		echo view('template/footer');
	}

	public function stock_category()
	{
		if (!$this->model->list_validate('stock_group')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('stock_group');
		$data['list'] = $this->db->table('category')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/stock_category', $data);
		echo view('template/footer');
	}

	public function add_stock_group()
	{
		if (!$this->model->permission_validate('stock_group', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_stock_group');
		echo view('template/footer');
	}

	public function save_stock_group()
	{
		$id = $_POST['id'];
		//echo '<pre>';

		$data['name'] = $_POST['name'];
		$data['category'] = $_POST['category'];
		$data['order_code'] = $_POST['order_code'];

		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('stock_group')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Stock Group Added Successfully');
				header("Location: " . base_url() . "/master/stock_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/stock_group");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('stock_group')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Stock Group Update Successfully');
				header("Location: " . base_url() . "/master/stock_group");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/stock_group");
			}
		}
	}
	public function save_stock_category()
	{
		$id = $_POST['id'];
		$data['category'] = trim($_POST['category']);

		if ($data['category']) {
			if (empty($id)) {
				$data['created'] = date('Y-m-d H:i:s');
				$data['modified'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('category')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Stock Category Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$data['modified'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('category')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Stock Category Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill Category');
		}
		header("Location: " . base_url() . "/master/stock_category");
	}

	public function delete_stock_group()
	{
		if (!$this->model->permission_validate('stock_group', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('stock_group')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Stock Group Delete Successfully');
			header("Location: " . base_url() . "/master/stock_group");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/stock_group");
		}
	}

	public function delete_stock_Category()
	{
		if (!$this->model->permission_validate('stock_group', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('category')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Stock Category Delete Successfully');
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
		}
		header("Location: " . base_url() . "/master/stock_category");

	}
	public function edit_stock_group()
	{
		if (!$this->model->permission_validate('stock_group', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('stock_group')->where('id', $id)->get()->getRowArray();
		$data['category'] = $this->db->table('stock_group')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_stock_group', $data);
		echo view('template/footer');
	}

	public function view_stock_group()
	{
		if (!$this->model->permission_validate('stock_group', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('stock_group')->where('id', $id)->get()->getRowArray();
		$data['category'] = $this->db->table('stock_group')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_stock_group', $data);
		echo view('template/footer');
	}

	public function view_stock_category()
	{
		if (!$this->model->permission_validate('stock_group', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('category')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_stock_category', $data);
		echo view('template/footer');
	}

	public function edit_stock_category()
	{
		if (!$this->model->permission_validate('stock_group', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('category')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_stock_category', $data);
		echo view('template/footer');
	}

	public function product()
	{
		//$data['list'] = $this->db->table('products')->get()->getResultArray();
		if (!$this->model->list_validate('product')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('product');
		$data['list'] = $this->db->table('products')
			->join('uom_list', 'uom_list.id = products.uom_id', 'left')
			->join('stock_group', 'stock_group.id = products.stock_group', 'left')
			->select('uom_list.*')
			->select('stock_group.name as sname')
			->select('products.*')
			->get()
			->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/product', $data);
		echo view('template/footer');
	}
	public function add_product()
	{
		if (!$this->model->permission_validate('product', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['stock'] = $this->db->table('stock_group')->get()->getResultArray();
		$data['suppliers'] = $this->db->table('supplier')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_product', $data);
		echo view('template/footer');
	}

	public function save_product()
	{
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['stock_group'] = $_POST['stock_group'];
		$data['product_model'] = $_POST['product_model'];
		$data['opening_stock'] = $_POST['opening_stock'];
		$data['minimum_stock'] = $_POST['minimum_stock'];
		$data['uom_id'] = $_POST['uom_id'];
		$data['price'] = $_POST['price'];
		$data['expire_type'] = !empty($_POST['expire_type']) ? $_POST['expire_type'] : 0;
		if ($_POST['expire_type'] == 1) {
			$data['mfg_date'] = $_POST['mfg_date'];
			$data['exp_date'] = $_POST['exp_date'];
			$data['service_date'] = NULL;
		} else if ($_POST['expire_type'] == 2) {
			$data['service_date'] = $_POST['service_date'];
			$data['mfg_date'] = NULL;
			$data['exp_date'] = NULL;
		} else {
			$data['service_date'] = NULL;
			$data['mfg_date'] = NULL;
			$data['exp_date'] = NULL;
		}
		$data['product_description'] = $_POST['product_description'];
		$data['supplier_id'] = $_POST['supplier_id'];

		if (!empty($_FILES['product']['name']) > 0) {
			echo $_FILES['product']['name'];
			$product_img = time() . '_' . $_FILES['product']['name'];
			$target_dir = "uploads/product/";
			move_uploaded_file($_FILES['product']['tmp_name'], $target_dir . $product_img);
			$data['image'] = $product_img;
		}

		if (empty($id)) {
			$data['quantity'] = $_POST['opening_stock'];
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('products')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Product Added Successfully');
				header("Location: " . base_url() . "/master/product");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/product");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('products')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Product Update Successfully');
				header("Location: " . base_url() . "/master/product");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/product");
			}
		}
	}

	public function delete_product()
	{
		if (!$this->model->permission_validate('product', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('products')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Product Delete Successfully');
			header("Location: " . base_url() . "/master/product");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/product");
		}
	}
	public function edit_product()
	{
		if (!$this->model->permission_validate('product', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('products')->where('id', $id)->get()->getRowArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['stock'] = $this->db->table('stock_group')->get()->getResultArray();
		$data['suppliers'] = $this->db->table('supplier')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_product', $data);
		echo view('template/footer');
	}

	public function view_product()
	{
		if (!$this->model->permission_validate('product', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('products')->where('id', $id)->get()->getRowArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['stock'] = $this->db->table('stock_group')->get()->getResultArray();
		$data['suppliers'] = $this->db->table('supplier')->where('status', 1)->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_product', $data);
		echo view('template/footer');
	}

	public function hall_validation()
	{
		$name = trim($_POST['name']);
		$amount = trim($_POST['amount']);
		$services = $_POST['services'];
		$data = array();
		if (empty($name) || empty($amount) || count($services) < 0) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function staff_validation()
	{
		$name = trim($_POST['name']);
		$icnum = trim($_POST['phone']);
		$salary = trim($_POST['salary']);
		//$date_of_join = trim($_POST['date_of_join']);
		$data = array();
		if (empty($name) || empty($icnum) || empty($salary)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function donation_validation()
	{
		$name = trim($_POST['name']);
		$amount = trim($_POST['amount']);
		$data = array();
		if (empty($name) || empty($amount)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function ubayam_validation()
	{
		$name = trim($_POST['name']);
		$amount = trim($_POST['amount']);
		$event_type = $_POST['event_type'];
		$data = array();
		if (empty($name) || empty($amount) || empty($event_type)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
	public function archanai_validation()
	{
		$name_eng = trim($_POST['name_eng']);
		$name_tamil = trim($_POST['name_tamil']);
		$amount = trim($_POST['amount']);
		$group = $_POST['groupname'];
		// echo 'amt = '. (float)$_POST['amount']; 
		// echo 'commission = '. (float)$_POST['commission']; exit ;
		//echo json_encode($group);	
		//$order_no = trim($_POST['order_no']);
		$data = array();
		//if (empty($name_eng) || empty($name_tamil) || empty($amount) || empty($order_no) ) {
		if (empty($name_eng) || empty($name_tamil) || empty($amount)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else if ((float) $_POST['amount'] <= (float) $_POST['commission']) {
			$data['err'] = "Please check Amount and Commission";
			$data['succ'] = '';

		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}



	public function del_hall_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("hall_booking_details")->where("booking_addon_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function del_venue_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("temple_package_venues")->where("venue_id", $id)->get()->getResultArray();
		echo count($res);
	}

	public function del_don_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("donation")->where("pay_for", $id)->get()->getResultArray();
		echo count($res);
	}

	public function del_uby_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("ubayam")->where("pay_for", $id)->get()->getResultArray();
		echo count($res);
	}

	public function del_staff_check()
	{
		$id = $_POST['id'];
		//$res = "SELECT (select count(*) from archanai_booking where comission_to=$id) + (select count(*) from hall_booking where commision_to=$id) as total_rows";
		$res = $this->db->query("SELECT (select count(*) from archanai_booking where comission_to=$id) 
										+ (select count(*) from hall_booking where commision_to=$id) 
										+ (select count(*) from pay_slip where staff_id=$id) 
										+ (select count(*) from stock_inward where staff_name=$id) 
										+ (select count(*) from stock_outward where staff_name=$id) 
										as total_rows")->getRowArray();

		echo $res['total_rows'];

	}


	public function hall_block()
	{
		if (!$this->model->list_validate('hall_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('hall_setting');
		$data['list'] = $this->db->table('booking_addonn')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/hall_block', $data);
		echo view('template/footer');
	}

	public function prasadam()
	{
		if (!$this->model->list_validate('prasadam_master')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('prasadam_master');
		$data['list'] = $this->db->table('prasadam_master')
			->select('prasadam_master.*')
			->orderBy('date', 'DESC')
			->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/prasadam', $data);
		echo view('template/footer');
	}
	public function add_prasadam()
	{

		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_prasadam');
		echo view('template/footer');
	}
	public function edit_prasadam()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_master')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_prasadam', $data);
		echo view('template/footer');
	}

	public function view_prasadam()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('prasadam_master')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_prasadam', $data);
		echo view('template/footer');
	}
	public function save_prasadam()
	{
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['date'] = $_POST['date'];
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('prasadam_master')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Prasadam Added Successfully');
				header("Location: " . base_url() . "/master/prasadam");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/prasadam");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('prasadam_master')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Prasadam Update Successfully');
				header("Location: " . base_url() . "/master/prasadam");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/prasadam");
			}
		}
	}
	public function property_type()
	{
		$data['list'] = $this->db->table('property_category')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/property_type', $data);
		echo view('template/footer');
	}

	public function save_property_type()
	{
		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);

		if ($data['name']) {
			if (empty($id)) {
				$data['created_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('property_category')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Property Type Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$builder = $this->db->table('property_category')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Property Type Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill Category');
		}
		header("Location: " . base_url() . "/master/property_type");
	}

	public function edit_property_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('property_category')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_property_type', $data);
		echo view('template/footer');
	}

	public function view_property_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('property_category')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_property_type', $data);
		echo view('template/footer');
	}

	public function delete_property_type()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('property_category')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Property Type Delete Successfully');
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
		}
		header("Location: " . base_url() . "/master/property_type");

	}
	public function property_title()
	{
		$data['list'] = $this->db->table('property_title')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/property_title', $data);
		echo view('template/footer');
	}

	public function save_property_title()
	{
		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);
		$data['description'] = $_POST['description'];

		if ($data['name']) {
			if (empty($id)) {
				$data['created_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('property_title')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Property Title Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$builder = $this->db->table('property_title')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Property Title Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please enter name');
		}
		header("Location: " . base_url() . "/master/property_title");
	}

	public function edit_property_title()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('property_title')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_property_title', $data);
		echo view('template/footer');
	}

	public function view_property_title()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('property_title')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_property_title', $data);
		echo view('template/footer');
	}

	public function delete_property_title()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('property_title')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Property Title Delete Successfully');
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
		}
		header("Location: " . base_url() . "/master/property_title");

	}
	public function rental_type()
	{
		$data['list'] = $this->db->table('rental_type')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/rental_type', $data);
		echo view('template/footer');
	}

	public function save_rental_type()
	{
		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);

		if ($data['name']) {
			if (empty($id)) {
				$data['created_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('rental_type')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Rental Type Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$builder = $this->db->table('rental_type')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Rental Type Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill Category');
		}
		header("Location: " . base_url() . "/master/rental_type");
	}

	public function edit_rental_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('rental_type')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_rental_type', $data);
		echo view('template/footer');
	}

	public function view_rental_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('rental_type')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_rental_type', $data);
		echo view('template/footer');
	}
	public function delete_rental_type()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('rental_type')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Rental Type Delete Successfully');
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
		}
		header("Location: " . base_url() . "/master/rental_type");

	}
	public function service()
	{

		$data['permission'] = $this->model->get_permission('service_setting');
		$data['list'] = $this->db->table('service')->where('status', 1)->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/service', $data);
		echo view('template/footer');
	}

	public function add_service()
	{
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_service', $data);
		echo view('template/footer');
	}

	public function save_service()
	{
		$id = $_POST['id'];
		//echo '<pre>';

		$data['name'] = trim($_POST['name']);
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		if (!empty($_POST['ledger_id']))
			$data['ledger_id'] = $_POST['ledger_id'];
		/*$data['added_by']	 =	$this->session->get('log_id');*/

		if (empty($id)) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('service')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Service Added Successfully');
				header("Location: " . base_url() . "/master/service");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/service");
			}
		} else {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('service')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Service Update Successfully');
				header("Location: " . base_url() . "/master/service");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/service");
			}
		}
	}

	public function delete_service()
	{

		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('service')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'service Delete Successfully');
			header("Location: " . base_url() . "/master/service");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/service");
		}
	}

	public function edit_service()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('service')->where('id', $id)->get()->getRowArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_service', $data);
		echo view('template/footer');
	}

	public function view_service()
	{

		$id = $this->request->uri->getSegment(3);
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['data'] = $this->db->table('service')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_service', $data);
		echo view('template/footer');
	}
	public function service_validation()
	{
		$name = trim($_POST['name']);
		$amount = trim($_POST['amount']);
		$data = array();
		if (empty($name) || empty($amount)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
	public function checklist()
	{

		$data['permission'] = $this->model->get_permission('checklist_setting');
		$data['list'] = $this->db->table('checklist')->join('service', 'service.id = checklist.service_id')->select("checklist.*,service.name as servicename")->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/checklist', $data);
		echo view('template/footer');
	}
	public function add_checklist()
	{

		$data['service_lists'] = $this->db->table('service')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_checklist', $data);
		echo view('template/footer');
	}
	public function save_checklist()
	{
		$id = $_POST['id'];
		//echo '<pre>';
		$data['name'] = trim($_POST['name']);
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		$data['service_id'] = $_POST['service_id'];
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['updated'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('checklist')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Checklist Added Successfully');
				header("Location: " . base_url() . "/master/checklist");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/checklist");
			}
		} else {
			$data['updated'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('checklist')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Checklist Update Successfully');
				header("Location: " . base_url() . "/master/checklist");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/checklist");
			}
		}
	}
	public function edit_checklist()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('checklist')->where('id', $id)->get()->getRowArray();
		$data['service_lists'] = $this->db->table('service')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_checklist', $data);
		echo view('template/footer');
	}
	public function view_checklist()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('checklist')->where('id', $id)->get()->getRowArray();
		$data['service_lists'] = $this->db->table('service')->where('status', 1)->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_checklist', $data);
		echo view('template/footer');
	}
	public function delete_checklist($id)
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('checklist')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Checklist Delete Successfully');
			header("Location: " . base_url() . "/master/checklist");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/checklist");
		}
	}
	public function checklist_validation()
	{
		$name = trim($_POST['name']);
		$amount = trim($_POST['amount']);
		$service_id = trim($_POST['service_id']);
		$data = array();
		if (empty($name) || empty($amount) || empty($service_id)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function payment_option()
	{
		$data['list'] = $this->db->table('payment_option')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/payment_option', $data);
		echo view('template/footer');
	}

	public function add_payment_option()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_payment_option');
		echo view('template/footer');
	}

	public function edit_payment_option()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('payment_option')->where('id', $id)->get()->getRowArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_payment_option', $data);
		echo view('template/footer');
	}

	public function save_payment_option()
	{
		$id = $_POST['id'];

		$data['pay_name'] = trim($_POST['pay_name']);
		$data['pay_id'] = trim($_POST['pay_id']);
		$data['status'] = trim($_POST['status']);

		if (!empty($_FILES['image']['name']) > 0) {
			echo $_FILES['image']['name'];
			$name = time() . '_' . $_FILES['image']['name'];
			$target_dir = "uploads/payment/";
			move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $name);
			$data['image'] = $name;
		}
		if (empty($id)) {
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('payment_option')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Payment Option Added Successfully');
				header("Location: " . base_url() . "/master/payment_option");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/payment_option");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('payment_option')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Payment Option Update Successfully');
				header("Location: " . base_url() . "/master/payment_option");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/payment_option");
			}
		}
	}



	public function booking_slot()
	{
		$data = array();
		$data['list'] = $this->db->table("booking_slot_new")->select('*')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/booking_slot', $data);
		echo view('template/footer');
	}


	public function add_booking_slot()
	{
		$data = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_booking_slot', $data);
		echo view('template/footer');
	}


	public function edit_booking_slot()
	{
		$data = array();
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->query("SELECT bsn.*, MAX(if(bstn.slot_type = 1, 1, 0)) as hall_check, MAX(if(bstn.slot_type = 2, 1, 0)) as ubay_check, MAX(if(bstn.slot_type = 3, 1, 0)) as sann_check FROM `booking_slot_new` bsn left join booking_slot_type_new bstn on bstn.booking_slot_id = bsn.id where bsn.id = $id group by bsn.id")->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_booking_slot', $data);
		echo view('template/footer');
	}

	public function view_booking_slot()
	{
		$data = array();
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('booking_slot_new')
			->join('booking_slot_type_new', 'booking_slot_new.id=booking_slot_type_new.booking_slot_id')
			->where('booking_slot_new.id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_booking_slot', $data);
		echo view('template/footer');
	}

	public function booking_slot_save()
	{
		$data = array();
		if (!empty($_POST['slot_name'])) {
			$data['slot_name'] = trim($_POST['slot_name']);
			$data['description'] = trim($_POST['slot_name']);
			if (isset($_POST['status']))
				$data['status'] = trim($_POST['status']);
			if (empty($_POST['id'])) {
				$data['created_by'] = $this->session->get('log_id');
				$data['created_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('booking_slot_new')->insert($data);
				$ins_id = $this->db->insertID();
			} else {
				$ins_id = $_POST['id'];
				$builder = $this->db->table('booking_slot_new')->where('id', $ins_id)->update($data);
			}
			if ($ins_id) {
				$this->db->table('booking_slot_type_new')->delete(['booking_slot_id' => $ins_id]);
				if (!empty($_POST['hall_slot_type'])) {
					$data1['slot_type'] = 1;
					$data1['booking_slot_id'] = $ins_id;
					$builder1 = $this->db->table('booking_slot_type_new')->insert($data1);
				}
				if (!empty($_POST['ubayam_slot_type'])) {
					$data1['slot_type'] = 2;
					$data1['booking_slot_id'] = $ins_id;
					$builder1 = $this->db->table('booking_slot_type_new')->insert($data1);
				}
				if (!empty($_POST['sannathi_slot_type'])) {
					$data1['slot_type'] = 3;
					$data1['booking_slot_id'] = $ins_id;
					$builder1 = $this->db->table('booking_slot_type_new')->insert($data1);
				}
				$this->session->setFlashdata('succ', 'Booking Slot Added Successfully');
				header("Location: " . base_url() . "/master/booking_slot");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/booking_slot");
			}
		} else {
			$this->session->setFlashdata('fail', 'Please fill all required field');
			header("Location: " . base_url() . "/master/booking_slot");
		}
		exit;

	}

	public function venue()
	{
		$data = array();
		$data['list'] = $this->db->table("venue")->select('*')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/venue', $data);
		echo view('template/footer');
	}


	public function add_venue()
	{
		$data = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_venue', $data);
		echo view('template/footer');
	}


	public function edit_venue()
	{
		$data = array();
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table("venue")->select('*')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_venue', $data);
		echo view('template/footer');
	}

	public function view_venue()
	{
		$data = array();
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table("venue")->select('*')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_venue', $data);
		echo view('template/footer');
	}

	public function venue_save()
	{
		$data = array();
		if (!empty($_POST['name'])) {
			$data['name'] = trim($_POST['name']);
			$data['description'] = trim($_POST['description']);
			if (isset($_POST['status']))
				$data['status'] = trim($_POST['status']);
			if (empty($_POST['id'])) {
				$data['created_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('venue')->insert($data);
				$ins_id = $this->db->insertID();

				$this->session->setFlashdata('succ', 'Venue Created Successfully');
				header("Location: " . base_url() . "/master/venue");
			} else {
				$ins_id = $_POST['id'];
				$builder = $this->db->table('venue')->where('id', $ins_id)->update($data);

				$this->session->setFlashdata('succ', 'Venue Updated Successfully');
				header("Location: " . base_url() . "/master/venue");
			}


		} else {
			$this->session->setFlashdata('fail', 'Please fill all required field');
			header("Location: " . base_url() . "/master/venue");
		}
		exit;

	}
	public function delete_venue()
	{
		// if (!$this->model->permission_validate('hall_setting', 'delete_p')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('venue')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'venue Delete Successfully');
			header("Location: " . base_url() . "/master/venue");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/master/venue");
		}
	}

	public function pack_service()
	{
		$data = array();
		$data['list'] = $this->db->table("temple_services")->select('*')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/pack_service', $data);
		echo view('template/footer');
	}

	public function add_pack_service()
	{
		$data = array();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_pack_service', $data);
		echo view('template/footer');
	}

	public function edit_pack_service()
	{
		$id = $this->request->uri->getSegment(3);
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['data'] = $this->db->table('temple_services')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_pack_service', $data);
		echo view('template/footer');
	}

	public function view_pack_service()
	{
		$id = $this->request->uri->getSegment(3);
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['data'] = $this->db->table('temple_services')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_pack_service', $data);
		echo view('template/footer');
	}

	public function save_temple_service()
	{
		$data['name'] = $_POST['name'];
		$data['description'] = $_POST['description'];
		$data['service_type'] = $_POST['service_type'];
		$data['service_mode'] = $_POST['service_mode'];
		$data['add_on'] = !empty($_POST['add_on']) ? $_POST['add_on'] : 0;
		$data['is_virtual'] = !empty($_POST['is_virtual']) ? $_POST['is_virtual'] : 0;
		$data['amount'] = $_POST['amount'];
		$data['ledger_id'] = $_POST['ledger_id'];
		$data['status'] = $_POST['status'];
		$data['created_by'] = $this->session->get('log_id');
		$data['modified_by'] = $this->session->get('log_id');

		if (empty($_POST['id'])) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['modified_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('temple_services')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Added Successfully');
				header("Location: " . base_url() . "/master/pack_service");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/pack_service");
			}
		} else {
			$id = $_POST['id'];
			$data['modified_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('temple_services')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Update Successfully');
				header("Location: " . base_url() . "/master/pack_service");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/pack_service");
			}
		}
		exit;
	}

	public function package()
	{
		$data = array();
		$data['list'] = $this->db->table("temple_packages")->select('*')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/package', $data);
		echo view('template/footer');
	}

	public function add_package()
	{
		$data = array();
		$data['service'] = array();
		$data['service_list'] = $this->db->table('temple_package_services')
			->join('temple_services', 'temple_package_services.service_id = temple_services.id', 'left')
			->select('temple_package_services.*')->select('temple_services.*')
			->where('temple_package_services.package_id', $id)
			->get()->getResultArray();
		$data['addon_service_list'] = $this->db->table('temple_package_addons')
			->join('temple_services', 'temple_package_addons.service_id = temple_services.id', 'left')
			->select('temple_package_addons.*')->select('temple_services.*')
			->where('temple_package_addons.package_id', $id)
			->get()->getResultArray();
		$data['venues'] = $this->db->table('venue')->select('id, name')->where('status', 1)->get()->getResultArray();
		$data['staff_list'] = $this->db->table('staff')->select('id, name')->get()->getResultArray();
		$data['slot_details'] = $this->db->table('booking_slot_type_new')
			->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
			->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
			->get()->getResultArray();
		$selected_venue_query = $this->db->table('temple_package_venues')
			->select('venue_id')
			->where('package_id', $id)
			->get();
		$data['selected_venues'] = array_column($selected_venue_query->getResultArray(), 'venue_id');
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$three_level_group_deposit = get_three_level_in_group($code = array("2000", "3000"));
		$data['deposit_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group_deposit)->orderBy('right_code', 'asc')->get()->getResultArray();
		// var_dump($data['staff_list']);
		// exit;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_package', $data);
		echo view('template/footer');
	}

	public function edit_package()
	{
		$id = $this->request->uri->getSegment(3);
		$data['service_list'] = $this->db->table('temple_package_services')
			->join('temple_services', 'temple_package_services.service_id = temple_services.id', 'left')
			->select('temple_package_services.*')->select('temple_services.*')
			->where('temple_package_services.package_id', $id)
			->get()->getResultArray();

		$data['addon_service_list'] = $this->db->table('temple_package_addons')
			->join('temple_services', 'temple_package_addons.service_id = temple_services.id', 'left')
			->select('temple_package_addons.*')->select('temple_services.*')
			->where('temple_package_addons.package_id', $id)
			->get()->getResultArray();
		$data['data'] = $temple_packages = $this->db->table('temple_packages')->where('id', $id)->get()->getRowArray();
		$data['service'] = $this->db->table("temple_services")->where('service_type', $temple_packages['package_type'])->where('status', 1)->get()->getResultArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$three_level_group_deposit = get_three_level_in_group($code = array("2000", "3000"));
		$data['deposit_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group_deposit)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['venues'] = $this->db->table('venue')->select('id, name')->get()->getResultArray();
		$data['staff_commission_list'] = $this->db->table('staff_commission')
			->join('staff', 'staff_commission.staff_id = staff.id', 'left')
			->select('staff_commission.amount, staff_commission.staff_id, staff.name as staff_name')
			->where('staff_commission.package_id', $id)
			->get()->getResultArray();
		$data['staff_list'] = $this->db->table('staff')->select('id, name')->get()->getResultArray();
		$data['slot_details'] = $this->db->table('booking_slot_type_new')
			->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
			->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
			->get()->getResultArray();
		$selected_slots_query = $this->db->table('temple_package_slots')
			->select('slot_id')
			->where('package_id', $id)
			->get();
		$data['selected_slots'] = array_column($selected_slots_query->getResultArray(), 'slot_id');
		$selected_venue_query = $this->db->table('temple_package_venues')
			->select('venue_id')
			->where('package_id', $id)
			->get();
		$data['selected_venues'] = array_column($selected_venue_query->getResultArray(), 'venue_id');
		$data['pack_dates'] = $this->db->table('temple_package_date')
										->select('temple_package_date.pack_date')
										->where('temple_package_date.package_id', $id)
										->get()->getResultArray();
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_package', $data);
		echo view('template/footer');
	}

	public function view_package()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('temple_packages')->where('id', $id)->get()->getRowArray();
		$data['service'] = $this->db->table("temple_packages")->select('*')->get()->getResultArray();
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();
		$three_level_group_deposit = get_three_level_in_group($code = array("2000", "3000"));
		$data['deposit_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group_deposit)->orderBy('right_code', 'asc')->get()->getResultArray();
		$data['service_list'] = $this->db->table('temple_package_services')
			->join('temple_services', 'temple_package_services.service_id = temple_services.id', 'left')
			->select('temple_package_services.*')->select('temple_services.*')
			->where('temple_package_services.package_id', $id)
			->get()->getResultArray();

		$data['addon_service_list'] = $this->db->table('temple_package_addons')
			->join('temple_services', 'temple_package_addons.service_id = temple_services.id', 'left')
			->select('temple_package_addons.*')->select('temple_services.*')
			->where('temple_package_addons.package_id', $id)
			->get()->getResultArray();

		$data['staff_commission_list'] = $this->db->table('staff_commission')
			->join('staff', 'staff_commission.staff_id = staff.id', 'left')
			->select('staff_commission.amount, staff_commission.staff_id, staff.name as staff_name')
			->where('staff_commission.package_id', $id)
			->get()->getResultArray();
		$data['venues'] = $this->db->table('venue')->select('id, name')->get()->getResultArray();

		$data['staff_list'] = $this->db->table('staff')->select('id, name')->get()->getResultArray();
		$data['slot_details'] = $this->db->table('booking_slot_type_new')
			->select('booking_slot_type_new.slot_type, booking_slot_new.slot_name, booking_slot_type_new.booking_slot_id')
			->join('booking_slot_new', 'booking_slot_new.id = booking_slot_type_new.booking_slot_id', 'left')
			->get()->getResultArray();
		$selected_slots_query = $this->db->table('temple_package_slots')
			->select('slot_id')
			->where('package_id', $id)
			->get();
		$selected_venue_query = $this->db->table('temple_package_venues')
			->select('venue_id')
			->where('package_id', $id)
			->get();
		$data['selected_venues'] = array_column($selected_venue_query->getResultArray(), 'venue_id');
		$data['pack_dates'] = $this->db->table('temple_package_date')
							->select('temple_package_date.pack_date')
							->where('temple_package_date.package_id', $id)
							->get()->getResultArray();
		$data['selected_slots'] = array_column($selected_slots_query->getResultArray(), 'slot_id');
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_package', $data);
		echo view('template/footer');
	}

	public function save_package()
	{
		if (!empty($_POST['services']) && !empty($_POST['name']) && !empty($_POST['package_type']) && !empty($_POST['package_mode']) && !empty($_POST['ledger_id']) && !empty($_POST['amount']) && !empty($_POST['status'])) {
			// var_dump($_post);
			// exit;
			$data['name'] = $_POST['name'];
			$data['description'] = $_POST['description'];
			$data['package_type'] = $_POST['package_type'];
			if (!empty($_POST['package_mode']))
				$data['package_mode'] = $_POST['package_mode'];
			if (!empty($_POST['ledger_id']))
				$data['ledger_id'] = $_POST['ledger_id'];
			if (!empty($_POST['deposit_ledger_id']))
				$data['deposit_ledger_id'] = $_POST['deposit_ledger_id'];
			// if(!empty($_POST['pack_date'])) $data['pack_date'] = $_POST['pack_date'];
			$data['amount'] = $_POST['amount'];
			$data['deposit_amount'] = !empty($_POST['deposit_amount']) ? $_POST['deposit_amount'] : 0;
			$data['advance_amount'] = !empty($_POST['advance_amount']) ? $_POST['advance_amount'] : 0;
			//$data['commission_amount'] = $_POST['commission_amount'];
			$data['status'] = $_POST['status'];
			if (!empty($_FILES['package_image']['name']) > 0) {
				//echo $_FILES['package_image']['name'];
				$name = time() . '_' . $_FILES['package_image']['name'];
				$target_dir = "uploads/package/";
				move_uploaded_file($_FILES['package_image']['tmp_name'], $target_dir . $name);
				$data['image'] = $name;
			}

			if (!empty($_FILES['package_pdf']['name'])) {
				// Handle PDF upload
				$pdf_name = time() . '_' . $_FILES['package_pdf']['name'];
				$target_dir_pdf = "uploads/package_pdf/";
				move_uploaded_file($_FILES['package_pdf']['tmp_name'], $target_dir_pdf . $pdf_name);
				$data['pdf_name'] = $pdf_name;  // Save the PDF file name in the `pdf_name` field
			}


			$data['created_by'] = $this->session->get('log_id');
			$data['modified_by'] = $this->session->get('log_id');
			if (empty($_POST['id'])) {
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['modified_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('temple_packages')->insert($data);
				$insid = $this->db->insertID();
			} else {
				$id = $_POST['id'];
				$data['modified_at'] = date('Y-m-d H:i:s');
				$builder = $this->db->table('temple_packages')->where('id', $id)->update($data);
				$insid = $id;
			}
			if ($builder) {
				$this->db->table('temple_package_services')->delete(['package_id' => $insid]);
				foreach ($_POST['services'] as $row) {
					$sdata = array();
					$sdata['package_id'] = $insid;
					$sdata['service_id'] = $row['service_id'];
					$sdata['quantity'] = $row['quantity'];
					$builder1 = $this->db->table('temple_package_services')->insert($sdata);
					// if ($builder1) {
					// 	$this->session->setFlashdata('succ', 'Added Successfully');
					// 	header("Location: " . base_url() . "/master/package");
					// } else {
					// 	$this->session->setFlashdata('fail', 'Please Try Again');
					// 	header("Location: " . base_url() . "/master/package");
					// }
				}

				$this->db->table('temple_package_addons')->delete(['package_id' => $insid]);
				if (!empty($_POST['addon_services'])) {
					foreach ($_POST['addon_services'] as $arow) {
						$adata = array();
						$temple_services = $this->db->table("temple_services")->where('id', $arow['service_id'])->get()->getRowArray();
						$adata['amount'] = $temple_services['amount'];

						$adata['package_id'] = $insid;
						$adata['service_id'] = $arow['service_id'];
						$adata['quantity'] = $arow['quantity'];
						$builder2 = $this->db->table('temple_package_addons')->insert($adata);
					}
				}

				$this->db->table('temple_package_date')->delete(['package_id' => $insid]);
				if (isset($_POST['pack_date']) && is_array($_POST['pack_date']) && count($_POST['pack_date']) > 0) {
					foreach($_POST['pack_date'] as $brow) {
						if ($brow !== '' && $brow !== null) { 
							$bdata = array();
							$bdata['package_id'] = $insid;
							$bdata['pack_date'] = $brow;
							$bdata['package_type'] = $_POST['package_type'];
							$builder3 = $this->db->table('temple_package_date')->insert($bdata);
						}
					}
				}

				$this->db->table('staff_commission')->delete(['package_id' => $insid]);
				if (!empty($_POST['staff_commissions'])) {

					foreach ($_POST['staff_commissions'] as $commission) {
						if (!empty($commission['staff_id']) && isset($commission['amount'])) {
							$commissionData = [
								'package_id' => $insid,
								'staff_id' => $commission['staff_id'],
								'amount' => $commission['amount'],
								'created_at' => date('Y-m-d H:i:s'),
								'modified_at' => date('Y-m-d H:i:s')
							];
							$this->db->table('staff_commission')->insert($commissionData);
						}
					}
				}

				$selected_slots = $_POST['slot_selection'];
				$this->db->table('temple_package_slots')->delete(['package_id' => $insid]);
				if (!empty($selected_slots)) {
					foreach ($selected_slots as $slot_id) {
						if ($slot_id != "0") {
							$SlotDatas = [
								'package_id' => $insid,
								'slot_id' => $slot_id
							];
							$this->db->table('temple_package_slots')->insert($SlotDatas);
						}
					}
				}

				$selected_venues = $_POST['venue_selection'];
				$this->db->table('temple_package_venues')->delete(['package_id' => $insid]);
				if (!empty($selected_venues)) {
					foreach ($selected_venues as $venue) {
						if ($venue != "0") {
							$VenueData = [
								'package_id' => $insid,
								'venue_id' => $venue
							];
							$this->db->table('temple_package_venues')->insert($VenueData);
						}
					}
				}

				// Handling multiple staff commissions
				// if (!empty($_POST['staff_id']) && is_array($_POST['staff_id'])) {
				// 	$staffIds = $_POST['staff_id'];
				// 	$commissionAmounts = $_POST['commission_amount'];
				// 	foreach ($staffIds as $index => $staffId) {
				// 		if (!empty($staffId) && isset($commissionAmounts[$index])) {
				// 			$commissionData = [
				// 				'package_id' => $insid,
				// 				'staff_id' => $staffId,
				// 				'amount' => $commissionAmounts[$index],
				// 				'created_at' => date('Y-m-d H:i:s'),
				// 				'modified_at' => date('Y-m-d H:i:s')
				// 			];
				// 			$this->db->table('staff_commission')->insert($commissionData);
				// 		}
				// 	}
				// }

				if ($builder1) {
					$this->session->setFlashdata('succ', 'Added Successfully');
					header("Location: " . base_url() . "/master/package");
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
					header("Location: " . base_url() . "/master/package");
				}

			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/master/package");
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill all required fields');
			if (!empty($_POST['id']))
				header("Location: " . base_url() . "/master/edit_package/" . $_POST['id']);
			else
				header("Location: " . base_url() . "/master/package");
		}
		exit;
	}

	public function validation()
	{
		$data = array();
		if (empty($_POST['name'])) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
		exit;
	}


	public function validation1()
	{
		$data = array();
		if (empty($_POST['slot_name'])) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
		exit;
	}


	public function validation2()
	{
		$data = [
			'err' => '',
			'succ' => ''
		];
		if (empty($_POST['name'])) {
			$data['err'] = "Please Fill Name Fields";
		} else if (empty($_POST['service_type'])) {
			$data['err'] = "Please Select Service Type";
		} else if (empty($_POST['status'])) {
			$data['err'] = "Please Select Status";
		} else if (isset($_POST['add_on']) && $_POST['add_on'] == '1' && (!isset($_POST['amount']) || !is_numeric($_POST['amount']) || $_POST['amount'] <= 0)) {
			$data['err'] = "Please Fill Amount for Addon";
		} else if (isset($_POST['add_on']) && $_POST['add_on'] == '1' && (empty($_POST['ledger_id']))) {
			$data['err'] = "Please Select Ledger";
		} else {
			$data['succ'] = "Form validate";
		}
		echo json_encode($data);
		exit;
	}

	public function validation_venue()
	{
		$data = array();
		if (empty($_POST['name'])) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
		exit;
	}


	public function get_service()
	{
		$data['row'] = array();
		if (!empty($_POST['id'])) {
			$id = $_POST['id'];

			$data['row'] = $this->db->table('temple_services')->where('service_type', $id)->where('status', 1)->where('add_on', 0)->get()->getResultArray();
			$data['addon_row'] = $this->db->table('temple_services')->where('service_type', $id)->where('status', 1)->where('add_on', 1)->get()->getResultArray();
			//$data = $this->db->getLastQuery();

			//echo $data; die();
			//$data = array("id"=>$row['id'], "name"=>$row['name']);
			//print_r($data);
			//echo 'test';
		}
		echo json_encode($data);
		exit;
	}

	public function courier()
	{
		$data = array();

		// Load the database and get the list of courier charges
		$data['list'] = $this->db->table("courier_charges")->select('*')->get()->getResultArray();

		// Load the views
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/courier', $data);
		echo view('template/footer');
	}

	public function add_courier_charge()
	{
		$data = array();

		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code', 'asc')->get()->getResultArray();

		// Get the list of states from the states table
		$data['states'] = $this->db->table("states")->select('*')->get()->getResultArray();

		// Load the add courier view
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_courier', $data);
		echo view('template/footer');
	}
	public function save_courier_charge()
	{
		// Retrieve POST data
		$data['state_code'] = $_POST['state_code'];
		$data['state_name'] = $_POST['state_name'];
		$data['amount'] = $_POST['amount'];

		if (!empty($_POST['ledger_id'])) {
			$data['ledger_id'] = $_POST['ledger_id'];
		}

		// Check if it's an update or insert operation
		if (empty($_POST['id'])) {
			// Insert operation
			$data['created_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('courier_charges')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Added Successfully');
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
			}
		} else {
			// Update operation
			$id = $_POST['id'];
			$builder = $this->db->table('courier_charges')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Updated Successfully');
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
			}
		}

		// Redirect back to the courier master page
		header("Location: " . base_url() . "/master/courier");
		exit;
	}



	public function view_courier_charge($id)
	{
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")
			->select('id,name,code,left_code,right_code')
			->whereIn('group_id', $three_level_group)
			->orderBy('right_code', 'asc')
			->get()->getResultArray();

		$data['courier_charge'] = $this->db->table('courier_charges')
			->where('id', $id)
			->get()
			->getRowArray();

		$data['states'] = $this->db->table('states')
			->select('*')
			->get()
			->getResultArray();

		// Load the view and pass the data
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_courier', $data);
		echo view('template/footer');
	}

	public function edit_courier_charge($id)
	{
		$three_level_group = get_three_level_in_group($code = array("4000", "8000"));
		$data['ledgers'] = $this->db->table("ledgers")
			->select('id,name,code,left_code,right_code')
			->whereIn('group_id', $three_level_group)
			->orderBy('right_code', 'asc')
			->get()
			->getResultArray();

		$data['courier_charge'] = $this->db->table('courier_charges')
			->where('id', $id)
			->get()
			->getRowArray();

		$data['states'] = $this->db->table('states')
			->select('*')
			->get()
			->getResultArray();

		// Load the view and pass the data
		echo view('template/header');
		echo view('template/sidebar');
		echo view('master/add_courier', $data);
		echo view('template/footer');
	}


	public function delete_courier_charge()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('courier_charge')->delete(['id' => $id]);

		if ($res) {
			$this->session->setFlashdata('succ', 'Courier charge deleted successfully');
		} else {
			$this->session->setFlashdata('fail', 'Please try again');
		}

		return redirect()->to(base_url('/master/courier'));
	}


	public function validation3()
	{
		$name = trim($_POST['state_name']);
		$code = trim($_POST['state_code']);
		$amount = trim($_POST['amount']);
		//  $ledger_id = trim($_POST['ledger_id']);
		$data = array();
		if (empty($name) || empty($code) || empty($amount)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}
}