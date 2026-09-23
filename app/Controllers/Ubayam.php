<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\RequestModel;

class Ubayam extends BaseController
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
		if (!$this->model->list_validate('ubayam')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$date = !empty($_REQUEST['date']) ? $_REQUEST['date'] : "";
		$data['permission'] = $this->model->get_permission('ubayam');
		$data['date'] = $date;
		if ($date) {
			$data['list'] = $this->db->table('ubayam', 'ubayam_setting.name as pname')
				->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
				->select('ubayam_setting.name as pname')
				->select('ubayam.*')
				->where('dt', $date)
				->orderBy('dt', 'DESC')
				->orderBy('created_at', 'DESC')
				->get()->getResultArray();
		} else {
			$data['list'] = $this->db->table('ubayam', 'ubayam_setting.name as pname')
				->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
				->select('ubayam_setting.name as pname')
				->select('ubayam.*')
				->orderBy('dt', 'DESC')
				->orderBy('created_at', 'DESC')
				->get()->getResultArray();
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('ubayam/index', $data);
		echo view('template/footer');
	}
	public function view()
	{
		if (!$this->model->permission_validate('ubayam', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ubayam')->where('id', $id)->get()->getRowArray();
		$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['family'] = $this->db->table('ubayam_family_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['sett_data'] = $this->db->table('ubayam_setting')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['view'] = true;
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('ubayam/add', $data);
		echo view('template/footer');
	}
	
	public function ubayam_new()
	{
		if (!$this->model->permission_validate('ubayam', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['sett_data'] = $this->db->query("select * from ubayam_setting where ubayam_date is null or ubayam_date = 0 or ubayam_date = '' or ubayam_date = '$date'")->getResultArray();
		$data['res'] = $this->db->table('ubayam')->select('id')->orderBy('id', 'desc')->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		//print_r($data['id']); exit();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('ubayam/add_new', $data);
		echo view('template/footer');
	}
	
	public function add()
	{
		if (!$this->model->permission_validate('ubayam', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$date = !empty($_REQUEST['date']) ? $_REQUEST['date'] : "";
		$data['date'] = $date;
		$data['sett_data'] = $this->db->query("select * from ubayam_setting where ubayam_date is null or ubayam_date = 0 or ubayam_date = '' or ubayam_date = '$date'")->getResultArray();
		$data['res'] = $this->db->table('ubayam')->select('id')->orderBy('id', 'desc')->get()->getRowArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		//print_r($data['id']); exit();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('ubayam/add', $data);
		echo view('template/footer');
	}
	public function get_payment_mode()
	{
		$id = $_POST['id'];
		$res = $this->db->table("payment_mode")->where("id", $id)->get()->getRowArray();
		$name = $res['name'];
		$data['name'] = $name;
		echo json_encode($data);
	}
	public function edit()
	{
		// if(!$this->model->permission_validate('ubayam','edit')){
		// 	header('Location: '.base_url().'/dashboard');			
		// }
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ubayam')->where('id', $id)->get()->getRowArray();
		$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['family'] = $this->db->table('ubayam_family_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['sett_data'] = $this->db->table('ubayam_setting')->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->where('paid_through', 'DIRECT')->get()->getResultArray();
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('ubayam/edit', $data);
		echo view('template/footer');
	}

	public function save()
	{
		$email = \Config\Services::email();
		$id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['dt']);
		$yr = $date[2];
		$mon = $date[1];
		$query = $this->db->query("SELECT ref_no FROM ubayam where id=(select max(id) from ubayam where year (dt)='" . $yr . "' and month (dt)='" . $mon . "')")->getRowArray();
		$data['ref_no'] = 'UB' . date('y') . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['dt'] = date("Y-m-d",strtotime($_POST['dt']));
		$data['ubayam_date'] = date("Y-m-d",strtotime($_POST['ubhayam_date']));
		$data['pay_for'] = trim($_POST['pay_for']);
		$data['name'] = trim($_POST['name']);
		$data['address'] = trim($_POST['address']);
		$data['ic_number'] = trim($_POST['ic_number']);

		if(empty($_POST['edit_status'])){
			$mble_phonecode = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
			$mble_number = !empty($_POST['mobile'])?$_POST['mobile']:"";
			$data['mobile']  = $mble_phonecode.$mble_number;
		}
		else{
			$data['mobile'] = $_POST['mobile'];
		}
		
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		$data['paidamount'] = trim($_POST['paid_amount']);
		$data['balanceamount'] = trim($_POST['balance_amount']);
		$data['email'] = $_POST['email'];
		$data['added_by'] = $this->session->get('log_id');


		//echo '<pre>';
		//print_r($data);
		//exit;

		$ip = 'unknown';
		$this->requestmodel = new RequestModel();
		$ip = $this->requestmodel->getIpAddress();
		if ($ip != 'unknown') {
			$ip_details = $this->requestmodel->getLocation($ip);
			$data['ip'] = $ip;
			$data['ip_location'] = (!empty($ip_details['country']) ? $ip_details['country'] : 'Unknown');
			$data['ip_details'] = json_encode($ip_details);
		}

		try {
			if (!empty($data['pay_for']) && !empty($data['name']) && !empty($data['amount']) && !empty($data['dt']) && $data['amount'] > 0) {
				// debit ledger
				// Individual Ledger
				/* $ledger = $this->db->table('ledgers')->where('name', 'UBAYAM FEE')->where('group_id', 29)->where('left_code', '6003')->get()->getRowArray();
				if (!empty($ledger)) {
					$dr_id = $ledger['id'];
				} else {
					$led['group_id'] = 29;
					$led['name'] = 'UBAYAM FEE';
					$led['left_code'] = '6003';
					$led['right_code'] = '000';
					$led['op_balance'] = '0';
					$led['op_balance_dc'] = 'D';
					$led_ins = $this->db->table('ledgers')->insert($led);
					$dr_id = $this->db->insertID();
				} */
				// Individual Ledger
				$sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
				if(!empty($sales_group)){
					$sls_id = $sales_group['id'];
				}else{
					$sls1['parent_id'] = 0;
					$sls1['name'] = 'Sales';
					$sls1['code'] = '4000';
					$sls1['added_by'] = $this->session->get('log_id');
					$led_ins1 = $this->db->table('groups')->insert($sls1);
					$sls_id = $this->db->insertID();
				}
				// Separate Ledger
				$ubayam_setting = $this->db->table('ubayam_setting')->where('id', $data['pay_for'])->get()->getRowArray();
				$ubayam_name = $ubayam_setting['name'];
				if(!empty($ubayam_setting['ledger_id'])){
					$dr_id = $ubayam_setting['ledger_id'];
				}else{
					$ledger1 = $this->db->table('ledgers')->where('name', 'All Sales')->where('group_id', $sls_id)->get()->getRowArray();
					if(!empty($ledger1)){
						$dr_id = $ledger1['id'];
					}else{
						$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '4913')->orderBy('right_code','desc')->get()->getRowArray();
						$set_right_code = (int) $right_code['right_code'] + 1;
						$set_right_code = sprintf("%04d", $set_right_code);
						$led1['group_id'] = $sls_id;
						$led1['name'] = 'All Sales';
						$led1['left_code'] = '4913';
						$led1['right_code'] = $set_right_code;
						$led1['op_balance'] = '0';
						$led1['op_balance_dc'] = 'D';
						$led_ins1 = $this->db->table('ledgers')->insert($led1);
						$dr_id = $this->db->insertID();
					}
				}
				// Separate Ledger

				if (empty($id)) {
					$data['created_at'] = date('Y-m-d H:i:s');
					$data['modified_at'] = date('Y-m-d H:i:s');
					$res = $this->db->table('ubayam')->insert($data);
					//$whatsapp_resp = whatsapp_aisensy($data['mobile'], [], 'success_message1');
					if ($res) {
						$ins_id = $this->db->insertID();
						if (!empty($data['mobile'])) {
							$users_all_data = array();
							if (substr($data['mobile'], 0, 1) == '+') {
								$users_all_data['mobile'] = substr($data['mobile'], 3);
								$users_all_data['country_phone_code'] = substr($data['mobile'], 0, 3);
							} else {
								$users_all_data['mobile'] = $data['mobile'];
								$users_all_data['country_phone_code'] = '+61';
							}
							$users_all_data['name'] = $data['name'];
							$users_all_data['address'] = $data['address'];
							$users_all_data['nric'] = $data['ic_number'];
							$users_all_data['email'] = $data['email'];
							sync_users_all_tag($users_all_data, 3);
						}
						if (!empty($dr_id)) {
							$err = 0;
							$succ = 0;
							foreach ($_POST['pay'] as $row) {
								$pays['ubayam_id'] = $ins_id;
								$pays['date'] = date("Y-m-d", strtotime($row['date']));
								$pays['amount'] = $row['pay_amt'];
								$pays['payment_mode'] = $row['payment_mode'];
								$ubpay = $this->db->table('ubayam_pay_details')->insert($pays);
								if ($ubpay) {
									if (!empty($pays['payment_mode'])) {
										$payment_mode_details = $this->db->table('payment_mode')->where('id', $pays['payment_mode'])->get()->getRowArray();
										$cr_id = $payment_mode_details['ledger_id'];
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
										$entries['entry_code'] = 'REC' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
										$entries['entrytype_id'] = '1';
										$entries['number'] = $num;
										$entries['date'] = date("Y-m-d", strtotime($row['date']));
										$entries['dr_total'] = $row['pay_amt'];
										$entries['cr_total'] = $row['pay_amt'];
										$entries['narration'] = 'Ubayam(' . $data['ref_no'] . ')' . "\n" . 'name:' . $data['name'] . "\n" . 'NRIC:' . $data['ic_number'] . "\n" . 'email:' . $data['email'] . "\n";
										$entries['inv_id'] = $ins_id;
										$entries['type'] = '1';
										$ent = $this->db->table('entries')->insert($entries);
										$en_id = $this->db->insertID();

										if (!empty($en_id)) {
											$ent_id[] = $en_id;
											$eitems_d['entry_id'] = $en_id;
											$eitems_d['ledger_id'] = $dr_id;
											$eitems_d['amount'] = $row['pay_amt'];
											$eitems_d['details'] = 'Ubayam(' . $data['ref_no'] . ')';
											$eitems_d['dc'] = 'C';
											$cr_res = $this->db->table('entryitems')->insert($eitems_d);

											$eitems_c['entry_id'] = $en_id;
											$eitems_c['ledger_id'] = $cr_id;
											$eitems_c['amount'] = $row['pay_amt'];
											$eitems_c['details'] = 'Ubayam(' . $data['ref_no'] . ')';
											$eitems_d['dc'] = 'C';
											$eitems_c['dc'] = 'D';
											$deb_res = $this->db->table('entryitems')->insert($eitems_c);
											if ($cr_res && $deb_res)
												$succ++;
											else
												$err++;
										} else {
											$err++;
										}
									}
								} else {
									$err++;
								}
							}
							if (!empty($_POST['familly'])) {
								foreach ($_POST['familly'] as $row_fam) {
									$fmys['ubayam_id'] = $ins_id;
									$fmys['name'] = $row_fam['name'];
									$fmys['icno'] = $row_fam['icno'];
									$fmys['relationship'] = $row_fam['relationship'];
									$this->db->table('ubayam_family_details')->insert($fmys);
								}
							}
							if ($err) {
								foreach ($ent_id as $rowid) {
									$this->db->table('entryitems')->delete(['entry_id' => $rowid]);
									$this->db->table('entries')->delete(['id' => $rowid]);
								}
								$this->db->table('ubayam_pay_details')->delete(['ubayam_id' => $ins_id]);
								$this->db->table('ubayam')->delete(['id' => $ins_id]);
								$msg_data['err'] = 'Please Try Again';
							} else {
								$this->send_whatsapp_msg($ins_id);
								if (!empty($_POST['email'])) {
									$temple_title = "Temple " . $_SESSION['site_title'];
									$qr_url = base_url() . "/ubayam/reg/";
									$tmpid = 1;
									$temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
									$mail_data['qr_image'] = qrcode_generation($ins_id, $qr_url);
									$mail_data['ubm_id'] = $ins_id;
									$mail_data['temple_details'] = $temple_details;
									$message = view('ubayam/mail_template', $mail_data);
									$to = $_POST['email'];
									$subject = $_SESSION['site_title'] . " Ubayam Voucher";
									$to_mail = array("prithivitest@gmail.com", $to);
									send_mail_with_content($to_mail, $message, $subject, $temple_title);
								}
								$msg_data['succ'] = 'Ubayam Added Successflly';
								$msg_data['id'] = $ins_id;
							}
						} else {
							$this->db->table('ubayam')->delete(['id' => $ins_id]);
							$msg_data['err'] = 'Please Try Again Ledger is empty';
						}
					} else {
						$msg_data['err'] = 'Please Try Again';
					}
				}
			} else {
				$msg_data['err'] = 'Please Fill Required Field';
			}
		} catch (Exception $e) {

			$msg_data['err'] = 'Exception Message: ' . $e->getMessage();

		}
		echo json_encode($msg_data);
		exit;
	}
	public function reg()
	{
		echo "welcome";
	}
	public function delete()
	{
		if (!$this->model->permission_validate('ubayam', 'delete_p')) {
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

	public function print_page()
	{
		if (!$this->model->permission_validate('ubayam', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		// echo  $id;
		//  exit ;
		$data['qry1'] = $this->db->table('ubayam')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as uname')
			->select('ubayam.*')
			->where('ubayam.id', $id)
			->get()->getRowArray();
		$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
		echo view('ubayam/print_page', $data);
	}


	public function ubayam_calendar()
	{
		if (!$this->model->list_validate('ubayam')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('ubayam/calender');
		echo view('template/footer');
	}

	public function ubayam_list()
	{
		// $query = $this->db->query("select ubayam.dt as date, ubayam_setting.name as name from `ubayam` left join ubayam_setting on ubayam.pay_for = ubayam_setting.id GROUP BY ubayam.dt HAVING COUNT(ubayam.dt) > 0"); 
		$query = $this->db->query("select ubayam.ubayam_date as date, ubayam_setting.name as name from `ubayam` left join ubayam_setting on ubayam.pay_for = ubayam_setting.id GROUP BY  ubayam.ubayam_date, ubayam.pay_for HAVING  count(ubayam.pay_for) > 0");
		$res = $query->getResultArray();
		echo json_encode($res);
	}
	public function get_payfor_collection()
	{
		$id = $_POST['id'];
		$res = $this->db->table('ubayam_setting')->where('id', $id)->get()->getRowArray();
		$data['target_amount'] = $res['amount'];
		$data['balanceamt'] = $res['amount'];
		$res = $this->db->table('ubayam')->select('id')->where('pay_for', $id)->get()->getResultArray();
		$data['totalamt'] = 0;
		$data['collection'] = 0;
		if (count($res)) {
			foreach ($res as $row) {
				$array[] = $row['id'];
			}
			$pid = implode(',', $array);
			$res1 = $this->db->query("select sum(amount) as totalamt from `ubayam` where id in ($pid)")->getRowArray();
			$res2 = $this->db->query("select sum(amount) as collection from `ubayam_pay_details` where ubayam_id in ($pid)")->getRowArray();
			$data['totalamt'] = number_format($res1['totalamt'], 2, '.', ',');
			$data['collection'] = number_format($res2['collection'], 2, '.', ',');
			$balance = $data['target_amount'] - $res2['collection'];
			if ($balance > 0)
				$data['balanceamt'] = number_format($balance, 2, '.', ',');
			else
				$data['balanceamt'] = 0;
		}
		echo json_encode($data);
	}

	public function update()
	{
		$id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		// $date = explode('-', $_POST['dt']);
		// $yr = $date[0];
		// $mon = $date[1];
		// $query   = $this->db->query("SELECT ref_no FROM ubayam where id=(select max(id) from ubayam where year (dt)='". $yr ."' and month (dt)='". $mon ."')")->getRowArray();
		// $data['ref_no']= 'UB' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$data['dt'] = date("Y-m-d",strtotime($_POST['dt']));
		// $data['pay_for']	 	=	trim($_POST['pay_for']);
		$data['name'] = trim($_POST['name']);
		$data['address'] = trim($_POST['address']);
		$data['ic_number'] = trim($_POST['ic_number']);
		$data['mobile'] = trim($_POST['mobile']);
		$data['description'] = trim($_POST['description']);
		$data['amount'] = trim($_POST['amount']);
		$data['paidamount'] = trim($_POST['paid_amount']);
		$data['balanceamount'] = trim($_POST['balance_amount']);
		$data['added_by'] = $this->session->get('log_id');

		// echo '<pre>';
		// print_r($data);
		// exit;
		if (!empty($data['name']) && !empty($data['amount']) && !empty($data['dt']) && $data['amount'] > 0) {
			$ubayam = $this->db->table('ubayam')->where('id', $id)->get()->getRowArray();
			// debit ledger
			// Individual Ledger
			/* $ledger = $this->db->table('ledgers')->where('name', 'Ubayam')->where('group_id', 29)->get()->getRowArray();
			if (!empty($ledger)) {
				$dr_id = $ledger['id'];
			} else {
				$led['group_id'] = 29;
				$led['name'] = 'Ubayam';
				$led['code'] = '027';
				$led['op_balance'] = '0';
				$led['op_balance_dc'] = 'D';
				$led_ins = $this->db->table('ledgers')->insert($led);
				$dr_id = $this->db->insertID();
			} */
			// Individual Ledger
			
			// Separate Ledger
			$ubayam_setting = $this->db->table('ubayam_setting')->where('id', $ubayam['pay_for'])->get()->getRowArray();
			$ubayam_name = $ubayam_setting['name'];
			$sales_group = $this->db->table('groups')->where('code', '4000')->get()->getRowArray();
			if(!empty($sales_group)){
				$sls_id = $sales_group['id'];
			}else{
				$sls1['parent_id'] = 0;
				$sls1['name'] = 'Sales';
				$sls1['code'] = '4000';
				$sls1['added_by'] = $this->session->get('log_id');
				$led_ins1 = $this->db->table('groups')->insert($sls1);
				$sls_id = $this->db->insertID();
			}
			// Separate Ledger
			$ubayam_setting = $this->db->table('ubayam_setting')->where('id', $data['pay_for'])->get()->getRowArray();
			$ubayam_name = $ubayam_setting['name'];
			if(!empty($ubayam_setting['ledger_id'])){
				$dr_id = $ubayam_setting['ledger_id'];
			}else{
				$ledger1 = $this->db->table('ledgers')->where('name', 'All Sales')->where('group_id', $sls_id)->get()->getRowArray();
				if(!empty($ledger1)){
					$dr_id = $ledger1['id'];
				}else{
					$right_code = $this->db->table('ledgers')->select('right_code')->where('group_id', $sls_id)->where('left_code', '4913')->orderBy('right_code','desc')->get()->getRowArray();
					$set_right_code = (int) $right_code['right_code'] + 1;
					$set_right_code = sprintf("%04d", $set_right_code);
					$led1['group_id'] = $sls_id;
					$led1['name'] = 'All Sales';
					$led1['left_code'] = '4913';
					$led1['right_code'] = $set_right_code;
					$led1['op_balance'] = '0';
					$led1['op_balance_dc'] = 'D';
					$led_ins1 = $this->db->table('ledgers')->insert($led1);
					$dr_id = $this->db->insertID();
				}
			}
			// Separate Ledger
			if ($id) {
				$data['modified_at'] = date('Y-m-d H:i:s');
				$res = $this->db->table('ubayam')->where('id', $id)->update($data);
				// $res = $this->db->table('ubayam')->insert($data);
				if ($res) {
					$ins_id = $id;
					if ((!empty($dr_id))) {
						$err = 0;
						$succ = 0;
						foreach ($_POST['pay'] as $row) {
							if (empty($row['id']) && $row['id'] == "") {
								$pays['ubayam_id'] = $ins_id;
								$pays['date'] = date("Y-m-d", strtotime($row['date']));
								$pays['amount'] = $row['pay_amt'];
								$pays['payment_mode'] = $row['payment_mode'];
								$ubpay = $this->db->table('ubayam_pay_details')->insert($pays);
								if ($ubpay) {
									$payment_mode_details = $this->db->table('payment_mode')->where('id', $pays['payment_mode'])->get()->getRowArray();
									$cr_id = $payment_mode_details['ledger_id'];
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
									$entries['entry_code'] = 'REC' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($qry['entry_code'], -5)) + 1)));
									$entries['entrytype_id'] = '1';
									$entries['number'] = $num;
									$entries['date'] = date("Y-m-d", strtotime($row['date']));
									$entries['dr_total'] = $row['pay_amt'];
									$entries['cr_total'] = $row['pay_amt'];
									$entries['narration'] = 'Ubayam';
									$entries['inv_id'] = $ins_id;
									$entries['type'] = '1';
									$ent = $this->db->table('entries')->insert($entries);
									$en_id = $this->db->insertID();

									if (!empty($en_id)) {
										$ent_id[] = $en_id;
										$eitems_d['entry_id'] = $en_id;
										$eitems_d['ledger_id'] = $dr_id;
										$eitems_d['amount'] = $row['pay_amt'];
										$eitems_d['details'] = 'Ubayam(' . $ubayam['ref_no'] . ')';
										$eitems_d['dc'] = 'C';
										$cr_res = $this->db->table('entryitems')->insert($eitems_d);

										$eitems_c['entry_id'] = $en_id;
										$eitems_c['ledger_id'] = $cr_id;
										$eitems_c['amount'] = $row['pay_amt'];
										$eitems_c['details'] = 'Ubayam(' . $ubayam['ref_no'] . ')';
										$eitems_c['dc'] = 'D';
										$deb_res = $this->db->table('entryitems')->insert($eitems_c);
										if ($cr_res && $deb_res)
											$succ++;
										else
											$err++;
									} else {
										$err++;
									}
								} else {
									$err++;
								}
							}
						}
						if ($err) {
							$msg_data['err'] = 'Please Try Again';
						} else {
							$this->send_whatsapp_msg($ins_id);
							$msg_data['succ'] = 'Ubayam Update Successflly';
							$msg_data['id'] = $ins_id;
						}
					} else {
						$this->db->table('ubayam')->delete(['id' => $ins_id]);
						$msg_data['err'] = 'Please Try Again Ledger is empty';
					}
				} else {
					$msg_data['err'] = 'Please Try Again';
				}
			}
		} else {
			$msg_data['err'] = 'Please Fill Required Field';
		}
		echo json_encode($msg_data);
		exit();
	}

	public function get_booking_ubhayam()
	{
		//$cemetryid = $_POST['cemetryid'];
		//->where("id", 5)
		$ubhayamdate = date("Y-m-d", strtotime($_POST['ubhayamdate']));
		$selected_row = $this->db->table("ubayam")->select('ubayam.pay_for')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for', 'left')
			->where("ubayam.ubayam_date", $ubhayamdate)->get()->getRowArray();
		$selected_row_slot = $selected_row['pay_for'];
		$ress = $this->db->table("ubayam")->select('ubayam.pay_for')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for', 'left')
			->where("ubayam.ubayam_date", $ubhayamdate)
			->get()->getResultArray();
		$ubhyams = array();
		$implode_arry = array();
		foreach ($ress as $row) {
			$ubhyams[] = $row['pay_for'];
		}
		$ubhayam_bookings = $this->db->query("select * from ubayam_setting where ubayam_date is null or ubayam_date = 0 or ubayam_date = '' or ubayam_date = '$ubhayamdate'")->getResultArray();
		$html = "<option value='' >--Select Ubayam--</option>";
		foreach ($ubhayam_bookings as $ubhayam_booking) {
			if (is_array($ubhyams) && in_array($ubhayam_booking['id'], $ubhyams)) {
				$selected = "selected";
				if ($ubhayam_booking['event_type'] == 1) {
					$disabled = "disabled";
				} else {
					$disabled = "";
				}
			} else {
				$disabled = "";
				$selected = "";
			}
			if(empty($disabled)) $html .= '<option value=' . $ubhayam_booking['id'] . ' ' . $disabled . ' ' . $selected . ' >' . $ubhayam_booking['name'] . '</option>';
		}
		echo $html;
	}
	public function send_whatsapp_msg($id)
	{
		$data['qry1'] = $ubayam = $this->db->table('ubayam')
			->join('ubayam_setting', 'ubayam_setting.id = ubayam.pay_for')
			->select('ubayam_setting.name as uname')
			->select('ubayam.*')
			->where('ubayam.id', $id)
			->get()->getRowArray();
		$tmpid = 1;
		$data['temple_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$data['payment'] = $this->db->table('ubayam_pay_details')->where('ubayam_id', $id)->get()->getResultArray();
		$data['terms'] = $this->db->table("terms_conditions")->get()->getRowArray();
		$data['pay_details'] = $this->db->table("ubayam_pay_details")->where("ubayam_id", $id)->get()->getResultArray();
		if (!empty($ubayam['mobile'])) {
			$html = view('ubayam/pdf', $data);
			$options = new Options();
			$options->set('isHtml5ParserEnabled', true);
			$options->set(array('isRemoteEnabled' => true));
			$options->set('isPhpEnabled', true);
			$dompdf = new Dompdf($options);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$filePath = FCPATH . 'uploads/documents/invoice_ubayam_' . $id . '.pdf';

			file_put_contents($filePath, $dompdf->output());
			$message_params = array();
			$message_params[] = date('d M, Y', strtotime($ubayam['dt']));
			$message_params[] = date('h:i A', strtotime($ubayam['created_at']));
			$message_params[] = $ubayam['amount'];
			// $message_params[] = $ubayam['paidamount'];
			$message_params[] = $ubayam['balanceamount'];
			$media['url'] = base_url() . '/uploads/documents/invoice_ubayam_' . $id . '.pdf';
			$media['filename'] = 'ubayam_invoice.pdf';
			$mobile_number = $ubayam['mobile'];
			//$mobile_number = '+919092615446';
			// print_r($mobile_number);
			// print_r($message_params);
			// print_r($media);
			// die; 
			$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'ubayam_live', $media);
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
