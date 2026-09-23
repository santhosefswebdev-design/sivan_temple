<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\MemberPaymentGatewayData;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Annathanam_counter extends BaseController
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
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['annathanam_rice_category'] = $this->db->table('annathanam_rice_category')->where('status', 1)->get()->getResultArray();
		$data['packages'] = $this->db->table('annathanam_packages')->select('id, name_eng, name_tamil, amount, view')->where('status', 1)->get()->getResultArray();
		$data['payment_mode'] = $this->db->table('payment_mode')->where("paid_through", "COUNTER")->where("annathanam", 1)->where('status', 1)->get()->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query = $this->db->query("SELECT ref_no FROM annathanam_new where id=(select max(id) from annathanam_new where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['bill_no']= 'AT' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$booking_settings = $this->db->table('booking_setting')->get()->getResultArray();
		$setting = array();
		if(count($booking_settings) > 0){
			foreach($booking_settings as $bs){
				$setting[$bs['meta_key']] = $bs['meta_value'];
			}
		}
		$data['setting'] = $setting;
		echo view('frontend/layout/header');
		echo view('frontend/annathanam/index', $data);
		//echo view('frontend/layout/footer');
	}
	
	public function annathanam_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['list'] = $this->db->table('annathanam_new')
			->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil')
			->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
			->orderBy('annathanam_new.id', 'desc')
			->where('annathanam_new.date >=', $from_date)
			->where('annathanam_new.date <=', $to_date)
			->where('annathanam_new.booking_status !=', 3)
			->get()
			->getResultArray();
        $data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		echo view('frontend/layout/header');
		echo view('frontend/report/annathanam_report', $data);
	}

	public function view_annathanam()
	{

		if(!$this->model->permission_validate('annathanam', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('annathanam_new')->where('id', $id)->get()->getRowArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['packages'] = $this->db->table('annathanam_packages')->where('status', 1)->get()->getResultArray();
		$data['items'] = $this->db->table('annathanam_booked_items')
					->select('annathanam_items.name_eng, annathanam_items.name_tamil')
					->join('annathanam_items', 'annathanam_booked_items.item_id = annathanam_items.id')
					->where('annathanam_booked_items.annathanam_id', $id)->get()->getResultArray();

		$data['addon_items'] = $this->db->table('annathanam_booked_addon')
					->select('annathanam_items.name_eng, annathanam_items.name_tamil, annathanam_booked_addon.item_id, annathanam_booked_addon.item_amount, annathanam_booked_addon.item_total_amount')
					->join('annathanam_items', 'annathanam_booked_addon.item_id = annathanam_items.id')
					->where('annathanam_booked_addon.annathanam_id', $id)->get()->getResultArray();

		// var_dump($data['items']);
		// exit;
		
		$data['view'] = true;
		echo view('frontend/layout/header');
		echo view('frontend/annathanam/index', $data);
	}

	public function save_annathanam(){
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		// $this->db->transStart();
		try{
			// Receive data from POST request
			$data['name'] = $_POST['name'];
			$data['phone_code'] = $_POST['phone_code'];
			$data['phone_no'] = $_POST['phone_no'];
			$data['slot_time'] = $_POST['time'];
			$data['package_id'] = $_POST['package_id'];
			$data['dob'] = $_POST['dob'];
			$tot_amt = $_POST['total_amount'];
			$sub_total = $tot_amt;
			if (!empty($_POST['discount_amount'])) {
				$data['discount_amount'] = $_POST['discount_amount'];
				$sub_total += $_POST['discount_amount'];
			}
			$data['sub_total'] = $sub_total;
      		$data['amount'] = $tot_amt;
			$data['no_of_pax'] = $_POST['no_of_pax'];
			$data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type']: 'full';
			$data['booking_through'] = 'COUNTER';
			$yr= date('Y', strtotime($_POST['date']));
			$mon= date('m', strtotime($_POST['date']));
			$query = $this->db->query("SELECT ref_no FROM annathanam_new WHERE id=(SELECT max(id) FROM annathanam_new WHERE year(date)='". $yr ."' AND month(date)='". $mon ."')")->getRowArray();
			$data['ref_no'] = 'AT' .date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
			$data['date'] = date('Y-m-d', strtotime($_POST['date']));
			$data['event_date'] = date('Y-m-d', strtotime($_POST['event_date']));
			$data['added_by'] = $this->session->get('log_id_frend');
			$data['created'] = date('Y-m-d H:i:s');
			$data['payment_mode'] = $pay_id = $_POST['pay_method'];
			$payment_mode = $this->db->table('payment_mode')->where("id", $pay_id)->get()->getRowArray();
			$pay_method = $payment_mode['name'];

			if (!empty($pay_method)) {
				if ($data['payment_type'] == 'full')
				$data['payment_status'] = 2;
				else
				$data['payment_status'] = 1;
			} else {
				$data['payment_status'] = 0;
			}
			// if ($pay_method == 'cash')
			// 	$data['payment_mode'] = 6; ////  goto cash Ledger
			// elseif ($pay_method == 'online')
			// 	$data['payment_mode'] = 7; ////  goto online Ledger
			// elseif ($pay_method == 'qr')
			// 	$data['payment_mode'] = 12; ////  goto qr Ledger
			// elseif ($pay_method == 'cheque')
			// 	$data['payment_mode'] = 11; ////  goto Cheque Ledger
			// elseif ($pay_method == 'card')
			// 	$data['payment_mode'] = 13; ////  goto card Ledger
			// else
			// 	$data['payment_mode'] = 4; ////  goto Qr or Online Payment Ledger
	
			$res = $this->db->table('annathanam_new')->insert($data);
			$annathanam_id = $this->db->insertID();

			$items = json_decode($_POST['pack_items'], true);
			$addon_items = json_decode($_POST['addon_pack_items'], true);
		
	
			if(!empty($items)){
				foreach ($items as $item) {
					$data_item = array(
						'annathanam_id' => $annathanam_id,
						'package_id' => $data['package_id'],
						'item_id' => $item['item_id'],
						'add_on' => $item['add_on']
					);
					$res = $this->db->table('annathanam_booked_items')->insert($data_item);
				}
			}
	
			if(!empty($addon_items)){
				foreach ($addon_items as $addon_item) {
					$data_addon_item = array(
						'annathanam_id' => $annathanam_id,
						'package_id' => $data['package_id'],
						'item_id' => $addon_item['item_id'],
						'quantity' => $addon_item['item_quantity'],
						'item_amount' => $addon_item['item_amount'],
						'item_total_amount' => $addon_item['item_total_amount'],
						'add_on' => $addon_item['add_on']
					);
					$this->db->table('annathanam_booked_addon')->insert($data_addon_item);
				}
			}

			$pay_details = array();
			// if($pay_method == 'cash') $payment_mode_id = 6;
			// if($pay_method == 'online') $payment_mode_id = 8;
			// if($pay_method == 'qr') $payment_mode_id = 9;
			// if($pay_method == 'nets_pay') $payment_mode_id = 10;
			// if($pay_method == 'cheque') $payment_mode_id = 12;
			// if($pay_method == 'pay_now') $payment_mode_id = 13;
			// $count = $this->db->table("payment_mode")->where('id', $payment_mode_id)->get()->getNumRows();
			if($data['payment_mode']){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $data['payment_mode'])->get()->getRowArray();
				$pay_details['payment_key'] = $pay_method;
				$pay_details['annathanam_id'] = $annathanam_id;
				$pay_details['is_repayment'] = 0;
				$pay_details['payment_mode_id'] = $data['payment_mode'];
				$pay_details['paid_through'] = 'COUNTER';
				$pay_details['pay_status'] = (($pay_method == 'cash' || $pay_method == 'online' || $pay_method == 'qr' || $pay_method == 'card' ) ? 2 : 1);
				$pay_details['payment_mode_title'] = $payment_mode_details['name'];
				$pay_details['booking_ref_no'] = $data['ref_no'];
				if($data['payment_type'] == 'partial') $pay_details['amount'] = $_POST['paid_amount'];
				else $pay_details['amount'] = $tot_amt;
				if(empty($pay_details['amount'])){
					$this->db->transRollback();
					echo 'Invalid Amount';
					$redirect_url = base_url("/annathanam_counter");
					echo <<<PPR
						<script>
						setTimeout(function(){
							location.href = '$redirect_url';
						}, 3500);
						</script>
					PPR;
					exit;
				}
				$pay_details['paid_date'] = date('Y-m-d');
				$this->requestmodel = new RequestModel();
				$ip = $this->requestmodel->getIpAddress();
				$pay_details['ip'] = $ip;
				if ($ip != 'unknown') {
					$ip_details = $this->requestmodel->getLocation($ip);
					$pay_details['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
					$pay_details['ip_details'] = json_encode($ip_details);
				}
				$this->db->table('annathanam_booked_pay_details')->insert($pay_details);
				$booking_ref_data = array();
				$booking_ref_data['paid_amount'] = $pay_details['amount'];
				if($data['payment_type'] == 'partial'){ 
					$booking_ref_data['payment_status'] = 1;
				}else {
					$booking_ref_data['payment_status'] = 2;
				}
				$booking_ref_data['booking_status'] = 1;
				$this->db->table("annathanam_new")->where('id', $annathanam_id)->update($booking_ref_data);

				$payment_gateway_data = array();
				$payment_gateway_data['annathanam_booking_id'] = $annathanam_id;
				$payment_gateway_data['pay_method'] = $pay_method;
				$this->db->table('annathanam_payment_gateway_datas')->insert($payment_gateway_data);

			}else{
				// $this->db->transRollback();
				echo 'Invalid Payment';
				$redirect_url = base_url("/annathanam_counter");
				echo <<<PPR
					<script>
					setTimeout(function(){
						location.href = '$redirect_url';
					}, 3500);
					</script>
				PPR;
				exit;
			}

			$this->account_migration($annathanam_id);
			// $this->db->transComplete();
			//return redirect()->to(base_url("/annathanam_counter?annathanam_id=$annathanam_id"));
			$msg_data['id'] = $annathanam_id;
			$msg_data['succ'] = 'Annathanam added successfully';
			
		}catch (Exception $e) {
			// $this->db->transRollback();
			echo $e->getMessage();
			$redirect_url = base_url("/annathanam_counter");
			echo <<<PPR
			<script>
			setTimeout(function(){
				location.href = '$redirect_url';
			}, 3500);
			</script>
			PPR;
		}
		echo json_encode($msg_data);
		exit;
	}

	public function get_items_by_package_id($package_id)
	{
		$package_details = $this->db->table('annathanam_packages')->select('veg_count')->where('id', $package_id)->get()->getRowArray();
		$item_ids = $this->db->table('annathanam_package_items')->select('item_id')->where('package_id', $package_id)->get()->getResultArray();
		$item_ids = array_column($item_ids, 'item_id');

		$items = []; 
		if (!empty($item_ids)) {
			$items = $this->db->table('annathanam_items')
							->select('id, name_eng, name_tamil, description, amount, add_on, add_veg')
							->whereIn('id', $item_ids)
							->where('status', 1)
							->get()
							->getResultArray();
		}
		$response = [
			'package_details' => $package_details,
			'items' => $items
		];

		echo json_encode($response);
	}

	public function get_special_items()
	{
		$result = [];
		$special_types = $this->db->table('annathanam_special_types')
								->select('id, name')
								->where('status', 1)
								->get()
								->getResultArray();

		foreach ($special_types as $type) {
			$type_id = $type['id'];
			$special_items = $this->db->table('annathanam_special_items')
									->select('id, name_eng, name_tamil, amount')
									->where('type_id', $type_id)
									->where('status', 1)
									->get()
									->getResultArray();

			foreach ($special_items as &$item) {
				$item['type_id'] = $type_id;  // Add type_id to each item array
			}

			$result[$type['name']] = [
				'type_id' => $type_id,
				'items' => $special_items
			];
		}

		echo json_encode($result);
	}

	public function get_addon_items()
	{
		$result = [];
		$special_types = $this->db->table('annathanam_items')->select('id, name_eng, name_tamil, amount, add_on')->where('status', 1)->get()->getResultArray();

		echo json_encode($special_types);
	}

	// public function print_annathanam($id)
	// {
	// 	//$id=  $this->request->uri->getSegment(3);
	//     $data['data'] = $this->db->table('annathanam_new')
	// 						->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil, annathanam_packages.amount')
	// 						->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
	// 						->where('annathanam_new.id', $id)
	// 						->get()
	// 						->getRowArray();

	// 	$tmpid = 1;
	// 	$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
	// 	$data['annathanam_items'] = $this->db->table('annathanam_item')
	// 										->join('annathanam_vegetables','annathanam_vegetables.id = annathanam_item.vegetable_id')
	// 										->select('annathanam_vegetables.name_eng,annathanam_vegetables.name_tamil')
	// 										->where('annathanam_item.annathanam_id', $id)
	// 										->get()
	// 										->getResultArray();
	// 	$data['items'] = $this->db->table('annathanam_booked_items')
	// 								->select('annathanam_items.name_eng, annathanam_items.name_tamil')
	// 								->join('annathanam_items', 'annathanam_booked_items.item_id = annathanam_items.id')
	// 								->where('annathanam_booked_items.annathanam_id', $id)->get()->getResultArray();
						
	// 	$data['addon_items'] = $this->db->table('annathanam_booked_addon')
	// 										->select('annathanam_items.name_eng, annathanam_items.name_tamil, annathanam_booked_addon.item_id, annathanam_booked_addon.item_amount, annathanam_booked_addon.item_total_amount')
	// 										->join('annathanam_items', 'annathanam_booked_addon.item_id = annathanam_items.id')
	// 										->where('annathanam_booked_addon.annathanam_id', $id)->get()->getResultArray();
	// 	echo view('annathanam_new/print_annathanam',$data);
	// }

	public function print_annathanam()
	{
		$id=  $this->request->uri->getSegment(3);
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		
	    $annathanam = $this->db->table('annathanam_new')
							->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil, annathanam_packages.amount')
							->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
							->where('annathanam_new.id', $id)
							->get()
							->getRowArray();
		
		if($annathanam['is_special'] == 0){
			$data['items'] = $this->db->table('annathanam_booked_items')
										->select('annathanam_items.name_eng, annathanam_items.name_tamil')
										->join('annathanam_items', 'annathanam_booked_items.item_id = annathanam_items.id')
										->where('annathanam_booked_items.annathanam_id', $id)->get()->getResultArray();
		} else {
			$data['special_items'] = $this->db->table('annathanam_booked_special')
										->select('annathanam_special_items.*, annathanam_booked_special.quantity')
										->join('annathanam_special_items', 'annathanam_booked_special.item_id = annathanam_special_items.id')
										->where('annathanam_booked_special.annathanam_id', $id)->get()->getResultArray();
		}

		$data['data'] = $annathanam;
		$data['addon_items'] = $this->db->table('annathanam_booked_addon')
											->select('annathanam_items.*, annathanam_booked_addon.quantity')
											->join('annathanam_items', 'annathanam_booked_addon.item_id = annathanam_items.id')
											->where('annathanam_booked_addon.annathanam_id', $id)->get()->getResultArray();
		$data['pay_details'] = $this->db->table("annathanam_booked_pay_details")->where("annathanam_id", $id)->get()->getResultArray();
		
		echo view('annathanam_new/print_annathanam',$data);
	}

	public function print_annathanam_imin()
	{
		$id = $this->request->uri->getSegment(3);
		$qry1 = $this->db->table('annathanam_new')->where('id', $id)->get()->getRowArray();
		$data['qry1'] = $qry1;
		$data['package'] = $this->db->table("annathanam_packages")->where('id', $qry1['package_id'])->get()->getRowArray();
		$query = $this->db->table("annathanam_booked_items")->join('annathanam_items', 'annathanam_items.id = annathanam_booked_items.item_id')->select('annathanam_items.name_eng')->where('annathanam_booked_items.annathanam_id', $id)->get()->getResultArray();
		$package_names = '';
		if (!empty($query)) {
			$names = array_column($query, 'name_eng'); 
			$package_names = implode(',', $names);
		}
		$data['package_names'] = $package_names;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		
		echo view('frontend/annathanam/print_imin', $data);
	}

	public function gtpaymentdata()
	{
		$id = $_POST['id'];
		$res = $this->db->table("annathanam_new")->where("id", $id)->get()->getRowArray();
		//$amt = $res['amount'] + $res['commision'];
		$amt = $res['amount'];
		$data['amt'] = $amt;
		$res1 = $this->db->table("annathanam_booked_pay_details")->selectSum('amount')->where("annathanam_id", $id)->get()->getRowArray();
		$paid_amount = $res1['amount'];
		$data['paid_amount'] = $paid_amount;
		$data['bal_amount'] = $amt - $paid_amount;

		echo json_encode($data);
	}

	public function update_booking_status()
	{
		$id = $_POST['id'];
		$status = $_POST['status'];

		$data = [
			'booking_status' => $status
		];

		$res = $this->db->table('annathanam_new')->where('id', $id)->update($data);
	
		// if($this->db->affectedRows() > 0) {
		if($res){
			echo json_encode(['success' => true, 'message' => 'Booking Cancelled Successfully.']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to Cancel the Booking.']);
		}
	}


	public function save_repayment()
	{
		if(!empty($_POST['payment_mode']) && !empty($_POST['pay_amount'])&& !empty($_POST['booking_id'])){
			$date = $_POST['date'];
			$pay_amount = $_POST['pay_amount'];
			$payment_mode = $_POST['payment_mode'];
			$booking_id = $_POST['booking_id'];
			$count = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getNumRows();
			if($count > 0){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
				$annathanam_details = $this->db->table("annathanam_new")->where('id', $booking_id)->get()->getRowArray();
				if($annathanam_details['amount'] >= ($annathanam_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['annathanam_id'] = $booking_id;
					$booking_payment_ins_data['booking_ref_no'] = $annathanam_details['ref_no'];
					$booking_payment_ins_data['is_repayment'] = 1;
					$booking_payment_ins_data['payment_mode_id'] = $payment_mode;
					$booking_payment_ins_data['paid_date'] = !empty($date) ? $date : date('Y-m-d');
					$booking_payment_ins_data['amount'] = $pay_amount;
					$booking_payment_ins_data['payment_mode_title'] = $payment_mode_details['name'];
					$paid_through = 'COUNTER';
					if($paid_through != 'ADMIN' && $paid_through != 'COUNTER') $booking_payment_ins_data['payment_ref_no'] = $ubayam_details['ref_no'];
					$booking_payment_ins_data['paid_through'] = $paid_through;
					$booking_payment_ins_data['pay_status'] = ($paid_through == 'ADMIN' || $paid_through == 'COUNTER') ? 2 : 1;
					$this->requestmodel = new RequestModel();
					$ip = $this->requestmodel->getIpAddress();
					$booking_payment_ins_data['ip'] = $ip;
					if ($ip != 'unknown') {
						$ip_details = $this->requestmodel->getLocation($ip);
						$booking_payment_ins_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
						$booking_payment_ins_data['ip_details'] = json_encode($ip_details);
					} 
					// $this->paid_amount += $booking_payment_ins_data['amount'];
					$res = $this->db->table("annathanam_booked_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE annathanam_new SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
					$query = $this->db->table('annathanam_new')->where('id', $booking_id)->get()->getRowArray();
					if ($query['amount'] == $query['paid_amount']) {
						$this->db->query("UPDATE annathanam_new SET payment_status = 2 WHERE id = ?", [$booking_id]);
					}
					$this->partial_account_migration($booked_pay_id);

					echo json_encode(['status' => true, 'message' => 'Repayment saved successfully.']);
				}else{
					echo json_encode(['status' => false, 'message' => 'Payment amount not exceed Total.']);
				}
			} else {
				echo json_encode(['status' => false, 'message' => 'Failed to save repayment.']);
			}
		} else {
			echo json_encode(['status' => false, 'message' => 'Failed to save repayment.']);
		}
		exit;
	}
	public function partial_account_migration($booked_pay_id){
		$succ = true;
		$yr = date('Y');
    	$mon = date('m');
		$booked_pay_details_cnt = $this->db->table("annathanam_booked_pay_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("annathanam_booked_pay_details")->where("id", $booked_pay_id)->get()->getResultArray();
			$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '1200')->get()->getRowArray();
			if (!empty($td_ledger)) {
			  $cr_id1 = $td_ledger['id'];
			} else {
			  $cled1['group_id'] = 3;
			  $cled1['name'] = 'TRADE RECEIVABLE';
			  $cled1['code'] = '1200/005';
			  $cled1['op_balance'] = '0';
			  $cled1['op_balance_dc'] = 'D';
			  $cled1['left_code'] = '1200';
			  $cled1['right_code'] = '005';
			  $this->db->table('ledgers')->insert($cled1);
			  $cr_id1 = $this->db->insertID();
			}
			$booking_id = $booked_pay_details[0]['annathanam_id'];
			$annathanam_new = $this->db->table("annathanam_new")->where("id", $booking_id)->get()->getRowArray();
			foreach ($booked_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode_id'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'REC' . date('y', strtotime($row['paid_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $row['paid_date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Annathanam(' . $annathanam_new['ref_no'] . ')' . "\n" . 'name:' . $annathanam_new['name'] . "\n" . 'NRIC:' . $annathanam_new['ic_number'] . "\n" . 'email:' . $annathanam_new['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 8;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {
						// Trade Debtors => Credit
						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $cr_id1;
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Annathanam(' . $annathanam_new['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Annathanam(' . $annathanam_new['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}else{
					$succ = false;
					return $succ;
				}
			}
		}else{
			$succ = false;
			return $succ;
		}
	}

	public function account_migration($ins_id)
	{
    	$yr = date('Y');
    	$mon = date('m');
		$data = $this->db->table('annathanam_new')->where('id', $ins_id)->get()->getRowArray();
		$booking_settings = $this->db->table('booking_setting')->get()->getResultArray();
		$setting = array();
		if (count($booking_settings) > 0) {
		foreach ($booking_settings as $bs) {
			$setting[$bs['meta_key']] = $bs['meta_value'];
		}
		}
		$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();

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
		$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '1200')->get()->getRowArray();
		if (!empty($td_ledger)) {
		  $cr_id1 = $td_ledger['id'];
		} else {
		  $cled1['group_id'] = 3;
		  $cled1['name'] = 'TRADE RECEIVABLE';
		  $cled1['code'] = '1200/005';
		  $cled1['op_balance'] = '0';
		  $cled1['op_balance_dc'] = 'D';
		  $cled1['left_code'] = '1200';
		  $cled1['right_code'] = '005';
		  $this->db->table('ledgers')->insert($cled1);
		  $cr_id1 = $this->db->insertID();
		}

		$number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
		if (empty($number1))
			$num1 = 1;
		else
			$num1 = $number1['number'] + 1;
		$qry1 = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();

		$entries1['entry_code'] = 'JOR' . date('y', strtotime($data['date'])) . $mon . (sprintf("%05d", (((float) substr($qry1['entry_code'], -5)) + 1)));
		$entries1['entrytype_id'] = '4';
		$entries1['number'] = $num1;
		$entries1['date'] = date("Y-m-d", strtotime($data['date']));;
		$entries1['dr_total'] = $data['sub_total'];
		$entries1['cr_total'] = $data['sub_total'];
		$entries1['narration'] = 'Annathanam(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . "\n" . 'email:' . $data['email'] . "\n";
		$entries1['inv_id'] = $ins_id;
		$entries1['type'] = 12;
		$ent = $this->db->table('entries')->insert($entries1);
		$en_id1 = $this->db->insertID();

		$annathanam_details = $this->db->table('annathanam_packages')->where('id', $data['package_id'])->get()->getRowArray();

		if(!empty($annathanam_details['ledger_id'])){
			$dr_id = $annathanam_details['ledger_id'];
		} else {
			$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
			if(!empty($ledger1)){
				$dr_id = $ledger1['id'];
			} else {
				$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code','desc')->get()->getRowArray();
				$set_right_code = (int) $right_code['right_code'] + 1;
				$set_right_code = sprintf("%04d", $set_right_code);
				$lednew1['group_id'] = $sls_id;
				$lednew1['name'] = 'All Incomes';
				$lednew1['left_code'] = '8913';
				$lednew1['right_code'] = $set_right_code;
				$lednew1['op_balance'] = '0';
				$lednew1['op_balance_dc'] = 'D';
				$this->db->table('ledgers')->insert($lednew1);
				$dr_id = $this->db->insertID();
			}
		}
		$amount = (float) $annathanam_details['amount'] * $data['no_of_pax'];

		// Debit the Product's Ledger (dr_id)
		$eitems_d['entry_id'] = $en_id1;
		$eitems_d['ledger_id'] = $dr_id;
		$eitems_d['amount'] = $amount;
		$eitems_d['details'] = $annathanam_details['name_eng'] . '(' . $data['ref_no'] . ')';
		$eitems_d['dc'] = 'C';
		$cr_res = $this->db->table('entryitems')->insert($eitems_d);
		$debtor_amount += $amount;

		$booked_addon_cnt = $this->db->table("annathanam_booked_addon")->where("annathanam_id", $ins_id)->get()->getNumRows();
		if($booked_addon_cnt > 0){
			$booked_addon_details = $this->db->table("annathanam_booked_addon")->join('annathanam_items', 'annathanam_items.id = annathanam_booked_addon.item_id')->select('annathanam_items.*, annathanam_booked_addon.quantity')->where("annathanam_booked_addon.annathanam_id", $ins_id)->where('annathanam_items.add_on', 1)->get()->getResultArray();

			foreach($booked_addon_details as $row){
				if(!empty($row['ledger_id'])){
					$dr_id = $row['ledger_id'];
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
				$amount = (float) $row['amount'] * $row['quantity'];

				// Debit the Product's Ledger (dr_id)
				$eitems_d['entry_id'] = $en_id1;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $amount;
				$eitems_d['details'] = $row['name_eng'] . '(' . $data['ref_no'] . ')';
				$eitems_d['dc'] = 'C';
				$cr_res = $this->db->table('entryitems')->insert($eitems_d);
				$debtor_amount += $amount;

			}
		}

		// Credit Trade Receivable (trade_receivable_id)
		$eitems_c['entry_id'] = $en_id1;
		$eitems_c['ledger_id'] = $cr_id1;
		$eitems_c['amount'] = $debtor_amount;
		$eitems_c['details'] = 'Annathanam(' . $data['ref_no'] . ')';
		$eitems_c['dc'] = 'D';
		$deb_res = $this->db->table('entryitems')->insert($eitems_c);

		$data['discount_amount'] = !empty($data['discount_amount']) ? (float) $data['discount_amount'] : 0;
		if (!empty($data['discount_amount'])) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number) && empty($number1))
			  $num = 1;
			else
			  $num = $number['number'] + 1;
	  
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'JOR' . date('y', strtotime($data['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
			$entries['date'] = date("Y-m-d", strtotime($data['date']));
			$entries['number'] = $num;
			$entries['entrytype_id'] = '4';
			$entries['dr_total'] = $data['discount_amount']; // Assuming 'total_amount' is the field for total booking amount
			$entries['cr_total'] = $data['discount_amount'];
			$entries['narration'] = 'Annathanam(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . "\n" . 'email:' . $data['email'] . "\n";
			$entries['inv_id'] = $ins_id;
			$entries['type'] = '12';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id2 = $this->db->insertID();
	  
			$eitems_c = array();
			$eitems_c['entry_id'] = $en_id2;
			$eitems_c['ledger_id'] = $cr_id1;
			$eitems_c['amount'] = $data['discount_amount'];
			$eitems_c['details'] = 'Discount for Annathanam(' . $data['ref_no'] . ')';
			$eitems_c['dc'] = 'C';
			$deb_res = $this->db->table('entryitems')->insert($eitems_c);
	  
			$eitems_disc_ent = array();
			$discount_ledger_id = !empty($setting['discount_annathanam_ledger_id']) ? $setting['discount_annathanam_ledger_id'] : 43;
			$eitems_disc_ent['entry_id'] = $en_id2;
			$eitems_disc_ent['ledger_id'] = $discount_ledger_id;
			$eitems_disc_ent['amount'] = $data['discount_amount'];
			$eitems_disc_ent['is_discount'] = 1;
			$eitems_disc_ent['dc'] = 'D';
			$eitems_disc_ent['details'] = 'Discount for Annathanam(' . $data['ref_no'] . ')';
			$this->db->table('entryitems')->insert($eitems_disc_ent);
			// $tot_amount += $prasadam['discount_amount'];
			$debtor_amount -= $data['discount_amount'];
		  }

		$booked_pay_cnt = $this->db->table("annathanam_booked_pay_details")->where("annathanam_id", $ins_id)->get()->getNumRows();
		if($booked_pay_cnt > 0){
			$booked_pay_details = $this->db->table("annathanam_booked_pay_details")->where("annathanam_id", $ins_id)->get()->getRowArray();
			
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number))
				$num = 1;
			else
				$num = $number['number'] + 1;
			// Get Entry Code
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

			$entries['entry_code'] = 'REC' . date('y', strtotime($booked_pay_details['paid_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = $booked_pay_details['paid_date'];
			$entries['dr_total'] = $booked_pay_details['amount'];
			$entries['cr_total'] = $booked_pay_details['amount'];
			$entries['narration'] = 'Annathanam(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . "\n" . 'email:' . $data['email'] . "\n";
			$entries['inv_id'] = $ins_id;
			$entries['type'] = 12;
			//Insert Entries
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty($en_id)) {
				// Trade Debtors => Credit
				$eitems_hall_book['entry_id'] = $en_id;
				$eitems_hall_book['ledger_id'] = $cr_id1;
				$eitems_hall_book['amount'] = $booked_pay_details['amount'];
				$eitems_hall_book['dc'] = 'C';
				$eitems_hall_book['details'] = 'Annathanam Amount';
				$this->db->table('entryitems')->insert($eitems_hall_book);
				// PETTY CASH => Debit 
				$eitems_cash_led['entry_id'] = $en_id;
				$eitems_cash_led['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_cash_led['amount'] = $booked_pay_details['amount'];
				$eitems_cash_led['dc'] = 'D';
				$eitems_cash_led['details'] = 'Annathanam Amount';
				$this->db->table('entryitems')->insert($eitems_cash_led);
			}
		}
	}

	public function send_whatsapp_msg($id)
	{
		$data['data'] = $annathanam = $this->db->table('annathanam')->where('id', $id)->get()->getRowArray();
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['annathanam_items'] = $this->db->table('annathanam_item')
											->join('annathanam_vegetables','annathanam_vegetables.id = annathanam_item.vegetable_id')
											->select('annathanam_vegetables.name_eng,annathanam_vegetables.name_tamil')
											->where('annathanam_item.annathanam_id', $id)
											->get()
											->getResultArray();
		if (!empty ($annathanam['phone_no'])) {
			$html = view('frontend/annathanam/pdf', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled' => true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/invoice_annathanam_' . $id . '.pdf';

			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$message_params[] = $annathanam['name'];
			$message_params[] = $annathanam['slot_time'];
			$message_params[] = $annathanam['total_amount'];
			$media['url'] = base_url() . '/uploads/documents/invoice_annathanam_' . $id . '.pdf';
			$media['filename'] = 'annathanam_invoice.pdf';
			$annathanam['phone_code'] = !empty($annathanam['phone_code']) ? $annathanam['phone_code'] : '+60';
			$mobile_number = $annathanam['phone_code'] . $annathanam['phone_no'];
			// $mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'annadhanam_live', $media);
			//print_r($whatsapp_resp);
			//echo $whatsapp_resp['success'];
			/* if($whatsapp_resp['success']) */
		}
	}

	public function save_annathanam_old(){
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$this->db->transStart();
		try{
			// Receive data from POST request
			$data['name'] = $_POST['name'];
			$data['phone_code'] = $_POST['phone_code'];
			$data['phone_no'] = $_POST['phone_no'];
			$data['slot_time'] = $_POST['time'];
			$data['package_id'] = $_POST['package_id'];
			$data['dob'] = $_POST['dob'];
			$data['amount'] = $_POST['amount'];
			$data['no_of_pax'] = $_POST['no_of_pax'];
			$data['total_amount'] = $_POST['total_amount'];
			$data['payment_type'] = !empty($_POST['payment_type']) ? $_POST['payment_type']: 'full';
			$data['booking_through'] = 'COUNTER';
			$pay_method = (!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
			//$data['payment_status'] = (($pay_method == 'cash' || $pay_method == 'online' || $pay_method == 'qr' || $pay_method == 'nets_pay' || $pay_method == 'pay_now' || $pay_method == 'cheque') ? 2 : 1);

			$items = json_decode($_POST['pack_items'], true);
			$addon_items = json_decode($_POST['addon_pack_items'], true);
		
			
			$yr= date('Y', strtotime($_POST['date']));
			$mon= date('m', strtotime($_POST['date']));
			$query = $this->db->query("SELECT ref_no FROM annathanam_new WHERE id=(SELECT max(id) FROM annathanam_new WHERE year(date)='". $yr ."' AND month(date)='". $mon ."')")->getRowArray();
			$data['ref_no'] = 'AT' .date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
			$data['date'] = date('Y-m-d', strtotime($_POST['date']));
			$data['event_date'] = date('Y-m-d', strtotime($_POST['event_date']));
			$data['added_by'] = $this->session->get('log_id_frend');
			$data['created'] = date('Y-m-d H:i:s');
			
			$pay_method = (!empty ($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
			$query = "SELECT id FROM payment_mode WHERE LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = LOWER(REPLACE(REPLACE(REPLACE(?, ' ', ''), '_', ''), '-', '')) AND paid_through = 'COUNTER' ";	
			$result = $this->db->query($query, [$pay_method])->getRowArray();
			$payment_mode = $result['id'];
			$data['payment_mode'] = $payment_mode;
	
			$res = $this->db->table('annathanam_new')->insert($data);
			$annathanam_id = $this->db->insertID();
	
			if(!empty($items)){
				foreach ($items as $item) {
					$data_item = array(
						'annathanam_id' => $annathanam_id,
						'package_id' => $data['package_id'],
						'item_id' => $item['item_id'],
						'add_on' => $item['add_on']
					);
					$res = $this->db->table('annathanam_booked_items')->insert($data_item);
				}
			}
	
			if(!empty($addon_items)){
				foreach ($addon_items as $addon_item) {
					$data_addon_item = array(
						'annathanam_id' => $annathanam_id,
						'package_id' => $data['package_id'],
						'item_id' => $addon_item['item_id'],
						'item_amount' => $addon_item['item_amount'],
						'item_total_amount' => $addon_item['item_total_amount'],
						'add_on' => $addon_item['add_on']
					);
					$this->db->table('annathanam_booked_addon')->insert($data_addon_item);
				}
			}
			$pay_details = array();
			// if($pay_method == 'cash') $payment_mode_id = 6;
			// if($pay_method == 'online') $payment_mode_id = 8;
			// if($pay_method == 'qr') $payment_mode_id = 9;
			// if($pay_method == 'nets_pay') $payment_mode_id = 10;
			// if($pay_method == 'cheque') $payment_mode_id = 12;
			// if($pay_method == 'pay_now') $payment_mode_id = 13;
			// $count = $this->db->table("payment_mode")->where('id', $payment_mode_id)->get()->getNumRows();
			if($payment_mode){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
				$pay_details['payment_key'] = $pay_method;
				$pay_details['annathanam_id'] = $annathanam_id;
				$pay_details['is_repayment'] = 0;
				$pay_details['payment_mode_id'] = $payment_mode;
				$pay_details['paid_through'] = 'COUNTER';
				$pay_details['pay_status'] = (($pay_method == 'cash' || $pay_method == 'online' || $pay_method == 'qr' || $pay_method == 'card' ) ? 2 : 1);
				$pay_details['payment_mode_title'] = $payment_mode_details['name'];
				$pay_details['booking_ref_no'] = $data['ref_no'];
				if($data['payment_type'] == 'partial') $pay_details['amount'] = $_POST['paid_amount'];
				else $pay_details['amount'] = $data['total_amount'];
				if(empty($pay_details['amount'])){
					$this->db->transRollback();
					echo 'Invalid Amount';
					$redirect_url = base_url("/annathanam_counter");
					echo <<<PPR
						<script>
						setTimeout(function(){
							location.href = '$redirect_url';
						}, 3500);
						</script>
					PPR;
					exit;
				}
				$pay_details['paid_date'] = date('Y-m-d');
				$this->requestmodel = new RequestModel();
				$ip = $this->requestmodel->getIpAddress();
				$pay_details['ip'] = $ip;
				if ($ip != 'unknown') {
					$ip_details = $this->requestmodel->getLocation($ip);
					$pay_details['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
					$pay_details['ip_details'] = json_encode($ip_details);
				}
				$this->db->table('annathanam_booked_pay_details')->insert($pay_details);
				$booking_ref_data = array();
				$booking_ref_data['paid_amount'] = $pay_details['amount'];
				if($data['payment_type'] == 'partial'){ 
					$booking_ref_data['payment_status'] = 1;
				}else {
					$booking_ref_data['payment_status'] = 2;
				}
				$booking_ref_data['booking_status'] = 1;
				$this->db->table("annathanam_new")->where('id', $annathanam_id)->update($booking_ref_data);

				$payment_gateway_data = array();
				$payment_gateway_data['annathanam_booking_id'] = $annathanam_id;
				$payment_gateway_data['pay_method'] = $pay_method;
				$this->db->table('annathanam_payment_gateway_datas')->insert($payment_gateway_data);

			}else{
				$this->db->transRollback();
				echo 'Invalid Payment';
				$redirect_url = base_url("/annathanam_counter");
				echo <<<PPR
					<script>
					setTimeout(function(){
						location.href = '$redirect_url';
					}, 3500);
					</script>
				PPR;
				exit;
			}

			$this->account_migration($annathanam_id);
			$this->db->transComplete();
			return redirect()->to(base_url("/annathanam_counter?annathanam_id=$annathanam_id"));
		}catch (Exception $e) {
			$this->db->transRollback();
			echo $e->getMessage();
			$redirect_url = base_url("/annathanam_counter");
			echo <<<PPR
			<script>
			setTimeout(function(){
				location.href = '$redirect_url';
			}, 3500);
			</script>
PPR;
		}
	}


}
