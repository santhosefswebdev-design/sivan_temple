<?php
namespace App\Controllers;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class Balance_sheet extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper("common");
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		if($_POST['fdate']) $sdate = $_POST['fdate'];
		else $sdate = date("Y-m-01");
		if($_POST['tdate']) $tdate = $_POST['tdate'];
		else $tdate = date("Y-m-d");
		//$data['groups'] = $this->db->where('name','Assets')->get('groups')->result();
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('name', array('Assets', 'Liabilities'))->get()->getResult();

		foreach($groups as $r) {


			$datas[] = '<tr style="color: black;">
							<td><b>'.$r->name.'</b></td>
							<td style="text-align: right;">
								<b>'.number_format($this->total_group_amt($r->id,  $sdate, $tdate),2).'</b>
							</td>
						</tr>';

				//$group_one = $this->db->where('parent_id',$r->id)->get('groups')->result();
				$group_one = $this->db->table('groups')->where('parent_id',$r->id)->get()->getResult();

				foreach($group_one as $go) {
			
					$datas[] = '<tr style="color: black;">
					   		<td><a style="margin-left: 2%;color: black;" href="">'.$go->name.'</a></td>
							<td style="text-align: right;">'.number_format($this->get_group_amt($go->id, $sdate, $tdate),2).'</td>
					   		</tr>';
				

				// $ledgers1 = $this->db->where('group_id',$go->id)->get('ledgers')->result();
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				
				foreach($ledgers1 as $led1) {
					$ledgername = get_ledger_name($led1->id);
					$datas[] = '<tr style="color: black;">
					   		<td><a style="margin-left: 4%;" href="">'.$ledgername.'</a></td>
							<td style="text-align: right;">'.number_format($this->get_ledger_amt($led1->id, $sdate, $tdate),2).'</td>
					   		</tr>';					
				}

			// 	//$group_two = $this->db->where('parent_id',$go->id)->get('groups')->result();
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->get()->getResult();
			
				foreach($group_two as $gt) {
					
					$datas[] = '<tr style="color: black;">
					   		<td><a style="margin-left: 4%;" href="">'.$gt->name.'</a></td>
							<td style="text-align: right;">'.number_format($this->get_group_amt($gt->id, $sdate, $tdate),2).'</td>
					   		</tr>';	

					   //$ledgers2 = $this->db->where('group_id',$gt->id)->get('ledgers')->result();
					   $ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
						foreach($ledgers2 as $led2) {
							$ledgername = get_ledger_name($led2->id);
							$datas[] = '<tr style="color: black;">
					   		<td><a style="margin-left: 6%;" href="">'.$ledgername.'</a></td>
							<td style="text-align: right;">'.number_format($this->get_ledger_amt($led2->id, $sdate, $tdate),2).'</td>
					   		</tr>';
						}
				}
			}
			$datas[] = '<tfoot><tr style="color: black;">
					   		<td><b>Total ' . $r->name . '</b></td>
							<td style="text-align: right;"><b>'. number_format($this->total_group_amt($r->id, $sdate, $tdate),2).'</b></td>
					   		</tr></tfoot></table><table class="table table-striped" style="width:100%;">';
		}

		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();
		
		//$datas[] = '<tfoot><tr style="color: black;">
				//<td><b>Liabilities and Owners Equity and P/L PENDING AS PER ABOORVA</b></td>
				//<td><b></b></td>
				//</tr></tfoot>';
		$data['sdate'] = $sdate;
		$data['tdate'] = $tdate;
		$data['list'] =$datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/Balance_sheet', $data);
		echo view('template/footer');
    }

	public function total_group_amt($id, $sdate ='', $tdate ='') {
		$sub_tot = 0;
		// $tot_groups = $this->db->where('parent_id',$id)->get('groups')->result();
		$tot_groups = $this->db->table('groups')->where('parent_id',$id)->get()->getResult();
		if($tot_groups) { 
			foreach($tot_groups as $tr) {
				$sub_tot += $this->get_group_amt($tr->id, $sdate, $tdate);
			}
		}
		return $sub_tot;
	}
	
	public function get_group_amt($id, $sdate = '', $tdate ='') {	
		//$group_amt = 0;
		@$group_amt += $this->get_ledger_amt($id, $sdate, $tdate);  
		//$groups = $this->db->where('parent_id',$id)->get('groups')->result();
		
		$groups = $this->db->table('groups')->where('parent_id',$id)->get()->getResult();
		
		if($groups) {		
			foreach($groups as $r) {
			//	echo $r->id;  echo '<br>';
				 $group_amt += $this->get_ledger_amt($r->id, $sdate, $tdate); 
				 $this->get_group_amt($r->id, $sdate, $tdate);
			}
		}
		return $group_amt;
	}

	public function get_ledger_amt($id, $sdate ='', $tdate ='') {

		$op_balance = 0;
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//$op_list = $this->db->where('group_id',$id)->get('ledgers')->result();
		$op_list = $this->db->table('ledgers')->where('group_id',$id)->get()->getResult();
		if($op_list) {
			foreach($op_list as $op) {
				$op_balance_new = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$op->id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
				if($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "")
				{
					$op_balance_amt = $op_balance_new['cr_amount'];
				}
				else
				{
					$op_balance_amt = $op_balance_new['dr_amount'];
				}
				$op_balance += $op_balance_amt;
				$op_balance -= $this->get_ledger_cr_amt($op->id, $sdate, $tdate);
				$op_balance += $this->get_ledger_dr_amt($op->id, $sdate, $tdate);
			}
		}
	
		//echo $op_balance; echo '<br>';
	
		return $op_balance; 
	
	}
	
	public function get_ledger_cr_amt($id, $sdate ='', $tdate='') {
		//$cr_amount = $this->db->select_sum('amount')->where('ledger_id',$id)->where('dc','C')->get('entryitems')->row()->amount;

		$res = $this->db->query("select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
		//echo $this->db->getLastQuery();die;
					//$res = $query->getResultArray();
		$cr_amount = $res['amount'];
		return	$cr_amount;
	}
	
	public function get_ledger_dr_amt($id, $sdate ='', $tdate ='') {
		//$dr_amount = $this->db->select_sum('amount')->where('ledger_id',$id)->where('dc','D')->get('entryitems')->row()->amount;
		$res = $this->db->query("select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray(); 
					//echo $this->db->getLastQuery();die;
		$dr_amount = $res['amount'];
		return	$dr_amount;
	}
	public function print_balance_sheet() {
		if($_POST['fdate']) $sdate = $_POST['fdate'];
		else $sdate = date("Y-m-01");
		if($_POST['tdate']) $tdate = $_POST['tdate'];
		else $tdate = date("Y-m-d");
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('name', array('Assets', 'Liabilities'))->get()->getResult();

		foreach($groups as $r) {
			$datas[] = '<tr style="color: black;">
					<td><b>'.$r->name.'</b></td>
					<td style="text-align: right;"><b>'.number_format($this->total_group_amt($r->id, $sdate, $tdate),2).'</b></td>
					</tr>';

				//$group_one = $this->db->where('parent_id',$r->id)->get('groups')->result();
				$group_one = $this->db->table('groups')->where('parent_id',$r->id)->get()->getResult();

				foreach($group_one as $go) {
			
					$datas[] = '<tr style="color: black;">
					   		<td><span style="margin-left: 2%;color: black;">'.$go->name.'</span></td>
							<td style="text-align: right;">'.number_format($this->get_group_amt($go->id, $sdate, $tdate),2).'</td>
					   		</tr>';
				

				// $ledgers1 = $this->db->where('group_id',$go->id)->get('ledgers')->result();
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				
				foreach($ledgers1 as $led1) {
					$ledgername = get_ledger_name($led1->id);
					$datas[] = '<tr style="color: black;">
					   		<td><span style="margin-left: 4%;">'.$ledgername.'</span></td>
							<td style="text-align: right;">'.number_format($this->get_ledger_amt($led1->id, $sdate, $tdate),2).'</td>
					   		</tr>';					
				}

			// 	//$group_two = $this->db->where('parent_id',$go->id)->get('groups')->result();
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->get()->getResult();
			
				foreach($group_two as $gt) {
					
					$datas[] = '<tr style="color: black;">
					   		<td><span style="margin-left: 4%;">'.$gt->name.'</span></td>
							<td style="text-align: right;">'.number_format($this->get_group_amt($gt->id, $sdate, $tdate),2).'</td>
					   		</tr>';	

					   //$ledgers2 = $this->db->where('group_id',$gt->id)->get('ledgers')->result();
					   $ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
						foreach($ledgers2 as $led2) {
							$ledgername = get_ledger_name($led2->id);
							$datas[] = '<tr style="color: black;">
					   		<td><span style="margin-left: 6%;">'.$ledgername.'</span></td>
							<td style="text-align: right;">'.number_format($this->get_ledger_amt($led2->id, $sdate, $tdate),2).'</td>
					   		</tr>';
						}
				}
			}
			$datas[] = '<tfoot><tr style="color: black;">
					   		<td><b>Total ' . $r->name . '</b></td>
							<td style="text-align: right;"><b>'. number_format($this->total_group_amt($r->id, $sdate, $tdate),2).'</b></td>
					   		</tr></tfoot></table><table class="" style="width:100%;">';
		}


		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();

		$data['list'] =$datas;
		echo view('account_report/print_balance_sheet', $data);
	}	
	public function multi_balance_sheet() {
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/multi_balance_sheet');
		echo view('template/footer');
    }
	
	public function print_multi_balance_sheet() {
		echo view('account_report/print_multi_balance_sheet');
	}
	
	public function balancesheet_rightcode_triplezero(){
		if($_POST['tdate']) $tdate = $_POST['tdate'];
		else $tdate = date("Y-m-d");
		$sdate = date("Y",strtotime($tdate))."-01-01";
		$fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('name', array('Assets', 'Liabilities', 'Capital'))->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = 0;
		$whr = '';
		if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes' or parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes') or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes'))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses' or parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses') or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses'))))$whr")->getRowArray();
		
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate, $fund_id);
			if($ledger_top_group_amt_zero_check < 0){
				$top_group_amt = "( ".number_format(abs($ledger_top_group_amt_zero_check),2)." )";
			}
			else{
				$top_group_amt = number_format($ledger_top_group_amt_zero_check,2);
			}
			$datas[] = '<tr style="color: black;">
							<td style="width: 40%;text-transform: uppercase;"><b>'.$r->name.'</b></td>
							<td style="text-align: right;"></td>
							<td style="text-align: right;"></td>
						</tr>';
				$group_one = $this->db->table('groups')->where('parent_id',$r->id)->get()->getResult();
				foreach($group_one as $go) {
					$ledger_group_amt_zero_check = number_format(get_group_amt_new_rightcode_triplezero_subtotal($go->id, $sdate, $tdate, $fund_id),2);
					/* if($ledger_group_amt_zero_check != 0)
					{
						$ledger_sub_group_amt_zero_check = get_group_amt_new_rightcode_triplezero($go->id, $sdate, $tdate, $fund_id);
						if($ledger_sub_group_amt_zero_check < 0){
							$group_amt = "( ".number_format(abs($ledger_sub_group_amt_zero_check),2)." )";
						}
						else{
							$group_amt = number_format($ledger_sub_group_amt_zero_check,2);
						}
						$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><span style="margin-left: 2%;color: black;text-transform: uppercase;" >'.$go->name.'</span></td>
								<td style="text-align: right;"></td>
								<td style="text-align: right;"></td>
								</tr>';
					} */
					$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><span style="margin-left: 2%;color: black;text-transform: uppercase;" >'.$go->name.'</span></td>
								<td style="text-align: right;"></td>
								<td style="text-align: right;"></td>
								</tr>';
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->where('right_code','000')->get()->getResult();
				$ls_ledgers1 = array();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led1->id, $sdate, $tdate, $fund_id),2);
						$ls_ledgers1[] = $led1->left_code;
						// echo $led1->name;
						// echo '<br>';
						// echo $ledger_amt_zero_check;
						// echo '<br>';
						if($ledger_amt_zero_check != 0)
						{
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led1->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = get_ledger_name_only($led1->id);
							$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;" onclick="open_group_ledger_triblezero_modal('.$led1->id.',\''.strtotime($sdate).'\',\''.strtotime($tdate).'\')">'.$ledgername .'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							if(!empty($led1->pa)){
								$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="text-align: right;">'.$current_pl_amount.'</td>
								<td style="text-align: right;">-</td>
								</tr>';
							}
						}					
					}
				}
				if(count($ls_ledgers1) > 0){
					$ledgers11 = $this->db->table('ledgers')->where('group_id',$go->id)->whereNotIn('left_code', $ls_ledgers1)->get()->getResult();
				}else{
					$ledgers11 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				}
				if(count($ledgers11) > 0){
					foreach($ledgers11 as $led11) {
						$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led11->id, $sdate, $tdate, $fund_id),2);
						// echo $led11->name;
						// echo '<br>';
						// echo $ledger_amt_zero_check;
						// echo '<br>';
						if($ledger_amt_zero_check != 0)
						{
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led11->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led11->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = get_ledger_name_only($led11->id);
							$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">'.$ledgername.'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							if(!empty($led11->pa)){
								$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="text-align: right;">'.$current_pl_amount.'</td>
								<td style="text-align: right;">-</td>
								</tr>';
							}
						}					
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->get()->getResult();
				foreach($group_two as $gt) {
					$ledger_group_amt_zero_check = number_format(get_group_amt_new_rightcode_triplezero_subtotal($gt->id, $sdate, $tdate, $fund_id),2);
					if($ledger_group_amt_zero_check != 0)
					{
						$ledger_sub_group_amt_zero_check = get_group_amt_new_rightcode_triplezero($gt->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_sub_group_amt_zero_check = -1 * $ledger_sub_group_amt_zero_check;
						if($ledger_sub_group_amt_zero_check < 0){
							$group_amt = "( ".number_format(abs($ledger_sub_group_amt_zero_check),2)." )";
						}
						else{
							$group_amt = number_format($ledger_sub_group_amt_zero_check,2);
						}
						$group_total += $ledger_sub_group_amt_zero_check;
						$ledger_sub_group_amt_previousyear = get_group_amt_new_rightcode_triplezero_previousyear($gt->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_sub_group_amt_previousyear = -1 * $ledger_sub_group_amt_previousyear;
						if($ledger_sub_group_amt_previousyear < 0){
							$ledger_amount_previous = "( ".number_format(abs($ledger_sub_group_amt_previousyear),2)." )";
						}
						else{
							$ledger_amount_previous = number_format($ledger_sub_group_amt_previousyear,2);
						}
						$group_total_prev += $ledger_sub_group_amt_previousyear;
						$datas[] = '<tr style="color: black;">
							<td style="width: 40%;"><span style="margin-left: 4%;text-transform: uppercase;">'.$gt->name.'</span></td>
							<td style="text-align: right;">'.$group_amt.'</td>
							<td style="text-align: right;">'.$ledger_amount_previous.'</td>
							</tr>';
					}
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->where('right_code','000')->get()->getResult();
					$ls_ledgers2 = array();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led2->id, $sdate, $tdate, $fund_id),2);
							$ls_ledgers2[] = $led2->left_code;
							// echo $led2->name;
							// echo '<br>';
							// echo $ledger_amt_zero_check;
							// echo '<br>';
							if($ledger_amt_zero_check != 0)
							{
								$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led2->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;" onclick="open_group_ledger_triblezero_modal('.$led2->id.',\''.strtotime($sdate).','.strtotime($tdate).')">'.$ledgername.'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
								if(!empty($led2->pa)){
									$datas[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
									<td style="text-align: right;">'.$current_pl_amount.'</td>
									<td style="text-align: right;">-</td>
									</tr>';
								}
							}
						}
					}
					if(count($ls_ledgers2) > 0){
						$ledgers22 = $this->db->table('ledgers')->where('group_id',$gt->id)->whereNotIn('left_code', $ls_ledgers2)->get()->getResult();
					}else{
						$ledgers22 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					}
					if(count($ledgers22) > 0){
						foreach($ledgers22 as $led22) {
							$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led22->id, $sdate, $tdate, $fund_id),2);
							// echo $led22->name;
							// echo '<br>';
							// echo $ledger_amt_zero_check;
							// echo '<br>';
							if($ledger_amt_zero_check != 0)
							{
								$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led22->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led22->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led22->id);
								$datas[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">'.$ledgername.'</a></td>
									<td style="text-align: right;">'.$ledger_amount.'</td>
									<td style="text-align: right;">'.$ledger_amount_previous.'</td>
									</tr>';
								if(!empty($led22->pa)){
									$datas[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
									<td style="text-align: right;">'.$current_pl_amount.'</td>
									<td style="text-align: right;">-</td>
									</tr>';
								}
							}					
						}
					}
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->where('right_code','000')->get()->getResult();
			$ls_ledgers3 = array();
			foreach($ledgers3 as $led3) {
				$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led3->id, $sdate, $tdate, $fund_id),2);
				$ls_ledgers3[] = $led3->left_code;
				if($ledger_amt_zero_check != 0)
				{
					$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led3->id, $sdate, $tdate, $fund_id);
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate, $fund_id);
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$datas[] = '<tr style="color: black;">
					<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;" onclick="open_group_ledger_triblezero_modal('.$led3->id.',\''.strtotime($sdate).','.strtotime($tdate).')">'.$ledgername.'</a></td>
					<td style="text-align: right;">'.$ledger_amount.'</td>
					<td style="text-align: right;">'.$ledger_amount_previous.'</td>
					</tr>';
					if(!empty($led3->pa)){
						$datas[] = '<tr style="color: black;">
						<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
						<td style="text-align: right;">'.$current_pl_amount.'</td>
						<td style="text-align: right;">-</td>
						</tr>';
					}
				}
			}
			if(count($ls_ledgers3) > 0){
				$ledgers33 = $this->db->table('ledgers')->where('group_id',$r->id)->whereNotIn('left_code', $ls_ledgers3)->get()->getResult();
			}else{
				$ledgers33 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			}
			if(count($ledgers33) > 0){
				foreach($ledgers33 as $led33) {
					$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led33->id, $sdate, $tdate, $fund_id),2);
					// echo $led33->name;
					// echo '<br>';
					// echo $ledger_amt_zero_check;
					// echo '<br>';
					if($ledger_amt_zero_check != 0)
					{
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led33->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
						if($ledger_amt_rightcode < 0){
							$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
						}
						else{
							$ledger_amount = number_format($ledger_amt_rightcode,2);
						}
						$group_total += $ledger_amt_rightcode;
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led33->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
						if($ledger_amt_rightcode_previousyear < 0){
							$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
						}
						else{
							$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
						}
						$group_total_prev += $ledger_amt_rightcode_previousyear;
						$ledgername = get_ledger_name_only($led33->id);
						$datas[] = '<tr style="color: black;">
							<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">'.$ledgername . '</a></td>
							<td style="text-align: right;">'.$ledger_amount.'</td>
							<td style="text-align: right;">'.$ledger_amount_previous.'</td>
							</tr>';
						if(!empty($led33->pa)){
							$datas[] = '<tr style="color: black;">
							<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
							<td style="text-align: right;">'.$current_pl_amount.'</td>
							<td style="text-align: right;">-</td>
							</tr>';
							$group_total += $current_pl;
						}
					}					
				}
			}
			// $ledger_bottom_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id,  $sdate, $tdate, $fund_id);
			// if($ledger_bottom_group_amt_zero_check < 0){
				// $bottom_group_amt = "( ".number_format(abs($ledger_bottom_group_amt_zero_check),2)." )";
			// }
			// else{
				// $bottom_group_amt = number_format($ledger_bottom_group_amt_zero_check,2);
			// }
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS') $assets_total = $group_total;
			elseif($r->name == 'Liabilities') $liabilities_total = $group_total;
			else $capital_total = $group_total;
			$datas[] = '<tr style="color: black;">
					   		<td style="width: 60%;text-transform: uppercase;"><b>Total ' . $r->name . '</b></td>
							<td style="text-align: right;"><b>'.$bottom_group_amt.'</b></td>
							<td style="text-align: right;"><b>'.$bottom_group_prev_amt.'</b></td>
					   		</tr></table><table class="table1" border="1" style="width:100%;">';
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		$datas[] = '<tr style="color: black;"><td style="text-transform: uppercase; width:390px; min-width:300px !important;"><b>Net Assets</b></td><td colspan="2"></td></tr>
					<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Assets</a></td>
						<td style="text-align: right;"><b>'.$assets_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>
					<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Liabilities</a></td>
						<td style="text-align: right;"><b>'.$liabilities_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>
					<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Liabilities & Equity</a></td>
						<td style="text-align: right;"><b>'.$liabilities_equity_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>
					<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Net Assets</a></td>
						<td style="text-align: right;"><b>'.$net_assets_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>
					</table>';
		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();
		$data['sdate'] = $sdate;
		$data['tdate'] = $tdate;
		$data['list'] =$datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		$data['fund_id'] = $fund_id;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/balancesheet_rightcode_triplezero', $data);
		echo view('template/footer');
    }
	public function balancesheet_full(){
		if($_POST['tdate']) $tdate = $_POST['tdate'];
		else $tdate = date("Y-m-d");
		$active_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		// $sdate = date("Y",strtotime($tdate))."-01-01";
		$sdate = $active_year['from_year_month'] . "-01";
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('code', array('1000', '2000', '3000'))->orderBy('code', 'ASC')->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = $assets_total_prev = $liabilities_total_prev = $capital_total_prev = 0;
		$whr = '';
		// if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (4000, 8000) or parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)))))$whr")->getRowArray();
		$history = history_of_balancing();
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
			$datas[] = '<tr style="color: black;">
							<td style="width: 40%;text-transform: uppercase; padding:10px !important;"><b>('.$r->code.') '.$r->name.'</b></td>
							<td style="text-align: right;"></td>
							<td style="text-align: right;"></td>
						</tr>';
			$group_one = $this->db->table('groups')->where('parent_id',$r->id)->orderBy('code', 'ASC')->get()->getResult();
			foreach($group_one as $go) {
				$sub_group_total = 0;
				$sub_group_total_prev = 0;
				$sub_group_data = array();
				$sub_group_data[] = '<tr style="color: black;">
							<td style="width: 40%; padding:8px !important;"><span style="margin-left: 2%; font-weight:bold; color: black;text-transform: uppercase;" >('.$go->code.') '.$go->name.'</span></td>
							<td style="text-align: right;"></td>
							<td style="text-align: right;"></td>
							</tr>';
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led1->id, $sdate, $tdate);
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate);
						if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$sub_group_total += $ledger_amt_rightcode;
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = $led1->name;
							$sub_group_data[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;" href="' . base_url() .'/accountreport/ledger_report/?ledger=' . $led1->id . '&fdate=' . $sdate . '&tdate=' . $tdate .'" target="_blank">('.$led1->left_code .'/'.$led1->right_code .') '.$ledgername .'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
						}
						if(!empty($led1->pa)){
							$group_total += $current_pl;
							$sub_group_total += $current_pl;
							$sub_group_data[] = '<tr style="color: black;">
							<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
							<td style="text-align: right;">'.$current_pl_amount.'</td>
							<td style="text-align: right;">-</td>
							</tr>';
						}
						if(!empty($led1->hb)){
							if($history['dr_total'] != $history['cr_total']){
								$hb = $history['dr_total'] - $history['cr_total'];
								if($hb < 0){
									$hb_amount = "( ".number_format(abs($hb),2)." )";
								}
								else{
									$hb_amount = number_format($hb,2);
								}
								$sub_group_data[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
								<td style="text-align: right;">'.$hb_amount.'</td>
								<td style="text-align: right;">-</td>
								</tr>';
								$group_total += $hb;
								$sub_group_total += $hb;
							}
						}
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->orderBy('code', 'ASC')->get()->getResult();
				foreach($group_two as $gt) {
					$sub_sub_group_total = 0;
					$sub_sub_group_total_prev = 0;
					$sub_sub_group_data = array();
					$sub_sub_group_data[] = '<tr style="color: black;">
							<td style="width: 40%; padding:8px !important;"><span style="margin-left: 4%; font-weight:bold; color: black;text-transform: uppercase;" >('.$gt->code.') '.$gt->name.'</span></td>
							<td style="text-align: right;"></td>
							<td style="text-align: right;"></td>
							</tr>';
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led2->id, $sdate, $tdate);
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate);
							if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$sub_group_total += $ledger_amt_rightcode;
								$sub_sub_group_total += $ledger_amt_rightcode;
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$sub_sub_group_data[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;" href="' . base_url() .'/accountreport/ledger_report/?ledger=' . $led2->id . '&fdate=' . $sdate . '&tdate=' . $tdate .'" target="_blank">('.$led2->left_code .'/'.$led2->right_code .') '.$ledgername .'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							}
							if(!empty($led2->pa)){
								$group_total += $current_pl;
								$sub_group_total += $current_pl;
								$sub_sub_group_total += $current_pl;
								$sub_sub_group_data[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="text-align: right;">'.$current_pl_amount.'</td>
								<td style="text-align: right;">-</td>
								</tr>';
							}
							if(!empty($led2->hb)){
								if($history['dr_total'] != $history['cr_total']){
									$hb = $history['dr_total'] - $history['cr_total'];
									if($hb < 0){
										$hb_amount = "( ".number_format(abs($hb),2)." )";
									}
									else{
										$hb_amount = number_format($hb,2);
									}
									$sub_sub_group_data[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
									<td style="text-align: right;">'.$hb_amount.'</td>
									<td style="text-align: right;">-</td>
									</tr>';
									$group_total += $hb;
									$sub_group_total += $hb;
									$sub_sub_group_total += $hb;
								}
							}
						}
					}
					if($sub_sub_group_total != 0){
						$sub_group_data[] = implode('', $sub_sub_group_data);
					}
					if($sub_sub_group_total < 0){
						$bottom_sub_sub_group_amt = "( ".number_format(abs($sub_sub_group_total),2)." )";
					}
					else{
						$bottom_sub_sub_group_amt = number_format($sub_sub_group_total,2);
					}
					// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
					if($sub_sub_group_total_prev < 0){
						$bottom_sub_sub_group_prev_amt = "( ".number_format(abs($sub_sub_group_total_prev),2)." )";
					}
					else{
						$bottom_sub_sub_group_prev_amt = number_format($sub_sub_group_total_prev,2);
					}
					if($sub_sub_group_total > 0 || $sub_sub_group_total_prev > 0){
						$sub_group_data[] = '<tr style="color: black; border-top:2px solid #000;">
									<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $gt->name . '</b></td>
									<td style="text-align: right;"><b>'.$bottom_sub_sub_group_amt.'</b></td>
									<td style="text-align: right;"><b>'.$bottom_sub_sub_group_prev_amt.'</b></td>
									</tr></table><table class="table1" border="1" style="width:100%;">';
					}
				}
				if($sub_group_total != 0){
					$datas[] = implode('', $sub_group_data);
				}
				if($sub_group_total < 0){
					$bottom_sub_group_amt = "( ".number_format(abs($sub_group_total),2)." )";
				}
				else{
					$bottom_sub_group_amt = number_format($sub_group_total,2);
				}
				// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
				if($sub_group_total_prev < 0){
					$bottom_sub_group_prev_amt = "( ".number_format(abs($sub_group_total_prev),2)." )";
				}
				else{
					$bottom_sub_group_prev_amt = number_format($sub_group_total_prev,2);
				}
				if($sub_group_total > 0 || $sub_group_total_prev > 0){
					$datas[] = '<tr style="color: black; border-top:2px solid #000;">
							<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $go->name . '</b></td>
							<td style="text-align: right;"><b>'.$bottom_sub_group_amt.'</b></td>
							<td style="text-align: right;"><b>'.$bottom_sub_group_prev_amt.'</b></td>
							</tr></table><table class="table1" border="1" style="width:100%;">';
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			foreach($ledgers3 as $led3) {
				$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led3->id, $sdate, $tdate);
				$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate);
				if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$datas[] = '<tr style="color: black;">
					<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;" href="' . base_url() .'/accountreport/ledger_report/?ledger=' . $led3->id . '&fdate=' . $sdate . '&tdate=' . $tdate .'" target="_blank">('.$led3->left_code .'/'.$led3->right_code .') '.$ledgername .'</a></td>
					<td style="text-align: right;">'.$ledger_amount.'</td>
					<td style="text-align: right;">'.$ledger_amount_previous.'</td>
					</tr>';
				}
				if(!empty($led3->pa)){
					$group_total += $current_pl;
					$datas[] = '<tr style="color: black;">
					<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
					<td style="text-align: right;">'.$current_pl_amount.'</td>
					<td style="text-align: right;">-</td>
					</tr>';
				}
				if(!empty($led3->hb)){
					if($history['dr_total'] != $history['cr_total']){
						$hb = $history['dr_total'] - $history['cr_total'];
						if($hb < 0){
							$hb_amount = "( ".number_format(abs($hb),2)." )";
						}
						else{
							$hb_amount = number_format($hb,2);
						}
						$datas[] = '<tr style="color: black;">
						<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
						<td style="text-align: right;">'.$hb_amount.'</td>
						<td style="text-align: right;">-</td>
						</tr>';
						$group_total += $hb;
					}
				}
			}
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS'){
				$assets_total = $group_total;
				$assets_total_prev = $group_total_prev;
			}elseif($r->name == 'Liabilities'){
				$liabilities_total = $group_total;
				$liabilities_total_prev = $group_total_prev;
			}else{
				$capital_total = $group_total;
				$capital_total_prev = $group_total_prev;
			}
			$datas[] = '<tr style="color: black; border-top:2px solid #000;">
							<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $r->name . '</b></td>
							<td style="text-align: right;"><b>'.$bottom_group_amt.'</b></td>
							<td style="text-align: right;"><b>'.$bottom_group_prev_amt.'</b></td>
							</tr></table><table class="table1" border="1" style="width:100%;">';
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		
		$net_assets_prev = $assets_total_prev - $liabilities_total_prev;
		if($assets_total_prev < 0){
			$assets_total_prev_amt = "( ".number_format(abs($assets_total_prev),2)." )";
		}
		else{
			$assets_total_prev_amt = number_format($assets_total_prev,2);
		}
		if($liabilities_total_prev < 0){
			$liabilities_total_prev_amt = "( ".number_format(abs($liabilities_total_prev),2)." )";
		}
		else{
			$liabilities_total_prev_amt = number_format($liabilities_total_prev,2);
		}
		$liabilities_equity_total_prev = $liabilities_total_prev + $capital_total_prev;
		if($liabilities_equity_total_prev < 0){
			$liabilities_equity_total_prev_amt = "( ".number_format(abs($liabilities_equity_total_prev),2)." )";
		}
		else{
			$liabilities_equity_total_prev_amt = number_format($liabilities_equity_total_prev,2);
		}
		if($net_assets_prev < 0){
			$net_assets_prev_amt = "( ".number_format(abs($net_assets_prev),2)." )";
		}
		else{
			$net_assets_prev_amt = number_format($net_assets_prev,2);
		}
		
	/* 	$datas[] = '<tr style="color: black;"><td style="text-transform: uppercase; width:390px; min-width:300px !important; padding:10px !important;"><b>Net Assets</b></td><td colspan="2"></td></tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Assets</a></td>
						<td style="text-align: right;"><b>'.$assets_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Liabilities</a></td>
						<td style="text-align: right;"><b>'.$liabilities_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>'; */
		$datas[] = '<tr style="color: black;">
						<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total Liabilities & Equity</b></td>
						<td style="text-align: right;"><b>'.$liabilities_equity_total_amt.'</b></td>
						<td style="text-align: right;"><b>'.$liabilities_equity_total_prev_amt.'</b></td>
					</tr>';
		$datas[] = '</table>';
		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();
		$data['sdate'] = $sdate;
		$data['tdate'] = $tdate;
		$data['list'] =$datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		// $data['fund_id'] = $fund_id;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/balancesheet_full', $data);
		echo view('template/footer');
    }
	public function print_balancesheet_full() {
		if($_POST['tpdate']) $tdate = $_POST['tpdate'];
		else $tdate = date("Y-m-d");
		$active_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		// $sdate = date("Y",strtotime($tdate))."-01-01";
		$sdate = $active_year['from_year_month'] . "-01";
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('code', array('1000', '2000', '3000'))->orderBy('code', 'ASC')->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = $assets_total_prev = $liabilities_total_prev = $capital_total_prev = 0;
		$whr = '';
		//if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (4000, 8000) or parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)))))$whr")->getRowArray();
		$history = history_of_balancing();
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
			$datas[] = '<tr style="color: black;">
							<td style="width: 60%;text-transform: uppercase; padding:10px !important;"><b>('.$r->code.') '.$r->name.'</b></td>
							<td style="width: 20%;text-align: right;"></td>
							<td style="width: 20%;text-align: right;"></td>
						</tr>';
			$group_one = $this->db->table('groups')->where('parent_id',$r->id)->orderBy('code', 'ASC')->get()->getResult();
			foreach($group_one as $go) {
				$sub_group_total = 0;
				$sub_group_total_prev = 0;
				$sub_group_data = array();
				$sub_group_data[] = '<tr style="color: black;">
							<td style="width: 60%; padding:8px !important;"><span style="margin-left: 2%; font-weight:bold; color: black;text-transform: uppercase;" >('.$go->code.') '.$go->name.'</span></td>
							<td style="width: 20%;text-align: right;"></td>
							<td style="width: 20%;text-align: right;"></td>
							</tr>';
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led1->id, $sdate, $tdate);
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate);
						if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$sub_group_total += $ledger_amt_rightcode;
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = $led1->name;
							$sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">('.$led1->left_code .'/'.$led1->right_code .') '.$ledgername .'</a></td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount.'</td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
						}
						if(!empty($led1->pa)){
							$group_total += $current_pl;
							$sub_group_total += $current_pl;
							$sub_group_data[] = '<tr style="color: black;">
							<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
							<td style="width: 20%;text-align: right;">'.$current_pl_amount.'</td>
							<td style="width: 20%;text-align: right;">-</td>
							</tr>';
						}
						if(!empty($led1->hb)){
							if($history['dr_total'] != $history['cr_total']){
								$hb = $history['dr_total'] - $history['cr_total'];
								if($hb < 0){
									$hb_amount = "( ".number_format(abs($hb),2)." )";
								}
								else{
									$hb_amount = number_format($hb,2);
								}
								$sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
								<td style="width: 20%;text-align: right;">'.$hb_amount.'</td>
								<td style="width: 20%;text-align: right;">-</td>
								</tr>';
								$group_total += $hb;
								$sub_group_total += $hb;
							}
						}
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->orderBy('code', 'ASC')->get()->getResult();
				foreach($group_two as $gt) {
					$sub_sub_group_total = 0;
					$sub_sub_group_total_prev = 0;
					$sub_sub_group_data = array();
					$sub_sub_group_data[] = '<tr style="color: black;">
							<td style="width: 60%; padding:8px !important;"><span style="margin-left: 4%; font-weight:bold; color: black;text-transform: uppercase;" >('.$gt->code.') '.$gt->name.'</span></td>
							<td style="width: 20%;text-align: right;"></td>
							<td style="width: 20%;text-align: right;"></td>
							</tr>';
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led2->id, $sdate, $tdate);
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate);
							if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$sub_group_total += $ledger_amt_rightcode;
								$sub_sub_group_total += $ledger_amt_rightcode;
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$sub_sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">('.$led2->left_code .'/'.$led2->right_code .') '.$ledgername .'</a></td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount.'</td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							}
							if(!empty($led2->pa)){
								$group_total += $current_pl;
								$sub_group_total += $current_pl;
								$sub_sub_group_total += $current_pl;
								$sub_sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="width: 20%;text-align: right;">'.$current_pl_amount.'</td>
								<td style="width: 20%;text-align: right;">-</td>
								</tr>';
							}
							if(!empty($led2->hb)){
								if($history['dr_total'] != $history['cr_total']){
									$hb = $history['dr_total'] - $history['cr_total'];
									if($hb < 0){
										$hb_amount = "( ".number_format(abs($hb),2)." )";
									}
									else{
										$hb_amount = number_format($hb,2);
									}
									$sub_sub_group_data[] = '<tr style="color: black;">
									<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
									<td style="width: 20%;text-align: right;">'.$hb_amount.'</td>
									<td style="width: 20%;text-align: right;">-</td>
									</tr>';
									$group_total += $hb;
									$sub_group_total += $hb;
									$sub_sub_group_total += $hb;
								}
							}
						}
					}
					if($sub_sub_group_total != 0){
						$sub_group_data[] = implode('', $sub_sub_group_data);
					}
					if($sub_sub_group_total < 0){
						$bottom_sub_sub_group_amt = "( ".number_format(abs($sub_sub_group_total),2)." )";
					}
					else{
						$bottom_sub_sub_group_amt = number_format($sub_sub_group_total,2);
					}
					// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
					if($sub_sub_group_total_prev < 0){
						$bottom_sub_sub_group_prev_amt = "( ".number_format(abs($sub_sub_group_total_prev),2)." )";
					}
					else{
						$bottom_sub_sub_group_prev_amt = number_format($sub_sub_group_total_prev,2);
					}
					if($sub_sub_group_total > 0 || $sub_sub_group_total_prev > 0){
						$sub_group_data[] = '<tr style="color: black; border-top:2px solid #000;">
									<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $gt->name . '</b></td>
									<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_sub_group_amt.'</b></td>
									<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_sub_group_prev_amt.'</b></td>
									</tr></table><table class="table1" border="1" style="width:100%;">';
					}
				}
				if($sub_group_total != 0){
					$datas[] = implode('', $sub_group_data);
				}
				if($sub_group_total < 0){
					$bottom_sub_group_amt = "( ".number_format(abs($sub_group_total),2)." )";
				}
				else{
					$bottom_sub_group_amt = number_format($sub_group_total,2);
				}
				// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
				if($sub_group_total_prev < 0){
					$bottom_sub_group_prev_amt = "( ".number_format(abs($sub_group_total_prev),2)." )";
				}
				else{
					$bottom_sub_group_prev_amt = number_format($sub_group_total_prev,2);
				}
				if($sub_group_total > 0 || $sub_group_total_prev > 0){
					$datas[] = '<tr style="color: black; border-top:2px solid #000;">
							<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $go->name . '</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_group_amt.'</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_group_prev_amt.'</b></td>
							</tr></table><table class="table1" border="1" style="width:100%;">';
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			foreach($ledgers3 as $led3) {
				$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led3->id, $sdate, $tdate);
				$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate);
				if(!empty($ledger_amt_rightcode) && !empty($ledger_amt_rightcode_previousyear)){
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$datas[] = '<tr style="color: black;">
					<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">('.$led3->left_code .'/'.$led3->right_code .') '.$ledgername .'</a></td>
					<td style="width: 20%;text-align: right;">'.$ledger_amount.'</td>
					<td style="width: 20%;text-align: right;">'.$ledger_amount_previous.'</td>
					</tr>';
				}
				if(!empty($led3->pa)){
					$group_total += $current_pl;
					$datas[] = '<tr style="color: black;">
					<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
					<td style="text-align: right;">'.$current_pl_amount.'</td>
					<td style="text-align: right;">-</td>
					</tr>';
				}
				if(!empty($led3->hb)){
					if($history['dr_total'] != $history['cr_total']){
						$hb = $history['dr_total'] - $history['cr_total'];
						if($hb < 0){
							$hb_amount = "( ".number_format(abs($hb),2)." )";
						}
						else{
							$hb_amount = number_format($hb,2);
						}
						$datas[] = '<tr style="color: black;">
						<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
						<td style="width: 20%;text-align: right;">'.$hb_amount.'</td>
						<td style="width: 20%;text-align: right;">-</td>
						</tr>';
						$group_total += $hb;
					}
				}
			}
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS'){
				$assets_total = $group_total;
				$assets_total_prev = $group_total_prev;
			}elseif($r->name == 'Liabilities'){
				$liabilities_total = $group_total;
				$liabilities_total_prev = $group_total_prev;
			}else{
				$capital_total = $group_total;
				$capital_total_prev = $group_total_prev;
			}
			$datas[] = '<tr style="color: black; border-top:2px solid #000;">
							<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $r->name . '</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_group_amt.'</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_group_prev_amt.'</b></td>
							</tr></table><table class="table1" border="1" style="width:100%;">';
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		
		$net_assets_prev = $assets_total_prev - $liabilities_total_prev;
		if($assets_total_prev < 0){
			$assets_total_prev_amt = "( ".number_format(abs($assets_total_prev),2)." )";
		}
		else{
			$assets_total_prev_amt = number_format($assets_total_prev,2);
		}
		if($liabilities_total_prev < 0){
			$liabilities_total_prev_amt = "( ".number_format(abs($liabilities_total_prev),2)." )";
		}
		else{
			$liabilities_total_prev_amt = number_format($liabilities_total_prev,2);
		}
		$liabilities_equity_total_prev = $liabilities_total_prev + $capital_total_prev;
		if($liabilities_equity_total_prev < 0){
			$liabilities_equity_total_prev_amt = "( ".number_format(abs($liabilities_equity_total_prev),2)." )";
		}
		else{
			$liabilities_equity_total_prev_amt = number_format($liabilities_equity_total_prev,2);
		}
		if($net_assets_prev < 0){
			$net_assets_prev_amt = "( ".number_format(abs($net_assets_prev),2)." )";
		}
		else{
			$net_assets_prev_amt = number_format($net_assets_prev,2);
		}
		
	/* 	$datas[] = '<tr style="color: black;"><td style="text-transform: uppercase; width:390px; min-width:300px !important; padding:10px !important;"><b>Net Assets</b></td><td colspan="2"></td></tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Assets</a></td>
						<td style="text-align: right;"><b>'.$assets_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Liabilities</a></td>
						<td style="text-align: right;"><b>'.$liabilities_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>'; */
		$datas[] = '<tr style="color: black;">
						<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total Liabilities & Equity</b></td>
						<td style="width: 20%;text-align: right;"><b>'.$liabilities_equity_total_amt.'</b></td>
						<td style="width: 20%;text-align: right;"><b>'.$liabilities_equity_total_prev_amt.'</b></td>
					</tr>';
		$datas[] = '</table>';			
		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();
		$data['list'] =$datas;
		$data['tdate'] =$tdate;
		echo view('account_report/print_balancesheet_full', $data);
	}
	public function pdf_balancesheet_full() {
		if($_REQUEST['tpdate']) $tdate = $_REQUEST['tpdate'];
		else $tdate = date("Y-m-d");
		$active_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		// $sdate = date("Y",strtotime($tdate))."-01-01";
		$sdate = $active_year['from_year_month'] . "-01";
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('code', array('1000', '2000', '3000'))->orderBy('code', 'ASC')->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = $assets_total_prev = $liabilities_total_prev = $capital_total_prev = 0;
		$whr = '';
		//if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (4000, 8000) or parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)))))$whr")->getRowArray();
		$history = history_of_balancing();
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
			$datas[] = '<tr style="color: black;">
							<td style="width: 60%;text-transform: uppercase; padding:10px !important;"><b>('.$r->code.') '.$r->name.'</b></td>
							<td style="width: 20%;text-align: right;"></td>
							<td style="width: 20%;text-align: right;"></td>
						</tr>';
			$group_one = $this->db->table('groups')->where('parent_id',$r->id)->orderBy('code', 'ASC')->get()->getResult();
			foreach($group_one as $go) {
				$sub_group_total = 0;
				$sub_group_total_prev = 0;
				$sub_group_data = array();
				$sub_group_data[] = '<tr style="color: black;">
							<td style="width: 60%; padding:8px !important;"><span style="margin-left: 2%; font-weight:bold; color: black;text-transform: uppercase;" >('.$go->code.') '.$go->name.'</span></td>
							<td style="width: 20%;text-align: right;"></td>
							<td style="width: 20%;text-align: right;"></td>
							</tr>';
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led1->id, $sdate, $tdate);
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate);
						if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$sub_group_total += $ledger_amt_rightcode;
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = $led1->name;
							$sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">('.$led1->left_code .'/'.$led1->right_code .') '.$ledgername .'</a></td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount.'</td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
						}
						if(!empty($led1->pa)){
							$group_total += $current_pl;
							$sub_group_total += $current_pl;
							$sub_group_data[] = '<tr style="color: black;">
							<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
							<td style="width: 20%;text-align: right;">'.$current_pl_amount.'</td>
							<td style="width: 20%;text-align: right;">-</td>
							</tr>';
						}
						if(!empty($led1->hb)){
							if($history['dr_total'] != $history['cr_total']){
								$hb = $history['dr_total'] - $history['cr_total'];
								if($hb < 0){
									$hb_amount = "( ".number_format(abs($hb),2)." )";
								}
								else{
									$hb_amount = number_format($hb,2);
								}
								$sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
								<td style="width: 20%;text-align: right;">'.$hb_amount.'</td>
								<td style="width: 20%;text-align: right;">-</td>
								</tr>';
								$group_total += $hb;
								$sub_group_total += $hb;
							}
						}
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->orderBy('code', 'ASC')->get()->getResult();
				foreach($group_two as $gt) {
					$sub_sub_group_total = 0;
					$sub_sub_group_total_prev = 0;
					$sub_sub_group_data = array();
					$sub_sub_group_data[] = '<tr style="color: black;">
							<td style="width: 60%; padding:8px !important;"><span style="margin-left: 4%; font-weight:bold; color: black;text-transform: uppercase;" >('.$gt->code.') '.$gt->name.'</span></td>
							<td style="width: 20%;text-align: right;"></td>
							<td style="width: 20%;text-align: right;"></td>
							</tr>';
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led2->id, $sdate, $tdate);
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate);
							if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$sub_group_total += $ledger_amt_rightcode;
								$sub_sub_group_total += $ledger_amt_rightcode;
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$sub_sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">('.$led2->left_code .'/'.$led2->right_code .') '.$ledgername .'</a></td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount.'</td>
								<td style="width: 20%;text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							}
							if(!empty($led2->pa)){
								$group_total += $current_pl;
								$sub_group_total += $current_pl;
								$sub_sub_group_total += $current_pl;
								$sub_sub_group_data[] = '<tr style="color: black;">
								<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="width: 20%;text-align: right;">'.$current_pl_amount.'</td>
								<td style="width: 20%;text-align: right;">-</td>
								</tr>';
							}
							if(!empty($led2->hb)){
								if($history['dr_total'] != $history['cr_total']){
									$hb = $history['dr_total'] - $history['cr_total'];
									if($hb < 0){
										$hb_amount = "( ".number_format(abs($hb),2)." )";
									}
									else{
										$hb_amount = number_format($hb,2);
									}
									$sub_sub_group_data[] = '<tr style="color: black;">
									<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
									<td style="width: 20%;text-align: right;">'.$hb_amount.'</td>
									<td style="width: 20%;text-align: right;">-</td>
									</tr>';
									$group_total += $hb;
									$sub_group_total += $hb;
									$sub_sub_group_total += $hb;
								}
							}
						}
					}
					if($sub_sub_group_total != 0){
						$sub_group_data[] = implode('', $sub_sub_group_data);
					}
					if($sub_sub_group_total < 0){
						$bottom_sub_sub_group_amt = "( ".number_format(abs($sub_sub_group_total),2)." )";
					}
					else{
						$bottom_sub_sub_group_amt = number_format($sub_sub_group_total,2);
					}
					// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
					if($sub_sub_group_total_prev < 0){
						$bottom_sub_sub_group_prev_amt = "( ".number_format(abs($sub_sub_group_total_prev),2)." )";
					}
					else{
						$bottom_sub_sub_group_prev_amt = number_format($sub_sub_group_total_prev,2);
					}
					if($sub_sub_group_total > 0 || $sub_sub_group_total_prev > 0){
						$sub_group_data[] = '<tr style="color: black; border-top:2px solid #000;">
									<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $gt->name . '</b></td>
									<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_sub_group_amt.'</b></td>
									<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_sub_group_prev_amt.'</b></td>
									</tr></table><table class="table1" border="1" style="width:100%;">';
					}
				}
				if($sub_group_total != 0){
					$datas[] = implode('', $sub_group_data);
				}
				if($sub_group_total < 0){
					$bottom_sub_group_amt = "( ".number_format(abs($sub_group_total),2)." )";
				}
				else{
					$bottom_sub_group_amt = number_format($sub_group_total,2);
				}
				// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
				if($sub_group_total_prev < 0){
					$bottom_sub_group_prev_amt = "( ".number_format(abs($sub_group_total_prev),2)." )";
				}
				else{
					$bottom_sub_group_prev_amt = number_format($sub_group_total_prev,2);
				}
				if($sub_group_total > 0 || $sub_group_total_prev > 0){
					$datas[] = '<tr style="color: black; border-top:2px solid #000;">
							<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $go->name . '</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_group_amt.'</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_sub_group_prev_amt.'</b></td>
							</tr></table><table class="table1" border="1" style="width:100%;">';
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			foreach($ledgers3 as $led3) {
				$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led3->id, $sdate, $tdate);
				$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate);
				if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$datas[] = '<tr style="color: black;">
					<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">('.$led3->left_code .'/'.$led3->right_code .') '.$ledgername .'</a></td>
					<td style="width: 20%;text-align: right;">'.$ledger_amount.'</td>
					<td style="width: 20%;text-align: right;">'.$ledger_amount_previous.'</td>
					</tr>';
				}
				if(!empty($led3->pa)){
					$group_total += $current_pl;
					$datas[] = '<tr style="color: black;">
					<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;">Current Profit & Loss</a></td>
					<td style="text-align: right;">'.$current_pl_amount.'</td>
					<td style="text-align: right;">-</td>
					</tr>';
				}
				if(!empty($led3->hb)){
					if($history['dr_total'] != $history['cr_total']){
						$hb = $history['dr_total'] - $history['cr_total'];
						if($hb < 0){
							$hb_amount = "( ".number_format(abs($hb),2)." )";
						}
						else{
							$hb_amount = number_format($hb,2);
						}
						$datas[] = '<tr style="color: black;">
						<td style="width: 60%;"><a style="margin-left: 6%;cursor: pointer;">Historical Balancing</a></td>
						<td style="width: 20%;text-align: right;">'.$hb_amount.'</td>
						<td style="width: 20%;text-align: right;">-</td>
						</tr>';
						$group_total += $hb;
					}
				}
			}
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS'){
				$assets_total = $group_total;
				$assets_total_prev = $group_total_prev;
			}elseif($r->name == 'Liabilities'){
				$liabilities_total = $group_total;
				$liabilities_total_prev = $group_total_prev;
			}else{
				$capital_total = $group_total;
				$capital_total_prev = $group_total_prev;
			}
			$datas[] = '<tr style="color: black; border-top:2px solid #000;">
							<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total ' . $r->name . '</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_group_amt.'</b></td>
							<td style="width: 20%;text-align: right;"><b>'.$bottom_group_prev_amt.'</b></td>
							</tr></table><table class="table1" border="1" style="width:100%;">';
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		
		$net_assets_prev = $assets_total_prev - $liabilities_total_prev;
		if($assets_total_prev < 0){
			$assets_total_prev_amt = "( ".number_format(abs($assets_total_prev),2)." )";
		}
		else{
			$assets_total_prev_amt = number_format($assets_total_prev,2);
		}
		if($liabilities_total_prev < 0){
			$liabilities_total_prev_amt = "( ".number_format(abs($liabilities_total_prev),2)." )";
		}
		else{
			$liabilities_total_prev_amt = number_format($liabilities_total_prev,2);
		}
		$liabilities_equity_total_prev = $liabilities_total_prev + $capital_total_prev;
		if($liabilities_equity_total_prev < 0){
			$liabilities_equity_total_prev_amt = "( ".number_format(abs($liabilities_equity_total_prev),2)." )";
		}
		else{
			$liabilities_equity_total_prev_amt = number_format($liabilities_equity_total_prev,2);
		}
		if($net_assets_prev < 0){
			$net_assets_prev_amt = "( ".number_format(abs($net_assets_prev),2)." )";
		}
		else{
			$net_assets_prev_amt = number_format($net_assets_prev,2);
		}
		
	/* 	$datas[] = '<tr style="color: black;"><td style="text-transform: uppercase; width:390px; min-width:300px !important; padding:10px !important;"><b>Net Assets</b></td><td colspan="2"></td></tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Assets</a></td>
						<td style="text-align: right;"><b>'.$assets_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Liabilities</a></td>
						<td style="text-align: right;"><b>'.$liabilities_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>'; */
		$datas[] = '<tr style="color: black;">
						<td style="width: 60%;text-transform: uppercase; text-align:center;"><b>Total Liabilities & Equity</b></td>
						<td style="width: 20%;text-align: right;"><b>'.$liabilities_equity_total_amt.'</b></td>
						<td style="width: 20%;text-align: right;"><b>'.$liabilities_equity_total_prev_amt.'</b></td>
					</tr>';
		$datas[] = '</table>';			
		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();
		$data['list'] =$datas;
		$data['tdate'] =$tdate;
		$html = view('account_report/print_balancesheet_full', $data);
		$options = new Options();
		$options->set('isHtml5ParserEnabled', true);
		$options->set(array('isRemoteEnabled'=>true));
		$options->set('isPhpEnabled', true);
		$dompdf = new Dompdf($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream("balancesheet.pdf", array("Attachment" => true));
	}
	public function excel_balancesheet_full() {
		if($_REQUEST['tpdate']) $tdate = $_REQUEST['tpdate'];
		else $tdate = date("Y-m-d");
		$active_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		// $sdate = date("Y",strtotime($tdate))."-01-01";
		$sdate = $active_year['from_year_month'] . "-01";
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('code', array('1000', '2000', '3000'))->orderBy('code', 'ASC')->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = $assets_total_prev = $liabilities_total_prev = $capital_total_prev = 0;
		$whr = '';
		//if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (4000, 8000) or parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)))))$whr")->getRowArray();
		$history = history_of_balancing();
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
			$datas[] = array(
						"accountname"=>'('.$r->code.') '.$r->name,
						"amount"=>"",
						"previousyear_amount"=>""
					);
			$group_one = $this->db->table('groups')->where('parent_id',$r->id)->orderBy('code', 'ASC')->get()->getResult();
			foreach($group_one as $go) {
				$sub_group_total = 0;
				$sub_group_total_prev = 0;
				$sub_group_data = array();
				$datas[] = array(
						"accountname"=>'('.$go->code.') '.$go->name,
						"amount"=>"",
						"previousyear_amount"=>""
					);
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led1->id, $sdate, $tdate);
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate);
						if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$sub_group_total += $ledger_amt_rightcode;
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = $led1->name;
							$sub_group_data[] = array(
								"accountname"=> '('.$led1->left_code .'/'.$led1->right_code .') '.$ledgername,
								"amount"=> $ledger_amount,
								"previousyear_amount"=> $ledger_amount_previous
							);
						}
						if(!empty($led1->pa)){
							$group_total += $current_pl;
							$sub_group_total += $current_pl;
							$sub_group_data[] = array(
								"accountname"=> 'Current Profit & Loss',
								"amount"=> $current_pl_amount,
								"previousyear_amount"=> ''
							);
						}
						if(!empty($led1->hb)){
							if($history['dr_total'] != $history['cr_total']){
								$hb = $history['dr_total'] - $history['cr_total'];
								if($hb < 0){
									$hb_amount = "( ".number_format(abs($hb),2)." )";
								}
								else{
									$hb_amount = number_format($hb,2);
								}
								$sub_group_data[] = array(
									"accountname"=> 'Historical Balancing',
									"amount"=> $hb_amount,
									"previousyear_amount"=> ''
								);
								$group_total += $hb;
								$sub_group_total += $hb;
							}
						}
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->orderBy('code', 'ASC')->get()->getResult();
				foreach($group_two as $gt) {
					$sub_sub_group_total = 0;
					$sub_sub_group_total_prev = 0;
					$sub_sub_group_data = array();
					$sub_sub_group_data[] = array(
									"accountname"=> '('.$gt->code.') '.$gt->name,
									"amount"=> '',
									"previousyear_amount"=> ''
								);
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led2->id, $sdate, $tdate);
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate);
							if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$sub_group_total += $ledger_amt_rightcode;
								$sub_sub_group_total += $ledger_amt_rightcode;
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$sub_sub_group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$sub_sub_group_data[] = array(
									"accountname"=> '('.$led2->left_code .'/'.$led2->right_code .') '.$ledgername,
									"amount"=> $ledger_amount,
									"previousyear_amount"=> $ledger_amount_previous
								);
							}
							if(!empty($led2->pa)){
								$group_total += $current_pl;
								$sub_group_total += $current_pl;
								$sub_sub_group_total += $current_pl;
								$sub_sub_group_data[] = array(
									"accountname"=> 'Current Profit & Loss',
									"amount"=> $current_pl_amount,
									"previousyear_amount"=> ''
								);
							}
							if(!empty($led2->hb)){
								if($history['dr_total'] != $history['cr_total']){
									$hb = $history['dr_total'] - $history['cr_total'];
									if($hb < 0){
										$hb_amount = "( ".number_format(abs($hb),2)." )";
									}
									else{
										$hb_amount = number_format($hb,2);
									}
									$sub_sub_group_data[] = array(
										"accountname"=> 'Historical Balancing',
										"amount"=> $hb_amount,
										"previousyear_amount"=> ''
									);
									$group_total += $hb;
									$sub_group_total += $hb;
									$sub_sub_group_total += $hb;
								}
							}
						}
					}
					if($sub_sub_group_total != 0){
						if(count($sub_sub_group_data) > 0){
							foreach($sub_sub_group_data as $sggd){
								$sub_group_data[] = $sggd;
							}
						}
					}
					if($sub_sub_group_total < 0){
						$bottom_sub_sub_group_amt = "( ".number_format(abs($sub_sub_group_total),2)." )";
					}
					else{
						$bottom_sub_sub_group_amt = number_format($sub_sub_group_total,2);
					}
					// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
					if($sub_sub_group_total_prev < 0){
						$bottom_sub_sub_group_prev_amt = "( ".number_format(abs($sub_sub_group_total_prev),2)." )";
					}
					else{
						$bottom_sub_sub_group_prev_amt = number_format($sub_sub_group_total_prev,2);
					}
					if($sub_sub_group_total > 0 || $sub_sub_group_total_prev > 0){
						$sub_group_data[] = array(
								"accountname"=> 'Total ' . $gt->name,
								"amount"=> $bottom_sub_sub_group_amt,
								"previousyear_amount"=> $bottom_sub_sub_group_prev_amt
							);
					}
				}
				if($sub_group_total != 0){
					if(count($sub_group_data) > 0){
						foreach($sub_group_data as $sgd){
							$datas[] = $sgd;
						}
					}
				}
				if($sub_group_total < 0){
					$bottom_sub_group_amt = "( ".number_format(abs($sub_group_total),2)." )";
				}
				else{
					$bottom_sub_group_amt = number_format($sub_group_total,2);
				}
				// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
				if($sub_group_total_prev < 0){
					$bottom_sub_group_prev_amt = "( ".number_format(abs($sub_group_total_prev),2)." )";
				}
				else{
					$bottom_sub_group_prev_amt = number_format($sub_group_total_prev,2);
				}
				if($sub_group_total > 0 || $sub_group_total_prev > 0){
					$datas[] = array(
						"accountname"=> 'Total ' . $gt->name,
						"amount"=> $bottom_sub_group_amt,
						"previousyear_amount"=> $bottom_sub_group_prev_amt
					);
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			foreach($ledgers3 as $led3) {
				$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led3->id, $sdate, $tdate);
				$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate);
				if(!empty($ledger_amt_rightcode) || !empty($ledger_amt_rightcode_previousyear)){
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$datas[] = array(
						"accountname"=> '('.$led3->left_code .'/'.$led3->right_code .') '.$ledgername,
						"amount"=> $ledger_amount,
						"previousyear_amount"=> $ledger_amount_previous
					);
				}
				if(!empty($led3->pa)){
					$group_total += $current_pl;
					$datas[] = array(
						"accountname"=> 'Current Profit & Loss',
						"amount"=> $current_pl_amount,
						"previousyear_amount"=> ''
					);
				}
				if(!empty($led3->hb)){
					if($history['dr_total'] != $history['cr_total']){
						$hb = $history['dr_total'] - $history['cr_total'];
						if($hb < 0){
							$hb_amount = "( ".number_format(abs($hb),2)." )";
						}
						else{
							$hb_amount = number_format($hb,2);
						}
						$datas[] = array(
							"accountname"=> 'Historical Balancing',
							"amount"=> $hb_amount,
							"previousyear_amount"=> ''
						);
						$group_total += $hb;
					}
				}
			}
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS'){
				$assets_total = $group_total;
				$assets_total_prev = $group_total_prev;
			}elseif($r->name == 'Liabilities'){
				$liabilities_total = $group_total;
				$liabilities_total_prev = $group_total_prev;
			}else{
				$capital_total = $group_total;
				$capital_total_prev = $group_total_prev;
			}
			$datas[] = array(
					"accountname"=> 'Total ' . $r->name,
					"amount"=> $bottom_group_amt,
					"previousyear_amount"=> $bottom_group_prev_amt
				);
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		
		$net_assets_prev = $assets_total_prev - $liabilities_total_prev;
		if($assets_total_prev < 0){
			$assets_total_prev_amt = "( ".number_format(abs($assets_total_prev),2)." )";
		}
		else{
			$assets_total_prev_amt = number_format($assets_total_prev,2);
		}
		if($liabilities_total_prev < 0){
			$liabilities_total_prev_amt = "( ".number_format(abs($liabilities_total_prev),2)." )";
		}
		else{
			$liabilities_total_prev_amt = number_format($liabilities_total_prev,2);
		}
		$liabilities_equity_total_prev = $liabilities_total_prev + $capital_total_prev;
		if($liabilities_equity_total_prev < 0){
			$liabilities_equity_total_prev_amt = "( ".number_format(abs($liabilities_equity_total_prev),2)." )";
		}
		else{
			$liabilities_equity_total_prev_amt = number_format($liabilities_equity_total_prev,2);
		}
		if($net_assets_prev < 0){
			$net_assets_prev_amt = "( ".number_format(abs($net_assets_prev),2)." )";
		}
		else{
			$net_assets_prev_amt = number_format($net_assets_prev,2);
		}
		
	/* 	$datas[] = '<tr style="color: black;"><td style="text-transform: uppercase; width:390px; min-width:300px !important; padding:10px !important;"><b>Net Assets</b></td><td colspan="2"></td></tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Assets</a></td>
						<td style="text-align: right;"><b>'.$assets_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>';
		$datas[] = '<tr>
						<td><a style="margin-left: 4%;cursor: pointer;">Total Liabilities</a></td>
						<td style="text-align: right;"><b>'.$liabilities_total_amt.'</b></td>
						<td style="text-align: right;"></td>
					</tr>'; */
		$datas[] = array(
					"accountname"=> 'Total Liabilities & Equity',
					"amount"=> $liabilities_equity_total_amt,
					"previousyear_amount"=> $liabilities_equity_total_prev_amt
				);
		$fileName = "balancesheet_rightcode_triplezero_".$sdate."_to_".$tdate;  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->getStyle('A2:C2')->getFont()->setBold(true);
        $sheet->getStyle("A1:C1")->applyFromArray($style);
        $sheet->mergeCells('A1:C1'); 
        $sheet->setCellValue('A1', "SREE SELVA VINAYAGAR TEMPLE");
        $sheet->setCellValue('A2', 'Account Name');
        $sheet->setCellValue('B2', 'Current Year');     
        $sheet->setCellValue('C2', 'Previous Year');     
        $rows = 3;
        foreach ($datas as $val)
        {
            $sheet->setCellValue('A' . $rows, $val['accountname']);
            $sheet->setCellValue('B' . $rows, $val['amount']);
            $sheet->setCellValue('C' . $rows, $val['previousyear_amount']);
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('uploads/excel/'.$fileName.'.xlsx');
        return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');
	}
	public function print_balancesheet_rightcode_triplezero() {
		if($_POST['tdate']) $tdate = $_POST['tdate'];
		else $tdate = date("Y-m-d");
		$sdate = date("Y",strtotime($tdate))."-01-01";
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : '');
		$datas = array();
		$groups = $this->db->table('groups')->whereIn('name', array('Assets', 'Liabilities', 'Capital'))->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = 0;
		$whr = '';
		// if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes' or parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes') or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes'))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses' or parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses') or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses'))))$whr")->getRowArray();
		
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate, $fund_id);
			if($ledger_top_group_amt_zero_check < 0){
				$top_group_amt = "( ".number_format(abs($ledger_top_group_amt_zero_check),2)." )";
			}
			else{
				$top_group_amt = number_format($ledger_top_group_amt_zero_check,2);
			}
			$datas[] = '<tr style="color: black;">
							<td style="width: 40%;text-transform: uppercase;"><b>'.$r->name.'</b></td>
							<td style="text-align: right;"></td>
							<td style="text-align: right;"></td>
						</tr>';
				$group_one = $this->db->table('groups')->where('parent_id',$r->id)->get()->getResult();
				foreach($group_one as $go) {
					$ledger_group_amt_zero_check = number_format(get_group_amt_new_rightcode_triplezero_subtotal($go->id, $sdate, $tdate, $fund_id),2);
					/* if($ledger_group_amt_zero_check != 0)
					{
						$ledger_sub_group_amt_zero_check = get_group_amt_new_rightcode_triplezero($go->id, $sdate, $tdate, $fund_id);
						if($ledger_sub_group_amt_zero_check < 0){
							$group_amt = "( ".number_format(abs($ledger_sub_group_amt_zero_check),2)." )";
						}
						else{
							$group_amt = number_format($ledger_sub_group_amt_zero_check,2);
						}
						$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><span style="margin-left: 2%;color: black;text-transform: uppercase;" >'.$go->name.'</span></td>
								<td style="text-align: right;"></td>
								<td style="text-align: right;"></td>
								</tr>';
					} */
					$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><span style="margin-left: 2%;color: black;text-transform: uppercase;" >'.$go->name.'</span></td>
								<td style="text-align: right;"></td>
								<td style="text-align: right;"></td>
								</tr>';
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->where('right_code','000')->get()->getResult();
				$ls_ledgers1 = array();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led1->id, $sdate, $tdate, $fund_id),2);
						$ls_ledgers1[] = $led1->left_code;
						// echo $led1->name;
						// echo '<br>';
						// echo $ledger_amt_zero_check;
						// echo '<br>';
						if($ledger_amt_zero_check != 0)
						{
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led1->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = get_ledger_name_only($led1->id);
							$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;" >'.$ledgername .'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							if(!empty($led1->pa)){
								$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="text-align: right;">'.$current_pl_amount.'</td>
								<td style="text-align: right;">-</td>
								</tr>';
							}
						}					
					}
				}
				if(count($ls_ledgers1) > 0){
					$ledgers11 = $this->db->table('ledgers')->where('group_id',$go->id)->whereNotIn('left_code', $ls_ledgers1)->get()->getResult();
				}else{
					$ledgers11 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				}
				if(count($ledgers11) > 0){
					foreach($ledgers11 as $led11) {
						$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led11->id, $sdate, $tdate, $fund_id),2);
						// echo $led11->name;
						// echo '<br>';
						// echo $ledger_amt_zero_check;
						// echo '<br>';
						if($ledger_amt_zero_check != 0)
						{
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led11->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led11->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = get_ledger_name_only($led11->id);
							$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">'.$ledgername.'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
							if(!empty($led11->pa)){
								$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
								<td style="text-align: right;">'.$current_pl_amount.'</td>
								<td style="text-align: right;">-</td>
								</tr>';
							}
						}					
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->get()->getResult();
				foreach($group_two as $gt) {
					$ledger_group_amt_zero_check = number_format(get_group_amt_new_rightcode_triplezero_subtotal($gt->id, $sdate, $tdate, $fund_id),2);
					if($ledger_group_amt_zero_check != 0)
					{
						$ledger_sub_group_amt_zero_check = get_group_amt_new_rightcode_triplezero($gt->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_sub_group_amt_zero_check = -1 * $ledger_sub_group_amt_zero_check;
						if($ledger_sub_group_amt_zero_check < 0){
							$group_amt = "( ".number_format(abs($ledger_sub_group_amt_zero_check),2)." )";
						}
						else{
							$group_amt = number_format($ledger_sub_group_amt_zero_check,2);
						}
						$group_total += $ledger_sub_group_amt_zero_check;
						$ledger_sub_group_amt_previousyear = get_group_amt_new_rightcode_triplezero_previousyear($gt->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_sub_group_amt_previousyear = -1 * $ledger_sub_group_amt_previousyear;
						if($ledger_sub_group_amt_previousyear < 0){
							$ledger_amount_previous = "( ".number_format(abs($ledger_sub_group_amt_previousyear),2)." )";
						}
						else{
							$ledger_amount_previous = number_format($ledger_sub_group_amt_previousyear,2);
						}
						$group_total_prev += $ledger_sub_group_amt_previousyear;
						$datas[] = '<tr style="color: black;">
							<td style="width: 40%;"><span style="margin-left: 4%;text-transform: uppercase;">'.$gt->name.'</span></td>
							<td style="text-align: right;">'.$group_amt.'</td>
							<td style="text-align: right;">'.$ledger_amount_previous.'</td>
							</tr>';
					}
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->where('right_code','000')->get()->getResult();
					$ls_ledgers2 = array();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led2->id, $sdate, $tdate, $fund_id),2);
							$ls_ledgers2[] = $led2->left_code;
							// echo $led2->name;
							// echo '<br>';
							// echo $ledger_amt_zero_check;
							// echo '<br>';
							if($ledger_amt_zero_check != 0)
							{
								$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led2->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$datas[] = '<tr style="color: black;">
								<td style="width: 40%;"><a style="margin-left: 6%;cursor: pointer;" >'.$ledgername.'</a></td>
								<td style="text-align: right;">'.$ledger_amount.'</td>
								<td style="text-align: right;">'.$ledger_amount_previous.'</td>
								</tr>';
								if(!empty($led2->pa)){
									$datas[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
									<td style="text-align: right;">'.$current_pl_amount.'</td>
									<td style="text-align: right;">-</td>
									</tr>';
								}
							}
						}
					}
					if(count($ls_ledgers2) > 0){
						$ledgers22 = $this->db->table('ledgers')->where('group_id',$gt->id)->whereNotIn('left_code', $ls_ledgers2)->get()->getResult();
					}else{
						$ledgers22 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					}
					if(count($ledgers22) > 0){
						foreach($ledgers22 as $led22) {
							$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led22->id, $sdate, $tdate, $fund_id),2);
							// echo $led22->name;
							// echo '<br>';
							// echo $ledger_amt_zero_check;
							// echo '<br>';
							if($ledger_amt_zero_check != 0)
							{
								$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led22->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led22->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led22->id);
								$datas[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">'.$ledgername.'</a></td>
									<td style="text-align: right;">'.$ledger_amount.'</td>
									<td style="text-align: right;">'.$ledger_amount_previous.'</td>
									</tr>';
								if(!empty($led22->pa)){
									$datas[] = '<tr style="color: black;">
									<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
									<td style="text-align: right;">'.$current_pl_amount.'</td>
									<td style="text-align: right;">-</td>
									</tr>';
								}
							}					
						}
					}
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->where('right_code','000')->get()->getResult();
			$ls_ledgers3 = array();
			foreach($ledgers3 as $led3) {
				$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led3->id, $sdate, $tdate, $fund_id),2);
				$ls_ledgers3[] = $led3->left_code;
				if($ledger_amt_zero_check != 0)
				{
					$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led3->id, $sdate, $tdate, $fund_id);
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate, $fund_id);
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$datas[] = '<tr style="color: black;">
					<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;" >'.$ledgername.'</a></td>
					<td style="text-align: right;">'.$ledger_amount.'</td>
					<td style="text-align: right;">'.$ledger_amount_previous.'</td>
					</tr>';
					if(!empty($led3->pa)){
						$datas[] = '<tr style="color: black;">
						<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
						<td style="text-align: right;">'.$current_pl_amount.'</td>
						<td style="text-align: right;">-</td>
						</tr>';
					}
				}
			}
			if(count($ls_ledgers3) > 0){
				$ledgers33 = $this->db->table('ledgers')->where('group_id',$r->id)->whereNotIn('left_code', $ls_ledgers3)->get()->getResult();
			}else{
				$ledgers33 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			}
			if(count($ledgers33) > 0){
				foreach($ledgers33 as $led33) {
					$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led33->id, $sdate, $tdate, $fund_id),2);
					// echo $led33->name;
					// echo '<br>';
					// echo $ledger_amt_zero_check;
					// echo '<br>';
					if($ledger_amt_zero_check != 0)
					{
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led33->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
						if($ledger_amt_rightcode < 0){
							$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
						}
						else{
							$ledger_amount = number_format($ledger_amt_rightcode,2);
						}
						$group_total += $ledger_amt_rightcode;
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led33->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
						if($ledger_amt_rightcode_previousyear < 0){
							$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
						}
						else{
							$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
						}
						$group_total_prev += $ledger_amt_rightcode_previousyear;
						$ledgername = get_ledger_name_only($led33->id);
						$datas[] = '<tr style="color: black;">
							<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">'.$ledgername . '</a></td>
							<td style="text-align: right;">'.$ledger_amount.'</td>
							<td style="text-align: right;">'.$ledger_amount_previous.'</td>
							</tr>';
						if(!empty($led33->pa)){
							$datas[] = '<tr style="color: black;">
							<td style="width: 40%;"><a style="margin-left: 4%;cursor: pointer;">Current Profit & Loss</a></td>
							<td style="text-align: right;">'.$current_pl_amount.'</td>
							<td style="text-align: right;">-</td>
							</tr>';
							$group_total += $current_pl;
						}
					}					
				}
			}
			// $ledger_bottom_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id,  $sdate, $tdate, $fund_id);
			// if($ledger_bottom_group_amt_zero_check < 0){
				// $bottom_group_amt = "( ".number_format(abs($ledger_bottom_group_amt_zero_check),2)." )";
			// }
			// else{
				// $bottom_group_amt = number_format($ledger_bottom_group_amt_zero_check,2);
			// }
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS') $assets_total = $group_total;
			elseif($r->name == 'Liabilities') $liabilities_total = $group_total;
			else $capital_total = $group_total;
			$datas[] = '<tr style="color: black;">
					   		<td style="width: 60%;text-transform: uppercase;"><b>Total ' . $r->name . '</b></td>
							<td style="text-align: right;"><b>'.$bottom_group_amt.'</b></td>
							<td style="text-align: right;"><b>'.$bottom_group_prev_amt.'</b></td>
					   		</tr></table><table class="table1" border="1" style="width:100%;">';
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		$datas[] = '<tr style="color: black;"><td style="text-transform: uppercase; width:390px; padding:10px !important; min-width:300px !important;"><b>Net Assets</b></td><td colspan="2"></td></tr>
					<tr>
						<td style="width: 60%;"><a style="margin-left: 4%;cursor: pointer;">Total Assets</a></td>
						<td style="text-align: right;min-width: 120px;"><b>'.$assets_total_amt.'</b></td>
						<td style="text-align: right;min-width: 120px;"></td>
					</tr>
					<tr>
						<td style="width: 60%;"><a style="margin-left: 4%;cursor: pointer;">Total Liabilities</a></td>
						<td style="text-align: right;min-width: 120px;"><b>'.$liabilities_total_amt.'</b></td>
						<td style="text-align: right;min-width: 120px;"></td>
					</tr>
					<tr>
						<td style="width: 60%;"><a style="margin-left: 4%;cursor: pointer;">Total Liabilities & Equity</a></td>
						<td style="text-align: right;min-width: 120px;"><b>'.$liabilities_equity_total_amt.'</b></td>
						<td style="text-align: right;min-width: 120px;"></td>
					</tr>
					<tr>
						<td style="width: 60%;"><a style="margin-left: 4%;cursor: pointer;">Net Assets</a></td>
						<td style="text-align: right;min-width: 120px;"><b>'.$net_assets_amt.'</b></td>
						<td style="text-align: right;min-width: 120px;"></td>
					</tr>
					</table>';
		$groups2 = $this->db->table('groups')->where('name','Liabilities and Owners Equity')->get()->getResult();
		$data['list'] =$datas;
		echo view('account_report/print_balancesheet_rightcode_triplezero', $data);
	}
	public function excel_balancesheet_rightcode_triplezero() {
		if($_POST['fdate']) $sdate = $_POST['fdate'];
		else $sdate = date("Y-m-01");
		if($_POST['tdate']) $tdate = $_POST['tdate'];
		else $tdate = date("Y-m-d");
		$fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : '');
		$data = array();
		$groups = $this->db->table('groups')->whereIn('name', array('Assets', 'Liabilities', 'Capital'))->get()->getResult();
		$assets_total = $liabilities_total = $capital_total = 0;
		$whr = '';
		if(!empty($fund_id)) $whr = " and e.fund_id=$fund_id";
		$curret_incomes_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes' or parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes') or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Incomes'))))$whr")->getRowArray();
		
		$curret_expenses_arr = $this->db->query("SELECT COALESCE(sum(if(dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(dc = 'D', amount, 0)), 0) as dr_total FROM `entries` e left join entryitems ei on e.id = ei.entry_id where e.date >= '$sdate' and e.date <= '$tdate' and ei.ledger_id in (SELECT id FROM `ledgers` where group_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses' or parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses') or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE `name` LIKE 'Expenses'))))$whr")->getRowArray();
		
		$current_incomes = $curret_incomes_arr['cr_total'] - $curret_incomes_arr['dr_total'];
		$current_expenses = $curret_expenses_arr['dr_total'] - $curret_expenses_arr['cr_total'];
		$current_pl = $current_incomes - $current_expenses;
		if($current_pl < 0){
			$current_pl_amount = "( ".number_format(abs($current_pl),2)." )";
		}
		else{
			$current_pl_amount = number_format($current_pl,2);
		}
		foreach($groups as $r) {
			$group_total = 0;
			$group_total_prev = 0;
			$ledger_top_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate, $fund_id);
			if($ledger_top_group_amt_zero_check < 0){
				$top_group_amt = "( ".number_format(abs($ledger_top_group_amt_zero_check),2)." )";
			}
			else{
				$top_group_amt = number_format($ledger_top_group_amt_zero_check,2);
			}
			$data[] = array(
						"accountname"=>$r->name,
						"amount"=>"",
						"previousyear_amount"=>""
					);
				$group_one = $this->db->table('groups')->where('parent_id',$r->id)->get()->getResult();
				foreach($group_one as $go) {
					$ledger_group_amt_zero_check = number_format(get_group_amt_new_rightcode_triplezero_subtotal($go->id, $sdate, $tdate, $fund_id),2);
					$data[] = array(
								"accountname"=>$go->name,
								"amount"=>"",
								"previousyear_amount"=>""
							);
				$ledgers1 = $this->db->table('ledgers')->where('group_id',$go->id)->where('right_code','000')->get()->getResult();
				$ls_ledgers1 = array();
				if(count($ledgers1) > 0){
					foreach($ledgers1 as $led1) {
						$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led1->id, $sdate, $tdate, $fund_id),2);
						$ls_ledgers1[] = $led1->left_code;
						// echo $led1->name;
						// echo '<br>';
						// echo $ledger_amt_zero_check;
						// echo '<br>';
						if($ledger_amt_zero_check != 0)
						{
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led1->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led1->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = get_ledger_name_only($led1->id);
							$data[] = array(
										"accountname"=>$ledgername,
										"amount"=>$ledger_amount,
										"previousyear_amount"=>$ledger_amount_previous
									);
							if(!empty($led1->pa)){
								$data[] = array(
									"accountname"=>"Current Profit & Loss",
									"amount"=>$current_pl_amount,
									"previousyear_amount"=>"-"
								);
							}
						}					
					}
				}
				if(count($ls_ledgers1) > 0){
					$ledgers11 = $this->db->table('ledgers')->where('group_id',$go->id)->whereNotIn('left_code', $ls_ledgers1)->get()->getResult();
				}else{
					$ledgers11 = $this->db->table('ledgers')->where('group_id',$go->id)->get()->getResult();
				}
				if(count($ledgers11) > 0){
					foreach($ledgers11 as $led11) {
						$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led11->id, $sdate, $tdate, $fund_id),2);
						if($ledger_amt_zero_check != 0)
						{
							$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led11->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
							if($ledger_amt_rightcode < 0){
								$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
							}
							else{
								$ledger_amount = number_format($ledger_amt_rightcode,2);
							}
							$group_total += $ledger_amt_rightcode;
							$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led11->id, $sdate, $tdate, $fund_id);
							if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
							if($ledger_amt_rightcode_previousyear < 0){
								$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
							}
							else{
								$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
							}
							$group_total_prev += $ledger_amt_rightcode_previousyear;
							$ledgername = get_ledger_name_only($led11->id);
							$data[] = array(
								"accountname"=>$ledgername,
								"amount"=>$ledger_amount,
								"previousyear_amount"=>$ledger_amount_previous
							);
							if(!empty($led11->pa)){
								$data[] = array(
									"accountname"=>"Current Profit & Loss",
									"amount"=>$current_pl_amount,
									"previousyear_amount"=>"-"
								);
							}
						}					
					}
				}
				$group_two = $this->db->table('groups')->where('parent_id',$go->id)->get()->getResult();
				foreach($group_two as $gt) {
					$ledger_group_amt_zero_check = number_format(get_group_amt_new_rightcode_triplezero_subtotal($gt->id, $sdate, $tdate, $fund_id),2);
					if($ledger_group_amt_zero_check != 0)
					{
						$ledger_sub_group_amt_zero_check = get_group_amt_new_rightcode_triplezero($gt->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_sub_group_amt_zero_check = -1 * $ledger_sub_group_amt_zero_check;
						if($ledger_sub_group_amt_zero_check < 0){
							$group_amt = "( ".number_format(abs($ledger_sub_group_amt_zero_check),2)." )";
						}
						else{
							$group_amt = number_format($ledger_sub_group_amt_zero_check,2);
						}
						$group_total += $ledger_sub_group_amt_zero_check;
						$ledger_sub_group_amt_previousyear = get_group_amt_new_rightcode_triplezero_previousyear($gt->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_sub_group_amt_previousyear = -1 * $ledger_sub_group_amt_previousyear;
						if($ledger_sub_group_amt_previousyear < 0){
							$ledger_amount_previous = "( ".number_format(abs($ledger_sub_group_amt_previousyear),2)." )";
						}
						else{
							$ledger_amount_previous = number_format($ledger_sub_group_amt_previousyear,2);
						}
						$group_total_prev += $ledger_sub_group_amt_previousyear;
						$data[] = array(
							"accountname"=>$gt->name,
							"amount"=>$group_amt,
							"previousyear_amount"=>$ledger_amount_previous
						);
					}
					$ledgers2 = $this->db->table('ledgers')->where('group_id',$gt->id)->where('right_code','000')->get()->getResult();
					$ls_ledgers2 = array();
					if(count($ledgers2) > 0){
						foreach($ledgers2 as $led2) {
							$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led2->id, $sdate, $tdate, $fund_id),2);
							$ls_ledgers2[] = $led2->left_code;
							// echo $led2->name;
							// echo '<br>';
							// echo $ledger_amt_zero_check;
							// echo '<br>';
							if($ledger_amt_zero_check != 0)
							{
								$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led2->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led2->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led2->id);
								$data[] = array(
									"accountname"=>$ledgername,
									"amount"=>$ledger_amount,
									"previousyear_amount"=>$ledger_amount_previous
								);
								if(!empty($led2->pa)){
									$data[] = array(
										"accountname"=>"Current Profit & Loss",
										"amount"=>$current_pl_amount,
										"previousyear_amount"=>"-"
									);
								}
							}
						}
					}
					if(count($ls_ledgers2) > 0){
						$ledgers22 = $this->db->table('ledgers')->where('group_id',$gt->id)->whereNotIn('left_code', $ls_ledgers2)->get()->getResult();
					}else{
						$ledgers22 = $this->db->table('ledgers')->where('group_id',$gt->id)->get()->getResult();
					}
					if(count($ledgers22) > 0){
						foreach($ledgers22 as $led22) {
							$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led22->id, $sdate, $tdate, $fund_id),2);
							// echo $led22->name;
							// echo '<br>';
							// echo $ledger_amt_zero_check;
							// echo '<br>';
							if($ledger_amt_zero_check != 0)
							{
								$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led22->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
								if($ledger_amt_rightcode < 0){
									$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
								}
								else{
									$ledger_amount = number_format($ledger_amt_rightcode,2);
								}
								$group_total += $ledger_amt_rightcode;
								$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led22->id, $sdate, $tdate, $fund_id);
								if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
								if($ledger_amt_rightcode_previousyear < 0){
									$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
								}
								else{
									$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
								}
								$group_total_prev += $ledger_amt_rightcode_previousyear;
								$ledgername = get_ledger_name_only($led22->id);
								$data[] = array(
									"accountname"=>$ledgername,
									"amount"=>$ledger_amount,
									"previousyear_amount"=>$ledger_amount_previous
								);
								if(!empty($led22->pa)){
									$data[] = array(
										"accountname"=>"Current Profit & Loss",
										"amount"=>$current_pl_amount,
										"previousyear_amount"=>"-"
									);
								}
							}					
						}
					}
				}
			}
			$ledgers3 = $this->db->table('ledgers')->where('group_id',$r->id)->where('right_code','000')->get()->getResult();
			$ls_ledgers3 = array();
			foreach($ledgers3 as $led3) {
				$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led3->id, $sdate, $tdate, $fund_id),2);
				$ls_ledgers3[] = $led3->left_code;
				if($ledger_amt_zero_check != 0)
				{
					$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero($led3->id, $sdate, $tdate, $fund_id);
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
					if($ledger_amt_rightcode < 0){
						$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
					}
					else{
						$ledger_amount = number_format($ledger_amt_rightcode,2);
					}
					$group_total += $ledger_amt_rightcode;
					$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led3->id, $sdate, $tdate, $fund_id);
					if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
					if($ledger_amt_rightcode_previousyear < 0){
						$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
					}
					else{
						$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
					}
					$group_total_prev += $ledger_amt_rightcode_previousyear;
					$ledgername = get_ledger_name_only($led3->id);
					$data[] = array(
						"accountname"=>$ledgername,
						"amount"=>$ledger_amount,
						"previousyear_amount"=>$ledger_amount_previous
					);
					if(!empty($led3->pa)){
						$data[] = array(
							"accountname"=>"Current Profit & Loss",
							"amount"=>$current_pl_amount,
							"previousyear_amount"=>"-"
						);
					}
				}
			}
			if(count($ls_ledgers3) > 0){
				$ledgers33 = $this->db->table('ledgers')->where('group_id',$r->id)->whereNotIn('left_code', $ls_ledgers3)->get()->getResult();
			}else{
				$ledgers33 = $this->db->table('ledgers')->where('group_id',$r->id)->get()->getResult();
			}
			if(count($ledgers33) > 0){
				foreach($ledgers33 as $led33) {
					$ledger_amt_zero_check = number_format(get_ledger_amt_new_rightcode_triplezero_subtotal($led33->id, $sdate, $tdate, $fund_id),2);
					// echo $led33->name;
					// echo '<br>';
					// echo $ledger_amt_zero_check;
					// echo '<br>';
					if($ledger_amt_zero_check != 0)
					{
						$ledger_amt_rightcode = get_ledger_amt_new_rightcode_triplezero_single($led33->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_amt_rightcode = -1 * $ledger_amt_rightcode;
						if($ledger_amt_rightcode < 0){
							$ledger_amount = "( ".number_format(abs($ledger_amt_rightcode),2)." )";
						}
						else{
							$ledger_amount = number_format($ledger_amt_rightcode,2);
						}
						$group_total += $ledger_amt_rightcode;
						$ledger_amt_rightcode_previousyear = get_ledger_amt_new_rightcode_triplezero_previousyear($led33->id, $sdate, $tdate, $fund_id);
						if(strtolower($r->name) != 'assets') $ledger_amt_rightcode_previousyear = -1 * $ledger_amt_rightcode_previousyear;
						if($ledger_amt_rightcode_previousyear < 0){
							$ledger_amount_previous = "( ".number_format(abs($ledger_amt_rightcode_previousyear),2)." )";
						}
						else{
							$ledger_amount_previous = number_format($ledger_amt_rightcode_previousyear,2);
						}
						$group_total_prev += $ledger_amt_rightcode_previousyear;
						$ledgername = get_ledger_name_only($led33->id);
						$data[] = array(
							"accountname"=>$ledgername,
							"amount"=>$ledger_amount,
							"previousyear_amount"=>$ledger_amount_previous
						);
						if(!empty($led33->pa)){
							$data[] = array(
								"accountname"=>"Current Profit & Loss",
								"amount"=>$current_pl_amount,
								"previousyear_amount"=>"-"
							);
							$group_total += $current_pl;
						}
					}					
				}
			}
			// $ledger_bottom_group_amt_zero_check = total_group_amt_new_rightcode_triplezero($r->id,  $sdate, $tdate, $fund_id);
			// if($ledger_bottom_group_amt_zero_check < 0){
				// $bottom_group_amt = "( ".number_format(abs($ledger_bottom_group_amt_zero_check),2)." )";
			// }
			// else{
				// $bottom_group_amt = number_format($ledger_bottom_group_amt_zero_check,2);
			// }
			if($group_total < 0){
				$bottom_group_amt = "( ".number_format(abs($group_total),2)." )";
			}
			else{
				$bottom_group_amt = number_format($group_total,2);
			}
			// $ledger_bottom_group_amt_previousyear = total_group_amt_new_rightcode_triplezero_previousyear($r->id,  $sdate, $tdate, $fund_id);
			if($group_total_prev < 0){
				$bottom_group_prev_amt = "( ".number_format(abs($group_total_prev),2)." )";
			}
			else{
				$bottom_group_prev_amt = number_format($group_total_prev,2);
			}
			if($r->name == 'ASSETS') $assets_total = $group_total;
			elseif($r->name == 'Liabilities') $liabilities_total = $group_total;
			else $capital_total = $group_total;
			$data[] = array(
						"accountname"=>"Total ".$r->name,
						"amount"=>$bottom_group_amt,
						"previousyear_amount"=>$bottom_group_prev_amt
					);
		}
		$net_assets = $assets_total - $liabilities_total;
		if($assets_total < 0){
			$assets_total_amt = "( ".number_format(abs($assets_total),2)." )";
		}
		else{
			$assets_total_amt = number_format($assets_total,2);
		}
		if($liabilities_total < 0){
			$liabilities_total_amt = "( ".number_format(abs($liabilities_total),2)." )";
		}
		else{
			$liabilities_total_amt = number_format($liabilities_total,2);
		}
		$liabilities_equity_total = $liabilities_total + $capital_total;
		if($liabilities_equity_total < 0){
			$liabilities_equity_total_amt = "( ".number_format(abs($liabilities_equity_total),2)." )";
		}
		else{
			$liabilities_equity_total_amt = number_format($liabilities_equity_total,2);
		}
		if($net_assets < 0){
			$net_assets_amt = "( ".number_format(abs($net_assets),2)." )";
		}
		else{
			$net_assets_amt = number_format($net_assets,2);
		}
		$data[] = array(
			"accountname"=>"Net Assets",
			"amount"=>"",
			"previousyear_amount"=>""
		);
		$data[] = array(
			"accountname"=>"Total Assets",
			"amount"=>$assets_total_amt,
			"previousyear_amount"=>""
		);
		$data[] = array(
			"accountname"=>"Total Liabilities",
			"amount"=>$liabilities_total_amt,
			"previousyear_amount"=>""
		);
		$data[] = array(
			"accountname"=>"Total Liabilities & Equity",
			"amount"=>$liabilities_equity_total_amt,
			"previousyear_amount"=>""
		);
		$data[] = array(
			"accountname"=>"Net Assets",
			"amount"=>$net_assets_amt,
			"previousyear_amount"=>""
		);
		$fileName = "balancesheet_rightcode_triplezero_".$sdate."_to_".$tdate;  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->getStyle('A2:C2')->getFont()->setBold(true);
        $sheet->getStyle("A1:C1")->applyFromArray($style);
        $sheet->mergeCells('A1:C1'); 
        $sheet->setCellValue('A1', "SREE SELVA VINAYAGAR TEMPLE");
        $sheet->setCellValue('A2', 'Account Name');
        $sheet->setCellValue('B2', 'Current Year');     
        $sheet->setCellValue('C2', 'Previous Year');     
        $rows = 3;
        foreach ($data as $val)
        {
            $sheet->setCellValue('A' . $rows, $val['accountname']);
            $sheet->setCellValue('B' . $rows, $val['amount']);
            $sheet->setCellValue('C' . $rows, $val['previousyear_amount']);
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        $writer->save('uploads/excel/'.$fileName.'.xlsx');
        return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');
	}
	public function open_group_ledger_triblezero(){
		$led_id = $_POST['led_id'];
		$fdate = date("Y-m-d" , $_POST['fdate']);
		$tdate = date("Y-m-d" , $_POST['tdate']);
		$led_da = $this->db->table("ledgers")->where('id',$led_id)->get()->getRowArray();
		$left_code = $led_da['left_code'];
		if(!empty($left_code))
		{
			$ledger_ids = $this->db->query("select id from ledgers where id IN (select id from ledgers where left_code = $left_code) order by right_code ASC")->getResultArray();
		}
		else
		{
			$ledger_ids = array();
		}
		$html = '<table class="table table-striped" style="width:100%;">';
		if(count($ledger_ids) > 0)
		{
			foreach($ledger_ids as $ledger_id)
			{
				$ledger_amt_zero_check = get_ledger_amt_new_rightcode_triplezero_single($ledger_id['id'], $fdate, $tdate);
				if($ledger_amt_zero_check != 0)
				{
					$ledgername = get_ledger_name($ledger_id['id']);
					if($ledger_amt_zero_check < 0){
                        $ledger_amount = "( ".number_format(abs($ledger_amt_zero_check),2)." )";
                    }
                    else{
                        $ledger_amount = number_format($ledger_amt_zero_check,2);
                    }
					$html .='<tr style="color: black;">
						<td>'.$ledgername.'</td>
						<td style="text-align: right;">'.$ledger_amount.'</td>
					</tr>';
				}
			}
		}
		$html .='</table>';
		echo $html;
	}
	public function get_ledger_triblezero(){
		$ledg_id = $_POST['ledg_id'];
		$ledger_nme = $this->db->table('ledgers')->where('id',$ledg_id)->get()->getRowArray();
		echo !empty($ledger_nme['name']) ? $ledger_nme['name'] : "";
	}
}
