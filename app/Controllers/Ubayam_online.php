<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Ubayam_online extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
			exit;
		}
	}
	public function index_old()
	{
		$data['sett_data'] = $this->db->table('ubayam_setting')->get()->getResultArray();
		$data['res'] = $this->db->table('ubayam')->select('id')->orderBy('id', 'desc')->get()->getRowArray();
		echo view('frontend/layout/header');
		echo view('frontend/ubayam/index', $data);
		echo view('frontend/layout/footer');
	}

	public function index()
	{
		$login_id = $_SESSION['log_id_frend'];
		$data['sett_data'] = $this->db->table('ubayam_setting')->get()->getResultArray();
		$data['res'] = $this->db->table('ubayam')->select('id')->orderBy('id', 'desc')->get()->getRowArray();
		$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		//$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		$data['reprintlists'] = $this->db->query("SELECT id,paidamount,ref_no,dt FROM ubayam WHERE added_by = '" . $login_id . "' and paid_through = 'COUNTER' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/ubayam_new/index', $data);
		//echo view('frontend/layout/footer');
	}
	
	
	public function ubayam()
	{
		$login_id = $_SESSION['log_id_frend'];
		$default_group = $this->db->query("SELECT * FROM ubayam_group order by id asc limit 1")->getRowArray();
		$data['default'] = str_replace(' ', '_', strtolower($default_group['name']));
		$data['sett_data'][''] = $this->db->table('ubayam_setting')->where('groupname', '')->get()->getResultArray();
		$data['res'] = $this->db->table('ubayam')->select('id')->orderBy('id', 'desc')->get()->getRowArray();
		$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		//$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		$group = $this->db->query("SELECT * FROM ubayam_group order by name asc")->getResultArray();
		foreach ($group as $row) {
			$data['sett_data'][$row['name']] = $this->db->table('ubayam_setting')->where('groupname', $row['name'])->get()->getResultArray();
		}
		$data['reprintlists'] = $this->db->query("SELECT id,paidamount,ref_no,dt FROM ubayam WHERE added_by = '" . $login_id . "' and paid_through = 'COUNTER' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
		$cur_date = date('Y-m-d');
		$ubayam_datas = $this->db->query("SELECT u.*, us.name as ubayam_name FROM `ubayam` u left join ubayam_setting us on us.id = u.pay_for where ((u.paid_through != 'DIRECT' and payment_status = 2) or (u.paid_through = 'DIRECT')) and (u.ubayam_date  >= '$cur_date')")->getResultArray();
		$ubayamdata = array();
		if (!empty($ubayam_datas)) {
			foreach ($ubayam_datas as $ubayam_data) {
				$h_dat = array(
					"year" => intval(date("Y", strtotime($ubayam_data['ubayam_date']))),
					"month" => intval(date("m", strtotime($ubayam_data['ubayam_date']))),
					"day" => intval(date("d", strtotime($ubayam_data['ubayam_date']))),
					"event_id" => $ubayam_data['id'],
					"ref_no" => $ubayam_data['ref_no'],
					"otb" => 0,
					"name" => $ubayam_data['name'],
					"event_name" => $ubayam_data['ubayam_name'],
					"register_by" => $ubayam_data['name']
				);
				$h_dat['repay'] = false;
				if ($ubayam_data['balance_amount'] > 0)
					$h_dat['repay'] = true;
				$ubayamdata["events"][] = $h_dat;
			}
		} else {
			$ubayamdata["events"][] = array();
		}
		$overall_temple_hall_blocking_datas = $this->db->table('overall_temple_block')
			->select("date as booking_date,description as register_by")
			->get()->getResultArray();
		if (!empty($overall_temple_hall_blocking_datas)) {
			foreach ($overall_temple_hall_blocking_datas as $overall_temple_blocking_data) {
				$ubayamdata["events"][] = array(
					"year" => intval(date("Y", strtotime($overall_temple_blocking_data['booking_date']))),
					"month" => intval(date("m", strtotime($overall_temple_blocking_data['booking_date']))),
					"day" => intval(date("d", strtotime($overall_temple_blocking_data['booking_date']))),
					"event_id" => 0,
					"ref_no" => "",
					"otb" => 1,
					"repay" => false,
					"name" => "ADMIN",
					"event_name" => "OVERALL TEMPLE BLOCK.",
					"register_by" => "ADMIN"
				);
			}
		} else {
			$ubayamdata["events"][] = array();
		}
		$data['ubayams'] = json_encode($ubayamdata);
		echo view('frontend/layout/header');
		echo view('frontend/ubayam_new/ubayam', $data);
		//echo view('frontend/layout/footer');
	}

	public function get_natchathram()
	{
		$rasi_id = $_POST['rasi_id'];
		$res = $this->db->table('rasi')->where('id', $rasi_id)->get()->getRowArray();
		if (!empty($res['natchathra_id'])) {
			$data = array("natchathra_id" => $res['natchathra_id'], "rasi_id" => $res['rasi_id']);
		} else {
			$res_natchathrams = $this->db->table('natchathram')->get()->getResultArray();
			$data_bf = array();
			foreach ($res_natchathrams as $res_natchathram) {
				$data_bf[] = $res_natchathram['id'];
			}
			$dataip = implode(',', $data_bf);
			$data = array("natchathra_id" => $dataip, "rasi_id" => $res['rasi_id']);
		}
		echo json_encode($data);
		exit;
	}
	public function get_natchathram_name()
	{
		$id = $_POST['id'];
		/*if(!empty($id)) {
												   $res =  $this->db->table('natchathram')->where('id',$id)->get()->getRowArray();
											   } else {
												   $res =  $this->db->table('natchathram')->get()->getResultArray();
											   }*/
		$res = $this->db->table('natchathram')->where('id', $id)->get()->getRowArray();
		$data = array("id" => $res['id'], "name_eng" => $res['name_eng']);
		echo json_encode($data);
		exit;
	}

	// public function save(){
	// 	$msg_data = array();
	// 	$msg_data['err'] = '';
	// 	$msg_data['succ'] = '';
	// 	$date = explode('-', $_POST['dt']);
	// 	$yr = $date[0];
	// 	$mon = $date[1];

	// 	$ubyam_set_amt =  $this->db->table('ubayam_setting')->where('id',$_POST['pay_for'])->get()->getRowArray();
	// 	$amt = !empty($ubyam_set_amt['amount']) ? $ubyam_set_amt['amount'] : 0;
	// 	$balanceamount = $amt - $_POST['total_amt'];
	// 	$query   = $this->db->query("SELECT ref_no FROM ubayam where id=(select max(id) from ubayam where year (dt)='". $yr ."' and month (dt)='". $mon ."')")->getRowArray();
	// 	$data['ref_no']= 'UB' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
	//     $data['dt']		 	 	=	$_POST['dt'];
	// 	$data['pay_for']	 	=	trim($_POST['pay_for']);
	// 	$data['name']		 	=	trim($_POST['name']);
	// 	$data['address']	 	=	trim($_POST['address']);
	// 	$data['email']	 	=	trim($_POST['email_id']);
	// 	$data['ic_number']	 	=	trim($_POST['ic_number']);
	// 	$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
	//   	$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
	// 	$data['mobile']  = $mble_phonecode.$mble_number;
	// 	$data['description'] 	=	trim($_POST['description']);
	// 	$data['amount']		 	=	$amt;
	// 	$data['paidamount'] 	=	trim($_POST['total_amt']);
	// 	$data['balanceamount']	=	$balanceamount;
	// 	$data['paid_through'] = "COUNTER";
	// 	$pay_method       =	(!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
	// 	$data['payment_status'] =   ($pay_method == 'cash' ? 2: 1);
	// 	$data['added_by']	 	=	$this->session->get('log_id_frend');
	// 	$data['created_at']  =	date('Y-m-d H:i:s');
	// 	$data['modified_at'] = date('Y-m-d H:i:s');
	// 	$res = $this->db->table('ubayam')->insert($data);
	// 	$whatsapp_resp = whatsapp_aisensy($data['mobile'], [], 'success_message1');
	// 	if($res){
	// 		$ins_id = $this->db->insertID();
	// 		$pays['ubayam_id'] 	= $ins_id;
	// 		$pays['date'] 		= date("Y-m-d");
	// 		$pays['amount'] 	= $data['paidamount'];
	// 		$this->db->table('ubayam_pay_details')->insert($pays);
	// 		if(!empty($_POST['familly']))
	// 		{
	// 			foreach($_POST['familly'] as $row_fam){
	// 				$fmys = array();
	// 				$fmys['ubayam_id'] 	= $ins_id;
	// 				$fmys['name'] 		= $row_fam['name'];
	// 				$fmys['relationship'] 	= $row_fam['relationship'];
	// 				$this->db->table('ubayam_family_details')->insert($fmys);
	// 			}
	// 		}
	// 		$payment_gateway_data = array();
	// 		$payment_gateway_data['ubayam_id'] = $ins_id;
	// 		$payment_gateway_data['pay_method'] = $pay_method;
	// 		$this->db->table('ubayam_payment_gateway_datas')->insert($payment_gateway_data);
	// 		$ubayam_payment_gateway_id = $this->db->insertID();
	// 		if($data['payment_status'] == 2) $this->account_migration($ins_id);
	// 		if(!empty($_POST['email_id']))
	// 		{
	// 			$temple_title = "Temple ".$_SESSION['site_title'];
	// 			$qr_url = base_url()."/ubayam_online/reg/";
	//         	$mail_data['qr_image'] = qrcode_generation($ins_id,$qr_url);
	// 			$mail_data['ubm_id'] = $ins_id;
	// 			$message =  view('ubayam/mail_template',$mail_data);
	// 			$subject = $_SESSION['site_title']." Ubayam Voucher";
	// 			$to_user = $_POST['email_id'];
	// 			$to_mail = array("prithivitest@gmail.com",$to_user);
	// 			send_mail_with_content($to_mail,$message,$subject,$temple_title);
	// 		}
	// 		$this->session->setFlashdata('succ', 'Ubayam Added Successflly');
	// 		$msg_data['succ'] = 'Ubayam Added Successflly';
	// 		$msg_data['id'] = $ins_id;
	// 	}else{
	// 		$this->session->setFlashdata('fail', 'Please Try Again');
	// 		$msg_data['err'] = 'Please Try Again';
	// 	}
	// 	echo json_encode($msg_data);
	// 	exit();
	// }


	public function save()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';

		$date = explode('-', $_POST['dt']);
		$yr = $date[2];
		$mon = $date[1];

		// Modify the lines for optional fields like rasi_id, natchathra_id, and description
		$rasi_id = isset($_POST['rasi_id']) ? trim($_POST['rasi_id']) : "";
		$natchathra_id = isset($_POST['natchathra_id']) ? trim($_POST['natchathra_id']) : "";
		$description = isset($_POST['description']) ? trim($_POST['description']) : "";

		$ubyam_set_amt = $this->db->table('ubayam_setting')->where('id', $_POST['pay_for'])->get()->getRowArray();
		$amt = !empty($ubyam_set_amt['amount']) ? $ubyam_set_amt['amount'] : 0;
		// $balanceamount = $amt - $_POST['total_amt'];
		// Capture the total paid amount from the form
		$paid_amount = !empty($_POST['paid_amount']) ? (float) $_POST['paid_amount'] : 0;

		// Calculate balance amount
		$balanceamount = $amt - $paid_amount;
		$query = $this->db->query("SELECT ref_no FROM ubayam where id=(select max(id) from ubayam where year (dt)='" . $yr . "' and month (dt)='" . $mon . "')")->getRowArray();
		$data['ref_no'] = 'UB' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['dt'] = $_POST['dt'];
		$data['ubayam_date'] = $_POST['ubhayam_date'];
		$data['pay_for'] = trim($_POST['pay_for']);
		$data['name'] = trim($_POST['name']);
		$data['address'] = trim($_POST['address']);
		$data['email'] = trim($_POST['email_id']);
		$data['ic_number'] = trim($_POST['ic_number']);
		$mble_phonecode = !empty($_POST['phonecode']) ? $_POST['phonecode'] : "";
		$mble_number = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
		$data['mobile'] = $mble_phonecode . $mble_number;
		$data['description'] = $description;
		$data['amount'] = $amt;
		// $data['paidamount'] = trim($_POST['total_amt']);
		// $data['balanceamount'] = $balanceamount;
		$data['paidamount'] = $paid_amount;  // Saving the paid amount
		$data['balanceamount'] = $balanceamount;  // Saving the balance amount
		$data['paid_through'] = "COUNTER";
		$pay_method = (!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
		$data['payment_status'] = (($pay_method == 'cash' || $pay_method == 'online') ? 2 : 1);
		$data['added_by'] = $this->session->get('log_id_frend');
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['modified_at'] = date('Y-m-d H:i:s');
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

		$res = $this->db->table('ubayam')->insert($data);
		// $whatsapp_resp = whatsapp_aisensy($data['mobile'], [], 'success_message1');



		if ($res) {
			$ins_id = $this->db->insertID();
			$pays['ubayam_id'] = $ins_id;
			$pays['date'] = date("Y-m-d");
			$pays['amount'] = $data['paidamount'];
			$pays['paid_through'] = "COUNTER";
			$this->db->table('ubayam_pay_details')->insert($pays);

			if (!empty($_POST['familly'])) {
				foreach ($_POST['familly'] as $row_fam) {
					$fmys = array();
					$fmys['ubayam_id'] = $ins_id;
					$fmys['name'] = $row_fam['name'];
					$fmys['relationship'] = $row_fam['relationship'];
					$this->db->table('ubayam_family_details')->insert($fmys);
				}
			}

			$payment_gateway_data = array();
			$payment_gateway_data['ubayam_id'] = $ins_id;
			$payment_gateway_data['pay_method'] = $pay_method;
			$this->db->table('ubayam_payment_gateway_datas')->insert($payment_gateway_data);
			$ubayam_payment_gateway_id = $this->db->insertID();

			if ($data['payment_status'] == 2) {
				$this->account_migration($ins_id);
				$this->send_whatsapp_msg($ins_id);
				$this->send_mail_to_customer($ins_id);
			}

			$this->session->setFlashdata('succ', 'Ubayam Added Successfully');
			$msg_data['succ'] = 'Ubayam Added Successfully';
			$msg_data['id'] = $ins_id;
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			$msg_data['err'] = 'Please Try Again';
		}

		echo json_encode($msg_data);
		exit();
	}
	public function send_mail_to_customer($id)
	{
		$ubayam = $this->db->table("ubayam")->where("id", $id)->get()->getRowArray();
		if (!empty($ubayam['email'])) {
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$temple_title = "Temple " . $temple_details['name'];
			$qr_url = base_url() . "/ubayam_online/reg/";
			$mail_data['qr_image'] = qrcode_generation($id, $qr_url);
			$mail_data['ubm_id'] = $id;
			$mail_data['temple_details'] = $temple_details;
			$message = view('ubayam/mail_template', $mail_data);
			$subject = $temple_details['name'] . " Ubayam Voucher";
			$to_user = $_POST['email_id'];
			$to_mail = array("prithivitest@gmail.com", $to_user);
			send_mail_with_content($to_mail, $message, $subject, $temple_title);
		}
	}
	public function payment_process($ubayam_id)
	{
		$ubayam_booking = $this->db->table('ubayam')->where('id', $ubayam_id)->get()->getRowArray();
		$ubayam_payment_gateway_datas = $this->db->table('ubayam_payment_gateway_datas')->where('ubayam_id', $ubayam_id)->get()->getResultArray();
		if (count($ubayam_payment_gateway_datas) > 0) {
			if ($ubayam_payment_gateway_datas[0]['pay_method'] == 'adyen') {
				if (!empty($ubayam_payment_gateway_datas[0]['request_data'])) {
					$request_data = $ubayam_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				} else {
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($ubayam_booking['amount'], $ubayam_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('ubayam_payment_gateway_datas')->where('id', $ubayam_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if (!empty($response['url']) && !empty($response['id'])) {
					header('Location: ' . $response['url']);
					exit;
				}
			} elseif ($ubayam_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_qr') {
				//$view_file = 'frontend/ipay88/ipay_merch_qr';
				$view_file = 'frontend/ipay88/ipay_merch_qr_camera';
				$data['ubayam_id'] = $ubayam_id;
				$data['list'] = $this->db->table('payment_option')->where('status', 1)->get()->getResultArray();
				$data['submit_url'] = '/ubayam_online/initiate_ipay_merch_qr/' . $ubayam_id;
				echo view($view_file, $data);
			} elseif ($ubayam_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_online') {
				$view_file = 'frontend/ipay88/ipay_merch_online';
				$data['id'] = $ubayam_id;
				$data['controller'] = 'ubayam_online';
				echo view($view_file, $data);
			} else {
				$redirect_url = base_url() . '/ubayam_online/print_booking/' . $ubayam_id;
				header('Location: ' . $redirect_url);
				exit;
			}
		} else {
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$result = $this->initiatePayment($ubayam_booking['amount'], $ubayam_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
			$response = json_decode($result, true);
			if (!empty($response['url']) && !empty($response['id'])) {
				$payment_gateway_data = array();
				$payment_gateway_data['ubayam_id'] = $ubayam_id;
				$payment_gateway_data['pay_method'] = 'adyen';
				$payment_gateway_data['request_data'] = $result;
				$payment_gateway_data['reference_id'] = $response['id'];
				$this->db->table('ubayam_payment_gateway_datas')->insert($payment_gateway_data);
				$ubayam_payment_gateway_id = $this->db->insertID();
				if (!empty($ubayam_payment_gateway_id)) {
					header('Location: ' . $response['url']);
					exit;
				}
			}
		}
	}
	public function initiatePayment($amount, $orderid, $address, $city, $email)
	{
		if (file_get_contents('php://input') != '') {
			$request = json_decode(file_get_contents('php://input'), true);
		} else {
			$request = array();
		}
		$apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
		$merchantAccount = "VivaantechsolutionscomECOM";
		$url = "https://checkout-test.adyen.com/v70/paymentLinks";
		$final_amt = $amount * 100;
		$data = [
			'amount' => [
				'currency' => 'MYR',
				'value' => $final_amt
			],
			"reference" => $orderid,
			'countryCode' => "MY",
			'shopperReference' => "order_" . $orderid,
			'shopperEmail' => $email,
			'shopperLocale' => "en-US",
			"billingAddress" => [
				"street" => $address,
				"postalCode" => "46000",
				"city" => $city,
				"houseNumberOrName" => "1/23",
				"country" => "MY",
				"stateOrProvince" => "KL"
			],
			"deliveryAddress" => [
				"street" => $address,
				"postalCode" => "46000",
				"city" => $city,
				"houseNumberOrName" => "1/23",
				"country" => "MY",
				"stateOrProvince" => "KL"
			],
			'returnUrl' => base_url() . '/ubayam_online/print_booking/' . $orderid,
			'merchantAccount' => $merchantAccount
		];
		$json_data = json_encode($data);
		$curlAPICall = curl_init();
		curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($curlAPICall, CURLOPT_URL, $url);
		curl_setopt(
			$curlAPICall,
			CURLOPT_HTTPHEADER,
			array(
				"x-api-key: " . $apikey,
				"Content-Type: application/json",
				"Content-Length: " . strlen($json_data)
			)
		);
		$result = curl_exec($curlAPICall);
		if ($result === false) {
			throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
		}
		curl_close($curlAPICall);
		return $result;
	}
	public function initiatePayment_response($pay_id)
	{
		if (file_get_contents('php://input') != '') {
			$request = json_decode(file_get_contents('php://input'), true);
		} else {
			$request = array();
		}
		$apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
		$merchantAccount = "VivaantechsolutionscomECOM";
		$url = "https://checkout-test.adyen.com/v70/paymentLinks/" . $pay_id;
		$curlAPICall = curl_init();
		curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlAPICall, CURLOPT_URL, $url);
		// Api key
		curl_setopt(
			$curlAPICall,
			CURLOPT_HTTPHEADER,
			array(
				"x-api-key: " . $apikey
			)
		);
		$result = curl_exec($curlAPICall);
		if ($result === false) {
			throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
		}
		curl_close($curlAPICall);
		return $result;
	}
	public function ipay88_online_response($ubayam_id)
	{
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$MerchantCode = 'M01236';
		$MerchantKey = 'HQgUUZLVzg';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$response = $ipay88->getResponse();
		//print_r($response);
		if ($response['status']) {
			$ubayam_up_data = array();
			$ubayam_up_data['payment_status'] = 2;
			$this->db->table('ubayam')->where('id', $ubayam_id)->update($ubayam_up_data);
			$this->account_migration($ubayam_id);
			$this->session->setFlashdata('succ', 'Ubayam Successfully Completed');
			$redirect_url = base_url() . '/ubayam_online/print_booking/' . $ubayam_id;
			header('Location: ' . $redirect_url);
			exit;
		} else {
			$this->session->setFlashdata('fail', 'Payment Failed');
			echo '<script>
    window.onunload = refreshParent;
	window.close();
    function refreshParent() {
        window.opener.location.reload();
    }
</script>';
		}
	}
	public function initiate_ipay_merch_online($ubayam_id)
	{
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$ubayam_booking = $this->db->table('ubayam')->where('id', $ubayam_id)->get()->getRowArray();
		$email = !empty($ubayam_booking['email']) ? $ubayam_booking['email'] : 'dd@ipay88.com.my';
		$name = !empty($ubayam_booking['name']) ? $ubayam_booking['name'] : 'Prithivi';
		$mobile_no = !empty($ubayam_booking['mobile']) ? $ubayam_booking['mobile'] : '9856734562';
		$description = 'Ubayam';
		$final_amt = $ubayam_booking['amount'];
		$final_amount = number_format($final_amt, '2', '.', '');
		$final_amt_str = (string) ($final_amt * 1000);
		$MerchantCode = 'M01236';
		$MerchantKey = 'HQgUUZLVzg';
		$ref_no = 'UBY_' . $ubayam_id;
		$refno_pay = $ref_no;
		$module = 'archanai';
		// $final_amount = '1.00';
		// $final_amt_str = '1000';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$ipay88->setField('PaymentId', 16);
		$ipay88->setField('RefNo', $refno_pay);
		$ipay88->setField('Amount', $final_amount);
		$ipay88->setField('Currency', 'MYR');
		$ipay88->setField('ProdDesc', $description);
		$ipay88->setField('UserName', $name);
		$ipay88->setField('UserEmail', $email);
		$ipay88->setField('UserContact', (string) $mobile_no);
		$ipay88->setField('Remark', $description);
		$ipay88->setField('Lang', 'utf-8');
		$ipay88->setField('ResponseURL', base_url() . '/ubayam_online/ipay88_online_response/' . $ubayam_id);
		$ipay88->setField('BackendURL', base_url() . '/ubayam_online/ipay88_online_response/' . $ubayam_id);
		$ipay88->generateSignature();
		$ipay88_fields = $ipay88->getFields();
		$data['ipay88_fields'] = $ipay88_fields;
		$data['epayment_url'] = \Ipay88::$epayment_url;
		$view_file = 'frontend/ipay88/ipay_merch_online_process';
		echo view($view_file, $data);
	}
	public function account_migration($ubayam_id)
	{
		$ubayam = $this->db->table('ubayam')->where('id', $ubayam_id)->get()->getRowArray();
		if ($ubayam['paid_through'] == 'COUNTER') {
			$ubayam_payment_gateway_datas = $this->db->table('ubayam_payment_gateway_datas')->where('ubayam_id', $ubayam_id)->get()->getRowArray();
			if ($ubayam_payment_gateway_datas['pay_method'] == 'cash')
				$payment_id = 6; ////  goto cash Ledger
			elseif ($ubayam_payment_gateway_datas['pay_method'] == 'online')
				$payment_id = 7; ////  goto online Ledger
			else
				$payment_id = 4; ////  goto Qr or Online Payment Ledger
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			if (empty($payment_mode_details['id']))
				$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
			if (!empty($sales_group)) {
				$sls_id = $sales_group['id'];
			} else {
				$sls1['parent_id'] = 0;
				$sls1['name'] = 'Sales';
				$sls1['code'] = '4000';
				$sls1['added_by'] = $this->session->get('log_id');
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			// Individual Ledger
			/* $ledger = $this->db->table('ledgers')->where('name', 'UBAYAM FEE')->where('group_id', 29)->where('left_code', '6003')->get()->getRowArray();
					 if (!empty($ledger)) {
						 $dr_id = $ledger['id'];
					 } else {
						 $led['group_id'] = 29;
						 $led['name'] = 'UBAYAM FEE';
						 $led['left_code'] = '6003';
						 $led['right_code'] = '000';
						 $led['op_balance'] = '0';
						 $led['op_balance_dc'] = 'D';
						 $led_ins = $this->db->table('ledgers')->insert($led);
						 $dr_id = $this->db->insertID();
					 } */
			// Individual Ledger
			// Separate Ledger
			$ubayam_setting = $this->db->table('ubayam_setting')->where('id', $ubayam['pay_for'])->get()->getRowArray();
			$ubayam_name = $ubayam_setting['name'];
			/* $ledger = $this->db->table('ledgers')->where('name', $ubayam_name)->where('group_id', 29)->where('left_code', '6003')->get()->getRowArray();
					 if (!empty($ledger)) {
						 $dr_id = $ledger['id'];
					 } else {
						 $right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', 29)->where('left_code', '6003')->orderBy('right_code','desc')->get()->getRowArray();
						 $set_right_code = (int) $right_code['right_code'] + 1;
						 $set_right_code = sprintf("%04d", $set_right_code);
						 $led['group_id'] = 29;
						 $led['name'] = $ubayam_name;
						 $led['left_code'] = '6003';
						 $led['right_code'] = $set_right_code;
						 $led['op_balance'] = '0';
						 $led['op_balance_dc'] = 'D';
						 $led_ins = $this->db->table('ledgers')->insert($led);
						 $dr_id = $this->db->insertID();
					 } */
			if (!empty($ubayam_setting['ledger_id'])) {
				$dr_id = $ubayam_setting['ledger_id'];
			} else {
				$ledger1 = $this->db->table('ledgers')->where('name', 'All Sales')->where('group_id', $sls_id)->get()->getRowArray();
				if (!empty($ledger1)) {
					$dr_id = $ledger1['id'];
				} else {
					$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '4913')->orderBy('right_code', 'desc')->get()->getRowArray();
					$set_right_code = (int) $right_code['right_code'] + 1;
					$set_right_code = sprintf("%04d", $set_right_code);
					$led1['group_id'] = $sls_id;
					$led1['name'] = 'All Sales';
					$led1['left_code'] = '4913';
					$led1['right_code'] = $set_right_code;
					$led1['op_balance'] = '0';
					$led1['op_balance_dc'] = 'D';
					$led_ins1 = $this->db->table('ledgers')->insert($led1);
					$dr_id = $this->db->insertID();
				}
			}
			// Separate Ledger
			$ubayam_pay_details = $this->db->table('ubayam_pay_details')->where('ubayam_id', $ubayam_id)->get()->getResultArray();
			foreach ($ubayam_pay_details as $upd) {
				$cr_id = $payment_mode_details['ledger_id'];
				$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
				if (empty($number)) {
					$num = 1;
				} else {
					$num = $number['number'] + 1;
				}
				$date_y_m_d = date("Y-m-d", strtotime($upd['date']));
				$date = explode('-', $date_y_m_d);
				$yr = $date[0];
				$mon = $date[1];
				$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
				$entries['entry_code'] = 'REC' . date('y', strtotime($date_y_m_d)) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
				$entries['entrytype_id'] = '1';
				$entries['number'] = $num;
				$entries['date'] = date("Y-m-d", strtotime($upd['date']));
				$entries['dr_total'] = $upd['amount'];
				$entries['cr_total'] = $upd['amount'];
				$entries['narration'] = 'Ubayam(' . $ubayam['ref_no'] . ')' . "\n" . 'name:' . $ubayam['name'] . "\n" . 'NRIC:' . $ubayam['ic_number'] . "\n" . 'email:' . $ubayam['email'] . "\n";
				$entries['inv_id'] = $ubayam_id;
				$entries['type'] = '1';
				$ent = $this->db->table('entries')->insert($entries);
				$en_id = $this->db->insertID();

				if (!empty($en_id)) {
					$ent_id[] = $en_id;
					$eitems_d['entry_id'] = $en_id;
					$eitems_d['ledger_id'] = $dr_id;
					$eitems_d['amount'] = $upd['amount'];
					$eitems_d['details'] = 'Ubayam(' . $ubayam['ref_no'] . ')';
					$eitems_d['dc'] = 'C';
					$cr_res = $this->db->table('entryitems')->insert($eitems_d);

					$eitems_c['entry_id'] = $en_id;
					$eitems_c['ledger_id'] = $cr_id;
					$eitems_c['amount'] = $upd['amount'];
					$eitems_c['details'] = 'Ubayam(' . $ubayam['ref_no'] . ')';
					$eitems_c['dc'] = 'D';
					$deb_res = $this->db->table('entryitems')->insert($eitems_c);
					if ($cr_res && $deb_res)
						$succ++;
					else
						$err++;
				}
			}
		}
	}
	public function print_booking($ubayam_id)
	{

		$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $ubayam = $this->db->table('ubayam')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as uname')
			->select('ubayam.*')
			->where('ubayam.id', $id)
			->get()->getRowArray();
		// $view_file = 'frontend/ubayam/print_page';
		$view_file = 'frontend/ubayam/print_imin';
		if ($ubayam['paid_through'] == 'COUNTER') {
			if ($ubayam['payment_status'] == '2') {
				//$data['qry2'] = $this->db->table('ubayam_details')->where('ubayam_id', $id)->get()->getResultArray();
				//echo "<pre>"; print_r($id); exit();
				$tmpid = $this->session->get('profile_id');
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
				$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
				$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
				$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
				//echo $this->db->getLastQuery();
				//echo "<pre>"; print_r($data); exit();
				echo view($view_file, $data);
			} elseif ($ubayam['payment_status'] == '1') {
				$ubayam_payment_gateway_datas = $this->db->table('ubayam_payment_gateway_datas')->where('ubayam_id', $ubayam_id)->get()->getRowArray();
				if (!empty($ubayam_payment_gateway_datas['reference_id'])) {
					$reference_id = $ubayam_payment_gateway_datas['reference_id'];
					$result_data = $this->initiatePayment_response($reference_id);
					$response_data = json_decode($result_data, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['response_data'] = $result_data;
					$this->db->table('ubayam_payment_gateway_datas')->where('id', $ubayam_payment_gateway_datas['id'])->update($payment_gateway_up_data);
					if (!empty($response_data['status'])) {
						if ($response_data['status'] == 'completed') {
							$ubayam_up_data = array();
							$ubayam_up_data['payment_status'] = 2;
							$this->db->table('ubayam')->where('id', $id)->update($ubayam_up_data);
							$this->account_migration($id);
							$tmpid = $this->session->get('profile_id');
							$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
							$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
							$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
							$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
							echo view($view_file, $data);
						} else {
							$ubayam_up_data = array();
							$ubayam_up_data['payment_status'] = 3;
							$this->db->table('ubayam')->where('id', $id)->update($ubayam_up_data);
							redirect()->to("/cancelled_booking");
							exit;
						}
					}
				} else {
					redirect()->to("/cancelled_booking");
					exit;
				}
			}
		} else {
			$tmpid = 1;
			$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
			$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
			$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
			//echo $this->db->getLastQuery();
			//echo "<pre>"; print_r($data); exit();
			echo view($view_file, $data);
		}
	}
	public function get_booking_ubhayam()
	{
		$ubhayamdate = $_POST['ubhayamdate'];
		$ress = $this->db->table("ubayam")->select('ubayam.pay_for')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for', 'left')
			->where("ubayam.ubayam_date", $ubhayamdate)
			->get()->getResultArray();
		$ubhyams = array();
		foreach ($ress as $row) {
			$ubhyams[] = $row['pay_for'];
		}
		$ubhayam_bookings = $this->db->table('ubayam_setting')->where('ledger_id !=', '')->get()->getResultArray();
		$html = "";
		foreach ($ubhayam_bookings as $ubhayam_booking) {
			if (is_array($ubhyams) && in_array($ubhayam_booking['id'], $ubhyams)) {
				$checked = "checked";
				if ($ubhayam_booking['event_type'] == 1) {
					$disabled = "disabled";
					$style = "cursor: no-drop;";
					$onclick = "";
				} else {
					$disabled = "";
					$style = "";
					$onclick = "onclick='payfor(" . $ubhayam_booking['id'] . ")' ";
				}
			} else {
				$disabled = "";
				$checked = "";
				$style = "";
				$onclick = "onclick='payfor(" . $ubhayam_booking['id'] . ")' ";
			}

			if(empty($disabled)){
				$html .= '<li>
						<input type="radio" class="ubayam_slot" value="' . $ubhayam_booking['id'] . '" name="pay_for" id="pay_for' . $ubhayam_booking['id'] . '" ' . $disabled . ' />
						<label class="" for="pay_for' . $ubhayam_booking['id'] . '" ' . $onclick . ' >
                        <img class="img-fluid prod_img" src="' . base_url() . '/uploads/ubayam/' . $ubhayam_booking['image'] . '">
                        <div class="d-flex justify-content-between align-items-center mb-2 mt-2" style="flex-direction: column;">
                          <p class="mb-0 text-muted arch">' . $ubhayam_booking['name'] . '</p>
                        </div>
                      </labe>
                    </li>';
			}
			//$html.= '<li>
			//<label class="" for="pay_for'.$ubhayam_booking['id'].'" style="background:url('.base_url().'/uploads/ubayam/'.$ubhayam_booking['image'].') no-repeat; background-size: cover;" '.$onclick.' >
			//<div class="back" style="'.$style.'"><h5>'.$ubhayam_booking['name'].'</h5></div></label>
			//</li>';
		}
		echo $html;
	}
	public function get_payfor_collection()
	{
		$id = $_POST['id'];
		$res = $this->db->table('ubayam_setting')->where('id', $id)->get()->getRowArray();
		echo !empty($res['amount']) ? $res['amount'] : 0;
	}
	public function reprint_booking($id)
	{
		$data['qry1'] = $ubayam = $this->db->table('ubayam')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as uname')
			->select('ubayam.*')
			->where('ubayam.id', $id)
			->get()->getRowArray();
		// $view_file = 'frontend/ubayam/print_page';
		$view_file = 'frontend/ubayam/print_imin';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
		echo view($view_file, $data);
	}
	public function send_whatsapp_msg($id)
	{
		$data['qry1'] = $ubayam = $this->db->table('ubayam')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as uname')
			->select('ubayam.*')
			->where('ubayam.id', $id)
			->get()->getRowArray();
		$tmpid = 1;
		$data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
		if (!empty($ubayam['mobile'])) {
			$html = view('ubayam/pdf', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled' => true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/invoice_ubayam_' . $id . '.pdf';

			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$message_params[] = date('d M, Y', strtotime($ubayam['dt']));
			$message_params[] = date('h:i A', strtotime($ubayam['created_at']));
			$message_params[] = $ubayam['amount'];
			// $message_params[] = $ubayam['paidamount'];
			$message_params[] = $ubayam['balanceamount'];
			$media['url'] = base_url() . '/uploads/documents/invoice_ubayam_' . $id . '.pdf';
			$media['filename'] = 'ubayam_invoice.pdf';
			$mobile_number = $ubayam['mobile'];
			//$mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'ubayam_live', $media);
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





	public function print_imin($ubayam_id)
	{

		$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $ubayam = $this->db->table('ubayam')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as uname')
			->select('ubayam.*')
			->where('ubayam.id', $id)
			->get()->getRowArray();
		$view_file = 'frontend/ubayam/print_imin';
		if ($ubayam['paid_through'] == 'COUNTER') {
			if ($ubayam['payment_status'] == '2') {
				//$data['qry2'] = $this->db->table('ubayam_details')->where('ubayam_id', $id)->get()->getResultArray();
				//echo "<pre>"; print_r($id); exit();
				$tmpid = $this->session->get('profile_id');
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
				$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
				$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
				$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
				//echo $this->db->getLastQuery();
				//echo "<pre>"; print_r($data); exit();
				echo view($view_file, $data);
			} elseif ($ubayam['payment_status'] == '1') {
				$ubayam_payment_gateway_datas = $this->db->table('ubayam_payment_gateway_datas')->where('ubayam_id', $ubayam_id)->get()->getRowArray();
				if (!empty($ubayam_payment_gateway_datas['reference_id'])) {
					$reference_id = $ubayam_payment_gateway_datas['reference_id'];
					$result_data = $this->initiatePayment_response($reference_id);
					$response_data = json_decode($result_data, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['response_data'] = $result_data;
					$this->db->table('ubayam_payment_gateway_datas')->where('id', $ubayam_payment_gateway_datas['id'])->update($payment_gateway_up_data);
					if (!empty($response_data['status'])) {
						if ($response_data['status'] == 'completed') {
							$ubayam_up_data = array();
							$ubayam_up_data['payment_status'] = 2;
							$this->db->table('ubayam')->where('id', $id)->update($ubayam_up_data);
							$this->account_migration($id);
							$tmpid = $this->session->get('profile_id');
							$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
							$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
							$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
							$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
							echo view($view_file, $data);
						} else {
							$ubayam_up_data = array();
							$ubayam_up_data['payment_status'] = 3;
							$this->db->table('ubayam')->where('id', $id)->update($ubayam_up_data);
							redirect()->to("/cancelled_booking");
							exit;
						}
					}
				} else {
					redirect()->to("/cancelled_booking");
					exit;
				}
			}
		} else {
			$tmpid = 1;
			$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
			$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
			$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
			//echo $this->db->getLastQuery();
			//echo "<pre>"; print_r($data); exit();
			echo view($view_file, $data);
		}
	}

}
