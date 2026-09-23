<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;

class Reportaccount extends BaseController{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common');
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
	function cash_expense(){
		if(!empty($_REQUEST['ledger'])) $ledger_id = $_REQUEST['ledger'];
        else $ledger_id = '';
		$filter_option = !empty($_REQUEST['filter_option']) ? $_REQUEST['filter_option'] : 'single';
        if($_REQUEST['month']) $month = $_REQUEST['month'];
        else $month = date("Y-m");
        $group = $this->db->table("groups")->get()->getResultArray();
		if(count($group) > 0){
			foreach($group as $row){
				$rows = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getNumRows();
				if($rows > 0){
					$ledger[] = '<optgroup label="'.$row['name'].'">';
					$res = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getResultArray();
					foreach($res as $r){
						$id = $r['id'];
						$ledgername = $r['left_code'] . '/' . $r['right_code'] . '-' . $r['name'];
						if($id == $ledger_id) $selected = 'selected';
						else $selected = '';
						$ledger[] .= '<option value="'.$id.'" '.$selected.'>'.$ledgername.'</option>';
					}
					$ledger[] .='</optgroup>';
				}
			}
        }
		$exp_list = array();
		if(!empty($ledger_id)){
			if($filter_option == 'single'){
				$exp_list = $this->db->query("select max(l.name) as name, max(l.left_code) as left_code, max(l.right_code) as right_code, max(e.narration) as narration, COALESCE(sum(ei.amount), 0) as amount from `entryitems` ei left join entries e on e.id=ei.entry_id left join ledgers l on l.id = ei.ledger_id where ei.entry_id in (SELECT entry_id from `entryitems` where dc = 'C' and ledger_id = $ledger_id) and ei.dc ='D' and DATE_FORMAT(e.date, '%Y-%m') = '$month' GROUP By l.id")->getResultArray();
			}else{
				$exp_list = $this->db->query("select ei.entry_id, e.date, l.name, l.left_code, l.right_code, e.narration, ei.amount from `entryitems` ei left join entries e on e.id=ei.entry_id left join ledgers l on l.id = ei.ledger_id where ei.entry_id in (SELECT entry_id from `entryitems` where dc = 'C' and ledger_id = $ledger_id) and ei.dc ='D' and DATE_FORMAT(e.date, '%Y-%m') = '$month'")->getResultArray();
			}
		}
        $data['filter_option'] = $filter_option;
        $data['ledger_id'] = $ledger_id;
        $data['month'] = $month;
        $data['ledger'] = $ledger;
        $data['exp_list'] = $exp_list;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('reportaccount/cash_expense', $data);
		echo view('template/footer');
	}
	function print_cash_expense(){
		if(!empty($_REQUEST['ledger'])) $ledger_id = $_REQUEST['ledger'];
        else $ledger_id = '';
		$filter_option = !empty($_REQUEST['filter_option']) ? $_REQUEST['filter_option'] : 'single';
        if($_REQUEST['month']) $month = $_REQUEST['month'];
        else $month = date("Y-m");
        $group = $this->db->table("groups")->get()->getResultArray();
		if(count($group) > 0){
			foreach($group as $row){
				$rows = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getNumRows();
				if($rows > 0){
					$ledger[] = '<optgroup label="'.$row['name'].'">';
					$res = $this->db->table("ledgers")->where('group_id', $row['id'])->where('type', 1)->like('name', 'cash', 'both')->get()->getResultArray();
					foreach($res as $r){
						$id = $r['id'];
						$ledgername = $r['left_code'] . '/' . $r['right_code'] . '-' . $r['name'];
						if($id == $ledger_id) $selected = 'selected';
						else $selected = '';
						$ledger[] .= '<option value="'.$id.'" '.$selected.'>'.$ledgername.'</option>';
					}
					$ledger[] .='</optgroup>';
				}
			}
        }
		$exp_list = array();
		if(!empty($ledger_id)){
			if($filter_option == 'single'){
				$exp_list = $this->db->query("select max(l.name) as name, max(l.left_code) as left_code, max(l.right_code) as right_code, max(e.narration) as narration, COALESCE(sum(ei.amount), 0) as amount from `entryitems` ei left join entries e on e.id=ei.entry_id left join ledgers l on l.id = ei.ledger_id where ei.entry_id in (SELECT entry_id from `entryitems` where dc = 'C' and ledger_id = $ledger_id) and ei.dc ='D' and DATE_FORMAT(e.date, '%Y-%m') = '$month' GROUP By l.id")->getResultArray();
			}else{
				$exp_list = $this->db->query("select ei.entry_id, e.date, l.name, l.left_code, l.right_code, e.narration, ei.amount from `entryitems` ei left join entries e on e.id=ei.entry_id left join ledgers l on l.id = ei.ledger_id where ei.entry_id in (SELECT entry_id from `entryitems` where dc = 'C' and ledger_id = $ledger_id) and ei.dc ='D' and DATE_FORMAT(e.date, '%Y-%m') = '$month'")->getResultArray();
			}
		}
        $data['filter_option'] = $filter_option;
        $data['ledger_id'] = $ledger_id;
        $data['month'] = $month;
        $data['ledger'] = $ledger;
        $data['exp_list'] = $exp_list;
		echo view('reportaccount/print_cash_expense', $data);
	}
}