<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Reconciliation extends BaseController
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

	public function index()
	{
		$ledger_id = !empty($_REQUEST['ledger']) ? $_REQUEST['ledger'] : 1;
		$res = $this->db->table("ledgers")->where('reconciliation', 1)->get()->getResultArray();
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_year_start_date = $ac_year['from_year_month'] . '-01';
		$ac_year_end_date = date("Y-m-t", strtotime($ac_year['to_year_month'] . '-01'));
		$data['from_year_month'] = $ac_year['from_year_month'];
		$data['to_year_month'] = $ac_year['to_year_month'];
		foreach ($res as $r) {
			$id = $r['id'];
			$ledgername = get_ledger_name($id);
			if ($ledger_id == $id)
				$selected = 'selected';
			else
				$selected = '';
			$ledger[] .= '<option ' . $selected . ' value="' . $id . '">' . $ledgername . '</option>';
		}
		/* if(empty($_REQUEST['fdate'])) $fdate = $ac_year_start_date;
			  else $fdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['fdate'])));
			  if(empty($_REQUEST['tdate'])) $tdate = $ac_year_end_date;
			  else $tdate = date("Y-m-d", strtotime(str_replace('-', '/', $_REQUEST['tdate']))); */
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		$res = array();
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$reconcil_bank_balance = 0;
		$undo_reconcil = '';
		if (!empty($_REQUEST['ledger'])) {
			$undo_reconcil = $this->db->table("entryitems")->select('COALESCE(max(DATE_FORMAT(reconciliation_date, "%Y-%m")), \'\') as reconciliation_date')->get()->getRowArray()['reconciliation_date'];
			$reconcil_bank = $this->db->table("reconcil_bank_balance")->where('ac_year_id', $ac_year['id'])->where('ledger_id', $ledger_id)->where('month', $recon_month)->get()->getRowArray();
			if (!empty($reconcil_bank['amount']))
				$reconcil_bank_balance = $reconcil_bank['amount'];
			// echo $this->db->getLastQuery();
			// die;
			$res = $this->db->table("entryitems")
				->select('entries.*, entryitems.id as entryitem_id, entryitems.details, entryitems.amount, entryitems.dc, entryitems.clearancemode, entryitems.reconciliation_date, entryitems.ledger_id, ledgers.name as ledger_name, ledgers.code as ledger_code')
				->join('entries', 'entries.id = entryitems.entry_id', 'left')
				->join('ledgers', 'ledgers.id = entryitems.ledger_id', 'left')
				->where('entryitems.ledger_id', $ledger_id)
				->where('entries.date <=', $tdate)
				->where('entryitems.clearancemode', 'FLOAT')
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
				->where('entries.date <=', $tdate)
				->orderBy('entries.date', 'ASC')
				->get()->getRowArray();
			//echo $this->db->getLastQuery();
			// $pending_transactions = $this->db->table("entryitems")
			// ->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			// ->join('entries', 'entries.id = entryitems.entry_id', 'left')
			// ->where('entryitems.ledger_id', $ledger_id)
			// ->where('entries.date >=', $fdate)
			// ->where('entries.date <=', $tdate)
			// ->where('entryitems.clearancemode', 'FLOAT')
			// ->orderBy('entries.date', 'ASC')
			// ->get()->getRowArray();
			$pending_transactions = $this->db->query("SELECT sum(if(entryitems.dc = 'D', `entryitems`.`amount`, 0)) as dr_total, sum(if(entryitems.dc = 'C', `entryitems`.`amount`, 0)) as cr_total FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getRowArray();
			$cleared_transactions = $this->db->table("entryitems")
				->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
				->join('entries', 'entries.id = entryitems.entry_id', 'left')
				->where('entryitems.ledger_id', $ledger_id)
				->where('entries.date <=', $tdate)
				->where('entryitems.reconciliation_date <=', $tdate)
				->where('entryitems.clearancemode', 'CLEARED')
				->orderBy('entries.date', 'ASC')
				->get()->getRowArray();
			$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
			$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
			$opening_balance = $op_dr - $op_cr;
			$cl_dr = $total_transactions['dr_total'];
			$cl_cr = $total_transactions['cr_total'];
			$closing_balance = ($op_dr + $cl_dr) - ($op_cr + $cl_cr);
			$clr_dr = $cleared_transactions['dr_total']; //
			$clr_cr = $cleared_transactions['cr_total']; //
			$cleared_balance = ($op_dr + $clr_dr) - ($op_cr + $clr_cr);
			$data['opening_balance'] = $opening_balance;
			$data['closing_balance'] = $closing_balance;
			$data['cleared_balance'] = $cleared_balance;
			$data['debit_balance'] = $pending_transactions['dr_total'];
			$data['credit_balance'] = $pending_transactions['cr_total'];
		}
		$data['res'] = $res;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['recon_month'] = $recon_month;
		$data['ledger'] = $ledger;
		$data['ledger_id'] = $ledger_id;
		// $data['fund_id'] = $fund_id;
		$data['undo_reconcil'] = $undo_reconcil;
		$data['funds'] = $this->db->table('funds')->get()->getResultArray();
		$data['reconcil_bank_balance'] = $reconcil_bank_balance;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('reconciliation/index', $data);
		echo view('template/footer');
	}
	public function save()
	{
		$rec_tick = !empty($_POST['rec_tick']) ? $_POST['rec_tick'] : array();
		if (!empty($_REQUEST['ledger'])) {
			$ledger_id = trim($_REQUEST['ledger']);
			if (count($rec_tick) > 0) {
				$length = count($_POST['rec_tick']);
				$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
				// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
				$fdate = $recon_month . '-01';
				$tdate = date("Y-m-t", strtotime($fdate));
				foreach ($rec_tick as $i => $entryitem_id) {
					$entryitems_date = $this->db->table("entryitems")->join("entries", 'entries.id = entryitems.entry_id')->select('entries.date')->where('entryitems.id', $entryitem_id)->get()->getRowArray();
					/* $clearance = $_POST['clearance'][$i];
								   $reconcil_date = !empty($_POST['reconcil_date'][$i]) ? $_POST['reconcil_date'][$i] : NULL;
								   $items = array(
									   'clearancemode'=>$clearance,
									   'reconciliation_date'=>$reconcil_date
								   ); */
					$items = array(
						'clearancemode' => 'CLEARED',
						'reconciliation_date' => $tdate
					);
					$this->db->table("entryitems")->where('id', $entryitem_id)->update($items);
				}
				return redirect()->to("/reconciliation/print/" . $ledger_id . '?recon_month=' . $recon_month);
			} else {
				return redirect()->to("/reconciliation");
			}
		} else {
			return redirect()->to("/reconciliation");
		}
	}
	public function print($ledger_id)
	{
		//var_dump($cleared_balance);
		//var_dump($entryitem);
		//exit;
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		$cleared_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->where('entryitems.reconciliation_date <=', $tdate)
			->where('entryitems.clearancemode', 'CLEARED')
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
		$pending_debit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'D' and (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray();
		$pending_credit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'C' and (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray();
		$total_transactions_before_start = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $ac_year_start_date)
			->where('entries.date <=', $fdate)
			->get()->getResultArray();
		$total_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
		$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
		$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
		$cl_dr = $total_transactions['dr_total'];
		$cl_cr = $total_transactions['cr_total'];
		$opening_balance = $op_dr - $op_cr;
		$closing_balance = ($op_dr + $cl_dr) - ($op_cr + $cl_cr);
		$data['opening_balance'] = $opening_balance;
		$data['closing_balance'] = $closing_balance;
		$data['pending_debit_transactions'] = $pending_debit_transactions;
		$data['pending_credit_transactions'] = $pending_credit_transactions;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['recon_month'] = $recon_month;
		$data['ledger_details'] = $ledger_details;

		// $res = $this->db->table("entryitems")
		// ->select('entries.date as entry_date,entries.narration,entries.entry_code, entryitems.reconciliation_date,entryitems.amount,entryitems.dc,ledgers.name as ledger_name')
		// ->join('entries', 'entries.id = entryitems.entry_id', 'left')
		// ->join('ledgers', 'ledgers.id = entryitems.ledger_id', 'left')
		// ->whereIn('entryitems.id', $entryitem)
		// ->get()->getResultArray();
		// $data['entryitems'] = $res;
		echo view('reconciliation/print', $data);
	}

	public function pdf($ledger_id)
	{
		//var_dump($cleared_balance);
		//var_dump($entryitem);
		//exit;
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		$cleared_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->where('entryitems.reconciliation_date <=', $tdate)
			->where('entryitems.clearancemode', 'CLEARED')
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
		$pending_debit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'D' and (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray();
		$pending_credit_transactions = $this->db->query("SELECT ledgers.*, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` left join ledgers on ledgers.id = `entryitems`.`ledger_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND entryitems.dc = 'C' and (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') or (`entries`.`date` <= '$tdate' and `entryitems`.`clearancemode` = 'CLEARED' and `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray();
		$total_transactions_before_start = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date >=', $ac_year_start_date)
			->where('entries.date <=', $fdate)
			->get()->getResultArray();
		$total_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();
		$op_dr = $current_year_op_bal['dr_amount'] + $total_transactions_before_start['dr_total']; //
		$op_cr = $current_year_op_bal['cr_amount'] + $total_transactions_before_start['cr_total']; //
		$cl_dr = $total_transactions['dr_total'];
		$cl_cr = $total_transactions['cr_total'];
		$opening_balance = $op_dr - $op_cr;
		$closing_balance = ($op_dr + $cl_dr) - ($op_cr + $cl_cr);
		$data['opening_balance'] = $opening_balance;
		$data['closing_balance'] = $closing_balance;
		$data['pending_debit_transactions'] = $pending_debit_transactions;
		$data['pending_credit_transactions'] = $pending_credit_transactions;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['recon_month'] = $recon_month;
		$data['ledger_details'] = $ledger_details;
		$file_name = "Reconciliation_" . $data['fdate'] . "_to_" . $data['tdate'];
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$dompdf->loadHtml(view('reconciliation/pdf', ["pdfdata" => $data]));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($file_name);
	}

	public function save_bank_balance()
	{
		if (!empty($_REQUEST['ledger_id']) && !empty($_REQUEST['recon_month']) && !empty($_REQUEST['bank_balance'])) {
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
			if (count($reconcil_bank_balance) > 0) {
				$data['updated'] = date('Y-m-d H:i:s');
				$res = $this->db->table("reconcil_bank_balance")->where('id', $reconcil_bank_balance[0]['id'])->update($data);
			} else {
				$this->db->table('reconcil_bank_balance')->insert($data);
			}
			return redirect()->to("/reconciliation?ledger=$ledger_id&recon_month=$recon_month");
		} else {
			return redirect()->to("/reconciliation");
		}
	}
	public function undo_reconcil($ledger_id)
	{
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		// $fund_id = !empty($_REQUEST['fund_id']) ? $_REQUEST['fund_id'] : 1;
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		// $this->db->query("UPDATE `entryitems` set clearancemode = 'FLOAT', reconciliation_date=NULL WHERE `ledger_id` LIKE $ledger_id and entry_id in (select id from entries where fund_id = $fund_id) and reconciliation_date='$tdate' and clearancemode = 'CLEARED'");
		$this->db->query("UPDATE `entryitems` set clearancemode = 'FLOAT', reconciliation_date=NULL WHERE `ledger_id` LIKE $ledger_id and reconciliation_date='$tdate' and clearancemode = 'CLEARED'");
		return redirect()->to("/reconciliation?ledger=$ledger_id&recon_month=$recon_month");
	}

	public function excel($ledger_id)
	{
		// Fetch accounting year and set dates
		$ac_year = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$recon_month = !empty($_REQUEST['recon_month']) ? $_REQUEST['recon_month'] : date('Y-m');
		$fdate = $recon_month . '-01';
		$tdate = date("Y-m-t", strtotime($fdate));
		$ac_year_start_date = $ac_year['from_year_month'] . '-01';
		// Get total transactions from the beginning of the accounting year to the selected date
		$total_transactions = $this->db->table("entryitems")
			->select("sum(if(entryitems.dc = 'D', entryitems.amount, 0)) as dr_total, sum(if(entryitems.dc = 'C', entryitems.amount, 0)) as cr_total")
			->join('entries', 'entries.id = entryitems.entry_id', 'left')
			->where('entryitems.ledger_id', $ledger_id)
			->where('entries.date <=', $tdate)
			->orderBy('entries.date', 'ASC')
			->get()->getRowArray();

		// Calculate the closing balance based on debits and credits
		$opening_balance = $this->db->table("ac_year_ledger_balance")
			->where('ledger_id', $ledger_id)
			->where('ac_year_id', $ac_year['id'])
			->get()->getRowArray();
		$op_dr = $opening_balance['dr_amount'];
		$op_cr = $opening_balance['cr_amount'];
		$closing_balance = ($op_dr + $total_transactions['dr_total']) - ($op_cr + $total_transactions['cr_total']);

		
		// Prepare data for Excel output
		$data = [
			'pending_debit_transactions' => $this->db->query("SELECT `entryitems`.`entry_id`, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND `entryitems`.`dc` = 'D' AND (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') OR (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'CLEARED' AND `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray(),
			'pending_credit_transactions' => $this->db->query("SELECT `entryitems`.`entry_id`, `entries`.`date`, entries.narration, entries.entry_code, `entryitems`.`amount` FROM `entryitems` LEFT JOIN `entries` ON `entries`.`id` = `entryitems`.`entry_id` WHERE `entryitems`.`ledger_id` = '$ledger_id' AND `entryitems`.`dc` = 'C' AND (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'FLOAT') OR (`entries`.`date` <= '$tdate' AND `entryitems`.`clearancemode` = 'CLEARED' AND `entryitems`.`reconciliation_date` > '$tdate') ORDER BY `entries`.`date` ASC")->getResultArray()
		];
		$outstanding_charges = 0;
		foreach ($data['pending_debit_transactions'] as $pbt) {
			$outstanding_charges += $pbt['amount'];
		}
		$outstanding_payments = 0;
		foreach ($data['pending_credit_transactions'] as $pct){
			$outstanding_payments += $pct['amount'];
		}

		$fileName = "Reconciliation_" . $fdate . "_to_" . $tdate;
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$imageUrl = 'https://selvavinayagar.grasp.com.my/test/uploads/main/1708670418_WhatsApp%20Image%202024-02-23%20at%2012.08.08_ce532764.jpg';

		// Set a path to save the image locally
		$localImagePath = FCPATH . 'uploads/main/logo_img.jpg'; // Make sure this path is writable

		// Download the image
		$imageData = file_get_contents($imageUrl);
		if ($imageData !== false) {
			file_put_contents($localImagePath, $imageData);

			// Load the image into PhpSpreadsheet
			$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
			$drawing->setName('Temple Logo');
			$drawing->setDescription('Temple Logo');
			$drawing->setPath($localImagePath); // Local path to the image
			$drawing->setHeight(80); // Adjust height as needed
			$drawing->setCoordinates('A1');
			$drawing->setWorksheet($sheet);

		} else {
			// Handle error if the image cannot be downloaded
			throw new Exception('Failed to download image.');
		}

		// Set cell values for temple name and address
		// Merging cells for the header text
		$sheet->mergeCells('D1:I1'); // Merging cells for temple name
		$sheet->setCellValue('D1', "SREE SELVA VINAYAGAR TEMPLE");
		$sheet->getStyle('D1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('D1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$sheet->mergeCells('B2:I2'); // Merging cells for address
		$sheet->setCellValue('B2', 'LOT 5976 JALAN TEPI SUNGAI, KLANG SELANGOR D.E, SELANGOR - 41100');
		
		$sheet->getStyle('B2')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('B2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$sheet->setCellValue('F3', 'TEL : 03-33710909');
		$sheet->getStyle('F3')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('F3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);


		$sheet->mergeCells('A5:E5'); // Merging cells for the reconciliation report title
		$sheet->setCellValue('A5', 'RECONCILIATION REPORT AT ' . strtoupper(date('F Y', strtotime($fdate))));
		$sheet->getStyle('A5')->getFont()->setBold(true)->setSize(12);
		$sheet->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		// Adjust row heights to ensure visibility
		$sheet->getRowDimension('1')->setRowHeight(40);
		$sheet->getRowDimension('2')->setRowHeight(20);
		$sheet->getRowDimension('3')->setRowHeight(20);
		$sheet->getRowDimension('4')->setRowHeight(20);
		$sheet->getRowDimension('5')->setRowHeight(20);

		// Write pending debit transactions
		$sheet->setCellValue('A7', 'OUTSTANDING CHARGES');
		$sheet->mergeCells('A4:E4');
		$sheet->getStyle('A4:E4')->getFont()->setBold(true);
		$sheet->fromArray(['ID', 'DATE', 'MEMO/PAYEE', 'PAYMENTS', 'AMOUNT'], NULL, 'A6');
		$sheet->getStyle('A7:E7')->getFont()->setBold(true);

		$rows = 8; // Start adding data from row 6
		foreach ($data['pending_debit_transactions'] as $val) {
			$sheet->setCellValue('A' . $rows, $val['entry_code']);
			$sheet->setCellValue('B' . $rows, date('Y-m-d', strtotime($val['date'])));
			$sheet->setCellValue('C' . $rows, $val['narration']);
			$sheet->setCellValue('D' . $rows, '-');
			$sheet->setCellValue('E' . $rows, number_format($val['amount'], 2));
			$rows++;
		}

		// Space between tables
		$rows += 2;

		// Write pending credit transactions
		$sheet->setCellValue('A' . $rows, 'OUTSTANDING PAYMENTS');
		$sheet->mergeCells('A' . $rows . ':E' . $rows);
		$sheet->getStyle('A' . $rows . ':E' . $rows)->getFont()->setBold(true);
		$rows++;

		$sheet->getStyle('A' . $rows . ':E' . $rows)->getFont()->setBold(true);
		$rows++;

		foreach ($data['pending_credit_transactions'] as $val) {
			$sheet->setCellValue('A' . $rows, $val['entry_code']);
			$sheet->setCellValue('B' . $rows, date('Y-m-d', strtotime($val['date'])));
			$sheet->setCellValue('C' . $rows, $val['narration']);
			$sheet->setCellValue('D' . $rows, number_format($val['amount'], 2));
			$sheet->setCellValue('E' . $rows, '-');
			$rows++;
		}
 

			// Adding reconciliation summary to Excel
			$rows += 4; // Add some space after the transaction lists
		$sheet->setCellValue('A' . $rows, 'RECONCILIATION');
		$sheet->mergeCells('A' . $rows . ':E' . $rows);
		$sheet->getStyle('A' . $rows . ':E' . $rows)->getFont()->setBold(true)->setSize(14);
		$rows++;

		// Headers
		$sheet->setCellValue('A' . $rows, 'Description');
		$sheet->setCellValue('B' . $rows, 'Amount');
		$sheet->getStyle('A' . $rows . ':B' . $rows)->getFont()->setBold(true);
		$rows++;

		// Cash Book Balance
		$sheet->setCellValue('A' . $rows, 'Cash Book Balance on ' . date('d-m-Y', strtotime($tdate)));
		$sheet->setCellValue('B' . $rows, number_format($closing_balance, 2));
		$rows++;

		// Outstanding Charges
		$sheet->setCellValue('A' . $rows, 'Subtract: Outstanding Charges:');
		$sheet->setCellValue('B' . $rows, number_format($outstanding_charges, 2));
		$rows++;

		// Line for visual separation
		$sheet->setCellValue('A' . $rows, '');
		$sheet->setCellValue('B' . $rows, '----------');
		$rows++;

		// Subtotal
		$subtotal = $closing_balance - $outstanding_charges;
		$sheet->setCellValue('A' . $rows, 'Subtotal:');
		$sheet->setCellValue('B' . $rows, number_format($subtotal, 2));
		$rows++;

		// Outstanding Payments
		$sheet->setCellValue('A' . $rows, 'Add: Outstanding Payments:');
		$sheet->setCellValue('B' . $rows, number_format($outstanding_payments, 2));
		$rows++;

		// Line for visual separation
		$sheet->setCellValue('A' . $rows, '');
		$sheet->setCellValue('B' . $rows, '----------');
		$rows++;

		// Expected Balance on Statement
		$expected_total = $subtotal + $outstanding_payments;
		$sheet->setCellValue('A' . $rows, 'Expected Balance on Statement:');
		$sheet->setCellValue('B' . $rows, number_format($expected_total, 2));
		$rows++;
		
		// Save the Excel file
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$file_path = 'uploads/excel/' . $fileName . '.xlsx';
		$writer->save($file_path);

		// Return download response to browser
		return $this->response->download($file_path, null)->setFileName($fileName . '.xlsx');
	}



}