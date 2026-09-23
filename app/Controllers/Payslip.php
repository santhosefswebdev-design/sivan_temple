<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Payslip extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper("common");
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		if(!$this->model->list_validate('pay_slip')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('pay_slip');
		$data['data'] = $this->db->query("select pay_slip.*, staff.name from pay_slip inner join staff on pay_slip.staff_id = staff.id where staff.status = 1 order by pay_slip.date desc ")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('payslip/index', $data);
		echo view('template/footer');
    }
	public function getrefno(){
		//echo strtotime($_POST['dt']);
		$yr= date('Y',strtotime($_POST['date'])) ;
		$mon= date('m',strtotime($_POST['date'])) ;
		  
		$query   = $this->db->query("SELECT ref_no FROM pay_slip where id=(select max(id) from pay_slip where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();

		echo 'PS' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
    }
	public function payslip_add(){
		if(!$this->model->permission_validate('pay_slip', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['staff'] = $this->db->table('staff')->where('is_admin',0)->where('status', 1)->orderBy('name', 'ASC')->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('products')->get()->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT ref_no FROM pay_slip where id=(select max(id) from pay_slip where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
		$data['ref_no']= 'PS' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$data['payment_modes'] = $this->db->query("SELECT *  FROM payment_mode WHERE paid_through LIKE '%direct%' and status = 1 ")->getResultArray();
		//echo $data['ref_no']; exit;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('payslip/payslip_add', $data);
		echo view('template/footer');
	}
	public function get_earn(){
      	$staff_id = $_POST['staff_id'];
	  	$date = $yr= date('Y-m',strtotime($_POST['date'])) ;
		$data = array();
		/*
		$last_month_salary = $this->db->query("select pay_slip.*, pay_slip_details.* 
												from `pay_slip` 
												inner join pay_slip_details on pay_slip_details. pay_slip_id = pay_slip.id
												where pay_slip.staff_id = $staff_id and  pay_slip_details.description  = 'Basic Pay' order by date desc")->getResultArray();
		
		if(count($last_month_salary) > 0){
			//$last_date = date('Y-m-d', strtotime($last_month_salary['created']));
			$last_date = $last_month_salary[0]['created'];
			$amt = $this->db->query("select sum(amount) as amount from `advancesalary` where created > '$last_date' and staff_id = $staff_id")->getRowArray();
			if($amt['amount'] > 0){
				$advance = $amt['amount'];
			}else {  $advance = 0; }
		}
		else{
				echo "";
		 }
		*/
		//var_dump(!empty($amt_emi[0]['amount']));
		//exit;
		//$advance = $month_advance_salary + $emi_advance_salary;

			// Salary Description
	 		$dres = $this->db->table('payslip_description')->where('name', 'Salary')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'Salary';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			// Commission Description
			$dres = $this->db->table('payslip_description')->where('name', 'Commission')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'Commission';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			// Basic Pay Description
			$dres = $this->db->table('payslip_description')->where('name', 'Basic Pay')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'Basic Pay';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			// Allowance Description
			$dres = $this->db->table('payslip_description')->where('name', 'Allowance')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'Allowance';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			// EPF Description
			$dres = $this->db->table('payslip_description')->where('name', 'EPF')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'EPF';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			// SOCSO Description
			$dres = $this->db->table('payslip_description')->where('name', 'SOCSO')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'SOCSO';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			// EIS Description
			$dres = $this->db->table('payslip_description')->where('name', 'EIS')->countAllResults();
			if($dres == 0){
				$ddata['name'] 		= 'EIS';
				$ddata['created']   = date('Y-m-d H:i:s');
				$ddata['modified']  = date('Y-m-d H:i:s');
				$this->db->table('payslip_description')->insert($ddata);
			}
			$result = $this->db->table("staff")->where("id", $staff_id)->get()->getRowArray();
			$res = $this->db->query("select * from pay_slip where staff_id = $staff_id and date like '%$date%'")->getRowArray();
			if(empty($res)){
				/* $data['sal_amt'] =$result['salary'] - $advance; */
				$data['sal_amt'] =$result['basic_pay'];
				$data['allowance_amt'] =$result['allowance'];
		    	//$com_amt_archa =$result['commission_amt'];
		    	$data['epf_amt'] =$result['is_epf']."_".$result['epf_amount'];
		    	$data['socso_amt'] =$result['is_socso']."_".$result['socso_amount'];
		    	$data['eis_amt'] =$result['is_eis']."_".$result['eis_amount'];
			}else{
				$ids = $res['id'];
				$salary = $this->db->table('pay_slip_details')->where('description', 'Basic Pay')->where('pay_slip_id', $ids)->get()->getRowArray();
				$allowance = $this->db->table('pay_slip_details')->where('description', 'Allowance')->where('pay_slip_id', $ids)->get()->getRowArray();
				//$commis = $this->db->table('pay_slip_details')->where('description', 'Commission')->where('pay_slip_id', $ids)->get()->getRowArray();
				$epf = $this->db->table('pay_slip_details')->where('description', 'EPF')->where('pay_slip_id', $ids)->get()->getRowArray();
				$socso = $this->db->table('pay_slip_details')->where('description', 'SOCSO')->where('pay_slip_id', $ids)->get()->getRowArray();
				$eis = $this->db->table('pay_slip_details')->where('description', 'EIS')->where('pay_slip_id', $ids)->get()->getRowArray();
				/* if(empty($salary)) $data['sal_amt'] =$result['salary'] - $advance; */
				if(empty($salary)) $data['sal_amt'] =$result['basic_pay'];
				else $data['sal_amt'] = "0";
				if(empty($allowance)) $data['allowance_amt'] =$result['allowance'];
				else $data['allowance_amt'] = "0";
				//if(empty($commis)) $com_amt_archa =$result['commission_amt'];
				if(empty($epf)) $data['epf_amt'] =$result['is_epf']."_".$result['epf_amount'];
				else $data['epf_amt'] = "0_0.00";
				if(empty($socso)) $data['socso_amt'] =$result['is_socso']."_".$result['socso_amount'];
				else $data['socso_amt'] = "0_0.00";
				if(empty($eis)) $data['eis_amt'] =$result['is_eis']."_".$result['eis_amount'];
				else $data['eis_amt'] = "0_0.00";
			}
			// ADVANCE PAYMENT
			$advance_payment_existing_check = $this->db->query("select * FROM pay_slip as ps JOIN pay_slip_details as psd ON psd.pay_slip_id = ps.id WHERE psd.description = 'Advance Salary' AND ps.staff_id = $staff_id and ps.date like '%$date%' ")->getResultArray();
			if(count($advance_payment_existing_check) > 0){
				$month_advance_salary = 0;
			}
			else{
				$amt   = $this->db->table('advancesalary')->select('SUM(amount) as amount')->where('staff_id',$staff_id)->where('deduction_month', $date)->where('type',1)->get()->getRowArray();
				if(!empty($amt['amount'])){
					$month_advance_salary = $amt['amount'];
				}
				else { $month_advance_salary = 0; }
			}
			
			// LOAN EMI ADVANCE PAYMENT
			$advance_payment_emi_loan_existing_check = $this->db->query("select * FROM pay_slip as ps JOIN pay_slip_details as psd ON psd.pay_slip_id = ps.id WHERE psd.description = 'Advance Salary' AND psd.type = 'Loan' AND ps.staff_id = $staff_id and ps.date like '%$date%' ")->getResultArray();
			if(count($advance_payment_emi_loan_existing_check) > 0){
				$emi_advance_salary = 0;
			}
			else{
				$choosed_dt = $_POST['date'];
				$amt_emi   = $this->db->table('advancesalary')->select('amount')
															->where('staff_id',$staff_id)
															->where('emi_start_month <=', $choosed_dt)
															->where('emi_end_month >=', $choosed_dt)
															->where('type',2)
															->get()
															->getRowArray();
				if(!empty($amt_emi['amount'])){
					$emi_advance_salary = $amt_emi['amount'];
				}
				else { $emi_advance_salary = 0; }
			}

			//OTHER COMMISSION
			$new_res = $this->db->query("select SUM(psd.earning) as tot_ern_comm FROM pay_slip as ps JOIN pay_slip_details as psd ON psd.pay_slip_id = ps.id WHERE psd.description = 'Commission' AND ps.staff_id = $staff_id and ps.date like '%$date%' ")->getRowArray();
			if(!empty($new_res['tot_ern_comm'])){
				$com_amt_payslip = $new_res['tot_ern_comm'];
			}
			else{
				$com_amt_payslip = 0;
			}

			$commsion_amd_data = $this->db->query("select SUM(abd.total_commision) as tot_comm FROM archanai_booking as ab JOIN archanai_booking_details as abd ON abd.archanai_booking_id = ab.id WHERE abd.comission_to = $staff_id and ab.date like '%$date%' ")->getRowArray();
			if(!empty($commsion_amd_data['tot_comm'])){
				$com_amt_archa = $commsion_amd_data['tot_comm'];
			}
			else{
				$com_amt_archa = 0;
			}
			$qry_other_commision   = $this->db->query("SELECT SUM(commission.amount) AS commission_amt FROM commission where commission.staff_id = $staff_id AND commission.date like '%$date%' ")->getRowArray();
			if(!empty($qry_other_commision['commission_amt'])){
				$other_comm_amt = $qry_other_commision['commission_amt'];
			}
			else{
				$other_comm_amt = 0;
			}
			$final_comm_amt = (float)$com_amt_archa + (float)$other_comm_amt - (float)$com_amt_payslip;
			$data['com_amt'] = $final_comm_amt;
			$data['adv_amt'] = $month_advance_salary;
			$data['emi_dedection_option'] = $emi_advance_salary;
			/* if($advance > 0) $data['sal_txt'] = 'Salary (Advance amount(RM ' . number_format($advance, "2") . ') debited)';
			else $data['sal_txt'] = 'Salary'; */
			$data['sal_txt'] = 'Basic Pay';
      	echo json_encode($data);
    }
	
	public function save_slip(){	
		//var_dump($_POST["pay"]);
		//exit;
		$yr= date('Y',strtotime($_POST['date'])) ;
		$mon= date('m',strtotime($_POST['date'])) ;
		//Check Exit Pay status on Payslip month
		/*$qry   = $this->db->query("SELECT id FROM pay_slip where year(date)=$yr and month(date)=$mon and staff_id='". $_POST['staffname'] ."'")->getRowArray();
		if (!empty($qry['id'])){
			$msg_data['err'] = "Pay Slip Already Added. Please Try Again";
			echo json_encode($msg_data);
			exit();
		}*/
		$query   = $this->db->query("SELECT ref_no FROM pay_slip where id=(select max(id) from pay_slip where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$data['date']		= $_POST['date'];
		$data['staff_id'] 	= $_POST['staffname'];
		$data['ref_no'] 	= 'PS'.date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));;
		$data['earning'] 	= (float)$_POST['tot_earn'];
		$data['deduction'] 	= (float)$_POST['tot_ded'];
		$finl_net_pay_amt = (float)$_POST['tot_earn'] - (float)$_POST['tot_ded'];
		$data['net_pay'] 	= $finl_net_pay_amt;
		$data['payment_mode'] 	= $_POST['paymentmode'];
		$data['created'] 	= date("Y-m-d H:i:s");
		$data['modified']	= date("Y-m-d H:i:s");
		$data['entry_by']	= $this->session->get('log_id');
		$sal_amt = 0;
		$com_amt = 0;
		$oth_amt = 0;
		//var_dump($_POST);
		//exit;
		if(!empty($_POST['pay'])){
			if(!empty($data['payment_mode'])){
				//Payment Mode Details
				$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
				// Insert Pay Slip
				$res = $this->db->table("pay_slip")->insert($data);
				$ins_id = $this->db->insertID();
				if(!empty($ins_id)){  
					$pay_earn=0; $pay_ded=0;
					$tot_commission = 0;
					foreach($_POST['pay'] as $row){
						//Add Earnins and Deduction
						if($row['pay_earn']) $pay_earn += $row['pay_earn'];
						if($row['pay_ded']) $pay_ded += $row['pay_ded'];
						//Insert Pay slip Details
						
						if($row['pay_name'] == "Monthly Loan EMI"){
							$choosed_dt = $_POST['date'];
							$stafff_id = $_POST['staffname'];
							$amt_emi = $this->db->query("select sum(amount) as amount,id as ad_sal_id,emi_end_month from advancesalary where staff_id = $stafff_id and emi_start_month <= '$choosed_dt' and emi_end_month >= '$choosed_dt' and type = 2 ")->getResultArray();
							if(count($amt_emi) > 0){
								if($amt_emi[0]['amount'] > 0){
									$emi_advance_salary = $amt_emi[0]['amount'];
									$emi_end_month = $amt_emi[0]['emi_end_month'];
									$ad_sal_id = $amt_emi[0]['ad_sal_id'];
									if(!empty($_POST['emi_deduction'])){

										$con_year_month = date("Y-m-14",strtotime($emi_end_month));
										$emi_dedection_one_month = date('Y-m-t',strtotime($con_year_month. ' + 1 months'));

										$data_emi_deduc['emi_end_month'] 	= $emi_dedection_one_month;
										$data_emi_deduc['modified'] = date('Y-m-d H:i:s');
										$this->db->table('advancesalary')->where('id', $ad_sal_id)->update($data_emi_deduc);
										$pay['pay_slip_id'] = $ins_id;
										$pay['description'] = "Advance Salary";
										$pay['type'] = "Loan";
										$pay['type_remark'] 	= "Except EMI deduction to this month";
										$pay['earning'] 	= "0.00";
										$pay['deduction'] 	= "0.00";
										$this->db->table('pay_slip_details')->insert($pay);
									}
									else{
										$pay_sec['pay_slip_id'] = $ins_id;
										$pay_sec['description'] = "Advance Salary";
										$pay_sec['type'] = "Loan";
										$pay_sec['type_remark'] 	= NULL;
										$pay_sec['earning'] 	= "0.00";
										$pay_sec['deduction'] 	= $amt_emi[0]['amount'];
										$this->db->table('pay_slip_details')->insert($pay_sec);
									}
								}
							}
						}
						else{
							$pay['pay_slip_id'] = $ins_id;
							$pay['description'] = $row['pay_name'];
							$pay['earning'] 	= $row['pay_earn'];
							$pay['deduction'] 	= $row['pay_ded'];
							$pay['type_remark'] 	= NULL;
							$this->db->table('pay_slip_details')->insert($pay);
						}
						
						// Check and Insert on Pay Slip Description
						$dres = $this->db->table('payslip_description')->where('name', $row['pay_name'])->countAllResults();
						if($dres == 0){
							$ddata['name'] 		= $row['pay_name'];
							$ddata['created']   = date('Y-m-d H:i:s');
							$ddata['modified']  = date('Y-m-d H:i:s');
							$this->db->table('payslip_description')->insert($ddata);
						}
						//Update staff commission Amount
						if($row['pay_name'] == 'Commission'){
							$id = $data['staff_id'];
							$earn = $row['pay_earn'];
							$tot_commission += $earn;
							$this->db->query("update staff set commission_amt =commission_amt-$earn where id = $id");
						}
					}
					// Total Earning
					$tot_ear = $pay_earn - $pay_ded;
					
					//Current Liabilities 13
					/* $current_liabilities = $this->db->table('groups')->where('name', 'Current Liabilities')->where('parent_id', 13)->get()->getRowArray();
					if(!empty($current_liabilities)){ $cl_grp_id = $current_liabilities['id'];}
					else{
						$cl_data['parent_id'] = 13;
						$cl_data['name'] = 'Current Liabilities';
						$cl_data['code'] = '210';
						$cl_data['added_by'] = $this->session->get('log_id');
						$cl_data = $this->db->table('groups')->insert($cl_data);
						$cl_grp_id = $this->db->insertID();
					}
					// Current Liabilities under Trade Creditors
					$cl_tc_led = $this->db->table('ledgers')->where('name', 'TRADE PAYABLE')->where('left_code', '4000')->where('group_id', $cl_grp_id)->get()->getRowArray();
					if(!empty($cl_tc_led)){ $cl_tc_led_id = $cl_tc_led['id'];}
					else{
						$cl_tc_led_data['group_id'] = $cl_grp_id;
						$cl_tc_led_data['name'] = 'TRADE PAYABLE';
						$cl_tc_led_data['code'] = '4000/000';
						$cl_tc_led_data['op_balance'] = '0';
						$cl_tc_led_data['op_balance_dc'] = 'D';
						$cl_tc_led_data['left_code'] = '4000';
						$cl_tc_led_data['right_code'] = '000';
						$this->db->table('ledgers')->insert($cl_tc_led_data);
						$cl_tc_led_id = $this->db->insertID();
					}
					//Direct Expenses 30
					$direct_expenses = $this->db->table('groups')->where('name', 'Direct Expenses')->where('parent_id', 30)->get()->getRowArray();
					if(!empty($direct_expenses)){ $de_grp_id = $direct_expenses['id'];}
					else{
						$de_data['parent_id'] = 30;
						$de_data['name'] = 'Direct Expenses';
						$de_data['code'] = '410';
						$de_data['added_by'] = $this->session->get('log_id');
						$this->db->table('groups')->insert($de_data);
						$de_grp_id = $this->db->insertID();
					}
					// Direct Expenses under Salary
					$de_s_led = $this->db->table('ledgers')->where('name', 'Salary')->where('group_id', $de_grp_id)->get()->getRowArray();
					if(!empty($de_s_led)){ $de_s_led_id = $de_s_led['id'];}
					else{
						$de_s_led_data['group_id'] = $de_grp_id;
						$de_s_led_data['name'] = 'Salary';
						$de_s_led_data['op_balance'] = '0';
						$de_s_led_data['op_balance_dc'] = 'D';
						$this->db->table('ledgers')->insert($de_s_led_data);
						$de_s_led_id = $this->db->insertID();
					}
					// Assets->Current Assets under Cash-in-Hand
					$cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
					if(!empty($cashinhand)){
						$cih_id = $cashinhand['id'];
					}else{
						$cih1['parent_id'] = 3;
						$cih1['name'] = 'Cash-in-Hand';
						$cih1['code'] = '111';
						$cih1['added_by'] = $this->session->get('log_id');
						$this->db->table('groups')->insert($cih1);
						$cih_id = $this->db->insertID();
					}
					$pc_ledger = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
					if(!empty($pc_ledger)){
						$pc_ledger_id = $pc_ledger['id'];
					}else{
						$pc_ledger_data['group_id'] = $cih_id;
						$pc_ledger_data['name'] = 'PETTY CASH';
						$pc_ledger_data['op_balance'] = '0';
						$pc_ledger_data['op_balance_dc'] = 'C';
						$this->db->table('ledgers')->insert($pc_ledger_data);
						$pc_ledger_id = $this->db->insertID();
					}
					// Liabilities->Deduction 
					$l_dedection = $this->db->table('groups')->where('name', 'Deduction')->where('parent_id', 13)->get()->getRowArray();
					if(!empty($l_dedection)){
						$l_dedection_id = $l_dedection['id'];
					}else{
						$l_dedection_data['parent_id'] = 13;
						$l_dedection_data['name'] = 'Deduction';
						$l_dedection_data['code'] = '';
						$l_dedection_data['added_by'] = $this->session->get('log_id');
						$this->db->table('groups')->insert($l_dedection_data);
						$l_dedection_id = $this->db->insertID();
					}
					$pay_earnings_tot = 0;
					$pay_advancesalary_tot = 0;
					$pay_notadvancesalary_tot = 0;
					$pay_earnings_status = 0;
					$pay_advancesalary_status = 0;
					$pay_notadvancesalary_status = 0;
					foreach($_POST['pay'] as $row){
						if($row['pay_type'] == 'Earnings'){
							$pay_earnings_tot = $pay_earnings_tot + $row['pay_earn'];
							$pay_earnings_status = $pay_earnings_status + 1;
						}
						if($row['pay_name'] == 'Advance Salary' && $row['pay_type'] == 'Deductions'){
							$pay_advancesalary_tot = $pay_advancesalary_tot + $row['pay_ded'];
							$pay_advancesalary_status = $pay_advancesalary_status + 1;
						}
						if($row['pay_name'] != 'Advance Salary' && $row['pay_type'] == 'Deductions'){
							$pay_notadvancesalary_tot = $pay_notadvancesalary_tot + $row['pay_ded'];
							$pay_notadvancesalary_status = $pay_notadvancesalary_status + 1;
						}
					}
					//Journal Section
					if($pay_earnings_status > 0)
					{
						$number = $this->db->table('entries')->select('number')->where('entrytype_id',4)->orderBy('id','desc')->get()->getRowArray(); 
						if(empty($number)) $num = 1;
						else $num = $number['number'] + 1;
						//Journal Entry code
						$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =4 and month (date)='". $mon ."')")->getRowArray();
						$jentries['entry_code'] 	= 'JOR' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
						$jentries['entrytype_id'] 	= '4';
						$jentries['number'] 		= $num;
						$jentries['date'] 		 	= $data['date'];		
						$jentries['dr_total'] 	 	= $pay_earnings_tot;
						$jentries['cr_total'] 	 	= $pay_earnings_tot;			
						$jentries['narration'] 	 	= 'Earnings';
						$jentries['inv_id']		 	= $ins_id;
						$jentries['type']		 	= 7;
						//Insert Journal Entry
						$ent = $this->db->table('entries')->insert($jentries);
						$jen_id = $this->db->insertID();
						if(!empty($jen_id)){
							// Journal Trade Creditors
							$eitems_trade_creditors['entry_id']  = $jen_id;
							$eitems_trade_creditors['ledger_id'] = $cl_tc_led_id;
							$eitems_trade_creditors['amount']    = $pay_earnings_tot;
							$eitems_trade_creditors['dc'] 	   = 'C';
							$eitems_trade_creditors['details']   = 'TRADE PAYABLE';
							$this->db->table('entryitems')->insert($eitems_trade_creditors);
							// Journal Salary 
							$eitems_salary['entry_id']  = $jen_id;
							$eitems_salary['ledger_id'] = $de_s_led_id;
							$eitems_salary['amount']    = $pay_earnings_tot;
							$eitems_salary['dc'] 	   	  = 'D';
							$eitems_salary['details']   = 'Salary';
							$this->db->table('entryitems')->insert($eitems_salary);
						}
					}
					// Payment section 
					$earning_advancesalary_tot = 0;
					if($pay_earnings_status > 0 && $pay_advancesalary_status > 0){
						$earning_advancesalary_tot = $pay_earnings_tot - $pay_advancesalary_tot;
					}
					else{
						$earning_advancesalary_tot = $pay_earnings_tot;
					}
					if($earning_advancesalary_tot > 0)
					{
						$number_payment = $this->db->table('entries')->select('number')->where('entrytype_id',2)->orderBy('id','desc')->get()->getRowArray(); 
						if(empty($number_payment)) $num_pay = 1;
						else $num_pay = $number_payment['number'] + 1;
						//Journal Entry code
						$qry_payment   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =2 and month (date)='". $mon ."')")->getRowArray();
						$pentries['entry_code'] 	= 'PAY' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry_payment['entry_code'],-5))+1)));
						$pentries['entrytype_id'] 	= '2';
						$pentries['number'] 		= $num_pay;
						$pentries['date'] 		 	= $data['date'];		
						$pentries['dr_total'] 	 	= $earning_advancesalary_tot;
						$pentries['cr_total'] 	 	= $earning_advancesalary_tot;			
						$pentries['narration'] 	 	= 'Earnings - Advance Salary';
						$pentries['inv_id']		 	= $ins_id;
						$pentries['type']		 	= 7;
						//Insert Payment Entry
						$this->db->table('entries')->insert($pentries);
						$pen_id = $this->db->insertID();
						if(!empty($pen_id)){
							$earning_without_commission = $earning_advancesalary_tot;
							if($tot_commission > 0){
								$com_led = $this->db->table('ledgers')->where('name', 'Commission Ledger')->where('group_id', 13)->get()->getRowArray();
								if(!empty($com_led)){
									$com_led_id = $com_led['id'];
								}else{
									$com_led_data['group_id'] = 13;
									$com_led_data['name'] = 'Commission Ledger';
									$com_led_data['op_balance'] = '0';
									$com_led_data['op_balance_dc'] = 'D';
									$com_led_ins = $this->db->table('ledgers')->insert($com_led_data);
									$com_led_id = $this->db->insertID();
								}
								// Payment Commission Ledger
								$eitems_payment_trade_creditors['entry_id']  = $pen_id;
								$eitems_payment_trade_creditors['ledger_id'] = $com_led_id;
								$eitems_payment_trade_creditors['amount']    = $tot_commission;
								$eitems_payment_trade_creditors['dc'] 	   = 'D';
								$eitems_payment_trade_creditors['details']   = 'Commission';
								$this->db->table('entryitems')->insert($eitems_payment_trade_creditors);
								$earning_without_commission = $earning_without_commission - $tot_commission;
							}
							// Payment Trade Creditors
							$eitems_payment_trade_creditors['entry_id']  = $pen_id;
							$eitems_payment_trade_creditors['ledger_id'] = $cl_tc_led_id;
							$eitems_payment_trade_creditors['amount']    = $earning_without_commission;
							$eitems_payment_trade_creditors['dc'] 	   = 'D';
							$eitems_payment_trade_creditors['details']   = 'Earnings - Advance Salary';
							$this->db->table('entryitems')->insert($eitems_payment_trade_creditors);
							// Payment Petty Cash 
							$eitems_petty_cash['entry_id']  = $pen_id;
							$eitems_petty_cash['ledger_id'] = $payment_mode_details['ledger_id'];
							$eitems_petty_cash['amount']    = $earning_advancesalary_tot;
							$eitems_petty_cash['dc'] 	   	  = 'C';
							$eitems_petty_cash['details']   = 'Earnings - Advance Salary';
							$this->db->table('entryitems')->insert($eitems_petty_cash);
						}
					}
					// RECEIPT SECTION
					if($pay_notadvancesalary_status > 0)
					{
						$number_receipt = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
						if(empty($number_receipt)) $num_rec = 1;
						else $num_rec = $number_receipt['number'] + 1;
						//Journal Entry code
						$qry_receipt   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
						$rentries['entry_code'] 	= 'REC' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry_receipt['entry_code'],-5))+1)));
						$rentries['entrytype_id'] 	= '1';
						$rentries['number'] 		= $num_rec;
						$rentries['date'] 		 	= $data['date'];		
						$rentries['dr_total'] 	 	= $pay_notadvancesalary_tot;
						$rentries['cr_total'] 	 	= $pay_notadvancesalary_tot;			
						$rentries['narration'] 	 	= 'Deductions';
						$rentries['inv_id']		 	= $ins_id;
						$rentries['type']		 	= 7;
						//Insert Payment Entry
						$this->db->table('entries')->insert($rentries);
						$ren_id = $this->db->insertID(); //$l_dedection_id
						foreach($_POST['pay'] as $row){
							if($row['pay_name'] != 'Advance Salary' && $row['pay_type'] == 'Deductions'){
								$pay_name = $row['pay_name'];
								$pay_name_ledger = $this->db->table('ledgers')->where('name', $pay_name)->where('group_id', $l_dedection_id)->get()->getRowArray();
								if(!empty($pay_name_ledger)){
									$pay_name_ledger_id = $pay_name_ledger['id'];
								}else{
									$pay_name_ledger_data['group_id'] = $l_dedection_id;
									$pay_name_ledger_data['name'] = $pay_name;
									$pay_name_ledger_data['op_balance'] = '0';
									$pay_name_ledger_data['op_balance_dc'] = 'C';
									$this->db->table('ledgers')->insert($pay_name_ledger_data);
									$pay_name_ledger_id = $this->db->insertID();
								}
								$eitems_payname['entry_id']  = $ren_id;
								$eitems_payname['ledger_id'] = $pay_name_ledger_id;
								$eitems_payname['amount']    = $row['pay_ded'];
								$eitems_payname['dc'] 	   	  = 'C';
								$eitems_payname['details']   = $row['pay_name'];
								$this->db->table('entryitems')->insert($eitems_payname);
							}
						}
					} */			
					// $this->account_migration($ins_id);
					$msg_data['id']   = $ins_id;
					$msg_data['succ'] = "Payslip Added Successfully";
				}else{
					$msg_data['err'] = "Please Try Again";
				}
			}
			else {
				$msg_data['err'] = "Please Choose Payment Mode";
			}
			
		}else{
			$msg_data['err'] = "Please Add Any PaySlip";
		}
		echo json_encode($msg_data);
		exit();
	}

	public function print_page(){
		if(!$this->model->permission_validate('pay_slip','print')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] 	 = $this->db->table("pay_slip")->where("id", $id)->get()->getRowArray();
		$staff_id = $data['data']['staff_id'];
		$payment_mode = $data['data']['payment_mode'];
		$data['data_pay'] = $this->db->table("pay_slip_details")->where("pay_slip_id", $id)->get()->getResultArray();
		$data['staff'] 	 = $this->db->table("staff")->where("id", $staff_id)->get()->getRowArray();
		$data['payment_mode'] 	 = $this->db->table("payment_mode")->where('id', $payment_mode)->get()->getRowArray();
	   	echo view('payslip/print_page', $data);
	}
	  
	  public function get_desc() {
		$name = $_POST['search'];
		$data = array();
		$res = $this->db->query("select name from payslip_description where name like '%".$name."%' ")->getResultArray();
		foreach($res as $row){
			$data[] = $row['name'];
		}
		$datas = implode(',', $data);
		echo json_encode($data);
	}
	
	public function view(){
	    if(!$this->model->permission_validate('pay_slip','view')){
			header('Location: '.base_url().'/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] 	 = $this->db->table("pay_slip")->where("id", $id)->get()->getRowArray();
		$data['data_pay'] = $this->db->table("pay_slip_details")->where("pay_slip_id", $id)->get()->getResultArray();
		$data['staff'] 	 = $this->db->table("staff")->where('is_admin',0)->where('status', 1)->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		$data['view']	 = true;
		// echo '<pre>'; print_r($data);die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('payslip/payslip_view', $data);
		echo view('template/footer');
	    
	}
	
	public function advance_salary(){
		if(!$this->model->permission_validate('advance_salary','view')){
			header('Location: '.base_url().'/dashboard');
		}
		$data = array();
		$data['permission'] = $this->model->get_permission('advance_salary');
		$data['data'] = $this->db->table('advancesalary', 'staff')
						->join('staff', 'staff.id = advancesalary.staff_id')
						->select('staff.name, advancesalary.*')
						->where('staff.status',1)
						->orderBy('advancesalary.date', 'DESC')
						->orderBy('advancesalary.id', 'DESC')
						->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('advance_salary/index', $data);
		echo view('template/footer');
	}

	public function advancesalary_add(){
		$data['staff'] = $this->db->table('staff')->where('is_admin',0)->where('status', 1)->orderBy('name','asc')->get()->getResultArray();
		$mon = date('m');
		$yr  = date('Y');
		$query   = $this->db->query("SELECT ref_no FROM advancesalary where id=(select max(id) from advancesalary where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
		$data['ref_no']= 'ASY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		$data['payment_modes'] = $this->db->query("SELECT *  FROM payment_mode WHERE paid_through LIKE '%direct%' and status = 1 ")->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('advance_salary/add', $data);
		echo view('template/footer');
	}
	public function advance_salary_view(){
		if(!$this->model->permission_validate('advance_salary','view')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('advancesalary', 'staff')
						->join('staff', 'staff.id = advancesalary.staff_id')
						->select("staff.name, advancesalary.*")
						->where('advancesalary.id', $id)
						->get()->getRowArray();
		$data['staff'] = $this->db->table('staff')->where('is_admin',0)->where('status', 1)->orderBy('name','asc')->get()->getResultArray();
		$data['payment_modes'] = $this->db->query("SELECT *  FROM payment_mode WHERE paid_through LIKE '%direct%' and status = 1 ")->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('advance_salary/add', $data);
		echo view('template/footer');
	}
	public function get_advance_refno(){
		$yr= date('Y',strtotime($_POST['date'])) ;
		$mon= date('m',strtotime($_POST['date'])) ;
		$query   = $this->db->query("SELECT ref_no FROM advancesalary where id=(select max(id) from advancesalary where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
		echo 'ASY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
	}

	public function save_advancesalary(){
		$msg_data = array();
		$msg_data['succ'] = '';
		$msg_data['err'] = '';
		if(empty($_POST['pay_type'])){
			$msg_data['err'] = "Please select type";
		}
		else if($_POST['pay_type'] == 2 && empty($_POST['emi_type']) ){
			$msg_data['err'] = "Please enter emi count";
		}else{
			// this one used for current date based working
			if(!empty($_POST['month_type'])){
				if($_POST['pay_type'] == '1' && !empty($_POST['month_type'])){
					// $con_yr_mn = date("Y-m", strtotime($_POST['date']));
					$con_yr_mn = $_POST['month_type'];
					$qry_existing_month_payslip_generate   = $this->db->query("SELECT * FROM pay_slip where DATE_FORMAT(date, '%Y-%m') ='".$con_yr_mn."' and staff_id='". $_POST['staffname'] ."'")->getResultArray();
					if (count($qry_existing_month_payslip_generate) > 0){
						$msg_data['err'] = "Payslip Already generated this month, Please try Again Next Month";
						echo json_encode($msg_data);
						exit();
					}
				}
			}
			//Check Exit Pay status on Advance salary date
			$qry   = $this->db->query("SELECT id FROM advancesalary where date='".$_POST['date']."' and staff_id='". $_POST['staffname'] ."' and type = '". $_POST['pay_type'] ."' ")->getRowArray();
			if (!empty($qry['id'])){
				$msg_data['err'] = "Advance Salary Already Added, Please try Again Next Day";
				echo json_encode($msg_data);
				exit();
			}
			// This one used for MONTH PICKER CHOOSED Month check pay_type == 1 only using
			if($_POST['pay_type'] == 1){
				$con_yr_mn_payslip_one = $_POST['month_type'];
				$qry_existing_month_payslip_generate_pyslip_one   = $this->db->query("SELECT * FROM pay_slip where DATE_FORMAT(date, '%Y-%m') ='".$con_yr_mn_payslip_one."' and staff_id='". $_POST['staffname'] ."'")->getResultArray();
				if (count($qry_existing_month_payslip_generate_pyslip_one) > 0){
					$msg_data['err'] = "Payslip Already generated choosed month, Please try Again Next Month";
					echo json_encode($msg_data);
					exit();
				}
			}
			if($_POST['pay_type'] == 2){
				$emi_start_month_paytype_two = $_POST['emi_start_month'];
				$emi_type_paytype_two = !empty($_POST['emi_type']) ? $_POST['emi_type'] : 0;
				$loan_end_month = loanperiodendmonths($emi_start_month_paytype_two,$emi_type_paytype_two);
				$qry_existing_month_payslip_generate_pyslip_two   = $this->db->query("SELECT * FROM advancesalary where DATE_FORMAT(advancesalary.emi_start_month,'%Y-%m') <= '$loan_end_month' AND DATE_FORMAT(advancesalary.emi_end_month,'%Y-%m') >= '$loan_end_month' and advancesalary.type = 2 and advancesalary.staff_id='". $_POST['staffname'] ."'")->getResultArray();
				if (count($qry_existing_month_payslip_generate_pyslip_two) > 0){
					$msg_data['err'] = "Already existing loan emi. please once complete previous loan, try to next loan";
					echo json_encode($msg_data);
					exit();
				}
			}
			if($_POST['pay_type'] == 1){
				$ded_month_date = $_POST['month_type'];
			}
			if($_POST['pay_type'] == 2){
				$ded_month_date = $_POST['emi_start_month'];
			}
			$emi_type = !empty($_POST['emi_type']) ? $_POST['emi_type'] : 0;
			$max_basic_sal_amt = loadstaffsalary($_POST['staffname'],$_POST['pay_type'],$ded_month_date);
			$max_emi_amt = loademiamount($_POST['provision_amount'],$emi_type,$_POST['amount'],$_POST['pay_type']);
			//echo $max_basic_sal_amt;
			//exit();
			if($max_emi_amt > $max_basic_sal_amt){
				$msg_data['err'] = "Enter the Amount Less than the Net Salary";
				echo json_encode($msg_data);
				exit();
			}
			$yr= date('Y',strtotime($_POST['date'])) ;
			$mon= date('m',strtotime($_POST['date'])) ;
			$data['date'] 		= $_POST['date'];
			$data['staff_id'] 	= $_POST['staffname'];
			$data['ref_no'] 	= $_POST['invno'];
			$data['provision_amount'] 	= !empty($_POST['provision_amount']) ? $_POST['provision_amount'] : "0.00";
			$data['narration'] 	= $_POST['narration'];
			$data['created']	= date('Y-m-d H:i:s');
			$data['modified'] 	= date('Y-m-d H:i:s');
			$data['payment_mode'] 	= $_POST['paymentmode'];
			if(!empty($_POST['ledger_id'])) $data['ledger_id'] 	= $_POST['ledger_id'];
			$data['type'] 	= $_POST['pay_type'];
			//Payment Mode Details
			//$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
			//$res = $this->db->table('staff')->where('id', $_POST['staffname'])->get()->getRowArray();
			//$staff = $data['staff_id'];
			//$sres = $this->db->table('staff')->where('id', $staff)->get()->getRowArray();
			/*
			$last_month_salary = $this->db->query("select pay_slip.*, pay_slip_details.* 
													from pay_slip 
													inner join pay_slip_details on pay_slip_details. pay_slip_id = pay_slip.id
													where pay_slip.staff_id = $staff and pay_slip_details.description  = 'Salary' order by pay_slip.date desc")->getResultArray();
			//var_dump($last_month_salary);
			//exit;
			if(count($last_month_salary) > 0){
				$last_date = date('Y-m-d', strtotime($last_month_salary[0]['created']));
				$amt = $this->db->query("select sum(amount) as amount from `advancesalary` where created > '$last_date' and staff_id = $staff")->getRowArray();
				if($amt['amount'] > 0){
					$advance = $amt['amount'];
				}else {  $advance = 0; }
			}
			else{  
				$amt = $this->db->query("select sum(amount) as amount from `advancesalary` where staff_id = $staff")->getRowArray();
				if($amt['amount'] > 0){
					$advance = $amt['amount'];
				}else {  $advance = 0; }
			}
			*/
			//$balance = $res['salary'];
			//var_dump($_POST);
			//exit;
			if(empty($_POST['pay_type'])){
				$msg_data['err'] = "Please select type";
			}
			else if($_POST['pay_type'] == 2 && (empty($_POST['emi_type']) && $_POST['emi_type'] == "") ){
				$msg_data['err'] = "Please enter emi count";
			}
			else{
				if($_POST['pay_type'] == 1){
					$data['amount'] 	= $_POST['amount'];
					$data['deduction_month'] 	= $_POST['month_type'];
					$data['emi_count'] 	= NULL;
					$data['emi_start_month'] 	= NULL;
					$data['emi_end_month'] 	= NULL;
					$data['total_amount'] 	= $_POST['amount'];
				}
				else if($_POST['pay_type'] == 2){
					if(!empty($_POST['provision_amount'])){
						$bf_m_a = $_POST['amount'];
						$sbf_m_a = (float)$bf_m_a + (float)$_POST['provision_amount'];
						$fbf_m_a = $sbf_m_a / $_POST['emi_type'];
						$data['amount'] 	= number_format($fbf_m_a,2);
					}
					else{
						$bf_m_a = $_POST['amount'];
						$sbf_m_a = (float)$bf_m_a;
						$fbf_m_a = $sbf_m_a / $_POST['emi_type'];
						$data['amount'] 	= number_format($fbf_m_a,2);
					}
					$emi_monthcount = $_POST['emi_type'];
					$data['deduction_month'] 	= NULL;
					$data['emi_count'] 	= $emi_monthcount;
					$data['emi_start_month'] 	= date("Y-m-01", strtotime($_POST['emi_start_month'])); 
					$emi_start_month_re 	= date("Y-m-14", strtotime($_POST['emi_start_month'])); // feb month calculation
					$emi_dedection_one_month = $emi_monthcount - 1;
					$data['emi_end_month'] 	= date("Y-m-t", strtotime("+$emi_dedection_one_month month", strtotime($emi_start_month_re)));
					$data['total_amount'] 	= $_POST['amount'];
				}

				if(!empty($data['payment_mode']))
				{
					$res = $this->db->table('advancesalary')->insert($data);
					$ins_id = $this->db->insertID();
					if($ins_id){
						
						//Current Liabilities 13
						/* $current_liabilities = $this->db->table('groups')->where('name', 'Current Liabilities')->where('parent_id', 13)->get()->getRowArray();
						if(!empty($current_liabilities)){ $cl_grp_id = $current_liabilities['id'];}
						else{
							$cl_data['parent_id'] = 13;
							$cl_data['name'] = 'Current Liabilities';
							$cl_data['code'] = '210';
							$cl_data['added_by'] = $this->session->get('log_id');
							$cl_data = $this->db->table('groups')->insert($cl_data);
							$cl_grp_id = $this->db->insertID();
						}
						// Current Liabilities under Trade Creditors
						$cl_tc_led = $this->db->table('ledgers')->where('name', 'TRADE PAYABLE')->where('left_code', '4000')->where('group_id', $cl_grp_id)->get()->getRowArray();
						if(!empty($cl_tc_led)){ $cl_tc_led_id = $cl_tc_led['id'];}
						else{
							$cl_tc_led_data['group_id'] = $cl_grp_id;
							$cl_tc_led_data['name'] = 'TRADE PAYABLE';
							$cl_tc_led_data['code'] = '4000/000';
							$cl_tc_led_data['op_balance'] = '0';
							$cl_tc_led_data['op_balance_dc'] = 'D';
							$cl_tc_led_data['left_code'] = '4000';
							$cl_tc_led_data['right_code'] = '000';
							$this->db->table('ledgers')->insert($cl_tc_led_data);
							$cl_tc_led_id = $this->db->insertID();
						}
						// Assets->Current Assets under Cash-in-Hand
						$cashinhand = $this->db->table('groups')->where('name', 'Cash-in-Hand')->where('parent_id', 3)->get()->getRowArray();
						if(!empty($cashinhand)){
							$cih_id = $cashinhand['id'];
						}else{
							$cih1['parent_id'] = 3;
							$cih1['name'] = 'Cash-in-Hand';
							$cih1['code'] = '111';
							$cih1['added_by'] = $this->session->get('log_id');
							$this->db->table('ledgers')->insert($cih1);
							$cih_id = $this->db->insertID();
						}
						$pc_ledger = $this->db->table('ledgers')->where('name', 'PETTY CASH')->where('group_id', $cih_id)->get()->getRowArray();
						if(!empty($pc_ledger)){
							$pc_ledger_id = $pc_ledger['id'];
						}else{
							$pc_ledger_data['group_id'] = $cih_id;
							$pc_ledger_data['name'] = 'PETTY CASH';
							$pc_ledger_data['op_balance'] = '0';
							$pc_ledger_data['op_balance_dc'] = 'C';
							$this->db->table('ledgers')->insert($pc_ledger_data);
							$pc_ledger_id = $this->db->insertID();
						}
						//Payment Section
						$number = $this->db->table('entries')->select('number')->where('entrytype_id',2)->orderBy('id','desc')->get()->getRowArray(); 
						if(empty($number)) $pnum = 1;
						else $pnum = $number['number'] + 1;
						//Payment Entry code
						$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =2 and month (date)='". $mon ."')")->getRowArray();
						$pentries['entry_code'] 	= 'PAY' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
						$pentries['entrytype_id'] 	= '2';
						$pentries['number'] 		= $pnum;
						$pentries['date'] 		 	= $data['date'];		
						$pentries['dr_total'] 	 	= $data['amount'];
						$pentries['cr_total'] 	 	= $data['amount'];			
						$pentries['narration'] 	 	= 'Advance Salary';
						$pentries['inv_id']		 	= $ins_id;
						$pentries['type']		 	= 10;
						//Insert Payment Entry
						$pent = $this->db->table('entries')->insert($pentries);
						$pen_id = $this->db->insertID();
						if($pen_id){
							//Cash ledger entry items
							$eitems_aled['entry_id']  = $pen_id;
							$eitems_aled['ledger_id'] = $payment_mode_details['ledger_id'];
							$eitems_aled['details']   = 'Advance Salary';
							$eitems_aled['amount']    = $data['amount'];
							$eitems_aled['dc'] 	   	  = 'C';
							$this->db->table('entryitems')->insert($eitems_aled);
							//Cash Staff Salary entry items
							$eitems_aled1['entry_id']  = $pen_id;
							$eitems_aled1['ledger_id'] = $cl_tc_led_id;
							$eitems_aled1['details']   = 'Advance Salary';
							$eitems_aled1['amount']    = $data['amount'];
							$eitems_aled1['dc'] 	   = 'D';
							$this->db->table('entryitems')->insert($eitems_aled1);
						} */
						$this->account_migration_advance_salary($ins_id);
						$msg_data['id']   = $ins_id;
						$msg_data['succ'] = "Advance Salary Successfully Completed!...";
					}else{
						$msg_data['err'] = "Please Try Again";
					}
				}
				else
				{
					$msg_data['err'] = "Please choose payment mode. ";
				}
			}
		}
		echo json_encode($msg_data);
		exit;
	}
	public function account_migration($id){
		$pay_slip = $this->db->table('pay_slip')->where('id', $id)->get()->getRowArray();
		$pay_slip_details = $this->db->table('pay_slip_details')->where('pay_slip_id', $id)->get()->getResultArray();
		$other_expenses = $this->db->table('groups')->where('name', 'Other Expenses')->where('code', 6100)->get()->getRowArray();
		if(!empty($other_expenses)){ $cl_grp_id = $other_expenses['id'];}
		else{
			$cl_data['parent_id'] = 30;
			$cl_data['name'] = 'Other Expenses';
			$cl_data['code'] = '6100';
			$cl_data['added_by'] = $this->session->get('log_id');
			$cl_data = $this->db->table('groups')->insert($cl_data);
			$cl_grp_id = $this->db->insertID();
		}
		
		$epf_led = $this->db->table('ledgers')->where('name', 'EPF')->where('left_code', '6100')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($epf_led)){ $epf_id = $epf_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'EPF';
			$cl_tc_led_data['code'] = '6100/001';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '6100';
			$cl_tc_led_data['right_code'] = '001';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$epf_id = $this->db->insertID();
		}
		
		$socso_led = $this->db->table('ledgers')->where('name', 'SOCSO')->where('left_code', '6100')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($socso_led)){ $socso_id = $socso_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'SOCSO';
			$cl_tc_led_data['code'] = '6100/002';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '6100';
			$cl_tc_led_data['right_code'] = '002';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$socso_id = $this->db->insertID();
		}
		
		$eis_led = $this->db->table('ledgers')->where('name', 'EIS')->where('left_code', '6100')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($eis_led)){ $eis_id = $eis_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'EIS';
			$cl_tc_led_data['code'] = '6100/005';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '6100';
			$cl_tc_led_data['right_code'] = '005';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$eis_id = $this->db->insertID();
		}
		
		
		$commission_led = $this->db->table('ledgers')->where('name', 'Commission')->where('left_code', '6100')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($commission_led)){ $commission_id = $commission_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'EIS';
			$cl_tc_led_data['code'] = '6100/005';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '6100';
			$cl_tc_led_data['right_code'] = '005';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$commission_id = $this->db->insertID();
		}
		
		$accruals = $this->db->table('groups')->where('name', 'Accruals')->where('code', 2110)->get()->getRowArray();
		if(!empty($accruals)){ $cl_grp_id = $accruals['id'];}
		else{
			$cl_data['parent_id'] = 14;
			$cl_data['name'] = 'Accruals';
			$cl_data['code'] = '2110';
			$cl_data['added_by'] = $this->session->get('log_id');
			$cl_data = $this->db->table('groups')->insert($cl_data);
			$cl_grp_id = $this->db->insertID();
		}
		
		$epf_payable_led = $this->db->table('ledgers')->where('name', 'EPF payable')->where('left_code', '2110')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($epf_payable_led)){ $epf_payable_id = $epf_payable_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'EPF payable';
			$cl_tc_led_data['code'] = '2110/001';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '2110';
			$cl_tc_led_data['right_code'] = '001';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$salary_id = $this->db->insertID();
		}
		
		$socso_payable_led = $this->db->table('ledgers')->where('name', 'SOCSO Payable')->where('left_code', '2110')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($socso_payable_led)){ $socso_payable_id = $socso_payable_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'SOCSO Payable';
			$cl_tc_led_data['code'] = '2110/002';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '2110';
			$cl_tc_led_data['right_code'] = '002';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$socso_payable_id = $this->db->insertID();
		}
		
		$salary_payable_led = $this->db->table('ledgers')->where('name', 'Salary Payable')->where('left_code', '2110')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($salary_payable_led)){ $salary_payable_id = $salary_payable_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'SOCSO Payable';
			$cl_tc_led_data['code'] = '2110/003';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '2110';
			$cl_tc_led_data['right_code'] = '003';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$salary_payable_id = $this->db->insertID();
		}
		
		
		$eis_payable_led = $this->db->table('ledgers')->where('name', 'EIS Payable')->where('left_code', '2110')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($eis_payable_led)){ $eis_payable_id = $eis_payable_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'EIS Payable';
			$cl_tc_led_data['code'] = '2110/004';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '2110';
			$cl_tc_led_data['right_code'] = '004';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$eis_payable_id = $this->db->insertID();
		}
		
		$comission_payable_led = $this->db->table('ledgers')->where('name', 'Comission Payable')->where('left_code', '2110')->where('group_id', $cl_grp_id)->get()->getRowArray();
		if(!empty($comission_payable_led)){ $comission_payable_id = $comission_payable_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $cl_grp_id;
			$cl_tc_led_data['name'] = 'Comission Payable';
			$cl_tc_led_data['code'] = '2110/005';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '2110';
			$cl_tc_led_data['right_code'] = '005';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$comission_payable_id = $this->db->insertID();
		}
		
		
		$direct_cost = $this->db->table('groups')->where('code', 5000)->get()->getRowArray();
		if(!empty($direct_cost)){ $dc_grp_id = $direct_cost['id'];}
		else{
			$cl_data['parent_id'] = 0;
			$cl_data['name'] = 'Direct Cost';
			$cl_data['code'] = '5000';
			$cl_data['added_by'] = $this->session->get('log_id');
			$cl_data = $this->db->table('groups')->insert($cl_data);
			$dc_grp_id = $this->db->insertID();
		}
		
		$commission_led = $this->db->table('ledgers')->where('name', 'Staff Commission')->where('left_code', '5000')->where('group_id', $in_grp_id)->get()->getRowArray();
		if(!empty($commission_led)){ $commission_id = $commission_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $dc_grp_id;
			$cl_tc_led_data['name'] = 'Staff Commission';
			$cl_tc_led_data['code'] = '5000/001';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '5000';
			$cl_tc_led_data['right_code'] = '001';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$commission_id = $this->db->insertID();
		}
		
		$salary_led = $this->db->table('ledgers')->where('name', 'Staff Fixed Salary')->where('left_code', '5000')->where('group_id', $dc_grp_id)->get()->getRowArray();
		if(!empty($salary_led)){ $salary_id = $salary_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $dc_grp_id;
			$cl_tc_led_data['name'] = 'Staff Fixed Salary';
			$cl_tc_led_data['code'] = '5000/000';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '5000';
			$cl_tc_led_data['right_code'] = '000';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$salary_id = $this->db->insertID();
		}
		
		
		$incomes = $this->db->table('groups')->where('name', 'Incomes')->where('code', 8000)->get()->getRowArray();
		if(!empty($incomes)){ $in_grp_id = $incomes['id'];}
		else{
			$cl_data['parent_id'] = 0;
			$cl_data['name'] = 'Other Expenses';
			$cl_data['code'] = '8000';
			$cl_data['added_by'] = $this->session->get('log_id');
			$cl_data = $this->db->table('groups')->insert($cl_data);
			$in_grp_id = $this->db->insertID();
		}
		
		$deductions_led = $this->db->table('ledgers')->where('name', 'Deductions')->where('left_code', '8200')->where('group_id', $in_grp_id)->get()->getRowArray();
		if(!empty($deductions_led)){ $deduction_payable_id = $deductions_led['id'];}
		else{
			$cl_tc_led_data = array();
			$cl_tc_led_data['group_id'] = $in_grp_id;
			$cl_tc_led_data['name'] = 'Deductions';
			$cl_tc_led_data['code'] = '8200/001';
			$cl_tc_led_data['op_balance'] = '0';
			$cl_tc_led_data['op_balance_dc'] = 'D';
			$cl_tc_led_data['left_code'] = '8200';
			$cl_tc_led_data['right_code'] = '001';
			$this->db->table('ledgers')->insert($cl_tc_led_data);
			$deduction_payable_id = $this->db->insertID();
		}
		
		
		if(count($pay_slip_details) > 0){
			$deduction_payable_total = 0;
			$salary_total = $commission_total = $commission_payable_total = 0;
			$epf_total = $socso_total = $eis_total = 0;
			$epf_payable_total = $socso_payable_total = $eis_payable_total = 0;
			foreach($pay_slip_details as $psd){
				if(!empty($psd['earning']) && $psd['earning'] > 0){
					if($psd['description'] == 'Basic Pay' || $psd['description'] == 'Salary'){
						$salary_total += $psd['earning'];
					}elseif($psd['description'] == 'Commission'){
						$commission_total += $psd['earning'];
					}else $salary_total += $psd['earning'];
				}elseif(!empty($psd['deduction']) && $psd['deduction'] > 0){
					// print_r($psd);
					if($psd['description'] == 'EPF'){
						$epf_tab = $this->db->table('epf')->where('employee_contribution', $psd['deduction'])->get()->getRowArray();
						$epf_payable_total += (float) $epf_tab['total_contribution'];
						$epf_total += (float) $epf_tab['employer_contribution'];
					}elseif($psd['description'] == 'SOCSO'){
						$sosco_tab = $this->db->table('sosco')->where('employee_contribution', $psd['deduction'])->get()->getRowArray();
						$socso_payable_total += (float) $sosco_tab['total_contribution'];
						$socso_total += (float) $sosco_tab['employer_contribution'];
					}elseif($psd['description'] == 'EIS'){
						$eis_tab = $this->db->table('sosco_insurance')->where('employee_contribution', $psd['deduction'])->get()->getRowArray();
						$eis_payable_total += (float) $eis_tab['total_contribution'];
						$eis_total += (float) $eis_tab['employer_contribution'];
					}else{
						$deduction_payable_total += (float) $psd['deduction'];
					}
				}
			}
			
		}
		$commission_payable_total = $commission_total;
		$debit_total = $salary_total + $commission_total + $epf_total + $socso_total + $eis_total;
		$credit_total = $deduction_payable_total + $commission_payable_total + $epf_payable_total + $socso_payable_total + $eis_payable_total;
		$salary_payable_total = $debit_total - $credit_total;
		print_r('salary_total=' . $salary_total);
		print_r('<br>');
		print_r('commission_total=' . $commission_total);
		print_r('<br>');
		print_r('epf_total=' . $epf_total);
		print_r('<br>');
		print_r('socso_total=' . $socso_total);
		print_r('<br>');
		print_r('eis_total=' . $eis_total);
		print_r('<br>');
		print_r('deduction_payable_total=' . $deduction_payable_total);
		print_r('<br>');
		print_r('commission_payable_total=' . $commission_payable_total);
		print_r('<br>');
		print_r('epf_payable_total=' . $epf_payable_total);
		print_r('<br>');
		print_r('socso_payable_total=' . $socso_payable_total);
		print_r('<br>');
		print_r('eis_payable_total=' . $eis_payable_total);
		print_r('<br>');
		print_r($debit_total);
		print_r('<br>');
		print_r($credit_total);
		print_r('<br>');
		print_r($salary_payable_total);
		print_r('<br>');
		
	}
	public function account_migration_advance_salary($id){
		$advancesalary = $this->db->table('advancesalary')->where('id', $id)->get()->getRowArray();
		if(!empty($advancesalary['id'])){
			if(!empty($advancesalary['amount'])){
				$payment_mode_details = $this->db->table('payment_mode')->where('id', $data['payment_mode'])->get()->getRowArray();
				if(empty($payment_mode_details['ledger_id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
				if(!empty($advancesalary['ledger_id'])){
					$cl_tc_led_id = $advancesalary['ledger_id'];
				}else{
					$current_assets = $this->db->table('groups')->where('name', 'Other Receivable')->where('code', 1220)->get()->getRowArray();
					if(!empty($current_assets)){ $cl_grp_id = $current_assets['id'];}
					else{
						$cl_data['parent_id'] = 3;
						$cl_data['name'] = 'Other Receivable';
						$cl_data['code'] = '1220';
						$cl_data['added_by'] = $this->session->get('log_id');
						$cl_data = $this->db->table('groups')->insert($cl_data);
						$cl_grp_id = $this->db->insertID();
					}
					$cl_tc_led = $this->db->table('ledgers')->where('name', 'Staff Loan')->where('left_code', '1220')->where('group_id', $cl_grp_id)->get()->getRowArray();
					if(!empty($cl_tc_led)){ $cl_tc_led_id = $cl_tc_led['id'];}
					else{
						$cl_tc_led_data['group_id'] = $cl_grp_id;
						$cl_tc_led_data['name'] = 'Staff Loan';
						
						$cl_tc_led_data['code'] = '1220/000';
						$cl_tc_led_data['op_balance'] = '0';
						$cl_tc_led_data['op_balance_dc'] = 'D';
						$cl_tc_led_data['left_code'] = '1220';
						$cl_tc_led_data['right_code'] = '000';
						$this->db->table('ledgers')->insert($cl_tc_led_data);
						$cl_tc_led_id = $this->db->insertID();
					}
				}
				$yr= date('Y',strtotime($advancesalary['date'])) ;
				$mon= date('m',strtotime($advancesalary['date'])) ;
				$this->db->table('entries')->select('number')->where('entrytype_id',2)->orderBy('id','desc')->get()->getRowArray(); 
				if(empty($number)) $pnum = 1;
				else $pnum = $number['number'] + 1;
				//Payment Entry code
				$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =2 and month (date)='". $mon ."')")->getRowArray();
				$pentries['entry_code'] 	= 'PAY' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
				$pentries['entrytype_id'] 	= '2';
				$pentries['number'] 		= $pnum;
				$pentries['date'] 		 	= $advancesalary['date'];		
				$pentries['dr_total'] 	 	= $advancesalary['amount'];
				$pentries['cr_total'] 	 	= $advancesalary['amount'];			
				$pentries['narration'] 	 	= 'Advance Salary';
				$pentries['inv_id']		 	= $ins_id;
				$pentries['type']		 	= 10;
				//Insert Payment Entry
				$pent = $this->db->table('entries')->insert($pentries);
				$pen_id = $this->db->insertID();
				if($pen_id){
					//Cash ledger entry items
					$eitems_aled['entry_id']  = $pen_id;
					$eitems_aled['ledger_id'] = $payment_mode_details['ledger_id'];
					$eitems_aled['details']   = 'Advance Salary';
					$eitems_aled['amount']    = $advancesalary['amount'];
					$eitems_aled['dc'] 	   	  = 'C';
					$this->db->table('entryitems')->insert($eitems_aled);
					//Cash Staff Salary entry items
					$eitems_aled1['entry_id']  = $pen_id;
					$eitems_aled1['ledger_id'] = $cl_tc_led_id;
					$eitems_aled1['details']   = 'Advance Salary';
					$eitems_aled1['amount']    = $advancesalary['amount'];
					$eitems_aled1['dc'] 	   = 'D';
					$this->db->table('entryitems')->insert($eitems_aled1);
				}
				
			}
		}
	}
	public function loadsalarytype(){
		// this user for no emi start month option
		/*$staff_id = $_POST['staff_id'];
		$choosed_date = $_POST['choosed_date'];
		$plus_one_month = date("Y-m-01", strtotime("+1 months", strtotime($choosed_date)));
		$html ="<option value=''>-- Select Type --</option><option value='1'>Month</option>";

		$advance_salary_emi_data = $this->db->query("select * from advancesalary where staff_id = $staff_id and emi_start_month <= '$plus_one_month' and emi_end_month >= '$plus_one_month' and type = 2 ")->getResultArray();
		if(count($advance_salary_emi_data) == 0){
			$html .="<option value='2'>EMI</option>";
		}*/
		$html ="<option value=''>-- Select Type --</option><option value='1'>Month</option>";
		$html .="<option value='2'>EMI</option>";
		echo $html;

	}
	public function loadstaffsalary(){
		$staff_id = $_POST['staff_id'];
		$paytype_id = $_POST['paytype_id'];

		/*$month_advance_salary = 0;
		$emi_advance_salary = 0;
		$basic_pay_data = $this->db->table('staff')->select("basic_pay")->where('id', $staff_id)->get()->getRowArray();
		if($paytype_id == 1){
			$deduction_month = $_POST['ded_month'];
			$advance_salary_monthly_data = $this->db->query("select sum(amount) as amount from advancesalary where staff_id = '$staff_id' and deduction_month = '$deduction_month' and type = 1 ")->getResultArray();
			if(count($advance_salary_monthly_data) > 0){
				if($advance_salary_monthly_data[0]['amount'] > 0){
					$month_advance_salary = $advance_salary_monthly_data[0]['amount'];
				}
				else { $month_advance_salary = 0; }
			}
			else{
				$month_advance_salary = 0;
			}
		}
		if($paytype_id == 2){
			$deduction_emi = $_POST['ded_month'];
			$advance_salary_emi_data = $this->db->query("select sum(amount) as amount,emi_count from advancesalary where staff_id = $staff_id and emi_start_month <= '$deduction_emi' and emi_end_month >= '$deduction_emi' and type = 2 ")->getResultArray();
			if(count($advance_salary_emi_data) > 0){
				if($advance_salary_emi_data[0]['amount'] > 0){
					$emi_advance_salary = $advance_salary_emi_data[0]['amount'] / $advance_salary_emi_data[0]['emi_count'];
				}
				else { $emi_advance_salary = 0; }
			}else {  $emi_advance_salary = 0; }
		}
		$advance_sal = $month_advance_salary + $emi_advance_salary;
		if(!empty($basic_pay_data['basic_pay'])){
			$eighty_per = $basic_pay_data['basic_pay'] * 80 / 100;
			$remaing_amt = $eighty_per - $advance_sal;
		}
		else{
			$remaing_amt = 0;
		}
		*/
		$date_convert_half = date('Y-m-14', strtotime($_POST['ded_month']));
		$deduction_emi_month_data = date("Y-m-01", strtotime("+1 month", strtotime($date_convert_half)));
		$deduction_emi_month = date('Y-m', strtotime($deduction_emi_month_data));

		echo $deduction_emi_month;
	}
	public function emi_calculation(){
		$loan_amt = !empty($_POST['loanamount']) ? $_POST['loanamount'] : 0;
		$provision_amt = !empty($_POST['provisionamount']) ? $_POST['provisionamount'] : 0;
		$emitype = !empty($_POST['emitype']) ? $_POST['emitype'] : 0;
		$pay_type = 2;
		$emi_amt = loademiamount($provision_amt,$emitype,$loan_amt,$pay_type);
		if($emi_amt > 0){
			echo number_format($emi_amt,2);
		}
		else{
			echo "0.00";
		}
	}
	public function print_advance_salary(){
		if(!$this->model->permission_validate('advance_salary','print')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('advancesalary', 'staff')
						->join('staff', 'staff.id = advancesalary.staff_id')
						->select("staff.name, advancesalary.*")
						->where('advancesalary.id', $id)
						->get()->getRowArray();
	   echo view('advance_salary/print_page', $data);
	}

	
}
