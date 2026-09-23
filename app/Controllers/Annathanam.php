<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Annathanam extends BaseController
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
		if (!$this->model->list_validate('annathanam')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['list'] = $this->db->table('annathanam')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/index', $data);
		echo view('template/footer');
	}
	public function add_annathanam()
	{
		if (!$this->model->permission_validate('annathanam', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['annathanam_rice_category'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['annathanam_kuruma_type'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['annathanam_rice_type'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		$data['annathanam_vegetables'] = $this->db->query("SELECT * FROM annathanam_vegetables  order by name_eng asc")->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$yr = date('Y');
		$mon = date('m');
		$query = $this->db->query("SELECT ref_no FROM annathanam where id=(select max(id) from annathanam where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['bill_no'] = 'AT' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['a_vegetables'] = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_annathanam', $data);
		echo view('template/footer');
	}
	public function edit_annathanam()
	{
		if (!$this->model->permission_validate('annathanam', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam')->where('id', $id)->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['annathanam_rice_category'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['annathanam_kuruma_type'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['annathanam_rice_type'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		$data['annathanam_vegetables'] = $this->db->query("SELECT * FROM annathanam_vegetables  order by name_eng asc")->getResultArray();
		$annathanam_items = $this->db->table('annathanam_item')->where('annathanam_id', $id)->get()->getResultArray();
		$getkuruma = $this->db->table('annathanam_kuruma_type')->where('id', $data['data']['kuruma_id'])->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['edit'] = true;
		if (count($getkuruma) > 0) {
			$kuruma_count_id = $getkuruma[0]['count'];
		} else {
			$kuruma_count_id = 0;
		}
		$data['kuruma_count_id'] = $kuruma_count_id;
		$array_ai = array();
		foreach ($annathanam_items as $annathanam_item) {
			$array_ai[] = $annathanam_item['vegetable_id'];
		}
		$data['a_vegetables'] = $array_ai;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_annathanam', $data);
		echo view('template/footer');
	}
	public function view_annathanam()
	{
		if (!$this->model->permission_validate('annathanam', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam')->where('id', $id)->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['annathanam_rice_category'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['annathanam_kuruma_type'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['annathanam_rice_type'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		$data['annathanam_vegetables'] = $this->db->query("SELECT * FROM annathanam_vegetables  order by name_eng asc")->getResultArray();
		$annathanam_items = $this->db->table('annathanam_item')->where('annathanam_id', $id)->get()->getResultArray();
		$getkuruma = $this->db->table('annathanam_kuruma_type')->where('id', $data['data']['kuruma_id'])->get()->getResultArray();
		if (count($getkuruma) > 0) {
			$kuruma_count_id = $getkuruma[0]['count'];
		} else {
			$kuruma_count_id = 0;
		}
		$data['kuruma_count_id'] = $kuruma_count_id;
		$data['view'] = true;
		$data['edit'] = true;
		$array_ai = array();
		foreach ($annathanam_items as $annathanam_item) {
			$array_ai[] = $annathanam_item['vegetable_id'];
		}
		$data['a_vegetables'] = $array_ai;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_annathanam', $data);
		echo view('template/footer');
	}
	public function print_annathanam()
	{
		if (!$this->model->permission_validate('annathanam', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam')->where('id', $id)->get()->getRowArray();
		$data['annathanam_items'] = $this->db->table('annathanam_item')
			->join('annathanam_vegetables', 'annathanam_vegetables.id = annathanam_item.vegetable_id')
			->select('annathanam_vegetables.name_eng,annathanam_vegetables.name_tamil')
			->where('annathanam_item.annathanam_id', $id)
			->get()
			->getResultArray();
		echo view('annathanam/print_annathanam', $data);
	}
	public function getriceAmount()
	{
		$rice_cat = !empty($_POST['rice_cat']) ? $_POST['rice_cat'] : 0;
		$kurm_id = !empty($_POST['kurm_id']) ? $_POST['kurm_id'] : 0;
		$ricetype_id = !empty($_POST['ricetype_id']) ? $_POST['ricetype_id'] : 0;
		$getamount = $this->db->table('annathanam_setting')
			->where('rice_category_id', $rice_cat)
			->where('kuruma_id', $kurm_id)
			->where('rice_type_id', $ricetype_id)
			->get()->getResultArray();
		if (count($getamount) > 0) {
			$amt = $getamount[0]['amount'];
		} else {
			$amt = "0.00";
		}
		return $amt;
	}
	public function getkurumaCount()
	{
		$kurm_id = !empty($_POST['kurm_id']) ? $_POST['kurm_id'] : 0;
		$getkuruma = $this->db->table('annathanam_kuruma_type')
			->where('id', $kurm_id)
			->get()->getResultArray();
		if (count($getkuruma) > 0) {
			$count = $getkuruma[0]['count'];
		} else {
			$count = 0;
		}
		return $count;
	}
	public function save_annathanam()
	{
		$id = $_POST['id'];
		$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();


		//ip location and ip details
		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$data['ip'] = $ip;
			$data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$data['ip_details'] = json_encode($ip_details);
		}

		if (empty($id)) {
			$yr = date('Y', strtotime($_POST['date']));
			$mon = date('m', strtotime($_POST['date']));
			$query = $this->db->query("SELECT ref_no FROM annathanam where id=(select max(id) from annathanam where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
			$data['ref_no'] = 'AT' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
			$data['date'] = date('Y-m-d', strtotime($_POST['date']));
			$data['name'] = $_POST['name'];

			if(empty($_POST['edit_status'])){
				$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
				$mble_number = !empty($_POST['phone_no'])?$_POST['phone_no']:"";
				$data['phone_no']  = $mble_phonecode.$mble_number;
			}
			else{
				$data['phone_no'] = $_POST['phone_no'];
			}

			$data['slot_time'] = $_POST['time'];
			$data['rice_category_id'] = $_POST['rice_category'];
			$data['kuruma_id'] = $_POST['kuruma_id'];
			$data['rice_type_id'] = $_POST['rice_type_id'];
			$data['amount'] = $_POST['amount'];
			$data['no_of_pax'] = $_POST['no_of_pax'];
			$data['total_amount'] = $_POST['total_amount'];
			$data['payment_mode'] = $_POST['payment_mode'];
			$data['added_by'] = $this->session->get('log_id');
			$data['created'] = date('Y-m-d H:i:s');
			$res = $this->db->table('annathanam')->insert($data);
			$annathanam_id = $this->db->insertID();
			if (!empty($_POST['vegetables'])) {
				foreach ($_POST['vegetables'] as $vegetable) {
					$data_vegetable['annathanam_id'] = $annathanam_id;
					$data_vegetable['vegetable_id'] = $vegetable['vegetble_id'];
					$this->db->table('annathanam_item')->insert($data_vegetable);
				}
			}
			$this->account_migration($annathanam_id);
		} else {
			$data['name'] = $_POST['name'];
			$data['phone_no'] = $_POST['phone_no'];
			$data['slot_time'] = $_POST['time'];
			$data['modified'] = date('Y-m-d H:i:s');
			$this->db->table('annathanam_item')->where("annathanam_id", $id)->delete();
			if (!empty($_POST['vegetables'])) {
				foreach ($_POST['vegetables'] as $vegetable) {
					$data_vegetable['annathanam_id'] = $id;
					$data_vegetable['vegetable_id'] = $vegetable['vegetble_id'];
					$this->db->table('annathanam_item')->insert($data_vegetable);
				}
			}
			$res = $this->db->table('annathanam')->where("id", $id)->update($data);
		}
		if ($res) {
			$this->session->setFlashdata('succ', 'Annathanam added Successfully');
			header("Location: " . base_url() . "/annathanam");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/annathanam");
		}
	}
	public function account_migration($annathanam_id)
	{
		$annathanam = $this->db->table('annathanam')->where('id', $annathanam_id)->get()->getRowArray();
		if ($annathanam['paid_through'] == 'DIRECT') {
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $annathanam['payment_mode'])->get()->getRowArray();
			if (empty($payment_mode_details['id']))
				$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$ledger = $this->db->table('ledgers')->where('name', 'Annadhanam Fee')->where('group_id', 29)->where('left_code', '7112')->get()->getRowArray();
			if (!empty($ledger)) {
				$dr_id = $ledger['id'];
			} else {
				$led['group_id'] = 29;
				$led['name'] = 'Annadhanam Fee';
				$led['left_code'] = '7112';
				$led['right_code'] = '000';
				$led['op_balance'] = '0';
				$led['op_balance_dc'] = 'D';
				$led_ins = $this->db->table('ledgers')->insert($led);
				$dr_id = $this->db->insertID();
			}
			$cr_id = $payment_mode_details['ledger_id'];
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$date = explode('-', date("Y-m-d", strtotime($annathanam['date'])));
			$yr = $annathanam['date'];
			$mon = $annathanam['date'];
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'REC' . date('y', strtotime($annathanam['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = date("Y-m-d", strtotime($annathanam['date']));
			$entries['dr_total'] = $annathanam['total_amount'];
			$entries['cr_total'] = $annathanam['total_amount'];
			$entries['narration'] = 'Annadhanam(' . $annathanam['ref_no'] . ')' . "\n" . 'name:' . $annathanam['name'] . "\n" . 'Phone:' . $annathanam['phone_no'] . "\n";
			$entries['inv_id'] = $annathanam_id;
			$entries['type'] = '12';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty($en_id)) {
				$ent_id[] = $en_id;
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $annathanam['total_amount'];
				$eitems_d['details'] = 'Annadhanam(' . $annathanam['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$cr_res = $this->db->table('entryitems')->insert($eitems_d);
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = $annathanam['total_amount'];
				$eitems_c['details'] = 'Annadhanam(' . $annathanam['ref_no'] . ')';
				$eitems_c['dc'] = 'D';
				$deb_res = $this->db->table('entryitems')->insert($eitems_c);
				if ($cr_res && $deb_res)
					$succ++;
				else
					$err++;
			}
		}
	}
	public function vegetables()
	{
		if (!$this->model->list_validate('annathanam_vegetable_setting')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('annathanam_vegetable_setting');
		$data['list'] = $this->db->table('annathanam_vegetables')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/vegetable', $data);
		echo view('template/footer');
	}
	public function add_vegetable()
	{
		if (!$this->model->permission_validate('annathanam_vegetable_setting', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_vegetable');
		echo view('template/footer');
	}

	public function edit()
	{
		if (!$this->model->permission_validate('annathanam_vegetable_setting', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_vegetables')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_vegetable', $data);
		echo view('template/footer');
	}

	public function view()
	{
		if (!$this->model->permission_validate('annathanam_vegetable_setting', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_vegetables')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_vegetable', $data);
		echo view('template/footer');
	}

	public function save_vegetable()
	{
		$id = $_POST['id'];
		$data['name_eng'] = trim($_POST['name_eng']);
		$data['name_tamil'] = trim($_POST['name_tamil']);
		$data['added_by'] = $this->session->get('log_id');
		if (empty($id)) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('annathanam_vegetables')->insert($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Vegetable Added Successfully');
				header("Location: " . base_url() . "/annathanam/vegetables");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/annathanam/vegetables");
			}
		} else {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('annathanam_vegetables')->where('id', $id)->update($data);
			if ($builder) {
				$this->session->setFlashdata('succ', 'Vegetable Update Successfully');
				header("Location: " . base_url() . "/annathanam/vegetables");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/annathanam/vegetables");
			}
		}
	}
	public function delete()
	{
		if (!$this->model->permission_validate('annathanam_vegetable_setting', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('annathanam_vegetables')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Vegetable Delete Successfully');
			header("Location: " . base_url() . "/annathanam/vegetables");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/annathanam/vegetables");
		}
	}
	public function del_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("prasadam")->where("prasadam_setting_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function vegetable_setting_validation()
	{
		$name_eng = trim($_POST['name_eng']);
		$name_tamil = trim($_POST['name_tamil']);
		$data = array();
		if (empty($name_eng) || empty($name_tamil)) {
			$data['err'] = "Please Fill Required Fields";
			$data['succ'] = '';
		} else {
			$data['succ'] = "Form validate";
			$data['err'] = '';
		}
		echo json_encode($data);
	}

	public function rice_category()
	{
		$data['list'] = $this->db->table('annathanam_rice_category')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/rice_category', $data);
		echo view('template/footer');
	}
	public function save_rice_category()
	{
		$id = $_POST['id'];
		$data['name_eng'] = trim($_POST['name_eng']);
		$data['name_tamil'] = trim($_POST['name_tamil']);
		if ($data['name_eng']) {
			if (empty($id)) {
				$builder = $this->db->table('annathanam_rice_category')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Rice Category Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$builder = $this->db->table('annathanam_rice_category')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Rice Category Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill Category');
		}
		header("Location: " . base_url() . "/annathanam/rice_category");
	}
	public function add_rice_category()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_rice_category');
		echo view('template/footer');
	}
	public function edit_rice_category()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_rice_category')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_rice_category', $data);
		echo view('template/footer');
	}

	public function view_rice_category()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_rice_category')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_rice_category', $data);
		echo view('template/footer');
	}
	public function del_check_rice_category()
	{
		$id = $_POST['id'];
		$res = $this->db->table("annathanam")->where("rice_category_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_rice_category()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('annathanam_rice_category')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Rice Category Delete Successfully');
			header("Location: " . base_url() . "/annathanam/rice_category");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/annathanam/rice_category");
		}
	}
	public function kuruma_type()
	{
		$data['list'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/kuruma_type', $data);
		echo view('template/footer');
	}
	public function save_kuruma_type()
	{
		$id = $_POST['id'];
		$data['name_eng'] = trim($_POST['name_eng']);
		$data['name_tamil'] = trim($_POST['name_tamil']);
		$data['count'] = $_POST['count'];
		if ($data['name_eng']) {
			if (empty($id)) {
				$builder = $this->db->table('annathanam_kuruma_type')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Kuruma Type Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$builder = $this->db->table('annathanam_kuruma_type')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Kuruma Type Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill Type');
		}
		header("Location: " . base_url() . "/annathanam/kuruma_type");
	}
	public function add_kuruma_type()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_kuruma_type');
		echo view('template/footer');
	}
	public function edit_kuruma_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_kuruma_type')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_kuruma_type', $data);
		echo view('template/footer');
	}
	public function view_kuruma_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_kuruma_type')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_kuruma_type', $data);
		echo view('template/footer');
	}
	public function del_check_kuruma_type()
	{
		$id = $_POST['id'];
		$res = $this->db->table("annathanam")->where("kuruma_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_kuruma_type()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('annathanam_kuruma_type')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Kuruma Type Delete Successfully');
			header("Location: " . base_url() . "/annathanam/kuruma_type");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/annathanam/kuruma_type");
		}
	}
	public function rice_type()
	{
		$data['list'] = $this->db->table('annathanam_rice_type')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/rice_type', $data);
		echo view('template/footer');
	}
	public function save_rice_type()
	{
		$id = $_POST['id'];
		$data['name'] = trim($_POST['name']);
		if ($data['name']) {
			if (empty($id)) {
				$builder = $this->db->table('annathanam_rice_type')->insert($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Rice Type Added Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			} else {
				$builder = $this->db->table('annathanam_rice_type')->where('id', $id)->update($data);
				if ($builder) {
					$this->session->setFlashdata('succ', 'Rice Type Update Successfully');
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Fill Type');
		}
		header("Location: " . base_url() . "/annathanam/rice_type");
	}
	public function add_rice_type()
	{
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_rice_type');
		echo view('template/footer');
	}
	public function edit_rice_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_rice_type')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_rice_type', $data);
		echo view('template/footer');
	}
	public function view_rice_type()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_rice_type')->where('id', $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_rice_type', $data);
		echo view('template/footer');
	}
	public function del_check_rice_type()
	{
		$id = $_POST['id'];
		$res = $this->db->table("annathanam")->where("rice_type_id", $id)->get()->getResultArray();
		echo count($res);
	}
	public function delete_rice_type()
	{
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('annathanam_rice_type')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Rice Type Delete Successfully');
			header("Location: " . base_url() . "/annathanam/rice_type");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/annathanam/rice_type");
		}
	}
	public function setting()
	{
		$data['list'] = $this->db->table('annathanam_setting as s')
			->join('annathanam_rice_category as rc', 'rc.id = s.rice_category_id')
			->join('annathanam_kuruma_type as kt', 'kt.id = s.kuruma_id')
			->join('annathanam_rice_type as rt', 'rt.id = s.rice_type_id')
			->select('rc.name_eng as rc_name_eng,rc.name_tamil as rc_name_tamil,kt.name_eng as kt_name_eng,kt.name_tamil as kt_name_tamil,rt.name as rt_name,s.amount as s_amount,s.id')
			->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/setting', $data);
		echo view('template/footer');
	}
	public function add_setting()
	{
		$data['rice_categories'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['kuruma_types'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['rice_types'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_setting', $data);
		echo view('template/footer');
	}
	public function edit_setting()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_setting')->where('id', $id)->get()->getRowArray();
		$data['rice_categories'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['kuruma_types'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['rice_types'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_setting', $data);
		echo view('template/footer');
	}
	public function view_setting()
	{
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('annathanam_setting')->where('id', $id)->get()->getRowArray();
		$data['rice_categories'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['kuruma_types'] = $this->db->table('annathanam_kuruma_type')->get()->getResultArray();
		$data['rice_types'] = $this->db->table('annathanam_rice_type')->where('status', 1)->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('annathanam/add_setting', $data);
		echo view('template/footer');
	}
	public function save_setting()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$id = $_POST['id'];
		$data['rice_category_id'] = $_POST['rice_category_id'];
		$data['kuruma_id'] = $_POST['kuruma_id'];
		$data['rice_type_id'] = $_POST['rice_type_id'];
		$data['amount'] = $_POST['amount'];
		if (empty($data['rice_category_id'])) {
			$msg_data['err'] = 'Please choose rice category.';
		} else if (empty($data['kuruma_id'])) {
			$msg_data['err'] = 'Please choose kuruma type.';
		} else if (empty($data['rice_type_id'])) {
			$msg_data['err'] = 'Please choose rice type.';
		} else if (empty($data['amount'])) {
			$msg_data['err'] = 'Please enter the amount.';
		} else {
			$res_rc_k_rt = $this->db->table("annathanam_setting")
				->where("rice_category_id", $data['rice_category_id'])
				->where("kuruma_id", $data['kuruma_id'])
				->where("rice_type_id", $data['rice_type_id'])
				->where("id !=", $id)
				->get()->getResultArray();
			if (count($res_rc_k_rt) > 0) {
				$msg_data['err'] = 'Already choosed this annathanam setting.';
			} else {
				if (empty($id)) {
					$builder = $this->db->table('annathanam_setting')->insert($data);
					if ($builder) {
						$msg_data['succ'] = 'Annathanam Setting Added Successfully';
					} else {
						$msg_data['err'] = 'Please Try Again';
					}
				} else {
					$builder = $this->db->table('annathanam_setting')->where('id', $id)->update($data);
					if ($builder) {
						$msg_data['succ'] = 'Annathanam Setting Updated Successfully';
					} else {
						$msg_data['err'] = 'Please Try Again';
					}
				}
			}
		}
		echo json_encode($msg_data);
		exit();
	}









}
