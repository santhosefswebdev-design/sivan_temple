<?php
namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Report_online extends BaseController
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

	public function log()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['list'] = $this->db->table('log_paymode_change as lpc')
			->select('lpc.*,')
			->where('lpc.date >=', $from_date)
			->where('lpc.date <=', $to_date)
			->orderBy('lpc.id', 'desc')
			->get()
			->getResultArray();

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		echo view('frontend/layout/header');
		echo view('frontend/report/log', $data);
	}

	public function archanai_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		echo view('frontend/layout/header');
		echo view('frontend/report/archanai_report', $data);
	}

	public function archanai_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));

		$data = [];
		$dat = $this->db->table('archanai_booking as ab')
			->join('archanai_payment_gateway_datas as apgd', 'apgd.archanai_booking_id = ab.id')
			->select('ab.*, apgd.pay_method')
			->where('DATE_FORMAT(ab.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(ab.date, "%Y-%m-%d") <=', $tdt);

		$dat = $dat->orderBy('ab.id', 'desc');
		$dat = $dat->get()->getResultArray();
		$print = "";

		$i = 1;
		foreach ($dat as $row) {

			//$action = '<a class="btn btn-warning btn-payment btn-rad" title="Pay" href=" ' .base_url(). '/annathanam_new/payment/' . $aname['id']. '" target="_blank"><i class="fa fa-credit-card"></i> </a>';

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'],
				$row['amount'],
				$row['pay_method'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/archanai_booking/print_booking/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>     <a class="btn btn-warning btn-payment btn-rad" title="Payment Mode" href=" ' .base_url(). '/annathanam_new/payment/' . $row['id']. '" target="_blank"><i class="fa fa-credit-card"></i> </a>',

			);
		}
	
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function get_archanai_payment_mode()
    {
      	$id = $_POST['id'];
      	$res = $this->db->table("archanai_booking")->where("id", $id)->get()->getRowArray();
      	$data['amt'] = $res['amount'];
		$data['ref_no'] = $res['ref_no'];

      	$res1 = $this->db->table("archanai_payment_gateway_datas")->select('pay_method')->where("archanai_booking_id", $id)->get()->getRowArray();
      	$data['pay_method'] = $pay_method = $res1['pay_method'];
	  	$query = "SELECT id FROM payment_mode WHERE LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = LOWER(REPLACE(REPLACE(REPLACE(?, ' ', ''), '_', ''), '-', '')) AND paid_through = 'COUNTER' ";
		$result = $this->db->query($query, [$pay_method])->getRowArray();
		$data['payment_mode'] = $result['id'];

      echo json_encode($data);
    }

	public function save_archanai_payment_mode()
	{
		$date = $_POST['date'];
		$oldPayModeId = $_POST['old_paymode'];
		$oldPayMethod = $_POST['old_paymethod'];
		$newPayModeId = $_POST['payment_mode'];
		$bookingId = $_POST['booking_id'];
		$amount = $_POST['amount'];

		$payMode = $this->db->table('payment_mode')->select('name')->where('id', $newPayModeId)->get()->getRowArray();

		if (empty($payMode) || !isset($payMode['name'])) {
			echo json_encode(['status' => false, 'message' => 'Invalid new payment mode selected.']);
			return;
		}

		if ($payMode['name'] == "Cash") {
			$newPayMethodName = "cash";
		} elseif ($payMode['name'] == "Online") {
			$newPayMethodName = "online";
		} elseif ($payMode['name'] == "Nets Pay") {
			$newPayMethodName = "nets_pay";
		} elseif ($payMode['name'] == "Pay Now") {
			$newPayMethodName = "pay_now";
		} elseif ($payMode['name'] == "Cheque") {
			$newPayMethodName = "cheque";
		}

		$updatePaymentMethod = $this->db->table("archanai_payment_gateway_datas")->where('archanai_booking_id', $bookingId)->update(['pay_method' => $newPayMethodName]);

		$entry = $this->db->table("entries")->select('id')->where('type', 3)->where('inv_id', $bookingId)->get()->getRowArray();
		$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('dc', 'D')->update(['ledger_id' => $newPayModeId]);

		$logData = [
			'type' => 1,
			'date' => date('Y-m-d'),
			'amount' => $amount,
			'old_pay_id' => $oldPayModeId,
			'old_pay_method' => $oldPayMethod,
			'new_pay_id' => $newPayModeId,
			'new_pay_method' => $newPayMethodName,
			'booking_id' => $bookingId,
			'entryitems_id' => $entryItem['id']
		];

		$logEntry = $this->db->table("log_paymode_change")->insert($logData);

		if ($logEntry) {
			echo json_encode(['status' => true, 'message' => 'Payment Mode Changed successfully.']);
		} else {
			echo json_encode(['status' => false, 'message' => 'Failed to log payment mode change.']);
		}
	}

	public function print_archanai_report()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];

		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_archanaireport'] == "PDF") {
			
			$file_name = "Archanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/archanai_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_archanaireport'] == "EXCEL") {
			$fileName = "Archanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Invoice No');
			$sheet->setCellValue('D2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_archanai_report($data['fdate'], $data['tdate']);
			// var_dump($excel_format_data);
			// exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/archanai_print', $data);
		}
	}

	public function excel_format_get_archanai_report($fdata, $tdata)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));

		$data = [];
		$dat = $this->db->table('archanai_booking')
			->select('archanai_booking.*')
			->where('DATE_FORMAT(archanai_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(archanai_booking.date, "%Y-%m-%d") <=', $tdt);

		$dat = $dat->orderBy('archanai_booking.date', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'],
				"amount" => $row['amount']
			);
		}
		return $data;
	}	

	public function hall_booking_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('templebooking as tb')
				->select('tb.id, tb.entry_date, tb.booking_date, tb.name, tb.amount, tb.paid_amount, tb.payment_type, bp.name as package_name,tb.booking_status')
				->join('booked_packages as bp', 'bp.booking_id = tb.id')
				->where('tb.booking_type', 1)
				->where('tb.entry_date >=', $from_date)
				->where('tb.entry_date <=', $to_date)
				->orderBy('tb.entry_date', 'DESC');

		if (!empty($cdt)) {
			$builder->where('tb.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			$builder->where('tb.payment_type', $group_filter);
		}
		
		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['cdt'] = $cdt;
		$data['group_filter'] = $group_filter;
		// var_dump($data);
		// exit;
		echo view('frontend/layout/header');
		echo view('frontend/report/hall_booking_report', $data);
	}

	public function ubayam_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('templebooking as tb')
				->select('tb.id, tb.entry_date, tb.booking_date, tb.name, tb.amount, tb.paid_amount, tb.payment_type, bp.name as package_name')
				->join('booked_packages as bp', 'bp.booking_id = tb.id')
				->where('tb.booking_type', 2)
				->where('tb.entry_date >=', $from_date)
				->where('tb.entry_date <=', $to_date)
				->orderBy('tb.entry_date', 'DESC');

		if (!empty($cdt)) {
			$builder->where('tb.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != 0) {
			$builder->where('tb.payment_type', $group_filter);
		}
		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['fdt'] = $from_date;
		$data['tdt'] = $to_date;
		$data['cdt'] = $cdt;
		// var_dump($data);
		// exit;
		echo view('frontend/layout/header');
		echo view('frontend/report/ubayam_report', $data);
	}

	public function kattalai_archanai_report()
	{
		if (!empty($_POST['fdt'])) $from_date = $_POST['fdt'];
		else $from_date = date('Y-m-01');

		if (!empty($_POST['tdt'])) $to_date = $_POST['tdt'];
		else $to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
            //->join('booked_packages as bp', 'bp.booking_id = kab.id')
            ->where('kab.date >=', $from_date)
            ->where('kab.date <=', $to_date);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		
		$builder->orderBy('kab.date', 'DESC');

		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_archanai_report', $data);
	}

	public function donation_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['list'] = $this->db->table('donation')
			->select('donation.*, donation_category.name as type_name')
			->join('donation_category', 'donation_category.id = donation.pay_for', 'left')
			->orderBy('donation.id', 'desc')
			->where('donation.date >=', $from_date)
			->where('donation.date <=', $to_date)
			->get()
			->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['dons_set'] = $this->db->table('donation_setting')->get()->getResultArray();
		$data['dons_name'] = $this->db->table('donation')->groupby('name')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/donation_report', $data);
	}

	public function cash_don_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$payfor = $_POST['payfor'];
		$fltername = $_POST['fltername'];
		$data = [];
		$dat = $this->db->table('donation', 'donation_setting.name as pname')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->join('donation_payment_gateway_datas as dpgd', 'dpgd.donation_booking_id = donation.id')
			->select('donation_setting.name as pname, dpgd.pay_method')
			->select('donation.*')
			->where('donation.date>=', $fdt);
		$dat = $dat->where('donation.date<=', $tdt);
		if ($payfor) {
			$dat = $dat->where('donation_setting.id', $payfor);
		}
		if ($fltername) {
			$dat = $dat->where('donation.name', $fltername);
		}
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {


			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['pname'],
				$row['name'],
				number_format($row['amount'], '2', '.', ','),
				$row['pay_method'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/donation_online/print_report/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  
				<a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/donation_online/print_booking/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>   
				<a class="btn btn-warning btn-payment btn-rad" title="Payment Mode" href=" ' .base_url(). '/annathanam_new/payment/' . $row['id']. '" target="_blank"><i class="fa fa-credit-card"></i> </a>',
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function get_donation_payment_mode()
    {
      	$id = $_POST['id'];

      	$res1 = $this->db->table("donation_payment_gateway_datas")->select('pay_method')->where("donation_booking_id", $id)->get()->getRowArray();
      	$data['pay_method'] = $pay_method = $res1['pay_method'];
	  	$query = "SELECT id FROM payment_mode WHERE LOWER(REPLACE(REPLACE(REPLACE(name, ' ', ''), '_', ''), '-', '')) = LOWER(REPLACE(REPLACE(REPLACE(?, ' ', ''), '_', ''), '-', '')) AND paid_through = 'COUNTER' ";
		$result = $this->db->query($query, [$pay_method])->getRowArray();
		$data['payment_mode'] = $result['id'];

      echo json_encode($data);
    }

	public function save_donation_payment_mode()
	{
		$date = $_POST['date'];
		$oldPayModeId = $_POST['old_paymode'];
		$oldPayMethod = $_POST['old_paymethod'];
		$newPayModeId = $_POST['payment_mode'];
		$bookingId = $_POST['booking_id'];

		$payMode = $this->db->table('payment_mode')->select('name')->where('id', $newPayModeId)->get()->getRowArray();

		if (empty($payMode) || !isset($payMode['name'])) {
			echo json_encode(['status' => false, 'message' => 'Invalid new payment mode selected.']);
			return;
		}

		if ($payMode['name'] == "Cash") {
			$newPayMethodName = "cash";
		} elseif ($payMode['name'] == "Online") {
			$newPayMethodName = "online";
		} elseif ($payMode['name'] == "Nets Pay") {
			$newPayMethodName = "nets_pay";
		} elseif ($payMode['name'] == "Pay Now") {
			$newPayMethodName = "pay_now";
		} elseif ($payMode['name'] == "Cheque") {
			$newPayMethodName = "cheque";
		}
		
		$updatePaymentMethod = $this->db->table("donation_payment_gateway_datas")->where('donation_booking_id', $bookingId)->update(['pay_method' => $newPayMethodName]);

		$entry = $this->db->table("entries")->select('id')->where('type', 2)->where('inv_id', $bookingId)->get()->getRowArray();
		$entryItem = $this->db->table("entryitems")->where('entry_id', $entry['id'])->where('dc', 'D')->update(['ledger_id' => $newPayModeId]);

		$logData = [
			'type' => 2,
			'date' => date('Y-m-d'),
			'old_pay_id' => $oldPayModeId,
			'new_pay_id' => $newPayModeId,
			'booking_id' => $bookingId,
			'entryitems_id' => $entry['id']
		];

		$logEntry = $this->db->table("log_paymode_change")->insert($logData);

		if ($logEntry) {
			echo json_encode(['status' => true, 'message' => 'Payment Mode Changed successfully.']);
		} else {
			echo json_encode(['status' => false, 'message' => 'Failed to log payment mode change.']);
		}
	}

	public function print_cashreport()
	{
		
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['payfor'] = $_REQUEST['payfor'];
		$data['fltername'] = $_REQUEST['fltername'];
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if (isset($_REQUEST['pdf_cashdonationreport']) == "PDF") {
			$file_name = "Cash_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/cashdonation_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif (isset($_REQUEST['excel_cashdonationreport']) == "EXCEL") {
			$fileName = "Cash_Donation_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:E1")->applyFromArray($style);
			$sheet->mergeCells('A1:E1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);

			if ($_REQUEST['payfor']) {
				$res_don_set = $this->db->table('donation_setting ds')->join('donation d', 'ds.id = d.pay_for', 'left')->select('max(ds.amount) as total_amount')->select('COALESCE(sum(d.amount), 0) as collected_amount')->where(['ds.id' => $_REQUEST['payfor']])->get()->getRowArray();
				$balance_amount = $res_don_set['total_amount'] - $res_don_set['collected_amount'];
				if ($balance_amount >= 0) {
					$re_balance_amount = $balance_amount;
				} else {
					$re_balance_amount = 0;
				}
				$sheet->setCellValue('A2', '');
				$sheet->setCellValue('B2', 'Target Amount : ' . $res_don_set['total_amount']);
				$sheet->setCellValue('C2', 'Collected Amount : ' . $res_don_set['collected_amount']);
				$sheet->setCellValue('D2', 'Balance Amount : ' . $re_balance_amount);
				$sheet->setCellValue('E2', '');
			}
			$sheet->setCellValue('A3', 'S.No');
			$sheet->setCellValue('B3', 'Date');
			$sheet->setCellValue('C3', 'Pay for');
			$sheet->setCellValue('D3', 'Name');
			$sheet->setCellValue('E3', 'Amount');
			$rows = 4;
			$si = 1;
			$totalAmount = 0;
			$excel_format_data = $this->excel_format_get_cashdonationreport($data['fdate'], $data['tdate'], $data['payfor'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			$sheet->getStyle('E4:E' . (count($excel_format_data) + 4))
				->getNumberFormat()
				->setFormatCode('#,##0.00');

			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['pname']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['amount']);
				$totalAmount += $val['amount'];
				$rows++;
				$si++;
			}
			$sheet->setCellValue('D' . $rows, 'Total');
			$sheet->setCellValue('E' . $rows, $totalAmount);

			$sheet->getStyle('E' . $rows)
				->getNumberFormat()
				->setFormatCode('#,##0.00');
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/cashdonation_print', $data);
		}
	}

	public function excel_format_get_cashdonationreport($fdata, $tdata, $payfor, $name)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$payforg = $payfor;
		$nameg = $name;
		$data = [];
		$dat = $this->db->table('donation', 'donation_setting.name as pname')
			->join('donation_setting', 'donation_setting.id = donation.pay_for')
			->select('donation_setting.name as pname')
			->select('donation.*')
			->where('donation.date>=', $fdt);
		$dat = $dat->where('donation.date<=', $tdt);
		if ($payforg) {
			$dat = $dat->where('donation_setting.id', $payforg);
		}
		if ($nameg) {
			$dat = $dat->where('donation.name', $nameg);
		}
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount']
			);
		}
		return $data;
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

	public function annathanam_rep_ref()	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$group_filter = $_POST['group_filter'];
		$data = [];
		$qry = $this->db->table('annathanam_new')
			->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil')
			->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
			->orderBy('annathanam_new.id', 'desc')
			->where('annathanam_new.for_ubayam', 0)
			->where('annathanam_new.date >=', $fdt)
			->get()->getResultArray();

		$print = "";

		$i = 1;
		foreach ($qry as $row) {
			$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			}	else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if($row['payment_status'] == 1 && $row['booking_status'] == 1) {
				$print = '<a class="btn btn-primary btn-rad" href="'.base_url().'/annathanam_counter/print_annathanam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-warning btn-payment btn-rad" title="Pay" data-id="'. $row['id'].'"><i class="fa fa-credit-card"></i></a>';
			}	else if($row['payment_status'] == 2 || $row['booking_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-primary btn-rad" href="'.base_url().'/annathanam_counter/print_annathanam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			if($row['booking_status'] != 3) {
				$action = '<a class="btn btn-danger btn-cancel btn-rad" title="Cancel" data-id="'. $row['id'].'"><i class="fa fa-times"></i> </a>';
			} else {
				$action = "";
			}

			// $print = '<a class="btn btn-primary btn-rad" href="'.base_url().'/annathanam_counter/print_annathanam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>
			// <a class="btn btn-danger btn-cancel btn-rad" title="Cancel" data-id="'. $row['id'].'"><i class="fa fa-times"></i> </a>';
			// if($bal_amt && $row['payment_type'] == "partial") {
			//     $print = '<a class="btn btn-warning btn-payment btn-rad" title="Pay" data-id="'. $row['id'].'"><i class="fa fa-credit-card"></i></a>';
			// }   
			
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['ref_no'],
				$row['name'],
				$row['name_eng'].'/'.$row['name_tamil'],
				$txt,
				$row['total_amount'],
				$row['paid_amount'],
				$print,
				$action

			);
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}
	
	public function print_annathanam_report()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['group_filter'] = $_REQUEST['group_filter'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_annathanamreport'] == "PDF") {
			$file_name = "Annathanam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/annathanam_print', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_annathanamreport'] == "EXCEL") {
			$fileName = "Annathanam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Invoice No');
			$sheet->setCellValue('D2', 'Name');
			$sheet->setCellValue('E2', 'Package');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('G2', 'No of Pax');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_annathanam_report ($data['fdate'], $data['tdate'], $data['group_filter']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['ref_no']);
				$sheet->setCellValue('D' . $rows, $val['name']);
				$sheet->setCellValue('E' . $rows, $val['package']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('G' . $rows, $val['no_pax']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/annathanam_print', $data);
		}
	}

	public function excel_format_get_annathanam_report($fdata, $tdata, $group_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
	
		$data = [];
		
		$dat = $this->db->table('annathanam_new')
			->select('annathanam_new.*, annathanam_packages.name_eng, annathanam_packages.name_tamil')
			->join('annathanam_packages', 'annathanam_packages.id = annathanam_new.package_id', 'left')
			->orderBy('annathanam_new.id', 'desc')
			->where('annathanam_new.date >=', $fdt)
			->where('annathanam_new.date <=', $tdt)
			->where('annathanam_new.booking_status !=', 3);

			if (!empty($group_filter) && $group_filter != "0") {
				$dat = $dat->where('annathanam_new.payment_type', $group_filter);
			}

			$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"ref_no" => $row['ref_no'],
				"name" => $row['name'],
				"package" => $row['name_eng'].'/'.$row['name_tamil'],
				"amount" => $row['total_amount'],
				// "no_pax" => $row['no_of_pax']
			);
		}
		return $data;
	}

	public function prasadam_report() {

		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');
		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$group_filter = $_POST['group_filter'];
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;

		$builder = $this->db->table('prasadam')->orderBy('id', 'desc');
		$builder->where('date >=', $from_date);
		$builder->where('date <=', $to_date);
		if(!empty($cdt)){
		$builder->where('collection_date =', $cdt);
		}
		$builder->where('payment_status !=', 3);
		if (!empty($group_filter) && $group_filter != 0) {
			$builder->where('prasadam_group_id', $group_filter);
		}
		$data['list'] = $builder->get()->getResultArray();

		foreach ($data['list'] as &$row) {
			$prasadam_details = $this->db->table('prasadam_booking_details')
				->where('prasadam_booking_id', $row['id'])
				->get()
				->getResultArray();
	
			$prasadam_list = [];
			foreach ($prasadam_details as $detail) {
				$prasadam_info = $this->db->table('prasadam_setting')
					->select('name_eng, name_tamil')
					->where('id', $detail['prasadam_id'])
					->get()
					->getRowArray();
	
				$prasadam_list[] = $prasadam_info['name_eng'] . ' / ' . $prasadam_info['name_tamil'] . ' - ' . $detail['quantity'];
			}
			$row['prasadam_str'] = implode('<br><br>', $prasadam_list);
		}
		echo json_encode($data);
		exit();
	}

	public function prasadam_rep_view()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');
		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$data['fltr_name'] = $this->db->table('prasadam')->select('customer_name')->groupBy('customer_name')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();

		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;

		echo view('frontend/layout/header');
		echo view('frontend/report/prasadam_report', $data);
	}

	public function prasadam_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$group_filter = $_POST['group_filter'];
		$data = [];
		$dat = $this->db->table('prasadam p')
			->select('p.`id`, `p`.`date`, p.`customer_name`, p.`amount`, p.`payment_status`, p.payment_type, p.paid_amount')
			// ->join('prasadam_booking_details pbd', 'p.id = pbd.prasadam_booking_id', 'left')
			// ->join('prasadam_setting ps', 'ps.id = pbd.prasadam_id', 'left')
			// ->join('prasadam_setting_group psp', 'psp.prasadam_id = ps.id', 'left')
			->where('DATE_FORMAT(p.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(p.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($group_filter) && $group_filter != '0') {
			$dat = $dat->where('p.payment_type', $group_filter);
		}

		$dat = $dat->orderBy('p.id', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')->select('prasadam_setting.name_eng,prasadam_setting.name_tamil')->where('prasadam_booking_details.prasadam_booking_id', $row['id'])->get()->getResultArray();
			$html = "";
			foreach ($payfors as $payfor) {
				$html .= "&#x2022; " . $payfor['name_eng'] . " / " . $payfor['name_tamil'] . "<br>";
			}

			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			}	else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if($row['payment_status'] == 1) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/prasadam_online/print_booking_report/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/prasadam_online/print_booking/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
				if($balance_amount > 0) $print .= '<a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-credit-card"></i></a>';
			}	else if($row['payment_status'] == 2) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/prasadam_online/print_booking_report/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/prasadam_online/print_booking/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				$row['customer_name'],
				"<p style='text-align: left;'>" . $html . "</p>",
				// $row['payment_type'],
				$txt,
				number_format($row['amount'], '2', '.', ','),
				number_format($row['paid_amount'], '2', '.', ','),
				$print
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_prasadamreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		// $data['cdate'] = $_REQUEST['cdt'];
		$data['fltername'] = $_REQUEST['group_filter'];
		//$data['collection_date'] = isset($_REQUEST['cdt']) && !empty($_REQUEST['cdt']) ? date('Y-m-d', strtotime($_REQUEST['cdt'])) : null;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_prasadamreport'] == "PDF") {
			$file_name = "Prasadam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/prasadam_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_prasadamreport'] == "EXCEL") {
			$fileName = "Prasadam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Customer Name');
			// $sheet->setCellValue('D2', 'Collection Date');
			$sheet->setCellValue('D2', 'Payfor');
			$sheet->setCellValue('E2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_prasadamreport($data['fdate'], $data['tdate'], $data['collection_date'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['customer_name']);
				// $sheet->setCellValue('D' . $rows, $val['collection_date']);
				$sheet->setCellValue('D' . $rows, $val['collection_name']);
				$sheet->setCellValue('E' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/prasadam_print', $data);
		}
	}
	public function excel_format_get_prasadamreport($fdata, $tdata, $collectiondate, $fltername)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		// $collection_date = !empty($collection_date) ? date('Y-m-d', strtotime($collection_date)) : null;
		$flternameg = $fltername;
		$data = [];
		$dat = $this->db->table('prasadam p')
			->select('p.`id`, `p`.`date`, p.`customer_name`, pg.group_name, p.`amount`')
			->join('prasadam_booking_details pbd', 'p.id = pbd.prasadam_booking_id', 'left')
			->join('prasadam_setting ps', 'ps.id = pbd.prasadam_id', 'left')
			->join('prasadam_setting_group psp', 'psp.prasadam_id = ps.id', 'left')
			->join('prasadam_group pg', 'pg.id = psp.prasadam_group_id', 'left')
			->where('DATE_FORMAT(p.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(p.date, "%Y-%m-%d") <=', $tdt);
		// if(!empty($collection_date)){
		// 	$dat = $dat->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")=',$collection_date);
		// }
		if ($flternameg) {
			// $dat = $dat->where('prasadam.customer_name', $fltername);
			$dat = $dat->where('psp.prasadam_group_id', $flternameg);
		}
		$dat = $dat->orderBy('p.date', 'asc');
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')->select('prasadam_setting.name_eng,prasadam_setting.name_tamil')->where('prasadam_booking_details.prasadam_booking_id', $row['id'])->get()->getResultArray();
			$html = "";
			foreach($payfors as $payfor)
			{
				$html.=  $payfor['name_eng']." / ".$payfor['name_tamil']. ' - '. $payfor['quantity'] . '&';
			}
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"customer_name" => $row['customer_name'],
				"amount" => $row['amount'],
				"collection_date" => date('d-m-Y', strtotime($row['collection_date'])),
				"collection_name" => $html
			);
		}
		return $data;
	}

	public function offering_report_new()
	{
		$fdt = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$tdt = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
		$type = $_POST['type'];
		$ptype = $_POST['ptype'];

		$builder = $this->db->table('product_offering po')
			->select('po.id, po.date, po.name, po.phone, po.ref_no, pod.offering_id, pod.product_id')
			->join('product_offering_detail pod', 'po.id = pod.pro_off_id', 'left')
			->orderBy('po.id', 'desc')
			->where('po.date >=', $fdt)
			->where('po.date <=', $tdt);
		
		if (!empty($type)) {
			$builder->where('pod.offering_id =', $type);
		}
		if (!empty($ptype)) {
			$builder->where('pod.product_id', $ptype);
		}
	
		$data['list'] = $builder->get()->getResultArray();

		$data['list'] = $this->db->table('product_offering')->get()->getResultArray();
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/offering_report', $data);
	}
	
	public function offering_report()
	{
		$data['list'] = $this->db->table('product_offering')->get()->getResultArray();
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/offering_report', $data);
	}
	
	public function offering_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$type = $_POST['type'];
		$ptype = $_POST['ptype'];
		$data = [];
		//$qry = $this->db->query("select * from `product_offering` where date >= '$fdt' and date <= '$tdt'")->getResultArray();
		$qry = $this->db->query("SELECT 
											product_offering.*, product_offering.id as main_id,
											product_offering_detail.*,
											product_category.name as product_name,  
											offering_category.name as category_name
										FROM 
											`product_offering`
										INNER JOIN 
											product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
										INNER JOIN 
											product_category ON product_offering_detail.product_id = product_category.id
										INNER JOIN 
											offering_category ON product_offering_detail.offering_id = offering_category.id
										ORDER BY 
											product_offering.id DESC")->getResultArray();
		
		if(!empty($type)) {
		    // $qry = $this->db->query("select * from `product_offering` inner join product_offering_detail on product_offering_detail.pro_off_id = product_offering.id inner join product_category on product_offering_detail.product_id = product_category.id where product_offering_detail.offering_id = $type")->getResultArray();
			$qry = $this->db->query("SELECT 
											product_offering.*, product_offering.id as main_id,
											product_offering_detail.*,
											product_category.name as product_name,  
											offering_category.name as category_name
										FROM 
											`product_offering`
										INNER JOIN 
											product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
										INNER JOIN 
											product_category ON product_offering_detail.product_id = product_category.id
										INNER JOIN 
											offering_category ON product_offering_detail.offering_id = offering_category.id
										WHERE 
											product_offering_detail.offering_id = ?
										ORDER BY 
											product_offering.id DESC", [$type])->getResultArray();
											
		}
		if(!empty($type)&&!empty($ptype)) {
		    //$qry = $this->db->query("select * from `product_offering` inner join product_offering_detail on product_offering_detail.pro_off_id = product_offering.id inner join product_category on product_offering_detail.product_id = product_category.id where product_offering_detail.offering_id = $type and product_offering_detail.product_id = $ptype")->getResultArray();
			$qry = $this->db->query("SELECT 
										product_offering.*, product_offering.id as main_id,
										product_offering_detail.*,
										product_category.name AS product_name,  
										offering_category.name AS category_name
									FROM 
										`product_offering`
									INNER JOIN 
										product_offering_detail ON product_offering_detail.pro_off_id = product_offering.id
									INNER JOIN 
										product_category ON product_offering_detail.product_id = product_category.id
									INNER JOIN 
										offering_category ON product_offering_detail.offering_id = offering_category.id
									WHERE 
										product_offering_detail.offering_id = ? AND product_offering_detail.product_id = ?
									ORDER BY 
										product_offering.id DESC", [$type, $ptype])->getResultArray();
		}
		
		//$qry = $this->db->table('product_offering')->select('*')->where('created' >= '$fdt')->orderBy('id', 'desc')->get()->getResultArray();
		$totalGramsByCategory = [];
		$i = 1;
		foreach ($qry as $row) {

			// if($row['booking_type'] == 1) {
			// 	$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/hallbooking_online/print_page_new/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			// 	$action = '<a class="btn btn-primary btn-rad" title="Edit" href="'.base_url().'/report/show_loan_history/'.$r['staff_id'].'"><i class="material-icons">&#xE417;</i></a>';
			// }	else if($row['booking_type'] == 2) {
	
			// 	$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			// } else {
			// 	$print = "";
			// }

			
			
			$data[] = array(
				$i++,
				'<p style="text-align:left;">' . $row['name'] . '</p>',
				$row['phone'],
				$row['category_name'],
				$row['product_name'],
				$row['grams'],
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/offering_online/print_offering/'. $row['main_id'].'" target="_blank"><i class="fa fa-print"></i> </a>'
				//$print
			);
			if (isset($totalGramsByCategory[$row['category_name']])) {
				$totalGramsByCategory[$row['category_name']] += $row['grams'];
			} else {
				$totalGramsByCategory[$row['category_name']] = $row['grams'];
			}
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
			"totals" => $totalGramsByCategory
		);
		echo json_encode($result);
		exit();
	}
	public function ubayam_rep_ref_temple()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];
		$booking_type = $_POST['booking_type'];

		$data = [];
		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('templebooking.booking_type', $booking_type)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			$dat = $dat->where('templebooking.payment_type', $group_filter);
		}

		$dat = $dat->orderBy('templebooking.id', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			//$paid_amount = (float) $row['paid_amount'] + (float) $row['deposit_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			}	elseif ($row['payment_type'] == 'only_booking' && $row['payment_status'] == 0){
				$txt = '<span class="cancel_text">Only Booked</span>';
			}	else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if($row['payment_status'] == 1 && $row['booking_status'] == 1) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam_imin/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-credit-card"></i></a> ';
			} else if($row['payment_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam_imin/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			} else if($row['payment_type'] == 'only_booking' && $row['payment_status'] != 2) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam_imin/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-credit-card"></i></a> ';
			} else {
				$print = "";
			}

			if($row['booking_status'] != 3) {
				$action = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Print" href="'.base_url().'/hallbooking_online/print_page_hall/'. $row['id'].'" target="_blank"><i class="fa fa-times"></i> </a>';
			} else {
				$action = "";
			}
			

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['pname'],
				$row['name'],
				$row['amount'],
				$row['paid_amount'],
				$txt,
				$print,
				$action

			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function hall_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];
		$booking_type = $_POST['booking_type'];

		$data = [];
		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->join('booked_deposit_details', 'booked_deposit_details.booking_id = templebooking.id', 'left')
			->select('booked_packages.name as pname, booked_deposit_details.amount as deposit_amount, booked_deposit_details.deposit_status')
			->select('templebooking.*')
			->where('templebooking.booking_type', 1)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);
		
		if (!empty($cdt)) {
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}
		if (!empty($group_filter) && $group_filter != "0") {
			$dat = $dat->where('templebooking.payment_type', $group_filter);
		}
		$dat = $dat->orderBy('templebooking.id', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$paidFull = ($row['total_amount'] == $row['paid_amount']);
			$balance_amount = (float) $row['total_amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			}	
			else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if($row['payment_status'] == 1 && $row['booking_status'] == 1) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/hallbooking_online/print_page_hall/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_hall_imin/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-credit-card"></i></a>';
			} else if($row['payment_status'] == 2 || $row['booking_status'] == 2 || $row['booking_status'] == 3) {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/hallbooking_online/print_page_hall/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a> <a class="btn btn-success btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_hall_imin/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			if($row['booking_status'] != 3) {
				$action1 = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Print" href="'.base_url().'/hallbooking_online/print_page_hall/'. $row['id'].'" target="_blank"><i class="fa fa-times"></i> </a>';
			} else {
				$action1 = "";
			}

			if($row['payment_status'] == 2 && $row['booking_status'] == 2 && $row['deposit_status'] == 1) {
				$action2 = '<a class="btn btn-primary btn-rad btn-success btn-deprepay" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-redo">Repay</i></a>';
			} else {
				$action2 = "";
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['pname'],
				$row['name'],
				$row['total_amount'],
				$row['paid_amount'],
				$txt,
				$print,
				'<p>' . $action1 . '' . $action2 .'</p>'
				//$action1

			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function hall_event_status() {
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$data = [];
		$dat = $this->db->table('templebooking')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->join('booked_deposit_details', 'booked_deposit_details.booking_id = templebooking.id', 'left')
			->select('booked_packages.name as pname, booked_deposit_details.amount as deposit_amount, booked_deposit_details.deposit_status, templebooking.*')
			->where('templebooking.booking_type', 1)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt)
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt)
			->orderBy('templebooking.id', 'desc')
			->get()->getResultArray();
	
		$i = 1;
		foreach ($dat as $row) {
			$currentDate = date('Y-m-d');
			$bookingDate = date('Y-m-d', strtotime($row['booking_date']));
			$paidFull = ($row['total_amount'] == $row['paid_amount']);
			$isPastBooking = ($bookingDate < $currentDate);
			$iscompleted = ($row['booking_status'] == 2);
	
			$data[] = [
				'S.No' => $i++,
				'id' => $row['id'],
				'Booking Date' => date('d-m-Y', strtotime($row['entry_date'])),
				'Event Date' => date('d-m-Y', strtotime($row['booking_date'])),
				'Package Name' => $row['pname'],
				'Name' => $row['name'],
				'Payment Status' => $paidFull ? '<span class="paid_text">Paid</span>' : '<span class="unpaid_text">Partially Paid</span>',
				'isPastBooking' => $isPastBooking,
				'paidFull' => $paidFull,
				'iscompleted' => $iscompleted
			];
		}
	
		echo json_encode($data);
		exit();
	}
	

	// public function hall_event_status()
	// {
	// 	$fdt = date('Y-m-d', strtotime($_POST['fdt']));
	// 	$tdt = date('Y-m-d', strtotime($_POST['tdt']));

	// 	$data = [];
	// 	$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
	// 		->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
	// 		->join('booked_deposit_details', 'booked_deposit_details.booking_id = templebooking.id')
	// 		->select('booked_packages.name as pname, booked_deposit_details.amount as deposit_amount')
	// 		->select('templebooking.*')
	// 		->where('templebooking.booking_type', 1)
	// 		->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
	// 	$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);

	// 	$dat = $dat->orderBy('templebooking.booking_date', 'desc');
	// 	$dat = $dat->get()->getResultArray();

	// 	$i = 1;
	// 	foreach ($dat as $row) {
	// 		$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
	// 		if ($balance_amount < 0)
	// 			$balance_amount = 0;

	// 		if($row['booking_status'] == 3) {
	// 			$txt = '<span class="cancel_text">Cancelled</span>';
	// 		}	else {

	// 			if (empty($balance_amount)) {
	// 				$txt = '<span class="paid_text">Paid</span>';
	// 			} else {
	// 				$txt = '<span class="unpaid_text">Partially Paid</span>';
	// 			}
	// 		}

	// 		if($row['payment_status'] == 1 && $row['booking_status'] == 1) {
	// 			$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-credit-card"></i></a>';
	// 		}	else if($row['payment_status'] == 2 && $row['booking_status'] == 1) {
	// 			$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
	// 		} else {
	// 			$print = "";
	// 		}

	// 		if($row['payment_status'] == 1 && $row['booking_status'] == 1) {
	// 			$action = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-times"></i> </a>  <a class="btn btn-primary btn-rad btn-success" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-redo">Repay</i></a>';
	// 		}	else if($row['payment_status'] == 2 && $row['booking_status'] == 1) {
	// 			$action = '<a class="btn btn-warning btn-rad btn-cancel btn-danger" title="Print" href="'.base_url().'/templeubayam_online/print_page_ubayam/'. $row['id'].'" target="_blank"><i class="fa fa-times"></i> </a>  <a class="btn btn-primary btn-rad btn-success" title="Edit" href="'.base_url().'/report/show_loan_history/'.$row['id'].'"><i class="fa fa-redo">Repay</i></a>';
	// 		} else {
	// 			$action = "";
	// 		}

	// 		$data[] = array(
	// 			$i++,
	// 			date('d-m-Y', strtotime($row['entry_date'])),
	// 			date('d-m-Y', strtotime($row['booking_date'])),
	// 			$row['pname'],
	// 			$row['name'],
	// 			$row['total_amount'],
	// 			$row['paid_amount'],
	// 			$txt,
	// 			$print,
	// 			$action
	// 		);
	// 	}

	// 	$result = array(
	// 		"draw" => 0,
	// 		"recordsTotal" => $i - 1,
	// 		"recordsFiltered" => $i - 1,
	// 		"data" => $data,
	// 	);
	// 	echo json_encode($result);
	// 	exit();
	// }

	public function print_hallreport_temple()
	{
		// if (!$this->model->list_validate('ubayam_report')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$data['report_type'] = $_REQUEST['report_type'];
		$report_type = $_REQUEST['report_type'];
		$data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			if ($report_type == 1) {
				$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			} else {
				$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			}
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/ubay_print_temple', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			// $fileName = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			if ($report_type == 1) {
				$fileName = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			} else {
				$fileName = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			}
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Event Date');
			$sheet->setCellValue('D2', 'Event Name');
			$sheet->setCellValue('E2', 'Name');
			$sheet->setCellValue('F2', 'Amount');
			$sheet->setCellValue('F2', 'Paid Amount');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_hallreport_temple($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['entry_date']);
				$sheet->setCellValue('C' . $rows, $val['date']);
				$sheet->setCellValue('D' . $rows, $val['pname']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				$sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/ubay_print_temple', $data);
		}
	}

	public function excel_format_get_hallreport_temple($fdata, $tdata, $cdata, $group_filter, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt= date('Y-m-d',strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];
		// $dat = $this->db->table('ubayam', 'ubayam_setting.name as pname')
		// 	->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
		// 	->select('ubayam_setting.name as pname')
		// 	->select('ubayam.*')
		// 	->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") >=', $fdt);
		// $dat = $dat->where('DATE_FORMAT(ubayam.ubayam_date, "%Y-%m-%d") <=', $tdt);
		// if ($payfor) {
		// 	$dat = $dat->where('ubayam_setting.id', $payfor);
		// }
		// if ($fltername) {
		// 	$dat = $dat->where('ubayam.name', $fltername);
		// }
		// $dat = $dat->orderBy('ubayam_date', 'asc');
		// $dat = $dat->get()->getResultArray();
		$dat = $this->db->table('templebooking', 'booked_packages.name as pname')
			->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
			->select('booked_packages.name as pname')
			->select('templebooking.*')
			->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);
		// if ($payforg) {
		// 	$dat = $dat->where('booked_packages.package_id', $payforg);
		// }
		if ($booking_type) {
			$dat = $dat->where('booked_packages.booking_type', $booking_type);
		}
		if (!empty($cdt)) {
			$dat = $dat->where('templebooking.booking_date =', $cdt);
		}

		if (!empty($group_filter_fill) && $group_filter_fill != "0") {
			$dat = $dat->where('templebooking.payment_type', $group_filter_fill);
		}
		// if ($fltername) {
		// 	$dat = $dat->where('templebooking.name', $fltername);
		// }
		$dat = $dat->orderBy('entry_date', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			if($row['booking_status'] == 3) {
				$txt = 'Cancelled';
			}	else {

				if (empty($balance_amount)) {
					$txt = 'Paid';
				} else {
					$txt = 'Partially Paid';
				}
			}
			$data[] = array(
				"s_no" => $i++,
				"entry_date" => date('d-m-Y', strtotime($row['entry_date'])),
				"date" => date('d-m-Y', strtotime($row['booking_date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				"paid" => $row['paid_amount'],
				// "bal" => $balance_amount,
				"status" => $txt
			);
		}
		return $data;
	}

	public function kattalai_archanai_report_ref()
	{
		if (!empty($_POST['fdt'])) $from_date = $_POST['fdt'];
		else $from_date = date('Y-m-01');

		if (!empty($_POST['tdt'])) $to_date = $_POST['tdt'];
		else $to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];
		//echo $group_filter; die();

		$builder = $this->db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type, kab.ref_no, kab.payment_status, kab.booking_status')
            ->where('kab.date >=', $from_date)
            ->where('kab.date <=', $to_date);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		// echo $group_filter; die();
		$builder->orderBy('kab.id', 'DESC');

		$res = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;
		
		$i = 0;
		//print_r($res);die;
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $aname) {

				if ($aname['daytype'] == 'daily'){
					$daytype = 'Daily';
				} elseif ($aname['daytype'] == 'weekly'){
					$daytype = 'Weekly';
				} elseif ($aname['daytype'] == 'days'){
					$daytype = 'Multiple Dates';
				} elseif ($aname['daytype'] == 'years'){
					$daytype = 'Yearly';
				}

				$balance_amount = (float) $aname['amount'] - (float) $aname['paid_amount'];
				if ($balance_amount < 0)
					$balance_amount = 0;

				if($aname['booking_status'] == 3) {
					$txt = '<span class="cancel_text">Cancelled</span>';
				}	else {

					if (empty($balance_amount)) {
						$txt = '<span class="paid_text">Paid</span>';
					} else {
						$txt = '<span class="unpaid_text">Partially Paid</span>';
					}
				}

				if($aname['payment_status'] == 1) {
					$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking_report/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>  <a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$aname['id'].'"><i class="fa fa-credit-card"></i></a>';
					//$action = '<a class="btn btn-primary btn-rad btn-payment" title="Edit" href="'.base_url().'/report/show_loan_history/'.$r['staff_id'].'"><i class="material-icons">&#xE417;</i></a>';
				}	else if($aname['payment_status'] == 2) {
					$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking_report/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
				} else {
					$print = "";
				}

				// if($aname['payment_status'] == 1) {
				// 	$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking_report/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>   <a class="btn btn-warning btn-payment btn-rad" title="Pay" href=" '.base_url().'/annathanam_new/payment/'. $aname['id'] .'" target="_blank"><i class="fa fa-credit-card"></i> </a>';
				// }	else {
				// 	$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/kattalai_archanai_online/print_booking_report/'. $aname['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
				// } //else {
				// // 	$print = "";
				// // }


				$data[] = array(
					$i++,
					date("d-m-Y", strtotime($aname['date'])),
					$aname['ref_no'],
					$aname['name'],
					$daytype,
					$aname['payment_type'],
					$aname['amount'],
					$aname['paid_amount'],
					$print,
					//$action
				);
			}
		}
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_kattalaireport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount($)');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount($)');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_archanai_print', $data);
		}
	}

	public function excel_format_get_kattalai($fdata, $tdata, $cdata, $group_filter, $booking_type)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt= date('Y-m-d',strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];
		
		$builder = $this->db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
            ->where('kab.date >=', $fdt)
            ->where('kab.date <=', $tdt);

		if (!empty($group_filter_fill) && $group_filter_fill != '0') {
			$builder->where('kab.daytype', $group_filter_fill);
		}
		// echo $group_filter; die();
		$builder->orderBy('kab.date', 'DESC');

		$res = $builder->get()->getResultArray();

		$i = 1;
		foreach ($res as $row) {
			
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"name" => $row['name'],
				"daytype" => $row['daytype'],
				"payment_type" => $row['payment_type'],
				"amount" => $row['amount'],
				"paid_amount" => $row['paid_amount'],
				
			);
		}
		return $data;
	}

	public function print_gurukalreport()
	{
		// if (!$this->model->list_validate('ubayam_report')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		// $data['report_type'] = $_REQUEST['report_type'];
		// $report_type = $_REQUEST['report_type'];
		// $data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			// if ($report_type == 1) {
			// 	$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// } else {
			// 	$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// }
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_gurukal_print', $data);
		}
	}
	public function print_notificationreport()
	{
		// if (!$this->model->list_validate('ubayam_report')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		// $data['report_type'] = $_REQUEST['report_type'];
		// $report_type = $_REQUEST['report_type'];
		// $data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			// if ($report_type == 1) {
			// 	$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// } else {
			// 	$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// }
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_notification_print', $data);
		}
	}
	public function print_offeringreport()
	{
		
		$fdt = date('Y-m-d', strtotime($_REQUEST['fdt']));
		$tdt = date('Y-m-d', strtotime($_REQUEST['tdt']));
		$type = $_REQUEST['offering_id'];
		$ptype = $_REQUEST['product_id'];

		$data['fdate'] = $fdt;
		$data['tdate'] = $tdt;
		$data['type'] = $type;
		$data['ptype'] = $ptype;
		
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_stockreport'] == "PDF") {
			
			$file_name = "Offering_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/offering_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_stockreport'] == "EXCEL") {
			$fileName = "Offering_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Name');
			$sheet->setCellValue('C2', 'Phone');
			$sheet->setCellValue('D2', 'Category');
			$sheet->setCellValue('E2', 'Product');
			$sheet->setCellValue('F2', 'Grams');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			// $sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_offering($data['fdate'], $data['tdate'], $data['cdate'], $data['type'], $data['ptype']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['name']);
				$sheet->setCellValue('C' . $rows, $val['phone']);
				$sheet->setCellValue('D' . $rows, $val['category_name']);
				$sheet->setCellValue('E' . $rows, $val['product_name']);
				$sheet->setCellValue('F' . $rows, $val['grams']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				// $sheet->setCellValue('G' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/offering_print', $data);
		}
	}

	public function excel_format_get_offering($fdata, $tdata, $cdata, $type, $ptype)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt= date('Y-m-d',strtotime($cdata));
		}
		// $flternameg = $fltername;
		$data = [];
		
		// $dat = $this->db->table('templebooking', 'booked_packages.name as pname')
		// 	->join('booked_packages', 'booked_packages.booking_id = templebooking.id')
		// 	->select('booked_packages.name as pname')
		// 	->select('templebooking.*')
		// 	->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") >=', $fdt);
		// $dat = $dat->where('DATE_FORMAT(templebooking.entry_date, "%Y-%m-%d") <=', $tdt);
		
		// if ($booking_type) {
		// 	$dat = $dat->where('booked_packages.booking_type', $booking_type);
		// }
		// if (!empty($cdt)) {
		// 	$dat = $dat->where('templebooking.booking_date =', $cdt);
		// }

		// if (!empty($group_filter_fill) && $group_filter_fill != "0") {
		// 	$dat = $dat->where('templebooking.payment_type', $group_filter_fill);
		// }
		
		// $dat = $dat->orderBy('entry_date', 'desc');
		// $dat = $dat->get()->getResultArray();


		$builder = $this->db->table('product_offering')
    ->select('
        product_offering.*,
        product_offering_detail.*,
        product_category.name AS product_name,
        offering_category.name AS category_name
    ')
    ->join('product_offering_detail', 'product_offering_detail.pro_off_id = product_offering.id')
    ->join('product_category', 'product_offering_detail.product_id = product_category.id')
    ->join('offering_category', 'product_offering_detail.offering_id = offering_category.id');

// Apply condition if $type is not empty
if (!empty($type)) {
    $builder->where('product_offering_detail.offering_id', $type);
}

// Apply condition if $ptype is not empty
if (!empty($ptype)) {
    $builder->where('product_offering_detail.product_id', $ptype);
}

// Order the results
$builder->orderBy('product_offering.id', 'DESC');

// Execute the query
$qry = $builder->get()->getResultArray();

		$i = 1;
		foreach ($qry as $row) {
			
			$data[] = array(
				"s_no" => $i++,
				"name" => $row['name'],
				"phone" => $row['phone'],
				"category_name" => $row['category_name'],
				"product_name" => $row['product_name'],
				"grams" => $row['grams']
			);
		}
		return $data;
	}

	public function outdoor_report()
	{
		if (!empty($_POST['fdt']))
			$from_date = $_POST['fdt'];
		else
			$from_date = date('Y-m-01');

		if (!empty($_POST['tdt']))
			$to_date = $_POST['tdt'];
		else
			$to_date = date('Y-m-d');

		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];
		$data['fdt'] = $from_date;
		$data['tdt'] = $to_date;
		$data['cdt'] = $cdt;
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/report/outdoor_report', $data);
	}

	public function outdoor_rep_ref()
	{
		$fdt = date('Y-m-d', strtotime($_POST['fdt']));
		$tdt = date('Y-m-d', strtotime($_POST['tdt']));
		$cdt = isset($_POST['cdt']) && !empty($_POST['cdt']) ? date('Y-m-d', strtotime($_POST['cdt'])) : null;
		$group_filter = $_POST['group_filter'];

		$data = [];
		$dat = $this->db->table('outdoor_booking', 'temple_packages.name as pname')
			->join('temple_packages', 'temple_packages.id = outdoor_booking.package_id')
			->select('temple_packages.name as pname')
			->select('outdoor_booking.*')
			->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('outdoor_booking.event_date =', $cdt);
		}

		if (!empty($group_filter) && $group_filter != "0") {
			$dat = $dat->where('outdoor_booking.payment_type', $group_filter);
		}

		$dat = $dat->orderBy('outdoor_booking.date', 'desc');
		$dat = $dat->get()->getResultArray();
		$print = "";

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;

			if($row['booking_status'] == 3) {
				$txt = '<span class="cancel_text">Cancelled</span>';
			}	else {

				if (empty($balance_amount)) {
					$txt = '<span class="paid_text">Paid</span>';
				} else {
					$txt = '<span class="unpaid_text">Partially Paid</span>';
				}
			}

			if($row['amount'] - $row['paid_amount'] && $row['payment_type'] == "partial") {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/outdoor_online/print_page/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>   <a class="btn btn-warning btn-payment btn-rad" title="Pay" href=" '.base_url().'/annathanam_new/payment/'. $row['id'] .'" target="_blank"><i class="fa fa-credit-card"></i> </a>';
			}	else if($row['payment_type'] == 'full') {
				$print = '<a class="btn btn-warning btn-rad" title="Print" href="'.base_url().'/outdoor_online/print_page/'. $row['id'].'" target="_blank"><i class="fa fa-print"></i> </a>';
			} else {
				$print = "";
			}

			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['date'])),
				date('d-m-Y', strtotime($row['event_date'])),
				$row['pname'],
				$row['name'],
				$row['amount'],
				$txt,
				$print,

			);
		}
	
		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		echo json_encode($result);
		exit();
	}

	public function print_outdoor_report()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if ($_REQUEST['pdf_outdoorreport'] == "PDF") {
			
			$file_name = "Outdoor_services_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/outdoor_print_temple', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_outdoorreport'] == "EXCEL") {
			$fileName = "Outdoor_services_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Booking Date');
			$sheet->setCellValue('C2', 'Event Date');
			$sheet->setCellValue('D2', 'Event Name');
			$sheet->setCellValue('E2', 'Name');
			$sheet->setCellValue('F2', 'Amount');
			$sheet->setCellValue('G2', 'Status');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_outdoor_report($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['entry_date']);
				$sheet->setCellValue('C' . $rows, $val['date']);
				$sheet->setCellValue('D' . $rows, $val['pname']);
				$sheet->setCellValue('E' . $rows, $val['name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				$sheet->setCellValue('G' . $rows, $val['status']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/outdoor_print_temple', $data);
		}
	}

	public function excel_format_get_outdoor_report($fdata, $tdata, $cdata, $group_filter)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$group_filter_fill = $group_filter;
		if (!empty($cdata)) {
			$cdt= date('Y-m-d',strtotime($cdata));
		}
		$data = [];
		$dat = $this->db->table('outdoor_booking')
			->join('temple_packages', 'temple_packages.id = outdoor_booking.package_id')
			->select('temple_packages.name as pname')
			->select('outdoor_booking.*')
			->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(outdoor_booking.date, "%Y-%m-%d") <=', $tdt);

		if (!empty($cdt)) {
			$dat = $dat->where('outdoor_booking.event_date =', $cdt);
		}

		if (!empty($group_filter_fill) && $group_filter_fill != "0") {
			$dat = $dat->where('outdoor_booking.payment_type', $group_filter_fill);
		}
		$dat = $dat->orderBy('date', 'desc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$balance_amount = (float) $row['amount'] - (float) $row['paid_amount'];
			if ($balance_amount < 0)
				$balance_amount = 0;
			if($row['booking_status'] == 3) {
				$txt = 'Cancelled';
			}	else {

				if (empty($balance_amount)) {
					$txt = 'Paid';
				} else {
					$txt = 'Partially Paid';
				}
			}
			$data[] = array(
				"s_no" => $i++,
				"entry_date" => date('d-m-Y', strtotime($row['date'])),
				"date" => date('d-m-Y', strtotime($row['event_date'])),
				"pname" => $row['pname'],
				"name" => $row['name'],
				"amount" => $row['amount'],
				"status" => $txt
			);
		}
		return $data;
	}

	public function kattalai_gurukal_report($from_date, $to_date)
	{
		if (!empty($_POST['fdt'])) $from_date = $_POST['fdt'];
		else $from_date = date('Y-m-01');

		if (!empty($_POST['tdt'])) $to_date = $_POST['tdt'];
		else $to_date = date('Y-m-d');
		$group_filter = $_POST['group_filter'];

		$builder = $this->db->table('kattalai_archanai_booking as kab')
            ->select('kab.id, kab.name, kab.date, kab.daytype, kab.amount, kab.paid_amount, kab.payment_type')
            //->join('booked_packages as bp', 'bp.booking_id = kab.id')
            ->where('kab.date >=', $from_date)
            ->where('kab.date <=', $to_date);

		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		
		$builder->orderBy('kab.date', 'DESC');

		$data['list'] = $builder->get()->getResultArray();

		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray();
		$data['from_date'] = $from_date;
		$data['to_date'] = $to_date;
		$data['group_filter'] = $group_filter;

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_gurukal_report', $data);
	}

	public function kattalai_gurukal_report_ref()
{
    $from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
    $to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
    $group_filter = $_POST['group_filter'] ?? null;

    // Create a period for each day between from_date and to_date
    $period = new \DatePeriod(
        new \DateTime($from_date),
        new \DateInterval('P1D'),
        (new \DateTime($to_date))->modify('+1 day')
    );

    $groupedData = [];

    foreach ($period as $dt) {
        $currentDate = $dt->format("Y-m-d");

        // Fetch records for the current date based on daytype
        // $builder = $this->db->table('kattalai_archanai_booking as kab')
        //     ->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
        //     ->where('kab.start_date <=', $to_date)
        //     ->where('kab.end_date >=', $from_date);
		
	// 	$builder = $this->db->table('kattalai_archanai_booking as kab')
    // ->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
    // ->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");

	if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
		$builder = $this->db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		// ->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
        //        FROM kattalai_archanai_deity_details d 
        //        WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
           FROM kattalai_archanai_deity_details d
           JOIN archanai_diety ad ON ad.id = d.deity_id
           WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
		FROM kattalai_archanai_details d2
		JOIN rasi r ON d2.rasi = r.id
		JOIN natchathram n ON d2.natchathiram = n.id
		WHERE d2.booking_id = kab.id) as devotee_details")
		->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
		if (!empty($group_filter) && $group_filter != '0') {
			// Apply the filter for 'daytype' only if it's not empty or '0'
			$builder->where('kab.daytype', $group_filter);
		}
		$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
	} else if ($group_filter == 'days') {
		$builder = $this->db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		// ->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
        //        FROM kattalai_archanai_deity_details d 
        //        WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
           FROM kattalai_archanai_deity_details d
           JOIN archanai_diety ad ON ad.id = d.deity_id
           WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
		FROM kattalai_archanai_details d2
		JOIN rasi r ON d2.rasi = r.id
		JOIN natchathram n ON d2.natchathiram = n.id
		WHERE d2.booking_id = kab.id) as devotee_details")
		->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
		if (!empty($group_filter) && $group_filter != '0') {
			// Apply the filter for 'daytype' only if it's not empty or '0'
			$builder->where('kab.daytype', $group_filter);
		}
		$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
	} 
	 else {

		$builder = $this->db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		// ->select("(SELECT GROUP_CONCAT(d1.deity_name SEPARATOR ', ') 
        //        FROM kattalai_archanai_deity_details d1 
        //        WHERE d1.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(ad.name_tamil SEPARATOR ', ')
           FROM kattalai_archanai_deity_details d
           JOIN archanai_diety ad ON ad.id = d.deity_id
           WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_tamil, '-', n.name_tamil) SEPARATOR ', ')
		FROM kattalai_archanai_details d2
		JOIN rasi r ON d2.rasi = r.id
		JOIN natchathram n ON d2.natchathiram = n.id
		WHERE d2.booking_id = kab.id) as devotee_details")   
		->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
		if (!empty($group_filter) && $group_filter != '0') {
			// Apply the filter for 'daytype' only if it's not empty or '0'
			$builder->where('kab.daytype', $group_filter);
		}
		$res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();
	}


        foreach ($res as $record) {
            $matchesDate = false;
			if ($record['daytype'] == 'days') {
                $datesRes1 = $this->db->table('kattalai_archanai_dates')
                    ->select('date')
                    ->where('booking_id', $record['id'])
                    ->get()
                    ->getResultArray();

				$dateCollection = array_column($datesRes1, 'date');
				if (!empty($dateCollection)) {
					$start = min($dateCollection);  // Get the earliest date
					$end = max($dateCollection);    // Get the latest date
				}

                foreach ($datesRes1 as $dateRow1) {
                    if ($dateRow1['date'] == $currentDate) {
                        $matchesDate = true;
                        break; 
                    }
                }
            } else {

			
            switch ($record['daytype']) {
                case 'weekly':			
					$weekday = date('N', strtotime($currentDate));
					$weekday = $weekday % 7 + 1;
					if (($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) && $record['dayofweek'] == $weekday) {
						$matchesDate = true;
					}
                    break;
                case 'years':
                case 'daily':
                    // Check if the date falls within the booking period
                    if ($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) {
                        $matchesDate = true;
                    }
                    break;
            }
		}

            if ($matchesDate) {
				if ($record['daytype'] == 'days') {
					$startdate = date("d-m-Y", strtotime($start));
					$enddate = date("d-m-Y", strtotime($end));
				} else {
					$startdate = date("d-m-Y", strtotime($record['start_date']));
					$enddate = date("d-m-Y", strtotime($record['end_date']));
				}
			
                $formattedDate = date("d-m-Y", strtotime($currentDate));
                $groupedData[$formattedDate][] = array(
                    'Id' => $record['id'],
                    'Date' => $formattedDate,
                    'Start Date' => $startdate,
                    'End Date' => $enddate,
                    'Devotee Name' => $record['name'],
                    'Types' => $record['daytype'],
                    'Payment Type' => $record['payment_type'],
                    'Amount' => $record['amount'],
                    'deity_names' => $record['deity_names'],
                    'devotee_details' => $record['devotee_details'],
                    'Paid Amount' => $record['paid_amount']
                );
            }
        }
    }

    // Pass data to the view
    $data = [
        'list' => $groupedData,
        'from_date' => $from_date,
        'to_date' => $to_date,
        'group_filter' => $group_filter,
        'payment_modes' => $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray()
    ];

    echo view('frontend/layout/header');
    echo view('frontend/report/kattalai_gurukal_report', $data);
}

	
	public function kattalai_gurukal_report_ref_new()
	{
		$from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
		$to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
		$group_filter = $_POST['group_filter'] ?? null;

		// Generate a DatePeriod for the range between from_date and to_date
		$period = new \DatePeriod(
			new \DateTime($from_date),
			new \DateInterval('P1D'),
			(new \DateTime($to_date))->modify('+1 day')
		);

		$groupedData = [];

		foreach ($period as $dt) {
			$currentDate = $dt->format("Y-m-d");
			// Initialize daily records
			$groupedData[$currentDate] = [];

			// Build the query
			$builder = $this->db->table('kattalai_archanai_booking as kab')
				->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
				->where('kab.start_date <=', $to_date)
				->where('kab.end_date >=', $from_date);

			if (!empty($group_filter) && $group_filter != '0') {
				$builder->where('kab.daytype', $group_filter);
			}

			$results = $builder->get()->getResultArray();

			foreach ($results as $record) {
				if ($this->matchesDate($record, $currentDate)) {
					$formattedDate = date("d-m-Y", strtotime($currentDate));
					$groupedData[$formattedDate][] = [
						'Id' => $record['id'],
						'Date' => $formattedDate,
						'Start Date' => date("d-m-Y", strtotime($record['start_date'])),
						'End Date' => date("d-m-Y", strtotime($record['end_date'])),
						'Devotee Name' => $record['name'],
						'Types' => $record['daytype'],
						'Payment Type' => $record['payment_type'],
						'Amount' => $record['amount'],
						'Paid Amount' => $record['paid_amount']
					];
				}
			}
		}

		// Display the grouped data
		$data = [
			'list' => $groupedData,
			'from_date' => $from_date,
			'to_date' => $to_date,
			'group_filter' => $group_filter,
			'payment_modes' => $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray()
		];

		// var_dump($data);
		// exit;

		echo view('frontend/layout/header');
		echo view('frontend/report/kattalai_gurukal_report', $data);
	}
	public function kattalai_notification_ref()
{
    $from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
    $to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
    $group_filter = $_POST['group_filter'] ?? null;
    $current_date = date('Y-m-d');

    $builder = $this->db->table('kattalai_archanai_booking as kab')
        ->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		->select("(SELECT GROUP_CONCAT(d.deity_name SEPARATOR ', ') 
               FROM kattalai_archanai_deity_details d 
               WHERE d.booking_id = kab.id) as deity_names")
		->select("(SELECT GROUP_CONCAT(CONCAT(d2.name, '-', r.name_eng, '-', n.name_eng) SEPARATOR ', ')
				FROM kattalai_archanai_details d2
				JOIN rasi r ON d2.rasi = r.id
				JOIN natchathram n ON d2.natchathiram = n.id
				WHERE d2.booking_id = kab.id) as devotee_details");

    if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
        $builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
    } else if ($group_filter == 'days') {
        $builder->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
    } else {
        $builder->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
    }

    if (!empty($group_filter) && $group_filter != '0') {
        $builder->where('kab.daytype', $group_filter);
    }

    $res = $builder->orderby('kab.id', 'desc')->get()->getResultArray();

    $groupedData = [];

    foreach ($res as $record) {
        $status = '';
        $enddate = $record['end_date'];

        if ($record['start_date'] == null || $record['end_date'] == null) {
            // Check the kattalai_archanai_dates table for the effective end date
            $datesRes = $this->db->table('kattalai_archanai_dates')
			->select('MAX(date) as end_date')
			->where('booking_id', $record['id'])
			->where('date IS NOT NULL')
    		->where('date !=', '1970-01-01')
			->get()
			->getRowArray();

            // if ($datesRes['end_date']) {
			if (!empty($datesRes['end_date']) && $datesRes['end_date'] > $from_date) {
                $enddate = $datesRes['end_date'];
            } else {
                // Skip this record if both start_date and end_date are null and kattalai_archanai_dates table has no valid end date
                continue;
            }
        }

        if ($enddate <= $current_date) {
            $status = 'COMPLETED';
        } elseif ($enddate < $to_date) {
            $status = 'GOING TO COMPLETE';
        } else {
            $status = 'ONGOING';
        }

        // $startdate = date("d-m-Y", strtotime($record['start_date']));
        $formattedDate = date("d-m-Y", strtotime($record['date']));

		if ($record['daytype'] == 'days') {
			$startdate = "";
		} else {
			$startdate = date("d-m-Y", strtotime($record['start_date']));
		}

		$daytype ="";
		if ($record['daytype'] == 'daily'){
			$daytype = 'Daily';
		} elseif ($record['daytype'] == 'weekly'){
			$daytype = 'Weekly';
		} elseif ($record['daytype'] == 'days'){
			$daytype = 'Multiple Dates';
		} elseif ($record['daytype'] == 'years'){
			$daytype = 'Yearly';
		}

        $groupedData[] = array(
            'Id' => $record['id'],
            'Date' => $formattedDate,
            'Start Date' => $startdate,
            'End Date' => date("d-m-Y", strtotime($enddate)),
            'Devotee Name' => $record['name'],
            'Types' => $daytype,
            'Payment Type' => $record['payment_type'],
            'Amount' => $record['amount'],
            'deity_names' => $record['deity_names'],
            'devotee_details' => $record['devotee_details'],
            'Paid Amount' => $record['paid_amount'],
            'Status' => $status
        );
    }

    $data = [
        'list' => $groupedData,
        'from_date' => $from_date,
        'to_date' => $to_date,
        'group_filter' => $group_filter,
        'payment_modes' => $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray()
    ];

    echo view('frontend/layout/header');
    echo view('frontend/report/kattalai_notification_report', $data);
}

	public function kattalai_notification_ref_withoutDays()
{
    $from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
    $to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
    $group_filter = $_POST['group_filter'] ?? null;
    $current_date = date('Y-m-d');

    $builder = $this->db->table('kattalai_archanai_booking as kab')
        ->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
        ->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");

    if (!empty($group_filter) && $group_filter != '0') {
        $builder->where('kab.daytype', $group_filter);
    }

    $res = $builder->get()->getResultArray();

    $groupedData = [];

    foreach ($res as $record) {
        $status = '';
        if ($record['end_date'] <= $current_date) {
            $status = 'COMPLETED';
        } elseif ($record['end_date'] <= $to_date) {
            $status = 'GOING TO COMPLETE';
        } else {
            $status = 'ONGOING';
        }

        $startdate = date("d-m-Y", strtotime($record['start_date']));
        $enddate = date("d-m-Y", strtotime($record['end_date']));
        $formattedDate = date("d-m-Y", strtotime($record['date']));

        $groupedData[] = array(
            'Id' => $record['id'],
            'Date' => $formattedDate,
            'Start Date' => $startdate,
            'End Date' => $enddate,
            'Devotee Name' => $record['name'],
            'Types' => $record['daytype'],
            'Payment Type' => $record['payment_type'],
            'Amount' => $record['amount'],
            'Paid Amount' => $record['paid_amount'],
            'Status' => $status
        );
    }

    $data = [
        'list' => $groupedData,
        'from_date' => $from_date,
        'to_date' => $to_date,
        'group_filter' => $group_filter,
        'payment_modes' => $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray()
    ];

    echo view('frontend/layout/header');
    echo view('frontend/report/kattalai_notification_report', $data);
}

	public function kattalai_notification_ref_ORIGINAl()
{
    $from_date = !empty($_POST['fdt']) ? $_POST['fdt'] : date('Y-m-01');
    $to_date = !empty($_POST['tdt']) ? $_POST['tdt'] : date('Y-m-d');
    $group_filter = $_POST['group_filter'] ?? null;

    // Create a period for each day between from_date and to_date
    $period = new \DatePeriod(
        new \DateTime($from_date),
        new \DateInterval('P1D'),
        (new \DateTime($to_date))->modify('+1 day')
    );

    $groupedData = [];

    foreach ($period as $dt) {
        $currentDate = $dt->format("Y-m-d");
        
		// $currentDate = date("Y-m-d");

       

	if ($group_filter == 'daily' || $group_filter == 'weekly' || $group_filter == 'years') {
		$builder = $this->db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}')");
		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		$res = $builder->get()->getResultArray();
	} else if ($group_filter == 'days') {
		$builder = $this->db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		->where("(kab.start_date IS NULL OR kab.end_date IS NULL)");
		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		$res = $builder->get()->getResultArray();
	} 
	 else {

		$builder = $this->db->table('kattalai_archanai_booking as kab')
		->select('kab.id, kab.name, kab.date, kab.daytype, kab.dayofweek, kab.amount, kab.paid_amount, kab.payment_type, kab.start_date, kab.end_date')
		->where("(kab.start_date <= '{$to_date}' AND kab.end_date >= '{$from_date}') OR kab.start_date IS NULL OR kab.end_date IS NULL");
		if (!empty($group_filter) && $group_filter != '0') {
			$builder->where('kab.daytype', $group_filter);
		}
		$res = $builder->get()->getResultArray();
	}


        foreach ($res as $record) {
            $matchesDate = false;
			if ($record['daytype'] == 'days') {
                $datesRes1 = $this->db->table('kattalai_archanai_dates')
                    ->select('date')
                    ->where('booking_id', $record['id'])
                    ->get()
                    ->getResultArray();

                foreach ($datesRes1 as $dateRow1) {
                    if ($dateRow1['date'] == $currentDate) {
                        $matchesDate = true;
                        break; 
                    }
                }
            } else {

			
            switch ($record['daytype']) {
                
                case 'weekly':
                    
					
					$weekday = date('N', strtotime($currentDate));
					$weekday = $weekday % 7 + 1;
					if (($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) && $record['dayofweek'] == $weekday) {
						$matchesDate = true;
					}
                    break;
                case 'years':
                case 'daily':
                    if ($record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate) {
                        $matchesDate = true;
                    }
                    break;
            }
		}

            if ($matchesDate) {
				if ($record['daytype'] == 'days') {
					$startdate = "";
					$enddate = "";
				} else {
					$startdate = date("d-m-Y", strtotime($record['start_date']));
					$enddate = date("d-m-Y", strtotime($record['end_date']));
				}
                $formattedDate = date("d-m-Y", strtotime($currentDate));
                $groupedData[$formattedDate][] = array(
                    'Id' => $record['id'],
                    'Date' => $formattedDate,
                    'Start Date' => $startdate,
                    'End Date' => $enddate,
                    'Devotee Name' => $record['name'],
                    'Types' => $record['daytype'],
                    'Payment Type' => $record['payment_type'],
                    'Amount' => $record['amount'],
                    'Paid Amount' => $record['paid_amount']
                );
            }
        }
    }

    $data = [
        'list' => $groupedData,
        'from_date' => $from_date,
        'to_date' => $to_date,
        'group_filter' => $group_filter,
        'payment_modes' => $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'COUNTER')->get()->getResultArray()
    ];

    echo view('frontend/layout/header');
    echo view('frontend/report/kattalai_notification_report', $data);
}

	private function matchesDate($record, $currentDate)
{
    switch ($record['daytype']) {
        case 'daily':
        case 'years':
    
            return $record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate;

        case 'days':
            // For 'days', bookings are set for specific dates within the start and end dates
            $datesRes = $this->db->table('kattalai_archanai_dates')
                                 ->select('date')
                                 ->where('booking_id', $record['id'])
                                 ->get()
                                 ->getResultArray();
            foreach ($datesRes as $dateRow) {
                if ($dateRow['date'] == $currentDate) {
                    return true;
                }
            }
            return false;

        case 'weekly':
            // For 'weekly', bookings occur on a specific day of the week, between the start and end dates
            $weekday = date('N', strtotime($currentDate)); // N = 1 (for Monday) through 7 (for Sunday)
            if ($record['dayofweek'] == $weekday) {
                return $record['start_date'] <= $currentDate && $record['end_date'] >= $currentDate;
            }
            return false;

        default:
            // Handle unknown daytypes
            error_log("Unhandled daytype: {$record['daytype']}");
            return false;
    }
}


	public function print_kattalai_gurukal_report()
	{
		// if (!$this->model->list_validate('ubayam_report')) {
		// 	header('Location: ' . base_url() . '/dashboard');
		// }
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		if (!empty($_REQUEST['cdt'])) {
			$data['cdate'] = $_REQUEST['cdt'];
		}
		$data['group_filter'] = $_REQUEST['group_filter'];
		// $data['report_type'] = $_REQUEST['report_type'];
		// $report_type = $_REQUEST['report_type'];
		// $data['booking_type'] = $_REQUEST['booking_type'];
		$tmpid = 1;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		// $data['payfor'] = $_REQUEST['payfor'];
		// $data['fltername'] = $_REQUEST['fltername'];
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			// if ($report_type == 1) {
			// 	$file_name = "Hallbooking_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// } else {
			// 	$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			// }
			$file_name = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/kattalai_archanai_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "KattalaiArchanai_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:H1")->applyFromArray($style);
			$sheet->mergeCells('A1:H1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Devotee Name');
			$sheet->setCellValue('D2', 'Types');
			$sheet->setCellValue('E2', 'Payment Type');
			$sheet->setCellValue('F2', 'Amount');
			// $sheet->setCellValue('F2', 'Paid');
			// $sheet->setCellValue('G2', 'Balance');
			$sheet->setCellValue('G2', 'Paid Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_kattalai($data['fdate'], $data['tdate'], $data['cdate'], $data['group_filter'], $data['booking_type']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['name']);
				$sheet->setCellValue('D' . $rows, $val['daytype']);
				$sheet->setCellValue('E' . $rows, $val['payment_type']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				// $sheet->setCellValue('F' . $rows, $val['paid']);
				// $sheet->setCellValue('G' . $rows, $val['bal']);
				$sheet->setCellValue('G' . $rows, $val['paid_amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/kattalai_archanai_print', $data);
		}
	}



	public function ubayam_rep_ref()
	{
		// $fdt = date('Y-m-d', strtotime($_POST['fdt']));
		// $tdt = date('Y-m-d', strtotime($_POST['tdt']));
		// $cdt = date('Y-m-d', strtotime($_POST['tdt']));
		// $fdt = '20224-09-01';
		// $tdt = '20224-09-13';

		$data = [];
		$dat = $this->db->table('templebooking tb')
			->select('tb.`id`, `tb`.`entry_date`, tb.`name`, tb.payment_type, tb.`amount`, tb.`paid_amount`')
			->where('booking_type', 2)
			->where('DATE_FORMAT(tb.entry_date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(tb.entry_date, "%Y-%m-%d") <=', $tdt);

		if ($cdt) {
			$group_filter = trim($cdt);
			$dat = $dat->where('tb.booking_date', $group_filter);
		}

		if ($_POST['group_filter']) {
			$group_filter = trim($_POST['group_filter']);
			$dat = $dat->where('tb.payment_type', $group_filter);
		}
		$dat = $dat->orderBy('tb.entry_date', 'asc');
		$dat = $dat->get()->getResultArray();

		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('booked_packages')->select('booked_packages.name')->where('booked_packages.booking_id', $row['id'])->get()->getResultArray();
			$html = "";
			foreach ($payfors as $payfor) {
				$html .= "&#x2022; " . $payfor['name'] . "<br>";
			}
			$data[] = array(
				$i++,
				date('d-m-Y', strtotime($row['entry_date'])),
				date('d-m-Y', strtotime($row['booking_date'])),
				$row['name'],
				$row['payment_type'],
				"<p style='text-align: left;'>" . $html . "</p>",
				number_format($row['amount'], '2', '.', ','),
				number_format($row['paid_amount'], '2', '.', ',')
			);
		}

		$result = array(
			"draw" => 0,
			"recordsTotal" => $i - 1,
			"recordsFiltered" => $i - 1,
			"data" => $data,
		);
		// echo json_encode($result);
		// exit();
		echo view('frontend/layout/header');
		echo view('frontend/report/ubayam_report', $dat);
	}
	
	public function print_ubayamreport()
	{
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$data['cdate'] = $_REQUEST['cdt'];
		$data['fltername'] = $_REQUEST['group_filter'];
		//$data['collection_date'] = isset($_REQUEST['cdt']) && !empty($_REQUEST['cdt']) ? date('Y-m-d', strtotime($_REQUEST['cdt'])) : null;
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		if ($_REQUEST['pdf_ubayamreport'] == "PDF") {
			$file_name = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('frontend/report/pdf/ubayam_pdf', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_ubayamreport'] == "EXCEL") {
			$fileName = "Ubayam_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1');
			$sheet->setCellValue('A1', $data['temp_details']['name']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Date');
			$sheet->setCellValue('C2', 'Customer Name');
			$sheet->setCellValue('D2', 'Collection Date');
			$sheet->setCellValue('E2', 'Payfor');
			$sheet->setCellValue('F2', 'Amount');
			$rows = 3;
			$si = 1;
			$excel_format_data = $this->excel_format_get_ubayamreport($data['fdate'], $data['tdate'], $data['collection_date'], $data['fltername']);
			//var_dump($excel_format_data);
			//exit;
			foreach ($excel_format_data as $val) {
				$sheet->setCellValue('A' . $rows, $val['s_no']);
				$sheet->setCellValue('B' . $rows, $val['date']);
				$sheet->setCellValue('C' . $rows, $val['customer_name']);
				$sheet->setCellValue('D' . $rows, $val['collection_date']);
				$sheet->setCellValue('E' . $rows, $val['collection_name']);
				$sheet->setCellValue('F' . $rows, $val['amount']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('frontend/report/print/ubayam_print', $data);
		}
	}
	public function excel_format_get_ubayamreport($fdata, $tdata, $collectiondate, $fltername)
	{
		$fdt = date('Y-m-d', strtotime($fdata));
		$tdt = date('Y-m-d', strtotime($tdata));
		$collection_date = !empty($collection_date) ? date('Y-m-d', strtotime($collection_date)) : null;
		$flternameg = $fltername;
		$data = [];
		$dat = $this->db->table('prasadam')
			->select('prasadam.id,prasadam.date,prasadam.customer_name,prasadam.collection_date,prasadam.amount')
			->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") >=', $fdt);
		$dat = $dat->where('DATE_FORMAT(prasadam.date, "%Y-%m-%d") <=', $tdt);
		if(!empty($collection_date)){
			$dat = $dat->where('DATE_FORMAT(prasadam.collection_date, "%Y-%m-%d")=',$collection_date);
		}
		if ($fltername) {
			$dat = $dat->where('prasadam.customer_name', $fltername);
		}
		$dat = $dat->orderBy('prasadam.date', 'asc');
		$dat = $dat->get()->getResultArray();
		$i = 1;
		foreach ($dat as $row) {
			$payfors = $this->db->table('prasadam_booking_details')
			->join('prasadam_setting', 'prasadam_setting.id = prasadam_booking_details.prasadam_id')
			->select('prasadam_setting.name_eng,prasadam_setting.name_tamil, prasadam_booking_details.quantity')
			->where('prasadam_booking_details.prasadam_booking_id', $row['id'])
			->get()->getResultArray();
			$html = "";
			foreach($payfors as $payfor)
			{
				$html.=  $payfor['name_eng']." / ".$payfor['name_tamil']. ' - '. $payfor['quantity'] . '&';
			}
			$data[] = array(
				"s_no" => $i++,
				"date" => date('d-m-Y', strtotime($row['date'])),
				"customer_name" => $row['customer_name'],
				"amount" => $row['amount'],
				"collection_date" => date('d-m-Y', strtotime($row['collection_date'])),
				"collection_name" => $html
			);
		}
		return $data;
	}


}




























































