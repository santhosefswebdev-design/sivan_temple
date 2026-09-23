<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Hallbooking_online extends BaseController
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

	public function index_old()
	{
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking/index');
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

	public function hall()
	{
		$login_id = $_SESSION['log_id_frend'];
		$default_group = $this->db->query("SELECT * FROM ubayam_group order by id asc limit 1")->getRowArray();
		$data['default'] = str_replace(' ', '_', strtolower($default_group['name']));
		$data['res'] = $this->db->table('templebooking')->select('id')->where("booking_type", 1)->orderBy('id', 'desc')->get()->getRowArray();
		$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['package'] = array();
		$data['package_addon'] = array();
		$data['reprintlists'] = $this->db->query("SELECT id,paid_amount,ref_no,entry_date FROM templebooking WHERE created_by = '" . $login_id . "' and booking_through = 'COUNTER' AND payment_status = 2 and booking_type = 1 ORDER BY id DESC LIMIT 3")->getResultArray();
		$cur_date = date('Y-m-d');
		$data['venues'] = $this->db->table('venue')->where('status', 1)->get()->getResultArray();
		$ubayam_datas = $this->db->query("SELECT  tu.*, bp.name as event_name ,bs.slot_name FROM  templebooking tu 
		JOIN booked_packages bp ON tu.id = bp.booking_id LEFT JOIN booked_slot bs ON tu.id = bs.booking_id where ((tu.booking_through != 'DIRECT' and tu.booking_status in (1,2)) or (tu.booking_through = 'DIRECT')) and tu.booking_status != 3 and tu.booking_type = 1 
		ORDER BY tu.created_at ASC;")->getResultArray();
		$ubayamdata = array();
		if (!empty($ubayam_datas)) {
			foreach ($ubayam_datas as $ubayam_data) {
				$h_dat = array(
					"year" => intval(date("Y", strtotime($ubayam_data['booking_date']))),
					"month" => intval(date("m", strtotime($ubayam_data['booking_date']))),
					"day" => intval(date("d", strtotime($ubayam_data['booking_date']))),
					"event_id" => $ubayam_data['id'],
					"venue_id" => $ubayam_data['venue'],
					"ref_no" => $ubayam_data['ref_no'],
					"otb" => 0,
					"name" => $ubayam_data['name'],
					"slot" => $ubayam_data['slot_name'],
					"event_name" => $ubayam_data['event_name'],
					"register_by" => $ubayam_data['name']
				);
				$bal_amt= $ubayam_data['amount'] - $ubayam_data['paid_amt'];
				$h_dat['repay'] = false;
				if ($bal_amt > 0)
					$h_dat['repay'] = true;
				$ubayamdata["events"][] = $h_dat;
			}
		} else {
			$ubayamdata["events"][] = array();
		}
		// $overall_temple_hall_blocking_datas = $this->db->table('overall_temple_block')
		// 					->select("date as booking_date,description as register_by")
		// 					->get()->getResultArray();
		// if (!empty($overall_temple_hall_blocking_datas)) {
		// 	foreach ($overall_temple_hall_blocking_datas as $overall_temple_blocking_data) {
		// 		$ubayamdata["events"][] = array(
		// 			"year" => intval(date("Y", strtotime($overall_temple_blocking_data['booking_date']))),
		// 			"month" => intval(date("m", strtotime($overall_temple_blocking_data['booking_date']))),
		// 			"day" => intval(date("d", strtotime($overall_temple_blocking_data['booking_date']))),
		// 			"event_id" => 0,
		// 			"ref_no" => "",
		// 			"otb" => 1,
		// 			"repay" => false,
		// 			"name" => "ADMIN",
		// 			"event_name" => "OVERALL TEMPLE BLOCK.",
		// 			"register_by" => "ADMIN"
		// 		);
		// 	}
		// } else {
		// 	$ubayamdata["events"][] = array();
		// }
		$data['ubayams'] = json_encode($ubayamdata);
		$data['time_list'] = $this->db->table("booking_slot_new")
							->select("booking_slot_new.*, booking_slot_type_new.*")
							->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
							->where("booking_slot_type_new.slot_type", 1)
							->where("booking_slot_new.status", 1)
							->get()
							->getResultArray();
		$booking_settings = $this->db->table('booking_setting')->get()->getResultArray();
		$setting = array();
		if(count($booking_settings) > 0){
			foreach($booking_settings as $bs){
				$setting[$bs['meta_key']] = $bs['meta_value'];
			}
		}
		$data['setting'] = $setting;
		echo view('frontend/layout/header');
		echo view('frontend/hallbooking_new/ubayam', $data);
	}

	public function get_natchathram()
	{
		$rasi_id = $_POST['rasi_id'];
		$res = $this->db->table('rasi')->where('id', $rasi_id)->get()->getRowArray();
		if (!empty ($res['natchathra_id'])) {
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
		$res = $this->db->table('natchathram')->where('id', $id)->get()->getRowArray();
		$data = array("id" => $res['id'], "name_eng" => $res['name_eng']);
		echo json_encode($data);
		exit;
	}
    public function loadbookingslots()
	{
		try {
			$html = "";
			$booking_type = 1;
			$booking_date = $_POST['bookeddate'];
			$pack_id = !empty($_POST['pack_id']) ? $_POST['pack_id'] : '';
			$user_id = $this->session->get('log_id_frend');
            // Count user existence and get details if valid
            $user_cnt = $this->db->table('login')
                ->where('id', $user_id)
                ->where('status', 1)
                ->countAllResults();

            if ($user_cnt > 0) {
                $user_details = $this->db->table('login')
                    ->where('id', $user_id)
                    ->where('status', 1)
                    ->get()->getRow();
            } else {
                $resp['status'] = false;
                $resp['error_msg'] = 'Invalid User';
                echo json_encode($resp);
				exit;
            }
			
			$over_block_cnt =  $this->db->table('overall_temple_block')->where('date', $booking_date)->countAllResults();
			if($over_block_cnt > 0){
				$resp['status'] = false;
				$resp['html'] = $html;
				$resp['error_msg'] = 'Admin Blocks All Event in the date';
				echo json_encode($resp);
				exit;
			}else{
				$time_list = [];
				$builder = $this->db->table('booking_slot_new as bsn')
					->join('booking_slot_type_new as bstn', 'bsn.id = bstn.booking_slot_id', 'left')
					->where('bstn.slot_type', $booking_type)
					->where('bsn.status', 1)
					->whereNotIn('bsn.id', function ($builder) use ($booking_date, $booking_type) {
						return $builder->select('booking_slot_id')
							->from('temple_session_block')
							->where('date', $booking_date)
							->where('event_type', $booking_type);
					});

				if (!empty($pack_id)) {
					$builder->whereIn('bsn.id', function ($builder) use ($pack_id) {
						return $builder->select('slot_id')
							->from('temple_package_slots')
							->where('package_id', $pack_id);
					})
					->whereExists(function ($builder) use ($booking_date, $pack_id) {
						return $builder->select('1')
							->from('temple_package_date')
							->where('pack_date', $booking_date)
							->where('package_id', $pack_id);
					});
				}

				if ($user_details->role != 91) {
					$builder->whereNotIn('bsn.id', function ($builder) use ($booking_date, $booking_type) {
						return $builder->select('booking_slot_id')
							->from('temple_session_spl_event')
							->where('date', $booking_date)
							->where('event_type', $booking_type);
					});
				}

				$builder->whereNotIn('bsn.id', function ($builder) use ($booking_date, $booking_type) {
					return $builder->select('bs.booking_slot_id')
						->from('booked_packages as bp')
						->join('templebooking as tb', 'tb.id = bp.booking_id', 'left')
						->join('booked_slot as bs', 'bs.booking_id = tb.id', 'left')
						->join('temple_packages as tp', 'tp.id = bp.package_id', 'left')
						->where('tb.booking_date', $booking_date)
						->where('tb.booking_type', $booking_type)
						->whereNotIn('tb.booking_status', [3])
						->where('tp.package_mode', 1);
				});

				$slot_cnt = $builder->countAllResults();
				if ($slot_cnt > 0) {
					$builder = $this->db->table('booking_slot_new as bsn')
						->join('booking_slot_type_new as bstn', 'bsn.id = bstn.booking_slot_id', 'left')
						->where('bstn.slot_type', $booking_type)
						->where('bsn.status', 1)
						->whereNotIn('bsn.id', function ($builder) use ($booking_date, $booking_type) {
							return $builder->select('booking_slot_id')
								->from('temple_session_block')
								->where('date', $booking_date)
								->where('event_type', $booking_type);
						});
					if (!empty($pack_id)) {
						$builder->whereIn('bsn.id', function ($builder) use ($pack_id) {
							return $builder->select('slot_id')
								->from('temple_package_slots')
								->where('package_id', $pack_id);
						})
						->whereExists(function ($builder) use ($booking_date, $pack_id) {
							return $builder->select('1')
								->from('temple_package_date')
								->where('pack_date', $booking_date)
								->where('package_id', $pack_id);
						});
					}

					if ($user_details->role != 91) {
						$builder->whereNotIn('bsn.id', function ($builder) use ($booking_date, $booking_type) {
							return $builder->select('booking_slot_id')
								->from('temple_session_spl_event')
								->where('date', $booking_date)
								->where('event_type', $booking_type);
						});
					}

					$builder->whereNotIn('bsn.id', function ($builder) use ($booking_date, $booking_type) {
						return $builder->select('bs.booking_slot_id')
							->from('booked_packages as bp')
							->join('templebooking as tb', 'tb.id = bp.booking_id', 'left')
							->join('booked_slot as bs', 'bs.booking_id = tb.id', 'left')
							->join('temple_packages as tp', 'tp.id = bp.package_id', 'left')
							->where('tb.booking_date', $booking_date)
							->where('tb.booking_type', $booking_type)
							->whereNotIn('tb.booking_status', [3])
							->where('tp.package_mode', 1);
					});

					$time_list = $builder->get()->getResultArray();
				}
				if(count($time_list) > 0){
					foreach ($time_list as $row) {
						$disabled = "";
						$checkbox_style = '';
						$label_style = '';
						$html .= '<td>
							<input style="left: 2%; opacity: 1; position: inherit;" type="radio" class="booking_slot" name="booking_slot[]" value="' . $row['id'] . '"> ' . $row['slot_name'] . '
						</td>
						';
					}
					$resp['status'] = true;
					$resp['html'] = $html;
					$resp['error_msg'] = 'Slots Available';
				}else{
					$resp['status'] = false;
					$resp['html'] = $html;
					$resp['error_msg'] = 'No Slots Available';
				}
				echo json_encode($resp);
				exit;
			}
		}catch (\Exception $e) {
			$resp['status'] = false;
			$resp['error_msg'] = $e->getMessage();
			echo json_encode($resp);
			exit;
        }
	}
	public function loadbookingslots_original()
	{
		$date = $_POST['bookeddate'];
		// $res = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
		// $data_time = array();
		// $time_name = array();
		// $i = 0;  //echo '<pre>';
		// foreach ($res as $r) {
		// 	$ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
		// 	// print_r($ds);
		// 	foreach ($ds as $rr) {
		// 		if (!empty($rr)) {
		// 			$data_time[] = $rr['booking_slot_id'];
		// 			$time_name[$rr['booking_slot_id']] = $r['name'];
		// 		}
		// 	}
		// }

		// //SLOT BLOCKED BOOKING
		// $data_blocked_time = array();
		// $res_blocked = $this->db->table("block_date")->select("date, description")->where("date", $date)->get()->getResultArray();
		// foreach ($res_blocked as $res_block) {
		// 	$data_blocked_time[] = 1;
		// 	$data_blocked_time[] = 2;
		// 	$data_blocked_time[] = 3;
		// }
		// //END SLOT BLOCKED BOOKING
		$html = "";
		// $time_list = $this->db->table("booking_slot")->get()->getResultArray();
		// $time_list = $this->db->table("booking_slot_new")
		// ->select("booking_slot_new.*, booking_slot_type_new.*")
		// ->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
		// ->where("booking_slot_type_new.slot_type", 2)
		// ->where("booking_slot_new.status", 1)
		// ->get()
		// ->getResultArray();
		$subquery = "SELECT booking_slot_id FROM temple_session_block WHERE date = '{$date}' AND event_type = booking_slot_type_new.slot_type";
			$subquery2 = "SELECT booking_slot_id FROM temple_session_spl_event WHERE date = '{$date}' AND event_type = booking_slot_type_new.slot_type";

			$time_list = $this->db->table("booking_slot_new")
					->select("booking_slot_new.*, booking_slot_type_new.*")
					->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
					->where("booking_slot_type_new.slot_type", 1)
					->where("booking_slot_new.status", 1)
					->where("booking_slot_new.id NOT IN ({$subquery})", NULL, false) 
					->where("booking_slot_new.id NOT IN ({$subquery2})", NULL, false) 
					->get()
					->getResultArray();
		foreach ($time_list as $row) {
			// if (in_array($row['id'], $data_time)) {
			// 	$disabled = "disabled";
			// 	$t_name = $time_name[$row['id']];
			// 	$checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
			// 	$label_style = 'cursor: no-drop;';
			// } else if (in_array($row['id'], $data_blocked_time)) {
			// 	$disabled = "disabled";
			// 	$t_name = '';
			// 	$checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
			// 	$label_style = 'cursor: no-drop;';
			// } else {
			// 	$disabled = "";
			// 	$t_name = '';
			// 	$checkbox_style = "";
			// 	$label_style = "";
			// }
			// ;
			$disabled = "";
			$checkbox_style = '';
				$label_style = '';
		// 		$html .= '<div class="box">
        //       <div>
        //           <input type="checkbox" class="" name="booking_slot" value="' . $row["id"] . '" id="timing' . $row["id"] . '" ' . $disabled . ' style="' . $checkbox_style . '">
        //       </div>
        //       <label for="timing' . $row["id"] . '" style="' . $label_style . '">
        //           <p id="timing' . $row["id"] . '">' . $row["slot_name"] . '</p>
        //       </label>
        //   </div>';
		$html .= '<td>
			<input style="left: 2%; opacity: 1; position: inherit;" type="radio" class="booking_slot" name="booking_slot" value="' . $row['id'] . '"> ' . $row['slot_name'] . '
		</td>';

		}
		echo $html;
	}
	public function get_payfor_collection()
	{
		$id = $_POST['id'];
		$res = $this->db->table("temple_packages")->where("id", $id)->get()->getRowArray();
		//$amt = $res['amount'] + $res['commision'];

		$amt = $res['amount'];
		$data['amt'] = $amt;
		$data['name'] = $res['name'];
		$data['deposit_amount'] = $res['deposit_amount'];
		$data['advance_amount'] = $res['advance_amount'];
		// $resp['data']['addons'] =  $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id in ($pack_id))")->getResultArray();
		$services = $this->db->query("SELECT ts.name, ts.description, tps.quantity FROM temple_services ts JOIN temple_package_services tps ON ts.id = tps.service_id WHERE tps.package_id = ? AND ts.status = 1 ", [$id])->getResultArray();
		$addons = $this->db->query("SELECT * FROM temple_services WHERE id IN(SELECT service_id FROM temple_package_addons WHERE package_id = ?)", [$id])->getResultArray();
		
		$data['services'] = $services;
		$data['addons'] = $addons;
		echo json_encode($data);
		// $res = $this->db->table('ubayam_setting')->where('id', $id)->get()->getRowArray();
		// echo !empty($res['amount']) ? $res['amount'] : 0;
	}

	public function getpack_amt_addon()
	{
	  $id = $_POST['id'];
	  $res = $this->db->table("temple_services")->where("id", $id)->get()->getRowArray();
	  //$amt = $res['amount'] + $res['commision'];
	  $amt = $res['amount'];
	  $data['amt'] = $amt;
	  $data['name'] = $res['name'];
	  echo json_encode($data);
	}

	public function get_service_list_addon()
	{
		$addon_id = $_POST['id'];
		$package_id = $_POST['package_id'];
		$get_result_details = $this->db->table("temple_services")->join('temple_package_addons', 'temple_package_addons.service_id = temple_services.id')->select('temple_services.*, temple_package_addons.quantity')->where("temple_package_addons.package_id", $package_id)->where("temple_package_addons.service_id", $addon_id)->get()->getResultArray();
		echo json_encode($get_result_details);
	}
	public function get_service_name_addon()
  {
    $id = $_POST['id'];
    $res = $this->db->table("temple_services")->where("id", $id)->get()->getRowArray();
    $data['name'] = $res['name'];
    $data['amount'] = $res['amount'];
    $data['description'] = $res['description'];
    echo json_encode($data);
  }

	public function book()
	{
		$login_id = $_SESSION['log_id_frend'];
		$data['time_list'] = $this->db->table("booking_slot")->get()->getResultArray();
		$data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$hall_booking_datas = $this->db->table('hall_booking')
			->select("id,booking_date,register_by,name,ref_no,event_name")
			->where("paid_through", "COUNTER")
			->where("entry_by", $login_id)
			->get()->getResultArray();
		$hallbookdata = array();
		if (!empty($hall_booking_datas)) {
			foreach ($hall_booking_datas as $hall_booking_data) {
				$hallbookdata["events"][] = array(
					"year" => intval(date("Y", strtotime($hall_booking_data['booking_date']))),
					"month" => intval(date("m", strtotime($hall_booking_data['booking_date']))),
					"day" => intval(date("d", strtotime($hall_booking_data['booking_date']))),
					"event_id" => $hall_booking_data['id'],
					"ref_no" => $hall_booking_data['ref_no'],
					"name" => $hall_booking_data['name'],
					"event_name" => $hall_booking_data['event_name'],
					"register_by" => $hall_booking_data['register_by']
				);
			}
		} else {
			$hallbookdata["events"][] = array();
		}
		//var_dump(json_encode($hallbookdata));
		//exit;
		$data['hall_booking'] = json_encode($hallbookdata);
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking_new/index1', $data);
		echo view('frontend/layout/footer');
	}

	public function loadbookingslots_old()
	{
		$date = $_POST['bookeddate'];
		// $res = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
		// $data_time = array();
		// $time_name = array();
		// $i = 0;  //echo '<pre>';
		// foreach ($res as $r) {
		// 	$ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
		// 	// print_r($ds);
		// 	foreach ($ds as $rr) {
		// 		if (!empty($rr)) {
		// 			$data_time[] = $rr['booking_slot_id'];
		// 			$time_name[$rr['booking_slot_id']] = $r['name'];
		// 		}
		// 	}
		// }

		// //SLOT BLOCKED BOOKING
		// $data_blocked_time = array();
		// $res_blocked = $this->db->table("block_date")->select("date, description")->where("date", $date)->get()->getResultArray();
		// foreach ($res_blocked as $res_block) {
		// 	$data_blocked_time[] = 1;
		// 	$data_blocked_time[] = 2;
		// 	$data_blocked_time[] = 3;
		// }
		// //END SLOT BLOCKED BOOKING
		$html = "";
		// $time_list = $this->db->table("booking_slot")->get()->getResultArray();

		$time_list = $this->db->table("booking_slot_new")
		->select("booking_slot_new.*, booking_slot_type_new.*")
		->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
		->where("booking_slot_type_new.slot_type", 2)
		->where("booking_slot_new.status", 1)
		->get()
		->getResultArray();
		foreach ($time_list as $row) {
			// if (in_array($row['id'], $data_time)) {
			// 	$disabled = "disabled";
			// 	$t_name = $time_name[$row['id']];
			// 	$checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
			// 	$label_style = 'cursor: no-drop;';
			// } else if (in_array($row['id'], $data_blocked_time)) {
			// 	$disabled = "disabled";
			// 	$t_name = '';
			// 	$checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
			// 	$label_style = 'cursor: no-drop;';
			// } else {
			// 	$disabled = "";
			// 	$t_name = '';
			// 	$checkbox_style = "";
			// 	$label_style = "";
			// }
			// ;
			$disabled = "";
			$checkbox_style = 'border: 2px solid #f61f1f !important;background: #f16e6e !important;';
				$label_style = 'cursor: no-drop;';
			$html .= '<div class="box">
              <div>
                  <input type="checkbox" class="slot" name="timing[]" value="' . $row["id"] . '" id="timing' . $row["id"] . '" ' . $disabled . ' style="' . $checkbox_style . '">
              </div>
              <label for="timing' . $row["id"] . '" style="' . $label_style . '">
                  <p id="timing' . $row["id"] . '">' . date("g:i A", strtotime($row["name"])) . ' - ' . date("g:i A", strtotime($row["description"])) . '</p>
              </label>
          </div>';
		}
		echo $html;
	}
	public function hallbook_list()
	{
		$login_id = $_SESSION['log_id_frend'];
		$data['permission'] = $this->model->get_permission('hall_booking');
		$date = $_REQUEST['date'];
		$data['list'] = $this->db->table("hall_booking")->where("DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')", $date)->where("entry_by", $login_id)->get()->getResultArray();
		$data['date'] = $date;
		// print_r($data);die;
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking/hallbooklist', $data);
		echo view('frontend/layout/footer');
	}

	public function list_booking_repay($hall_booking_id)
	{
		$login_id = $_SESSION['log_id_frend'];
		$data['hall_datas'] = $this->db->table("hall_booking")->where("id", $hall_booking_id)->where("entry_by", $login_id)->get()->getRowArray();
		$data['date'] = $date;
		// print_r($data);die;
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking/hallbookrepay', $data);
		echo view('frontend/layout/footer');
	}

	public function add_booking()
	{
		/*if(!$this->model->permission_validate('hall_booking', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}*/
		$date = $this->request->uri->getSegment(3);
		$res = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
		//      $result = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $res['booking_date'])->where("status<>", 3)->get()->getResultArray();

		$data_time = array();
		$time_name = array();
		$i = 0;  //echo '<pre>';
		foreach ($res as $r) {
			$ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
			// print_r($ds);
			foreach ($ds as $rr) {
				if (!empty($rr)) {
					$data_time[] = $rr['booking_slot_id'];
					$time_name[$rr['booking_slot_id']] = $r['name'];
				}
			}
		}
		//die;
		$data['date'] = $date;
		$data['data_time'] = $data_time;
		$data['time_name'] = $time_name;
		$data['time_list'] = $this->db->table("booking_slot")->get()->getResultArray();
		$data['staff'] = $this->db->table("staff")->get()->getResultArray();
		$data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking/add_booking', $data);
		echo view('frontend/layout/footer');
	}
	public function edit_booking()
	{
		/*if(!$this->model->permission_validate('hall_booking','edit')){
				header('Location: '.base_url().'/dashboard');			
			}*/
		$id = $this->request->uri->getSegment(3);

		$res = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		if ($res['status'] != 1) {
			header('Location: ' . base_url() . '/booking/view/' . $id);
		}
		$result = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $res['booking_date'])->where("status<>", 3)->get()->getResultArray();

		$data_time = array();
		$time_name = array();
		$own_time = array();
		$i = 0;
		$time_res = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $id)->get()->getResultArray();

		foreach ($time_res as $row) {
			if (!empty($row)) {
				$own_time[] = $row["booking_slot_id"];
			}
		}

		//print_r($own_time);die;
		foreach ($result as $r) {
			$ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
			foreach ($ds as $rr) {
				if (!empty($rr)) {
					$data_time[] = $rr['booking_slot_id'];
					$time_name[$rr['booking_slot_id']] = $r['name'];
				}
			}
		}

		//die;
		$data['data'] = $res;
		$data['date'] = $date;
		$data['data_time'] = $data_time;
		$data['time_name'] = $time_name;
		$data['own_time'] = $own_time;
		$data['package_list'] = $this->db->table('hall_booking_details', 'booking_addonn.name')
			->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')
			->select('booking_addonn.name')
			->select('hall_booking_details.*,(hall_booking_details.amount+hall_booking_details.commission) as tot')
			->where('hall_booking_details.hall_booking_id', $id)
			->get()->getResultArray();
		//        echo '<pre>';
		// print_r($data['package_list']);
		// exit;
		$data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
		$data['time_list'] = $this->db->table("booking_slot")->get()->getResultArray();
		$data['staff'] = $this->db->table("staff")->get()->getResultArray();
		$data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking/edit_hallbooking', $data);
		echo view('frontend/layout/footer');
	}

	public function getpack_amt()
	{
		$pack_id = $_POST['id'];
		$get_result_details = $this->db->table("booking_addonn_service")->join('service', 'service.id = booking_addonn_service.service_id')->select('booking_addonn_service.*,service.name as service_name,service.description as service_description')->where("booking_addon_id", $pack_id)->get()->getResultArray();
		echo json_encode($get_result_details);
	}
	public function get_service_name()
	{
		$id = $_POST['id'];
		$res = $this->db->table("service")->where("id", $id)->get()->getRowArray();
		$data['name'] = $res['name'];
		$data['amount'] = $res['amount'];
		$data['description'] = $res['description'];
		echo json_encode($data);
	}
	public function save_booking()
	{
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['event_date']);
		$yr = $date[0];
		$mon = $date[1];
		$query = $this->db->query("SELECT ref_no FROM hall_booking where id=(select max(id) from hall_booking where year (booking_date)='" . $yr . "' and month (booking_date)='" . $mon . "')")->getRowArray();
		$data = array();
		$data['ref_no'] = 'HA' . date('y', strtotime($_POST['event_date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['booking_date'] = $_POST['event_date'];
		$data['booking_time'] = date("H:i:s");
		$data['event_name'] = trim($_POST['event_name']);
		$data['register_by'] = !empty($_POST['register']) ? trim($_POST['register']) : '';
		$data['name'] = trim($_POST['name']);
		$data['status'] = 1;
		$data['address'] = trim($_POST['address']);
		$mble_phonecode = !empty($_POST['phonecode']) ? $_POST['phonecode'] : "";
		$mble_number = !empty($_POST['mobile']) ? $_POST['mobile'] : "";
		$data['mobile_number'] = $mble_phonecode . $mble_number;
		$data['email'] = trim($_POST['email']);
		$data['ic_no'] = trim($_POST['ic_num']);
		$data['city'] = trim($_POST['city']);
		$data['total_amount'] = trim($_POST['total_amt']);
		$data['paid_amount'] = trim($_POST['total_amt']);
		// $payfor_total_amt_re = !empty($_POST['payfor_total_amt']) ? $_POST['payfor_total_amt'] : 0;
		// $balance_amt = trim($_POST['total_amt']) - $payfor_total_amt_re;
		// $data['balance_amount'] = $balance_amt;
		$data['paid_through'] = "COUNTER";
		$pay_method = (!empty($_POST['pay_method']) ? $_POST['pay_method'] : 'cash');
		$data['payment_status'] = ($pay_method == 'cash' ? 2 : 1);
		$data['entry_date'] = date("Y-m-d");
		$data['entry_by'] = $this->session->get('log_id_frend');
		$data['created'] = date("Y-m-d H:i:s");
		$data['modified'] = date("Y-m-d H:i:s");

		$payfor_thirty_percent_amt = $_POST['payfor_thirty_percent_amt'];
		$payfor_total_amt = $payfor_total_amt_re;
		if (!empty($data['booking_date']) && !empty($data['event_name']) && !empty($data['name']) && !empty($data['mobile_number'])) {
			if ($payfor_thirty_percent_amt > $payfor_total_amt) {
				$this->session->setFlashdata('fail', 'Please Try Again');
				$msg_data['err'] = 'Please enter atleast 30% amount of full amount.';
			} else {
				$res = $this->db->table("hall_booking")->insert($data);
				//$whatsapp_resp = whatsapp_aisensy($data['mobile_number'], [], 'success_message1');
				if ($res) {
					$id = $this->db->insertID();
					/* if(!empty($_POST['pay_for'])){
									$total_amt = 0;
									foreach($_POST['pay_for'] as $row){
										  if(!empty($row['pack_amt']))
										  {
											 $packdata = array();
											$packdata['hall_booking_id']  = $id;
											$packdata['booking_addon_id'] = $row['pack_id'];
											$sign_pack_amt = $row['pack_amt'];
											$sign_pack_com = 0;
											$packdata['amount']     = $sign_pack_amt;
											$packdata['commission'] = $sign_pack_com;
											$packdata['created']     = date("Y-m-d H:i:s");
											$packdata['updated']     = date("Y-m-d H:i:s");
											$this->db->table("hall_booking_details")->insert($packdata);
											$total_amt += $row['pack_amt'];
										  }
									}
								} */
					if (!empty($_POST['service'])) {
						foreach ($_POST['service'] as $row) {
							$packdata = array();
							$packdata['hall_booking_id'] = $id;
							$packdata['service_id'] = $row['service_id'];
							$packdata['service_name'] = $row['service_name'];
							$packdata['service_description'] = $row['description'];
							$packdata['service_amount'] = $row['service_amt'];
							$packdata['created'] = date("Y-m-d H:i:s");
							$packdata['modified'] = date("Y-m-d H:i:s");
							$this->db->table("hall_booking_service_details")->insert($packdata);
						}
					}
					$final_amount = $_POST['payfor_total_amt'];
					$paydata['hall_booking_id'] = $id;
					$paydata['date'] = $data['entry_date'];
					$paydata['amount'] = $final_amount;
					$paydata['payment_mode'] = $pay_method == 'cash' ? 6 : 4;
					$paydata['created'] = date("Y-m-d H:i:s");
					$paydata['updated'] = date("Y-m-d H:i:s");
					$this->db->table("hall_booking_pay_details")->insert($paydata);
					if (!empty($_POST['timing'])) {
						foreach ($_POST['timing'] as $key => $value) {
							$slotdata['hall_booking_id'] = $id;
							$slotdata['booking_slot_id'] = $value;
							$this->db->table("hall_booking_slot_details")->insert($slotdata);
						}
					}
					$payment_gateway_data = array();
					$payment_gateway_data['hall_booking_id'] = $id;
					$payment_gateway_data['pay_method'] = $pay_method;
					$this->db->table('hall_booking_payment_gateway_datas')->insert($payment_gateway_data);
					$archanai_payment_gateway_id = $this->db->insertID();
					if ($data['payment_status'] == 2) {
						$this->account_migration($id);
						$this->send_whatsapp_msg($id);
						$this->send_mail_to_customer($id);
					}
					if ($data['payment_status'] == 2)
						$this->account_migration($id);
					if (!empty($_POST['email'])) {
						$temple_title = "Temple " . $_SESSION['site_title'];
						$qr_url = base_url() . "/booking/reg/";
						$mail_data['qr_image'] = qrcode_generation($id, $qr_url);
						$mail_data['hall_id'] = $id;
						$message = view('hallbooking/mail_template', $mail_data);
						$subject = $_SESSION['site_title'] . " HALL BOOKING";
						$to_user = $_POST['email'];
						$to_mail = array("prithivitest@gmail.com", $to_user);
						send_mail_with_content($to_mail, $message, $subject, $temple_title);
					}
					$this->session->setFlashdata('succ', 'Hall Booking Added Successfully');
					$msg_data['succ'] = 'Hall Booking Added Successfully';
					$msg_data['id'] = $id;
				} else {
					$this->session->setFlashdata('fail', 'Please Try Again');
					$msg_data['err'] = 'Please Try Again';
				}
			}
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			$msg_data['err'] = 'Please Try Again. required user details.';
		}
		echo json_encode($msg_data);
		exit();
	}
	public function save_repay($hall_book_id)
	{
		$pay_amount = !empty($_REQUEST['pay_amount']) ? $_REQUEST['pay_amount'] : 0;
		$hall_datas = $this->db->table("hall_booking")->where("id", $hall_book_id)->get()->getRowArray();
		$msg_data = array();
		$data = $paydata = array();
		if ($pay_amount <= $hall_datas['balance_amount']) {
			$pay_method = 'cash';
			$data['paid_amount'] = $hall_datas['paid_amount'] + $pay_amount;
			$data['balance_amount'] = $hall_datas['balance_amount'] - $pay_amount;
			$this->db->table('hall_booking')->where('id', $hall_book_id)->update($data);
			$paydata['hall_booking_id'] = $hall_book_id;
			$paydata['date'] = date("Y-m-d");
			$paydata['amount'] = $pay_amount;
			$paydata['payment_mode'] = $pay_method == 'cash' ? 6 : 4;
			$paydata['created'] = date("Y-m-d H:i:s");
			$paydata['updated'] = date("Y-m-d H:i:s");
			$this->db->table("hall_booking_pay_details")->insert($paydata);
			$hall_booking_pay_id = $this->db->insertID();
			$this->repay_account_migration($hall_booking_pay_id);
			$msg_data['succ'] = 'Hall Booking Repayment Completed Successfully';
		} else {
			$msg_data['err'] = 'Pay amount must less than or equal the balance amount.';
		}
		echo json_encode($msg_data);
		exit();
	}

	public function gtpaymentdata()
	{
		$id = $_POST['id'];
		$bookingDetails = $this->db->table("templebooking")->where("id", $id)->get()->getRowArray();
		$amt = (float) $bookingDetails['total_amount'];

		$paymentDetails = $this->db->table("booked_pay_details")->selectSum('amount')->where("booking_id", $id)->get()->getRowArray();
		$paid_amount = (float) $paymentDetails['amount'];

		$depositDetails = $this->db->table("booked_deposit_details")->selectSum('amount')->where("booking_id", $id)->get()->getRowArray();
		$paid_deposit = (float) $depositDetails['amount'];

		$data = [
			'amt' => $amt,
			'paid_amount' => $paid_amount,
			'deposit_amount' => $paid_deposit,
			'bal_amount' => $amt - $final_paid
		];

		echo json_encode($data);
	}

	public function gtdepositdata()
	{
		$id = $_POST['id'];

		$depositDetails = $this->db->table("booked_deposit_details")->selectSum('amount')->where("booking_id", $id)->get()->getRowArray();
		$paid_deposit = (float) $depositDetails['amount'];
		$data['deposit_amount'] = $paid_deposit;
			
		echo json_encode($data);
	}

	public function update_booking_status()
	{
		$id = $_POST['id'];
		$status = $_POST['status'];

		$data = [
			'booking_status' => $status
		];

		$this->db->table('templebooking')
				->where('id', $id)
				->update($data);

		if($this->db->affectedRows() > 0) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	public function get_hallpackages_list(){
		$resp = array('success' => true, 'data' => array('status' => true));
		try{
			$request_all_data = !empty($_REQUEST['booking_date']) ? $_REQUEST : json_decode(file_get_contents('php://input'), true);
			if($request_all_data['booking_date'] && $request_all_data['slot_id'] && $request_all_data['package_type'] && $request_all_data['venue_id']){
				$booking_date = trim($request_all_data['booking_date']);
				$slot_id = trim($request_all_data['slot_id']);
				$venue_id = trim($request_all_data['venue_id']);
				$package_type = trim($request_all_data['package_type']);
				
				// Query to count package availability
				$query = $this->db->query("
							SELECT COUNT(*) as count FROM (
								SELECT bp.package_id 
								FROM templebooking tb
								LEFT JOIN booked_packages bp ON bp.booking_id = tb.id
								LEFT JOIN temple_packages tp ON tp.id = bp.package_id
								LEFT JOIN booked_slot bs ON bs.booking_id = tb.id
								LEFT JOIN temple_package_venues tpv ON tpv.package_id = tp.id
								WHERE tb.booking_date = '$booking_date'
								AND bs.booking_slot_id = $slot_id
								AND tp.package_type = $package_type
								AND tpv.venue_id = $venue_id
								AND tb.booking_status NOT IN (3)
								GROUP BY bp.package_id
							) AS subquery
						");
				
				$result = $query->getRowArray();
				$pack_rows = isset($result['count']) ? $result['count'] : 0;

				// echo $pack_rows;
				// exit;

				if($pack_rows > 1){
					$resp['data']['packages'] = array();
					$resp['data']['addons'] = array();
				} elseif($pack_rows == 1){
					$packages_result = $this->db->query("
										SELECT 
											MAX(bp.package_id) AS package_id, 
											MAX(tp.package_type) AS package_type, 
											MAX(tp.package_mode) AS package_mode
										FROM 
											templebooking tb
										LEFT JOIN 
											booked_packages bp ON bp.booking_id = tb.id
										LEFT JOIN 
											temple_packages tp ON tp.id = bp.package_id
										LEFT JOIN 
											booked_slot bs ON bs.booking_id = tb.id
										LEFT JOIN 
											temple_package_venues tpv ON tpv.package_id = tp.id
										WHERE 
											tb.booking_date = '$booking_date'
											AND bs.booking_slot_id = $slot_id
											AND tp.package_type = $package_type
											AND tpv.venue_id = $venue_id
											AND tb.booking_status NOT IN (3)
										GROUP BY 
											bp.package_id
									")->getRowArray();
	
					if($packages_result['package_mode'] == 2){
						$sql = "
							SELECT * 
							FROM temple_packages tp
							LEFT JOIN 
								temple_package_venues tpv ON tpv.package_id = tp.id
							WHERE tp.id = ?
							AND tp.package_type = ?
							AND tp.status = 1
							AND tpv.venue_id = ?
						";
	
						$packages = $this->db->query($sql, [$packages_result['package_id'], $package_type, $venue_id])->getResultArray();
	
						$resp['data']['packages'] = $packages;
						$resp['data']['addons'] = $this->db->query("select * from temple_services where id in(select service_id from temple_package_addons where package_id = '" . $packages_result['package_id'] . "')")->getResultArray();
					} else {
						$resp['data']['packages'] = array();
						$resp['data']['addons'] = array();
					}
				// Additional logic if no packages are found directly matching the criteria
				} else {
					$spl_pack_query = $this->db->query("
						SELECT tp.*
						FROM temple_packages tp
						JOIN temple_package_venues tpv ON tpv.package_id = tp.id
						WHERE tp.package_type = ?
						AND tp.status = 1
						AND tp.id IN (
							SELECT package_id
							FROM temple_package_date
							WHERE package_type = ?
							AND pack_date = ?
						)
						AND tpv.venue_id = ?
					", [$package_type, $package_type, $booking_date, $venue_id])->getResultArray();

					$spl_pack_cnt = count($spl_pack_query);

					if ($spl_pack_cnt > 0) {
						$resp['data']['packages'] = $spl_pack_query;
						$resp['data']['addons'] = $this->db->query("
							SELECT ts.*
							FROM temple_services ts
							WHERE ts.id IN (
								SELECT service_id
								FROM temple_package_addons
								WHERE package_id IN (
									SELECT id
									FROM temple_packages
									WHERE package_type = ?
									AND status = 1
									AND id IN (
										SELECT package_id
										FROM temple_package_date
										WHERE pack_date = ?
										AND package_type = ?
									)
								)
							)
						", [$package_type, $booking_date, $package_type])->getResultArray();
					} else {
						$tot_pack_cnt = $this->db->query("
							SELECT COUNT(*) as count
							FROM temple_packages tp
							JOIN temple_package_venues tpv ON tpv.package_id = tp.id
							WHERE tp.package_type = ?
							AND tp.id NOT IN (
								SELECT package_id
								FROM temple_package_date
								WHERE package_type = ?
								AND pack_date IS NOT NULL
								AND pack_date != '0000-00-00'
							)
							AND tpv.venue_id = ?
						", [$package_type, $package_type, $venue_id])->getRow()->count;

						if ($tot_pack_cnt > 0) {
							$resp['data']['packages'] = $this->db->query("
								SELECT tp.*
								FROM temple_packages tp
								JOIN temple_package_venues tpv ON tpv.package_id = tp.id
								WHERE tp.package_type = ?
								AND tp.status = 1
								AND tp.id IN (
									SELECT package_id
									FROM temple_package_date
									WHERE package_type = ?
									AND pack_date IS NULL
									OR pack_date = ''
								)
								AND tpv.venue_id = ?
							", [$package_type, $package_type, $venue_id])->getResultArray();
							$resp['data']['addons'] = $this->db->query("
								SELECT ts.*
								FROM temple_services ts
								WHERE ts.id IN (
									SELECT service_id
									FROM temple_package_addons
									WHERE package_id IN (
										SELECT id
										FROM temple_packages
										WHERE package_type = ?
										AND status = 1
										AND id IN (
											SELECT package_id
											FROM temple_package_date
											WHERE package_type = ?
											AND pack_date IS NULL
											OR pack_date = ''
										)
									)
								)
							", [$package_type, $package_type])->getResultArray();
						} else {
							$resp['data']['packages'] = array();
							$resp['data']['addons'] = array();
						}
					}
				}

			} else {
				$resp['data']['packages'] = array();
			}
		} catch (Exception $e) {
			$resp['success'] = false;
			$resp['data']['status'] = false;
			$resp['data']['message'] = $e->getMessage();
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($resp);
		exit;
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
				$ubayam_details = $this->db->table("templebooking")->where('id', $booking_id)->get()->getRowArray();
				if($ubayam_details['total_amount'] >= ($ubayam_details['paid_amount'] + $pay_amount)){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['booking_id'] = $booking_id;
					$booking_payment_ins_data['booking_type'] = 1;
					$booking_payment_ins_data['is_repayment'] = 1;
					$booking_payment_ins_data['booking_ref_no'] = $ubayam_details['ref_no'];
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
					$res = $this->db->table("booked_pay_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE templebooking SET paid_amount = paid_amount + ? WHERE id = ?", [$pay_amount, $booking_id]);
					$query = $this->db->table('templebooking')->where('id', $booking_id)->get()->getRowArray();
					if ($query['total_amount'] == $query['paid_amount']) {
						$this->db->query("UPDATE templebooking SET payment_status = 2 WHERE id = ?", [$booking_id]);
					}elseif($query['paid_amount'] > 0 && $query['payment_status'] == 0){
						$this->db->query("UPDATE templeboking SET payment_status = 1 WHERE id = ?", [$booking_id]);
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
		$booked_pay_details_cnt = $this->db->table("booked_pay_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("booked_pay_details")->where("id", $booked_pay_id)->get()->getResultArray();
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
			$booking_id = $booked_pay_details[0]['booking_id'];
			$templeubayam = $this->db->table("templebooking")->where("id", $booking_id)->get()->getRowArray();
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

					$entries['entry_code'] = 'REC' . date('y', strtotime($row['paid_date'])) . date('m', strtotime($row['paid_date'])) . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $row['paid_date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'NRIC:' . $templeubayam['ic_number'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
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
						if ($templeubayam['booking_type'] == 2){$eitems_hall_book['details'] = 'Ubayam Amount';}
						elseif ($templeubayam['booking_type'] == 1){$eitems_hall_book['details'] = 'Hall Booking Amount';}
						else {$eitems_hall_book['details'] = 'Sannathi Amount';}
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						if ($templeubayam['booking_type'] == 2){$eitems_cash_led['details'] = 'Ubayam Amount';}
						elseif ($templeubayam['booking_type'] == 1){$eitems_cash_led['details'] = 'Hall Booking Amount';}
						else {$eitems_cash_led['details'] = 'Sannathi Amount';}
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

	public function save_deposit_repayment()
	{
		if(!empty($_POST['payment_mode']) && !empty($_POST['pay_amount'])&& !empty($_POST['booking_id'])){
			$date = $_POST['date'];
			$pay_amount = $_POST['pay_amount'];
			$payment_mode = $_POST['payment_mode'];
			$booking_id = $_POST['booking_id'];
			$count = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getNumRows();
			if($count > 0){
				$payment_mode_details = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
				$ubayam_details = $this->db->table("templebooking")->where('id', $booking_id)->get()->getRowArray();
				if($ubayam_details['deposit_amount'] == $pay_amount){
					$booking_payment_ins_data = array();
					$booking_payment_ins_data['booking_id'] = $booking_id;
					$booking_payment_ins_data['booking_type'] = 1;
					$booking_payment_ins_data['booking_ref_no'] = $ubayam_details['ref_no'];
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
					$res = $this->db->table("paid_deposit_details")->insert($booking_payment_ins_data);
					$booked_pay_id = $this->db->insertID();
					$this->db->query("UPDATE booked_deposit_details SET deposit_status = 2 WHERE booking_id = ?", [$booking_id]);
					// $query = $this->db->table('templebooking')->where('id', $booking_id)->get()->getRowArray();
					// if ($query['amount'] == $query['paid_amount']) {
					// 	$this->db->query("UPDATE templebooking SET payment_status = 2 WHERE id = ?", [$booking_id]);
					// }elseif($query['paid_amount'] > 0 && $query['payment_status'] == 0){
					// 	$this->db->query("UPDATE templeboking SET payment_status = 1 WHERE id = ?", [$booking_id]);
					// }
					$this->deposit_account_migration($booked_pay_id);
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
	public function deposit_account_migration($booked_pay_id){
		$succ = true;
		$booked_pay_details_cnt = $this->db->table("paid_deposit_details")->where("id", $booked_pay_id)->get()->getNumRows();	
		if ($booked_pay_details_cnt > 0) {
			$booked_pay_details = $this->db->table("paid_deposit_details")->where("id", $booked_pay_id)->get()->getResultArray();
			$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE PAYABLE')->where('group_id', 14)->where('left_code', '2100')->get()->getRowArray();
			if (!empty($td_ledger)) {
			  $cr_id1 = $td_ledger['id'];
			} else {
				$cled1['group_id'] = 14;
				$cled1['name'] = 'TRADE PAYABLE';
				$cled1['code'] = '2100/2102';
				$cled1['op_balance'] = '0';
				$cled1['op_balance_dc'] = 'D';
				$cled1['left_code'] = '2100';
				$cled1['right_code'] = '2102';
				$this->db->table('ledgers')->insert($cled1);
				$cr_id1 = $this->db->insertID();
			}
			$booking_id = $booked_pay_details[0]['booking_id'];
			$templeubayam = $this->db->table("templebooking")->where("id", $booking_id)->get()->getRowArray();
			foreach ($booked_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode_id'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 2)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =2 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'PAY' . date('y', strtotime($row['paid_date'])) . date('m', strtotime($row['paid_date'])) . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '2';
					$entries['number'] = $num;
					$entries['date'] = $row['paid_date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'DEPOSIT REFUND(' . $templeubayam['ref_no'] . ')' . "\n" . 'name:' . $templeubayam['name'] . "\n" . 'email:' . $templeubayam['email'] . "\n";
					$entries['inv_id'] = $booking_id;
					$entries['type'] = 8;
					//Insert Entries
					$ent = $this->db->table('entries')->insert($entries);
					$en_id = $this->db->insertID();
					if (!empty($en_id)) {

						$eitems_hall_book['entry_id'] = $en_id;
						$eitems_hall_book['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_hall_book['amount'] = $row['amount'];
						$eitems_hall_book['dc'] = 'C';
						$eitems_hall_book['details'] = 'Deposit_amount';
						$this->db->table('entryitems')->insert($eitems_hall_book);

						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $cr_id1;
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Deposit Refund';
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


	public function initiate_ipay_merch_qr($hall_book_id)
	{
		$barcode = !empty($_REQUEST['barcode']) ? $_REQUEST['barcode'] : '';
		$payment_id = !empty($_REQUEST['payment_id']) ? $_REQUEST['payment_id'] : '';
		$hall_booking = $this->db->table('hall_booking')->where('id', $hall_book_id)->get()->getRowArray();
		if (!empty($barcode) && !empty($hall_booking['paid_amount']) && !empty($payment_id)) {
			$final_amt = $hall_booking['paid_amount'];
			$description = $hall_booking['ref_no'];
			$xml_response = $this->initiatePaymentIpayMerchantQr('hall_booking', $barcode, 'HALL_' . $hall_book_id, $final_amt, $payment_id, $description);
			$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml_response['response_data']);
			$xml = new \SimpleXMLElement($response);
			$body = $xml->xpath('//sBody')[0];
			$aStatus = $body->EntryPageFunctionalityV2Response->EntryPageFunctionalityV2Result[0]->aStatus;
			$hall_booking_payment_gateway_datas = $this->db->table('hall_booking_payment_gateway_datas')->where('hall_booking_id', $hall_book_id)->get()->getRowArray();
			$payment_gateway_up_data = array();
			$payment_gateway_up_data['request_data'] = $xml_response['request_data'];
			$payment_gateway_up_data['response_data'] = $xml_response['response_data'];
			$this->db->table('hall_booking_payment_gateway_datas')->where('id', $hall_booking_payment_gateway_datas['id'])->update($payment_gateway_up_data);
			if ($aStatus == 1) {
				$hall_booking_up_data = array();
				$hall_booking_up_data['payment_status'] = 2;
				$this->db->table('hall_booking')->where('id', $hall_book_id)->update($hall_booking_up_data);
				$this->account_migration($hall_book_id);
				$this->session->setFlashdata('succ', 'Hall Booking Successfully');
				$redirect_url = base_url() . '/booking/print_booking/' . $hall_book_id;
				header('Location: ' . $redirect_url);
				exit;
			} else {
				$this->session->setFlashdata('fail', 'Payment Failed. Please Try Again');
				$redirect_url = base_url() . '/booking/';
				header('Location: ' . $redirect_url);
				exit;
			}
		} else {
			$this->session->setFlashdata('fail', 'Payment Failed. Please Try Again');
			$redirect_url = base_url() . '/booking/';
			header('Location: ' . $redirect_url);
			exit;
		}
	}
	public function initiatePaymentIpayMerchantQr($module, $barcode, $ref_no, $final_amt, $payment_id = 336, $description = 'Hall Booking', $email = 'dd@ipay88.com.my')
	{
		$MerchantCode = "M15137";
		$MerchantKey = "Vx7AbhyzGK";
		$url = "https://payment.ipay88.com.my/ePayment/WebService/MHGatewayService/GatewayService.svc";
		$final_amt = 0.10;
		$final_amt_str = '010';
		$signature = hash('sha256', $MerchantKey . $MerchantCode . $ref_no . $final_amt_str . 'MYR' . $barcode);
		$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:mob="https://www.mobile88.com" xmlns:mhp="http://schemas.datacontract.org/2004/07/MHPHGatewayService.Model">
		   <soapenv:Header/>
		   <soapenv:Body>
			  <mob:EntryPageFunctionalityV2>
				 <mob:requestModelObj>
					<mhp:Amount>' . $final_amt . '</mhp:Amount>
					<mhp:BackendURL></mhp:BackendURL>
					<mhp:BarcodeNo>' . $barcode . '</mhp:BarcodeNo>
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
			"Content-length: " . strlen($xml_post_string),
			"SOAPAction: https://www.mobile88.com/IGatewayService/EntryPageFunctionalityV2"
		);
		//print_r($headers);
		/* if($module == 'archanai'){
				  $hall_booking_payment_gateway_datas = $this->db->table('hall_booking_payment_gateway_datas')->where('hall_booking_id', $ref_no)->get()->getRowArray();
				  $payment_gateway_up_data = array();
				  $payment_gateway_up_data['request_data'] = $xml_post_string;
				  $this->db->table('hall_booking_payment_gateway_datas')->where('id', $hall_booking_payment_gateway_datas['id'])->update($payment_gateway_up_data);
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
	public function payment_process($hall_booking_id)
	{
		$hall_booking = $this->db->table('hall_booking')->where('id', $hall_booking_id)->get()->getRowArray();
		$hall_booking_payment_gateway_datas = $this->db->table('hall_booking_payment_gateway_datas')->where('hall_booking_id', $hall_booking_id)->get()->getResultArray();
		if (count($hall_booking_payment_gateway_datas) > 0) {
			if ($hall_booking_payment_gateway_datas[0]['pay_method'] == 'adyen') {
				if (!empty($hall_booking_payment_gateway_datas[0]['request_data'])) {
					$request_data = $hall_booking_payment_gateway_datas[0]['request_data'];
					$response = json_decode($request_data, true);
				} else {
					$tmpid = 1;
					$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
					$result = $this->initiatePayment($hall_booking['amount'], $hall_booking_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
					$response = json_decode($result, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['request_data'] = $result;
					$payment_gateway_up_data['reference_id'] = $response['id'];
					$this->db->table('hall_booking_payment_gateway_datas')->where('id', $hall_booking_payment_gateway_datas[0]['id'])->update($payment_gateway_up_data);
				}
				if (!empty($response['url']) && !empty($response['id'])) {
					header('Location: ' . $response['url']);
					exit;
				}
			} elseif ($hall_booking_payment_gateway_datas[0]['pay_method'] == 'ipay_merch_qr') {
				//$view_file = 'frontend/ipay88/ipay_merch_qr';
				$view_file = 'frontend/ipay88/ipay_merch_qr_camera';
				$data['arch_book_id'] = $arch_book_id;
				$data['list'] = $this->db->table('payment_option')->where('status', 1)->get()->getResultArray();
				$data['submit_url'] = '/booking/initiate_ipay_merch_qr/' . $hall_booking_id;
				echo view($view_file, $data);
			} else {
				$redirect_url = base_url() . '/booking/print_booking/' . $hall_booking_id;
				header('Location: ' . $redirect_url);
				exit;
			}
		} else {
			$tmpid = 1;
			$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
			$result = $this->initiatePayment($hall_booking['amount'], $hall_booking_id, $temple_details['address1'] . $temple_details['address2'], $temple_details['city'], $temple_details['email']);
			$response = json_decode($result, true);
			if (!empty($response['url']) && !empty($response['id'])) {
				$payment_gateway_data = array();
				$payment_gateway_data['hall_booking_id'] = $hall_booking_id;
				$payment_gateway_data['request_data'] = $result;
				$payment_gateway_data['pay_method'] = 'adyen';
				$payment_gateway_data['reference_id'] = $response['id'];
				$this->db->table('hall_booking_payment_gateway_datas')->insert($payment_gateway_data);
				$hall_booking_payment_gateway_id = $this->db->insertID();
				if (!empty($hall_booking_payment_gateway_id)) {
					header('Location: ' . $response['url']);
					exit;
				}
			}
		}
	}
	public function account_migration($hall_booking_id)
	{
		$hall_booking = $this->db->table("hall_booking")->where("id", $hall_booking_id)->get()->getRowArray();
		$entry_date = date('Y-m-d', strtotime($hall_booking['entry_date']));
		$date = explode('-', $entry_date);
		$yr = $date[0];
		$mon = $date[1];
		$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '3000')->get()->getRowArray();
		if (!empty($td_ledger)) {
			$cr_id1 = $td_ledger['id'];
		} else {
			$cled1['group_id'] = 3;
			$cled1['name'] = 'TRADE RECEIVABLE';
			$cled1['code'] = '1000/001';
			$cled1['op_balance'] = '0';
			$cled1['op_balance_dc'] = 'D';
			$cled1['left_code'] = '1000';
			$cled1['right_code'] = '001';
			$this->db->table('ledgers')->insert($cled1);
			$cr_id1 = $this->db->insertID();
		}
		$incomes_group = $this->db->table('groups')->where('code', '8000')->get()->getRowArray();
		if (!empty($incomes_group)) {
			$sls_id = $incomes_group['id'];
		} else {
			$sls1['parent_id'] = 0;
			$sls1['name'] = 'Incomes';
			$sls1['code'] = '8000';
			$sls1['added_by'] = $this->session->get('log_id');
			$led_ins1 = $this->db->table('groups')->insert($sls1);
			$sls_id = $this->db->insertID();
		}
		/* $led_hall_book = $this->db->table('ledgers')->where('name', 'RENTAL - HALL')->where('group_id', $sls_id)->get()->getRowArray();
					if (!empty($led_hall_book)) {
						$led_hall_book_id = $led_hall_book['id'];
					} else {
						$led_hall_book_data['group_id'] = $sls_id;
						$led_hall_book_data['name'] = 'RENTAL - HALL';
						$led_hall_book_data['left_code'] = '7022';
						$led_hall_book_data['right_code'] = '000';
						$led_hall_book_data['op_balance'] = '0';
						$led_hall_book_data['op_balance_dc'] = 'D';
						$led_hall_book__ins = $this->db->table('ledgers')->insert($led_hall_book_data);
						$led_hall_book_id = $this->db->insertID();
					} */
		$hall_booking_service_details = $this->db->table("hall_booking_service_details")->join('service', 'hall_booking_service_details.service_id = service.id')->select('hall_booking_service_details.*, service.ledger_id')->where("hall_booking_service_details.hall_booking_id", $hall_booking_id)->get()->getResultArray();
		if (count($hall_booking_service_details) > 0) {
			$over_all_tot_amt = 0;
			foreach ($hall_booking_service_details as $row)
				$over_all_tot_amt += (float) $row['service_amount'];
			$number1 = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number1))
				$num1 = 1;
			else
				$num1 = $number1['number'] + 1;
			// Get Entry Code
			$qry1 = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =4 and month (date)='" . $mon . "')")->getRowArray();

			$entries1['entry_code'] = 'JOR' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry1['entry_code'], -5)) + 1)));
			$entries1['entrytype_id'] = '4';
			$entries1['number'] = $num1;
			$entries1['date'] = $entry_date;
			$entries1['dr_total'] = $over_all_tot_amt;
			$entries1['cr_total'] = $over_all_tot_amt;
			$entries1['narration'] = 'Hall Booking(' . $hall_booking['ref_no'] . ')' . "\n" . 'name:' . $hall_booking['name'] . "\n" . 'NRIC:' . $hall_booking['ic_no'] . "\n" . 'email:' . $hall_booking['email'] . "\n";
			$entries1['inv_id'] = $hall_booking_id;
			$entries1['type'] = 8;
			//Insert Entries
			$ent = $this->db->table('entries')->insert($entries1);
			$en_id1 = $this->db->insertID();
			if (!empty($en_id1)) {
				foreach ($hall_booking_service_details as $row) {
					$hallbooking_details = $this->db->table('service')->where('id', $row['service_id'])->get()->getRowArray();
					/*
												  if(!empty($row['ledger_id'])){
													  $led_hall_book_id = $row['ledger_id'];
												  }*/
					if (!empty($hallbooking_details['ledger_id'])) {
						$led_hall_book_id = $hallbooking_details['ledger_id'];
					} else {
						$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
						if (!empty($ledger1)) {
							$led_hall_book_id = $ledger1['id'];
						} else {
							$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '8913')->orderBy('right_code', 'desc')->get()->getRowArray();
							$set_right_code = (int) $right_code['right_code'] + 1;
							$set_right_code = sprintf("%04d", $set_right_code);
							$led1['group_id'] = $sls_id;
							$led1['name'] = 'All Incomes';
							$led1['left_code'] = '8913';
							$led1['right_code'] = $set_right_code;
							$led1['op_balance'] = '0';
							$led1['op_balance_dc'] = 'D';
							$led_ins1 = $this->db->table('ledgers')->insert($led1);
							$led_hall_book_id = $this->db->insertID();
						}
					}
					// Hall Booking => Credit
					$eitems_hall_book['entry_id'] = $en_id1;
					$eitems_hall_book['ledger_id'] = $led_hall_book_id;
					$eitems_hall_book['amount'] = $row['service_amount'];
					$eitems_hall_book['dc'] = 'C';
					$eitems_hall_book['details'] = 'Amount for' . $row['service_name'] . '(' . $hall_booking['ref_no'] . ')';
					$this->db->table('entryitems')->insert($eitems_hall_book);
					//  Trade Debtors => Debit 
					$eitems_cash_led['entry_id'] = $en_id1;
					$eitems_cash_led['ledger_id'] = $cr_id1;
					$eitems_cash_led['amount'] = $row['service_amount'] . '(' . $hall_booking['ref_no'] . ')';
					$eitems_cash_led['dc'] = 'D';
					$eitems_cash_led['details'] = 'Amount for' . $row['service_name'];
					$this->db->table('entryitems')->insert($eitems_cash_led);
				}
			}
		}
		$hall_booking_pay_details = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $hall_booking_id)->get()->getResultArray();
		if (count($hall_booking_pay_details) > 0) {
			foreach ($hall_booking_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'REC' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $entry_date;
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $hall_booking['ref_no'] . ')' . "\n" . 'name:' . $hall_booking['name'] . "\n" . 'NRIC:' . $hall_booking['ic_no'] . "\n" . 'email:' . $hall_booking['email'] . "\n";
					$entries['inv_id'] = $hall_booking_id;
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
						$eitems_hall_book['details'] = 'Hall Booking Amount' . '(' . $hall_booking['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Hall Booking Amount' . '(' . $hall_booking['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
				}
			}
		}
	}
	public function repay_account_migration($hall_booking_pay_id)
	{
		$hall_booking_pay_details = $this->db->table("hall_booking_pay_details")->where("id", $hall_booking_pay_id)->get()->getResultArray();
		$td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '3000')->get()->getRowArray();
		if (!empty($td_ledger)) {
			$cr_id1 = $td_ledger['id'];
		} else {
			$cled1['group_id'] = 3;
			$cled1['name'] = 'TRADE RECEIVABLE';
			$cled1['code'] = '3000/000';
			$cled1['op_balance'] = '0';
			$cled1['op_balance_dc'] = 'D';
			$cled1['left_code'] = '3000';
			$cled1['right_code'] = '000';
			$this->db->table('ledgers')->insert($cled1);
			$cr_id1 = $this->db->insertID();
		}
		if (count($hall_booking_pay_details) > 0) {
			foreach ($hall_booking_pay_details as $row) {
				$paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$hall_booking = $this->db->table("hall_booking")->where("id", $row['hall_booking_id'])->get()->getRowArray();
				if (!empty($paymentmode['ledger_id'])) {
					$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
					if (empty($number))
						$num = 1;
					else
						$num = $number['number'] + 1;
					$date = explode('-', $row['date']);
					$yr = $date[0];
					$mon = $date[1];
					// Get Entry Code
					$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

					$entries['entry_code'] = 'REC' . date('y', strtotime($row['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
					$entries['entrytype_id'] = '1';
					$entries['number'] = $num;
					$entries['date'] = $row['date'];
					$entries['dr_total'] = $row['amount'];
					$entries['cr_total'] = $row['amount'];
					$entries['narration'] = 'Hall Booking(' . $hall_booking['ref_no'] . ')' . "\n" . 'name:' . $hall_booking['name'] . "\n" . 'NRIC:' . $hall_booking['ic_no'] . "\n" . 'email:' . $hall_booking['email'] . "\n";
					$entries['inv_id'] = $hall_booking_id;
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
						$eitems_hall_book['details'] = 'Hall Booking Amount' . '(' . $hall_booking['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_hall_book);
						// PETTY CASH => Debit 
						$eitems_cash_led['entry_id'] = $en_id;
						$eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
						$eitems_cash_led['amount'] = $row['amount'];
						$eitems_cash_led['dc'] = 'D';
						$eitems_cash_led['details'] = 'Hall Booking Amount' . '(' . $hall_booking['ref_no'] . ')';
						$this->db->table('entryitems')->insert($eitems_cash_led);
					}
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
			'returnUrl' => base_url() . '/archanai_booking/print_booking/' . $orderid,
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
	/* public function checkoutonlinepayment()
	   {
		   $shopperOrder = $_REQUEST['shopperOrder'];
		   $row = $this->db->table("hall_booking")->where('id',$shopperOrder)->get()->getRowArray();
		   $payment_id = $row['payment_ref_id'];
		   $response_json = $this->initiatePayment_response($payment_id);
		   $response = json_decode($response_json, true); 
		   $amount = $response['amount']['value'];
		   $reference = $response['reference'];
		   $shopperEmail = $response['shopperEmail'];
		   $id = $response['id'];
		   $status = $response['status'];
		   $expiresAt = $response['expiresAt'];
		   $updatedAt = $response['updatedAt'];
		   $url = $response['url'];
		   $date = explode('-', $row['booking_date']);
		   $yr = $date[0];
		   $mon = $date[1];
		   //var_dump($reference);
		   //exit;
		   if($status == "completed")
		   {
			   // Hall Booking ledger 
			   $led_hall_book = $this->db->table('ledgers')->where('name', 'Hall Booking')->where('group_id', 29)->get()->getRowArray();
			   if(!empty($led_hall_book)){
				   $led_hall_book_id = $led_hall_book['id'];
			   }else{
				   $led_hall_book_data['group_id'] = 29;
				   $led_hall_book_data['name'] = 'Hall Booking';
				   $led_hall_book_data['op_balance'] = '0';
				   $led_hall_book_data['op_balance_dc'] = 'D';
				   $led_hall_book__ins = $this->db->table('ledgers')->insert($led_hall_book_data);
				   $led_hall_book_id = $this->db->insertID();
			   }
			   // Cash Ledger
			   $led_cash_led = $this->db->table('ledgers')->where('name', 'Cash Ledger')->where('group_id', 4)->get()->getRowArray();
			   if(!empty($led_cash_led)){
				   $led_cash_led_id = $led_cash_led['id'];
			   }else{
				   $led_cash_led_data['group_id'] = 4;
				   $led_cash_led_data['name'] = 'Cash Ledger';
				   $led_cash_led_data['op_balance'] = '0';
				   $led_cash_led_data['op_balance_dc'] = 'D';
				   $led_cash_led_ins = $this->db->table('ledgers')->insert($led_cash_led_data);
				   $led_cash_led_id = $this->db->insertID();
			   }
			   
			   if(!empty($amount)){
					 // Get Entry Number
				   $number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
				   if(empty($number)) $num = 1;
					 else $num = $number['number'] + 1;
					 // Get Entry Code
				   $qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
					 
				   $entries['entry_code'] = 'REC' .date('y',strtotime($_POST['event_date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
				   $entries['entrytype_id'] = '1';
				   $entries['number'] 		 = $num;
				   $entries['date'] 		 = date("Y-m-d");					
				   $entries['dr_total'] 	 = $amount;
				   $entries['cr_total'] 	 = $amount;						
				   $entries['narration'] 	 = 'Online Hall Booking';
				   $entries['inv_id']		 = $reference;
				   $entries['type']		 = 8;
				   //Insert Entries
				   $ent = $this->db->table('entries')->insert($entries);
				   $en_id = $this->db->insertID();
				   if(!empty($en_id)){
					   // Hall Booking => Credit
					   $eitems_hall_book['entry_id'] = $en_id;
					   $eitems_hall_book['ledger_id'] = $led_hall_book_id;
					   $eitems_hall_book['amount'] = $amount;
					   $eitems_hall_book['dc'] = 'C'; 
					   $eitems_hall_book['details'] = 'Online Hall Booking'; 
					   $this->db->table('entryitems')->insert($eitems_hall_book);
					   // Cash Ledger => Debit 
					   $eitems_cash_led['entry_id'] = $en_id;
					   $eitems_cash_led['ledger_id'] = $led_cash_led_id;
					   $eitems_cash_led['amount'] = $amount;					
					   $eitems_cash_led['dc'] = 'D';
					   $eitems_cash_led['details'] = 'Online Hall Booking'; 
					   $this->db->table('entryitems')->insert($eitems_cash_led);
				   }
			   }
			   $this->db->table('hall_booking')->where('id',$reference)->update(array("status"=>2));
		   }
		   if($status == "failed")
		   {
			   $this->db->table('hall_booking')->where('id',$reference)->update(array("status"=>3));
		   }
	   if($status == "expired")
		   {
			   $this->db->table('hall_booking')->where('id',$reference)->update(array("status"=>3));
		   }
		   return redirect()->to("/booking");	  
		   //echo '<pre>';
		   //print_r($response); 
		   //exit;
	   } */
	public function qrcode_generation($qr_id)
	{
		$kavadi_registration_check = $this->db->table("hall_booking")->where("id", $qr_id)->get()->getResultArray();
		if (count($kavadi_registration_check) > 0) {
			if (!empty($qr_id)) {
				$qr_url = "https://chart.googleapis.com/chart?cht=qr&chl=http://templeganesh.graspsoftwaresolutions.com/booking/reg/?id=" . $qr_id . "&chs=160x160&chld=L|0";
				$data['qr_image'] = $qr_url;
				$this->session->setFlashdata('succ', 'Booking Added Successfully');
				echo view('frontend/layout/book_header');
				echo view('frontend/booking/qrcode_generation', $data);
				echo view('frontend/layout/footer');
			}
		} else {
			return redirect()->to("/booking");
		}

	}
	public function update()
	{
		$id = $_POST['hall_id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';

		//print_r($_POST); die;
		if (!empty($_POST['timing'])) {
			$date = explode('-', $_POST['event_date']);
			$yr = $date[0];
			$mon = $date[1];
			$data['booking_date'] = trim($_POST['event_date']);
			$data['booking_time'] = date("H:i:s");
			$data['event_name'] = trim($_POST['event_name']);
			$data['register_by'] = trim($_POST['register']);
			$data['name'] = trim($_POST['name']);
			$data['status'] = $_POST['status'];
			// if ($_POST['status'] != 3){
			//   if ((float)$_POST['total_amt'] > 0  && (float)$_POST['balance'] == 0 ) $data['status'] = 2;
			//   else if (((float)$_POST['total_amt'] > 0  && (float)$_POST['balance'] > 0 ) || ((float)$_POST['total_amt'] == 0  && (float)$_POST['balance'] == 0 ) || ((float)$_POST['total_amt'] == 0  && (float)$_POST['balance'] > 0 ))  $data['status'] = 1;
			//   else $data['status']         = $_POST['status'];
			// }
			$total_amount = 0;
			$total_commision = 0;
			if (!empty($_POST['commission_to'])) {
				foreach ($_POST['package'] as $row) {
					$packdetails = $this->db->table("booking_addonn")->where("id", $row['pack_id'])->get()->getRowArray();
					if ($packdetails['commision'] > 0) {
						$pack_amount = $packdetails['amount'];
						$pack_comms = $packdetails['commision'];
						/* $per_comm = number_format((float)($pack_comms / ($pack_amount / 100)), "2");
						$total_commision += ($row['pack_amt'] / 100) * $per_comm; */
						$total_commision += $pack_comms;
						$total_amount += $row['pack_amt'] - $total_commision;
					} else {
						$total_amount += $row['pack_amt'];
						$total_commision += 0;
					}
				}
			}

			$data['address'] = trim($_POST['address']);
			$data['mobile_number'] = trim($_POST['mobile']);
			$data['email'] = trim($_POST['email']);
			$data['ic_no'] = trim($_POST['ic_num']);
			$data['commision_to'] = trim($_POST['commission_to']);
			$data['total_amount'] = trim($_POST['total_amt']);
			$data['paid_amount'] = trim($_POST['deposie_amt']);
			$data['balance_amount'] = trim($_POST['balance']);
			//$data['entry_date']     = date("Y-m-d H:i:s");
			$data['entry_by'] = $this->session->get('log_id');
			$data['modified'] = date("Y-m-d H:i:s");
			if (!empty($data['booking_date']) && !empty($data['event_name']) && !empty($data['name']) && !empty($data['mobile_number'])) {
				$res1 = $this->db->table('hall_booking_details')->delete(['hall_booking_id' => $id]);
				//$res2 = $this->db->table('hall_booking_pay_details')->delete(['hall_booking_id' => $id]);
				$res3 = $this->db->table('hall_booking_slot_details')->delete(['hall_booking_id' => $id]);
				if ($id) {
					if (!empty($_POST['package'])) {
						foreach ($_POST['package'] as $row) {
							$packdata['hall_booking_id'] = $id;
							$packdata['booking_addon_id'] = $row['pack_id'];
							$packdetails = $this->db->table("booking_addonn")->where("id", $row['pack_id'])->get()->getRowArray();
							if (!empty($_POST['commission_to'])) {
								if ($packdetails['commision'] > 0) {
									$pack_amount = $packdetails['amount'];
									$pack_comms = $packdetails['commision'];
									/* $per_comm = number_format((float)($pack_comms / ($pack_amount / 100)), "2");
									$sign_pack_com = ($row['pack_amt'] / 100) * $per_comm; */
									$sign_pack_com = $pack_comms;
									$sign_pack_amt = $row['pack_amt'] - $sign_pack_com;
								} else {
									$sign_pack_amt = $row['pack_amt'];
									$sign_pack_com = 0;
								}
							} else {
								$sign_pack_amt = $row['pack_amt'];
								$sign_pack_com = '';
							}
							$packdata['amount'] = $sign_pack_amt;
							$packdata['commission'] = $sign_pack_com;
							$packdata['created'] = date("Y-m-d H:i:s");
							$packdata['updated'] = date("Y-m-d H:i:s");
							$this->db->table("hall_booking_details")->insert($packdata);
						}
					}

					// Hall Booking ledger 
					$led_hall_book = $this->db->table('ledgers')->where('name', 'Hall Booking')->where('group_id', 29)->get()->getRowArray();
					if (!empty($led_hall_book)) {
						$led_hall_book_id = $led_hall_book['id'];
					} else {
						$led_hall_book_data['group_id'] = 29;
						$led_hall_book_data['name'] = 'Hall Booking';
						$led_hall_book_data['op_balance'] = '0';
						$led_hall_book_data['op_balance_dc'] = 'D';
						$led_hall_book__ins = $this->db->table('ledgers')->insert($led_hall_book_data);
						$led_hall_book_id = $this->db->insertID();
					}
					// Cash Ledger
					$led_cash_led = $this->db->table('ledgers')->where('name', 'Cash Ledger')->where('group_id', 4)->get()->getRowArray();
					if (!empty($led_cash_led)) {
						$led_cash_led_id = $led_cash_led['id'];
					} else {
						$led_cash_led_data['group_id'] = 4;
						$led_cash_led_data['name'] = 'Cash Ledger';
						$led_cash_led_data['op_balance'] = '0';
						$led_cash_led_data['op_balance_dc'] = 'D';
						$led_cash_led_ins = $this->db->table('ledgers')->insert($led_cash_led_data);
						$led_cash_led_id = $this->db->insertID();
					}
					// Commission Ledger
					$comm_res = $this->db->table('ledgers')->where('name', 'Commission Ledger')->where('group_id', 13)->get()->getRowArray();
					if (!empty($comm_res)) {
						$com_led_id = $comm_res['id'];
					} else {
						$comm_led_data['group_id'] = 13;
						$comm_led_data['name'] = 'Commission Ledger';
						$comm_led_data['op_balance'] = '0';
						$comm_led_data['op_balance_dc'] = 'D';
						$comm_led_ins = $this->db->table('ledgers')->insert($comm_led_data);
						$com_led_id = $this->db->insertID();
					}

					if (!empty($_POST['pay'])) {
						foreach ($_POST['pay'] as $row) {
							if (!isset($row['epay'])) {
								$paydata['hall_booking_id'] = $id;
								$paydata['date'] = $row['date'];
								$paydata['amount'] = $row['pay_amt'];
								$paydata['created'] = date("Y-m-d H:i:s");
								$paydata['updated'] = date("Y-m-d H:i:s");
								$this->db->table("hall_booking_pay_details")->insert($paydata);
								// Get Entry Number
								$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
								if (empty($number))
									$num = 1;
								else
									$num = $number['number'] + 1;
								// Get Entry Code
								$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

								$entries['entry_code'] = 'REC' . date('y', strtotime($_POST['event_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
								$entries['entrytype_id'] = '1';
								$entries['number'] = $num;
								$entries['date'] = date("Y-m-d");
								$entries['dr_total'] = $row['pay_amt'];
								$entries['cr_total'] = $row['pay_amt'];
								$entries['narration'] = 'Hall Booking';
								$entries['inv_id'] = $id;
								$entries['type'] = 8;
								//Insert Entries
								$ent = $this->db->table('entries')->insert($entries);
								$en_id = $this->db->insertID();
								if (!empty($en_id)) {
									// Hall Booking => Credit
									$eitems_hall_book['entry_id'] = $en_id;
									$eitems_hall_book['ledger_id'] = $led_hall_book_id;
									$eitems_hall_book['amount'] = $row['pay_amt'];
									$eitems_hall_book['dc'] = 'C';
									$eitems_hall_book['details'] = 'Hall Booking Amount';
									$this->db->table('entryitems')->insert($eitems_hall_book);
									// Cash Ledger => Debit 
									$eitems_cash_led['entry_id'] = $en_id;
									$eitems_cash_led['ledger_id'] = $led_cash_led_id;
									$eitems_cash_led['amount'] = $row['pay_amt'];
									$eitems_cash_led['dc'] = 'D';
									$eitems_cash_led['details'] = 'Hall Booking Amount';
									$this->db->table('entryitems')->insert($eitems_cash_led);
								}
							}
						}
					}
					if ($data['commision_to'] != 0 && $data['commision_to'] != '' && $data['status'] == 2) {
						$staff_id = $data['commision_to'];
						// Get Total Commission Amount
						$commission_result = $this->db->query("select sum(commission) as total_commission from hall_booking_details where hall_booking_id = $id")->getRowArray();
						$total_commission = $commission_result['total_commission'];
						// Commission Add to Staff
						$this->db->query("update staff set commission_amt=commission_amt+$total_commission where id=$staff_id");
						// Get Entry Number
						$number = $this->db->table('entries')->select('number')->where('entrytype_id', 2)->orderBy('id', 'desc')->get()->getRowArray();
						if (empty($number))
							$num = 1;
						else
							$num = $number['number'] + 1;
						// Get Entry Code
						$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id = 2 and month (date)='" . $mon . "')")->getRowArray();

						$entries['entry_code'] = 'PAY' . date('y', strtotime($_POST['event_date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
						$entries['entrytype_id'] = '2';
						$entries['number'] = $num;
						$entries['date'] = date("Y-m-d");
						$entries['dr_total'] = $total_commission;
						$entries['cr_total'] = $total_commission;
						$entries['narration'] = 'Hall Booking';
						$entries['inv_id'] = $id;
						$entries['type'] = 8;
						//Insert Entries
						$ent = $this->db->table('entries')->insert($entries);
						$en_id = $this->db->insertID();
						if (!empty($en_id)) {
							// Commission Ledger => Debit
							$eitems_hall_book['entry_id'] = $en_id;
							$eitems_hall_book['ledger_id'] = $com_led_id;
							$eitems_hall_book['amount'] = $total_commission;
							$eitems_hall_book['dc'] = 'D';
							$eitems_hall_book['details'] = 'Hall Booking Amount';
							$this->db->table('entryitems')->insert($eitems_hall_book);
							// Cash Ledger => Credit 
							$eitems_cash_led['entry_id'] = $en_id;
							$eitems_cash_led['ledger_id'] = $led_cash_led_id;
							$eitems_cash_led['amount'] = $total_commission;
							$eitems_cash_led['dc'] = 'C';
							$eitems_cash_led['details'] = 'Hall Booking Amount';
							$this->db->table('entryitems')->insert($eitems_cash_led);
						}
					}
					foreach ($_POST['timing'] as $key => $value) {
						$slotdata['hall_booking_id'] = $id;
						$slotdata['booking_slot_id'] = $value;
						$this->db->table("hall_booking_slot_details")->insert($slotdata);
					}
					$res = $this->db->table("hall_booking")->where('id', $id)->update($data);
					if ($res) {
						if ($data['status'] == 3) {
							$msg_data['succ'] = 'Booking Cancelled Successfully';
							$msg_data['id'] = $id;
						} else {
							$msg_data['succ'] = 'Booking Update Successfully';
							$msg_data['id'] = $id;
						}
					} else {
						$msg_data['err'] = 'Please Try Again';
					}
				} else {
					$msg_data['err'] = 'Please Try Again';
				}
			} else {
				$msg_data['err'] = 'Please Fill All Required Fields';
			}
		} else {
			$msg_data['err'] = 'Please select at-least on timing Again';
		}
		echo json_encode($msg_data);
		exit();
	}

	public function event_list()
	{
		//var_dump($_SESSION['log_id_frend']);
		//exit;
		/*$query   = $this->db->query("SELECT booking_date, COUNT(booking_date) as tcnt
											FROM hall_booking where status!=3
											GROUP BY booking_date
											HAVING COUNT(booking_date) > 0"); */
		$login_id = $_SESSION['log_id_frend'];
		$query = $this->db->query("SELECT DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') as booking_date, COUNT(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')) as tcnt
                                  FROM hall_booking where status!=3 and entry_by = $login_id
                                  GROUP BY DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')
                                  HAVING COUNT(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')) > 0");
		$res = $query->getResultArray();
		echo json_encode($res);
	}

	public function print_page_new($id)
	{
		// if (!$this->model->permission_validate('hall_booking', 'print')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$id = $this->request->uri->getSegment(3);
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['data'] = $this->db->table('templebooking')->where('templebooking.id', $id)->get()->getRowArray();
		$data['packages'] = $this->db->table("booked_packages")->select('name, quantity, amount')->where('booking_id', $id)->get()->getRowArray();
		$data['services'] = $this->db->table("booked_services")->select('name, quantity, amount')->where('booking_id', $id)->get()->getResultArray();
		$data['booked_addon'] = $this->db->table("booked_addon")->select('name, quantity, amount')->where("booking_id", $id)->get()->getResultArray();

		// $data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['pay_details'] = $this->db->table("booked_pay_details")->where("booking_id", $id)->get()->getResultArray();

		echo view('templehallbooking/print_page', $data);
	}

	public function print_page_hall($id)
	{
		
		$id = $this->request->uri->getSegment(3);
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['data'] = $this->db->table('templebooking')->join('venue', 'templebooking.venue = venue.id')->select('templebooking.*, venue.name as venue_name')->where('templebooking.id', $id)->get()->getRowArray();
		$data['packages'] = $this->db->table("booked_packages")->select('name, quantity, amount')->where('booking_id', $id)->get()->getRowArray();
		$data['services'] = $this->db->table("booked_services")->select('name, quantity, amount')->where('booking_id', $id)->get()->getResultArray();
		// $data['booked_slot'] = $this->db->table("booked_slot")->select('slot_name')->where("booking_id", $id)->get()->getResultArray();
		$data['booked_addon'] = $this->db->table("booked_addon")->select('name, quantity, amount')->where("booking_id", $id)->get()->getResultArray();
		$data['booked_extra'] = $this->db->table("booked_extra_charges")->select('description, amount')->where("booking_id", $id)->get()->getResultArray();
		// $data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['pay_details'] = $this->db->table("booked_pay_details")->where("booking_id", $id)->get()->getResultArray();
		$data['tempdata'] = $this->db->table('templebooking')
			->select('total_amount')
			->where('id', $id)
			->get()
			->getRowArray();
		$data['booked_slot'] = $this->db->table("booked_slot")->select('slot_name')->where("booking_id", $id)->get()->getRowArray();	

		// var_dump($data);
		// exit;
		echo view('frontend/hallbooking_new/print_page', $data);
	}

	public function print_page_hall_old()
	{
		
		$id = $this->request->uri->getSegment(3);
		// echo  $id;
		//  exit ;
		$data['qry1'] = $this->db->table('templebooking')
			->where('templebooking.id', $id)
			->get()->getRowArray();
		$query = $this->db->table("booked_packages")
		->select('name') 
		->where('booking_id', $id)
		->get()->getResultArray();

		$package_names = '';
		if (!empty($query)) {
			$names = array_column($query, 'name'); 
			$package_names = implode(',', $names);
		}
		$data['package_names'] = $package_names;
		// // $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		// $query = $this->db->query("SELECT hall FROM terms_conditions ");
		// $result = $query->getRowArray();
		// $data['terms'] = json_decode($result['hall'], true);

		$querys = $this->db->table("booked_packages")
        ->select('package_id')
        ->where('booking_id', $id)
        ->get()->getResultArray();

    // Fetch and decode terms and conditions
		$terms_res = $this->db->table("terms_conditions_english")->get()->getRowArray();
		$terms = json_decode($terms_res['hall'], true);

		// Initialize an array to hold the terms for each package
		$allTerms = [];
		$bookingDetails = $this->db->table('templebooking')
        ->where('templebooking.id', $id)
        ->get()->getRowArray();
		$name = $bookingDetails['name'];
    	$ic_number = $bookingDetails['ic_number'];
		// Loop through each package ID and collect the terms
		foreach ($querys as $query) {
			$packageId = $query['package_id'];
			if (isset($terms[$packageId])) {
				foreach ($terms[$packageId] as $term) {
					// Replace {person_name} with $name and {ic_number} with $ic_number
					$replacedTerm = str_replace(['{person_name}', '{ic_number}'], [$name, $ic_number], $term);
					$allTerms[] = $replacedTerm;
				}
			}
		}

    	$data['terms'] = $allTerms;
		// echo json_encode($data);

		$tmpid = 1;
		$data['booked_slot'] = $this->db->table("booked_slot")->where("booking_id", $id)->get()->getRowArray();
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['booked_addon'] = $this->db->table("booked_addon")->where("booking_id", $id)->get()->getResultArray();
		$data['booked_services'] = $this->db->table("booked_services")->where("booking_id", $id)->get()->getResultArray();
		$data['pay_details'] = $this->db->table("booked_pay_details")->where("booking_id", $id)->get()->getResultArray();
		// echo view('templehallbooking/print_page', $data);
		echo view('frontend/booking/print_page', $data);
	}

	public function print_booking($hall_booking_id)
	{

		$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $hall_booking = $this->db->table('hall_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'frontend/booking/print';
		if ($hall_booking['paid_through'] == 'COUNTER') {
			if ($hall_booking['payment_status'] == '2') {
				//$data['qry2'] = $this->db->table('hall_booking_details')->where('hall_booking_id', $id)->get()->getResultArray();
				//echo "<pre>"; print_r($id); exit();
				$tmpid = 1;
				$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
				$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();

				$data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
				//echo $this->db->getLastQuery();
				//echo "<pre>"; print_r($data); exit();
				echo view($view_file, $data);
			} elseif ($hall_booking['payment_status'] == '1') {
				$hall_booking_payment_gateway_datas = $this->db->table('hall_booking_payment_gateway_datas')->where('hall_booking_id', $hall_booking_id)->get()->getRowArray();
				if (!empty($hall_booking_payment_gateway_datas['reference_id'])) {
					$reference_id = $hall_booking_payment_gateway_datas['reference_id'];
					$result_data = $this->initiatePayment_response($reference_id);
					$response_data = json_decode($result_data, true);
					$payment_gateway_up_data = array();
					$payment_gateway_up_data['response_data'] = $result_data;
					$this->db->table('hall_booking_payment_gateway_datas')->where('id', $hall_booking_payment_gateway_datas['id'])->update($payment_gateway_up_data);
					if (!empty($response_data['status'])) {
						if ($response_data['status'] == 'completed') {
							$hall_booking_up_data = array();
							$hall_booking_up_data['payment_status'] = 2;
							$this->db->table('hall_booking')->where('id', $id)->update($hall_booking_up_data);
							$this->account_migration($id);
							$tmpid = $this->session->get('profile_id');
							$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

							$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();

							$data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
							echo view($view_file, $data);
						} else {
							$hall_booking_up_data = array();
							$hall_booking_up_data['payment_status'] = 3;
							$this->db->table('hall_booking')->where('id', $id)->update($hall_booking_up_data);
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
			$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();

			$data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
			//echo $this->db->getLastQuery();
			//echo "<pre>"; print_r($data); exit();
			echo view($view_file, $data);
		}
	}
	public function list_booking_pdf($id)
	{
		$data['qry1'] = $hall_booking = $this->db->table('hall_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'frontend/booking/print';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();

		$data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
		//echo view($view_file, $data);

		$file_name = "Hall_Booking_" . $id;
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$dompdf->loadHtml(view($view_file, $data));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($file_name);

	}
	public function list_booking_print($id)
	{
		$data['qry1'] = $hall_booking = $this->db->table('hall_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'frontend/booking/print';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();

		/* $data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray(); */
		$data['hall_booking_service_details'] = $this->db->table("hall_booking_service_details")->where("hall_booking_id", $id)->get()->getResultArray();
		//echo view($view_file, $data);

		/* $file_name = "Hall_Booking_".$id;
			  $dompdf = new \Dompdf\Dompdf();
			  $options = $dompdf->getOptions(); 
			  $options->set(array('isRemoteEnabled' => true));
			  $dompdf->setOptions($options);			
			  $dompdf->loadHtml(view($view_file,  $data));
			  $dompdf->setPaper('A4', 'portrait');
			  $dompdf->render();
			  $dompdf->stream($file_name); */
		echo view($view_file, $data);

	}
	public function print_page()
	{

		/*if(!$this->model->permission_validate('hall_booking','print')){
			  header('Location: '.base_url().'/dashboard');			
		  }*/

		$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
		$data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray();
		//print_r($data['hall_booking_details']);
		echo view('frontend/booking/print', $data);
	}
	public function view()
	{
		/*if(!$this->model->permission_validate('hall_booking','view')){
				  header('Location: '.base_url().'/dashboard');			
			  }*/

		$id = $this->request->uri->getSegment(3);

		$res = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		$result = $this->db->table("hall_booking")->select("id, name")->where("booking_date", $res['booking_date'])->where("status<>", 3)->get()->getResultArray();

		$data_time = array();
		$time_name = array();
		$own_time = array();
		$i = 0;
		$time_res = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $id)->get()->getResultArray();

		foreach ($time_res as $row) {
			if (!empty($row)) {
				$own_time[] = $row["booking_slot_id"];
			}
		}
		foreach ($result as $r) {
			$ds = $this->db->table("hall_booking_slot_details")->select("booking_slot_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
			//print_r($ds);

			foreach ($ds as $rr) {
				if (!empty($rr)) {
					$data_time[] = $rr['booking_slot_id'];
					$time_name[$rr['booking_slot_id']] = $r['name'];
				}
			}
		}

		//die;
		$data['data'] = $res;
		$data['date'] = $date;
		$data['data_time'] = $data_time;
		$data['time_name'] = $time_name;
		$data['own_time'] = $own_time;
		$data['package_list'] = $this->db->table('hall_booking_details', 'booking_addonn.name')
			->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')
			->select('booking_addonn.name')
			->select('hall_booking_details.*,(hall_booking_details.amount+hall_booking_details.commission) as tot')
			->where('hall_booking_details.hall_booking_id', $id)
			->get()->getResultArray();
		//        echo '<pre>';
		// print_r($data['package_list']);
		// exit;
		$data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
		//$data['time_list'] = $this->db->table("booking_slot")->get()->getResultArray();
		//echo '<pre>';

		$data['time_list'] = $this->db->table('hall_booking_slot_details')
			->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')
			->select('booking_slot.*')
			->where('hall_booking_slot_details.hall_booking_id', $id)
			->get()->getResultArray();
		//print_r($data['time_list2']);

		//print_r($data['time_list']);die;
		$data['staff'] = $this->db->table("staff")->get()->getResultArray();
		$data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
		echo view('frontend/layout/header');
		//echo view('template/sidebar');
		echo view('frontend/booking/view_hallbooking', $data);
		echo view('frontend/layout/footer');
	}

	public function refund_pay()
	{
		$msg_data = array();
		$msg_data['succ'] = '';
		$id = $_POST['pay_id'];
		// Get Pay Details
		$res = $this->db->table('hall_booking_pay_details')->where('id', $id)->get()->getRowArray();
		$hall_id = $res['hall_booking_id'];
		$balance_amt = $res['amount'];
		if ($res) {
			// Cash Ledger
			$led_cash_led = $this->db->table('ledgers')->where('name', 'Cash Ledger')->get()->getRowArray();
			if (!empty($led_cash_led)) {
				$led_cash_led_id = $led_cash_led['id'];
			} else {
				$led_cash_led_data['group_id'] = 4;
				$led_cash_led_data['name'] = 'Cash Ledger';
				$led_cash_led_data['op_balance'] = '0';
				$led_cash_led_data['op_balance_dc'] = 'D';
				$led_cash_led_ins = $this->db->table('ledgers')->insert($led_cash_led_data);
				$led_cash_led_id = $this->db->insertID();
			}
			// Hall Booking Refund
			$led_hallrefund = $this->db->table('ledgers')->where('name', 'HALL BOOKING REFUND')->get()->getRowArray();
			if (!empty($led_hallrefund)) {
				$hallrefund_id = $led_hallrefund['id'];
			} else {
				$hall_refund['group_id'] = 31;
				$hall_refund['name'] = 'HALL BOOKING REFUND';
				$hall_refund['op_balance'] = '0';
				$hall_refund['op_balance_dc'] = 'D';
				$ress = $this->db->table('ledgers')->insert($hall_refund);
				$hallrefund_id = $this->db->insertID();
			}
			// Get Entry Number
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number))
				$num = 1;
			else
				$num = $number['number'] + 1;
			// Get Entry Code
			$date = explode('-', $_POST['event_date']);
			$yr = date('Y');
			$mon = date('m');
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

			$entries['entry_code'] = 'REC' . date('y') . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = date("Y-m-d");
			$entries['dr_total'] = $res['amount'];
			$entries['cr_total'] = $res['amount'];
			$entries['narration'] = 'Hall Booking';
			$entries['inv_id'] = $res['hall_booking_id'];
			$entries['type'] = 8;
			//Insert Entries
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty($en_id)) {
				// Hall Booking Refund => Debit
				$eitems_hall_book['entry_id'] = $en_id;
				$eitems_hall_book['ledger_id'] = $hallrefund_id;
				$eitems_hall_book['amount'] = $res['amount'];
				$eitems_hall_book['dc'] = 'D';
				$eitems_hall_book['details'] = 'Hall Booking Amount';
				$res1 = $this->db->table('entryitems')->insert($eitems_hall_book);
				// Cash Ledger => Credit 
				$eitems_cash_led['entry_id'] = $en_id;
				$eitems_cash_led['ledger_id'] = $led_cash_led_id;
				$eitems_cash_led['amount'] = $res['amount'];
				$eitems_cash_led['dc'] = 'C';
				$eitems_cash_led['details'] = 'Hall Booking Amount';
				$res2 = $this->db->table('entryitems')->insert($eitems_cash_led);
				if ($res1 && $res2) {
					$this->db->query("update hall_booking set balance_amount=balance_amount+$balance_amt, paid_amount=paid_amount-$balance_amt where id=$hall_id");
					$result = $this->db->table('hall_booking_pay_details')->delete(['id' => $id]);
					if ($result)
						$msg_data['succ'] = true;
					else
						$msg_data['succ'] = false;

				} else {
					$msg_data['succ'] = false;
				}
			}
		}
		echo json_encode($msg_data);
	}



	public function print_imin($id)
	{
		$data['qry1'] = $hall_booking = $this->db->table('hall_booking')->where('id', $id)->get()->getRowArray();
		$view_file = 'frontend/booking/print_imin';
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();

		/* $data['hall_booking_details'] = $this->db->table("hall_booking_details")->select('hall_booking_details.*, booking_addonn.name')->join('booking_addonn', 'booking_addonn.id = hall_booking_details.booking_addon_id')->where("hall_booking_details.hall_booking_id", $id)->get()->getResultArray(); */
		$data['hall_booking_service_details'] = $this->db->table("hall_booking_service_details")->where("hall_booking_id", $id)->get()->getResultArray();
		//echo view($view_file, $data);

		/* $file_name = "Hall_Booking_".$id;
			  $dompdf = new \Dompdf\Dompdf();
			  $options = $dompdf->getOptions(); 
			  $options->set(array('isRemoteEnabled' => true));
			  $dompdf->setOptions($options);			
			  $dompdf->loadHtml(view($view_file,  $data));
			  $dompdf->setPaper('A4', 'portrait');
			  $dompdf->render();
			  $dompdf->stream($file_name); */
		echo view($view_file, $data);

	}

	public function send_whatsapp_msg($id)
	{
		$hall_booking = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		$hall_booking_slot_details = $this->db->table("hall_booking_slot_details")->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->select('booking_slot.*')->where("hall_booking_id", $id)->get()->getResultArray();
		/* print_r($hall_booking_slot_details);
									  print_r($hall_booking); */
		$message_params = array();
		// $message_params[] = $hall_booking['name'];
		// $message_params[] = $hall_booking['event_name'];
		
		if (count($hall_booking_slot_details) > 0) {
			$slot_name = array();
			foreach ($hall_booking_slot_details as $hbsd) {
				$slot_name[] = $hbsd['name'] . '-' . $hbsd['description'];
			}
			$message_params[] = implode(' and ', $slot_name);
		} else
			$message_params[] = '';
		$message_params[] = date('d M, Y', strtotime($hall_booking['booking_date']));
		$message_params[] = date('h:i A', strtotime($hall_booking['created_at']));

		// $message_params[] = $hall_booking['total_amount'];
		$message_params[] = $hall_booking['paid_amount'];

	
		// $message_params[] = $hall_booking['balance_amount'];
		$media = array();
		$tmpid = 1;
		$data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['qry1'] = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
		$data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
		$data['hall_booking_details'] = $this->db->table("hall_booking_service_details")->select('hall_booking_service_details.*')->where("hall_booking_service_details.hall_booking_id", $id)->get()->getResultArray();
		//print_r($data['hall_booking_details']);
		$data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		
		// $html = view('hallbooking/pdf', $data);
		// $options = new Options();
		// $options->set('isHtml5ParserEnabled', true);
		// $options->set(array('isRemoteEnabled' => true));
		// $options->set('isPhpEnabled', true);
		// $dompdf = new Dompdf($options);
		// $dompdf->loadHtml($html);
		// $dompdf->setPaper('A4', 'portrait');
		// $dompdf->render();
		// $filePath = FCPATH . 'uploads/documents/invoice_hall_' . $id . '.pdf';

		// file_put_contents($filePath, $dompdf->output());

		// $media['url'] = base_url() . '/uploads/documents/invoice_hall_' . $id . '.pdf';
		// $media['filename'] = 'hall_booking_invoice.pdf';
		$media = array();
		$mobile_number = $hall_booking['mobile_number'];
		//$mobile_number = '+919092615446';
		/* print_r($mobile_number);
									  print_r($message_params);
									  print_r($media);
									  die;  */
		$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'hall_booking_live', $media);
		//echo $whatsapp_resp['success'];
		/* if($whatsapp_resp['success']) 
									  //echo 'success';
									  echo view('hallbooking/whatsapp_resp_suc');
									  else 
									  //echo 'fail'; 
									  echo view('hallbooking/whatsapp_resp_fail'); */
	}

	public function hall_old()
	{
		$login_id = $_SESSION['log_id_frend'];
		$default_group = $this->db->query("SELECT * FROM ubayam_group order by id asc limit 1")->getRowArray();
		$data['default'] = str_replace(' ', '_', strtolower($default_group['name']));
		// $data['sett_data'][''] = $this->db->table('ubayam_setting')->where('groupname', '')->get()->getResultArray();
		$data['res'] = $this->db->table('templebooking')->select('id')->where("booking_type", 1)->orderBy('id', 'desc')->get()->getRowArray();
		$data['rasi'] = $this->db->table('rasi')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		//$data['nat'] = $this->db->table('natchathram')->get()->getResultArray();
		// $group = $this->db->query("SELECT * FROM ubayam_group order by name asc")->getResultArray();
		// foreach ($group as $row) {
		// 	$data['sett_data'][$row['name']] = $this->db->table('ubayam_setting')->where('groupname', $row['name'])->get()->getResultArray();
		// }

		// $data['package'] = $this->db->table("temple_packages")->where('package_type', 2)->where('status', 1)->get()->getResultArray();
		$data['package'] = array();
		
		// $data['package_addon'] = $this->db->table("temple_services")->where('service_type', 2)->where('add_on', 1)->where('status', 1)->get()->getResultArray();
		$data['package_addon'] = array();
		$data['reprintlists'] = $this->db->query("SELECT id,paid_amount,ref_no,entry_date FROM templebooking WHERE created_by = '" . $login_id . "' and booking_through = 'COUNTER' AND payment_status = 2 and booking_type = 1 ORDER BY id DESC LIMIT 3")->getResultArray();
		$cur_date = date('Y-m-d');
		$ubayam_datas = $this->db->query("SELECT  tu.*, bp.name as event_name FROM  templebooking tu 
		JOIN booked_packages bp ON tu.id = bp.booking_id where ((tu.booking_through != 'DIRECT' and tu.booking_status in (1,2)) or (tu.booking_through = 'DIRECT')) and tu.booking_status != 3 and tu.booking_type = 1 
		ORDER BY tu.created_at ASC;")->getResultArray();
		$ubayamdata = array();
		if (!empty($ubayam_datas)) {
			foreach ($ubayam_datas as $ubayam_data) {
				$h_dat = array(
					"year" => intval(date("Y", strtotime($ubayam_data['booking_date']))),
					"month" => intval(date("m", strtotime($ubayam_data['booking_date']))),
					"day" => intval(date("d", strtotime($ubayam_data['booking_date']))),
					"event_id" => $ubayam_data['id'],
					"ref_no" => $ubayam_data['ref_no'],
					"otb" => 0,
					"name" => $ubayam_data['name'],
					"event_name" => $ubayam_data['event_name'],
					"register_by" => $ubayam_data['name']
				);
				$bal_amt= $ubayam_data['amount'] - $ubayam_data['paid_amt'];
				$h_dat['repay'] = false;
				if ($bal_amt > 0)
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

		// $group = $this->db->query("SELECT * FROM hall_group order by name asc")->getResultArray();
		// $data['package'][''] = $this->db->query("select * from booking_addonn where group_id is null or group_id = '' or group_id = 0")->getResultArray();
		// foreach ($group as $row) {
		// 	$data['package'][$row['name']] = $this->db->table('booking_addonn')->where('group_id', $row['id'])->get()->getResultArray();
		// }
		$data['time_list'] = $this->db->table("booking_slot_new")
		->select("booking_slot_new.*, booking_slot_type_new.*")
		->join("booking_slot_type_new", "booking_slot_type_new.booking_slot_id = booking_slot_new.id", "left")
		->where("booking_slot_type_new.slot_type", 1)
		->where("booking_slot_new.status", 1)
		->get()
		->getResultArray();
		$query = $this->db->query("SELECT hall FROM terms_conditions ");
		$result = $query->getRowArray();
		$data['terms'] = json_decode($result['hall'], true);
		echo view('frontend/layout/header');
		echo view('frontend/hallbooking_new/ubayam', $data);
		//echo view('frontend/layout/footer');
	}

}
