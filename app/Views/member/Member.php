<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Member extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		if (!$this->model->list_validate('member')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('member');
		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*');

		$res = $qry->get()->getResultArray();
		$data['list'] = $res;
		// echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/index', $data);
		echo view('template/footer');
	}
	public function view()
	{
		if (!$this->model->permission_validate('member', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);


		$data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();

		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if (!$this->model->permission_validate('member', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
		$data['data']['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();

		$data['mode'] = 'add';
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}

	public function edit()
	{
		if (!$this->model->permission_validate('member', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();

		$data['mode'] = 'edit';
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}

	public function save()
	{
		// echo '<pre>'; print_r($_POST); die;
		$id = $_POST['id'];


		$data['name'] = trim($_POST['name']);
		$data['member_type'] = trim($_POST['member_type']);
		$data['ic_no'] = trim($_POST['ic_number']);
		$data['mobile'] = trim($_POST['mobile']);
		$data['address'] = trim($_POST['address']);
		$data['start_date'] = trim($_POST['start_date']);
		// $data['end_date'] = date('Y-m-d', strtotime(trim($_POST['end_date'])));

		$data['end_date'] = null; // default to null

		if ($_POST['member_type'] === '3') { // Assuming 3 is the numerical value for 'Lifetime'
			$data['end_date'] = null;
		} else {
			$data['end_date'] = date('Y-m-d', strtotime(trim($_POST['end_date'])));
		}


		$data['payment'] = trim($_POST['payment']);
		$data['payment_mode'] = trim($_POST['paymentmode']);
		$data['status'] = trim($_POST['status']);
		$data['email_address'] = $_POST['email_address'];
		$data['added_by'] = $this->session->get('log_id');

		if (empty($id)) {
			$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
			$data['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->insert($data);
			if ($res) {
				$ins_id = $this->db->insertID();
				$this->account_migration($ins_id);
				if (!empty($_POST['email_address'])) {
					$temple_title = "Temple " . $_SESSION['site_title'];
					$mail_data['mem_id'] = $ins_id;
					$message = view('member/mail_template', $mail_data);
					$subject = $_SESSION['site_title'] . " Member Registration";
					$to_user = $_POST['email_address'];
					$to_mail = array("prithivitest@gmail.com", $to_user);
					send_mail_with_content($to_mail, $message, $subject, $temple_title);
				}
				$this->session->setFlashdata('succ', 'Member Added Successfully');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->where('id', $id)->update($data);
			if ($res) {
				$this->session->setFlashdata('succ', 'Member Updated Successfully');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		}
	}
	public function account_migration($member_id)
	{
		$member_datas = $this->db->table('member')->where('id', $member_id)->get()->getRowArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', 3)->get()->getRowArray();
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
		$ledger1 = $this->db->table('ledgers')->where('name', 'Member Fees')->where('group_id', $sls_id)->get()->getRowArray();
		if (!empty($ledger1)) {
			$dr_id = $ledger1['id'];
		} else {
			$led1['group_id'] = $sls_id;
			$led1['name'] = 'Member Fees';
			$led1['left_code'] = '7099';
			$led1['right_code'] = '000';
			$led1['op_balance'] = '0';
			$led1['op_balance_dc'] = 'D';
			$led_ins1 = $this->db->table('ledgers')->insert($led1);
			$dr_id = $this->db->insertID();
		}
		if (!empty($member_datas['payment'])) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr = date('Y', strtotime($member_datas['date']));
			$mon = date('m', strtotime($member_datas['date']));
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'REC' . date('y', strtotime($member_datas['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));

			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = $member_datas['start_date'];

			$entries['dr_total'] = $member_datas['payment'];
			$entries['cr_total'] = $member_datas['payment'];
			$entries['narration'] = 'Member Registration';
			$entries['inv_id'] = $member_id;
			$entries['type'] = '11';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty($en_id)) {
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $member_datas['payment'];
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['amount'] = $member_datas['payment'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
			}
			return true;
		} else
			return false;
	}
	public function delete()
	{
		if (!$this->model->permission_validate('member', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('ubayam')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Ubayam Deleted Successfully');
			header("Location: " . base_url() . "/ubayam");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/ubayam");
		}
		header("Location: " . base_url() . "/ubayam");

	}

	public function get_member_amount()
	{
		$id = $_POST['id'];
		$data = $this->db->table('member_type')->select('amount')->where('id', $id)->get()->getRowArray();
		echo json_encode($data);
	}
	public function print_page()
	{
		if (!$this->model->permission_validate('member', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*')
			->where("member.id", $id);

		$res = $qry->get()->getRowArray();

		$data['qry1'] = $res;
		echo view('member/print_page', $data);
	}


	public function renewal()
	{
		$currentDate = date("Y-m-d");

		// Deactivate members with end date below the current date
		$this->db->table('member')
			->where('end_date <', $currentDate)
			->where('status', 1)
			->update(['status' => 0]);

		// Retrieve inactive members for display
		$query = $this->db->table('member')
			->where('status', 2)
			->get();
		$data['inactiveMembers'] = $query->getResultArray();

		// Load the view with the data
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal', $data);
		echo view('template/footer');
	}



	public function cron()
	{
		// Load the database library
		$db = \Config\Database::connect();

		// Get the current date
		$currentDate = date("Y-m-d");

		// Query to retrieve active members whose end date is before the current date
		$query = $db->query("SELECT * FROM member WHERE end_date < '$currentDate' AND status = 1");

		// Deactivate members
		foreach ($query->getResultArray() as $row) {
			$memberId = $row['id']; // replace 'id' with your actual primary key field
			$db->table('member')->set('status', 2)->where('id', $memberId)->update();
		}

		echo "Cron job executed successfully.";
	}




}