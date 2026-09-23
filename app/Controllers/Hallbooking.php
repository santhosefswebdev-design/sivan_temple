<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;


class Hallbooking extends BaseController
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
    if (!$this->model->list_validate('hall_booking')) {
      header('Location: ' . base_url() . '/dashboard');
    }
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/index');
    echo view('template/footer');
  }

  public function hallbook_list()
  {
    $data['permission'] = $this->model->get_permission('hall_booking');
    $date = $_REQUEST['date'];
    $data['list'] = $this->db->table("hall_booking")->where("DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')", $date)->get()->getResultArray();
    foreach ($data['list'] as &$d_list) {
      $slot_details = $this->db->table("booking_slot")->select('booking_slot.*')->join('hall_booking_slot_details', 'hall_booking_slot_details.booking_slot_id = booking_slot.id')->where("hall_booking_slot_details.hall_booking_id", $d_list['id'])->get()->getResultArray();
      $d_list['slot_details'] = $slot_details;
    }
    $data['date'] = $date;
    // print_r($data);die;
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/hallbooklist', $data);
    echo view('template/footer');
  }

  public function add_booking()
  {
    if (!$this->model->permission_validate('hall_booking', 'create_p')) {
      header('Location: ' . base_url() . '/dashboard');
    }
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
    $data['staff'] = $this->db->table("staff")->where('is_admin', 0)->get()->getResultArray();
    $data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
    $data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
    $data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/add_booking', $data);
    echo view('template/footer');
  }

  public function edit_booking()
  {
    if (!$this->model->permission_validate('hall_booking', 'edit')) {
      header('Location: ' . base_url() . '/dashboard');
    }
    $id = $this->request->uri->getSegment(3);

    $res = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
    if ($res['status'] != 1) {
      header('Location: ' . base_url() . '/hallbooking/view/' . $id);
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
    $data['package_list'] = $this->db->table('hall_booking_service_details')
      ->select('hall_booking_service_details.*')
      ->where('hall_booking_service_details.hall_booking_id', $id)
      ->get()->getResultArray();
    //        echo '<pre>';
    // print_r($data['package_list']);
    // exit;
    $data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
    $data['time_list'] = $this->db->table("booking_slot")->get()->getResultArray();
    $data['staff'] = $this->db->table("staff")->get()->getResultArray();
    $data['package'] = $this->db->table("booking_addonn")->get()->getResultArray();
    $data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/edit_hallbooking', $data);
    echo view('template/footer');
  }

  public function getpack_amt()
  {
    $id = $_POST['id'];
    $res = $this->db->table("booking_addonn")->where("id", $id)->get()->getRowArray();
    //$amt = $res['amount'] + $res['commision'];
    $amt = $res['amount'];
    $data['amt'] = $amt;
    $data['name'] = $res['name'];
    echo json_encode($data);
  }
  public function get_service_list()
  {
    $pack_id = $_POST['id'];
    $get_result_details = $this->db->table("booking_addonn_service")->where("booking_addon_id", $pack_id)->get()->getResultArray();
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
    //echo '<pre>';
    //print_r($_POST); exit;

    if (!empty($_POST['timing'])) {
		$entry_date = date("Y-m-d");
      $date = explode('-', $entry_date);
      $event_date = $_POST['event_date'];
      $slot_ids = array();
      $hall_booking_slots = $this->db->query("SELECT * FROM `hall_booking_slot_details` where hall_booking_id in (SELECT id FROM `hall_booking` WHERE status = 1 and `booking_date` = '$event_date') ")->getResultArray();
      if (count($hall_booking_slots)) {
        foreach ($hall_booking_slots as $hbs) {
          $slot_ids[] = $hbs['booking_slot_id'];
        }
      }
      $err = false;
      /* if (count($_POST['timing'])) {
        foreach ($_POST['timing'] as $key => $value) {
          if (in_array($value, $slot_ids))
            $err = true;
        }
      } else
        $err = true; */
		if (in_array($_POST['timing'], $slot_ids))
            $err = true;
      if (!$err) {
        $yr = $date[0];
        $mon = $date[1];
        $query = $this->db->query("SELECT ref_no FROM hall_booking where id=(select max(id) from hall_booking where year (entry_date)='" . $yr . "' and month (entry_date)='" . $mon . "')")->getRowArray();
        $data['ref_no'] = 'HA' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));

        $data['booking_date'] = $_POST['event_date'];
        $data['booking_time'] = date("H:i:s");
        $data['event_name'] = trim($_POST['event_name']);
        $data['register_by'] = trim($_POST['register']);
        $data['name'] = trim($_POST['name']);
        $data['status'] = $_POST['status'];
        $data['address'] = trim($_POST['address']);
        $mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
        $mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
        $data['mobile_number']  = $mble_phonecode.$mble_number;
        $data['email'] = trim($_POST['email']);
        $data['ic_no'] = trim($_POST['ic_num']);
        //$data['commision_to']   = trim($_POST['commission_to']);
        /* if(!empty($_POST['commission_to'])) $data['commision_to']   = implode(",",$_POST['commission_to']); */
        $data['total_amount'] = trim($_POST['total_amt']);
        $data['paid_amount'] = trim($_POST['deposie_amt']);
        $data['balance_amount'] = trim($_POST['balance']);
        $data['entry_date'] = date("Y-m-d H:i:s");
        $data['entry_by'] = $this->session->get('log_id');
        $data['created'] = date("Y-m-d H:i:s");
        $data['modified'] = date("Y-m-d H:i:s");
        $ip = 'unknown';
        $this->requestmodel = new RequestModel();
        $ip = $this->requestmodel->getIpAddress();
        if ($ip != 'unknown') {
          $ip_details = $this->requestmodel->getLocation($ip);
          $data['ip'] = $ip;
          $data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
          $data['ip_details'] = json_encode($ip_details);
        }

        if (!empty($data['booking_date']) && !empty($data['event_name']) && !empty($data['register_by']) && !empty($data['name']) && !empty($data['mobile_number'])) {
          $res = $this->db->table("hall_booking")->insert($data);
          //$whatsapp_resp = whatsapp_aisensy($data['mobile_number'], [], 'success_message1');
          if ($res) {
            $id = $this->db->insertID();
            /* $td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '3000')->get()->getRowArray();
                 if(!empty($td_ledger)){
                 $cr_id1 = $td_ledger['id'];
                 }else{
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
                 //Journal
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
                 $led_hall_book = $this->db->table('ledgers')->where('name', 'RENTAL - HALL')->where('group_id', $sls_id)->get()->getRowArray();
                 if(!empty($led_hall_book)){
                 $led_hall_book_id = $led_hall_book['id'];
                 }else{
                 $led_hall_book_data['group_id'] = $sls_id;
                 $led_hall_book_data['name'] = 'RENTAL - HALL';
                 $led_hall_book_data['left_code'] = '7022';
                 $led_hall_book_data['right_code'] = '000';
                 $led_hall_book_data['op_balance'] = '0';
                 $led_hall_book_data['op_balance_dc'] = 'D';
                 $led_hall_book__ins = $this->db->table('ledgers')->insert($led_hall_book_data);
                 $led_hall_book_id = $this->db->insertID();
                 } */
            if (!empty($_POST['service'])) {
              foreach ($_POST['service'] as $row) {
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
            if (!empty($_POST['staff_additional'])) {
              foreach ($_POST['staff_additional'] as $row) {
                $get_comm_amt = $this->db->table('staff')->where('id', $row['id'])->get()->getRowArray();
                $existing_com = !empty($get_comm_amt['commission_amt']) ? $get_comm_amt['commission_amt'] : 0;
                $curr_com = !empty($row['amount']) ? $row['amount'] : 0;
                $update_comm = $existing_com + $curr_com;
                $this->db->table("staff")->where('id', $row['id'])->update(array("commission_amt" => $update_comm));
                $commissiondata['hall_booking_id'] = $id;
                $commissiondata['staff_id'] = $row['id'];
                $commissiondata['amount'] = $row['amount'];
                $this->db->table("hall_booking_commission_details")->insert($commissiondata);
              }
            }
            if (!empty($_POST['pay'])) {
              foreach ($_POST['pay'] as $row) {
                $paydata['hall_booking_id'] = $id;
                $paydata['date'] = $row['date'];
                $paydata['amount'] = $row['pay_amt'];
                $paydata['payment_mode'] = $row['payment_mode'];
                $paydata['created'] = date("Y-m-d H:i:s");
                $paydata['updated'] = date("Y-m-d H:i:s");
                $this->db->table("hall_booking_pay_details")->insert($paydata);
                /* $paymentmode = $this->db->table('payment_mode')->where('id',$row['payment_mode'])->get()->getRowArray();
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
                     $entries['dr_total'] 	 = $row['pay_amt'];
                     $entries['cr_total'] 	 = $row['pay_amt'];						
                     $entries['narration'] 	 = 'Hall Booking';
                     $entries['inv_id']		 = $id;
                     $entries['type']		 = 8;
                     //Insert Entries
                     $ent = $this->db->table('entries')->insert($entries);
                     $en_id = $this->db->insertID();
                     if(!empty($en_id)){
                     // Hall Booking => Credit
                     $eitems_hall_book['entry_id'] = $en_id;
                     $eitems_hall_book['ledger_id'] = $led_hall_book_id;
                     $eitems_hall_book['amount'] = $row['pay_amt'];
                     $eitems_hall_book['dc'] = 'C'; 
                     $eitems_hall_book['details'] = 'Hall Booking Amount'; 
                     $this->db->table('entryitems')->insert($eitems_hall_book);
                     // Cash Ledger => Debit 
                     $eitems_cash_led['entry_id'] = $en_id;
                     $eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
                     $eitems_cash_led['amount'] = $row['pay_amt'];					
                     $eitems_cash_led['dc'] = 'D';
                     $eitems_cash_led['details'] = 'Hall Booking Amount'; 
                     $this->db->table('entryitems')->insert($eitems_cash_led);
                     } */
              }
            }
            /* foreach ($_POST['timing'] as $key => $value) {
              $slotdata['hall_booking_id'] = $id;
              $slotdata['booking_slot_id'] = $value;
              $this->db->table("hall_booking_slot_details")->insert($slotdata);
            } */
			$slotdata['hall_booking_id'] = $id;
            $slotdata['booking_slot_id'] = $_POST['timing'];
            $this->db->table("hall_booking_slot_details")->insert($slotdata);
			
            $this->account_migration($id);
            $this->send_whatsapp_msg($id);
            if (!empty($_POST['email'])) {
              $temple_title = "Temple " . $_SESSION['site_title'];
              $qr_url = base_url() . "/hallbooking/reg/";
              $mail_data['qr_image'] = qrcode_generation($id, $qr_url);
              $mail_data['hall_id'] = $id;
              $tmpid = 1;
              $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
              $mail_data['temple_details'] = $temple_details;
              $message = view('hallbooking/mail_template', $mail_data);
              $subject = $_SESSION['site_title'] . " HALL BOOKING";
              $to_user = $_POST['email'];
              $to_mail = array("prithivitest@gmail.com", $to_user);
              send_mail_with_content($to_mail, $message, $subject, $temple_title);
            }
            $msg_data['succ'] = 'Hall Booking Added Successfully';
            $msg_data['id'] = $id;
          } else {
            $msg_data['err'] = 'Please Try Again';
          }
        } else {
          $msg_data['err'] = 'Please Fill All Required Field';
        }
      } else {
        $msg_data['err'] = 'Your timing slot registered by another person. Please reload the page.';
      }
    } else {
      $msg_data['err'] = 'Please select at-least on timing Again';
    }
    echo json_encode($msg_data);
    exit();
  }
  public function account_migration($hall_booking_id)
  {
    $hall_booking = $this->db->table("hall_booking")->where("id", $hall_booking_id)->get()->getRowArray();
	$entry_date = date('Y-m-d', strtotime($hall_booking['entry_date']));
	$date = explode('-', $entry_date);
    $yr = $date[0];
    $mon = $date[1];
    $td_ledger = $this->db->table('ledgers')->where('name', 'TRADE RECEIVABLE')->where('group_id', 3)->where('left_code', '1200')->get()->getRowArray();
    if (!empty($td_ledger)) {
      $cr_id1 = $td_ledger['id'];
    } else {
      $cled1['group_id'] = 3;
      $cled1['name'] = 'TRADE RECEIVABLE';
      $cled1['code'] = '1200/0001';
      $cled1['op_balance'] = '0';
      $cled1['op_balance_dc'] = 'D';
      $cled1['left_code'] = '1200';
      $cled1['right_code'] = '0001';
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
					if(!empty($hallbooking_details['ledger_id'])){
						$led_hall_book_id = $hallbooking_details['ledger_id'];
					}else{
						$ledger1 = $this->db->table('ledgers')->where('name', 'All Incomes')->where('group_id', $sls_id)->get()->getRowArray();
						if(!empty($ledger1)){
							$led_hall_book_id = $ledger1['id'];
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
							$led_hall_book_id = $this->db->insertID();
						}
					}
          // Hall Booking => Credit
          $eitems_hall_book['entry_id'] = $en_id1;
          $eitems_hall_book['ledger_id'] = $led_hall_book_id;
          $eitems_hall_book['amount'] = $row['service_amount'];
          $eitems_hall_book['dc'] = 'C';
          $eitems_hall_book['details'] = 'Amount for' . $row['service_name'];
          $this->db->table('entryitems')->insert($eitems_hall_book);
          //  Trade Debtors => Debit 
          $eitems_cash_led['entry_id'] = $en_id1;
          $eitems_cash_led['ledger_id'] = $cr_id1;
          $eitems_cash_led['amount'] = $row['service_amount'];
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
            $eitems_hall_book['details'] = 'Hall Booking Amount';
            $this->db->table('entryitems')->insert($eitems_hall_book);
            // PETTY CASH => Debit 
            $eitems_cash_led['entry_id'] = $en_id;
            $eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
            $eitems_cash_led['amount'] = $row['amount'];
            $eitems_cash_led['dc'] = 'D';
            $eitems_cash_led['details'] = 'Hall Booking Amount';
            $this->db->table('entryitems')->insert($eitems_cash_led);
          }
        }
      }
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
      if (!empty($_POST['commission_to']))
        $data['commision_to'] = implode(",", $_POST['commission_to']);
      $data['total_amount'] = trim($_POST['total_amt']);
      $data['paid_amount'] = trim($_POST['deposie_amt']);
      $data['balance_amount'] = trim($_POST['balance']);
      //$data['entry_date']     = date("Y-m-d H:i:s");
      $data['entry_by'] = $this->session->get('log_id');
      $data['modified'] = date("Y-m-d H:i:s");
      if (!empty($data['booking_date']) && !empty($data['event_name']) && !empty($data['register_by']) && !empty($data['name']) && !empty($data['mobile_number'])) {
        //$res1 = $this->db->table('hall_booking_service_details')->delete(['hall_booking_id' => $id]);
        //$res2 = $this->db->table('hall_booking_pay_details')->delete(['hall_booking_id' => $id]);
        //$res3 = $this->db->table('hall_booking_slot_details')->delete(['hall_booking_id' => $id]);
        if ($id) {
          // Trade Debtors
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
          //Debit Cash in hand
          /*  $cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
           if(!empty($cashinhand)){
             $cih_id = $cashinhand['id'];
           }else{
             $cih1['parent_id'] = 3;
             $cih1['name'] = 'Cash-in-Hand';
             $cih1['code'] = '111';
             $cih1['added_by'] = $this->session->get('log_id');
             $this->db->table('ledgers')->insert($cih1);
             $cih_id = $this->db->insertID();
           }
           $pettycash_ledger = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
           if(!empty($pettycash_ledger)){
             $cr_id2 = $pettycash_ledger['id'];
           }else{
             $cled2['group_id'] = 4;
             $cled2['name'] = 'PETTY CASH';
             $cled2['op_balance'] = '0';
             $cled2['op_balance_dc'] = 'C';
             $this->db->table('ledgers')->insert($cled2);
             $cr_id2 = $this->db->insertID();
           } */
          //Journal***************************************//
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
          $led_hall_book = $this->db->table('ledgers')->where('name', 'RENTAL - HALL')->where('group_id', $sls_id)->get()->getRowArray();
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
          // Cash Ledger
          /* $led_cash_led = $this->db->table('ledgers')->where('name', 'Cash Ledger')->where('group_id', 4)->get()->getRowArray();
          if(!empty($led_cash_led)){
            $led_cash_led_id = $led_cash_led['id'];
          }else{
            $led_cash_led_data['group_id'] = 4;
            $led_cash_led_data['name'] = 'Cash Ledger';
            $led_cash_led_data['op_balance'] = '0';
            $led_cash_led_data['op_balance_dc'] = 'D';
            $led_cash_led_ins = $this->db->table('ledgers')->insert($led_cash_led_data);
            $led_cash_led_id = $this->db->insertID();
          } */
          // Expenses Hall Booking Refund
          /* $ehbr_ledger = $this->db->table('ledgers')->where('name', 'RENTAL - HALL')->where('group_id', 29)->get()->getRowArray();
          if(!empty($ehbr_ledger)){
            $ehbr_id = $ehbr_ledger['id'];
          }else{
            $cled1_ehbr['group_id'] = 29;
            $cled1_ehbr['name'] = 'RENTAL - HALL';
    $cled1_ehbr['left_code'] = '7022';
    $cled1_ehbr['right_code'] = '000';
            $cled1_ehbr['op_balance'] = '0';
            $cled1_ehbr['op_balance_dc'] = 'D';
            $this->db->table('ledgers')->insert($cled1_ehbr);
            $ehbr_id = $this->db->insertID();
          } */
          // Payment details ******************************//
		  $hall_booking = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
          if (!empty($_POST['pay'])) {
            foreach ($_POST['pay'] as $row) {
              $paydata['hall_booking_id'] = $id;
              $paydata['date'] = $row['date'];
              $paydata['amount'] = $row['pay_amt'];
              $paydata['payment_mode'] = $row['payment_mode'];
              $paydata['created'] = date("Y-m-d H:i:s");
              $paydata['updated'] = date("Y-m-d H:i:s");
              $this->db->table("hall_booking_pay_details")->insert($paydata);

              $paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
              // Get Entry Number
              $number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
              if (empty($number))
                $num = 1;
              else
                $num = $number['number'] + 1;
			
				$date = explode('-', $paydata['date']);
				$yr = $date[0];
				$mon = $date[1];
              // Get Entry Code
              $qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();

              $entries['entry_code'] = 'REC' . date('y', strtotime($paydata['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
              $entries['entrytype_id'] = '1';
              $entries['number'] = $num;
              $entries['date'] = $paydata['date'];
              $entries['dr_total'] = $row['pay_amt'];
              $entries['cr_total'] = $row['pay_amt'];
              $entries['narration'] = 'Hall Booking(' . $hall_booking['ref_no'] . ')' . "\n" . 'name:' . $hall_booking['name'] . "\n" . 'NRIC:' . $hall_booking['ic_no'] . "\n" . 'email:' . $hall_booking['email'] . "\n";
              $entries['inv_id'] = $id;
              $entries['type'] = 8;
              //Insert Entries
              $ent = $this->db->table('entries')->insert($entries);
              $en_id = $this->db->insertID();
              if (!empty($en_id)) {
                // Hall Booking => Credit
                $eitems_hall_book['entry_id'] = $en_id;
                $eitems_hall_book['ledger_id'] = $cr_id1;
                $eitems_hall_book['amount'] = $row['pay_amt'];
                $eitems_hall_book['dc'] = 'C';
                $eitems_hall_book['details'] = 'Hall Booking Amount';
                $this->db->table('entryitems')->insert($eitems_hall_book);
                // Cash Ledger => Debit 
                $eitems_cash_led['entry_id'] = $en_id;
                $eitems_cash_led['ledger_id'] = $paymentmode['ledger_id'];
                $eitems_cash_led['amount'] = $row['pay_amt'];
                $eitems_cash_led['dc'] = 'D';
                $eitems_cash_led['details'] = 'Hall Booking Amount';
                $this->db->table('entryitems')->insert($eitems_cash_led);
              }
            }
          }
          /* foreach ($_POST['timing'] as $key => $value) { 
            $slotdata['hall_booking_id'] = $id;
            $slotdata['booking_slot_id'] = $value;
            $this->db->table("hall_booking_slot_details")->insert($slotdata);
          } */
          $res = $this->db->table("hall_booking")->where('id', $id)->update($data);
          if ($res) {
            if ($data['status'] == 3) {
              $hall_booking_pay_details = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
              if (count($hall_booking_pay_details) > 0) {
                foreach ($hall_booking_pay_details as $row) {
                  $paydata_re['hall_booking_id'] = $id;
                  $paydata_re['date'] = $row['date'];
                  $paydata_re['amount'] = $row['amount'];
                  $paydata_re['created'] = date("Y-m-d H:i:s");
                  $paydata_re['updated'] = date("Y-m-d H:i:s");
                  $this->db->table("hall_booking_refund_details")->insert($paydata_re);
                  // Get Entry Number
                  $number_rf = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
                  if (empty($number_rf))
                    $num_rf = 1;
                  else
                    $num_rf = $number_rf['number'] + 1;
                  //Payment Mode Details
                  $paymentmode = $this->db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
                  // Get Entry Code
                  $qry_rf = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
                  $entries_rf['entry_code'] = 'REC' . date('y', strtotime($_POST['event_date'])) . $mon . (sprintf("%05d", (((float) substr($qry_rf['entry_code'], -5)) + 1)));
                  $entries_rf['entrytype_id'] = '1';
                  $entries_rf['number'] = $num_rf;
                  $entries_rf['date'] = date("Y-m-d");
                  $entries_rf['dr_total'] = $row['amount'];
                  $entries_rf['cr_total'] = $row['amount'];
                  $entries_rf['narration'] = 'Hall Booking Cancellation';
                  $entries_rf['inv_id'] = $id;
                  $entries_rf['type'] = 8;
                  //Insert Entries
                  $this->db->table('entries')->insert($entries_rf);
                  $en_id_rf = $this->db->insertID();
                  if (!empty($en_id_rf)) {
                    // Hall Booking => Debit
                    $eitems_hall_book_rf['entry_id'] = $en_id_rf;
                    $eitems_hall_book_rf['ledger_id'] = $cr_id1;
                    $eitems_hall_book_rf['amount'] = $row['amount'];
                    $eitems_hall_book_rf['dc'] = 'D';
                    $eitems_hall_book_rf['details'] = 'Hall Booking Cancellation';
                    $this->db->table('entryitems')->insert($eitems_hall_book_rf);
                    // Cash Ledger => credit 
                    $eitems_cash_led_rf['entry_id'] = $en_id_rf;
                    $eitems_cash_led_rf['ledger_id'] = $paymentmode['ledger_id'];
                    $eitems_cash_led_rf['amount'] = $row['amount'];
                    $eitems_cash_led_rf['dc'] = 'C';
                    $eitems_cash_led_rf['details'] = 'Hall Booking Cancellation';
                    $this->db->table('entryitems')->insert($eitems_cash_led_rf);
                  }
                }
              }
              /* $hall_booking_details = $this->db->table("hall_booking_service_details")->where("hall_booking_id", $id)->get()->getResultArray();
                          if(count($hall_booking_details) > 0){
                            foreach($hall_booking_details as $row){
                              $number1_rf = $this->db->table('entries')->select('number')->where('entrytype_id',4)->orderBy('id','desc')->get()->getRowArray(); 
                              if(empty($number1_rf)) $num1_rf = 1;
                              else $num1_rf = $number1_rf['number'] + 1;
                              // Get Entry Code
                              $qry1_rf   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =4 and month (date)='". $mon ."')")->getRowArray();
                              
                              $entries1_rf['entry_code'] = 'JOR' .date('y',strtotime($_POST['event_date'])).$mon. (sprintf("%05d",(((float)  substr($qry1_rf['entry_code'],-5))+1)));
                              $entries1_rf['entrytype_id'] = '4';
                              $entries1_rf['number'] 		 = $num1_rf;
                              $entries1_rf['date'] 		 = date("Y-m-d");					
                              $entries1_rf['dr_total'] 	 = $row['service_amount'];
                              $entries1_rf['cr_total'] 	 = $row['service_amount'];						
                              $entries1_rf['narration'] 	 = 'Hall Booking Cancellation';
                              $entries1_rf['inv_id']		 = $id;
                              $entries1_rf['type']		 = 8;
                              //Insert Entries
                              $this->db->table('entries')->insert($entries1_rf);
                              $en_id1_rf = $this->db->insertID();
                              if(!empty($en_id1_rf)){
                                // Expense Hall Booking Refund => Debit
                                $eitems_hall_book1_rf['entry_id'] = $en_id1_rf;
                                $eitems_hall_book1_rf['ledger_id'] = $ehbr_id;
                                $eitems_hall_book1_rf['amount'] = $row['service_amount'];
                                $eitems_hall_book1_rf['dc'] = 'D'; 
                                $eitems_hall_book1_rf['details'] = 'Hall Booking Cancellation'; 
                                $this->db->table('entryitems')->insert($eitems_hall_book1_rf);
                                //  Trade Debtors => Credit 
                                $eitems_cash_led1_rf['entry_id'] = $en_id1_rf;
                                $eitems_cash_led1_rf['ledger_id'] = $cr_id1;
                                $eitems_cash_led1_rf['amount'] = $row['service_amount'];					
                                $eitems_cash_led1_rf['dc'] = 'C';
                                $eitems_cash_led1_rf['details'] = 'Hall Booking Cancellation'; 
                                $this->db->table('entryitems')->insert($eitems_cash_led1_rf);
                              }
                            }
                          } */
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
    /*$query   = $this->db->query("SELECT booking_date, COUNT(booking_date) as tcnt
                                        FROM hall_booking where status!=3
                                        GROUP BY booking_date
                                        HAVING COUNT(booking_date) > 0"); */

    $query = $this->db->query("SELECT DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') as booking_date, hall_booking.id as hall_id, COUNT(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')) as tcnt
                                  FROM hall_booking where status!=3
                                  GROUP BY DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')
                                  HAVING COUNT(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')) > 0");
    /* $query = $this->db->query("DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') as booking_date, COUNT(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')) as tcnt
                                  FROM hall_booking where status!=3
                                  GROUP BY DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')
                                  HAVING COUNT(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')) > 0
                              "); */
    $res = $query->getResultArray();
    
    $res_array = array();
    foreach($res as $row){
        $html = array();
        $hb_booking_date = $row['booking_date'];
        $hb_slot_id = $row['hall_id'];
        $slot_dets = $this->db->query("SELECT bs.name,bs.description,bs.slot_season,hbsd.hall_booking_id FROM hall_booking_slot_details as hbsd JOIN booking_slot as bs ON bs.id = hbsd.booking_slot_id where hbsd.hall_booking_id = $hb_slot_id ")->getResultArray();
        foreach($slot_dets as $slot_row){
            $hb_id = $slot_row['hall_booking_id'];
            $html[]= $slot_row['name']."-".$slot_row['description']."\n(".$slot_row['slot_season'].")"."\n";
            $service_dets = $this->db->query("SELECT hbsd.service_name FROM hall_booking_service_details as hbsd where hbsd.hall_booking_id = $hb_id ")->getResultArray();
            foreach($service_dets as $service_row){
                $html[]= $service_row['service_name']."\n";
            }
        }
        $res_array[] = array('booking_date'=>$hb_booking_date,'slot_pack_dets'=>$html);
    }
    //var_dump(json_encode($res_array));
    //exit;
    echo json_encode($res_array);
  }


  public function print_page()
  {

    if (!$this->model->permission_validate('hall_booking', 'print')) {
      header('Location: ' . base_url() . '/dashboard');
    }

    $id = $this->request->uri->getSegment(3);

    $data['qry1'] = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
    $data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
    $data['hall_booking_details'] = $this->db->table("hall_booking_service_details")->select('hall_booking_service_details.*')->where("hall_booking_service_details.hall_booking_id", $id)->get()->getResultArray();
    //print_r($data['hall_booking_details']);
    $data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
    $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
    echo view('hallbooking/print', $data);
  }
  public function view()
  {
    if (!$this->model->permission_validate('hall_booking', 'view')) {
      header('Location: ' . base_url() . '/dashboard');
    }

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
    $data['package_list'] = $this->db->table('hall_booking_service_details')
      ->select('hall_booking_service_details.*')
      ->where('hall_booking_service_details.hall_booking_id', $id)
      ->get()->getResultArray();
    //        echo '<pre>';
    // print_r($data['package_list']);
    // exit;
    $data['pay_details'] = $this->db->table("hall_booking_pay_details")->join('payment_mode', 'payment_mode.id = hall_booking_pay_details.payment_mode')->select('hall_booking_pay_details.*,payment_mode.name as paymentname')->where("hall_booking_id", $id)->get()->getResultArray();
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
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/view_hallbooking', $data);
    echo view('template/footer');
  }
  public function assignchecklist()
  {
    $id = $this->request->uri->getSegment(3);
    $res = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
    $data['data'] = $res;
    $data['package_list'] = $this->db->table('hall_booking_service_details')
      ->select('hall_booking_service_details.*')
      ->where('hall_booking_service_details.hall_booking_id', $id)
      ->get()->getResultArray();
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/checklist_hallbooking', $data);
    echo view('template/footer');
  }
  public function getchecklistamt()
  {
    $id = $_POST['check_id'];
    $res = $this->db->table("checklist")->where("id", $id)->get()->getRowArray();
    $amt = !empty($res['amount']) ? $res['amount'] : "";
    echo $amt;
  }
  public function assignchecklist_update()
  {
    $hall_id = $_POST['hall_id'];
    if (!empty($_POST['checklist'])) {
      foreach ($_POST['checklist'] as $row) {
        $checklist_id = !empty($row['checklist_id']) ? $row['checklist_id'] : NULL;
        $checklist_amount = !empty($row['checklist_amount']) ? $row['checklist_amount'] : NULL;
        $checklist_remarks = !empty($row['checklist_remarks']) ? $row['checklist_remarks'] : NULL;
        $checklist_data = array(
          "checklist_id" => $checklist_id,
          "checklist_amount" => $checklist_amount,
          "remarks" => $checklist_remarks
        );
        $this->db->table("hall_booking_service_details")
          ->where('id', $row['hallbook_service_id'])
          ->where('hall_booking_id', $hall_id)
          ->update($checklist_data);
      }
    }
    $this->session->setFlashdata('succ', 'Checklist Data Updated Successfully.');
    return redirect()->to("/hallbooking/assignchecklist/" . $hall_id);
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

  public function hallbook_remainder_list()
  {
    $data['permission'] = $this->model->get_permission('hall_booking');
    $profile_id = $_SESSION['profile_id'];
    $query = $this->db->table('admin_profile')->where('id', $profile_id)->get()->getRowArray();
    $days = $query['hall_remind'];
    if ($days != 0 || !empty($days)) {
      $hallremind_days = $days;
    } else {
      $hallremind_days = 5;
    }

    $data['list'] = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')  < NOW() + INTERVAL $hallremind_days DAY and paid_amount < total_amount;")->getResultArray();

    // echo $this->db->getLastQuery();
    //exit;
    echo view('template/header');
    echo view('template/sidebar');
    echo view('hallbooking/hallbook_remainder_list', $data);
    echo view('template/footer');
  }

  public function block_event_list()
  {
    /*$query   = $this->db->query("SELECT booking_date, COUNT(booking_date) as tcnt
                                        FROM hall_booking where status!=3
                                        GROUP BY booking_date
                                        HAVING COUNT(booking_date) > 0"); */

    $query = $this->db->query("SELECT DATE_FORMAT(block_date.date, '%Y-%m-%d') as booking_date,
                                  description,id FROM block_date 
                                  GROUP BY DATE_FORMAT(block_date.date, '%Y-%m-%d')");
    $res = $query->getResultArray();
    echo json_encode($res);
  }

  public function block_event_add()
  {
    if (!empty($_POST['event_id'])) {
      $id = $_POST['event_id'];
      $updatedata["description"] = $_POST['description'];
      $this->db->table('block_date')->where('id', $id)->update($updatedata);
      $this->session->setFlashdata('succ', 'Hallblocking Data Updated Successfully');
      return redirect()->to("/master/hall_block");
    } else {
      $data["date"] = $_POST['event_date'];
      $data["description"] = $_POST['description'];
      $data["created"] = date("Y-m-d H:i:s");
      $this->db->table('block_date')->insert($data);
      $this->session->setFlashdata('succ', 'Hallblocking Data Created Successfully');
      return redirect()->to("/master/hall_block");
    }
  }
  public function block_event_delete()
  {
    $id = $_POST['id'];
    $res = $this->db->table('block_date')->delete(['id' => $id]);
    $this->session->setFlashdata('succ', 'Hallblocking Data Deleted Successfully');
    return redirect()->to("/master/hall_block");
  }
  public function blocked_event_check()
  {
    $eventdate = $_POST['eventdate'];
    $retndate = $this->db->table('block_date')->select('date')->where('date', $eventdate)->get()->getRowArray();
    echo !empty($retndate['date']) ? $retndate['date'] : "";
  }
  function hallbook_reminder_sendmail()
  {
    $id = $_POST['hallbook_id'];
    $hallbookdet = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE id = $id ")->getRowArray();
    //var_dump($hallbookdet);
    // exit;
    $email = \Config\Services::email();
    if (!empty($hallbookdet['email'])) {
      $interval_date = $hallbookdet['interval_date'];
      //exit;
      $html = "Hi, ";
      $html .= "Your booking has remaining $interval_date days to schedule, You need to pay the remaining amount.";
      $to = $hallbookdet['email'];
      $subject = "Hall Booking Reminder";
      $message = $html;
      $email->setTo($to);
      $email->setFrom('templetest@grasp.com.my', 'Temple Rajamariamman');
      // $email->setNewline("\r\n");
      $email->setSubject($subject);
      $email->setMessage($message);
      if ($email->send()) {
        //print_r($email->printDebugger(['headers']));
        // exit;
        $this->session->setFlashdata('succ', 'Email successfully sent');
        return redirect()->to("/hallbooking/hallbook_remainder_list");
      } else {
        $data = $email->printDebugger(['headers']);
        print_r($data);
      }
    } else {
      //exit;
      $this->session->setFlashdata('fail', 'Email address not found.');
      return redirect()->to("/hallbooking/hallbook_remainder_list");
    }

  }
  public function get_payment_mode()
  {
    $id = $_POST['id'];
    $res = $this->db->table("payment_mode")->where("id", $id)->get()->getRowArray();
    $p_id = $res['id'];
    $name = $res['name'];
    $data['id'] = $p_id;
    $data['name'] = $name;
    echo json_encode($data);
  }
  public function get_staff_commision_name()
  {
    $id = $_POST['id'];
    $res = $this->db->table("staff")->where("id", $id)->get()->getRowArray();
    $p_id = $res['id'];
    $name = $res['name'];
    $data['id'] = $p_id;
    $data['name'] = $name;
    echo json_encode($data);
  }
  public function get_package_description_name()
  {
    $id = $_POST['id'];
    $res = $this->db->table("booking_addonn")->where("id", $id)->get()->getRowArray();
    $p_id = $res['id'];
    $description = $res['description'];
    $data['id'] = $p_id;
    $data['description'] = $description;
    echo json_encode($data);
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
    $message_params[] = date('d M, Y', strtotime($hall_booking['booking_date']));
    if (count($hall_booking_slot_details) > 0) {
      $slot_name = array();
      foreach ($hall_booking_slot_details as $hbsd) {
        $slot_name[] = $hbsd['name'] . '-' . $hbsd['description'];
      }
      $message_params[] = implode(' and ', $slot_name);
    } else
      $message_params[] = '';
    $message_params[] = $hall_booking['total_amount'];
    // $message_params[] = $hall_booking['paid_amount'];
    $message_params[] = $hall_booking['balance_amount'];
    $media = array();
    $tmpid = 1;
    $data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
    $data['qry1'] = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
    $data['hall_booking_slot_details'] = $this->db->table("hall_booking_slot_details")->select('hall_booking_slot_details.*, CONCAT(booking_slot.name,\'-\',booking_slot.description) as slot_time')->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->where("hall_booking_slot_details.hall_booking_id", $id)->get()->getResultArray();
    $data['hall_booking_details'] = $this->db->table("hall_booking_service_details")->select('hall_booking_service_details.*')->where("hall_booking_service_details.hall_booking_id", $id)->get()->getResultArray();
    //print_r($data['hall_booking_details']);
    $data['pay_details'] = $this->db->table("hall_booking_pay_details")->where("hall_booking_id", $id)->get()->getResultArray();
    $data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
    $html = view('hallbooking/pdf', $data);
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set(array('isRemoteEnabled' => true));
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $filePath = FCPATH . 'uploads/documents/invoice_hall_' . $id . '.pdf';

    file_put_contents($filePath, $dompdf->output());

    $media['url'] = base_url() . '/uploads/documents/invoice_hall_' . $id . '.pdf';
    $media['filename'] = 'invoice.pdf';
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

  public function overall_blocked_event_check()
  {
    $eventdate = $_POST['eventdate'];
    $retndate = $this->db->table('overall_temple_block')->select('date')->where('date', $eventdate)->get()->getRowArray();
    echo !empty($retndate['date']) ? $retndate['date'] : "";
  }
}
