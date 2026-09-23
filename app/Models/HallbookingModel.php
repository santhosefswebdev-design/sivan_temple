<?php
namespace App\Models;
use CodeIgniter\Model;
use Dompdf\Dompdf;
use Dompdf\Options;
class HallbookingModel extends Model {
    public function __construct()
    {
  	  parent::__construct();
        $this->session = \Config\Services::session($config);
    }

    public function send_whatsapp_msg($id){
		$hall_booking = $this->db->table("hall_booking")->where("id", $id)->get()->getRowArray();
        $hall_booking_slot_details = $this->db->table("hall_booking_slot_details")->join('booking_slot', 'booking_slot.id = hall_booking_slot_details.booking_slot_id')->select('booking_slot.*')->where("hall_booking_id", $id)->get()->getResultArray();
		/* print_r($hall_booking_slot_details);
		print_r($hall_booking); */
		$message_params = array();
		// $message_params[] = $hall_booking['name'];
		// $message_params[] = $hall_booking['event_name'];
		$message_params[] = date('d M, Y', strtotime($hall_booking['booking_date']));
		if(count($hall_booking_slot_details) > 0){
			$slot_name = array();
			foreach($hall_booking_slot_details as $hbsd){
				$slot_name[] = $hbsd['name'] . '-' . $hbsd['description'];
			}
			$message_params[] = implode(' and ', $slot_name);
		}else $message_params[] = '';
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
		$data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
		$html = view('hallbooking/pdf', $data);
		$options = new Options();
		$options->set('isHtml5ParserEnabled', true);
		$options->set(array('isRemoteEnabled'=>true));
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
	
}