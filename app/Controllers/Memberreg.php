<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\MemberPaymentGatewayData;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Memberreg extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
			exit;
		}
	}

	public function index()
	{
		$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
		$data['data']['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/memberreg/index', $data);
		//echo view('frontend/layout/footer');
	}

	public function index1()
	{
		$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
		$data['data']['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/memberreg/index1', $data);
		echo view('frontend/layout/footer');
	}
	// public function save()
	// {
	// 	// echo '<pre>'; print_r($_POST); die;
	// 	$data['name'] = trim($_POST['name']);
	// 	$data['member_type'] = trim($_POST['member_type']);
	// 	$data['ic_no'] = trim($_POST['ic_number']);
	// 	$mble_phonecode = !empty($_POST['phonecode']) ? $_POST['phonecode'] : "";
	// 	$mble_number = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
	// 	$data['mobile'] = $mble_phonecode . $mble_number;
	// 	$data['email_address'] = trim($_POST['email_address']);
	// 	$data['address'] = trim($_POST['address']);
	// 	$data['start_date'] = trim($_POST['start_date']);
	// 	$data['payment'] = trim($_POST['payment']);
	// 	$data['added_by'] = $this->session->get('log_id_frend');
	// 	$data['paid_through'] = "COUNTER";
	// 	$data['payment_status'] = 2;
	// 	$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
	// 	$data['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
	// 	$data['created'] = date('Y-m-d H:i:s');
	// 	$data['modified'] = date('Y-m-d H:i:s');
	// 	$res = $this->db->table('member')->insert($data);
	// 	if ($res) {
	// 		$ins_id = $this->db->insertID();
	// 		$this->account_migration($ins_id);
	// 		if (!empty($_POST['email_address'])) {
	// 			$temple_title = "Temple " . $_SESSION['site_title'];
	// 			$mail_data['mem_id'] = $ins_id;
	// 			$message = view('member/mail_template', $mail_data);
	// 			$subject = $_SESSION['site_title'] . " Member Registration";
	// 			$to_user = $_POST['email_address'];
	// 			$to_mail = array("prithivitest@gmail.com", $to_user);
	// 			send_mail_with_content($to_mail, $message, $subject, $temple_title);
	// 		}
	// 		$this->session->setFlashdata('succ', 'Member Added Successfully');
	// 		return redirect()->to("/memberreg");
	// 	} else {
	// 		$this->session->setFlashdata('fail', 'Please Try Again');
	// 		return redirect()->to("/memberreg");
	// 	}
	// }

	public function save()
	{
		$data['name'] = trim($_POST['name']);
		$data['member_type'] = trim($_POST['member_type']);
		$data['ic_no'] = trim($_POST['ic_number']);
		$mble_phonecode = !empty($_POST['phonecode']) ? $_POST['phonecode'] : "";
		$mble_number = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
		$data['mobile'] = $mble_phonecode . $mble_number;
		$data['email_address'] = trim($_POST['email_address']);
		$data['address'] = trim($_POST['address']);
		$data['joining_date'] = trim($_POST['start_date']);
		$data['start_date'] = trim($_POST['start_date']);
		if ($_POST['member_type'] === '3') { // Assuming 3 is the numerical value for 'Lifetime'
			$data['end_date'] = null;
		} else {
			$endDate = date("Y-m-d", strtotime("+1 year -1 day", strtotime($_POST['start_date'])));
			$data['end_date'] = $endDate;
		}
		$data['payment'] = trim($_POST['payment']);
		$pay_method = !empty($_POST['pay_method']) ? trim($_POST['pay_method']) : 'cash';
		$data['added_by'] = $this->session->get('log_id_frend');
		$data['paid_through'] = "COUNTER";

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


		if ($pay_method == 'cash' || $pay_method == 'online') {
			$data['status'] = 1; // Confirmed
			$data['payment_status'] = 2; // Cash done
		} else {
			$data['status'] = 2; // Pending, adjust accordingly
			$data['payment_status'] = 1; // Online payment
		}

		$query = $this->db->query("SELECT MAX(member_no) AS member_no FROM member")->getRowArray();
		$data['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');

		$res = $this->db->table('member')->insert($data);

		if ($res) {
			$ins_id = $this->db->insertID();
			// Log the payment data in member_payment_gateway_datas table
			$paymentData = [
				'member_id' => $ins_id,
				'pay_method' => $pay_method,
				'request_data' => json_encode($_POST), // Customize this based on your needs
				'response_data' => null, // Set response data accordingly
				'reference_id' => null, // Set reference ID accordingly
				'created' => date('Y-m-d H:i:s'),
			];

			$this->db->table('member_payment_gateway_datas')->insert($paymentData);
			if ($data['payment_status'] == 2) {
				$this->account_migration($ins_id);
				$this->send_whatsapp_msg($ins_id);
				$this->send_mail_to_customer($ins_id);
			}

			$this->session->setFlashdata('succ', 'Member Added Successfully');
			return redirect()->to("/memberreg");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			return redirect()->to("/memberreg");
		}
	}
	public function send_mail_to_customer($id)
	{
		$member = $this->db->table("member")->where("id", $id)->get()->getRowArray();
		if (!empty($member['email_address'])) {
			$tmpid = 1;
			$mail_data['temple_details'] = $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$temple_title = "Temple " . $temple_details['name'];
			$mail_data['mem_id'] = $ins_id;
			$message = view('member/online_mail_template', $mail_data);
			$subject = $temple_details['name'] . " Member Registration";
			$to_user = $member['email_address'];
			$to_mail = array("prithivitest@gmail.com", $to_user);
			send_mail_with_content($to_mail, $message, $subject, $temple_title);
		}
	}


	public function account_migration($member_id)
	{
		$member_datas = $this->db->table('member')->where('id', $member_id)->get()->getRowArray();
		$member_payment_gateway_datas = $this->db->table('member_payment_gateway_datas')->where('member_id', $member_id)->get()->getRowArray();
		if ($member_payment_gateway_datas['pay_method'] == 'cash')
			$payment_id = 6; ////  goto cash Ledger
		else if ($member_payment_gateway_datas['pay_method'] == 'online')
			$payment_id = 7; ////  goto online Ledger
		else
			$payment_id = 4; ////  goto Qr or Online Payment Ledger
		$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
		$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
		if (!empty($incomes_group)) {
			$sls_id = $incomes_group['id'];
		} else {
			$sls1['parent_id'] = 0;
			$sls1['name'] = 'Incomes';
			$sls1['code'] = '8000';
			$sls1['added_by'] = $this->session->get('log_id');
			$this->db->table('groups')->insert($sls1);
			$sls_id = $this->db->insertID();
		}
		// Debit ledger
		if(!empty($member_datas['ledger_id'])){
			$dr_id = $member_datas['ledger_id'];
		}else{
			$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
			if(!empty($ledger1)){
				$dr_id = $ledger1['id'];
			}else{
				$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
				$set_right_code = (int) $right_code['right_code'] + 1;
				$set_right_code = sprintf("%04d", $set_right_code);
				$led1['group_id'] = $sls_id;
				$led1['name'] = 'All Incomes';
				$led1['left_code'] = '8913';
				$led1['right_code'] = $set_right_code;
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$dr_id = $this->db->insertID();
			}
		}
		if (!empty($member_datas['payment'])) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$entry_date = date('Y-m-d');
			$yr = date('Y', strtotime($entry_date));
			$mon = date('m', strtotime($entry_date));
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'REC' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));

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
	public function get_member_amount()
	{
		$id = $_POST['id'];
		$data = $this->db->table('member_type')->select('amount')->where('id', $id)->get()->getRowArray();
		echo json_encode($data);
	}
	public function send_whatsapp_msg($id)
	{
		$tmpid = 1;
		$data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*')
			->where("member.id", $id);
		$member = $qry->get()->getRowArray();

		$data['qry1'] = $member;
		if (!empty($member['mobile'])) {
			$html = view('member/pdf', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled' => true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/member_card_' . $id . '.pdf';

			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$message_params[] = $member['name'];
			$message_params[] = $member['tname'];
			$message_params[] = $member['member_no'];
			$message_params[] = date('d M, Y', strtotime($member['start_date']));
			$media['url'] = base_url() . '/uploads/documents/member_card_' . $id . '.pdf';
			$media['filename'] = 'member_card.pdf';
			$mobile_number = $member['mobile'];
			//$mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'member_reg_live', $media);
			//print_r($whatsapp_resp);
			//echo $whatsapp_resp['success'];
			/* if($whatsapp_resp['success']) 
							  //echo 'success';
							  echo view('hallbooking/whatsapp_resp_suc');
							  else 
							  //echo 'fail'; 
							  echo view('hallbooking/whatsapp_resp_fail'); */
		}
	}
}
