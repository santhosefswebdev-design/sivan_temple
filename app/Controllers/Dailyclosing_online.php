<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Dailyclosing_online extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
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
		$login_id = $_SESSION['log_id_frend'];
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$archanai_group_data_online = daily_group_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_group_details'] = $archanai_group_data_online;

		// $archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
		// $archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "", $login_id);
	
		// $data['archanai_details'] = $archanai_data_online;
		// $data['archanai_diety_details'] = $archanai_diety_data_online;

		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['donation_details'] = $donation_data;
		$payment_voucher_data = daily_payment_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['payment_voucher_details'] = $payment_voucher_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['repayment_details'] = $repayment_data;
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;

		// var_dump($data['product_offering_details']);
		// exit;
		echo view('frontend/layout/header');
		echo view('frontend/daily_closing/index', $data);
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
		$login_id = $_SESSION['log_id_frend'];
		$counter_user = $this->db->table('login')->where('id', $login_id)->get()->getRowArray();

		$data['counter_user'] = $counter_user; // Pass counter login details to view
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$archanai_group_data_online = daily_group_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_group_details'] = $archanai_group_data_online;
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['donation_details'] = $donation_data;
		$payment_voucher_data = daily_payment_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['payment_voucher_details'] = $payment_voucher_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['repayment_details'] = $repayment_data;
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		echo view('frontend/daily_closing/print_page', $data);
	}


	public function print_a4($fromdate, $todate)
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
		$login_id = $_SESSION['log_id_frend'];
		$counter_user = $this->db->table('login')->where('id', $login_id)->get()->getRowArray();

		$data['counter_user'] = $counter_user; // Pass counter login details to view
		$archanai_data_online = daily_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_details'] = $archanai_data_online;
		$archanai_group_data_online = daily_group_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_group_details'] = $archanai_group_data_online;
		/* $archanai_diety_data_online = daily_diety_archanai_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['archanai_diety_details'] = $archanai_diety_data_online; */
		$hallbooking_data_online = daily_hall_booking_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['hallbooking_details'] = $hallbooking_data_online;
		$ubayam_data = daily_ubayam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['ubayam_details'] = $ubayam_data;
		$donation_data = daily_donation_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['donation_details'] = $donation_data;
		$prasadam_data = daily_prasadam_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['prasadam_details'] = $prasadam_data;
		$product_offering_data = daily_product_offering_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['product_offering_details'] = $product_offering_data;
		$payment_voucher_data = daily_payment_voucher_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['payment_voucher_details'] = $payment_voucher_data;
		$repayment_data = daily_repayment_data_withcurrentdate($dailyclosing_start_date, $dailyclosing_end_date, $booking_type = "COUNTER", $login_id);
		$data['repayment_details'] = $repayment_data;
		$data['floating_cash'] = $this->db->query("SELECT sum(amount) as amount, checked_by FROM `floating_cash` WHERE date >= '$dailyclosing_start_date' AND date <= '$dailyclosing_end_date' GROUP BY checked_by")->getRowArray();
		$data['dailyclosing_start_date'] = $dailyclosing_start_date;
		$data['dailyclosing_end_date'] = $dailyclosing_end_date;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		echo view('frontend/daily_closing/print_a4', $data);
	}
	public function saveFloatingCash()
	{
		// Get POST data
		$floating_cash = $this->request->getPost('floating_cash');
		$checked_by = $this->request->getPost('checked_by');

		// Get today's date
		$today_date = date('Y-m-d');

		// Prepare the data for insertion
		$floating_data = [
			'date' => $today_date,
			'amount' => $floating_cash,
			'checked_by' => $checked_by,
			'created_at' => date('Y-m-d H:i:s'),
			'modified_at' => date('Y-m-d H:i:s')
		];

		// Delete any existing record for today's date
		$this->db->table('floating_cash')
			->where('date', $today_date)
			->delete();

		// Insert the new record
		if ($this->db->table('floating_cash')->insert($floating_data)) {
			// Send success response
			return $this->response->setJSON(['status' => 'success', 'message' => 'Floating Cash saved successfully']);
		} else {
			// Send error response
			return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save Floating Cash']);
		}
	}

}
