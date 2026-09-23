<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Aging extends BaseController
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
        $ledger_id = !empty($_REQUEST['ledger']) ? $_REQUEST['ledger'] : 1;
		$res = $this->db->table("ledgers")->where('aging', 1)->get()->getResultArray();
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_year_start_date = $ac_year['from_year_month'] . '-01';
		$ac_year_end_date = date("Y-m-t", strtotime($ac_year['to_year_month'] . '-01'));
		$data['financial_year']['start_date'] = $ac_year_start_date;
		$data['financial_year']['end_date'] = $ac_year_end_date;
		$ledger = array();
		if(count($res) > 0){
			foreach($res as $r){
				$id = $r['id'];
				$ledgername = get_ledger_name($id);
				if($ledger_id == $id) $selected = 'selected';
				else $selected = '';
				$ledger[] .= '<option '.$selected.' value="'.$id.'">'.$ledgername.'</option>';
			}
		}
		/* if(empty($_REQUEST['fdate'])) $fdate = $ac_year_start_date;
		else $fdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['fdate'])));
		if(empty($_REQUEST['tdate'])) $tdate = $ac_year_end_date;
		else $tdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['tdate']))); */
		$aging_from_date = !empty($_REQUEST['aging_from_date']) ? $_REQUEST['aging_from_date'] : date('Y-m-d');
		$aging_to_date = !empty($_REQUEST['aging_to_date']) ? $_REQUEST['aging_to_date'] : date('Y-m-d');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $aging_from_date;
		$tdate = $aging_to_date;
		$res = array();
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$reconcil_bank_balance = 0;
		$undo_reconcil = '';
		$recon_month = date('Y-m');
        if(!empty($_REQUEST['ledger'])){
			//$undo_reconcil = $this->db->table("entryitems")->select('COALESCE(max(DATE_FORMAT(reconciliation_date, "%Y-%m")), \'\') as reconciliation_date')->get()->getRowArray()['reconciliation_date'];
			//$reconcil_bank = $this->db->table("reconcil_bank_balance")->where('ac_year_id', $ac_year['id'])->where('ledger_id', $ledger_id)->where('month', $recon_month)->get()->getRowArray();
			//if(!empty($reconcil_bank['amount'])) $reconcil_bank_balance = $reconcil_bank['amount'];
			// echo $this->db->getLastQuery();
			// die;
			$res = $this->db->table("entryitems")
			->select('entries.*, entryitems.id as entryitem_id, entryitems.details, entryitems.amount, entryitems.dc, entryitems.agingmode, entryitems.ledger_id, ledgers.name as ledger_name, ledgers.code as ledger_code')
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->join('ledgers', 'ledgers.id = entryitems.ledger_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $fdate)
			->where('entries.date <=', $tdate)
			->where('entryitems.agingmode', 'FLOAT')
			->orderBy('entries.date', 'ASC')
			->get()->getResultArray();
			$current_year_op_bal = $this->db->table("ac_year_ledger_balance")->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_year['id'])->get()->getRowArray();
			$total_transactions_before_start = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $ac_year_start_date)
			->where('entries.date <=', $fdate)
			->orderBy('entries.date', 'ASC')
			->get()->getResultArray();
			$total_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $fdate)
			->where('entries.date <=', $tdate)
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
			//echo $this->db->getLastQuery();

			$pending_transactions = $this->db->query("SELECT sum(if(entryitems.dc = 'D', `entryitems`.`amount`, 0)) as dr_total, sum(if(entryitems.dc = 'C', `entryitems`.`amount`, 0)) as cr_total FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND (`entries`.`date` >= '$fdate' and `entries`.`date` <= '$tdate' AND `entryitems`.`agingmode` = 'FLOAT') or (`entries`.`date` >= '$fdate' and `entries`.`date` <= '$tdate' and `entryitems`.`agingmode` = 'CLEARED' ) ORDER BY `entries`.`date` ASC")->getRowArray();
			$cleared_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $fdate)
			->where('entries.date <=', $tdate)
			->where('entryitems.agingmode', 'CLEARED')
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
			$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
			$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
			$opening_balance = $op_dr - $op_cr;
			$cl_dr = $total_transactions['dr_total'];
			$cl_cr =$total_transactions['cr_total'];
			$closing_balance = ($op_dr + $cl_dr) - ($op_cr + $cl_cr);
			$clr_dr = $cleared_transactions['dr_total']; //
			$clr_cr = $cleared_transactions['cr_total']; //
			$cleared_balance = ($op_dr + $clr_dr) - ($op_cr + $clr_cr);
			$data['opening_balance'] = $opening_balance;
			$data['closing_balance'] = $closing_balance;
			$data['cleared_balance'] =$cleared_balance;
			$data['debit_balance'] = $pending_transactions['dr_total'];
			$data['credit_balance'] = $pending_transactions['cr_total'];
		}
		$data['res'] = $res;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
        $data['recon_month'] =$recon_month;
        $data['ledger'] =$ledger;
        $data['ledger_id'] =$ledger_id;
        // $data['fund_id'] = $fund_id;
        $data['undo_reconcil'] = $undo_reconcil; // no need
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
        $data['reconcil_bank_balance'] =$reconcil_bank_balance; // no need
		$data['bank_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('type', 1)->get()->getResultArray();
		$three_level_group = get_three_level_in_group($code = array("6000"));
		$data['charge_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->whereIn('group_id', $three_level_group)->orderBy('right_code','asc')->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('aging/index', $data);
		echo view('template/footer');
    }
	public function save(){
		$rec_tick = !empty($_POST['rec_tick']) ? $_POST['rec_tick'] : array();
		if(!empty($_REQUEST['ledger']) && !empty($_POST['bank_balance']) && !empty($_POST['received_date'])){
			$ledger_id = trim($_REQUEST['ledger']);
			if(count($rec_tick) > 0){
				$length = count($_POST['rec_tick']);
				$aging_from_date = !empty($_REQUEST['aging_from_date']) ? $_REQUEST['aging_from_date'] : date('Y-m-d');
				$aging_to_date = !empty($_REQUEST['aging_to_date']) ? $_REQUEST['aging_to_date'] : date('Y-m-d');
				$fdate = $aging_from_date;
				$tdate = $aging_to_date;
				foreach($rec_tick as $i => $entryitem_id){
					$entryitems_date =$this->db->table("entryitems")->join("entries", 'entries.id = entryitems.entry_id')->select('entries.date')->where('entryitems.id', $entryitem_id)->get()->getRowArray();
					$items = array(
						'agingmode'=>'CLEARED'
					);
					$this->db->table("entryitems")->where('id', $entryitem_id)->update($items);
				}
				$bank_balance = (float) $_POST['bank_balance'];
				$variance_amt = (float)$_POST['variance_amt'];
				$invoice_amount = $bank_balance + abs($variance_amt);
				$yr=date('Y');
				$mon=date('m');
				$query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = 1 and month (date)='". $mon ."')")->getRowArray();
				$bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
				// Receipts
				$rdata['entrytype_id']   = 1;
				$rdata['date']           = $_POST['received_date']; 
				$rdata['dr_total']        = $invoice_amount; 
				$rdata['cr_total']        = $invoice_amount; 
				$rdata['narration']      = $_POST['receipt_detail'];
				$rdata['entry_code']      = $bill_no; 
				$number = $this->db->table('entries')->select('number')->where('entrytype_id', 1)->orderBy('id','desc')->get()->getRowArray(); 
				if(empty($number)) {
					$rdata['number'] = 1;
				} else {
					$rdata['number'] = $number['number'] + 1;
				}
				$this->db->table("entries")->insert($rdata);
				$rec_insid = $this->db->insertID();
				if(!empty($rec_insid))
				{
					$entryitems_d['entry_id']  = $rec_insid;
					$entryitems_d['ledger_id'] = $_POST['bank_ledger'];
					$entryitems_d['details'] = $_POST['receipt_detail'];
					$entryitems_d['amount'] = $invoice_amount;
					$entryitems_d['dc'] = "D";
					$this->db->table('entryitems')->insert($entryitems_d);
					$entryitems_c['entry_id']  = $rec_insid;
					$entryitems_c['agingmode'] = 'CLEARED';
					$entryitems_c['ledger_id'] = $_REQUEST['ledger'];
					$entryitems_c['details'] = $_POST['receipt_detail'];
					$entryitems_c['amount'] = $invoice_amount;
					$entryitems_c['dc'] = "C";
					$this->db->table('entryitems')->insert($entryitems_c);
				}
				if ($_POST['variance_amt'] < 0)
				{
					$payment_query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = 2 and month (date)='". $mon ."')")->getRowArray();
					$j_bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($payment_query['entry_code'],-5))+1)));
					// Journal
					$cr_dr_total = abs($_POST['variance_amt']);
					$jdata['entrytype_id']   = 2;
					$jdata['date']           = $_POST['received_date']; 
					$jdata['dr_total']        = $cr_dr_total; 
					$jdata['cr_total']        = $cr_dr_total; 
					$jdata['narration']      = "Charges";
					$jdata['entry_code']      = $j_bill_no; 
					$jnumber = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id','desc')->get()->getRowArray(); 
					if(empty($jnumber)) {
						$jdata['number'] = 1;
					} else {
						$jdata['number'] = $jnumber['number'] + 1;
					}
					$this->db->table("entries")->insert($jdata);
					$jor_insid = $this->db->insertID();
				
					$entryitems_jd['entry_id']  = $jor_insid;
					$entryitems_jd['ledger_id'] = $_POST['bank_ledger'];
					$entryitems_jd['details'] = "Charges";
					$entryitems_jd['amount'] = abs($_POST['variance_amt']);
					$entryitems_jd['dc'] = "C";
					$this->db->table('entryitems')->insert($entryitems_jd);
					$entryitems_jc['entry_id']  = $jor_insid;
					$entryitems_jc['ledger_id'] = $_POST['charges_ledger'];
					$entryitems_jc['details'] = "Charges";
					$entryitems_jc['amount'] = abs($_POST['variance_amt']);
					$entryitems_jc['dc'] = "D";
					$this->db->table('entryitems')->insert($entryitems_jc);
				}
				else{
					$receipt_query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = 1 and month (date)='". $mon ."')")->getRowArray();
					$j_bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($receipt_query['entry_code'],-5))+1)));
					// Journal
					$cr_dr_total = abs($_POST['variance_amt']);
					$jdata['entrytype_id']   = 1;
					$jdata['date']           = $_POST['received_date']; 
					$jdata['dr_total']        = $cr_dr_total; 
					$jdata['cr_total']        = $cr_dr_total; 
					$jdata['narration']      = "Charges";
					$jdata['entry_code']      = $j_bill_no; 
					$jnumber = $this->db->table('entries')->select('number')->where('entrytype_id', 4)->orderBy('id','desc')->get()->getRowArray(); 
					if(empty($jnumber)) {
						$jdata['number'] = 1;
					} else {
						$jdata['number'] = $jnumber['number'] + 1;
					}
					$this->db->table("entries")->insert($jdata);
					$jor_insid = $this->db->insertID();
					$entryitems_jd['entry_id']  = $jor_insid;
					$entryitems_jd['ledger_id'] = $_POST['bank_ledger'];
					$entryitems_jd['details'] = "Charges";
					$entryitems_jd['amount'] = $_POST['variance_amt'];
					$entryitems_jd['dc'] = "D";
					$this->db->table('entryitems')->insert($entryitems_jd);
					$entryitems_jc['entry_id']  = $jor_insid;
					$entryitems_jc['ledger_id'] = $_REQUEST['ledger'];
					$entryitems_jc['details'] = "Charges";
					$entryitems_jc['amount'] = $_POST['variance_amt'];
					$entryitems_jc['dc'] = "C";
					$this->db->table('entryitems')->insert($entryitems_jc);
				}
				//return redirect()->to("/aging/print/" . $ledger_id . '?aging_from_date='.$fdate.'&aging_to_date='.$tdate);
				return redirect()->to("/aging");
			}
			else{
				return redirect()->to("/aging");
			}
		}
		else{
			return redirect()->to("/aging");
		}
	}
	public function print($ledger_id){
		//var_dump($cleared_balance);
		//var_dump($entryitem);
		//exit;
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$aging_from_date = !empty($_REQUEST['aging_from_date']) ? $_REQUEST['aging_from_date'] : date('Y-m-d');
		$aging_to_date = !empty($_REQUEST['aging_to_date']) ? $_REQUEST['aging_to_date'] : date('Y-m-d');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $aging_from_date;
		$tdate = $aging_to_date;
		$cleared_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $fdate)
			->where('entries.date <=', $tdate)
			->where('entryitems.agingmode', 'CLEARED')
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
		$current_year_op_bal = $this->db->table("ac_year_ledger_balance")->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_year['id'])->get()->getRowArray();
		$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
		$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
		$clr_dr = $cleared_transactions['dr_total']; //
		$clr_cr = $cleared_transactions['cr_total']; //
		$cleared_balance = ($op_dr + $clr_dr) - ($op_cr + $clr_cr);
		$data['cleared_balance'] = $cleared_balance;
		$ac_year_start_date = $ac_year['from_year_month'] . '-01';
		$ac_year_end_date = $ac_year['from_year_month'] . '-31';
		$ledger_details = $this->db->table("ledgers")->where('id', $ledger_id)->get()->getRowArray();
		$current_year_op_bal = $this->db->table("ac_year_ledger_balance")->where('ledger_id', $ledger_id)->where('ac_year_id', $ac_year['id'])->get()->getRowArray();
		// if(empty($_REQUEST['fdate'])) $fdate = $ac_year_start_date;
		// else $fdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['fdate'])));
		// if(empty($_REQUEST['tdate'])) $fdate = $ac_year_end_date;
		// else $tdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['tdate'])));
		$pending_debit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'D' and (`entries`.`date` >= '$fdate' and `entries`.`date` <= '$tdate' AND `entryitems`.`agingmode` = 'FLOAT') or (`entries`.`date` >= '$fdate' and `entries`.`date` <= '$tdate' and `entryitems`.`agingmode` = 'CLEARED') ORDER BY `entries`.`date` ASC")->getResultArray();
		$pending_credit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'C' and (`entries`.`date` >= '$fdate' and `entries`.`date` <= '$tdate' AND `entryitems`.`agingmode` = 'FLOAT') or (`entries`.`date` >= '$fdate' and `entries`.`date` <= '$tdate' and `entryitems`.`agingmode` = 'CLEARED') ORDER BY `entries`.`date` ASC")->getResultArray();
		$total_transactions_before_start = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $ac_year_start_date)
			->where('entries.date <=', $fdate)
			->get()->getResultArray();
		$data['opening_balance'] = $opening_balance;
		$data['pending_debit_transactions'] = $pending_debit_transactions;
		$data['pending_credit_transactions'] = $pending_credit_transactions;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['$recon_month'] = $recon_month;
		$data['ledger_details'] = $ledger_details;
		$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
		$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
		$opening_balance = $op_dr - $op_cr;
		// $res = $this->db->table("entryitems")
						// ->select('entries.date as entry_date,entries.narration,entries.entry_code, entryitems.reconciliation_date,entryitems.amount,entryitems.dc,ledgers.name as ledger_name')
						// ->join('entries', 'entries.id = entryitems.entry_id', 'left')
						// ->join('ledgers', 'ledgers.id = entryitems.ledger_id', 'left')
						// ->whereIn('entryitems.id', $entryitem)
						// ->get()->getResultArray();
		// $data['entryitems'] = $res;
		echo view('aging/print',$data);
	}
	public function save_bank_balance(){
		if(!empty($_REQUEST['ledger_id']) && !empty($_REQUEST['recon_month']) && !empty($_REQUEST['bank_balance'])){
			$ledger_id = trim($_REQUEST['ledger_id']);
			$recon_month = trim($_REQUEST['recon_month']);
			$amount = trim($_REQUEST['bank_balance']);
			// $fund_id = trim($_REQUEST['fund_id']);
			$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
			$data = array();
			$data['ac_year_id'] = $ac_year['id'];
			$data['ledger_id'] = $ledger_id;
			// $data['fund_id'] = $fund_id;
			$data['month'] = $recon_month;
			$data['amount'] = $amount;
			$reconcil_bank_balance = $this->db->table("reconcil_bank_balance")->where('ac_year_id', $ac_year['id'])->where('ledger_id', $ledger_id)->where('month', $recon_month)->get()->getResultArray();
			if(count($reconcil_bank_balance) > 0){
				$data['updated'] = date('Y-m-d H:i:s');
				$res = $this->db->table("reconcil_bank_balance")->where('id', $reconcil_bank_balance[0]['id'])->update($data);
			}else{
				$this->db->table('reconcil_bank_balance')->insert($data);
			}
			return redirect()->to("/reconciliation?ledger=$ledger_id&recon_month=$recon_month");
		}
		else{
			return redirect()->to("/reconciliation");
		}
	}
	public function undo_reconcil($ledger_id){
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		// $this->db->query("UPDATE `entryitems` set clearancemode = 'FLOAT', reconciliation_date=NULL WHERE `ledger_id` LIKE $ledger_id and entry_id in (select id from entries where fund_id = $fund_id) and reconciliation_date='$tdate' and clearancemode = 'CLEARED'");
		$this->db->query("UPDATE `entryitems` set clearancemode = 'FLOAT', reconciliation_date=NULL WHERE `ledger_id` LIKE $ledger_id and reconciliation_date='$tdate' and clearancemode = 'CLEARED'");
		return redirect()->to("/reconciliation?ledger=$ledger_id&recon_month=$recon_month");
	}
}