<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class IpayResponse extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
    }
	public function archanai($arch_book_id) {
		include_once FCPATH . 'app/Libraries/ipay88-master/IPay88.class.php';
		die;
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
			$this->session->setFlashdata('succ', 'Archanai Booking Successfully');
			$redirect_url = base_url() . '/archanai_booking/print_booking/' .$arch_book_id;
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
}
