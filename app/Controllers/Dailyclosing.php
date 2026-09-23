<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Dailyclosing extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}
	public function index()
	{
		if (!empty($_POST['dailyclosing_start_date']))
			$dailyclosing_start_date = $_POST['dailyclosing_start_date'];
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($_POST['dailyclosing_end_date']))
			$dailyclosing_end_date = $_POST['dailyclosing_end_date'];
		else
			$dailyclosing_end_date = date("Y-m-d");
		/* $archanai_data_direct = daily_archanai_booking_withcurrentdate_overall($current_date, $booking_type = "DIRECT");
					$archanai_data_online = daily_archanai_booking_withcurrentdate_overall($current_date, $booking_type = "ONLINE"); */
		$data['archanai_details'] = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		/* $hallbooking_data_direct = daily_hall_booking_withcurrentdate($current_date, $booking_type = "DIRECT");
					$hallbooking_data_online = daily_hall_booking_withcurrentdate($current_date, $booking_type = "ONLINE");
					$data['hallbooking_details'] = array_merge($hallbooking_data_direct,$hallbooking_data_online); */
		$data['archanai_group_details'] = daily_group_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['hallbooking_details'] = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);

		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['prasadam_details'] = $prasadam_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['repayment_details'] = $repayment_data;
		$payment_voucher_data = daily_payment_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['repayment_details'] = $repayment_data;
	
		$data['payment_voucher_details'] = $payment_voucher_data;
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;

		echo view('template/header');
		echo view('template/sidebar');
		echo view('daily_closing/index', $data);
		echo view('template/footer');
	}
	public function print($fromdate, $todate)
	{
		$tmpid = $this->session->get('profile_id');
		if (!empty($fromdate))
			$dailyclosing_start_date = date('Y-m-d', $fromdate);
		else
			$dailyclosing_start_date = date("Y-m-d");
		if (!empty($todate))
			$dailyclosing_end_date = date('Y-m-d', $todate);
		else
			$dailyclosing_end_date = date("Y-m-d");
		/* $archanai_data_direct = daily_archanai_booking_withcurrentdate($current_date, $booking_type = "DIRECT");
					$archanai_data_online = daily_archanai_booking_withcurrentdate($current_date, $booking_type = "ONLINE");
					$data['archanai_details'] = array_merge($archanai_data_online,$archanai_data_direct); */
		$data['archanai_details'] = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['archanai_group_details'] = daily_group_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['hallbooking_details'] = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['prasadam_details'] = $prasadam_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$payment_voucher_data = daily_payment_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date);
		$data['payment_voucher_details'] = $payment_voucher_data;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		echo view('daily_closing/print_page', $data);
	}
}
