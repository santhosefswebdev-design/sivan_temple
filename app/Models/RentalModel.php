<?php
namespace App\Models;
use CodeIgniter\Model;
use Dompdf\Dompdf;
use Dompdf\Options;
class RentalModel extends Model {
    public function __construct()
    {
  	  parent::__construct();
        $this->session = \Config\Services::session($config);
    }

    public function send_whatsapp_msg(){
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
					$message_params = array();
					$message_params[] = $roww['tennant_name'];
					$message_params[] = date("M, Y");
					$message_params[] = !empty($roww['due_date']) ? $roww['due_date'] . date("m/Y") : '';
					$message_params[] = $pending_amt;
					$mobile_number = $roww['phone_no'];
					$mobile_number = '+919092615446';
					print_r($mobile_number);
					print_r($message_params);
					die; 
					$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'rental_live');
				}
			}
		}
    }
	
}