<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\RequestModel;

class Rental extends BaseController
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 10000);
		ini_set('max_input_time', 12000);
		helper('url');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		$data['rentals'] = $this->db->table('rental')->select("rental.*, property_category.name, properties.name as propertyname")->join("properties", "properties.id = rental.property_id", "inner")->join("property_category", "property_category.id = properties.property_category_id", "inner")->get()->getResultArray();
		//echo "<pre>"; print_r($data); exit();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/list', $data);
		echo view('template/footer');
	}

	public function add()
	{
		$data['property_lists'] = $this->db->query("SELECT id,name FROM properties where id in (SELECT property_id  FROM tennant WHERE status = 1)")->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')
			->select('payment_mode.name,payment_mode.id')
			->where('payment_mode.status', 1)
			->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/add', $data);
		echo view('template/footer');
	}
	public function edit($id)
	{
		$data['property_lists'] = $this->db->query("SELECT id,name FROM properties where id in (SELECT property_id  FROM tennant WHERE status = 1)")->getResultArray();
		$data['rental'] = $this->db->table('rental')->where("id", $id)->get()->getRowArray();
		$data['payment'] = $this->db->table('rental_pay_details')->where('rental_id', $id)->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')
			->select('payment_mode.name,payment_mode.id')
			->where('payment_mode.status', 1)
			->get()->getResultArray();
		$rental_id = $data['rental']['property_id'];
		$res = $this->db->query("SELECT properties.rental_value as amount,tennant.address,tennant.name as payee_name FROM `properties` LEFT JOIN tennant ON tennant.property_id = properties.id WHERE tennant.status = 1 AND properties.id = '$rental_id' ")->getRowArray();
		$data['rental_amt'] = !empty($res['amount']) ? $res['amount'] : 0;
		$data['view'] = true;
		//echo "<pre>"; print_r($data); exit();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/add', $data);
		echo view('template/footer');
	}
	public function print($id)
	{
		$data['rental'] = $this->db->table('rental')
			->join('properties', 'rental.property_id = properties.id')
			->select('rental.*,properties.lot_no,properties.area')
			->where("rental.id", $id)
			->get()
			->getRowArray();
		$data['pay_details'] = $this->db->table("rental_pay_details")->where("rental_id", $id)->get()->getResultArray();
		echo view('rental/print', $data);
	}

	public function store()
	{

		$id = $_POST['id'];
		$data['property_id'] = $_POST['property_id'];
		$data['month_year'] = $_POST['rental_monthyear'];
		$data['amount'] = $_POST['rental_amount'];
		$data['payee_name'] = $_POST['rental_paynee_name'];
		$data['payee_description'] = $_POST['rental_description'];

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

		if (empty($id)) {
			$data['created_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('rental')->insert($data);
			$insert_id = $this->db->insertID();
		} else {
			$data['updated_at'] = date('Y-m-d H:i:s');
			$builder = $this->db->table('rental')->where('id', $id)->update($data);
			$insert_id = $id;
		}

		if (!empty($insert_id) && !empty($_POST['property_id'])) {

			$directincome_group = $this->db->table('groups')->where('name', 'Sales')->where('parent_id', 26)->get()->getRowArray();
			if (!empty($directincome_group)) {
				$dic_id = $directincome_group['id'];
			} else {
				$dic1['parent_id'] = 26;
				$dic1['name'] = 'Sales';
				$dic1['code'] = '330';
				$dic1['added_by'] = $this->session->get('log_id');
				$this->db->table('groups')->insert($dic1);
				$dic_id = $this->db->insertID();
			}
			// Rendal ledger
			$rental_ledger = $this->db->table('ledgers')->where('name', 'RENTAL RECEIVED')->where('left_code', '7003')->where('group_id', $dic_id)->get()->getRowArray();
			if (!empty($rental_ledger)) {
				$rr_id = $rental_ledger['id'];
			} else {
				$led1['group_id'] = $dic_id;
				$led1['name'] = 'RENTAL RECEIVED';
				$led1['code'] = '7003/000';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led1['left_code'] = '7003';
				$led1['right_code'] = '000';
				$this->db->table('ledgers')->insert($led1);
				$rr_id = $this->db->insertID();
			}
			$cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
			if (!empty($cashinhand)) {
				$cih_id = $cashinhand['id'];
			} else {
				$cih1['parent_id'] = 3;
				$cih1['name'] = 'Cash-in-Hand';
				$cih1['code'] = '111';
				$cih1['added_by'] = $this->session->get('log_id');
				$this->db->table('ledgers')->insert($cih1);
				$cih_id = $this->db->insertID();
			}
			$ledger2 = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
			if (!empty($ledger2)) {
				$cr_id1 = $ledger2['id'];
			} else {
				$cled1['group_id'] = $cih_id;
				$cled1['name'] = 'PETTY CASH';
				$cled1['op_balance'] = '0';
				$cled1['op_balance_dc'] = 'C';
				$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
				$cr_id1 = $this->db->insertID();
			}
			//$prop_data = $this->db->table('properties')->where('id', $_POST['property_id'])->get()->getResultArray();
			//$temple_id = $prop_data['temple_id'];
			if (!empty($_POST['pay'])) {

				foreach ($_POST['pay'] as $row) {
					if (empty($row['id']) && $row['id'] == "") {
						$rents['rental_id'] = $insert_id;
						$rents['date'] = date("Y-m-d", strtotime($row['date']));
						$rents['amount'] = $row['pay_amt'];
						$rents['payment_mode'] = $row['payment_mode'];
						//Payment Mode Details
						$payment_mode_details = $this->db->table('payment_mode')->where('id', $rents['payment_mode'])->get()->getRowArray();
						$rnpay = $this->db->table('rental_pay_details')->insert($rents);

						if ($rnpay) {
							$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id', 'desc')->get()->getRowArray();
							if (empty($number)) {
								$num = 1;
							} else {
								$num = $number['number'] + 1;
							}
							$date = explode('-', date("Y-m-d", strtotime($row['date'])));
							$yr = $date[0];
							$mon = $date[1];
							$qry = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='" . $yr . "' and entrytype_id =1 and month (date)='" . $mon . "')")->getRowArray();
							$entries['entry_code'] = 'REC' . date('y', strtotime($row['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
							$entries['entrytype_id'] = '1';
							$entries['number'] = $num;
							$entries['date'] = date("Y-m-d", strtotime($row['date']));
							$entries['dr_total'] = $row['pay_amt'];
							$entries['cr_total'] = $row['pay_amt'];
							$entries['narration'] = 'Rental';
							$entries['inv_id'] = $insert_id;
							$entries['type'] = '1';
							$ent = $this->db->table('entries')->insert($entries);
							$en_id = $this->db->insertID();
							if (!empty($en_id)) {
								$eitems_d['entry_id'] = $en_id;
								$eitems_d['ledger_id'] = $rr_id;
								$eitems_d['amount'] = $row['pay_amt'];
								$eitems_d['dc'] = 'C';
								$cr_res = $this->db->table('entryitems')->insert($eitems_d);

								$eitems_c['entry_id'] = $en_id;
								$eitems_c['ledger_id'] = $row['payment_mode'];
								$eitems_c['amount'] = $row['pay_amt'];
								$eitems_c['dc'] = 'D';
								$deb_res = $this->db->table('entryitems')->insert($eitems_c);
							}
							//var_dump($en_id);
							//exit;
						}
					}
				}
			}
		}

		$this->session->setFlashdata('succ', 'Rental Data Created Successfully');
		return redirect()->to("/rental");


	}
	public function get_payment_mode()
	{
		$id = $_POST['id'];
		$res = $this->db->table("payment_mode")->where("id", $id)->get()->getRowArray();
		$ledger_id = $res['ledger_id'];
		$name = $res['name'];
		$data['ledger_id'] = $ledger_id;
		$data['name'] = $name;
		echo json_encode($data);
	}
	public function findpropertyNameExists()
	{
		$property_id = $this->request->getPost('property_id');
		$rental_monthyear = $this->request->getPost('rental_monthyear');
		$updateid = $this->request->getPost('update_id');
		if (!empty($updateid)) {
			$query = $this->db->table('rental')->where(['property_id' => $property_id, 'month_year' => $rental_monthyear, 'id !=' => $updateid])->countAllResults();
		} else {
			$query = $this->db->table('rental')->where(['property_id' => $property_id, 'month_year' => $rental_monthyear])->countAllResults();
		}
		if ($query > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}
	public function print_rental()
	{
		$data = array();
		$res = $this->db->table('rental')->select("rental.*, property_category.name")->join("properties", "properties.id = rental.property_id", "inner")->join("property_category", "property_category.id = properties.property_category_id", "inner")->get()->getResultArray();

		$data['data'] = $res;
		if ($_REQUEST['pdf_data'] == "PDF") {
			$file_name = "rental_" . date("dmY");
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions();
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);
			$dompdf->loadHtml(view('rental/pdf/rental_print', ["pdfdata" => $data]));
			$dompdf->setPaper('LEGAL', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		} else if ($_REQUEST["excel_data"] == "EXCEL") {
			$fileName = "rental_" . date("dmY");
			$spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->getStyle("A1:E1")->applyFromArray($style);
			$sheet->getStyle("A2:E2")->applyFromArray($style);
			$sheet->mergeCells('A1:E1');
			$sheet->mergeCells('A2:E2');
			$sheet->setCellValue('A1', "");
			$sheet->setCellValue('A2', 'RENTAL LIST');

			$sheet->setCellValue('A4', "SNo");
			$sheet->setCellValue('B4', "Property Name");
			$sheet->setCellValue('C4', "Month / Year");
			$sheet->setCellValue('D4', "Amount");
			$sheet->setCellValue('E4', "Payee Name");

			$rows = 5;
			$i = 1;
			foreach ($data['data'] as $key => $row) {
				$sheet->setCellValue('A' . $rows, $i);
				$sheet->setCellValue('B' . $rows, $row['name']);
				$sheet->setCellValue('C' . $rows, $row['month_year']);
				$sheet->setCellValue('D' . $rows, $row['amount']);
				$sheet->setCellValue('E' . $rows, $row['payee_name']);
				$rows++;
				$i++;
			}

			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
		} else {
			echo view('rental/print/rental_print', $data);
		}
	}
	public function get_properties_amount()
	{
		if (!empty($_POST['prop_id'])) {
			$id = $_POST['prop_id'];
			$res = $this->db->query("SELECT properties.rental_value as amount,tennant.address,tennant.name as payee_name FROM `properties` LEFT JOIN tennant ON tennant.property_id = properties.id WHERE tennant.status = 1 AND properties.id = '$id' ")->getRowArray();
			$amount_val = !empty($res['amount']) ? $res['amount'] : 0;
			$address = !empty($res['address']) ? $res['address'] : "";
			$payee_name = !empty($res['payee_name']) ? $res['payee_name'] : "";
		}
		$json_resp = array("amount" => $amount_val, "address" => $address, "payee_name" => $payee_name);
		echo json_encode($json_resp);
		exit;
	}
	public function default_list()
	{
		//rental_value
		if ($_POST['rental_monthyear'])
			$rental_monthyear = $_POST['rental_monthyear'];
		else
			$rental_monthyear = date("m/Y");
		$convert_date = explode("/", $rental_monthyear);
		$str_to_date_convert = $convert_date[1] . "-" . $convert_date[0];
		//echo $str_to_date_convert;
		$datalist = $this->db->query("SELECT tennant.phone as phone_no,tennant.name as tennant_name, properties.id as property_id, properties.name as property_name,properties.rental_value as amount FROM properties JOIN tennant ON tennant.property_id = properties.id WHERE '$str_to_date_convert' BETWEEN DATE_FORMAT(tennant.start_date,'%Y-%m') AND DATE_FORMAT(tennant.end_date,'%Y-%m') AND tennant.status = 1 ")->getResultArray();
		$retn_array = array();
		foreach ($datalist as $roww) {
			$paid_rental = $this->db->table("rental")->join('rental_pay_details', 'rental_pay_details.rental_id = rental.id')->select('SUM(rental_pay_details.amount) as paidamt')->where("rental.property_id", $roww['property_id'])->where("rental.month_year", $rental_monthyear)->groupBy('rental_pay_details.rental_id')->get()->getRowArray();
			//echo $paid_rental['paidamt'];
			//echo $roww['amount'];
			if (floatval($paid_rental['paidamt']) == floatval($roww['amount']) || floatval($paid_rental['paidamt']) > floatval($roww['amount'])) {
				//echo "Full Paid";
			} else {
				//echo "Half Paid";
				$pending_amt = $roww['amount'] - $paid_rental['paidamt'];
				$due_date = $str_to_date_convert . "-01";
				$converted_month = date("M", strtotime($due_date));
				$retn_array[] = array("phone_no" => $roww['phone_no'], "tennant_name" => $roww['tennant_name'], "property_id" => $roww['property_id'], "property_name" => $roww['property_name'], "amount" => $roww['amount'], "pending_amount" => $pending_amt, "due_month" => $converted_month);
			}
		}
		//echo $rental_monthyear;
		//exit;
		$data['list'] = $retn_array;
		//exit;
		//echo $this->db->getLastQuery(); die;
		$data['rental_monthyear'] = $rental_monthyear;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('rental/default_list', $data);
		echo view('template/footer');
	}


}