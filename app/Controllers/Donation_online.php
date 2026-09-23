<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Donation_online extends BaseController
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
		exit;
		$data['list'] = $this->db->table('donation', 'donation_setting.name as pname')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->orderBy('date', 'DESC')
			->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/donation/index', $data);
		echo view('frontend/layout/footer');
	}
	public function add()
	{
		$login_id = $_SESSION['log_id_frend'];
		$default_group = $this->db->query("SELECT * FROM cashdonation_group ORDER BY id ASC LIMIT 1")->getRowArray();
		$data['default'] = str_replace(' ', '_', strtolower($default_group['name']));

		// Get all groups
		$group = $this->db->query("SELECT * FROM cashdonation_group ORDER BY name ASC")->getResultArray();

		// Initialize the sett_don array
		$data['sett_don'] = [];

		// Fetch donation settings for each group with non-empty ledger_id
		foreach ($group as $row) {
			$settings = $this->db->table('donation_setting')
				->where('groupname', $row['name'])
				->where('ledger_id !=', '')
				->get()
				->getResultArray();
			if (!empty($settings)) {
				$data['sett_don'][$row['name']] = $settings;
			}
		}

		// Fetch phone codes
		$data['phone_codes'] = $this->db->table("phone_code")
			->orderBy('dailing_code', 'ASC')
			->get()
			->getResultArray();

		// Fetch recent donations made by the current user
		$data['reprintlists'] = $this->db->query("
        SELECT id, amount, ref_no, date 
        FROM donation 
        WHERE added_by = '$login_id' 
        AND paid_through = 'COUNTER' 
        AND payment_status = 2 
        ORDER BY id DESC 
        LIMIT 3
    ")->getResultArray();

		// Render views
		echo view('frontend/layout/header');
		echo view('frontend/donation_new/index', $data);
		// echo view('frontend/layout/footer');
	}


	// Save function
	public function save()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['date']);
		$yr = $date[0];
		$mon = $date[1];
		$query = $this->db->query("SELECT ref_no FROM donation where id=(select max(id) from donation where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['ref_no'] = 'DO' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['date'] = $_POST['date'];
		$data['pay_for'] = trim($_POST['pay_for']);
		$data['name'] = trim($_POST['name']);
		$data['address'] = trim($_POST['address']);
		$data['ic_number'] = trim($_POST['ic_number']);
		$mble_phonecode = !empty ($_POST['phonecode']) ? $_POST['phonecode'] : "";
		$mble_number = !empty ($_POST['mobile']) ? $_POST['mobile'] : "";
		$pay_method = (!empty ($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
		switch ($pay_method) {
			case 'cash':
				$data['payment_status'] = 2;  // Confirmed status for any of these payment methods
				break;
			case 'qr':
				$data['payment_status'] = 2;  // Confirmed status for any of these payment methods
				break;
			case 'card':
				$data['payment_status'] = 2;  // Confirmed status for any of these payment methods
				break;
			default:
				$data['payment_status'] = 2;  // Optional: default case for unknown payment methods
		}
		$data['mobile'] = $mble_phonecode . $mble_number;
		$data['email'] = trim($_POST['email_id']);
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['total_amount']);
		$data['target_amount'] = 0;
		$data['collected_amount'] = 0;
		$data['paid_through'] = "COUNTER";
		// $data['payment_status'] = ($pay_method == 'cash' ? 2 : 1);
		$data['payment_status'] = 2;
		$data['added_by'] = $this->session->get('log_id_frend');
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');

		//ip location and ip details
		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$data['ip'] = $ip;
			$data['ip_location'] = (!empty ($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$data['ip_details'] = json_encode($ip_details);
		}


		// Proceed with saving data
		$this->db->table('donation')->insert($data);
		$ins_id = $this->db->insertID();
		$payment_gateway_data = array();
		$payment_gateway_data['donation_booking_id'] = $ins_id;
		$payment_gateway_data['pay_method'] = $pay_method;
		$this->db->table('donation_payment_gateway_datas')->insert($payment_gateway_data);
		$donation_payment_gateway_id = $this->db->insertID();



		if ($data['payment_status'] == 2) {
			$this->account_migration($ins_id);
			$this->send_whatsapp_msg($ins_id);
			$this->send_mail_to_customer($ins_id);
		}
		$this->session->setFlashdata('succ', 'Donation Added Successfully');
		$msg_data['succ'] = 'Donation Added Successfully';
		$msg_data['id'] = $ins_id;

		echo json_encode($msg_data);
		exit();
	}
	public function send_mail_to_customer($id)
	{
		$donation = $this->db->table("donation")->where("id", $id)->get()->getRowArray();
		if (!empty ($donation['email'])) {
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$temple_title = "Temple " . $temple_details['name'];
			$qr_url = base_url() . "/donation/reg/";
			$mail_data['qr_image'] = qrcode_generation($id, $qr_url);
			$mail_data['don_id'] = $id;
			$mail_data['temple_details'] = $temple_details;
			$message = view('donation/mail_template', $mail_data);
			$to = $donation['email'];
			$subject = $temple_details['name'] . " Cash Donation";
			$to_mail = array("prithivitest@gmail.com", $to);
			send_mail_with_content($to_mail, $message, $subject, $temple_title);
		}
	}
	public function payment_process($don_book_id)
	{
		$donation_booking = $this->db->table('donation')->where('id', $don_book_id)->get()->getRowArray();
		$donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $don_book_id)->get()->getResultArray();
		if (count($donation_payment_gateway_datas) > 0) {
			if ($donation_payment_gateway_datas[0]['pay_method'] == 'adyen') {
				if (!empty ($donation_payment_gateway_datas[0]['request_data'])) {
					$request_data = $donation_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				} else {
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($donation_booking['amount'], $don_book_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('donation_payment_gateway_datas')->where('id', $donation_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if (!empty ($response['url']) && !empty ($response['id'])) {
					header('Location: ' . $response['url']);
					exit;
				}
			}elseif($donation_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_qr'){
				//$view_file = 'frontend/ipay88/ipay_merch_qr';
				$view_file = 'frontend/ipay88/ipay_merch_qr_camera';
				$data['don_book_id'] = $don_book_id;
				$data['list'] = $this->db->table('payment_option')->where('status', 1)->get()->getResultArray();
				$data['submit_url'] = '/donation_online/initiate_ipay_merch_qr/' . $don_book_id;
				echo view($view_file, $data);
			}elseif($donation_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_online'){
				$view_file = 'frontend/ipay88/ipay_merch_online';
				$data['id'] = $don_book_id;
				$data['controller'] = 'donation_online';
				echo view($view_file, $data);
			} else {
				$redirect_url = base_url() . '/donation_online/print_booking/' . $don_book_id;
				header('Location: ' . $redirect_url);
				exit;
			}
		} else {
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$result = $this->initiatePayment($donation_booking['amount'], $don_book_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
			$response = json_decode($result, true);
			if (!empty ($response['url']) && !empty ($response['id'])) {
				$payment_gateway_data = array();
				$payment_gateway_data['donation_booking_id'] = $don_book_id;
				$payment_gateway_data['pay_method'] = 'adyen';
				$payment_gateway_data['request_data'] = $result;
				$payment_gateway_data['reference_id'] = $response['id'];
				$this->db->table('donation_payment_gateway_datas')->insert($payment_gateway_data);
				$donation_payment_gateway_id = $this->db->insertID();
				if (!empty ($donation_payment_gateway_id)) {
					header('Location: ' . $response['url']);
					exit;
				}
			}
		}
	}
	public function ipay88_online_response($donation_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$MerchantCode = 'M01236';
		$MerchantKey = 'HQgUUZLVzg';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$response = $ipay88->getResponse();
		//print_r($response);
		if($response['status']){
			$donation_up_data = array();
			$donation_up_data['payment_status'] = 2;
			$this->db->table('donation')->where('id', $donation_id)->update($donation_up_data);
			$this->account_migration($donation_id);
			$this->session->setFlashdata('succ', 'Donation Successfully Completed');
			$redirect_url = base_url() . '/archanai_booking/print_booking/' .$donation_id;
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$this->session->setFlashdata('fail', 'Payment Failed');
			echo'<script>
    window.onunload = refreshParent;
	window.close();
    function refreshParent() {
        window.opener.location.reload();
    }
</script>';
		}
	}
	public function initiate_ipay_merch_online($donation_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$donation_booking = $this->db->table('donation')->where('id', $donation_id)->get()->getRowArray();
		$email = !empty($donation_booking['email']) ? $donation_booking['email'] : 'dd@ipay88.com.my';
		$name = !empty($donation_booking['name']) ? $donation_booking['name'] : 'Prithivi';
		$mobile_no = !empty($donation_booking['mobile']) ? $donation_booking['mobile'] : '9856734562';
		$description='Donation';
		$final_amt = $donation_booking['amount'];
		$final_amount = number_format($final_amt, '2','.','');
		$final_amt_str = (string) ($final_amt * 1000);
		$MerchantCode = 'M01236';
		$MerchantKey = 'HQgUUZLVzg';
		$ref_no = 'DON_' . $donation_id;
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
		$ipay88->setField('UserContact', $mobile_no);
		$ipay88->setField('Remark', $description);
		$ipay88->setField('Lang', 'utf-8');
		$ipay88->setField('ResponseURL',  base_url() . '/donation_online/ipay88_online_response/' . $donation_id);
		$ipay88->setField('BackendURL',  base_url() . '/donation_online/ipay88_online_response/' . $donation_id);
		$ipay88->generateSignature();
		$ipay88_fields = $ipay88->getFields();
		$data['ipay88_fields'] = $ipay88_fields;
		$data['epayment_url'] = \Ipay88::$epayment_url;
		$view_file = 'frontend/ipay88/ipay_merch_online_process';
		echo view($view_file, $data);
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
			'returnUrl' => base_url() . '/donation_online/print_booking/' . $orderid,
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
	public function account_migration($donation_id)
	{
		$donation = $this->db->table('donation')->where('id', $donation_id)->get()->getRowArray();
		if ($donation['paid_through'] == 'COUNTER') {
			$donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $donation_id)->get()->getRowArray();
			if ($donation_payment_gateway_datas['pay_method'] == 'cash')
				$payment_id = 6; ////  goto cash Ledger
			elseif ($donation_payment_gateway_datas['pay_method'] == 'online')
				$payment_id = 7; ////  goto online Ledger
			elseif ($donation_payment_gateway_datas['pay_method'] == 'qr')
				$payment_id = 13; ////  goto qr Ledger
			elseif ($donation_payment_gateway_datas['pay_method'] == 'card')
				$payment_id = 12; ////  goto nets Ledger
			
			elseif ($donation_payment_gateway_datas['pay_method'] == 'cheque')
				$payment_id = 11; ////  goto Cheque Ledger
			else
				$payment_id = 4; ////  goto Qr or Online Payment Ledger
			$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			if (empty ($payment_mode_details['id']))
				$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			
			/* $ledger = $this->db->table('ledgers')->where('name', 'Donation')->where('group_id', 29)->where('left_code', '7012')->get()->getRowArray();
			if (!empty ($ledger)) {
				$dr_id = $ledger['id'];
			} else {
				$led['group_id'] = 29;
				$led['name'] = 'Donation';
				$led['left_code'] = '7012';
				$led['right_code'] = '000';
				$led['op_balance'] = '0';
				$led['op_balance_dc'] = 'D';
				$led_ins = $this->db->table('ledgers')->insert($led);
				$dr_id = $this->db->insertID();
			} */
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
			$donation_details = $this->db->table('donation_setting')->where('id', $donation['pay_for'])->get()->getRowArray();
			if(!empty($donation_details['ledger_id'])){
				$dr_id = $donation_details['ledger_id'];
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
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty ($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$date = explode('-', $donation['date']);
			$yr = $date[0];
			$mon = $date[1];
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'REC' . date('y', strtotime($donation['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));

			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = $donation['date'];
			$entries['dr_total'] = $donation['amount'];
			$entries['cr_total'] = $donation['amount'];
			$entries['narration'] = 'Cash Donation(' . $donation['ref_no'] . ')' . "\n" . 'name:' . $donation['name'] . "\n" . 'NRIC:' . $donation['ic_number'] . "\n" . 'email:' . $donation['email'] . "\n";
			$entries['inv_id'] = $donation_id;
			$entries['type'] = '2';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty ($en_id)) {
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $donation['amount'];
				$eitems_d['details'] = 'Cash Donation(' . $donation['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['details'] = 'Cash Donation(' . $donation['ref_no'] . ')';
				$eitems_c['amount'] = $donation['amount'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
			}
		}
	}
	public function print_booking($don_book_id)
	{

		$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $donation = $this->db->table('donation')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->where('donation.id', $id)
			->get()->getRowArray();
		// $view_file = 'frontend/donation/print_page';
		$view_file = 'frontend/donation/print_imin';
		if ($donation['paid_through'] == 'COUNTER') {
			if ($donation['payment_status'] == '2') {
				//$data['qry2'] = $this->db->table('donation_details')->where('donation_id', $id)->get()->getResultArray();
				//echo "<pre>"; print_r($id); exit();
				$tmpid = $this->session->get('profile_id');
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
				$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
				//echo $this->db->getLastQuery();
				//echo "<pre>"; print_r($data); exit();
				echo view($view_file, $data);
			} elseif ($donation['payment_status'] == '1') {
				$donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $don_book_id)->get()->getRowArray();
				if (!empty ($donation_payment_gateway_datas['reference_id'])) {
					$reference_id = $donation_payment_gateway_datas['reference_id'];
					$result_data = $this->initiatePayment_response($reference_id);
					$response_data = json_decode($result_data, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['response_data'] = $result_data;
					$this->db->table('donation_payment_gateway_datas')->where('id', $donation_payment_gateway_datas['id'])->update($payment_gateway_up_data);
					if (!empty ($response_data['status'])) {
						if ($response_data['status'] == 'completed') {
							$donation_up_data = array();
							$donation_up_data['payment_status'] = 2;
							$this->db->table('donation')->where('id', $id)->update($donation_up_data);
							$this->account_migration($id);
							$tmpid = $this->session->get('profile_id');
							$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
							$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
							echo view($view_file, $data);
						} else {
							$donation_up_data = array();
							$donation_up_data['payment_status'] = 3;
							$this->db->table('donation')->where('id', $id)->update($donation_up_data);
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
			//echo $this->db->getLastQuery();
			//echo "<pre>"; print_r($data); exit();
			echo view($view_file, $data);
		}
	}

	public function print_report($don_book_id)
	{
		$id = $this->request->uri->getSegment(3);
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['data'] = $this->db->table('donation')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname, donation.amount, donation.name, donation.mobile')
			->select('donation.*')
			->where('donation.id', $id)
			->get()->getRowArray();

			// print_r($data['data']);
			// exit;
		echo view('frontend/donation/print_report', $data);
	}
	public function get_donation_amount()
	{
		$id = $_POST['id'];
		$res = $this->db->table('donation_setting')->where('id', $id)->get()->getRowArray();
		echo !empty ($res['amount']) ? $res['amount'] : 0;
	}
	public function reprint_booking($id)
	{
		$data['qry1'] = $donation = $this->db->table('donation')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->where('donation.id', $id)
			->get()->getRowArray();
		// $view_file = 'frontend/donation/print_page';
		$view_file = 'frontend/donation/print_imin';
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		echo view($view_file, $data);
	}
	public function send_whatsapp_msg($id)
	{
		$data['qry1'] = $donation = $this->db->table('donation')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->where('donation.id', $id)
			->get()->getRowArray();
		$tmpid = 1;
		$data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		if (!empty ($donation['mobile'])) {
			$html = view('donation/pdf', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled' => true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/invoice_donation_' . $id . '.pdf';

			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			/* $message_params[] = date('d M, Y', strtotime($donation['dt']));
									   $message_params[] = date('h:i A', strtotime($donation['created_at']));
									   $message_params[] = $donation['amount'];
									   // $message_params[] = $ubayam['paidamount'];
									   $message_params[] = $donation['balanceamount']; */
			$media['url'] = base_url() . '/uploads/documents/invoice_donation_' . $id . '.pdf';
			$media['filename'] = 'donation_invoice.pdf';
			$mobile_number = $donation['mobile'];
			//$mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'donation_live', $media);
			// print_r($whatsapp_resp);
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
