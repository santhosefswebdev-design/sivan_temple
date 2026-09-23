<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class IpayOnlineCemetery extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
        $this->model = new PermissionModel();
    }
	public function ipay88_online_response($cemetery_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$MerchantCode = 'M01230';
		$MerchantKey = 'HQgUUZLVzg';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$response = $ipay88->getResponse();
		//print_r($response);
		if($response['status']){
			$cemetery_up_data = array();
			$cemetery_up_data['payment_status'] = 2;
			$this->db->table('cemetery')->where('id', $cemetery_id)->update($cemetery_up_data);
			$this->account_migration($cemetery_id);
			$this->session->setFlashdata('succ', 'Cemetery Registration Successfull');
			$redirect_url = base_url() . '/IpayOnlineCemetery/payment_success/';
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/IpayOnlineCemetery/payment_failed/';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function initiate_ipay_merch_online($cemetery_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$email = 'dd@ipay88.com.my';
		$description='Archanai';
		$final_amt = $cemetery['amount'];
		$MerchantCode = 'M01230';
		$MerchantKey = 'HQgUUZLVzg';
		$ref_no = 'Hall_' . $cemetery_id;
		$refno_pay = $ref_no;
		$module = 'archanai';
		$final_amount = '1.00';
		$final_amt_str = '10000';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$ipay88->setField('PaymentId', 6);
		$ipay88->setField('RefNo', $refno_pay);
		$ipay88->setField('Amount', $final_amount);
		$ipay88->setField('Currency', 'MYR');
		$ipay88->setField('ProdDesc', $description);
		$ipay88->setField('UserName', 'Prithivi');
		$ipay88->setField('UserEmail', $email);
		$ipay88->setField('UserContact', '9856734562');
		$ipay88->setField('Remark', $description);
		$ipay88->setField('Lang', 'utf-8');
		$ipay88->setField('ResponseURL',  base_url() . '/IpayOnlineCemetery/ipay88_online_response/' . $cemetery_id);
		$ipay88->setField('BackendURL',  base_url() . '/IpayOnlineCemetery/ipay88_online_response/' . $cemetery_id);
		$ipay88->generateSignature();
		$ipay88_fields = $ipay88->getFields();
		$data['ipay88_fields'] = $ipay88_fields;
		$data['epayment_url'] = \Ipay88::$epayment_url;
		$view_file = 'front_user/ipay88/ipay_merch_online_process';
		echo view($view_file, $data);
	}
	public function payment_process($cemetery_id) {
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$cemetery_payment_gateway_datas = $this->db->table('cemetery_payment_gateway_datas')->where('cemetery_id', $cemetery_id)->get()->getResultArray();
		if(count($cemetery_payment_gateway_datas) > 0){
			if($cemetery_payment_gateway_datas[0]['pay_method'] == 'adyen'){
				if(!empty($cemetery_payment_gateway_datas[0]['request_data'])){
					$request_data = $cemetery_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				}else{
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($cemetery['amount'],$cemetery_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('cemetery_payment_gateway_datas')->where('id', $cemetery_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if(!empty($response['url']) && !empty($response['id'])){
					header('Location: ' . $response['url']);
					exit;
				}
			}elseif($cemetery_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_online'){
					$view_file = 'front_user/ipay88/ipay_merch_online';
					$data['cemetery_id'] = $cemetery_id;
					$data['submit_url'] = '/IpayOnlineCemetery/initiate_ipay_merch_online/' . $cemetery_id;
					echo view($view_file, $data);
			}else{
				$cemetery_up_data = array();
				$cemetery_up_data['payment_status'] = 2;
				$this->db->table('cemetery')->where('id', $cemetery_id)->update($cemetery_up_data);
				$this->account_migration($cemetery_id);
				$this->session->setFlashdata('succ', 'Cemetery Registration Successfull');
				$redirect_url = base_url() . '/cemeteryreg/list/';
				header('Location: ' . $redirect_url);
				exit;
			}
		}else{
			/* $payment_gateway_data = array();
			$payment_gateway_data['cemetery_id'] = $cemetery_id;
			$payment_gateway_data['pay_method'] = 'ipay_merch_online';
			$this->db->table('cemetery_payment_gateway_datas')->insert($payment_gateway_data);
			$view_file = 'front_user/ipay88/ipay_merch_online';
			$data['cemetery_id'] = $cemetery_id;
			$data['submit_url'] = '/IpayOnlineCemetery/initiate_ipay_merch_online/' . $cemetery_id;
			echo view($view_file, $data); */
			$payment_gateway_data = array();
			$payment_gateway_data['cemetery_id'] = $cemetery_id;
			$payment_gateway_data['pay_method'] = 'cash';
			$this->db->table('cemetery_payment_gateway_datas')->insert($payment_gateway_data);
			$cemetery_up_data = array();
			$cemetery_up_data['payment_status'] = 2;
			$this->db->table('cemetery')->where('id', $cemetery_id)->update($cemetery_up_data);
			$this->account_migration($cemetery_id);
			$this->session->setFlashdata('succ', 'Cemetery Registration Successfull');
			$redirect_url = base_url() . '/cemeteryreg/list/';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function ipay88_online_response1($cemetery_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$MerchantCode = 'M01230';
		$MerchantKey = 'HQgUUZLVzg';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$response = $ipay88->getResponse();
		//print_r($response);
		if($response['status']){
			$cemetery_up_data = array();
			$cemetery_up_data['payment_status'] = 2;
			$this->db->table('cemetery')->where('id', $cemetery_id)->update($cemetery_up_data);
			$this->account_migration($cemetery_id);
			$this->session->setFlashdata('succ', 'Cemetery Registration Successfull');
			$redirect_url = base_url() . '/cemeteryreg/list/';
			header('Location: ' . $redirect_url);
			exit;
		}else{
			$this->session->setFlashdata('fail', 'Payment Failed');
			$redirect_url = base_url() . '/cemeteryreg/list/';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function initiate_ipay_merch_online1($cemetery_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$cemetery_fee_details = $this->db->table('cemetery_fee_details')->where('cemetery_id', $cemetery_id)->get()->getResultArray();
		$email = 'dd@ipay88.com.my';
		$description='Archanai';
		$final_amt = $cemetery['amount'];
		$MerchantCode = 'M01230';
		$MerchantKey = 'HQgUUZLVzg';
		$ref_no = 'Hall_' . $cemetery_id;
		$refno_pay = $ref_no;
		$module = 'archanai';
		$final_amount = '1.00';
		$final_amt_str = '10000';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$ipay88->setField('PaymentId', 6);
		$ipay88->setField('RefNo', $refno_pay);
		$ipay88->setField('Amount', $final_amount);
		$ipay88->setField('Currency', 'MYR');
		$ipay88->setField('ProdDesc', $description);
		$ipay88->setField('UserName', 'Prithivi');
		$ipay88->setField('UserEmail', $email);
		$ipay88->setField('UserContact', '9856734562');
		$ipay88->setField('Remark', $description);
		$ipay88->setField('Lang', 'utf-8');
		$ipay88->setField('ResponseURL',  base_url() . '/IpayOnlineCemetery/ipay88_online_response1/' . $cemetery_id);
		$ipay88->setField('BackendURL',  base_url() . '/IpayOnlineCemetery/ipay88_online_response1/' . $cemetery_id);
		$ipay88->generateSignature();
		$ipay88_fields = $ipay88->getFields();
		$data['ipay88_fields'] = $ipay88_fields;
		$data['epayment_url'] = \Ipay88::$epayment_url;
		$view_file = 'front_user/ipay88/ipay_merch_online_process';
		echo view($view_file, $data);
	}
	public function payment_process1($cemetery_id) {
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$cemetery_payment_gateway_datas = $this->db->table('cemetery_payment_gateway_datas')->where('cemetery_id', $cemetery_id)->get()->getResultArray();
		if(count($cemetery_payment_gateway_datas) > 0){
			if($cemetery_payment_gateway_datas[0]['pay_method'] == 'adyen'){
				if(!empty($cemetery_payment_gateway_datas[0]['request_data'])){
					$request_data = $cemetery_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				}else{
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($cemetery['amount'],$cemetery_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('cemetery_payment_gateway_datas')->where('id', $cemetery_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if(!empty($response['url']) && !empty($response['id'])){
					header('Location: ' . $response['url']);
					exit;
				}
			}elseif($cemetery_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_online'){
					$view_file = 'front_user/ipay88/ipay_merch_online';
					$data['cemetery_id'] = $cemetery_id;
					$data['submit_url'] = '/IpayOnlineCemetery/initiate_ipay_merch_online1/' . $cemetery_id;
					echo view($view_file, $data);
			}else{
				$cemetery_up_data = array();
				$cemetery_up_data['payment_status'] = 2;
				$this->db->table('cemetery')->where('id', $cemetery_id)->update($cemetery_up_data);
				$this->account_migration($cemetery_id);
				$this->session->setFlashdata('succ', 'Cemetery Registration Successfull');
				$redirect_url = base_url() . '/cemeteryreg/list/';
				header('Location: ' . $redirect_url);
				exit;
			}
		}else{
			/* $payment_gateway_data = array();
			$payment_gateway_data['cemetery_id'] = $cemetery_id;
			$payment_gateway_data['pay_method'] = 'ipay_merch_online';
			$this->db->table('cemetery_payment_gateway_datas')->insert($payment_gateway_data);
			$view_file = 'front_user/ipay88/ipay_merch_online';
			$data['cemetery_id'] = $cemetery_id;
			$data['submit_url'] = '/IpayOnlineCemetery/initiate_ipay_merch_online/' . $cemetery_id;
			echo view($view_file, $data); */
			$payment_gateway_data = array();
			$payment_gateway_data['cemetery_id'] = $cemetery_id;
			$payment_gateway_data['pay_method'] = 'cash';
			$this->db->table('cemetery_payment_gateway_datas')->insert($payment_gateway_data);
			$cemetery_up_data = array();
			$cemetery_up_data['payment_status'] = 2;
			$this->db->table('cemetery')->where('id', $cemetery_id)->update($cemetery_up_data);
			$this->account_migration($cemetery_id);
			$this->session->setFlashdata('succ', 'Cemetery Registration Successfull');
			$redirect_url = base_url() . '/cemeteryreg/list/';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function account_migration($cemetery_id){
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$cemetery_fee_details = $this->db->table('cemetery_fee_details')->where('cemetery_id', $cemetery_id)->get()->getResultArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', 3)->get()->getRowArray();
		if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
		$total_amount = 0;
		$cemetery_overtime_fee = !empty($cemetery['overtime_fee']) ? (float) $cemetery['overtime_fee'] : 0;
		$total_amount += $cemetery_overtime_fee;
		if(count($cemetery_fee_details)){
			foreach($cemetery_fee_details as $cfd) $total_amount += (float) $cfd['fee_amount'];
		}
		if($total_amount > 0){
			$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr= date('Y',strtotime($cemetery['date'])) ;
			$mon= date('m',strtotime($cemetery['date'])) ;
			$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
			$entries['entry_code'] = 'REC' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] 		 = $num;
			$entries['date'] 		 = $cemetery['date'];		
			$entries['dr_total'] 	 = $total_amount;
			$entries['cr_total'] 	 = $total_amount;	
			$entries['narration'] 	 = 'Cemetery Registration';
			$entries['inv_id']		 = $cemetery_id;
			$entries['type']		 = '13';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			$eitems_d = array();
			$eitems_d['entry_id'] = $en_id;
			$eitems_d['ledger_id'] = $payment_mode_details['ledger_id'];
			$eitems_d['amount'] = $total_amount;
			$eitems_d['dc'] = 'D';
			$this->db->table('entryitems')->insert($eitems_d);
			$ledger1 = $this->db->table('ledgers')->where('name', 'BURIAL')->where('group_id', 29)->where('left_code', '7014')->get()->getRowArray();
			if(!empty($ledger1)){
				$cr_id = $ledger1['id'];
			}else{
				$led1['group_id'] = 29;
				$led1['name'] = 'BURIAL';
				$led1['code'] = '7014/005';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led1['left_code'] = '7014';
				$led1['right_code'] = '005';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$cr_id = $this->db->insertID();
			}
			if($cemetery_overtime_fee > 0){
				$eitems_c = array();
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = $cemetery_overtime_fee;
				$eitems_c['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_c);
			}
			foreach($cemetery_fee_details as $cfd){
				$eitems_c = array();
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = (float) $cfd['fee_amount'];
				$eitems_c['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_c);
			}
		}
	}
	public function payment_success(){
		echo view('frontend/cemetery/payment_success');
	}
	
	public function payment_failed(){
		echo view('frontend/cemetery/payment_failed');
	}
}
