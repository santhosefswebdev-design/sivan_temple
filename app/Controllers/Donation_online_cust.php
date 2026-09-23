<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Donation_online_cust extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('log_id_frend') ) == false ){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/customer_login');
            exit;
		}
    }
    public function index(){
		exit;
        $data['list'] = $this->db->table('donation', 'donation_setting.name as pname')
					->join('donation_setting', 'donation_setting.id = donation.pay_for')
					->select('donation_setting.name as pname')
					->select('donation.*')
					->orderBy('date', 'DESC')
					->get()->getResultArray();
		echo view('front_user/layout/header');
		echo view('front_user/donation/index', $data);
		echo view('front_user/layout/footer');
    }
	public function add()
	{
		$login_id = $_SESSION['log_id_frend'];
		$data['sett_don'] = $this->db->table('donation_setting')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['reprintlists'] = $this->db->query("SELECT id,amount,ref_no,date FROM donation WHERE added_by = '".$login_id."' and paid_through = 'ONLINE' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
		echo view('front_user/layout/header');
		echo view('front_user/donation_new/index', $data);
		//echo view('front_user/layout/footer');
	}
	public function save(){
        //$id = $_POST['id'];
        //echo '<pre>';
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['date']);
		$yr = $date[0];
  		$mon = $date[1];
		$query   = $this->db->query("SELECT ref_no FROM donation where id=(select max(id) from donation where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
		$data['ref_no']= 'DO' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$data['date']		 =	$_POST['date'];
		$data['pay_for']	 =	trim($_POST['pay_for']);
		$data['name']		 =	trim($_POST['name']);
		$data['address']	 =	trim($_POST['address']);
		$data['ic_number']	 =	trim($_POST['ic_number']);
		$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
      	$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
		$pay_method       =	(!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
		$data['mobile']  = $mble_phonecode.$mble_number;
		$data['email']		 =	trim($_POST['email_id']);
		$data['description'] =	trim($_POST['description']);
		$data['amount']		 =	trim($_POST['total_amount']);
		$data['target_amount'] =	0;
		$data['collected_amount'] =	0;
		$data['paid_through'] = "ONLINE";
		$data['payment_status'] =   ($pay_method == 'cash' ? 2: 1);
		$data['added_by']	 =	$this->session->get('log_id_frend');
		$data['created']  =	date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$this->db->table('donation')->insert($data);
		$ins_id = $this->db->insertID();
		$payment_gateway_data = array();
		$payment_gateway_data['donation_booking_id'] = $ins_id;
		$payment_gateway_data['pay_method'] = $pay_method;
		$this->db->table('donation_payment_gateway_datas')->insert($payment_gateway_data);
		$donation_payment_gateway_id = $this->db->insertID();
		if($data['payment_status'] == 2) $this->account_migration($ins_id);
		if(!empty($_POST['email_id']))
		{
			$temple_title = "Temple ".$_SESSION['site_title'];
			$qr_url = base_url()."/donation_online/reg/";
            $mail_data['qr_image'] = qrcode_generation($ins_id,$qr_url);
			$mail_data['don_id'] = $ins_id;
			$message =  view('donation/mail_template',$mail_data);
			$subject = $_SESSION['site_title']." Cash Donation";
			$to_user = $_POST['email_id'];
			$to_mail = array("prithivitest@gmail.com",$to_user);
			send_mail_with_content($to_mail,$message,$subject,$temple_title);
		}
		$this->session->setFlashdata('succ', 'Donation Added Successflly');
		$msg_data['succ'] = 'Donation Added Successflly';
		$msg_data['id'] = $ins_id;
		echo json_encode($msg_data);
		exit();
	}
	public function payment_process($don_book_id) {
		$donation_booking = $this->db->table('donation')->where('id', $don_book_id)->get()->getRowArray();
		$donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $don_book_id)->get()->getResultArray();
		if(count($donation_payment_gateway_datas) > 0){
			if($donation_payment_gateway_datas[0]['pay_method'] == 'adyen'){
				if(!empty($donation_payment_gateway_datas[0]['request_data'])){
					$request_data = $donation_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				}else{
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($donation_booking['amount'],$don_book_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('donation_payment_gateway_datas')->where('id', $donation_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if(!empty($response['url']) && !empty($response['id'])){
					header('Location: ' . $response['url']);
					exit;
				}
			}else{
				$redirect_url = base_url() . '/donation_online/print_booking/' .$don_book_id;
				header('Location: ' . $redirect_url);
				exit;
			}
		}else{
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$result = $this->initiatePayment($donation_booking['amount'],$don_book_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
			$response = json_decode($result, true);
			if(!empty($response['url']) && !empty($response['id'])){
				$payment_gateway_data = array();
				$payment_gateway_data['donation_booking_id'] = $don_book_id;
				$payment_gateway_data['pay_method'] = 'adyen';
				$payment_gateway_data['request_data'] = $result;
				$payment_gateway_data['reference_id'] = $response['id'];
				$this->db->table('donation_payment_gateway_datas')->insert($payment_gateway_data);
				$donation_payment_gateway_id = $this->db->insertID();
				if(!empty($donation_payment_gateway_id)){
					header('Location: ' . $response['url']);
					exit;
				}
			}
		}
	}
	public function initiatePayment($amount,$orderid,$address,$city,$email) {
		if(file_get_contents('php://input') != '') {
			$request = json_decode(file_get_contents('php://input'), true);
		}else{
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
			"reference"=> $orderid,
			'countryCode' => "MY",
			'shopperReference' => "order_".$orderid,
			'shopperEmail' => $email,
			'shopperLocale' => "en-US",
			"billingAddress" => [
				"street"=>$address,
				"postalCode"=> "46000",
				"city"=> $city,
				"houseNumberOrName"=> "1/23",
				"country"=> "MY",
				"stateOrProvince"=> "KL"
			],
			"deliveryAddress" => [
				"street"=> $address,
				"postalCode"=> "46000",
				"city"=> $city,
				"houseNumberOrName"=> "1/23",
				"country"=> "MY",
				"stateOrProvince"=> "KL"
			],
			'returnUrl' => base_url() . '/donation_online/print_booking/' .$orderid,
			'merchantAccount' => $merchantAccount
		];
		$json_data = json_encode($data);
		$curlAPICall = curl_init();
		curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, $json_data);
		curl_setopt($curlAPICall, CURLOPT_URL, $url);
		curl_setopt($curlAPICall, CURLOPT_HTTPHEADER,
			array(
				"x-api-key: " . $apikey,
				"Content-Type: application/json",
				"Content-Length: " . strlen($json_data)
			)
		);
		$result = curl_exec($curlAPICall);
		if($result === false){
			throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
		}
		curl_close($curlAPICall);
		return $result;
    }
	public function initiatePayment_response($pay_id) {
		if(file_get_contents('php://input') != '') {
			$request = json_decode(file_get_contents('php://input'), true);
		}else{
			$request = array();
		}
		$apikey = "AQExhmfuXNWTK0Qc+iSGm3I5puqPTYhFHpxGTXFfyXa4nWlGJfnh+XuzwV6dTmmMJv6GnBDBXVsNvuR83LVYjEgiTGAH-09p02SzaBtpvbU0D3ZRFu8cWY44ivj4mqeMXogk0Ogk=-@e*vZIt9AWvaNN:.";
		$merchantAccount = "VivaantechsolutionscomECOM";
		$url = "https://checkout-test.adyen.com/v70/paymentLinks/".$pay_id;
		$curlAPICall = curl_init();
		curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlAPICall, CURLOPT_URL, $url);
		// Api key
		curl_setopt($curlAPICall, CURLOPT_HTTPHEADER,
			array(
				"x-api-key: " . $apikey
			)
		);
		$result = curl_exec($curlAPICall);
		if($result === false){
			throw new Exception(curl_error($curlAPICall), curl_errno($curlAPICall));
		}
		curl_close($curlAPICall);
		return $result;
    }
	public function account_migration($donation_id){
		$donation = $this->db->table('donation')->where('id', $donation_id)->get()->getRowArray();
		 if($donation['paid_through'] == 'ONLINE'){
			 $donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $donation_id)->get()->getRowArray();
			 if($donation_payment_gateway_datas['pay_method'] == 'cash') $payment_id = 6; ////  goto cash Ledger
			 else $payment_id = 5; ////  goto Qr or Online Payment Ledger
			 $payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			$ledger = $this->db->table('ledgers')->where('name', 'Donation')->where('group_id', 29)->where('left_code', '7012')->get()->getRowArray();
			if(!empty($ledger)){
				$dr_id = $ledger['id'];
			}else{
				$led['group_id'] = 29;
				$led['name'] = 'Donation';
				$led['left_code'] = '7012';
				$led['right_code'] = '000';
				$led['op_balance'] = '0';
				$led['op_balance_dc'] = 'D';
				$led_ins = $this->db->table('ledgers')->insert($led);
				$dr_id = $this->db->insertID();
			}
			$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr = $donation['date'][0];
			$mon = $donation['date'][1];
			$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
			$entries['entry_code'] = 'REC' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
		
			$entries['entrytype_id'] = '1';
			$entries['number'] 		 = $num;
			$entries['date'] 		 = $donation['date']; 
			$entries['dr_total'] 	 = $donation['amount'];
			$entries['cr_total'] 	 = $donation['amount'];
			$entries['narration'] 	 = 'Cash Donation(' . $donation['ref_no'] . ')' . "\n" . 'name:' . $donation['name'] . "\n" . 'NRIC:' . $donation['ic_number'] . "\n" . 'email:' . $donation['email'] . "\n";
			$entries['inv_id']       = $donation_id;
			$entries['type']         = '2';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if(!empty($en_id)){
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $donation['amount'];
				$eitems_d['details'] 	 = 'Cash Donation(' . $donation['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['details'] 	 = 'Cash Donation(' . $donation['ref_no'] . ')';
				$eitems_c['amount'] = $donation['amount'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
			}
		 }
	}
	public function print_booking($don_book_id){
		 
	 	$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $donation = $this->db->table('donation')
						->join('donation_setting', 'donation_setting.id = donation.pay_for')
						->select('donation_setting.name as pname')
						->select('donation.*')
						->where('donation.id', $id)
						->get()->getRowArray();
		$view_file = 'front_user/donation/print_page';
		if($donation['paid_through'] == 'ONLINE'){
			if($donation['payment_status'] == '2'){
				//$data['qry2'] = $this->db->table('donation_details')->where('donation_id', $id)->get()->getResultArray();
				//echo "<pre>"; print_r($id); exit();
				$tmpid = $this->session->get('profile_id');
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
				$data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
							//echo $this->db->getLastQuery();
				//echo "<pre>"; print_r($data); exit();
				echo view($view_file, $data);
			}elseif($donation['payment_status'] == '1'){
				$donation_payment_gateway_datas = $this->db->table('donation_payment_gateway_datas')->where('donation_booking_id', $don_book_id)->get()->getRowArray();
				if(!empty($donation_payment_gateway_datas['reference_id'])){
					$reference_id = $donation_payment_gateway_datas['reference_id'];
					$result_data = $this->initiatePayment_response($reference_id);
					$response_data = json_decode($result_data, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['response_data'] = $result_data;
					$this->db->table('donation_payment_gateway_datas')->where('id', $donation_payment_gateway_datas['id'])->update($payment_gateway_up_data);
					if(!empty($response_data['status'])){
						if($response_data['status'] == 'completed'){
							$donation_up_data = array();
							$donation_up_data['payment_status'] = 2;
							$this->db->table('donation')->where('id', $id)->update($donation_up_data);
							$this->account_migration($id);
							$tmpid = $this->session->get('profile_id');
							$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
							$data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
							echo view($view_file, $data);
						}else{
							$donation_up_data = array();
							$donation_up_data['payment_status'] = 3;
							$this->db->table('donation')->where('id', $id)->update($donation_up_data);
							redirect()->to("/cancelled_booking");
							exit;
						}
					}
				}else{
					redirect()->to("/cancelled_booking");
					exit;
				}
			}
		}else{
			$tmpid = $this->session->get('profile_id');
			$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			//echo $this->db->getLastQuery();
			//echo "<pre>"; print_r($data); exit();
			echo view($view_file, $data);
		}
	 }
	public function get_donation_amount(){
		$id = $_POST['id'];
		$res = $this->db->table('donation_setting')->where('id', $id)->get()->getRowArray();
		echo !empty($res['amount']) ? $res['amount'] : 0;
	}
	public function reprint_booking($id) {
		$data['qry1'] = $donation = $this->db->table('donation')
						->join('donation_setting', 'donation_setting.id = donation.pay_for')
						->select('donation_setting.name as pname')
						->select('donation.*')
						->where('donation.id', $id)
						->get()->getRowArray();
		$view_file = 'front_user/donation/print_page';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
		echo view($view_file, $data);
	}
}
