<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\HallbookingModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Cron extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
    }
    public function hallbook_remainder_notification()
    {
      $email = \Config\Services::email();
      $profile_id = 1;
      $query = $this->db->table('admin_profile')->where('id', $profile_id)->get()->getRowArray();
      $days = $query['hall_remind'];
      if($days!=0 || !empty($days)) {
        $hallremind_days = $days;
      }
      else{
        $hallremind_days = 5;
      }
		  $lists = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')  < NOW() + INTERVAL $hallremind_days DAY and paid_amount < total_amount;")->getResultArray();
        foreach($lists as $row)
        {
          if(!empty($row['email']))
          {
            $interval_date = $row['interval_date'];
            $html = "Hi, ";
            $html .= "Your booking has remaining $interval_date days to schedule, You need to pay the remaining amount.";
            $to = $row['email'];
            $subject = "Hall Booking Reminder";
            $message = $html;
            $email->setTo($to);
            $email->setFrom('templetest@grasp.com.my', 'Temple Rajamariamman');
          // $email->setNewline("\r\n");
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->send();
          }
       }

    }
    function testmail()
    {
      $email = \Config\Services::email();
      $html = "Hi, ";
      $html .= "this is test mail";
      $to = "rajkumar.bizsoft@gmail.com";
      $subject = "Test Mail";
      $message = $html;
      $email->setTo($to);
      $email->setFrom('templetest@grasp.com.my', 'Test Mail');
    // $email->setNewline("\r\n");
      $email->setSubject($subject);
      $email->setMessage($message);
      $email->send();
      //echo $email->print_debugger();
    }
    function daily_closing($mobile = ''){
		$tmpid = 1;
		$dailyclosing_start_date = date('Y-m-d');
		$dailyclosing_end_date = date("Y-m-d");
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['archanai_diety_details'] = $archanai_diety_data_online;
		$data['archanai_details'] = $archanai_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date,$dailyclosing_end_date);
		$data['prasadam_details'] = $prasadam_data;
		$data['temp_details'] = $temp_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$mobile_number = array();
		if(empty($mobile) && !empty($temp_details['daily_closing_phone'])){
			$daily_closing_phone = json_decode($temp_details['daily_closing_phone'], true);
			if(!empty($daily_closing_phone[0]['phonecode']) && !empty($daily_closing_phone[0]['phoneno'])){
				foreach($daily_closing_phone as $dcp){
					$mobile_number[] = $dcp['phonecode'] . $dcp['phoneno'];
				}
			}
		}else $mobile_number[] = $mobile;
		if(count($mobile_number) > 0){
			foreach($mobile_number as $mn){
				$html = view('daily_closing/pdf', $data);
				// echo $html;
				// die;
				$options = new Options();
				$options->set('isHtml5ParserEnabled', true);
				$options->set(array('isRemoteEnabled'=>true));
				$options->set('isPhpEnabled', true);
				$dompdf = new Dompdf($options);
				$dompdf->loadHtml($html);
				$dompdf->setPaper('A4', 'portrait');
				$dompdf->render();
				$filePath = FCPATH . 'uploads/documents/daily_closing_' . time() . '.pdf';
				file_put_contents($filePath, $dompdf->output());
				$message_params = array();
				$media['url'] = base_url() . '/uploads/documents/daily_closing_' . time() . '.pdf';
				$media['filename'] = 'daily_closing.pdf';
				$mobile = '+919092615446';
				// print_r($mobile);
				// print_r($message_params);
				// print_r($media);
				// die; 
				$whatsapp_resp = whatsapp_aisensy($mn, $message_params, 'daily_closing_live', $media);
				//print_r($whatsapp_resp);
			}
		}
	}
    function hall_booking_remainder($mobile = ''){
		$this->hallmodal = new HallbookingModel();
		$profile_id = 1;
		$query = $this->db->table('admin_profile')->where('id', $profile_id)->get()->getRowArray();
		$days = $query['hall_remind'];
		if($days!=0 || !empty($days)) {
			$hallremind_days = $days;
		}else{
			$hallremind_days = 5;
		}
		$remainder = $this->db->query("SELECT *, abs(datediff(DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d'), NOW())) as interval_date FROM hall_booking WHERE DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d') >= NOW() AND DATE_FORMAT(hall_booking.booking_date, '%Y-%m-%d')  < NOW() + INTERVAL $hallremind_days DAY and paid_amount < total_amount;")->getResultArray();
		if(count($remainder) > 0){
			foreach($remainder as $rm){
				$this->hallmodal->send_whatsapp_msg($rm['id']);
			}
		}

	}
	function rental_remainder($mobile = ''){
		$str_to_date_convert = date("Y-m");
		$datalist = $this->db->query("SELECT tennant.phone as phone_no,tennant.name as tennant_name, properties.id as property_id, properties.name as property_name,properties.rental_value as amount, properties.due_date FROM properties JOIN tennant ON tennant.property_id = properties.id WHERE '$str_to_date_convert' BETWEEN DATE_FORMAT(tennant.start_date,'%Y-%m') AND DATE_FORMAT(tennant.end_date,'%Y-%m') AND tennant.status = 1 ")->getResultArray();
		if(count($datalist) > 0){
			foreach ($datalist as $roww) {
				$paid_rental = $this->db->table("rental")->join('rental_pay_details', 'rental_pay_details.rental_id = rental.id')->select('SUM(rental_pay_details.amount) as paidamt')->where("rental.property_id", $roww['property_id'])->where("rental.month_year", $rental_monthyear)->groupBy('rental_pay_details.rental_id')->get()->getRowArray();
				if (floatval($paid_rental['paidamt']) == floatval($roww['amount']) || floatval($paid_rental['paidamt']) > floatval($roww['amount'])) {
					//echo "Full Paid";
				} else {
					//echo "Half Paid";
					$pending_amt = $roww['amount'] - $paid_rental['paidamt'];
					$due_date = $str_to_date_convert . "-01";
					$converted_month = date("M", strtotime($due_date));
					$retn_array[] = array("phone_no" => $roww['phone_no'], "tennant_name" => $roww['tennant_name'], "property_id" => $roww['property_id'], "property_name" => $roww['property_name'], "amount" => $roww['amount'], "pending_amount" => $pending_amt, "due_month" => $converted_month);
					$due_date = !empty($roww['due_date']) ? str_pad($roww['due_date'], 2, "0", STR_PAD_LEFT) . '/' . date("m/Y") : '';
					if(!empty($due_date)){
						if(date("Y-m") . '-' . str_pad($roww['due_date'], 2, "0", STR_PAD_LEFT) >= date("Y-m-d")){
							$message_params = array();
							$message_params[] = $roww['tennant_name'];
							$message_params[] = date("M, Y");
							$message_params[] = ' ' . $due_date;
							$message_params[] = (string) $pending_amt;
							$mobile_number = $roww['phone_no'];
							$mobile_number = '+60146488869';
							//$mobile_number = '+919092615446';
							/* print_r($mobile_number);
							print_r($message_params);
							die;  */
							$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'rental_live');
							/* print_r($whatsapp_resp);
							die; */
						}
					}else{
						$message_params = array();
						$message_params[] = $roww['tennant_name'];
						$message_params[] = date("M, Y");
						$message_params[] = $due_date;
						$message_params[] = (string) $pending_amt;
						$mobile_number = $roww['phone_no'];
						$mobile_number = '+60146488869';
						//$mobile_number = '+919092615446';
						/* print_r($mobile_number);
						print_r($message_params);
						die;  */
						$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'rental_live');
						/* print_r($whatsapp_resp);
						die; */
					}
				}
			}
		}
	}
	function member_renewal_update(){
		$current_date = date("Y-m-d");
		$member_renewal_data = $this->db->table('member')->where('member.end_date <=',$current_date)->get()->getResultArray();
		if(count($member_renewal_data) > 0){
			foreach($member_renewal_data as $row){
				$member_id = $row['id'];
				$data['status'] = 2;
				$this->db->table('member')->where('id', $member_id)->update($data);
				return true;
			}
		}
		
	}
}
