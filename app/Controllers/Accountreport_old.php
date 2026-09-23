<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;

class Accountreport extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }

    public function ledger_report(){
		if(!$this->model->list_validate('ledger_report_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ledger_report_accounts');
		
        $id = $this->request->uri->getSegment(3);
        if(!empty($id)) $ledger_id = $id;
        else if($_POST['ledger']) $ledger_id = $_POST['ledger'];
        else $ledger_id =1;
        //var_dump($ledger_id);
        //exit;
        if($_POST['fdate']) $fdate = $_POST['fdate'];
        else $fdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
        $led_res = $this->ledger_statement($ledger_id, $fdate, $tdate);
        $group = $this->db->table("groups")->get()->getResultArray();

        foreach($group as $row){
            $ledger[] = '<optgroup label="'.$row['name'].'">';
            $res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
            foreach($res as $r){
                $id = $r['id'];
                $ledgername = get_ledger_name($id);
                if($ledger_id == $id) $selected = 'selected';
                else $selected = '';
                $ledger[] .= '<option '.$selected.' value="'.$id.'">'.$ledgername.'</option>';
            }
            $ledger[] .='</optgroup>';
        }
        $data['ledger_id'] = $ledger_id;
        $data['fdate'] = $fdate;
        $data['tdate'] = $tdate;
        $data['res'] = $led_res;
        $data['ledger'] =$ledger;
        $data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('account/ledger_report', $data);
		echo view('template/footer');
    }

    public function trail_balance(){
		if(!$this->model->list_validate('trial_balance_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
        if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
        //echo $sdate; echo $tdate;die;
        $query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
        //$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
        $parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach($parentgroup as $row){
			//print_r($row['id']);
			/*$datas[] = '<tr>
					   		<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
                            <td>-</td>
					   </tr>';*/
            $presult = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
            if(!empty($presult)){
                foreach($presult as $dd){
                    $id = $dd['id'];
                    $ledgername = get_ledger_name_only($id);
                    $ledgercode = get_ledger_code_only($id);
                    $debitamt = 0;
                    $creditamt= 0;
                    $op_bal = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
					if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
					{
						$op_balance_amt = $op_balance['cr_amount'];
					}
					else
					{
						$op_balance_amt = $op_balance['dr_amount'];
					}
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                    $d_amt = $this->db->query($d_sql)->getRowArray();
                    $c_amt = $this->db->query($c_sql)->getRowArray();
                    $debitamt  = $d_amt['amount'];
                    $creditamt = $c_amt['amount'];
                    $clbal = ( $op_bal + $debitamt) - $creditamt;
                    if(!empty($debitamt) || !empty($creditamt))
                    {
                        $datas[] = '<tr>
                                    <td>'.$ledgercode.'</td>
                                    <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a>
                                    </td>
                                    <td align="right">'.number_format($debitamt, '2','.',',').'</td>
                                    <td align="right">'.number_format($creditamt, '2','.',',').'</td>
                                </tr>';
                    }
                    $totalopb += $op_balance_amt;
                    $totaldeb += $debitamt;
                    $totalcre += $creditamt;
                    $totalclb += $clbal;
                }
            }
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
                    /*$datas[] = '<tr>
                                <td>&emsp;&emsp;'.$crow['name'].'</td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                        </tr>';*/
                        $res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
                        foreach($res as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_bal = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
                            if(!empty($debitamt) || !empty($creditamt))
                            {
                            $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a></td>
                                            <td align="right">'.number_format($debitamt, '2','.',',').'</td>
                                            <td align="right">'.number_format($creditamt, '2','.',',').'</td>
                                        </tr>';
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $debitamt;
                            $totalcre += $creditamt;
                            $totalclb += $clbal;
                        }
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        /*$datas[] = '<tr>
                                <td>&emsp;&emsp;'.$ccg['name'].'</td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                        </tr>';*/
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_bal = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $op_bal = $op_balance_amt; 
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
                            if(!empty($debitamt) || !empty($creditamt))
                            {
                            $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a></td>
                                            <td align="right">'.number_format($debitamt, '2','.',',').'</td>
                                            <td align="right">'.number_format($creditamt, '2','.',',').'</td>
                                        </tr>';
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $debitamt;
                            $totalcre += $creditamt;
                            $totalclb += $clbal;
                        }
                    }
                }
            }
			//print_r($res);
		}//die;
        $datas[] = '<tfoot><tr style="color: black;">
					<td align="right" colspan="2"><b>Total</b></td>
					<td align="right">'.number_format($totaldeb, '2','.','').'</td>
					<td align="right">'.number_format($totalcre, '2','.','').'</td>
					</tr></tfoot>';
        $data['sdate'] = $sdate;
        $data['tdate'] = $tdate;
        $data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/trail_balance', $data);
		echo view('template/footer');
    }
	public function trail_balance_new(){
		if(!$this->model->list_validate('trial_balance_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
        if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
        //echo $sdate; echo $tdate;die;
        $query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
        //$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
        $parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach($parentgroup as $row){
			//print_r($row['id']);
			/*$datas[] = '<tr>
					   		<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
                            <td>-</td>
					   </tr>';*/
            $presult = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
            if(!empty($presult)){
                foreach($presult as $dd){
                    $id = $dd['id'];
                    $ledgername = get_ledger_name_only($id);
                    $ledgercode = get_ledger_code_only($id);
                    $debitamt = 0;
                    $creditamt= 0;
                    $op_bal = 0;
                    $op_balance_amt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
					if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
					{
						$op_balance_amt -= $op_balance['cr_amount'];
					}
					else
					{
						$op_balance_amt += $op_balance['dr_amount'];
					}
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'";
                    $d_amt = $this->db->query($d_sql)->getRowArray();
                    $c_amt = $this->db->query($c_sql)->getRowArray();
                    $debitamt  = $d_amt['amount'];
                    $creditamt = $c_amt['amount'];
                    $clbal = ( $op_bal + $debitamt) - $creditamt;
                    $tab_credit = $tab_debit = 0;
					if($clbal < 0) $tab_credit = abs($clbal);
					else $tab_debit = $clbal;
					if(!empty($tab_debit) || !empty($tab_credit))
					{
                        $datas[] = '<tr>
                                    <td>'.$ledgercode.'</td>
                                    <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a>
                                    </td>
                                    <td align="right">'.number_format($tab_debit, '2','.',',').'</td>
                                    <td align="right">'.number_format($tab_credit, '2','.',',').'</td>
                                </tr>';
                    }
                    $totalopb += $op_balance_amt;
                    $totaldeb += $tab_debit;
                    $totalcre += $tab_credit;
                    $totalclb += $clbal;
                }
            }
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
                    /*$datas[] = '<tr>
                                <td>&emsp;&emsp;'.$crow['name'].'</td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                        </tr>';*/
                        $res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
                        foreach($res as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_bal = 0;
                            $op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt -= $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt += $op_balance['dr_amount'];
							}
                            $op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
                            $tab_credit = $tab_debit = 0;
							if($clbal < 0) $tab_credit = abs($clbal);
							else $tab_debit = $clbal;
                            if(!empty($tab_debit) || !empty($tab_credit))
                            {
                            $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a></td>
                                            <td align="right">'.number_format($tab_debit, '2','.',',').'</td>
                                            <td align="right">'.number_format($tab_credit, '2','.',',').'</td>
                                        </tr>';
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $tab_debit;
                            $totalcre += $tab_credit;
                            $totalclb += $clbal;
                        }
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        /*$datas[] = '<tr>
                                <td>&emsp;&emsp;'.$ccg['name'].'</td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                        </tr>';*/
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_bal = 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt -= $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt += $op_balance['dr_amount'];
							}
                            $op_bal = $op_balance_amt; 
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if($clbal < 0) $tab_credit = abs($clbal);
							else $tab_debit = $clbal;
                            if(!empty($tab_debit) || !empty($tab_credit))
                            {
                            $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a></td>
                                            <td align="right">'.number_format($tab_credit, '2','.',',').'</td>
                                            <td align="right">'.number_format($tab_debit, '2','.',',').'</td>
                                        </tr>';
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $tab_debit;
                            $totalcre += $tab_credit;
                            $totalclb += $clbal;
                        }
                    }
                }
            }
			//print_r($res);
		}//die;
        $datas[] = '<tfoot><tr style="color: black;">
					<td align="right" colspan="2"><b>Total</b></td>
					<td align="right">'.number_format($totaldeb, '2','.','').'</td>
					<td align="right">'.number_format($totalcre, '2','.','').'</td>
					</tr></tfoot>';
        $data['sdate'] = $sdate;
        $data['tdate'] = $tdate;
        $data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
        echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/trail_balance_new', $data);
		echo view('template/footer');
    }
    public function balance_sheet(){
		if(!$this->model->list_validate('balance_sheet_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('balance_sheet_accounts');
		
        echo view('template/header');
		echo view('template/sidebar');
		//echo view('account/index', $data);
		echo view('template/footer');
    }

    public function profile_loss(){
        if(!$this->model->list_validate('profit_and_loss_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('profit_and_loss_accounts');
        //var_dump($_POST);
       // exit;
		if($_POST['sdate']) $sdate = $_POST['sdate']; 
        else $sdate = date('Y-m-01');
        if($_POST['edate']) $edate = $_POST['edate'];
        else $edate = date('Y-m-d');
        //echo $job_code; //die;
        $table = array();
        $data = array();
        $datas = array();
        $total_income = 0; $total_expenses = 0;
        // Income List
        $id = [27, 28, 29];  // direct income, indirect income and sales account group id
        //$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
        $res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
        $subincome_array = array();
        foreach($res as $row){
           $subincome_array[$row['name']] = $row['id'];
        }
        $main_incomes['Income'] = "26";
        $income_array = array_merge($main_incomes,$subincome_array);
        //var_dump($income_array);
        //exit;
        foreach($income_array as $key => $row){
            $led_list = $this->db->table("ledgers")->where('group_id', $row)->get()->getResultArray();
            foreach($led_list as $led){
                $led_bd = $this->db->table('entryitems', 'entries')
                            ->join('entries', 'entries.id = entryitems.entry_id')
                            ->where('entryitems.ledger_id', $led['id'])
                            ->where('entries.date >=', $sdate)
                            ->where('entries.date <=', $edate);
                $led_res = $led_bd->select('entryitems.*')
                            ->select('entries.date')
                            ->get()
                            ->getResultArray();
                $total_dr = 0; $total_cr = 0;
                foreach($led_res as $dr){
                    if(is_numeric($dr['amount']) == true){
                        if(!empty($dr['amount'])) $amount = $dr['amount'];
                        else $amount = 0;

                        if($dr['dc'] == 'D') $total_dr += $amount;
                        if($dr['dc'] == 'C') $total_cr += $amount;
                    }
                }
               $fin_amt = $total_cr - $total_dr;
               $led_name = $led['id'];
               $data['Income'][$key][] = array(
                                                    "$led_name" => $fin_amt
                                                );
            }
        }
      // var_dump($data);
      // exit;
        if(count($data)){
            foreach($data as $key => $val){    
                $table[] = '<tr><td style="font-weight: bold;font-size: medium;">'.$key.'</td><td></td><tr>';
                foreach($val as $sub_key => $sub_val){
                    if($sub_key != "Income"){
                        $sub_total_income = get_profit_loss_subtotal($sub_val);
                        if($sub_total_income > 0)
                        {
                            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td><td></td><tr>';
                        }
                    }
                    foreach($sub_val as $skey => $sval){
                        foreach($sval as $name => $amt){
                            if(!empty($amt))
                            {
                                $ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
                                $table[] .= '<tr><td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' .$ledgername.'</td><td align="right" >'.number_format($amt, "2",".",",").'</td><tr>';
                            }
                            $total_income += $amt;
                        }
                    }
                }
            }
        }
        else{
            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Income</td><td></td><tr>';
        }
       $table[] .= '<tr><td>Total Income</td><td align="right" >'.number_format($total_income, "2",".",",").'</td><tr>';

       // Expenses 
       // Direct expenses in staff  id 38
        $id = [31,45];
        //$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
        $res = $this->db->table('groups')->where('parent_id', 30)->get()->getResultArray();
        //echo '<pre>'; print_r($res);die;
        $subexpense_array = array();
        foreach($res as $row){
           $subexpense_array[$row['name']] = $row['id'];
        }
        $main_expenses['Expenses'] = "30";
        $expense_array = array_merge($main_expenses,$subexpense_array);
        foreach($expense_array as $key => $row){
            $led_list = $this->db->table("ledgers")->where('group_id', $row)->get()->getResultArray();
            foreach($led_list as $led){
				$led_bd = $this->db->table('entryitems', 'entries')
                            ->join('entries', 'entries.id = entryitems.entry_id')
                            ->where('entryitems.ledger_id', $led['id'])
                            ->where('entries.date >=', $sdate)
                            ->where('entries.date <=', $edate);
                $led_res = $led_bd->select('entryitems.*')
                            ->select('entries.date')
                            ->get()
                            ->getResultArray();
                $total_dr = 0; $total_cr = 0;
                foreach($led_res as $dr){
                    if(is_numeric($dr['amount']) == true){
                        if(!empty($dr['amount'])) $amount = $dr['amount'];
                        else $amount = 0;

                        if($dr['dc'] == 'D') $total_dr += $amount;
                        if($dr['dc'] == 'C') $total_cr += $amount;
                    }
                }
               $fin_amt = $total_dr - $total_cr;
               $led_name = $led['id'];
               $datas['Expenses'][$key][] = array(
                                                    "$led_name" => $fin_amt
                                                );
            }
        }
       if(count($datas)){
            foreach($datas as $key => $val){    
                $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">'.$key.'</td><td></td><tr>';
                foreach($val as $sub_key => $sub_val){
                    if($sub_key != "Expenses"){
                        $sub_total_expenses = get_profit_loss_subtotal($sub_val);
                        if($sub_total_expenses > 0)
                        {
                            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td><td></td><tr>';
                        }
                    }
                    foreach($sub_val as $skey => $sval){
                        foreach($sval as $name => $amt){
                            if(!empty($amt))
                            {
                                $ledgername = get_ledger_name_only($name);
                                $ledgercode = get_ledger_code_only($name);
                                $table[] .= '<tr><td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' .$ledgername.'</td><td align="right" >'.number_format($amt, "2",".",",").'</td><tr>';
                            }
                            $total_expenses += $amt;
                        }
                    }
                }
            }
        }else{
            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Expenses</td><td></td><tr>';
            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;Direct Expenses</td><td></td><tr>';
        }
        $table[] .= '<tr><td>Total Expenses</td><td align="right" >'.number_format($total_expenses, "2",".",",").'</td><tr>'; 
        
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $profit = $total_income - $total_expenses;
        if($profit >= 0) $data['profit'] = 'Total Profit Amount is '.number_format($profit, '2','.',',');
        else{ $neg = $profit * -1; $data['profit'] = 'Total Loss Amount is '.number_format($neg , '2','.',','); }
        $data['table'] = $table;
        
        echo view('template/header');
		echo view('template/sidebar');
		echo view('account/profitloss', $data);
		echo view('template/footer');
    }
    
    public function ledger_statement($ledger ='', $fdate ='', $tdate =''){
        $id = $this->request->uri->getSegment(3);
        if(!empty($id)) $ledger = $id;
        else{
            if($_POST['fdate']) $fdate  = $_POST['fdate'];
            else $fdate  = $fdate;
            if($_POST['tdate']) $tdate  = $_POST['tdate'];
            else $tdate  = $tdate;
            $tdate  = $_POST['tdate'];
        }
        //echo $ledger; echo '<br>'; echo $fdate; echo '<br>'; echo $tdate; die;
        if(empty($fdate) && empty($tdate)){
            $res = $this->db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entryitems.ledger_id', $ledger)
					->select('entryitems.*')
					->select('entries.*')
					->get()
					->getResultArray();
        }else{
            if(empty($tdate)) $tdate = date("Y-m-d");
            $res = $this->db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entries.date >=', $fdate )
					->where('entries.date <=', $tdate )
					->where('entryitems.ledger_id', $ledger)
					->select('entryitems.*')
					->select('entries.*')
					->get()
					->getResultArray();
        }
        // echo $ledger.'<br>'.$fdate.'<br>'.$tdate.'<br>'.$this->db->getLastQuery().'<br>'; 
        // echo '<pre>'; print_r($res);//die;
        //Opening Balance
        $op_bal = $this->db->table('ledgers')->where('id', $ledger)->get()->getRowArray();
        $op_bal = $op_bal['op_balance'];
        //echo $op_bal.'<br>';
        if(!empty($fdate)){
            $date = explode('-', $fdate);
            $m = $date[1]; $de = $date[2]; $y = $date[0];
            $ydate = date('Y-m-d', mktime(0,0,0,$m,($de-1),$y)); 
           
            $ops = $this->db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entries.date <=', $ydate )
					->where('entryitems.ledger_id', $ledger)
					->select('entryitems.*')
					->select('entries.*')
					->get()
					->getResultArray();
					
			foreach($ops as $rd){
			    if($rd['dc'] == 'D') $op_bal = $op_bal + $rd['amount'];
                else $op_bal = $op_bal - $rd['amount'];
			}
        }
        // echo $op_bal;
        // die;
        $data['op_bal'] = $op_bal;
        $i=0;
        $datas = array();
        foreach($res as $row){
            // Ledger Name
            $getentry = $this->db->table('entryitems')->where('entry_id', $row['entry_id'])->get()->getResultArray();
            if($getentry[0]['dc'] == 'D') $debit_name = $this->db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
            else $debit_name = $this->db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();
            
            if($getentry[0]['dc'] == 'C') $credit_name = $this->db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
            else $credit_name = $this->db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();
            
           // $ledger =  $debit_name['name'].' / Cr '.$credit_name['name'];
            $ledger =  $row['narration'];
            // if($row['type'] == 1) $table = 'ubayam';
            // else if($row['type'] == 2) $table = 'donation';
            // else if($row['type'] == 3) $table = 'archanai_booking';
            // else if($row['type'] == 4) $table = 'donation_product';
            // else if($row['type'] == 5) $table = 'stock_inward';
            // else $table = 'stock_outward';
            
           /* //Invoice Number Get
            $inv_details = $this->db->table($table)->where('id', $row['inv_id'])->get()->getRowArray();
            if($inv_details['invoice_no'] != '') $inv_no = $inv_details['invoice_no'];
            else if($inv_details['ref_no'] != '') $inv_no = $inv_details['ref_no'];
            else $inv_no = '-'; */
            
            //Credit Amount
            if(!empty($row['amount'])) $amount = $row['amount'];
            else $amount = 0;
            if($row['dc'] == 'D'){
				//$debit = 'Dr '.str_replace('-0', '0', number_format($amount, '2','.',','));
				$debit = str_replace('-0', '0', number_format($amount, '2','.',','));
				$debit_amount = $amount;
            }else{
				$debit = '';
				$debit_amount = 0.00;
			}
            
            if($row['dc'] == 'C'){
				/* $credit = 'Cr '.str_replace('-0', '0', number_format($amount, '2','.',',')); */
				$credit = str_replace('-0', '0', number_format($amount, '2','.',','));
				$credit_amount = $amount;
            }else{
				$credit = '';
				$credit_amount = 0.00;
			}
            
            //Balance Amount
            if($row['dc'] == 'C') $op_bal -= $amount;
            else $op_bal +=  $amount;
            
            //Report Data
            $datas[$i]['date']      = $row['date'];
            $datas[$i]['entry_code']      = $row['entry_code'];
            //$datas[$i]['inv_no'] = $inv_no;
            $datas[$i]['ledger']    = $ledger;
            $datas[$i]['debit']     = $debit;
            $datas[$i]['debit_amount']     = $debit_amount;
            $datas[$i]['credit']    = $credit;
            $datas[$i]['credit_amount']    = $credit_amount;
            $datas[$i]['balance']   = $op_bal;
            
            $i++;
        }
        $data['cl_bal'] = $op_bal;
        $data['data'] = $datas;
        if(empty($id)){
            return $data;
            exit;
        }else{
            
            echo view('account_report/ledger_statement', $data);
        }
    }
	
	public function print_ledger_statement(){
        if(!$this->model->permission_validate('ledger_report_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		
		$ledger_id = $_POST['ledger'];
        $fdate = $_POST['fdate'];
        $tdate = $_POST['tdate'];
        $led_res = $this->ledger_statement($ledger_id, $fdate, $tdate);
        $data = $led_res;
        echo view('account_report/ledger_statement', $data);
    }

	public function print_trial_balance(){
        if(!$this->model->permission_validate('trial_balance_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
	    //print_r($_POST);
		if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
        $parentgroup = $query->getResultArray();
        $datas = array();
		foreach($parentgroup as $row){
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach($res as $dd){
						$id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
													from entryitems 
													inner join entries on entries.id = entryitems. entry_id
													where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
						$clbal = ($op_balance_amt + $debitamt) - $creditamt;
                        if(!empty($debitamt) || !empty($creditamt))
                        {
						    $datas[] = '<tr>
										<td>'.$ledgercode.'</td>
										<td>'.$ledgername.'</td>
										<td align="right">'.number_format($debitamt, '2','.','').'</td>
										<td align="right">'.number_format($creditamt, '2','.','').'</td>
									</tr>';
                        }
									$totalopb += $op_balance_amt;
									$totaldeb += $debitamt;
									$totalcre += $creditamt;
									$totalclb += $clbal;
					}
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ($op_balance_amt + $debitamt) - $creditamt;
                            if(!empty($debitamt) || !empty($creditamt))
                            {
                                $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td>'.$ledgername.'</td>
                                            <td align="right">'.number_format($debitamt, '2','.','').'</td>
                                            <td align="right">'.number_format($creditamt, '2','.','').'</td>
                                        </tr>';
                            }
										$totalopb += $op_balance_amt;
										$totaldeb += $debitamt;
										$totalcre += $creditamt;
										$totalclb += $clbal;
                        }
                    }
                }
            }
			$res = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
			if(count($res) > 0){
				foreach($res as $dd){
					    $id = $dd['id'];
                        $ledgername = get_ledger_name_only($id);
                        $ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt= 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
						if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
						{
							$op_balance_amt = $op_balance['cr_amount'];
						}
						else
						{
							$op_balance_amt = $op_balance['dr_amount'];
						}
						$d_sql = "select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$c_sql = "select sum(entryitems.amount) as amount 
												from entryitems 
												inner join entries on entries.id = entryitems. entry_id
												where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt  = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
					$clbal = ($op_balance_amt + $debitamt) - $creditamt;
                    if(!empty($debitamt) || !empty($creditamt))
                    {
					    $datas[] = '<tr>
									<td>'.$ledgercode.'</td>
									<td>'.$ledgername.'</td>
									<td align="right">'.number_format($debitamt, '2','.','').'</td>
									<td align="right">'.number_format($creditamt, '2','.','').'</td>
								</tr>';
                    }
					$totalopb += $op_balance_amt;
					$totaldeb += $debitamt;
					$totalcre += $creditamt;
					$totalclb += $clbal;
				}
			}
			//print_r($res);
		}//die;
		
		$datas[] = '<tr style="color: black; border-top:1px solid black;">
					<td colspan="2"><b>Total</b></td>
					<td align="right" style="border-bottom:4px double black;">'.number_format($totaldeb, '2','.','').'</td>
					<td align="right" style="border-bottom:4px double black;">'.number_format($totalcre, '2','.','').'</td>
					</tr>';
        
        $data['list'] = $datas;
		echo view('account_report/print_trial_balance', $data);
	}
	
	public function print_trial_balance_new(){
        if(!$this->model->permission_validate('trial_balance_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
	    //print_r($_POST);
		if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
        $parentgroup = $query->getResultArray();
        $datas = array();
		foreach($parentgroup as $row){
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach($res as $dd){
						$id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt -= $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt += $op_balance['dr_amount'];
							}
                            $d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
													from entryitems 
													inner join entries on entries.id = entryitems. entry_id
													where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
							$clbal = ( $op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if($clbal < 0) $tab_credit = abs($clbal);
							else $tab_debit = $clbal;
							if(!empty($tab_debit) || !empty($tab_credit))
							{
								$datas[] = '<tr>
											<td>'.$ledgercode.'</td>
											<td>'.$ledgername.'</td>
											<td align="right">'.number_format($tab_debit, '2','.','').'</td>
											<td align="right">'.number_format($tab_credit, '2','.','').'</td>
										</tr>';
							}
							$totalopb += $op_balance_amt;
							$totaldeb += $tab_debit;
							$totalcre += $tab_credit;
							$totalclb += $clbal;
					}
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_balance_amt= 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt -= $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt += $op_balance['dr_amount'];
							}
                            $d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
							$clbal = ( $op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if($clbal < 0) $tab_credit = abs($clbal);
							else $tab_debit = $clbal;
							if(!empty($tab_debit) || !empty($tab_credit))
							{
                                $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td>'.$ledgername.'</td>
                                            <td align="right">'.number_format($tab_debit, '2','.','').'</td>
                                            <td align="right">'.number_format($tab_credit, '2','.','').'</td>
                                        </tr>';
                            }
							$totalopb += $op_balance_amt;
							$totaldeb += $tab_debit;
							$totalcre += $tab_credit;
							$totalclb += $clbal;
                        }
                    }
                }
            }
			$res = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
			if(count($res) > 0){
				foreach($res as $dd){
					    $id = $dd['id'];
                        $ledgername = get_ledger_name_only($id);
                        $ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt= 0;
						$op_balance_amt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
						if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
						{
							$op_balance_amt = $op_balance['cr_amount'];
						}
						else
						{
							$op_balance_amt = $op_balance['dr_amount'];
						}
						$d_sql = "select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$c_sql = "select sum(entryitems.amount) as amount 
												from entryitems 
												inner join entries on entries.id = entryitems. entry_id
												where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt  = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ( $op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if($clbal < 0) $tab_credit = abs($clbal);
						else $tab_debit = $clbal;
						if(!empty($tab_debit) || !empty($tab_credit))
						{
							$datas[] = '<tr>
										<td>'.$ledgercode.'</td>
										<td>'.$ledgername.'</td>
										<td align="right">'.number_format($tab_debit, '2','.','').'</td>
										<td align="right">'.number_format($tab_credit, '2','.','').'</td>
									</tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
				}
			}
			//print_r($res);
		}//die;
		
		$datas[] = '<tr style="color: black; border-top:1px solid black;">
					<td colspan="2"><b>Total</b></td>
					<td align="right" style="border-bottom:4px double black;">'.number_format($totaldeb, '2','.','').'</td>
					<td align="right" style="border-bottom:4px double black;">'.number_format($totalcre, '2','.','').'</td>
					</tr>';
        
        $data['list'] = $datas;
		echo view('account_report/print_trial_balance', $data);
	}

    public function print_trial_balance11() {
        if(!$this->model->permission_validate('trial_balance_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		

		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
        if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
        //echo $sdate; echo $tdate;die;
        $query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
        //$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
        $parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach($parentgroup as $row){
			//print_r($row['id']);
			/*$datas[] = '<tr>
					   		<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
                            <td>-</td>
					   </tr>';*/
            $presult = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
            if(!empty($presult)){
                foreach($presult as $dd){
                    $id = $dd['id'];
                    $ledgername = get_ledger_name_only($id);
                    $ledgercode = get_ledger_code_only($id);
                    $debitamt = 0;
                    $creditamt= 0;
                    $op_bal = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
					if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
					{
						$op_balance_amt = $op_balance['cr_amount'];
					}
					else
					{
						$op_balance_amt = $op_balance['dr_amount'];
					}
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                    $d_amt = $this->db->query($d_sql)->getRowArray();
                    $c_amt = $this->db->query($c_sql)->getRowArray();
                    $debitamt  = $d_amt['amount'];
                    $creditamt = $c_amt['amount'];
                    $clbal = ( $op_bal + $debitamt) - $creditamt;
                    if(!empty($debitamt) || !empty($creditamt))
                    {
                        $datas[] = '<tr>
                                    <td>'.$ledgercode.'</td>
                                    <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a>
                                    </td>
                                    <td align="right">'.number_format($debitamt, '2','.',',').'</td>
                                    <td align="right">'.number_format($creditamt, '2','.',',').'</td>
                                </tr>';
                    }
                    $totalopb += $op_balance_amt;
                    $totaldeb += $debitamt;
                    $totalcre += $creditamt;
                    $totalclb += $clbal;
                }
            }
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
                    /*$datas[] = '<tr>
                                <td>&emsp;&emsp;'.$crow['name'].'</td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                        </tr>';*/
                        $res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
                        foreach($res as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_bal = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
                            if(!empty($debitamt) || !empty($creditamt))
                            {
                            $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a></td>
                                            <td align="right">'.number_format($debitamt, '2','.',',').'</td>
                                            <td align="right">'.number_format($creditamt, '2','.',',').'</td>
                                        </tr>';
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $debitamt;
                            $totalcre += $creditamt;
                            $totalclb += $clbal;
                        }
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        /*$datas[] = '<tr>
                                <td>&emsp;&emsp;'.$ccg['name'].'</td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                        </tr>';*/
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_bal = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $op_bal = $op_balance_amt; 
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
                            if(!empty($debitamt) || !empty($creditamt))
                            {
                            $datas[] = '<tr>
                                            <td>'.$ledgercode.'</td>
                                            <td><a href="#" style="" id="'.$dd['id'].'" onclick="ledger_report('.$dd['id'].')">'.$ledgername.'</a></td>
                                            <td align="right">'.number_format($debitamt, '2','.',',').'</td>
                                            <td align="right">'.number_format($creditamt, '2','.',',').'</td>
                                        </tr>';
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $debitamt;
                            $totalcre += $creditamt;
                            $totalclb += $clbal;
                        }
                    }
                }
            }
			//print_r($res);
		}//die;
        $datas[] = '<tfoot><tr style="color: black;">
					<td align="right" colspan="2"><b>Total</b></td>
					<td align="right">'.number_format($totaldeb, '2','.','').'</td>
					<td align="right">'.number_format($totalcre, '2','.','').'</td>
					</tr></tfoot>';
        $data['sdate'] = $sdate;
        $data['tdate'] = $tdate;
        $data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
        
		
		echo view('account_report/print_trial_balance', $data);
	}

	
	public function excel_trial_balance(){
        if(!$this->model->permission_validate('trial_balance_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);
		if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
        $parentgroup = $query->getResultArray();
		$data = array();
		foreach($parentgroup as $row){
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach($res as $dd){
						$id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
													from entryitems 
													inner join entries on entries.id = entryitems. entry_id
													where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
						$clbal = ($op_balance_amt + $debitamt) - $creditamt;
                        if(!empty($debitamt) || !empty($creditamt))
                        {
                            $data[] = array(
                                        "ledgercode"=>$ledgercode,
                                        "ledgername"=>$ledgername,
                                        "debitamt"=>number_format($debitamt, '2','.',''),
                                        "creditamt"=>number_format($creditamt, '2','.','')
                                    );
                        }
                        $totalopb += $op_balance_amt;
                        $totaldeb += $debitamt;
                        $totalcre += $creditamt;
                        $totalclb += $clbal;
					}
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
                            $d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ($op_balance_amt + $debitamt) - $creditamt;
                            if(!empty($debitamt) || !empty($creditamt))
                            {
                                $data[] = array(
                                            "ledgercode"=>$ledgercode,
                                            "ledgername"=>$ledgername,
                                            "debitamt"=>number_format($debitamt, '2','.',''),
                                            "creditamt"=>number_format($creditamt, '2','.','')
                                        );
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $debitamt;
                            $totalcre += $creditamt;
                            $totalclb += $clbal;
                        }
                    }
                }
            }
			$res = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
			if(count($res) > 0){
				foreach($res as $dd){
					    $id = $dd['id'];
                        $ledgername = get_ledger_name_only($id);
                        $ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt= 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
						if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
						{
							$op_balance_amt = $op_balance['cr_amount'];
						}
						else
						{
							$op_balance_amt = $op_balance['dr_amount'];
						}
						$d_sql = "select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$c_sql = "select sum(entryitems.amount) as amount 
												from entryitems 
												inner join entries on entries.id = entryitems. entry_id
												where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt  = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
					$clbal = ($op_balance_amt + $debitamt) - $creditamt;
                    if(!empty($debitamt) || !empty($creditamt))
                    {
                        $data[] = array(
                                    "ledgercode"=>$ledgercode,
                                    "ledgername"=>$ledgername,
                                    "debitamt"=>number_format($debitamt, '2','.',''),
                                    "creditamt"=>number_format($creditamt, '2','.','')
                                );
                    }
					$totalopb += $op_balance_amt;
					$totaldeb += $debitamt;
					$totalcre += $creditamt;
					$totalclb += $clbal;
				}
			}
			//print_r($res);
		}//die;
        $datas = array(
                        "Total"=>"Total",
                        "totaldeb"=>number_format($totaldeb, '2','.',''),
                        "totalcre"=>number_format($totalcre, '2','.','')
                    );
        $fileName = "trial_balance_".$sdate."_to_".$tdate;  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->getStyle('A2:D2')->getFont()->setBold(true);
        $sheet->getStyle("A1:D1")->applyFromArray($style);
        $sheet->mergeCells('A1:D1'); 
        $sheet->setCellValue('A1', "SREE SELVA VINAYAGAR TEMPLE");
        $sheet->setCellValue('A2', 'A/C No');
        $sheet->setCellValue('B2', 'Description');
        $sheet->setCellValue('C2', 'Debit');
        $sheet->setCellValue('D2', 'Credit');  
        $rows = 3;
        foreach ($data as $val)
        {
            $sheet->setCellValue('A' . $rows, $val['ledgercode']);
            $sheet->setCellValue('B' . $rows, $val['ledgername']);
            $sheet->setCellValue('C' . $rows, $val['debitamt']);
            $sheet->setCellValue('D' . $rows, $val['creditamt']);
            $rows++;
        }
        $sheet->setCellValue('A' . $rows, "");
        $sheet->setCellValue('B' . $rows, "Total");
        $sheet->setCellValue('C' . $rows, $datas['totaldeb']);
        $sheet->setCellValue('D' . $rows, $datas['totalcre']);
        $writer = new Xlsx($spreadsheet);
        $writer->save('uploads/excel/'.$fileName.'.xlsx');
        return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');

	}
	public function excel_trial_balance_new(){
        if(!$this->model->permission_validate('trial_balance_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);
		if($_POST['fdate']) $sdate = $_POST['fdate'];
        else $sdate = date("Y-m-01");
        if($_POST['tdate']) $tdate = $_POST['tdate'];
        else $tdate = date("Y-m-d");
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
        $parentgroup = $query->getResultArray();
		$data = array();
		foreach($parentgroup as $row){
            $childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
            if(!empty($childgroup)){
                foreach($childgroup as $crow){
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach($res as $dd){
						$id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt -= $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
                            $d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
													from entryitems 
													inner join entries on entries.id = entryitems. entry_id
													where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
							$clbal = ( $op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if($clbal < 0) $tab_credit = abs($clbal);
							else $tab_debit = $clbal;
							if(!empty($tab_debit) || !empty($tab_credit))
							{
								$data[] = array(
                                        "ledgercode"=>$ledgercode,
                                        "ledgername"=>$ledgername,
                                        "debitamt"=>number_format($tab_debit, '2','.',''),
                                        "creditamt"=>number_format($tab_credit, '2','.','')
                                    );
							}
							$totalopb += $op_balance_amt;
							$totaldeb += $tab_debit;
							$totalcre += $tab_credit;
							$totalclb += $clbal;
					}
                    $cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
                    foreach($cgroup as $ccg){
                        $cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
                        
                        foreach($cgchild as $dd){
                            $id = $dd['id'];
                            $ledgername = get_ledger_name_only($id);
                            $ledgercode = get_ledger_code_only($id);
                            $debitamt = 0;
                            $creditamt= 0;
                            $op_balance_amt= 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt -= $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
                            $d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
                            $d_amt = $this->db->query($d_sql)->getRowArray();
                            $c_amt = $this->db->query($c_sql)->getRowArray();
                            $debitamt  = $d_amt['amount'];
                            $creditamt = $c_amt['amount'];
                            $clbal = ( $op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if($clbal < 0) $tab_credit = abs($clbal);
							else $tab_debit = $clbal;
							if(!empty($tab_debit) || !empty($tab_credit))
							{
                                $data[] = array(
                                            "ledgercode"=>$ledgercode,
                                            "ledgername"=>$ledgername,
                                            "debitamt"=>number_format($tab_debit, '2','.',''),
                                            "creditamt"=>number_format($tab_credit, '2','.','')
                                        );
                            }
                            $totalopb += $op_balance_amt;
                            $totaldeb += $tab_debit;
                            $totalcre += $tab_credit;
                            $totalclb += $clbal;
                        }
                    }
                }
            }
			$res = $this->db->table('ledgers')->where('group_id', $row['id'])->get()->getResultArray();
			if(count($res) > 0){
				foreach($res as $dd){
					    $id = $dd['id'];
                        $ledgername = get_ledger_name_only($id);
                        $ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt= 0;
						$op_balance_amt= 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$id)->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
						if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
						{
							$op_balance_amt -= $op_balance['cr_amount'];
						}
						else
						{
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$op_bal = $op_balance_amt;
						$d_sql = "select sum(entryitems.amount) as amount 
										from entryitems 
										inner join entries on entries.id = entryitems. entry_id
										where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$c_sql = "select sum(entryitems.amount) as amount 
												from entryitems 
												inner join entries on entries.id = entryitems. entry_id
												where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date >= '$sdate' and entries.date <= '$tdate'";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt  = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ( $op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if($clbal < 0) $tab_credit = abs($clbal);
						else $tab_debit = $clbal;
						if(!empty($tab_debit) || !empty($tab_credit))
						{
							$data[] = array(
                                    "ledgercode"=>$ledgercode,
                                    "ledgername"=>$ledgername,
                                    "debitamt"=>number_format($tab_debit, '2','.',''),
                                    "creditamt"=>number_format($tab_credit, '2','.','')
                                );
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
				}
			}
			//print_r($res);
		}//die;
        $datas = array(
                        "Total"=>"Total",
                        "totaldeb"=>number_format($totaldeb, '2','.',''),
                        "totalcre"=>number_format($totalcre, '2','.','')
                    );
        $fileName = "trial_balance_".$sdate."_to_".$tdate;  
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->getStyle('A2:D2')->getFont()->setBold(true);
        $sheet->getStyle("A1:D1")->applyFromArray($style);
        $sheet->mergeCells('A1:D1'); 
        $sheet->setCellValue('A1', "SREE SELVA VINAYAGAR TEMPLE");
        $sheet->setCellValue('A2', 'A/C No');
        $sheet->setCellValue('B2', 'Description');
        $sheet->setCellValue('C2', 'Debit');
        $sheet->setCellValue('D2', 'Credit');  
        $rows = 3;
        foreach ($data as $val)
        {
            $sheet->setCellValue('A' . $rows, $val['ledgercode']);
            $sheet->setCellValue('B' . $rows, $val['ledgername']);
            $sheet->setCellValue('C' . $rows, $val['debitamt']);
            $sheet->setCellValue('D' . $rows, $val['creditamt']);
            $rows++;
        }
        $sheet->setCellValue('A' . $rows, "");
        $sheet->setCellValue('B' . $rows, "Total");
        $sheet->setCellValue('C' . $rows, $datas['totaldeb']);
        $sheet->setCellValue('D' . $rows, $datas['totalcre']);
        $writer = new Xlsx($spreadsheet);
        $writer->save('uploads/excel/'.$fileName.'.xlsx');
        return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');

	}
	public function print_profit_loss(){
        if(!$this->model->permission_validate('profit_and_loss_accounts','print')){
			header('Location: '.base_url().'/dashboard');
		}
		if($_POST['fdate']) $sdate = $_POST['fdate']; 
        else $sdate = date('Y-m-01');
        if($_POST['tdate']) $edate = $_POST['tdate'];
        else $edate = date('Y-m-d');
        //echo $edate; //die;
        $table = array();
        $data = array();
        $datas = array();
        $total_income = 0; $total_expenses = 0;
        // Income List
        $id = [27, 28, 29];  // direct income, indirect income and sales account group id
        /* $res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray(); */
		$res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
        $subincome_array = array();
        foreach($res as $row){
            $subincome_array[$row['name']] = $row['id'];
        }
        $main_incomes['Income'] = "26";
        $income_array = array_merge($main_incomes,$subincome_array);
        foreach($income_array as $key => $row){
            $led_list = $this->db->table("ledgers")->where('group_id', $row)->get()->getResultArray();
            foreach($led_list as $led){
                $led_bd = $this->db->table('entryitems', 'entries')
                            ->join('entries', 'entries.id = entryitems.entry_id')
                            ->where('entryitems.ledger_id', $led['id'])
                            ->where('entries.date >=', $sdate)
                            ->where('entries.date <=', $edate);
                $led_res = $led_bd->select('entryitems.*')
                            ->select('entries.date')
                            ->get()
                            ->getResultArray();
                $total_dr = 0; $total_cr = 0;
                foreach($led_res as $dr){
                    if(is_numeric($dr['amount']) == true){
                        if(!empty($dr['amount'])) $amount = $dr['amount'];
                        else $amount = 0;

                        if($dr['dc'] == 'D') $total_dr += $amount;
                        if($dr['dc'] == 'C') $total_cr += $amount;
                    }
                }
               $fin_amt = $total_cr - $total_dr;
               $led_name = $led['id'];
               $data['Income'][$key][] = array(
                                                    "$led_name" => $fin_amt
                                                );
            }
       }
        if(count($data)){
            foreach($data as $key => $val){    
                $table[] = '<tr><td style="font-weight: bold;font-size: medium;">'.$key.'</td><td></td><tr>';
                foreach($val as $sub_key => $sub_val){
                    if($sub_key != "Income"){
                        $sub_total_income = get_profit_loss_subtotal($sub_val);
                        if($sub_total_income > 0){
                            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td><td></td><tr>';
                        }
                    }
                    foreach($sub_val as $skey => $sval){
                        foreach($sval as $name => $amt){
                            if(!empty($amt)){
                                $ledgername = get_ledger_name_only($name);
                                $ledgercode = get_ledger_code_only($name);
                                $table[] .= '<tr><td>&emsp;&emsp;&emsp;('. $ledgercode . ')' . $ledgername.'</td><td align="right">'.number_format($amt, "2",".",",").'</td><tr>';
                            }
                            $total_income += $amt;
                        }
                    }
                }
            }
        }
        else{
            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Income</td><td></td><tr>';
        }
       $table[] .= '<tr><td>Total Income</td><td align="right"  style="border-top:1px solid black;">'.number_format($total_income, "2",".",",").'</td><tr>';

       // Expenses 
       // Direct expenses in staff  id 38
        $id = [31,45];
       /* $res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray(); */
	    $res = $this->db->table('groups')->where('parent_id', 30)->get()->getResultArray();
        $subexpense_array = array();
        foreach($res as $row){
            $subexpense_array[$row['name']] = $row['id'];
        }
        $main_expenses['Expenses'] = "30";
        $expense_array = array_merge($main_expenses,$subexpense_array);
        //echo '<pre>'; print_r($res);die;
        foreach($expense_array as $key => $row){
            $led_list = $this->db->table("ledgers")->where('group_id', $row)->get()->getResultArray();
            foreach($led_list as $led){
				$led_bd = $this->db->table('entryitems', 'entries')
                            ->join('entries', 'entries.id = entryitems.entry_id')
                            ->where('entryitems.ledger_id', $led['id'])
                            ->where('entries.date >=', $sdate)
                            ->where('entries.date <=', $edate);
                $led_res = $led_bd->select('entryitems.*')
                            ->select('entries.date')
                            ->get()
                            ->getResultArray();
                $total_dr = 0; $total_cr = 0;
                foreach($led_res as $dr){
                    if(is_numeric($dr['amount']) == true){
                        if(!empty($dr['amount'])) $amount = $dr['amount'];
                        else $amount = 0;

                        if($dr['dc'] == 'D') $total_dr += $amount;
                        if($dr['dc'] == 'C') $total_cr += $amount;
                    }
                }
               $fin_amt = $total_dr - $total_cr;
               $led_name = $led['id'];
               $datas['Expenses'][$key][] = array(
                                                    "$led_name" => $fin_amt
                                                );
            }
       }
       if(count($datas)){
            foreach($datas as $key => $val){    
                $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">'.$key.'</td><td></td><tr>';
                foreach($val as $sub_key => $sub_val){
                    if($sub_key != "Expenses"){
                        $sub_total_expenses = get_profit_loss_subtotal($sub_val);
                        if($sub_total_expenses > 0){
                            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td><td></td><tr>';
                        }
                    }
                    foreach($sub_val as $skey => $sval){
                        foreach($sval as $name => $amt){
                            if(!empty($amt)){
                                $ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
                                $table[] .= '<tr><td>&emsp;&emsp;&emsp;('. $ledgercode . ')' . $ledgername.'</td><td align="right" >'.number_format($amt, "2",".",",").'</td><tr>';
                            }
                            $total_expenses += $amt;
                        }
                    }
                }
            }
        }else{
            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Expenses</td><td></td><tr>';
            $table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;Direct Expenses</td><td></td><tr>';
        }
        $table[] .= '<tr><td>Total Expenses</td><td align="right" style="border-top:1px solid black;">'.number_format($total_expenses, "2",".",",").'</td><tr>'; 
        
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $profit = $total_income - $total_expenses;
        if($profit >= 0) $data['profit'] = 'Total Profit Amount is '.number_format($profit, '2','.',',');
        else{ $neg = $profit * -1; $data['profit'] = 'Total Loss Amount is '.number_format($neg , '2','.',','); }
        $data['table'] = $table;
		echo view('account/print_profit_loss', $data);
    }
	public function ledgers_name_list(){
		
		if(!$this->model->permission_validate('ledgers_name_list_accounts', 'print')){
			header('Location: '.base_url().'/dashboard');
		}
		
		$id = 3;
			
		$data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
		
			echo view('account_report/ledgers_name_list', $data);
		
	 }
	 public function account_group_list(){
		
		if(!$this->model->permission_validate('account_group_list_accounts', 'print')){
			header('Location: '.base_url().'/dashboard');
		}
		
		$id = 3;
			
		$data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
		
			echo view('account_report/account_group_list', $data);
		
	 }
	 public function manually_yearendclose()
	{
		$total_income_amount_bf_cr = 0;
		$total_income_amount_bf_dr = 0;
		$sdate = "2023-04-01";
		$tdate = "2024-03-31";
		$datas_income = array();
		$group = $this->db->table("groups")->get()->getResultArray();
		foreach($group as $row){
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
			if(count($res) >0){
				foreach($res as $dd){
					$led_id = $dd['id'];
					$op_bal = !empty($dd['op_balance']) ? $dd['op_balance'] : 0;
					$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$debitamt_tot = $debitamt['amount'];
					$creditamt_tot = $creditamt['amount'];
					if($debitamt_tot > $creditamt_tot)
					{
						$datas_income[$led_id]['DR'][] = ($debitamt_tot + $op_bal) - $creditamt_tot;
					}
					else
					{
						$datas_income[$led_id]['CR'][] = ($creditamt_tot - $op_bal) - $debitamt_tot;
					}
				}
			}
		}
		//print_r($datas_income);
		foreach($datas_income as $key=> $row2)
		{
			if(!empty($row2["CR"]))
			{
				$ac_lb_data['dr_amount'] = "0.00";
				$ac_lb_data['cr_amount'] = abs($row2["CR"][0]);
			}
			if(!empty($row2["DR"]))
			{
				$ac_lb_data['dr_amount'] = abs($row2["DR"][0]);
				$ac_lb_data['cr_amount'] = "0.00";
			}
			$ac_lb_data['ac_year_id'] = 1;
			$ac_lb_data['ledger_id'] = $key;
			$this->db->table('ac_year_ledger_balance')->insert($ac_lb_data);
			//var_dump($ac_lb_data);
			//echo "<br>";
		}
	}

}