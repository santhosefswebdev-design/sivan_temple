<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Archanai_booking_cust extends BaseController
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
	
	public function index_old(){
      $login_id = $_SESSION['log_id_frend'];
	  $data['permission'] = $this->model->get_permission('archanai_ticket');
	  $data['staff'] = $this->db->table('staff')->get()->getResultArray();
	  $data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
	  $data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
	  $group = $this->db->query("SELECT * FROM archanai_group order by name asc")->getResultArray();
	  $data['archanai'][''] = $this->db->table('archanai')->where('groupname', '')->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
	  foreach($group as $row){ 
			$data['archanai'][$row['name']] = $this->db->table('archanai')->where('groupname', $row['name'])->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
	  }
      //$data['data'] = $this->db->table('archanai')->get()->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();

      $data['bill_no']= 'AR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
	  
	  echo view('front_user/layout/header');
      //echo view('template/sidebar');
      echo view('front_user/archanai/index', $data);
      echo view('front_user/layout/footer');
    }
    
    
    public function index(){
      $login_id = $_SESSION['log_id_frend'];
	  //var_dump($login_id);
	  //exit;
	  /* if(!$this->model->list_validate('archanai_ticket')){
			header('Location: '.base_url().'/dashboard');
		} */
	  $data['permission'] = $this->model->get_permission('archanai_ticket');
	  $data['staff'] = $this->db->table('staff')->get()->getResultArray();
	  $data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
	  $data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
	  $group = $this->db->query("SELECT * FROM archanai_group order by name asc")->getResultArray();
	  $data['archanai'][''] = $this->db->table('archanai')->where('groupname', '')->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
	  foreach($group as $row){ 
			$data['archanai'][$row['name']] = $this->db->table('archanai')->where('groupname', $row['name'])->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
	  }
      //$data['data'] = $this->db->table('archanai')->get()->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();

      $data['bill_no']= 'AR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
	  $data['default'] = "archanai";
	  $data['reprintlists'] = $this->db->query("SELECT id,amount,ref_no,date FROM archanai_booking WHERE entry_by = '".$login_id."' and paid_through = 'ONLINE' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();
	  echo view('front_user/layout/header');
      echo view('front_user/archanai_new/index', $data);
    }
	public function get_natchathram() {
	    $rasi_id = $_POST['rasi_id'];
		$res = $this->db->table('rasi')->where('id',$rasi_id)->get()->getRowArray();
		if(!empty($res['natchathra_id']))
		{
			$data = array("natchathra_id"=>$res['natchathra_id'], "rasi_id"=>$res['rasi_id']);
		}
		else
		{
			$res_natchathrams =  $this->db->table('natchathram')->get()->getResultArray();
			$data_bf = array();
			foreach($res_natchathrams as $res_natchathram)
			{
				$data_bf[] = $res_natchathram['id'];
			}
			$dataip = implode(',', $data_bf);
			$data = array("natchathra_id"=>$dataip, "rasi_id"=>$res['rasi_id']);
		}
		echo json_encode($data);
		exit;
	}
	public function get_natchathram_name() {
	    $id = $_POST['id'];
		$res =  $this->db->table('natchathram')->where('id',$id)->get()->getRowArray();
		$data = array("id"=>$res['id'], "name_eng"=>$res['name_eng']);
		echo json_encode($data);
		exit;
	}
	
    public function save(){
		/* echo '<pre>';
		print_r($_REQUEST); exit; */
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		
		$yr= date('Y');
		$mon= date('m');
		$query   = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
		$data['ref_no']= 'AR' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$data['date']			= date('Y-m-d');
		$data['entry_by']	    =	$this->session->get('log_id_frend');
		$data['amount']       =	$_POST['tot_amt'];
		$pay_method       =	(!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'ipay_merch_online');
		$data['sep_print']      =	(!empty($_REQUEST['sep_print']) ? $_REQUEST['sep_print'] : 0);
		$data['created']      =	date('Y-m-d H:i:s');
		$data['rasi_id'] =   $rasi_id;
		$data['natchathra_id'] =   $natchathra_id;
		$data['paid_through'] =   "ONLINE";
		$data['payment_status'] =   ($pay_method == 'cash' ? 2: 1);
		$data['comission_to'] =   0;
		$tot_amt = 0;
		foreach ($_POST['arch'] as $arch)
		{
			$cash = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
			$amt = $arch['qty'] * $cash['amount'];
			$tot_amt  +=	$amt;
		}
		$data['amount'] = $tot_amt;
		$data['comission'] = "0.00";
		$res = $this->db->table('archanai_booking')->insert($data);
		$arch_book_id=$this->db->insertID();
		if($res)
		{
			$cash_amt = 0;
			if(!empty($_POST['arch'])){
				foreach ($_POST['arch'] as $arch)
				{
					$data_arch_book['archanai_booking_id']	 =	$arch_book_id;
					$data_arch_book['archanai_id']  =	$arch['id'];
					$data_arch_book['quantity']  =	$arch['qty'];
					$data_arch_book['created']  =	date('Y-m-d H:i:s');
					$cash = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
					$data_arch_book['amount']  =	$cash['amount'];
					$data_arch_book['commision']  =	$cash['commission'];
					$amt = $arch['qty'] * $cash['amount'];
					$camt =  $arch['qty'] * $cash['commission'];
					$data_arch_book['total_amount']  =	$amt-$camt;
					$data_arch_book['total_commision']  =	$camt;
					$cash_amt = $cash_amt + $amt;
					$res_2 = $this->db->table('archanai_booking_details')->insert($data_arch_book);
					/*STOCK DEDECTION SECTION START */
					$archanai_dedection_data = $this->db->table('archanai')->where('id',$arch['id'])->get()->getRowArray();
					if(!empty($archanai_dedection_data['dedection_from_stock'])){
						if($archanai_dedection_data['dedection_from_stock'] == 1){
							$am_raw_items = $this->db->table("archanai_raw_material_items")
												->where("product_id", $arch['id'])
												->get()->getResultArray();
							if(count($am_raw_items) > 0)
							{
								$staff_row = $this->db->table('staff')->where('name','admin')->where('is_admin',1)->get()->getRowArray();
								$data_rtout['date'] = $_POST['dt'];
								$data_rtout['staff_name'] = !empty($staff_row['id']) ? $staff_row['id'] : NULL;
								$query_out   = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
								$data_rtout['invoice_no']= 'AR' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($query_out['invoice_no'],-5))+1)));
								$data_rtout['date'] 		= $data['date'];
								$data_rtout['added_by'] 		= $this->session->get('log_id_frend');
								$data_rtout['modified'] 		= date("Y-m-d H:i:s");
								$data_rtout['created'] 		= date("Y-m-d H:i:s");
								$this->db->table('stock_outward')->insert($data_rtout);
								$ins_id_rtout = $this->db->insertID(); 
								$tot_outward_list_amt = 0;
								foreach($am_raw_items as $pr_raw_item)
								{
									$tot_req_qty = $arch['qty'] * $pr_raw_item['qty'];
									$av_data_r = $this->db->table("raw_matrial_groups")->where("id", $pr_raw_item['raw_id'])->get()->getRowArray();
									$avl_stack_r['opening_stock'] = $av_data_r['opening_stock'] - $tot_req_qty;
									$this->db->table('raw_matrial_groups')->where('id', $pr_raw_item['raw_id'])->update($avl_stack_r);

									$uom_item_data = $this->db->table('raw_matrial_groups')->where('id',$pr_raw_item['raw_id'])->get()->getRowArray();
									$uom_id = $uom_item_data['uom_id'];
									$item_raw_name = $uom_item_data['name'];
									$item_raw_rate = $uom_item_data['price'];
									$item_raw_qty = $tot_req_qty;
									$item_raw_amt = $uom_item_data['price'] * $tot_req_qty;
									$data_rtout_list['stack_out_id']= $ins_id_rtout;
									$data_rtout_list['item_type'] 	= 2;
									$data_rtout_list['item_id'] 	= $pr_raw_item['raw_id'];
									$data_rtout_list['item_name'] 	= $item_raw_name;
									$data_rtout_list['uom_id'] 		= $uom_id;
									$data_rtout_list['rate'] 		= $item_raw_rate;
									$data_rtout_list['quantity'] 	= $item_raw_qty;
									$data_rtout_list['amount'] 		= $item_raw_amt;
									$data_rtout_list['created'] 	= date("Y-m-d H:i:s");
									$data_rtout_list['modified'] 	= date("Y-m-d H:i:s");
									$this->db->table('stock_outward_list')->insert($data_rtout_list);
									$tot_outward_list_amt = $tot_outward_list_amt + $item_raw_amt;
								}
								$this->db->table('stock_outward')->where('id', $ins_id_rtout)->update(array("total_amount"=>$tot_outward_list_amt));
							}
						}
					}
					/*STOCK DEDECTION SECTION END */
				}
			}
			if(!empty($_POST['rasi'])){
				foreach ($_POST['rasi'] as $rasi) 
				{
					$data_arch_rasi['archanai_booking_id']	 =	$arch_book_id;
					$data_arch_rasi['name'] =   $rasi['arc_name'];
					$data_arch_rasi['rasi_id'] =  $rasi['rasi_ids'];
					$data_arch_rasi['natchathram_id'] =   $rasi['natchathra_ids'];
					$this->db->table('archanai_booking_rasi')->insert($data_arch_rasi);
				} 
			}
			if(!empty($_POST['vehicle'])){
				foreach ($_POST['vehicle'] as $vehicle) 
				{
					$data_arch_vehicle['archanai_booking_id']	 =	$arch_book_id;
					$data_arch_vehicle['name'] =   $vehicle['vle_name'];
					$data_arch_vehicle['vehicle_no'] =  $vehicle['vle_no'];
					$this->db->table('archanai_booking_vehicle')->insert($data_arch_vehicle);
				} 
			}
			$payment_gateway_data = array();
			$payment_gateway_data['archanai_booking_id'] = $arch_book_id;
			$payment_gateway_data['pay_method'] = $pay_method;
			$this->db->table('archanai_payment_gateway_datas')->insert($payment_gateway_data);
			$archanai_payment_gateway_id = $this->db->insertID();
			if($data['payment_status'] == 2){
				$this->account_migration($arch_book_id);
				$this->session->setFlashdata('succ', 'Archanai Booking Added Successfully');
			}
			if($res_2){
				$msg_data['succ'] = 'Archanai Booking Added Successfully';
				$msg_data['id'] = $arch_book_id;
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				$msg_data['err'] = 'Please Try Again';
			}
		}
		echo json_encode($msg_data);
		exit();
    }
	public function initiate_ipay_merch_qr($arch_book_id) {
		$barcode = !empty($_REQUEST['barcode']) ? $_REQUEST['barcode'] : '';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$archanai_booking = $this->db->table('archanai_booking')->where('id', $arch_book_id)->get()->getRowArray();
		if(!empty($barcode) && !empty($archanai_booking['amount']) && !empty($payment_id)){
			$final_amt = $archanai_booking['amount'];
			$description = $archanai_booking['ref_no'];
			$xml_response = $this->initiatePaymentIpayMerchantQr('archanai',$barcode,'ARCH_' . $arch_book_id,$final_amt,$payment_id,$description);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml_response['response_data']);
			$xml = new \SimpleXMLElement($response);
			$body = $xml->xpath('//sBody')[0];
			$aStatus = $body->EntryPageFunctionalityV2Response->EntryPageFunctionalityV2Result[0]->aStatus;
			$archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $arch_book_id)->get()->getRowArray();
			$payment_gateway_up_data = array();
			$payment_gateway_up_data['request_data'] = $xml_response['request_data'];
			$payment_gateway_up_data['response_data'] = $xml_response['response_data'];
			$this->db->table('archanai_payment_gateway_datas')->where('id', $archanai_payment_gateway_datas['id'])->update($payment_gateway_up_data);
			if($aStatus == 1){
				$archanai_booking_up_data = array();
				$archanai_booking_up_data['payment_status'] = 2;
				$this->db->table('archanai_booking')->where('id', $arch_book_id)->update($archanai_booking_up_data);
				$this->session->setFlashdata('succ', 'Archanai Booking Successfully');
				$redirect_url = base_url() . '/archanai_booking_cust/print_booking/' .$arch_book_id;
				header('Location: ' . $redirect_url);
				exit;
			}else{
				$this->session->setFlashdata('fail', 'Payment Failed. Please Try Again');
				$redirect_url = base_url() . '/archanai_booking_cust/';
				header('Location: ' . $redirect_url);
				exit;
			}
		}else{
			$this->session->setFlashdata('fail', 'Payment Failed. Please Try Again');
			$redirect_url = base_url() . '/archanai_booking_cust/';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function initiatePaymentIpayMerchantQr($module,$barcode,$ref_no,$final_amt,$payment_id=336,$description='Archanai',$email = 'dd@ipay88.com.my') {
		$MerchantCode = "M15137";
		$MerchantKey = "Vx7AbhyzGK";
		$url = "https://payment.ipay88.com.my/ePayment/WebService/MHGatewayService/GatewayService.svc";
		$final_amt = 0.10;
		$final_amt_str = '010';
		$signature = hash('sha256', $MerchantKey . $MerchantCode . $ref_no . $final_amt_str . 'MYR' . $barcode);
		$xml_post_string='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mob="https://www.mobile88.com" xmlns:mhp="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model">
		   <soapenv:Header/>
		   <soapenv:Body>
			  <mob:EntryPageFunctionalityV2>
				 <mob:requestModelObj>
					<mhp:Amount>' . $final_amt . '</mhp:Amount>
					<mhp:BackendURL></mhp:BackendURL>
					<mhp:BarcodeNo>' . $barcode .'</mhp:BarcodeNo>
					<mhp:Currency>MYR</mhp:Currency>
					<mhp:MerchantCode>' . $MerchantCode . '</mhp:MerchantCode>
					<mhp:PaymentId>' . $payment_id . '</mhp:PaymentId>
					<mhp:ProdDesc>' . $description . '</mhp:ProdDesc>
					<mhp:RefNo>' . $ref_no . '</mhp:RefNo>
					<mhp:Remark>good</mhp:Remark>
					<mhp:Signature>' . $signature . '</mhp:Signature>
					<mhp:SignatureType>SHA256</mhp:SignatureType>
					<mhp:TerminalID></mhp:TerminalID>
					<mhp:UserContact>0179871656</mhp:UserContact>
					<mhp:UserEmail>' . $email . '</mhp:UserEmail>
					<mhp:UserName>fira</mhp:UserName>
					<mhp:lang>UTF-8</mhp:lang>
					<mhp:xfield1/>
				 </mob:requestModelObj>
			  </mob:EntryPageFunctionalityV2>
		   </soapenv:Body>
		</soapenv:Envelope>';
		$headers = array(
			"Accept-Encoding: gzip,deflate",
			"Content-Type: text/xml; charset=utf-8",
			"Host: payment.ipay88.com.my",
			"Content-length: ".strlen($xml_post_string),
			"SOAPAction: https://www.mobile88.com/IGatewayService/EntryPageFunctionalityV2"
		);
		//print_r($headers);
/* 		if($module == 'archanai'){
			$archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $ref_no)->get()->getRowArray();
			$payment_gateway_up_data = array();
			$payment_gateway_up_data['request_data'] = $xml_post_string;
			$this->db->table('archanai_payment_gateway_datas')->where('id', $archanai_payment_gateway_datas['id'])->update($payment_gateway_up_data);
		} */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		 
		$response = curl_exec($ch);
		//print_r($response);
		$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
		curl_close($ch);
		return array('request_data' => $xml_post_string, 'response_data' => $response);
	}
	public function ipay88_online_response($arch_book_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$MerchantCode = 'M01230';
		$MerchantKey = 'HQgUUZLVzg';
		$ipay88 = new \IPay88($MerchantCode);
		$ipay88->setMerchantKey($MerchantKey);
		$response = $ipay88->getResponse();
		//print_r($response);
		if($response['status']){
			$archanai_booking_up_data = array();
			$archanai_booking_up_data['payment_status'] = 2;
			$this->db->table('archanai_booking')->where('id', $arch_book_id)->update($archanai_booking_up_data);
			$this->account_migration($arch_book_id);
			$this->session->setFlashdata('succ', 'Archanai Booking Successfully');
			$redirect_url = base_url() . '/archanai_booking_cust/print_booking/' .$arch_book_id;
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
	public function initiate_ipay_merch_online($arch_book_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$archanai_booking = $this->db->table('archanai_booking')->where('id', $arch_book_id)->get()->getRowArray();
		$email = 'dd@ipay88.com.my';
		$description='Archanai';
		$final_amt = $archanai_booking['amount'];
		$MerchantCode = 'M01230';
		$MerchantKey = 'HQgUUZLVzg';
		$ref_no = 'ARCH_' . $arch_book_id;
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
		$ipay88->setField('ResponseURL',  base_url() . '/archanai_booking_cust/ipay88_online_response/' . $arch_book_id);
		$ipay88->setField('BackendURL',  base_url() . '/archanai_booking_cust/ipay88_online_response/' . $arch_book_id);
		$ipay88->generateSignature();
		$ipay88_fields = $ipay88->getFields();
		$data['ipay88_fields'] = $ipay88_fields;
		$data['epayment_url'] = \Ipay88::$epayment_url;
		$view_file = 'front_user/ipay88/ipay_merch_online_process';
		echo view($view_file, $data);
	}
	public function payment_process($arch_book_id) {
		$archanai_booking = $this->db->table('archanai_booking')->where('id', $arch_book_id)->get()->getRowArray();
		$archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $arch_book_id)->get()->getResultArray();
		if(count($archanai_payment_gateway_datas) > 0){
			if($archanai_payment_gateway_datas[0]['pay_method'] == 'adyen'){
				if(!empty($archanai_payment_gateway_datas[0]['request_data'])){
					$request_data = $archanai_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				}else{
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($archanai_booking['amount'],$arch_book_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('archanai_payment_gateway_datas')->where('id', $archanai_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if(!empty($response['url']) && !empty($response['id'])){
					header('Location: ' . $response['url']);
					exit;
				}
			}elseif($archanai_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_qr'){
				//$view_file = 'front_user/ipay88/ipay_merch_qr';
				$view_file = 'front_user/ipay88/ipay_merch_qr_camera';
				$data['arch_book_id'] = $arch_book_id;
				$data['list'] = $this->db->table('payment_option')->where('status', 1)->get()->getResultArray();
				echo view($view_file, $data);
			}elseif($archanai_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_online'){
				$view_file = 'front_user/ipay88/ipay_merch_online';
				$data['arch_book_id'] = $arch_book_id;
				$data['submit_url'] = '/archanai_booking_cust/initiate_ipay_merch_online/' . $arch_book_id;
				echo view($view_file, $data);
			}else{
				$redirect_url = base_url() . '/archanai_booking_cust/print_booking/' .$arch_book_id;
				header('Location: ' . $redirect_url);
				exit;
			}
		}else{
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$result = $this->initiatePayment($archanai_booking['amount'],$arch_book_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
			$response = json_decode($result, true);
			if(!empty($response['url']) && !empty($response['id'])){
				$payment_gateway_data = array();
				$payment_gateway_data['archanai_booking_id'] = $arch_book_id;
				$payment_gateway_data['pay_method'] = 'adyen';
				$payment_gateway_data['request_data'] = $result;
				$payment_gateway_data['reference_id'] = $response['id'];
				$this->db->table('archanai_payment_gateway_datas')->insert($payment_gateway_data);
				$archanai_payment_gateway_id = $this->db->insertID();
				if(!empty($archanai_payment_gateway_id)){
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
			'returnUrl' => base_url() . '/archanai_booking_cust/print_booking/' .$orderid,
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
	public function account_migration($arch_book_id){
		 $archanai_booking = $this->db->table('archanai_booking')->where('id', $arch_book_id)->get()->getRowArray();
		 $archanai_booking_details = $this->db->table('archanai_booking_details')->where('archanai_booking_id', $arch_book_id)->get()->getResultArray();
		 if($archanai_booking['paid_through'] == 'ONLINE'){
			 $archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $arch_book_id)->get()->getRowArray();
			 if($archanai_payment_gateway_datas['pay_method'] == 'cash') $payment_id = 6; ////  goto cash Ledger
			 else $payment_id = 4; ////  goto Qr or Online Payment Ledger
			 $payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			 if(empty($payment_mode_details['id']))$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			 $sales_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
			if(!empty($sales_group)){
				$sls_id = $sales_group['id'];
			}else{
				$sls1['parent_id'] = 26;
				$sls1['name'] = 'Sales';
				$sls1['code'] = '330';
				$sls1['added_by'] = $this->session->get('log_id');
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			// Debit ledger
			$ledger1 = $this->db->table('ledgers')->where('name', 'ARCHANAI COLLECTION')->where('group_id', $sls_id)->get()->getRowArray();
			if(!empty($ledger1)){
				$dr_id = $ledger1['id'];
			}else{
				$led1['group_id'] = $sls_id;
				$led1['name'] = 'ARCHANAI COLLECTION';
				$led1['left_code'] = '7013';
				$led1['right_code'] = '000';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$dr_id = $this->db->insertID();
			}
			if(count($archanai_booking_details) > 0){
				 $cash_amt = 0;
				 $com_amt = 0;
				 foreach ($archanai_booking_details as $arch){  
					$amt = $arch['quantity'] * $arch['amount'];
					$camt =  $arch['quantity'] * $arch['commission'];
					$cash_amt = $cash_amt + $amt;
					$com_amt = $com_amt + $camt;
				 }
				 $number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
				if(empty($number)) {
					$num = 1;
				} else {
					$num = $number['number'] + 1;
				}
				$yr= date('Y',strtotime($archanai_booking['date'])) ;
				$mon= date('m',strtotime($archanai_booking['date'])) ;
				$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
				$entries['entry_code'] = 'REC' .date('y',strtotime($archanai_booking['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
				
				$entries['entrytype_id'] = '1';
				$entries['number'] 		 = $num;
				$entries['date'] 		 = $archanai_booking['date'];
								
				$entries['dr_total'] 	 = $cash_amt;
				$entries['cr_total'] 	 = $cash_amt;	
				$entries['narration'] 	 = 'Archanai Booking(' . $archanai_booking['ref_no'] . ')';
				$entries['inv_id']		 = $arch_book_id;
				$entries['type']		 = '3';
				$ent = $this->db->table('entries')->insert($entries);
				$en_id = $this->db->insertID();
				if(!empty($en_id) ){
					$eitems_d['entry_id'] = $en_id;
					$eitems_d['ledger_id'] = $dr_id;
					$eitems_d['amount'] = $cash_amt;
					$eitems_d['dc'] = 'C';
					$this->db->table('entryitems')->insert($eitems_d);

					$eitems_c['entry_id'] = $en_id;
					$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
					/* if ($comission_to!=0)
						$eitems_c['amount'] = $cash_amt-$com_amt;
					else */
						$eitems_c['amount'] = $cash_amt;
					$eitems_c['dc'] = 'D';
					$this->db->table('entryitems')->insert($eitems_c);				
				}
				return true;
			}else return false;
		}else return false;
	 }
	 public function print_booking($arch_book_id){
	 	$id = $this->request->uri->getSegment(3);
		$data['qry1'] = $archanai_booking = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		$url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		$data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
		if($archanai_booking['sep_print'] == 1) $view_file = 'front_user/archanai/sep_print_imin';
		else $view_file = 'front_user/archanai/print_imin';
		if($archanai_booking['paid_through'] == 'ONLINE'){
			if($archanai_booking['payment_status'] == '2'){
				//$data['qry2'] = $this->db->table('archanai_booking_details')->where('archanai_booking_id', $id)->get()->getResultArray();
				//echo "<pre>"; print_r($id); exit();
				$tmpid = $this->session->get('profile_id');
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();

				$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
							->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
							->where('archanai_booking_details.archanai_booking_id', $id )
							->select('archanai.*')
							->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
							->get()
							->getResultArray();
				$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
							->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
							->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
							->where('archanai_booking_rasi.archanai_booking_id', $id )
							->select('archanai_booking_rasi.*')
							->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
							->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
							->get()
							->getResultArray();
							//echo $this->db->getLastQuery();
				//echo "<pre>"; print_r($data); exit();
				echo view($view_file, $data);
			}elseif($archanai_booking['payment_status'] == '1'){
				$archanai_payment_gateway_datas = $this->db->table('archanai_payment_gateway_datas')->where('archanai_booking_id', $arch_book_id)->get()->getRowArray();
				if(!empty($archanai_payment_gateway_datas['reference_id'])){
					$reference_id = $archanai_payment_gateway_datas['reference_id'];
					$result_data = $this->initiatePayment_response($reference_id);
					$response_data = json_decode($result_data, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['response_data'] = $result_data;
					$this->db->table('archanai_payment_gateway_datas')->where('id', $archanai_payment_gateway_datas['id'])->update($payment_gateway_up_data);
					if(!empty($response_data['status'])){
						if($response_data['status'] == 'completed'){
							$archanai_booking_up_data = array();
							$archanai_booking_up_data['payment_status'] = 2;
							$this->db->table('archanai_booking')->where('id', $id)->update($archanai_booking_up_data);
							$this->account_migration($id);
							$tmpid = $this->session->get('profile_id');
							$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();

							$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
										->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
										->where('archanai_booking_details.archanai_booking_id', $id )
										->select('archanai.*')
										->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
										->get()
										->getResultArray();
							$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
										->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
										->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
										->where('archanai_booking_rasi.archanai_booking_id', $id )
										->select('archanai_booking_rasi.*')
										->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
										->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
										->get()
										->getResultArray();
							echo view($view_file, $data);
						}else{
							$archanai_booking_up_data = array();
							$archanai_booking_up_data['payment_status'] = 3;
							$this->db->table('archanai_booking')->where('id', $id)->update($archanai_booking_up_data);
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

			$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
						->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
						->where('archanai_booking_details.archanai_booking_id', $id )
						->select('archanai.*')
						->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
						->get()
						->getResultArray();
			$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
						->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
						->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
						->where('archanai_booking_rasi.archanai_booking_id', $id )
						->select('archanai_booking_rasi.*')
						->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
						->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
						->get()
						->getResultArray();
						//echo $this->db->getLastQuery();
			//echo "<pre>"; print_r($data); exit();
			echo view($view_file, $data);
		}
	 }
     public function print_booking_sep($arch_book_id){
		 
	 	$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		//$data['qry2'] = $this->db->table('archanai_booking_details')->where('archanai_booking_id', $id)->get()->getResultArray();
		//echo "<pre>"; print_r($id); exit();
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

		$data['booking'] = $this->db->table('archanai_booking_details', 'archanai')
					->join('archanai', 'archanai.id = archanai_booking_details.archanai_id')
					->where('archanai_booking_details.archanai_booking_id', $id )
					->select('archanai.*')
					->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
					->get()
					->getResultArray();
					//echo $this->db->getLastQuery();
		//echo "<pre>"; print_r($data); exit();
		$url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		$data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
		echo view('front_user/archanai/print_sep', $data);
	 }
	public function cancelled_booking() {
	    echo view('front_user/layout/header');
        echo view('front_user/archanai_new/cancelled_booking');
        echo view('front_user/layout/footer');
    }
	public function reprint_booking($id) {
		$data['qry1'] = $archanai_booking = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'front_user/archanai/print';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['booking'] = $this->db->table('archanai_booking_details', 'archanai', 'archanai_booking_rasi', 'rasi', 'natchathram')
					->join('archanai', 'archanai.id = archanai_booking_details.archanai_id', 'left')
					->where('archanai_booking_details.archanai_booking_id', $id )
					->select('archanai.*')
					->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
					->get()
					->getResultArray();
		$data['rasi'] = $this->db->table('archanai_booking_rasi', 'rasi', 'natchathram')
					->join('rasi', 'rasi.id = archanai_booking_rasi.rasi_id', 'left')
					->join('natchathram', 'natchathram.id = archanai_booking_rasi.natchathram_id', 'left')
					->where('archanai_booking_rasi.archanai_booking_id', $id )
					->select('archanai_booking_rasi.*')
					->select('rasi.*, rasi.name_eng as rasi_name_eng, rasi.name_tamil as rasi_name_tamil')
					->select('natchathram.*, natchathram.name_eng as nat_name_eng, natchathram.name_tamil as nat_name_tamil')
					->get()
					->getResultArray();
		$url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		$data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
		echo view($view_file, $data);
	}
}
