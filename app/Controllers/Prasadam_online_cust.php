<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Prasadam_online_cust extends BaseController
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
      $login_id = $_SESSION['log_id_frend'];
	    $data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
      $data['prasadam_settings'] = $this->db->query("SELECT * FROM prasadam_setting order by name_eng asc")->getResultArray();
      $data['reprintlists'] = $this->db->query("SELECT id,customer_name,amount,name,date FROM prasadam WHERE added_by = '".$login_id."' and paid_through = 'ONLINE' AND payment_status = 2 ORDER BY id DESC LIMIT 3")->getResultArray();

	    echo view('front_user/layout/header'); 
      echo view('front_user/prasadam/index', $data);
    }
    public function save(){
      //var_dump($_POST);
      //exit;
      $msg_data = array();
      $msg_data['err'] = '';
      $msg_data['succ'] = '';
      $yr=date('Y');
		  $mon=date('m');
		  $query   = $this->db->query("SELECT ref_no FROM prasadam where id=(select max(id) from prasadam where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
      $data['ref_no']= 'PR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
      $data['customer_name'] = $_POST['name'];
			$data['date'] = $_POST['date'];
			$data['email_id'] = $_POST['email_id'];
			$data['ic_no'] = $_POST['ic_number'];
      $mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
      $mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
		  $data['mobile_no']  = $mble_phonecode.$mble_number;
			$data['address'] = $_POST['address'];
			$data['desciption'] = $_POST['description'];
      $data['amount'] = $_POST['tot_amt'];
			$data['collection_date'] = $_POST['collection_date'];
      $data['start_time'] = $_POST['s_time'];
			//$data['end_time'] = $_POST['e_time'];
      $data['added_by']	 	=	$this->session->get('log_id_frend');
      $data['sep_print']      =	(!empty($_REQUEST['sep_print']) ? $_REQUEST['sep_print'] : 0);
      $data['paid_through'] = "ONLINE";
      $pay_method       =	(!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
      $data['payment_status'] =   ($pay_method == 'cash' ? 2: 1);
      $data['created_at']  =	date('Y-m-d H:i:s');
      $data['updated_at'] = date('Y-m-d H:i:s');
      $res = $this->db->table('prasadam')->insert($data);
      if($res)
      {
        $ins_id = $this->db->insertID();
        if(!empty($_POST['prasadam'])){
          foreach ($_POST['prasadam'] as $prasadam)
          {
            $data_prdm_book['prasadam_booking_id']	 =	$ins_id;
            $data_prdm_book['prasadam_id']  =	$prasadam['id'];
            $data_prdm_book['quantity']  =	$prasadam['qty'];
            $data_prdm_book['created']  =	date('Y-m-d H:i:s');
            $prsm_set = $this->db->table('prasadam_setting')->where('id', $prasadam['id'])->get()->getRowArray();
            $data_prdm_book['amount']  =	$prsm_set['amount'];
            $amt = $prasadam['qty'] * $prsm_set['amount'];
            $data_prdm_book['total_amount']  =	$amt;
            $res_2 = $this->db->table('prasadam_booking_details')->insert($data_prdm_book);
            
            /*STOCK DEDECTION SECTION START */
						$prasadam_dedection_data = $this->db->table('prasadam_setting')->where('id',$prasadam['id'])->get()->getRowArray();
						if(!empty($prasadam_dedection_data['dedection_from_stock'])){
							if($prasadam_dedection_data['dedection_from_stock'] == 1){
								$pm_raw_items = $this->db->table("prasadam_raw_material_items")
													->where("product_id", $prasadam['id'])
													->get()->getResultArray();
								if(count($pm_raw_items) > 0)
								{
									$staff_row = $this->db->table('staff')->where('name','admin')->where('is_admin',1)->get()->getRowArray();
									$data_rtout['date'] = $_POST['date'];
									$data_rtout['staff_name'] = !empty($staff_row['id']) ? $staff_row['id'] : NULL;
									$query_out   = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
									$data_rtout['invoice_no']= 'PR' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query_out['invoice_no'],-5))+1)));
									$data_rtout['added_by'] 		= $this->session->get('log_id_frend');
									$data_rtout['modified'] 		= date("Y-m-d H:i:s");
									$data_rtout['created'] 		= date("Y-m-d H:i:s");
									$this->db->table('stock_outward')->insert($data_rtout);
									$ins_id_rtout = $this->db->insertID(); 
									$tot_outward_list_amt = 0;
									foreach($pm_raw_items as $pr_raw_item)
									{
										$tot_req_qty = $prasadam['qty'] * $pr_raw_item['qty'];
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
        $payment_gateway_data = array();
        $payment_gateway_data['prasadam_id'] = $ins_id;
        $payment_gateway_data['pay_method'] = $pay_method;
        $this->db->table('prasadam_payment_gateway_datas')->insert($payment_gateway_data);
        $prasadam_payment_gateway_id = $this->db->insertID();
        if($data['payment_status'] == 2) $this->account_migration($ins_id);
        if($res_2){
          $this->session->setFlashdata('succ', 'Prasadam Added Successflly');
          $msg_data['succ'] = 'Prasadam Added Successflly';
          $msg_data['id'] = $ins_id;
        }
        else{
          $this->session->setFlashdata('fail', 'Please Try Again');
          $msg_data['err'] = 'Please Try Again';
        }
      }
      echo json_encode($msg_data);
      exit();
    }
    public function payment_process($prsm_id) {
      $prasadam_booking = $this->db->table('prasadam')->where('id', $prsm_id)->get()->getRowArray();
      $prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prsm_id)->get()->getResultArray();
      if(count($prasadam_payment_gateway_datas) > 0){
        if($prasadam_payment_gateway_datas[0]['pay_method'] == 'adyen'){
          if(!empty($prasadam_payment_gateway_datas[0]['request_data'])){
            $request_data = $prasadam_payment_gateway_datas[0]['request_data'];
            $response = json_decode($request_data, true);
          }else{
            $tmpid = 1;
            $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
            $result = $this->initiatePayment($prasadam_booking['amount'],$prsm_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
            $response = json_decode($result, true);
            $payment_gateway_up_data = array();
            $payment_gateway_up_data['request_data'] = $result;
            $payment_gateway_up_data['reference_id'] = $response['id'];
            $this->db->table('prasadam_payment_gateway_datas')->where('id', $prasadam_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
          }
          if(!empty($response['url']) && !empty($response['id'])){
            header('Location: ' . $response['url']);
            exit;
          }
        }else{
          $redirect_url = base_url() . '/prasadam_online/print_booking/' .$prsm_id;
          header('Location: ' . $redirect_url);
          exit;
        }
      }else{
        $tmpid = 1;
        $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
        $result = $this->initiatePayment($prasadam_booking['amount'],$prsm_id,$temple_details['address1'] . $temple_details['address2'],$temple_details['city'],$temple_details['email']);
        $response = json_decode($result, true);
        if(!empty($response['url']) && !empty($response['id'])){
          $payment_gateway_data = array();
          $payment_gateway_data['prasadam_id'] = $prsm_id;
          $payment_gateway_data['pay_method'] = 'adyen';
          $payment_gateway_data['request_data'] = $result;
          $payment_gateway_data['reference_id'] = $response['id'];
          $this->db->table('prasadam_payment_gateway_datas')->insert($payment_gateway_data);
          $prasadam_payment_gateway_id = $this->db->insertID();
          if(!empty($prasadam_payment_gateway_id)){
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
        'returnUrl' => base_url() . '/prasadam_online/print_booking/' .$orderid,
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
    public function account_migration($prsm_id){
      $prasadam = $this->db->table('prasadam')->where('id', $prsm_id)->get()->getRowArray();
      if($prasadam['paid_through'] == 'ONLINE'){
			 $prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prsm_id)->get()->getRowArray();
			 if($prasadam_payment_gateway_datas['pay_method'] == 'cash') $payment_id = 6; ////  goto cash Ledger
			 else $payment_id = 5; ////  goto Qr or Online Payment Ledger
			 $payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_id)->get()->getRowArray();
			  if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
			  $ledger = $this->db->table('ledgers')->where('name', 'PRASADAM FEE')->where('group_id', 29)->where('left_code', '7111')->get()->getRowArray();
			  if(!empty($ledger)){
				$dr_id = $ledger['id'];
			  }else{
				$led['group_id'] = 29;
				$led['name'] = 'PRASADAM FEE';
				$led['left_code'] = '7111';
				$led['right_code'] = '000';
				$led['op_balance'] = '0';
				$led['op_balance_dc'] = 'D';
				$led_ins = $this->db->table('ledgers')->insert($led);
				$dr_id = $this->db->insertID();
			  }
			  $cr_id = $payment_mode_details['ledger_id'];
			  $number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
			  if(empty($number)) {
				$num = 1;
			  } else {
				$num = $number['number'] + 1;
			  }
			  $date = explode('-', date("Y-m-d", strtotime($prasadam['date'])));
			  $yr = date('Y',strtotime($prasadam['date']));
			  $mon = date('m',strtotime($prasadam['date']));
			  $qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
			  $entries['entry_code'] = 'REC' .date('y',strtotime($prasadam['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
			  $entries['entrytype_id'] = '1';
			  $entries['number'] 		 = $num;
			  $entries['date'] 		 = date("Y-m-d", strtotime($prasadam['date'])); 
			  $entries['dr_total'] 	 = $prasadam['amount'];
			  $entries['cr_total'] 	 = $prasadam['amount'];
			  $entries['narration'] 	 = 'Prasadam(' . $prasadam['ref_no'] . ')' . "\n" . 'name:' . $prasadam['customer_name'] . "\n" . 'NRIC:' . $prasadam['ic_no'] . "\n" . 'email:' . $prasadam['email_id'] . "\n";
			  $entries['inv_id']       = $prsm_id;
			  $entries['type']         = '10';
			  $ent = $this->db->table('entries')->insert($entries);
			  $en_id = $this->db->insertID();
			  if(!empty($en_id)){
				$ent_id[] = $en_id;
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $prasadam['amount'];
				$eitems_d['details'] = 'Prasadam(' . $prasadam['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$cr_res = $this->db->table('entryitems')->insert($eitems_d);
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = $prasadam['amount'];
				$eitems_c['details'] = 'Prasadam(' . $prasadam['ref_no'] . ')';
				$eitems_c['dc'] = 'D';
				$deb_res = $this->db->table('entryitems')->insert($eitems_c);
				if($cr_res && $deb_res) $succ++;
				else $err++;
			  }
		}
    }
    public function print_booking($prsm_id){
      $id = $this->request->uri->getSegment(3);
      $data['qry1'] = $prasadam = $this->db->table('prasadam')
                                        ->select('prasadam.*')
                                        ->where('prasadam.id', $id)
                                        ->get()->getRowArray();
      $data['qry1_payfor'] =  $this->db->table('prasadam_booking_details')
                                        ->join('prasadam_setting','prasadam_setting.id = prasadam_booking_details.prasadam_id')
                                        ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
                                        ->where('prasadam_booking_details.prasadam_booking_id', $id)
                                        ->get()->getResultArray();
      $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
      $data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
      if($prasadam['sep_print'] == 1) $view_file = 'front_user/prasadam/print_sep';
      else $view_file = 'front_user/prasadam/print_page';
      if($prasadam['paid_through'] == 'ONLINE'){
        if($prasadam['payment_status'] == '2'){
          $tmpid = $this->session->get('profile_id');
          $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
          $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
          echo view($view_file, $data);
        }elseif($prasadam['payment_status'] == '1'){
          $prasadam_payment_gateway_datas = $this->db->table('prasadam_payment_gateway_datas')->where('prasadam_id', $prsm_id)->get()->getRowArray();
          if(!empty($prasadam_payment_gateway_datas['reference_id'])){
            $reference_id = $prasadam_payment_gateway_datas['reference_id'];
            $result_data = $this->initiatePayment_response($reference_id);
            $response_data = json_decode($result_data, true);
            $payment_gateway_up_data = array();
            $payment_gateway_up_data['response_data'] = $result_data;
            $this->db->table('prasadam_payment_gateway_datas')->where('id', $prasadam_payment_gateway_datas['id'])->update($payment_gateway_up_data);
            if(!empty($response_data['status'])){
              if($response_data['status'] == 'completed'){
                $prasadam_up_data = array();
                $prasadam_up_data['payment_status'] = 2;
                $this->db->table('prasadam')->where('id', $id)->update($prasadam_up_data);
                $this->account_migration($id);
                $tmpid = $this->session->get('profile_id');
                $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
                $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
                echo view($view_file, $data);
              }else{
                $prasadam_up_data = array();
                $prasadam_up_data['payment_status'] = 3;
                $this->db->table('prasadam')->where('id', $id)->update($prasadam_up_data);
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
        $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
        echo view($view_file, $data);
      }
    }
    public function print_booking_sep($prsm_id){
      $id = $this->request->uri->getSegment(3);
      $data['qry1'] = $this->db->table('prasadam')
                                        ->select('prasadam.*')
                                        ->where('prasadam.id', $id)
                                        ->get()->getRowArray();
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
      $data['qry1_payfor'] =  $this->db->table('prasadam_booking_details')
                                        ->join('prasadam_setting','prasadam_setting.id = prasadam_booking_details.prasadam_id')
                                        ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
                                        ->where('prasadam_booking_details.prasadam_booking_id', $id)
                                        ->get()->getResultArray();
      $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
      $data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
      echo view('front_user/prasadam/print_sep', $data);
    }
    public function cancelled_booking() {
	    echo view('front_user/layout/header');
      echo view('front_user/prasadam/cancelled_booking');
      echo view('front_user/layout/footer');
    }
    public function reprint_booking($id) {
      $data['qry1'] = $prasadam = $this->db->table('prasadam')
                                        ->select('prasadam.*')
                                        ->where('prasadam.id', $id)
                                        ->get()->getRowArray();
      $data['qry1_payfor'] =  $this->db->table('prasadam_booking_details')
                                        ->join('prasadam_setting','prasadam_setting.id = prasadam_booking_details.prasadam_id')
                                        ->select('prasadam_booking_details.*,prasadam_setting.name_eng,prasadam_setting.name_tamil')
                                        ->where('prasadam_booking_details.prasadam_booking_id', $id)
                                        ->get()->getResultArray();
      $view_file = 'front_user/prasadam/print_page';
      $tmpid = $this->session->get('profile_id');
      $data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
      $data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
      $url = "https://maps.app.goo.gl/SyWKRkVEzrTDa1BB8";
		  $data['qrcdoee'] = qrcode_generation($id,$url, 95, 95);
      echo view($view_file, $data);
    }


}
