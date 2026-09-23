<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Member extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		if (!$this->model->list_validate('member')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('member');
		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*');

		$res = $qry->get()->getResultArray();
		$data['list'] = $res;
		// echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/index', $data);
		echo view('template/footer');
	}
	public function view()
	{
		if (!$this->model->permission_validate('member', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);


		$data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();

		$data['view'] = true;
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if (!$this->model->permission_validate('member', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		//$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
		//$data['data']['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['ledgers'] = $this->db->query("SELECT * FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (8000) or parent_id in (SELECT id FROM `groups` WHERE code in (8000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (8000))))")->getResultArray();
		$data['mode'] = 'add';
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}

	public function edit()
	{
		if (!$this->model->permission_validate('member', 'edit')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['mode'] = 'edit';
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/add', $data);
		echo view('template/footer');
	}
	public function findmembernoExists()
    {
		$member_no =  $this->request->getPost('member_no');
        $updateid = $this->request->getPost('update_id');
		if(!empty($updateid))
		{
			$query = $this->db->table('member')->where(['member_no' => $member_no,'id !=' => $updateid,'status'=>1])->countAllResults();
		}
        else
		{
			$query = $this->db->table('member')->where(['member_no' => $member_no,'status'=>1])->countAllResults();
		}
        if($query > 0){
            echo "false";
        }else{
            echo "true";
        }
    }
	public function save()
	{
		// echo '<pre>'; print_r($_POST); die;
		$id = $_POST['id'];


		$data['name'] = trim($_POST['name']);
		$data['member_type'] = trim($_POST['member_type']);
		$data['ic_no'] = trim($_POST['ic_number']);

		if(empty($_POST['edit_status'])){
			$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
			$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
			$data['mobile']  = $mble_phonecode.$mble_number;
		}
		else{
			$data['mobile'] = $_POST['mobile'];
		}
		if(!empty($_POST['ledger_id'])){
			$data['ledger_id'] = $_POST['ledger_id'];
		}
		$data['address'] = trim($_POST['address']);
		$data['joining_date'] = trim($_POST['start_date']);
		$data['start_date'] = trim($_POST['start_date']);
		// $data['end_date'] = date('Y-m-d', strtotime(trim($_POST['end_date'])));
		//ip location and ip details
		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$data['ip'] = $ip;
			$data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$data['ip_details'] = json_encode($ip_details);
		}

		if ($_POST['member_type'] === '3') { // Assuming 3 is the numerical value for 'Lifetime'
			$data['end_date'] = null;
		} else {
			$data['end_date'] = date('Y-m-d', strtotime(trim($_POST['end_date'])));
		}
		$data['payment'] = trim($_POST['payment']);
		$data['payment_mode'] = trim($_POST['paymentmode']);
		$data['status'] = $_POST['status'];
		$data['email_address'] = $_POST['email_address'];
		$data['added_by'] = $this->session->get('log_id');
		$data['payment_status'] = 2;
		$data['member_no'] = $_POST['member_no'];
		if (empty($id)) {
			//$query = $this->db->query("select max(member_no) as member_no from member")->getRowArray();
			//$data['member_no'] = sprintf("%06d", (((float) substr($query['member_no'], -5)) + 1));
			
			$data['created'] = date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->insert($data);
			if ($res) {
				$ins_id = $this->db->insertID();
				$this->account_migration($ins_id,$content="Member Registration");
				$this->send_whatsapp_msg($ins_id);
				if (!empty($_POST['email_address'])) {
					$temple_title = "Temple " . $_SESSION['site_title'];
					$mail_data['mem_id'] = $ins_id;
					$message = view('member/mail_template', $mail_data);
					$subject = $_SESSION['site_title'] . " Member Registration";
					$to_user = $_POST['email_address'];
					$to_mail = array("prithivitest@gmail.com", $to_user);
					send_mail_with_content($to_mail, $message, $subject, $temple_title);
				}
				$this->session->setFlashdata('succ', 'Member Added Successfully');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		} else {
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->where('id', $id)->update($data);
			if ($res) {
				$this->session->setFlashdata('succ', 'Member Updated Successfully');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		}
	}
	public function renewal_save()
	{
		$id = $_POST['id'];
		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$renewal_data['ip'] = $ip;
			$renewal_data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$renewal_data['ip_details'] = json_encode($ip_details);
		}
		if (!empty($id)) {
			$data['start_date'] = date('Y-m-d');
			$endDate = date("Y-m-d", strtotime("+1 year -1 day", strtotime($data['start_date'])));
			$data['end_date'] = $endDate;
			$data['status'] = 1;
			$data['renewal_status'] = 0;
			$data['added_by'] = $this->session->get('log_id');
			$data['payment_status'] = 2;
			$data['payment_mode'] = trim($_POST['paymentmode']);
			$data['modified'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member')->where('id', $id)->update($data);
			if ($res) {

				$renewal_data['member_id'] = $id;
				$renewal_data['renewal_start_date'] = date("Y-m-d");
				$renewal_data['renewal_end_date'] = $endDate;
				$this->db->table('member_renewal')->insert($renewal_data);

				$this->account_migration($id,$content="Member Renewal");
				//$this->send_whatsapp_msg($id);
				if (!empty($_POST['email_address'])) {
					$temple_title = "Temple " . $_SESSION['site_title'];
					$mail_data['mem_id'] = $id;
					$message = view('member/mail_template', $mail_data);
					$subject = $_SESSION['site_title'] . " Member Renewal";
					$to_user = $_POST['email_address'];
					$to_mail = array("prithivitest@gmail.com", $to_user);
					send_mail_with_content($to_mail, $message, $subject, $temple_title);
				}
				$this->session->setFlashdata('succ', 'Member Renewal Successfully completed');
				header("Location: " . base_url() . "/member");
			} else {
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: " . base_url() . "/member");
			}
		}
	}
	public function account_migration($member_id,$content)
	{
		$member_datas = $this->db->table('member')->where('id', $member_id)->get()->getRowArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', 3)->get()->getRowArray();
		if (empty($payment_mode_details['id']))
			$payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
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
		// Debit ledger
		if(!empty($member_datas['ledger_id'])){
			$dr_id = $member_datas['ledger_id'];
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
		if (!empty($member_datas['payment'])) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
			if (empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$entry_date = date('Y-m-d');
			$yr = date('Y', $entry_date);
			$mon = date('m', $entry_date);
			$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
			$entries['entry_code'] = 'REC' . date('y', strtotime($entry_date)) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));

			$entries['entrytype_id'] = '1';
			$entries['number'] = $num;
			$entries['date'] = $member_datas['start_date'];

			$entries['dr_total'] = $member_datas['payment'];
			$entries['cr_total'] = $member_datas['payment'];
			$entries['narration'] = $content;
			$entries['inv_id'] = $member_id;
			$entries['type'] = '11';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			if (!empty($en_id)) {
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $member_datas['payment'];
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_c['amount'] = $member_datas['payment'];
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
			}
			return true;
		} else
			return false;
	}
	public function delete()
	{
		if (!$this->model->permission_validate('member', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('ubayam')->delete(['id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Ubayam Deleted Successfully');
			header("Location: " . base_url() . "/ubayam");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/ubayam");
		}
		header("Location: " . base_url() . "/ubayam");

	}
	public function renewal_report()
	{
		if (!$this->model->list_validate('member')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('member');
		
		$data['list'] = $res;
		// echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal_report', $data);
		echo view('template/footer');
	}
	public function get_renewal_report()
	{
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$qry = $this->db->table('member', 'member_type.name as tname')
						->join('member_type', 'member_type.id = member.member_type')
						->join('member_renewal', 'member_renewal.member_id = member.id')
						->select('member_type.name as tname,member_renewal.renewal_end_date,member_renewal.renewal_start_date')
						->select('member.*')
						->where('member_renewal.renewal_start_date >=',$fdata)
						->where('member_renewal.renewal_start_date <=',$tdata);
		$res = $qry->get()->getResultArray();
		$i = 1;
		$data = array();
		if (!empty($res)) {
			foreach ($res as $r) {
				$data[] = array(
					$i++,
					$r['name'],
					$r['member_no'],
					$r['tname'],
					date('d/m/Y', strtotime($r['renewal_start_date'])),
					date('d/m/Y', strtotime($r['renewal_end_date'])),
					$r['payment']
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
	public function print_renewalreport()
	{
		if (!$this->model->list_validate('member')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['fdate'] = $_REQUEST['fdt'];
		$data['tdate'] = $_REQUEST['tdt'];
		$fdata = $_REQUEST['fdt'];
		$tdata = $_REQUEST['tdt'];
		$i = 0;
		$qry = $this->db->table('member', 'member_type.name as tname')
						->join('member_type', 'member_type.id = member.member_type')
						->join('member_renewal', 'member_renewal.member_id = member.id')
						->select('member_type.name as tname,member_renewal.renewal_end_date,member_renewal.renewal_start_date')
						->select('member.*')
						->where('member_renewal.renewal_start_date >=',$fdata)
						->where('member_renewal.renewal_start_date <=',$tdata);
		$res = $qry->get()->getResultArray();
		$data['member_data'] = $res;
		if ($_REQUEST['pdf_renewalreport'] == "PDF") {
			$file_name = "Member_Renewal_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('member/pdf/member_renewal_print', ["pdfdata" => $data]), 'UTF-8');
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} elseif ($_REQUEST['excel_renewalreport'] == "EXCEL") {
			$fileName = "Member_Renewal_Report_" . $data['fdate'] . "_to_" . $data['tdate'];
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:G1")->applyFromArray($style);
			$sheet->mergeCells('A1:G1');
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Member Name');
			$sheet->setCellValue('C2', 'Member No');
			$sheet->setCellValue('D2', 'Member Type');
			$sheet->setCellValue('E2', 'Renewal Start Date');
			$sheet->setCellValue('F2', 'Renewal End Date');
			$sheet->setCellValue('G2', 'Amount');
			$rows = 3;
			$si = 1;
			if(count($data['member_data']) > 0){
				foreach ($data['member_data'] as $val) {
					$sheet->setCellValue('A' . $rows, $si);
					$sheet->setCellValue('B' . $rows, $val['name']);
					$sheet->setCellValue('C' . $rows, $val['member_no']);
					$sheet->setCellValue('D' . $rows, $val['tname']);
					$sheet->setCellValue('E' . $rows, date('d/m/Y', strtotime($val['renewal_start_date'])));
					$sheet->setCellValue('F' . $rows, date('d/m/Y', strtotime($val['renewal_end_date'])));
					$sheet->setCellValue('G' . $rows, $val['payment']);
					$rows++;
					$si++;
				}
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('member/member_renewal_print', $data);
		}
	}
	public function get_member_amount()
	{
		$id = $_POST['id'];
		$data = $this->db->table('member_type')->select('amount')->where('id', $id)->get()->getRowArray();
		echo json_encode($data);
	}
	public function print_page()
	{
		if (!$this->model->permission_validate('member', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*')
			->where("member.id", $id);

		$res = $qry->get()->getRowArray();

		$data['qry1'] = $res;
		echo view('member/print_page', $data);
	}

	public function renewal_page()
	{

		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();


		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal_page', $data);
		echo view('template/footer');
	}

	public function renewal()
	{
		$currentDate = date("Y-m-d");

		// Deactivate members with end date below the current date
		$this->db->table('member')
			->where('end_date <', $currentDate)
			->where('status', 1)
			->update(['renewal_status' => 1,'status' => 0]);

		// Retrieve inactive members for display
		$query = $this->db->table('member')
			->where('renewal_status', 1)
			->get();
		$data['inactiveMembers'] = $query->getResultArray();

		// Load the view with the data
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member/renewal', $data);
		echo view('template/footer');
	}



	public function cron()
	{
		// Load the database library
		$db = \Config\Database::connect();

		// Get the current date
		$currentDate = date("Y-m-d");

		// Query to retrieve active members whose end date is before the current date
		$query = $db->query("SELECT * FROM member WHERE end_date < '$currentDate' AND status = 1");

		// Deactivate members
		foreach ($query->getResultArray() as $row) {
			$memberId = $row['id']; // replace 'id' with your actual primary key field
			$db->table('member')->set('status', 2)->where('id', $memberId)->update();
		}

		echo "Cron job executed successfully.";
	}
	public function send_whatsapp_msg($id)
	{
		$tmpid = 1;
		$data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$qry = $this->db->table('member', 'member_type.name as tname')
			->join('member_type', 'member_type.id = member.member_type')
			->select('member_type.name as tname')
			->select('member.*')
			->where("member.id", $id);
		$member = $qry->get()->getRowArray();

		$data['qry1'] = $member;
		if (!empty($member['mobile'])) {
			$html = view('member/pdf', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled' => true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/member_card_' . $id . '.pdf';

			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$message_params[] = $member['name'];
			$message_params[] = $member['tname'];
			$message_params[] = $member['member_no'];
			$message_params[] = date('d M, Y', strtotime($member['start_date']));
			$media['url'] = base_url() . '/uploads/documents/member_card_' . $id . '.pdf';
			$media['filename'] = 'member_card.pdf';
			$mobile_number = $member['mobile'];
			//$mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'member_reg_live', $media);
			//print_r($whatsapp_resp);
			//echo $whatsapp_resp['success'];
			/* if($whatsapp_resp['success']) 
					 //echo 'success';
					 echo view('hallbooking/whatsapp_resp_suc');
					 else 
					 //echo 'fail'; 
					 echo view('hallbooking/whatsapp_resp_fail'); */
		}
	}

}