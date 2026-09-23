<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Marriage extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		$data['list'] = $this->db->table('marriage_registration')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('marriage/index', $data);
		echo view('template/footer');
	}

	public function add()
	{
		$data['payment_modes'] = $this->db->table('payment_mode')->where('paid_through', 'DIRECT')->where('status', 1)->get()->getResultArray();
		$data['mrg_documents'] = $this->db->table('marriage_documents')->where("mid", $id)->get()->getResultArray();
		$data['payment'] = $this->db->table('marriage_pay_details')->where("mid", $id)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('marriage/add', $data);
		echo view('template/footer');
	}

	public function edit($id)
	{
		$data['marriage'] = $this->db->table('marriage_registration')->where("id", $id)->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('paid_through', 'DIRECT')->where('status', 1)->get()->getResultArray();
		$data['mrg_documents'] = $this->db->table('marriage_documents')->where("mid", $id)->get()->getResultArray();
		$data['payment'] = $this->db->table('marriage_pay_details')->where("mid", $id)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('marriage/add', $data);
		echo view('template/footer');
	}

	public function view($id)
	{
		$data['marriage'] = $this->db->table('marriage_registration')->where("id", $id)->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('paid_through', 'DIRECT')->where('status', 1)->get()->getResultArray();
		$data['mrg_documents'] = $this->db->table('marriage_documents')->where("mid", $id)->get()->getResultArray();
		$data['payment'] = $this->db->table('marriage_pay_details')->where("mid", $id)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('marriage/add', $data);
		echo view('template/footer');
	}

	public function print($id)
	{
		$data['marriage'] = $this->db->table('marriage_registration')->where("id", $id)->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('paid_through', 'DIRECT')->where('status', 1)->get()->getResultArray();
		$data['mrg_documents'] = $this->db->table('marriage_documents')->where("mid", $id)->get()->getResultArray();
		$data['payment'] = $this->db->table('marriage_pay_details')->where("mid", $id)->get()->getResultArray();
		echo view('marriage/print', $data);
	}

	public function get_payment_mode()
	{
		$id = $_POST['id'];
		$res = $this->db->table("payment_mode")->where("id", $id)->get()->getRowArray();
		$name = $res['name'];
		$data['name'] = $name;
		echo json_encode($data);
	}

	public function store()
	{
		$id = $_POST['id'];
		$data['bri_name'] = $_POST['bri_name'];
		$data['bri_ic'] = $_POST['bri_ic'];
		$data['bri_dob'] = $_POST['bri_dob'];
		$data['bri_nationality'] = $_POST['bri_nationality'];
		$data['bri_religion'] = $_POST['bri_religion'];
		$data['gro_name'] = $_POST['gro_name'];
		$data['gro_ic'] = $_POST['gro_ic'];
		$data['gro_dob'] = $_POST['gro_dob'];
		$data['gro_nationality'] = $_POST['gro_nationality'];
		$data['gro_religion'] = $_POST['gro_religion'];
		$data['date_of_mrg'] = $_POST['date_of_mrg'];
		$data['time_of_mrg'] = $_POST['time_of_mrg'];
		$data['place_of_mrg'] = $_POST['place_of_mrg'];

		$data['phonecode'] = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
		$data['phoneno'] = !empty($_POST['phoneno'])?$_POST['phoneno']:"";

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
			$data['created'] = date('Y-m-d H:i:s');
			$data['updated'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('marriage_registration')->insert($data);
			$insert_id = $this->db->insertID();
		} else {
			$data['updated'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('marriage_registration')->where('id', $id)->update($data);
			$insert_id = $id;
		}

		if (!empty($_POST['pay'])) {
			foreach ($_POST['pay'] as $row) {
				$paydata['mid'] = $insert_id;
				$paydata['date'] = $row['date'];
				$paydata['amount'] = $row['pay_amt'];
				$paydata['payment_mode'] = $row['payment_mode'];
				$paydata['created'] = date("Y-m-d H:i:s");
				$this->db->table("marriage_pay_details")->insert($paydata);
				$marriage_pay_id = $this->db->insertID();
				$this->account_migration($marriage_pay_id);
			}
		}

		if (!empty($_FILES['file'])) {
			$files = count($_FILES['file']["name"]);
			$document_des = $_POST['description'];
			for ($j = 0; $j < $files; $j++) {
				if (!empty($_FILES['file']['name'][$j])) {
					$logoimg = time() . '_' . $_FILES['file']['name'][$j];
					$target_dir = "uploads/marriage/";
					move_uploaded_file($_FILES['file']['tmp_name'][$j], $target_dir . $logoimg);
					$document_name = $logoimg;
				} else {
					$document_name = '';
				}
				$document_data = array(
					'description' => $document_des[$j],
					'document_name' => $document_name,
					'mid' => $insert_id
				);
				$this->db->table('marriage_documents')->insert($document_data);
			}
		}
		$this->session->setFlashdata('succ', 'Marriage Registered Successfully');
		return redirect()->to("/marriage");
	}
	public function account_migration($marriage_pay_id)
	{
		$marriage_pay_datas = $this->db->table('marriage_pay_details')->where('id', $marriage_pay_id)->get()->getRowArray();
		if ($marriage_pay_datas['amount']) {
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $marriage_pay_datas['payment_mode'])->get()->getRowArray();
			if (empty($payment_mode_details['id']))
				$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$sales_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
			if (!empty($sales_group)) {
				$sls_id = $sales_group['id'];
			} else {
				$sls1['parent_id'] = 26;
				$sls1['name'] = 'Sales';
				$sls1['code'] = '330';
				$sls1['added_by'] = $this->session->get('log_id');
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			// Debit ledger
			$ledger1 = $this->db->table('ledgers')->where('name', 'Register Marriage')->where('group_id', $sls_id)->get()->getRowArray();
			if (!empty($ledger1)) {
				$dr_id = $ledger1['id'];
			} else {
				$led1['group_id'] = $sls_id;
				$led1['name'] = 'Register Marriage';
				$led1['left_code'] = '7800';
				$led1['right_code'] = '000';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$dr_id = $this->db->insertID();
			}
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr = date('Y', strtotime($marriage_pay_datas['date']));
			$mon = date('m', strtotime($marriage_pay_datas['date']));
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'ROM' . date('y', strtotime($marriage_pay_datas['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));

			$entries['entrytype_id'] = '13';
			$entries['number'] = $num;
			$entries['date'] = $marriage_pay_datas['date'];

			$entries['dr_total'] = $marriage_pay_datas['amount'];
			$entries['cr_total'] = $marriage_pay_datas['amount'];
			$entries['narration'] = 'Register Marriage';
			$entries['inv_id'] = $member_id;
			$entries['type'] = '11';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty($en_id)) {
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $marriage_pay_datas['amount'];
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['amount'] = $marriage_pay_datas['amount'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
			}
			return true;
		} else
			return false;
	}
}
