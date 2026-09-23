<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Dailycollection extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper("common");
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}
	public function index(){
        if(!$this->model->list_validate('ac_daily_collections')){
			header('Location: '.base_url().'/dashboard');
		}
        
		$data['permission'] = $this->model->get_permission('ac_daily_collections');
		//var_dump($_POST);
		//exit;
		if($_POST['sdate']) $sdate = $_POST['sdate']; 
        else $sdate = date('Y-m-d');
		$type_id = !empty($_POST['type_id']) ? $_POST['type_id'] : "";
        $fund_id = $_POST['fund_id'];
		$receipt_debit_ac = $_POST['receipt_debit_ac'];
		$payment_credit_ac = !empty($_POST['payment_credit_ac']) ? $_POST['payment_credit_ac'] : "";
		$table = array();
        $data = array();
        $total_receipt = 0;
        $total_payment = 0;
		$receipts = $this->db->table('entries e')->join('entryitems ei','ei.entry_id = e.id')->select('e.id,e.entrytype_id')->where('e.date',$sdate);
		if(!empty($type_id)){
			$receipts = $receipts->where('e.entrytype_id', $type_id);
		}
		else{
			$receipts = $receipts->whereIn('e.entrytype_id', array('1','2'));
		}
		if(!empty($fund_id)){
			$receipts = $receipts->where('e.fund_id', $fund_id);
		}
		/*if(!empty($receipt_debit_ac)){
			$receipts = $receipts->where('ei.ledger_id', $receipt_debit_ac);
		}*/
		$receipts = $receipts->groupBy('ei.entry_id')->get()->getResultArray();	

		if(!empty($receipts)){
			foreach($receipts as $rec_row){
				if($rec_row['entrytype_id'] == 1){
					$ledger_d_account = ledgercode_accountname($rec_row['id'],$type="D",$receipt_debit_ac);
					$ledger_c_account = ledgercode_accountname($rec_row['id'],$type="C");
					$ac = $ledger_d_account['left_code'].'-'.$ledger_d_account['right_code']." ".$ledger_d_account['ledger_name'];
					$c_descrip = $ledger_c_account['ledger_name'];
					$d_descrip = $ledger_d_account['ledger_name'];
					$d_amount = $ledger_d_account['led_amt'];
				}
				else if($rec_row['entrytype_id'] == 2){
					$ledger_d_account = ledgercode_accountname($pay_row['id'],$type="D");
					$ledger_c_account = ledgercode_accountname($pay_row['id'],$type="C",$payment_credit_ac);
					$ac = $ledger_c_account['left_code'].'-'.$ledger_c_account['right_code']." ".$ledger_c_account['ledger_name'];
					$c_descrip = $ledger_c_account['ledger_name'];
					$d_descrip = $ledger_d_account['ledger_name'];
					$c_amount = $ledger_c_account['led_amt'];
				}
				$table[] = '<tr>
								<td style="text-align:left;">'.$ac.'</td>
								<td style="text-align:left;">'.$c_descrip.' - '.$d_descrip.'</td>
								<td style="text-align:right;">'.$d_amount.'</td>
							</tr>';
			}
		}
        $data['sdate'] = $sdate;
        $data['type_id'] = $type_id;
        $data['fund_id'] = $fund_id;
        $data['receipt_debit_ac'] = $receipt_debit_ac;
        $data['payment_credit_ac'] = $payment_credit_ac;
        $data['table'] = $table;

		$data['receipt_ledgers'] = $this->db->query("SELECT * FROM `ledgers` where group_id not in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000) or parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (5000, 6000, 9000))))")->getResultArray();

		$data['payment_ledgers'] = $this->db->query("SELECT * FROM `ledgers` where group_id not in (SELECT id FROM `groups` WHERE code in (4000, 8000) or parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000)) or parent_id in (select id from `groups` where parent_id in (SELECT id FROM `groups` WHERE code in (4000, 8000))))")->getResultArray();

		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('daily_collection/index', $data);
		echo view('template/footer');
    }
	public function print_daily_collection(){
		if(!$this->model->list_validate('ac_daily_collections')){
			header('Location: '.base_url().'/dashboard');
		}
        
		$data['permission'] = $this->model->get_permission('ac_daily_collections');
		if($_POST['fdate']) $sdate = $_POST['fdate']; 
        else $sdate = date('Y-m-d');
		$type_id = $_POST['ptype_id'];
        $fund_id = $_POST['pfund_id'];
		$receipt_debit_ac = $_POST['preceipt_ledger_id'];
		$payment_credit_ac = $_POST['ppayment_ledger_id'];
		$table = array();
        $data = array();
        $total_receipt = 0;
        $total_payment = 0;
		$receipts = $this->db->table('entries e')->join('entryitems ei','ei.entry_id = e.id')->select('e.id,e.entrytype_id')->where('e.date',$sdate);
		if(!empty($type_id)){
			$receipts = $receipts->where('e.entrytype_id', $type_id);
		}
		else{
			$receipts = $receipts->whereIn('e.entrytype_id', array('1','2'));
		}
		if(!empty($fund_id)){
			$receipts = $receipts->where('e.fund_id', $fund_id);
		}
		$receipts = $receipts->groupBy('ei.entry_id')->get()->getResultArray();	

		if(!empty($receipts)){
			foreach($receipts as $rec_row){
				if($rec_row['entrytype_id'] == 1){
					$ledger_d_account = ledgercode_accountname($rec_row['id'],$type="D",$receipt_debit_ac);
					$ledger_c_account = ledgercode_accountname($rec_row['id'],$type="C");
					$ac = $ledger_d_account['left_code'].'-'.$ledger_d_account['right_code']." ".$ledger_d_account['ledger_name'];
					$c_descrip = $ledger_c_account['ledger_name'];
					$d_descrip = $ledger_d_account['ledger_name'];
					$d_amount = $ledger_d_account['led_amt'];
				}
				else if($rec_row['entrytype_id'] == 2){
					$ledger_d_account = ledgercode_accountname($pay_row['id'],$type="D");
					$ledger_c_account = ledgercode_accountname($pay_row['id'],$type="C",$payment_credit_ac);
					$ac = $ledger_c_account['left_code'].'-'.$ledger_c_account['right_code']." ".$ledger_c_account['ledger_name'];
					$c_descrip = $ledger_c_account['ledger_name'];
					$d_descrip = $ledger_d_account['ledger_name'];
					$c_amount = $ledger_c_account['led_amt'];
				}
				$table[] = '<tr>
								<td style="text-align:left;">'.$ac.'</td>
								<td style="text-align:left;">'.$c_descrip.' - '.$d_descrip.'</td>
								<td style="text-align:right;">'.$d_amount.'</td>
							</tr>';
			}
		}
		$data['sdate'] = $sdate;
        $data['table'] = $table;
		echo view('daily_collection/print_daily_collection', $data);
	}


}