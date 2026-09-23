<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;
use Dompdf\Dompdf;
use Dompdf\Options;
class Accountreportcopy extends BaseController
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

	public function ledger_report()
	{
		if (!$this->model->list_validate('ledger_report_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ledger_report_accounts');

		$id = $this->request->uri->getSegment(3);
		if (!empty($id))
			$ledger_id = $id;
		else if ($_POST['ledger'])
			$ledger_id = $_POST['ledger'];
		else
			$ledger_id = 1;
		//var_dump($ledger_id);
		//exit;
		if ($_POST['fdate'])
			$fdate = $_POST['fdate'];
		else
			$fdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		$led_res = $this->ledger_statement($ledger_id, $fdate, $tdate);
		$group = $this->db->table("groups")->get()->getResultArray();

		foreach ($group as $row) {
			$ledger[] = '<optgroup label="' . $row['name'] . '">';
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
			foreach ($res as $r) {
				$id = $r['id'];
				$ledgername = $r['left_code'] . '/' . $r['right_code'] . '-' . $r['name'];
				if ($ledger_id == $id)
					$selected = 'selected';
				else
					$selected = '';
				$ledger[] .= '<option ' . $selected . ' value="' . $id . '">' . $ledgername . '</option>';
			}
			$ledger[] .= '</optgroup>';
		}
		$data['ledger_id'] = $ledger_id;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['res'] = $led_res;
		$data['ledger'] = $ledger;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/ledger_report', $data);
		echo view('template/footer');
	}
	public function new_ledger_report()
	{
		if (!$this->model->list_validate('ledger_report_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ledger_report_accounts');

		if (!empty($_POST['ledger']))
			$ledger_id = $_POST['ledger'];
		else
			$ledger_id = array(1);

		if ($_POST['fdate'])
			$fdate = $_POST['fdate'];
		else
			$fdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		$group = $this->db->table("groups")->get()->getResultArray();

		foreach ($group as $row) {
			$ledger[] = '<optgroup label="' . $row['name'] . '">';
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
			foreach ($res as $r) {
				$id = $r['id'];
				$ledgername = $r['left_code'] . '/' . $r['right_code'] . '-' . $r['name'];
				if (in_array($id, $ledger_id))
					$selected = 'selected';
				else
					$selected = '';
				$ledger[] .= '<option value="' . $id . '" ' . $selected . '>' . $ledgername . '</option>';
			}
			$ledger[] .= '</optgroup>';
		}
		$data['ledger_id'] = $ledger_id;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$data['ledger'] = $ledger;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/new_ledger_report', $data);
		echo view('template/footer');
	}
	public function print_multiple_ledger_statement()
	{
		$ledger_id = $_POST['ledger'];
		$fdate = $_POST['fdate'];
		$tdate = $_POST['tdate'];
		//$led_res = $this->ledger_statement($ledger_id, $fdate, $tdate);
		//$data = $led_res;
		$data['ledger_id'] = $ledger_id;
		$data['fdate'] = $fdate;
		$data['tdate'] = $tdate;
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		echo view('account_report/multiple_ledger_statement', $data);
	}
	public function trail_balance()
	{
		if (!$this->model->list_validate('trial_balance_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		//echo $sdate; echo $tdate;die;
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
		$parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach ($parentgroup as $row) {
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
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
						$op_balance_amt = $op_balance['cr_amount'];
					} else {
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
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					if (!empty($debitamt) || !empty($creditamt)) {
						$datas[] = '<tr>
                                    <td>' . $ledgercode . '</td>
                                    <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a>
                                    </td>
                                    <td align="right">' . number_format($debitamt, '2', '.', ',') . '</td>
                                    <td align="right">' . number_format($creditamt, '2', '.', ',') . '</td>
                                </tr>';
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $debitamt;
					$totalcre += $creditamt;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$crow['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt = $op_balance['cr_amount'];
						} else {
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
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						if (!empty($debitamt) || !empty($creditamt)) {
							$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($debitamt, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($creditamt, '2', '.', ',') . '</td>
                                        </tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $debitamt;
						$totalcre += $creditamt;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
						/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$ccg['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt = $op_balance['cr_amount'];
							} else {
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
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							if (!empty($debitamt) || !empty($creditamt)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($debitamt, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($creditamt, '2', '.', ',') . '</td>
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
					<td align="right">' . number_format($totaldeb, '2', '.', '') . '</td>
					<td align="right">' . number_format($totalcre, '2', '.', '') . '</td>
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

	public function balance_sheet()
	{
		if (!$this->model->list_validate('balance_sheet_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('balance_sheet_accounts');

		echo view('template/header');
		echo view('template/sidebar');
		//echo view('account/index', $data);
		echo view('template/footer');
	}
	public function getGroupSales($groupId, $fromDate, $toDate)
	{
		$sql = "SELECT ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, 
					   g.name as group_name, COALESCE(SUM(IF(ei.dc = 'C', amount, 0)), 0) as cr_total, 
					   COALESCE(SUM(IF(ei.dc = 'D', amount, 0)), 0) as dr_total 
				FROM ledgers l 
				LEFT JOIN groups g ON g.id = l.group_id 
				LEFT JOIN entryitems ei ON ei.ledger_id = l.id 
				LEFT JOIN entries e ON e.id = ei.entry_id 
				WHERE g.id = $groupId AND e.date BETWEEN '$fromDate' AND '$toDate' 
				GROUP BY ei.ledger_id 
				ORDER BY l.left_code, l.right_code ASC";
		return $this->db->query($sql)->getResultArray();
	}

	// Define a function to render the HTML table rows
	public function renderTableRows($groups, $classLevel)
	{
		$rows = array();
		foreach ($groups as $group) {
			$total = $group['cr_total'] - $group['dr_total'];
			$ledgerCode = $group['left_code'] . '/' . $group['right_code'];
			$totalAmount = ($total < 0) ? "( " . number_format(abs($total), 2) . " )" : number_format($total, 2);

			$html = '<tr><td class="' . $classLevel . '">(' . $ledgerCode . ')' . $group['ledger_name'] . '</td>';
			$html .= '<td align="right">' . $totalAmount . '</td></tr>';
			$rows[] = $html;
		}
		return $rows;
	}

	public function profile_loss_new()
	{
		if (!$this->model->list_validate('profit_and_loss_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('profit_and_loss_accounts');
		//var_dump($_POST);
		// exit;

		if ($_POST['sdate'])
			$sdate = $_POST['sdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['edate'])
			$edate = $_POST['edate'];
		else
			$edate = date('Y-m-d');

		if (!empty($_POST['smonthdate']))
			$smonthdate = $_POST['smonthdate'] . "-01";
		else
			$smonthdate = date('Y-m-01');

		if (!empty($_POST['emonthdate'])) {
			$datecount = cal_gregorian($_POST['emonthdate']);
			$emonthdate = $_POST['emonthdate'] . "-" . $datecount;
		} else {
			$datecount = cal_gregorian($_POST['emonthdate']);
			$emonthdate = date('Y-m') . "-" . $datecount;
		}
		$breakdown = $_POST['breakdown'];
		if ($breakdown == "monthly") {
			$getMonthsInRange = getMonthsInRange($smonthdate, $emonthdate);
			$bd_colspan = getMonthsInCount($smonthdate, $emonthdate);
			$from_date = $smonthdate;
			$to_date = $emonthdate;
		} else {
			$getMonthsInRange = array();
			$bd_colspan = 1;
			$from_date = $sdate;
			$to_date = $edate;
		}
		$fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : '');
		//echo $job_code; //die;
		$table = array();
		$data = array();
		$datas = array();
		$total_income = 0;
		$total_expenses = 0;
		// Income List
		$id = [27, 28, 29];  // direct income, indirect income and sales account group id
		//$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
		$res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
		$subincome_array = array();
		foreach ($res as $row) {
			$subincome_array[$row['name']] = $row['id'];
		}
		$main_incomes['Income'] = "26";
		$income_array = array_merge($main_incomes, $subincome_array);
		//var_dump($income_array);
		//exit;
		if ($breakdown == "monthly") {
		} else {

			// Sales //

			$topGroupId = $this->db->table("groups")->where('code', 4000)->get()->getRowArray()['id'];
			// Get sales data for groups
			$salesGroups = $this->getGroupSales($topGroupId, $from_date, $to_date);
			$table = $this->renderTableRows($salesGroups, 'level_ledger');

		}
		// print_r($sales_grops);
		// die;


		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['smonthdate'] = $smonthdate;
		$data['emonthdate'] = $emonthdate;
		$data['breakdown'] = !empty($breakdown) ? $breakdown : 'daily';
		$data['getMonthsInRange'] = $getMonthsInRange;
		$data['bd_colspan'] = $bd_colspan;

		$data['fund_id'] = $fund_id;
		$profit = $total_income - $total_expenses;
		if ($profit >= 0)
			$data['profit'] = 'Total Profit Amount is ' . number_format($profit, '2', '.', ',');
		else {
			$neg = $profit * -1;
			$data['profit'] = 'Total Loss Amount is ' . number_format($neg, '2', '.', ',');
		}
		$data['table'] = $table;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/profitloss', $data);
		echo view('template/footer');
	}

	public function profile_loss()
	{
		if (!$this->model->list_validate('profit_and_loss_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('profit_and_loss_accounts');
		//var_dump($_POST);
		// exit;

		if ($_POST['sdate'])
			$sdate = $_POST['sdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['edate'])
			$edate = $_POST['edate'];
		else
			$edate = date('Y-m-d');

		if (!empty($_POST['smonthdate']))
			$smonthdate = $_POST['smonthdate'] . "-01";
		else
			$smonthdate = date('Y-m-01');

		if (!empty($_POST['emonthdate'])) {
			$datecount = cal_gregorian($_POST['emonthdate']);
			$emonthdate = $_POST['emonthdate'] . "-" . $datecount;
		} else {
			$datecount = cal_gregorian($_POST['emonthdate']);
			$emonthdate = date('Y-m') . "-" . $datecount;
		}
		$breakdown = $_POST['breakdown'];
		$fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : '');
		//echo $job_code; //die;
		$table = array();
		$data = array();
		$datas = array();
		$total_income = 0;
		$total_expenses = 0;
		// Income List
		$id = [27, 28, 29];  // direct income, indirect income and sales account group id
		//$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
		$res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
		$subincome_array = array();
		foreach ($res as $row) {
			$subincome_array[$row['name']] = $row['id'];
		}
		$main_incomes['Income'] = "26";
		$income_array = array_merge($main_incomes, $subincome_array);
		//var_dump($income_array);
		//exit;
		$whr = '';
		if (!empty($fund_id))
			$whr = " and e.fund_id=$fund_id";
		$profit = 0;
		if ($breakdown == "monthly") {

			$getMonthsInRange = getMonthsInRange($smonthdate, $emonthdate);
			$bd_colspan = getMonthsInCount($smonthdate, $emonthdate);
			$from_date = $smonthdate;
			$to_date = $emonthdate;

			// Sales //

			$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
			$sales_ledgers = $this->db->table("ledgers")->where('group_id', $top_sales_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_sales_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($sales_ledgers) > 0) {
				foreach ($sales_ledgers as $sales_ledger) {
					$html = '<tr>';
					$ledgercode = $sales_ledger['left_code'] . '/' . $sales_ledger['right_code'];
					$ledgername = $sales_ledger['name'];
					$ledger_id = $sales_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$sales_sub_groups = $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($sales_sub_groups) > 0) {
				foreach ($sales_sub_groups as $sales_sub_group) {
					$sales_sub_ledgers = $this->db->table("ledgers")->where('group_id', $sales_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($sales_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($sales_sub_ledgers as $sales_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $sales_sub_ledger['left_code'] . '/' . $sales_sub_ledger['right_code'];
							$ledgername = $sales_sub_ledger['name'];
							$sub_ledger_id = $sales_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $sales_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$sales_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sales_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($sales_sub_sub_groups) > 0) {
							foreach ($sales_sub_sub_groups as $sales_sub_sub_group) {
								$sales_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $sales_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($sales_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($sales_sub_sub_ledgers as $sales_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $sales_sub_sub_ledger['left_code'] . '/' . $sales_sub_sub_ledger['right_code'];
										$ledgername = $sales_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $sales_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $sales_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $sales_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $sales_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_sales_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$sales_total = $ledger_total;

			// Cost of Sales //

			$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
			$co_sales_ledgers = $this->db->table("ledgers")->where('group_id', $top_co_sales_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_co_sales_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$co_sales_total = 0;
			$ledger_total = array();
			if (count($co_sales_ledgers) > 0) {
				foreach ($co_sales_ledgers as $co_sales_ledger) {
					$html = '<tr>';
					$ledgercode = $co_sales_ledger['left_code'] . '/' . $co_sales_ledger['right_code'];
					$ledgername = $co_sales_ledger['name'];
					$ledger_id = $co_sales_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($month_total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$co_sales_sub_groups = $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($co_sales_sub_groups) > 0) {
				foreach ($co_sales_sub_groups as $co_sales_sub_group) {
					$co_sales_sub_ledgers = $this->db->table("ledgers")->where('group_id', $co_sales_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($co_sales_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($co_sales_sub_ledgers as $co_sales_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $co_sales_sub_ledger['left_code'] . '/' . $co_sales_sub_ledger['right_code'];
							$ledgername = $co_sales_sub_ledger['name'];
							$sub_ledger_id = $co_sales_sub_ledger['id'];
							$sub_html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $co_sales_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$co_sales_sub_sub_groups = $this->db->table("groups")->where('parent_id', $co_sales_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($co_sales_sub_sub_groups) > 0) {
							foreach ($co_sales_sub_sub_groups as $co_sales_sub_sub_group) {
								$co_sales_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $co_sales_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($co_sales_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($co_sales_sub_sub_ledgers as $co_sales_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $co_sales_sub_sub_ledger['left_code'] . '/' . $co_sales_sub_sub_ledger['right_code'];
										$ledgername = $co_sales_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $co_sales_sub_sub_ledger['id'];
										$sub_html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $co_sales_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $co_sales_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right"  class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $co_sales_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_co_sales_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$cost_sales_total = $ledger_total;


			// Gross Profit //

			$gross_profit_total = array();
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Gross Surplus/Deficit</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $sales_total[$res_month['date']] - $cost_sales_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$html .= '<td align="right" class="bold_text">' . $cur_total_amount . '</td>';
					$month_total += $cur_total;
					$gross_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';

			// Incomes //

			$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
			$incomes_ledgers = $this->db->table("ledgers")->where('group_id', $top_incomes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_incomes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$incomes_total = 0;
			$ledger_total = array();
			if (count($incomes_ledgers) > 0) {
				foreach ($incomes_ledgers as $incomes_ledger) {
					$html = '<tr>';
					$ledgercode = $incomes_ledger['left_code'] . '/' . $incomes_ledger['right_code'];
					$ledgername = $incomes_ledger['name'];
					$ledger_id = $incomes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($month_total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$incomes_sub_groups = $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($incomes_sub_groups) > 0) {
				foreach ($incomes_sub_groups as $incomes_sub_group) {
					$incomes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $incomes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($incomes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($incomes_sub_ledgers as $incomes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $incomes_sub_ledger['left_code'] . '/' . $incomes_sub_ledger['right_code'];
							$ledgername = $incomes_sub_ledger['name'];
							$sub_ledger_id = $incomes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $incomes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$incomes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $incomes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($incomes_sub_sub_groups) > 0) {
							foreach ($incomes_sub_sub_groups as $incomes_sub_sub_group) {
								$incomes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $incomes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($incomes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($incomes_sub_sub_ledgers as $incomes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $incomes_sub_sub_ledger['left_code'] . '/' . $incomes_sub_sub_ledger['right_code'];
										$ledgername = $incomes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $incomes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $incomes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $incomes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $incomes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_incomes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$incomes_total = $ledger_total;


			// Expenses //

			$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
			$expenes_ledgers = $this->db->table("ledgers")->where('group_id', $top_expenes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_expenes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($expenes_ledgers) > 0) {
				foreach ($expenes_ledgers as $expenes_ledger) {
					$html = '<tr>';
					$ledgercode = $expenes_ledger['left_code'] . '/' . $expenes_ledger['right_code'];
					$ledgername = $expenes_ledger['name'];
					$ledger_id = $expenes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$expenes_sub_groups = $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($expenes_sub_groups) > 0) {
				foreach ($expenes_sub_groups as $expenes_sub_group) {
					$expenes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $expenes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($expenes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($expenes_sub_ledgers as $expenes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $expenes_sub_ledger['left_code'] . '/' . $expenes_sub_ledger['right_code'];
							$ledgername = $expenes_sub_ledger['name'];
							$sub_ledger_id = $expenes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $expenes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$expenes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $expenes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($expenes_sub_sub_groups) > 0) {
							foreach ($expenes_sub_sub_groups as $expenes_sub_sub_group) {
								$expenes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $expenes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($expenes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($expenes_sub_sub_ledgers as $expenes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $expenes_sub_sub_ledger['left_code'] . '/' . $expenes_sub_sub_ledger['right_code'];
										$ledgername = $expenes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $expenes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $expenes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $expenes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $expenes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_expenes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$expenes_total = $ledger_total;

			// Net Profit //

			$net_profit_total = array();
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Surplus/(Deficit) Before Taxation</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $gross_profit_total[$res_month['date']] + $incomes_total[$res_month['date']] - $expenes_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$html .= '<td align="right" class="bold_text">' . $cur_total_amount . '</td>';
					$month_total += $cur_total;
					$net_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';


			// Taxation //

			$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
			$taxes_ledgers = $this->db->table("ledgers")->where('group_id', $top_taxes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_taxes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($taxes_ledgers) > 0) {
				foreach ($taxes_ledgers as $taxes_ledger) {
					$html = '<tr>';
					$ledgercode = $taxes_ledger['left_code'] . '/' . $taxes_ledger['right_code'];
					$ledgername = $taxes_ledger['name'];
					$ledger_id = $taxes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$taxes_sub_groups = $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($taxes_sub_groups) > 0) {
				foreach ($taxes_sub_groups as $taxes_sub_group) {
					$taxes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $taxes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($taxes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($taxes_sub_ledgers as $taxes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $taxes_sub_ledger['left_code'] . '/' . $taxes_sub_ledger['right_code'];
							$ledgername = $taxes_sub_ledger['name'];
							$sub_ledger_id = $taxes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $taxes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$taxes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $taxes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($taxes_sub_sub_groups) > 0) {
							foreach ($taxes_sub_sub_groups as $taxes_sub_sub_group) {
								$taxes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $taxes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($taxes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($taxes_sub_sub_ledgers as $taxes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $taxes_sub_sub_ledger['left_code'] . '/' . $taxes_sub_sub_ledger['right_code'];
										$ledgername = $taxes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $taxes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $taxes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $taxes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $taxes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_taxes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$taxes_total = $ledger_total;


			// Total Profit //

			$final_profit_total = array();
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $net_profit_total[$res_month['date']] - $taxes_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$month_total += $cur_total;
					$final_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
			}
			if (count($final_profit_total) > 0) {
				$month_total = 0;
				foreach ($final_profit_total as $fpt) {
					$profit += $fpt;
				}
			}
			$html = '';


		} else {

			$getMonthsInRange = array();
			$bd_colspan = 1;
			$from_date = $sdate;
			$to_date = $edate;

			// Sales //

			$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
			$sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_sales_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_sales_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_sales_group['name'] . '</td><td></td></tr>';
			if (count($sales_groups) > 0) {
				foreach ($sales_groups as $sales_group) {
					$group_id = $sales_group['group_id'];
					$total = $sales_group['cr_total'] - $sales_group['dr_total'];
					$top_sales_group_total += $total;
					$ledgercode = $sales_group['left_code'] . '/' . $sales_group['right_code'];
					$ledgername = $sales_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($sales_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$sales_sub_groups_total = 0;
						foreach ($sales_sub_groups as $sales_sub_group) {
							$total = $sales_sub_group['cr_total'] - $sales_sub_group['dr_total'];
							$sales_sub_groups_total += $total;
							$ledgercode = $sales_sub_group['left_code'] . '/' . $sales_sub_group['right_code'];
							$ledgername = $sales_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($sales_sub_groups_total < 0)
							$sales_sub_groups_total_amount = "( " . number_format(abs($sales_sub_groups_total), 2) . " )";
						else
							$sales_sub_groups_total_amount = number_format($sales_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $sales_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $sales_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($sales_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$sales_sub_sub_groups_total = 0;
								foreach ($sales_sub_sub_groups as $sales_sub_sub_group) {
									$total = $sales_sub_sub_group['cr_total'] - $sales_sub_sub_group['dr_total'];
									$sales_sub_sub_groups_total += $total;
									$ledgercode = $sales_sub_sub_group['left_code'] . '/' . $sales_sub_sub_group['right_code'];
									$ledgername = $sales_sub_sub_group['ledger_name'];
									if ($sales_sub_sub_groups_total < 0)
										$sales_sub_sub_groups_total_amount = "( " . number_format(abs($sales_sub_sub_groups_total), 2) . " )";
									else
										$sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($sales_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($sales_sub_sub_groups_total < 0)
									$sales_sub_sub_groups_total_amount = "( " . number_format(abs($sales_sub_sub_groups_total), 2) . " )";
								else
									$sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $sales_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $sales_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_sales_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_sales_group_total_amount = "( " . number_format(abs($top_sales_group_total), 2) . " )";
			else
				$top_sales_group_total_amount = number_format($top_sales_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_sales_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_sales_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Cost of Sales //

			$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
			$co_sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_co_sales_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_co_sales_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_co_sales_group['name'] . '</td><td></td></tr>';
			if (count($co_sales_groups) > 0) {
				foreach ($co_sales_groups as $co_sales_group) {
					$group_id = $co_sales_group['group_id'];
					$total = $co_sales_group['dr_total'] - $co_sales_group['cr_total'];
					$top_co_sales_group_total += $total;
					$ledgercode = $co_sales_group['left_code'] . '/' . $co_sales_group['right_code'];
					$ledgername = $co_sales_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$co_sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($co_sales_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$co_sales_sub_groups_total = 0;
						foreach ($co_sales_sub_groups as $co_sales_sub_group) {
							$total = $co_sales_sub_group['dr_total'] - $co_sales_sub_group['cr_total'];
							$co_sales_sub_groups_total += $total;
							$ledgercode = $co_sales_sub_group['left_code'] . '/' . $co_sales_sub_group['right_code'];
							$ledgername = $co_sales_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($co_sales_sub_groups_total < 0)
							$co_sales_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_groups_total), 2) . " )";
						else
							$co_sales_sub_groups_total_amount = number_format($co_sales_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $co_sales_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $co_sales_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$co_sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($co_sales_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$co_sales_sub_sub_groups_total = 0;
								foreach ($co_sales_sub_sub_groups as $co_sales_sub_sub_group) {
									$total = $co_sales_sub_sub_group['dr_total'] - $co_sales_sub_sub_group['cr_total'];
									$co_sales_sub_sub_groups_total += $total;
									$ledgercode = $co_sales_sub_sub_group['left_code'] . '/' . $co_sales_sub_sub_group['right_code'];
									$ledgername = $co_sales_sub_sub_group['ledger_name'];
									if ($co_sales_sub_sub_groups_total < 0)
										$co_sales_sub_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_sub_groups_total), 2) . " )";
									else
										$co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($co_sales_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($co_sales_sub_sub_groups_total < 0)
									$co_sales_sub_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_sub_groups_total), 2) . " )";
								else
									$co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $co_sales_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $co_sales_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_co_sales_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_co_sales_group_total_amount = "( " . number_format(abs($top_co_sales_group_total), 2) . " )";
			else
				$top_co_sales_group_total_amount = number_format($top_co_sales_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_co_sales_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_co_sales_group_total_amount . '</td>';
			$table[] .= '</tr>';
			$gross_profit = $top_sales_group_total - $top_co_sales_group_total;

			if ($gross_profit < 0) {
				$gross_profit_amount = "( " . number_format(abs($gross_profit), 2) . " )";
				$gross_profit_txt = 'Gross Surplus';
			} else {
				$gross_profit_amount = number_format($gross_profit, 2);
				$gross_profit_txt = 'Gross (Deficit)';
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $gross_profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $gross_profit_amount . '</td>';
			$table[] .= '</tr>';

			// Incomes

			$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
			$incomes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_incomes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_incomes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_incomes_group['name'] . '</td><td></td></tr>';
			if (count($incomes_groups) > 0) {
				foreach ($incomes_groups as $incomes_group) {
					$group_id = $incomes_group['group_id'];
					$total = $incomes_group['cr_total'] - $incomes_group['dr_total'];
					$top_incomes_group_total += $total;
					$ledgercode = $incomes_group['left_code'] . '/' . $incomes_group['right_code'];
					$ledgername = $incomes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$incomes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($incomes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$incomes_sub_groups_total = 0;
						foreach ($incomes_sub_groups as $incomes_sub_group) {
							$total = $incomes_sub_group['cr_total'] - $incomes_sub_group['dr_total'];
							$incomes_sub_groups_total += $total;
							$ledgercode = $incomes_sub_group['left_code'] . '/' . $incomes_sub_group['right_code'];
							$ledgername = $incomes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($incomes_sub_groups_total < 0)
							$incomes_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_groups_total), 2) . " )";
						else
							$incomes_sub_groups_total_amount = number_format($incomes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $incomes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $incomes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$incomes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($incomes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$incomes_sub_sub_groups_total = 0;
								foreach ($incomes_sub_sub_groups as $incomes_sub_sub_group) {
									$total = $incomes_sub_sub_group['cr_total'] - $incomes_sub_sub_group['dr_total'];
									$incomes_sub_sub_groups_total += $total;
									$ledgercode = $incomes_sub_sub_group['left_code'] . '/' . $incomes_sub_sub_group['right_code'];
									$ledgername = $incomes_sub_sub_group['ledger_name'];
									if ($incomes_sub_sub_groups_total < 0)
										$incomes_sub_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_sub_groups_total), 2) . " )";
									else
										$incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($incomes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($incomes_sub_sub_groups_total < 0)
									$incomes_sub_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_sub_groups_total), 2) . " )";
								else
									$incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $incomes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $incomes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_incomes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_incomes_group_total_amount = "( " . number_format(abs($top_incomes_group_total), 2) . " )";
			else
				$top_incomes_group_total_amount = number_format($top_incomes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_incomes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_incomes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Expenses

			$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
			$expenes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_expenes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_expenes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_expenes_group['name'] . '</td><td></td></tr>';
			if (count($expenes_groups) > 0) {
				foreach ($expenes_groups as $expenes_group) {
					$group_id = $expenes_group['group_id'];
					$total = $expenes_group['dr_total'] - $expenes_group['cr_total'];
					$top_expenes_group_total += $total;
					$ledgercode = $expenes_group['left_code'] . '/' . $expenes_group['right_code'];
					$ledgername = $expenes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$expenes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($expenes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$expenes_sub_groups_total = 0;
						foreach ($expenes_sub_groups as $expenes_sub_group) {
							$total = $expenes_sub_group['dr_total'] - $expenes_sub_group['cr_total'];
							$expenes_sub_groups_total += $total;
							$ledgercode = $expenes_sub_group['left_code'] . '/' . $expenes_sub_group['right_code'];
							$ledgername = $expenes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($expenes_sub_groups_total < 0)
							$expenes_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_groups_total), 2) . " )";
						else
							$expenes_sub_groups_total_amount = number_format($expenes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $expenes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $expenes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$expenes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($expenes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$expenes_sub_sub_groups_total = 0;
								foreach ($expenes_sub_sub_groups as $expenes_sub_sub_group) {
									$total = $expenes_sub_sub_group['dr_total'] - $expenes_sub_sub_group['cr_total'];
									$expenes_sub_sub_groups_total += $total;
									$ledgercode = $expenes_sub_sub_group['left_code'] . '/' . $expenes_sub_sub_group['right_code'];
									$ledgername = $expenes_sub_sub_group['ledger_name'];
									if ($expenes_sub_sub_groups_total < 0)
										$expenes_sub_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_sub_groups_total), 2) . " )";
									else
										$expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($expenes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($expenes_sub_sub_groups_total < 0)
									$expenes_sub_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_sub_groups_total), 2) . " )";
								else
									$expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $expenes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $expenes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_expenes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_expenes_group_total_amount = "( " . number_format(abs($top_expenes_group_total), 2) . " )";
			else
				$top_expenes_group_total_amount = number_format($top_expenes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_expenes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_expenes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Net Profit

			$net_profit = $gross_profit + $top_incomes_group_total - $top_expenes_group_total;

			if ($net_profit < 0) {
				$net_profit_amount = "( " . number_format(abs($net_profit), 2) . " )";
				$net_profit_txt = "(Deficit) Before Taxation";
			} else {
				$net_profit_amount = number_format($net_profit, 2);
				$net_profit_txt = "Surplus Before Taxation";
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $net_profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $net_profit_amount . '</td>';
			$table[] .= '</tr>';

			// Taxation

			$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
			$taxes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_taxes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_taxes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_taxes_group['name'] . '</td><td></td></tr>';
			if (count($taxes_groups) > 0) {
				foreach ($taxes_groups as $taxes_group) {
					$group_id = $taxes_group['group_id'];
					$total = $taxes_group['dr_total'] - $taxes_group['cr_total'];
					$top_taxes_group_total += $total;
					$ledgercode = $taxes_group['left_code'] . '/' . $taxes_group['right_code'];
					$ledgername = $taxes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$taxes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($taxes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['group_name'] . '</td><td></td></tr>';
						$taxes_sub_groups_total = 0;
						foreach ($taxes_sub_groups as $taxes_sub_group) {
							$total = $taxes_sub_group['dr_total'] - $taxes_sub_group['cr_total'];
							$taxes_sub_groups_total += $total;
							$ledgercode = $taxes_sub_group['left_code'] . '/' . $taxes_sub_group['right_code'];
							$ledgername = $taxes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($taxes_sub_groups_total < 0)
							$taxes_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_groups_total), 2) . " )";
						else
							$taxes_sub_groups_total_amount = number_format($taxes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['group_name'] . '</td><td>' . $taxes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $taxes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$taxes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($taxes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['group_name'] . '</td><td></td></tr>';
								$taxes_sub_sub_groups_total = 0;
								foreach ($taxes_sub_sub_groups as $taxes_sub_sub_group) {
									$total = $taxes_sub_sub_group['dr_total'] - $taxes_sub_sub_group['cr_total'];
									$taxes_sub_sub_groups_total += $total;
									$ledgercode = $taxes_sub_sub_group['left_code'] . '/' . $taxes_sub_sub_group['right_code'];
									$ledgername = $taxes_sub_sub_group['ledger_name'];
									if ($taxes_sub_sub_groups_total < 0)
										$taxes_sub_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_sub_groups_total), 2) . " )";
									else
										$taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($taxes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($taxes_sub_sub_groups_total < 0)
									$taxes_sub_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_sub_groups_total), 2) . " )";
								else
									$taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['group_name'] . '</td><td>' . $taxes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $taxes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_taxes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_taxes_group_total_amount = "( " . number_format(abs($top_taxes_group_total), 2) . " )";
			else
				$top_taxes_group_total_amount = number_format($top_taxes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_taxes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_taxes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Total profit

			$profit = $net_profit - $top_taxes_group_total;
			if ($profit < 0) {
				$profit_amount = "( " . number_format(abs($profit), 2) . " )";
				$profit_txt = "(Deficit) After Taxation";
			} else {
				$profit_amount = number_format($profit, 2);
				$profit_txt = "Surplus After Taxation";
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $profit_amount . '</td>';
			$table[] .= '</tr>';
		}
		// print_r($sales_grops);
		// die;

		/* foreach($income_array as $key => $row){
			$led_list = $this->db->table("ledgers")->where('group_id', $row)->orderBy('left_code', 'ASC')->get()->getResultArray();
			if($breakdown == "monthly"){
				if(count($getMonthsInRange) > 0){
					foreach($getMonthsInRange as &$res_month){
						$ss_date = $res_month['date'] . '-01';
						$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
						foreach($led_list as $led){
							$led_bd = $this->db->table('entryitems', 'entries')
										->join('entries', 'entries.id = entryitems.entry_id')
										->where('entryitems.ledger_id', $led['id'])
										->where('entries.date >=', $ss_date)
										->where('entries.date <=', $ee_date);
							if(!empty($fund_id)) $led_bd = $led_bd->where('entries.fund_id', $fund_id);
							$led_res = $led_bd->select('entryitems.*')
										->select('entries.date')
										->get()
										->getResultArray();
							$total_dr = 0; $total_cr = 0;
							if(count($led_res) > 0){
								foreach($led_res as $dr){
									if(is_numeric($dr['amount']) == true){
										if(!empty($dr['amount'])) $amount = $dr['amount'];
										else $amount = 0;

										if($dr['dc'] == 'D') $total_dr += $amount;
										if($dr['dc'] == 'C') $total_cr += $amount;
									}
								}
							}
							$fin_amt = $total_cr - $total_dr;
							$led_name = $led['id'];
							$res_month['income_amount'][$led_name] = $fin_amt;
							if(empty($res_month['total_income_amount'])) $res_month['total_income_amount'] = 0;
							$res_month['total_income_amount'] += $fin_amt;
						}
					}
				}
			}
			foreach($led_list as $led){
				$led_bd = $this->db->table('entryitems', 'entries')
							->join('entries', 'entries.id = entryitems.entry_id')
							->where('entryitems.ledger_id', $led['id'])
							->where('entries.date >=', $from_date)
							->where('entries.date <=', $to_date);
				if(!empty($fund_id)) $led_bd = $led_bd->where('entries.fund_id', $fund_id);
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
				$table[] = '<tr>
								<td style="font-weight: bold;font-size: medium;">'.$key.'</td>';
								if($breakdown == "monthly"){
									foreach($getMonthsInRange as $ris_month){
										$table[].= '<td></td>';
									}
									$table[] .= '<td ></td>';
								}
								else{
									$table[] .= '<td ></td>';
								}
				$table[] .= '<tr>';
				foreach($val as $sub_key => $sub_val){
					if($sub_key != "Income"){
						$sub_total_income = get_profit_loss_subtotal($sub_val);
						if($sub_total_income > 0)
						{
							$table[] .= '<tr>
											<td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td>';
											if($breakdown == "monthly"){
												foreach($getMonthsInRange as $ras_month){
													$table[] .= '<td></td>';
												}
												$table[] .= '<td ></td>'; 
											}
											else{
												$table[] .= '<td ></td>';
											}
							$table[] .= '<tr>';
						}
					}
					foreach($sub_val as $skey => $sval){
						foreach($sval as $name => $amt){
							if(!empty($amt))
							{
								$ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
								$table[] .= '<tr>
												<td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' .$ledgername.'</td>';
												if($breakdown == "monthly"){
													foreach($getMonthsInRange as $rks_month){
														$table[] .= '<td>'.number_format($rks_month['income_amount'][$name], "2",".",",").'</td>';
													}
													$table[] .= '<td align="right" >'.number_format($amt, "2",".",",").'</td>'; // TOTAL AMOUNT
												}
												else{
													$table[] .= '<td align="right" >'.number_format($amt, "2",".",",").'</td>';
												}
								$table[] .= '</tr>';
							}
							$total_income += $amt;
						}
					}
				}
			}
		}
		else{
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Income</td><td colspan='.$bd_colspan.'></td><tr>';
		}
	   $table[] .= '<tr><td><strong>Total Income</strong></td>';
	   if($breakdown == "monthly"){
			foreach($getMonthsInRange as $rr_month){
				$table[] .= '<td align="left" style="font-weight:bold">'.number_format($rr_month['total_income_amount'], "2",".",",").'</td>';
			}
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_income, "2",".",",").'</td>';
		}
		else{
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_income, "2",".",",").'</td>';
		}
		$table[] .= '<tr>';

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
			if($breakdown == "monthly"){
				if(count($getMonthsInRange) > 0){
					foreach($getMonthsInRange as &$rss_month){
						$ss_date = $rss_month['date'] . '-01';
						$ee_date = date('Y-m-t', strtotime($rss_month['date'] . '-01'));
						foreach($led_list as $led){
							$led_bd1 = $this->db->table('entryitems', 'entries')
										->join('entries', 'entries.id = entryitems.entry_id')
										->where('entryitems.ledger_id', $led['id'])
										->where('entries.date >=', $ss_date)
										->where('entries.date <=', $ee_date);
							if(!empty($fund_id)) $led_bd1 = $led_bd1->where('entries.fund_id', $fund_id);
							$led_res1 = $led_bd1->select('entryitems.*')
										->select('entries.date')
										->get()
										->getResultArray();
							$total_dr = 0; $total_cr = 0;
							foreach($led_res1 as $dr){
								if(is_numeric($dr['amount']) == true){
									if(!empty($dr['amount'])) $amount = $dr['amount'];
									else $amount = 0;

									if($dr['dc'] == 'D') $total_dr += $amount;
									if($dr['dc'] == 'C') $total_cr += $amount;
								}
							}
						   $fin_amt = $total_dr - $total_cr;
						   $led_name = $led['id'];
						   $rss_month['expense_amount'][$led_name] = $fin_amt;
						   $rss_month['expense_query'][$led_name] = $this->db->getLastQuery();
						   if(empty($rss_month['total_expense_amount'])) $rss_month['total_expense_amount'] = 0;
						   $rss_month['total_expense_amount'] += $fin_amt;
						}
					}
				}
			}
			foreach($led_list as $led){
				$led_bd2 = $this->db->table('entryitems', 'entries')
							->join('entries', 'entries.id = entryitems.entry_id')
							->where('entryitems.ledger_id', $led['id'])
							->where('entries.date >=', $from_date)
							->where('entries.date <=', $to_date);
				if(!empty($fund_id)) $led_bd2 = $led_bd2->where('entries.fund_id', $fund_id);
				$led_res2 = $led_bd2->select('entryitems.*')
							->select('entries.date')
							->get()
							->getResultArray();
				$total_dr = 0; $total_cr = 0;
				foreach($led_res2 as $dr){
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
				$table[] .= '<tr>
								<td style="font-weight: bold;font-size: medium;">'.$key.'</td>';
								if($breakdown == "monthly"){
									foreach($getMonthsInRange as $rea_month){
										$table[] .= '<td></td>';
									}
									$table[] .= '<td ></td>';
								}
								else{
									$table[] .= '<td ></td>';
								}
				 $table[] .= '<tr>';
				foreach($val as $sub_key => $sub_val){
					if($sub_key != "Expenses"){
						$sub_total_expenses = get_profit_loss_subtotal($sub_val);
						if($sub_total_expenses > 0)
						{
							$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td>';
											if($breakdown == "monthly"){
												foreach($getMonthsInRange as $reb_month){
													$table[] .= '<td></td>';
												}
												$table[] .= '<td ></td>';
											}
											else{
												$table[] .= '<td ></td>';
											}
							$table[] .= '<tr>';
						}
					}
					foreach($sub_val as $skey => $sval){
						foreach($sval as $name => $amt){
							if(!empty($amt))
							{
								$ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
								$table[] .= '<tr>
												<td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' .$ledgername.'</td>';
												if($breakdown == "monthly"){
													foreach($getMonthsInRange as $rek_month){
													   $table[] .= '<td>'.number_format($rek_month['expense_amount'][$name], "2",".",",").'</td>';
													}
													$table[] .= '<td align="right">'.number_format($amt, "2",".",",").'</td>';
												}
												else{
													$table[] .= '<td align="right">'.number_format($amt, "2",".",",").'</td>';
												}
								$table[] .= '<tr>';
							}
							$total_expenses += $amt;
						}
					}
				}
			}
		}else{
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Expenses</td><td colspan='.$bd_colspan.'></td><tr>';
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;Direct Expenses</td><td colspan='.$bd_colspan.'></td><tr>';
		}
		$table[] .= '<tr><td><strong>Total Expenses</strong></td>';
		if($breakdown == "monthly"){
			foreach($getMonthsInRange as $red_month){
				$table[] .= '<td align="left"  style="font-weight:bold">'.number_format($red_month['total_expense_amount'], "2",".",",").'</td>';
			}
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_expenses, "2",".",",").'</td>';
		}
		else{
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_expenses, "2",".",",").'</td>';
		}
		$table[] .= '<tr>'; */

		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['smonthdate'] = $smonthdate;
		$data['emonthdate'] = $emonthdate;
		$data['breakdown'] = !empty($breakdown) ? $breakdown : 'daily';
		$data['getMonthsInRange'] = $getMonthsInRange;
		$data['bd_colspan'] = $bd_colspan;

		$data['fund_id'] = $fund_id;
		if ($profit >= 0)
			$data['profit'] = 'Total Profit Amount is ' . number_format($profit, '2', '.', ',');
		else {
			$neg = $profit * -1;
			$data['profit'] = 'Total Loss Amount is ' . number_format($neg, '2', '.', ',');
		}
		$data['table'] = $table;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/profitloss', $data);
		echo view('template/footer');
	}

	public function ledger_statement($ledger = '', $fdate = '', $tdate = '')
	{
		$id = $this->request->uri->getSegment(3);
		if (!empty($id))
			$ledger = $id;
		else {
			if ($_POST['fdate'])
				$fdate = $_POST['fdate'];
			else
				$fdate = $fdate;
			if ($_POST['tdate'])
				$tdate = $_POST['tdate'];
			else
				$tdate = $tdate;
			$tdate = $_POST['tdate'];
		}
		//echo $ledger; echo '<br>'; echo $fdate; echo '<br>'; echo $tdate; die;
		if (empty($fdate) && empty($tdate)) {
			$res = $this->db->table('entryitems', 'entries')
				->join('entries', 'entries.id = entryitems.entry_id')
				->where('entryitems.ledger_id', $ledger)
				->select('entryitems.*')
				->select('entries.*')
				->orderBy('entries.date', 'ASC')
				->get()
				->getResultArray();
		} else {
			if (empty($tdate))
				$tdate = date("Y-m-d");
			$res = $this->db->table('entryitems', 'entries')
				->join('entries', 'entries.id = entryitems.entry_id')
				->where('entries.date >=', $fdate)
				->where('entries.date <=', $tdate)
				->where('entryitems.ledger_id', $ledger)
				->select('entryitems.*')
				->select('entries.*')
				->orderBy('entries.date', 'ASC')
				->get()
				->getResultArray();
		}
		// echo $ledger.'<br>'.$fdate.'<br>'.$tdate.'<br>'.$this->db->getLastQuery().'<br>'; 
		// echo '<pre>'; print_r($res);//die;
		//Opening Balance
		// $op_bal = $this->db->table('ledgers')->where('id', $ledger)->get()->getRowArray();
		// $op_bal = $op_bal['op_balance'];
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $ledger)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
		if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
			$op_bal -= $op_balance['cr_amount'];
		} else {
			$op_bal = $op_balance['dr_amount'];
		}
		if (!empty($fdate)) {
			$date = explode('-', $fdate);
			$m = $date[1];
			$de = $date[2];
			$y = $date[0];
			$ydate = date('Y-m-d', mktime(0, 0, 0, $m, ($de - 1), $y));

			$ops = $this->db->table('entryitems', 'entries')
				->join('entries', 'entries.id = entryitems.entry_id')
				->where('entries.date <=', $ydate)
				->where('entryitems.ledger_id', $ledger)
				->select('entryitems.*')
				->select('entries.*')
				->get()
				->getResultArray();

			foreach ($ops as $rd) {
				if ($rd['dc'] == 'D')
					$op_bal = $op_bal + $rd['amount'];
				else
					$op_bal = $op_bal - $rd['amount'];
			}
		}
		// echo $op_bal;
		// die;
		$data['op_bal'] = $op_bal;
		$i = 0;
		$datas = array();
		foreach ($res as $row) {
			// Ledger Name
			$getentry = $this->db->table('entryitems')->where('entry_id', $row['entry_id'])->get()->getResultArray();
			if ($getentry[0]['dc'] == 'D')
				$debit_name = $this->db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
			else
				$debit_name = $this->db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();

			if ($getentry[0]['dc'] == 'C')
				$credit_name = $this->db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
			else
				$credit_name = $this->db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();

			$ledger = $debit_name['name'] . ' / Cr ' . $credit_name['name'];
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
			if (!empty($row['amount']))
				$amount = $row['amount'];
			else
				$amount = 0;
			if ($row['dc'] == 'D') {
				//$debit = 'Dr '.str_replace('-0', '0', number_format($amount, '2','.',','));
				$debit = str_replace('-0', '0', number_format($amount, '2', '.', ','));
				$debit_amount = $amount;
			} else {
				$debit = '';
				$debit_amount = 0.00;
			}

			if ($row['dc'] == 'C') {
				/* $credit = 'Cr '.str_replace('-0', '0', number_format($amount, '2','.',',')); */
				$credit = str_replace('-0', '0', number_format($amount, '2', '.', ','));
				$credit_amount = $amount;
			} else {
				$credit = '';
				$credit_amount = 0.00;
			}

			//Balance Amount
			if ($row['dc'] == 'C')
				$op_bal -= $amount;
			else
				$op_bal += $amount;

			//Report Data
			$datas[$i]['date'] = $row['date'];
			$datas[$i]['entry_code'] = $row['entry_code'];
			//$datas[$i]['inv_no'] = $inv_no;
			$datas[$i]['ledger'] = $ledger;
			$datas[$i]['debit'] = $debit;
			$datas[$i]['debit_amount'] = $debit_amount;
			$datas[$i]['credit'] = $credit;
			$datas[$i]['credit_amount'] = $credit_amount;
			$datas[$i]['balance'] = $op_bal;

			$i++;
		}
		$data['cl_bal'] = $op_bal;
		$data['data'] = $datas;
		if (empty($id)) {
			return $data;
			exit;
		} else {

			echo view('account_report/ledger_statement', $data);
		}
	}

	public function print_ledger_statement()
	{


		$ledger_id = $_POST['ledger'];
		$fdate = $_POST['fdate'];
		$tdate = $_POST['tdate'];
		$led_res = $this->ledger_statement($ledger_id, $fdate, $tdate);
		$data = $led_res;
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		echo view('account_report/ledger_statement', $data);
	}




	public function print_trial_balance()
	{
		if (!$this->model->permission_validate('trial_balance_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
		$parentgroup = $query->getResultArray();
		$datas = array();
		foreach ($parentgroup as $row) {
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt = $op_balance['cr_amount'];
						} else {
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
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_balance_amt + $debitamt) - $creditamt;
						if (!empty($debitamt) || !empty($creditamt)) {
							$datas[] = '<tr>
										<td>' . $ledgercode . '</td>
										<td>' . $ledgername . '</td>
										<td align="right">' . number_format($debitamt, '2', '.', '') . '</td>
										<td align="right">' . number_format($creditamt, '2', '.', '') . '</td>
									</tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $debitamt;
						$totalcre += $creditamt;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();

						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt = $op_balance['cr_amount'];
							} else {
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
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_balance_amt + $debitamt) - $creditamt;
							if (!empty($debitamt) || !empty($creditamt)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td>' . $ledgername . '</td>
                                            <td align="right">' . number_format($debitamt, '2', '.', '') . '</td>
                                            <td align="right">' . number_format($creditamt, '2', '.', '') . '</td>
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
			if (count($res) > 0) {
				foreach ($res as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
						$op_balance_amt = $op_balance['cr_amount'];
					} else {
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
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_balance_amt + $debitamt) - $creditamt;
					if (!empty($debitamt) || !empty($creditamt)) {
						$datas[] = '<tr>
									<td>' . $ledgercode . '</td>
									<td>' . $ledgername . '</td>
									<td align="right">' . number_format($debitamt, '2', '.', '') . '</td>
									<td align="right">' . number_format($creditamt, '2', '.', '') . '</td>
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
					<td align="right" style="border-bottom:4px double black;">' . number_format($totaldeb, '2', '.', '') . '</td>
					<td align="right" style="border-bottom:4px double black;">' . number_format($totalcre, '2', '.', '') . '</td>
					</tr>';

		$data['list'] = $datas;
		echo view('account_report/print_trial_balance', $data);
	}



	public function print_trial_balance11()
	{
		if (!$this->model->permission_validate('trial_balance_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}


		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		//echo $sdate; echo $tdate;die;
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
		$parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach ($parentgroup as $row) {
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
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
						$op_balance_amt = $op_balance['cr_amount'];
					} else {
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
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					if (!empty($debitamt) || !empty($creditamt)) {
						$datas[] = '<tr>
                                    <td>' . $ledgercode . '</td>
                                    <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a>
                                    </td>
                                    <td align="right">' . number_format($debitamt, '2', '.', ',') . '</td>
                                    <td align="right">' . number_format($creditamt, '2', '.', ',') . '</td>
                                </tr>';
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $debitamt;
					$totalcre += $creditamt;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$crow['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt = $op_balance['cr_amount'];
						} else {
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
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						if (!empty($debitamt) || !empty($creditamt)) {
							$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($debitamt, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($creditamt, '2', '.', ',') . '</td>
                                        </tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $debitamt;
						$totalcre += $creditamt;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();
						/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$ccg['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt = $op_balance['cr_amount'];
							} else {
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
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							if (!empty($debitamt) || !empty($creditamt)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($debitamt, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($creditamt, '2', '.', ',') . '</td>
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
					<td align="right">' . number_format($totaldeb, '2', '.', '') . '</td>
					<td align="right">' . number_format($totalcre, '2', '.', '') . '</td>
					</tr></tfoot>';
		$data['sdate'] = $sdate;
		$data['tdate'] = $tdate;
		$data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();


		echo view('account_report/print_trial_balance', $data);
	}


	public function excel_trial_balance()
	{
		if (!$this->model->permission_validate('trial_balance_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
		$parentgroup = $query->getResultArray();
		$data = array();
		foreach ($parentgroup as $row) {
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt = $op_balance['cr_amount'];
						} else {
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
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_balance_amt + $debitamt) - $creditamt;
						if (!empty($debitamt) || !empty($creditamt)) {
							$data[] = array(
								"ledgercode" => $ledgercode,
								"ledgername" => $ledgername,
								"debitamt" => number_format($debitamt, '2', '.', ''),
								"creditamt" => number_format($creditamt, '2', '.', '')
							);
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $debitamt;
						$totalcre += $creditamt;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->get()->getResultArray();

						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt = $op_balance['cr_amount'];
							} else {
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
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_balance_amt + $debitamt) - $creditamt;
							if (!empty($debitamt) || !empty($creditamt)) {
								$data[] = array(
									"ledgercode" => $ledgercode,
									"ledgername" => $ledgername,
									"debitamt" => number_format($debitamt, '2', '.', ''),
									"creditamt" => number_format($creditamt, '2', '.', '')
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
			if (count($res) > 0) {
				foreach ($res as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
						$op_balance_amt = $op_balance['cr_amount'];
					} else {
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
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_balance_amt + $debitamt) - $creditamt;
					if (!empty($debitamt) || !empty($creditamt)) {
						$data[] = array(
							"ledgercode" => $ledgercode,
							"ledgername" => $ledgername,
							"debitamt" => number_format($debitamt, '2', '.', ''),
							"creditamt" => number_format($creditamt, '2', '.', '')
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
			"Total" => "Total",
			"totaldeb" => number_format($totaldeb, '2', '.', ''),
			"totalcre" => number_format($totalcre, '2', '.', '')
		);
		$fileName = "trial_balance_" . $sdate . "_to_" . $tdate;
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
		$sheet->setCellValue('A1', "LEMBAGA WAKAF HINDU NEGERL PULAU PINANG PENANG STATE HINDU ENDOWMENTS BOARD");
		$sheet->setCellValue('A2', 'A/C No');
		$sheet->setCellValue('B2', 'Description');
		$sheet->setCellValue('C2', 'Debit');
		$sheet->setCellValue('D2', 'Credit');
		$rows = 3;
		foreach ($data as $val) {
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
		$writer->save('uploads/excel/' . $fileName . '.xlsx');
		return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');

	}
	public function print_profit_loss()
	{
		if (!$this->model->list_validate('profit_and_loss_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('profit_and_loss_accounts');
		//var_dump($_POST);
		// exit;

		if ($_POST['sdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['edate'])
			$edate = $_POST['tdate'];
		else
			$edate = date('Y-m-d');

		if (!empty($_POST['fmonthdate']))
			$smonthdate = $_POST['fmonthdate'] . "-01";
		else
			$smonthdate = date('Y-m-01');

		if (!empty($_POST['tmonthdate'])) {
			$datecount = cal_gregorian($_POST['tmonthdate']);
			$emonthdate = $_POST['tmonthdate'] . "-" . $datecount;
		} else {
			$datecount = cal_gregorian($_POST['tmonthdate']);
			$emonthdate = date('Y-m') . "-" . $datecount;
		}
		$breakdown = $_POST['pbreakdown'];
		$fund_id = (!empty($_POST['fund_id_print']) ? $_POST['fund_id_print'] : '');
		//echo $job_code; //die;
		$table = array();
		$data = array();
		$datas = array();
		$total_income = 0;
		$total_expenses = 0;
		// Income List
		$id = [27, 28, 29];  // direct income, indirect income and sales account group id
		//$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
		$res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
		$subincome_array = array();
		foreach ($res as $row) {
			$subincome_array[$row['name']] = $row['id'];
		}
		$main_incomes['Income'] = "26";
		$income_array = array_merge($main_incomes, $subincome_array);
		//var_dump($income_array);
		//exit;
		$whr = '';
		if (!empty($fund_id))
			$whr = " and e.fund_id=$fund_id";
		$profit = 0;
		if ($breakdown == "monthly") {

			$getMonthsInRange = getMonthsInRange($smonthdate, $emonthdate);
			$bd_colspan = getMonthsInCount($smonthdate, $emonthdate);
			$from_date = $smonthdate;
			$to_date = $emonthdate;

			// Sales //

			$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
			$sales_ledgers = $this->db->table("ledgers")->where('group_id', $top_sales_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_sales_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($sales_ledgers) > 0) {
				foreach ($sales_ledgers as $sales_ledger) {
					$html = '<tr>';
					$ledgercode = $sales_ledger['left_code'] . '/' . $sales_ledger['right_code'];
					$ledgername = $sales_ledger['name'];
					$ledger_id = $sales_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$sales_sub_groups = $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($sales_sub_groups) > 0) {
				foreach ($sales_sub_groups as $sales_sub_group) {
					$sales_sub_ledgers = $this->db->table("ledgers")->where('group_id', $sales_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($sales_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($sales_sub_ledgers as $sales_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $sales_sub_ledger['left_code'] . '/' . $sales_sub_ledger['right_code'];
							$ledgername = $sales_sub_ledger['name'];
							$sub_ledger_id = $sales_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $sales_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$sales_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sales_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($sales_sub_sub_groups) > 0) {
							foreach ($sales_sub_sub_groups as $sales_sub_sub_group) {
								$sales_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $sales_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($sales_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($sales_sub_sub_ledgers as $sales_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $sales_sub_sub_ledger['left_code'] . '/' . $sales_sub_sub_ledger['right_code'];
										$ledgername = $sales_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $sales_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $sales_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $sales_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $sales_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_sales_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$sales_total = $ledger_total;

			// Cost of Sales //

			$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
			$co_sales_ledgers = $this->db->table("ledgers")->where('group_id', $top_co_sales_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_co_sales_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$co_sales_total = 0;
			$ledger_total = array();
			if (count($co_sales_ledgers) > 0) {
				foreach ($co_sales_ledgers as $co_sales_ledger) {
					$html = '<tr>';
					$ledgercode = $co_sales_ledger['left_code'] . '/' . $co_sales_ledger['right_code'];
					$ledgername = $co_sales_ledger['name'];
					$ledger_id = $co_sales_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($month_total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$co_sales_sub_groups = $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($co_sales_sub_groups) > 0) {
				foreach ($co_sales_sub_groups as $co_sales_sub_group) {
					$co_sales_sub_ledgers = $this->db->table("ledgers")->where('group_id', $co_sales_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($co_sales_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($co_sales_sub_ledgers as $co_sales_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $co_sales_sub_ledger['left_code'] . '/' . $co_sales_sub_ledger['right_code'];
							$ledgername = $co_sales_sub_ledger['name'];
							$sub_ledger_id = $co_sales_sub_ledger['id'];
							$sub_html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $co_sales_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$co_sales_sub_sub_groups = $this->db->table("groups")->where('parent_id', $co_sales_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($co_sales_sub_sub_groups) > 0) {
							foreach ($co_sales_sub_sub_groups as $co_sales_sub_sub_group) {
								$co_sales_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $co_sales_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($co_sales_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($co_sales_sub_sub_ledgers as $co_sales_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $co_sales_sub_sub_ledger['left_code'] . '/' . $co_sales_sub_sub_ledger['right_code'];
										$ledgername = $co_sales_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $co_sales_sub_sub_ledger['id'];
										$sub_html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $co_sales_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $co_sales_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right"  class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $co_sales_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_co_sales_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$cost_sales_total = $ledger_total;


			// Gross Profit //

			$gross_profit_total = array();
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Gross Profit/Loss</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $sales_total[$res_month['date']] - $cost_sales_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$html .= '<td align="right" class="bold_text">' . $cur_total_amount . '</td>';
					$month_total += $cur_total;
					$gross_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';

			// Incomes //

			$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
			$incomes_ledgers = $this->db->table("ledgers")->where('group_id', $top_incomes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_incomes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$incomes_total = 0;
			$ledger_total = array();
			if (count($incomes_ledgers) > 0) {
				foreach ($incomes_ledgers as $incomes_ledger) {
					$html = '<tr>';
					$ledgercode = $incomes_ledger['left_code'] . '/' . $incomes_ledger['right_code'];
					$ledgername = $incomes_ledger['name'];
					$ledger_id = $incomes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($month_total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$incomes_sub_groups = $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($incomes_sub_groups) > 0) {
				foreach ($incomes_sub_groups as $incomes_sub_group) {
					$incomes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $incomes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($incomes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($incomes_sub_ledgers as $incomes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $incomes_sub_ledger['left_code'] . '/' . $incomes_sub_ledger['right_code'];
							$ledgername = $incomes_sub_ledger['name'];
							$sub_ledger_id = $incomes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $incomes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$incomes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $incomes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($incomes_sub_sub_groups) > 0) {
							foreach ($incomes_sub_sub_groups as $incomes_sub_sub_group) {
								$incomes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $incomes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($incomes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($incomes_sub_sub_ledgers as $incomes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $incomes_sub_sub_ledger['left_code'] . '/' . $incomes_sub_sub_ledger['right_code'];
										$ledgername = $incomes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $incomes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $incomes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $incomes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $incomes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_incomes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$incomes_total = $ledger_total;


			// Expenses //

			$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
			$expenes_ledgers = $this->db->table("ledgers")->where('group_id', $top_expenes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_expenes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($expenes_ledgers) > 0) {
				foreach ($expenes_ledgers as $expenes_ledger) {
					$html = '<tr>';
					$ledgercode = $expenes_ledger['left_code'] . '/' . $expenes_ledger['right_code'];
					$ledgername = $expenes_ledger['name'];
					$ledger_id = $expenes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$expenes_sub_groups = $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($expenes_sub_groups) > 0) {
				foreach ($expenes_sub_groups as $expenes_sub_group) {
					$expenes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $expenes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($expenes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($expenes_sub_ledgers as $expenes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $expenes_sub_ledger['left_code'] . '/' . $expenes_sub_ledger['right_code'];
							$ledgername = $expenes_sub_ledger['name'];
							$sub_ledger_id = $expenes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $expenes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$expenes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $expenes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($expenes_sub_sub_groups) > 0) {
							foreach ($expenes_sub_sub_groups as $expenes_sub_sub_group) {
								$expenes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $expenes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($expenes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($expenes_sub_sub_ledgers as $expenes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $expenes_sub_sub_ledger['left_code'] . '/' . $expenes_sub_sub_ledger['right_code'];
										$ledgername = $expenes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $expenes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $expenes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $expenes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $expenes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_expenes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$expenes_total = $ledger_total;

			// Net Profit //

			$net_profit_total = array();
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Net Profit/Loss</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $gross_profit_total[$res_month['date']] + $incomes_total[$res_month['date']] - $expenes_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$html .= '<td align="right" class="bold_text">' . $cur_total_amount . '</td>';
					$month_total += $cur_total;
					$net_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';


			// Taxation //

			$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
			$taxes_ledgers = $this->db->table("ledgers")->where('group_id', $top_taxes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_taxes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($taxes_ledgers) > 0) {
				foreach ($taxes_ledgers as $taxes_ledger) {
					$html = '<tr>';
					$ledgercode = $taxes_ledger['left_code'] . '/' . $taxes_ledger['right_code'];
					$ledgername = $taxes_ledger['name'];
					$ledger_id = $taxes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$taxes_sub_groups = $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($taxes_sub_groups) > 0) {
				foreach ($taxes_sub_groups as $taxes_sub_group) {
					$taxes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $taxes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($taxes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($taxes_sub_ledgers as $taxes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $taxes_sub_ledger['left_code'] . '/' . $taxes_sub_ledger['right_code'];
							$ledgername = $taxes_sub_ledger['name'];
							$sub_ledger_id = $taxes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $taxes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$taxes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $taxes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($taxes_sub_sub_groups) > 0) {
							foreach ($taxes_sub_sub_groups as $taxes_sub_sub_group) {
								$taxes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $taxes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($taxes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($taxes_sub_sub_ledgers as $taxes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $taxes_sub_sub_ledger['left_code'] . '/' . $taxes_sub_sub_ledger['right_code'];
										$ledgername = $taxes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $taxes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $taxes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $taxes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $taxes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_taxes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$taxes_total = $ledger_total;


			// Total Profit //

			$final_profit_total = array();
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $net_profit_total[$res_month['date']] - $taxes_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$month_total += $cur_total;
					$final_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
			}
			if (count($final_profit_total) > 0) {
				$month_total = 0;
				foreach ($final_profit_total as $fpt) {
					$profit += $fpt;
				}
			}
			$html = '';


		} else {

			$getMonthsInRange = array();
			$bd_colspan = 1;
			$from_date = $sdate;
			$to_date = $edate;

			// Sales //

			$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
			$sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_sales_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_sales_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_sales_group['name'] . '</td><td></td></tr>';
			if (count($sales_groups) > 0) {
				foreach ($sales_groups as $sales_group) {
					$group_id = $sales_group['group_id'];
					$total = $sales_group['cr_total'] - $sales_group['dr_total'];
					$top_sales_group_total += $total;
					$ledgercode = $sales_group['left_code'] . '/' . $sales_group['right_code'];
					$ledgername = $sales_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($sales_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$sales_sub_groups_total = 0;
						foreach ($sales_sub_groups as $sales_sub_group) {
							$total = $sales_sub_group['cr_total'] - $sales_sub_group['dr_total'];
							$sales_sub_groups_total += $total;
							$ledgercode = $sales_sub_group['left_code'] . '/' . $sales_sub_group['right_code'];
							$ledgername = $sales_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($sales_sub_groups_total < 0)
							$sales_sub_groups_total_amount = "( " . number_format(abs($sales_sub_groups_total), 2) . " )";
						else
							$sales_sub_groups_total_amount = number_format($sales_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $sales_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $sales_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($sales_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$sales_sub_sub_groups_total = 0;
								foreach ($sales_sub_sub_groups as $sales_sub_sub_group) {
									$total = $sales_sub_sub_group['cr_total'] - $sales_sub_sub_group['dr_total'];
									$sales_sub_sub_groups_total += $total;
									$ledgercode = $sales_sub_sub_group['left_code'] . '/' . $sales_sub_sub_group['right_code'];
									$ledgername = $sales_sub_sub_group['ledger_name'];
									if ($sales_sub_sub_groups_total < 0)
										$sales_sub_sub_groups_total_amount = "( " . number_format(abs($sales_sub_sub_groups_total), 2) . " )";
									else
										$sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($sales_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($sales_sub_sub_groups_total < 0)
									$sales_sub_sub_groups_total_amount = "( " . number_format(abs($sales_sub_sub_groups_total), 2) . " )";
								else
									$sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $sales_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $sales_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_sales_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_sales_group_total_amount = "( " . number_format(abs($top_sales_group_total), 2) . " )";
			else
				$top_sales_group_total_amount = number_format($top_sales_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_sales_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_sales_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Cost of Sales //

			$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
			$co_sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_co_sales_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_co_sales_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_co_sales_group['name'] . '</td><td></td></tr>';
			if (count($co_sales_groups) > 0) {
				foreach ($co_sales_groups as $co_sales_group) {
					$group_id = $co_sales_group['group_id'];
					$total = $co_sales_group['dr_total'] - $co_sales_group['cr_total'];
					$top_co_sales_group_total += $total;
					$ledgercode = $co_sales_group['left_code'] . '/' . $co_sales_group['right_code'];
					$ledgername = $co_sales_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$co_sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($co_sales_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$co_sales_sub_groups_total = 0;
						foreach ($co_sales_sub_groups as $co_sales_sub_group) {
							$total = $co_sales_sub_group['dr_total'] - $co_sales_sub_group['cr_total'];
							$co_sales_sub_groups_total += $total;
							$ledgercode = $co_sales_sub_group['left_code'] . '/' . $co_sales_sub_group['right_code'];
							$ledgername = $co_sales_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($co_sales_sub_groups_total < 0)
							$co_sales_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_groups_total), 2) . " )";
						else
							$co_sales_sub_groups_total_amount = number_format($co_sales_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $co_sales_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $co_sales_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$co_sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($co_sales_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$co_sales_sub_sub_groups_total = 0;
								foreach ($co_sales_sub_sub_groups as $co_sales_sub_sub_group) {
									$total = $co_sales_sub_sub_group['dr_total'] - $co_sales_sub_sub_group['cr_total'];
									$co_sales_sub_sub_groups_total += $total;
									$ledgercode = $co_sales_sub_sub_group['left_code'] . '/' . $co_sales_sub_sub_group['right_code'];
									$ledgername = $co_sales_sub_sub_group['ledger_name'];
									if ($co_sales_sub_sub_groups_total < 0)
										$co_sales_sub_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_sub_groups_total), 2) . " )";
									else
										$co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($co_sales_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($co_sales_sub_sub_groups_total < 0)
									$co_sales_sub_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_sub_groups_total), 2) . " )";
								else
									$co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $co_sales_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $co_sales_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_co_sales_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_co_sales_group_total_amount = "( " . number_format(abs($top_co_sales_group_total), 2) . " )";
			else
				$top_co_sales_group_total_amount = number_format($top_co_sales_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_co_sales_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_co_sales_group_total_amount . '</td>';
			$table[] .= '</tr>';
			$gross_profit = $top_sales_group_total - $top_co_sales_group_total;

			if ($gross_profit < 0) {
				$gross_profit_amount = "( " . number_format(abs($gross_profit), 2) . " )";
				$gross_profit_txt = 'Gross Loss';
			} else {
				$gross_profit_amount = number_format($gross_profit, 2);
				$gross_profit_txt = 'Gross Profit';
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $gross_profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $gross_profit_amount . '</td>';
			$table[] .= '</tr>';

			// Incomes

			$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
			$incomes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_incomes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_incomes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_incomes_group['name'] . '</td><td></td></tr>';
			if (count($incomes_groups) > 0) {
				foreach ($incomes_groups as $incomes_group) {
					$group_id = $incomes_group['group_id'];
					$total = $incomes_group['cr_total'] - $incomes_group['dr_total'];
					$top_incomes_group_total += $total;
					$ledgercode = $incomes_group['left_code'] . '/' . $incomes_group['right_code'];
					$ledgername = $incomes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$incomes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($incomes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$incomes_sub_groups_total = 0;
						foreach ($incomes_sub_groups as $incomes_sub_group) {
							$total = $incomes_sub_group['cr_total'] - $incomes_sub_group['dr_total'];
							$incomes_sub_groups_total += $total;
							$ledgercode = $incomes_sub_group['left_code'] . '/' . $incomes_sub_group['right_code'];
							$ledgername = $incomes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($incomes_sub_groups_total < 0)
							$incomes_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_groups_total), 2) . " )";
						else
							$incomes_sub_groups_total_amount = number_format($incomes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $incomes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $incomes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$incomes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($incomes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$incomes_sub_sub_groups_total = 0;
								foreach ($incomes_sub_sub_groups as $incomes_sub_sub_group) {
									$total = $incomes_sub_sub_group['cr_total'] - $incomes_sub_sub_group['dr_total'];
									$incomes_sub_sub_groups_total += $total;
									$ledgercode = $incomes_sub_sub_group['left_code'] . '/' . $incomes_sub_sub_group['right_code'];
									$ledgername = $incomes_sub_sub_group['ledger_name'];
									if ($incomes_sub_sub_groups_total < 0)
										$incomes_sub_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_sub_groups_total), 2) . " )";
									else
										$incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($incomes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($incomes_sub_sub_groups_total < 0)
									$incomes_sub_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_sub_groups_total), 2) . " )";
								else
									$incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $incomes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $incomes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_incomes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_incomes_group_total_amount = "( " . number_format(abs($top_incomes_group_total), 2) . " )";
			else
				$top_incomes_group_total_amount = number_format($top_incomes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_incomes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_incomes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Expenses

			$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
			$expenes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_expenes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_expenes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_expenes_group['name'] . '</td><td></td></tr>';
			if (count($expenes_groups) > 0) {
				foreach ($expenes_groups as $expenes_group) {
					$group_id = $expenes_group['group_id'];
					$total = $expenes_group['dr_total'] - $expenes_group['cr_total'];
					$top_expenes_group_total += $total;
					$ledgercode = $expenes_group['left_code'] . '/' . $expenes_group['right_code'];
					$ledgername = $expenes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$expenes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($expenes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$expenes_sub_groups_total = 0;
						foreach ($expenes_sub_groups as $expenes_sub_group) {
							$total = $expenes_sub_group['dr_total'] - $expenes_sub_group['cr_total'];
							$expenes_sub_groups_total += $total;
							$ledgercode = $expenes_sub_group['left_code'] . '/' . $expenes_sub_group['right_code'];
							$ledgername = $expenes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($expenes_sub_groups_total < 0)
							$expenes_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_groups_total), 2) . " )";
						else
							$expenes_sub_groups_total_amount = number_format($expenes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $expenes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $expenes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$expenes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($expenes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$expenes_sub_sub_groups_total = 0;
								foreach ($expenes_sub_sub_groups as $expenes_sub_sub_group) {
									$total = $expenes_sub_sub_group['dr_total'] - $expenes_sub_sub_group['cr_total'];
									$expenes_sub_sub_groups_total += $total;
									$ledgercode = $expenes_sub_sub_group['left_code'] . '/' . $expenes_sub_sub_group['right_code'];
									$ledgername = $expenes_sub_sub_group['ledger_name'];
									if ($expenes_sub_sub_groups_total < 0)
										$expenes_sub_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_sub_groups_total), 2) . " )";
									else
										$expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($expenes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($expenes_sub_sub_groups_total < 0)
									$expenes_sub_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_sub_groups_total), 2) . " )";
								else
									$expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $expenes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $expenes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_expenes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_expenes_group_total_amount = "( " . number_format(abs($top_expenes_group_total), 2) . " )";
			else
				$top_expenes_group_total_amount = number_format($top_expenes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_expenes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_expenes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Net Profit

			$net_profit = $gross_profit + $top_incomes_group_total - $top_expenes_group_total;

			if ($net_profit < 0) {
				$net_profit_amount = "( " . number_format(abs($net_profit), 2) . " )";
				$net_profit_txt = "Net Loss";
			} else {
				$net_profit_amount = number_format($net_profit, 2);
				$net_profit_txt = "Net Profit";
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $net_profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $net_profit_amount . '</td>';
			$table[] .= '</tr>';

			// Taxation

			$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
			$taxes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_taxes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_taxes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_taxes_group['name'] . '</td><td></td></tr>';
			if (count($taxes_groups) > 0) {
				foreach ($taxes_groups as $taxes_group) {
					$group_id = $taxes_group['group_id'];
					$total = $taxes_group['dr_total'] - $taxes_group['cr_total'];
					$top_taxes_group_total += $total;
					$ledgercode = $taxes_group['left_code'] . '/' . $taxes_group['right_code'];
					$ledgername = $taxes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$taxes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($taxes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['group_name'] . '</td><td></td></tr>';
						$taxes_sub_groups_total = 0;
						foreach ($taxes_sub_groups as $taxes_sub_group) {
							$total = $taxes_sub_group['dr_total'] - $taxes_sub_group['cr_total'];
							$taxes_sub_groups_total += $total;
							$ledgercode = $taxes_sub_group['left_code'] . '/' . $taxes_sub_group['right_code'];
							$ledgername = $taxes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($taxes_sub_groups_total < 0)
							$taxes_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_groups_total), 2) . " )";
						else
							$taxes_sub_groups_total_amount = number_format($taxes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['group_name'] . '</td><td>' . $taxes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $taxes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$taxes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($taxes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['group_name'] . '</td><td></td></tr>';
								$taxes_sub_sub_groups_total = 0;
								foreach ($taxes_sub_sub_groups as $taxes_sub_sub_group) {
									$total = $taxes_sub_sub_group['dr_total'] - $taxes_sub_sub_group['cr_total'];
									$taxes_sub_sub_groups_total += $total;
									$ledgercode = $taxes_sub_sub_group['left_code'] . '/' . $taxes_sub_sub_group['right_code'];
									$ledgername = $taxes_sub_sub_group['ledger_name'];
									if ($taxes_sub_sub_groups_total < 0)
										$taxes_sub_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_sub_groups_total), 2) . " )";
									else
										$taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($taxes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($taxes_sub_sub_groups_total < 0)
									$taxes_sub_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_sub_groups_total), 2) . " )";
								else
									$taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['group_name'] . '</td><td>' . $taxes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $taxes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_taxes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_taxes_group_total_amount = "( " . number_format(abs($top_taxes_group_total), 2) . " )";
			else
				$top_taxes_group_total_amount = number_format($top_taxes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_taxes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_taxes_group_total_amount . '</td>';
			$table[] .= '</tr>';
			$profit = $net_profit - $top_taxes_group_total;
		}
		// print_r($sales_grops);
		// die;

		/* foreach($income_array as $key => $row){
			$led_list = $this->db->table("ledgers")->where('group_id', $row)->orderBy('left_code', 'ASC')->get()->getResultArray();
			if($breakdown == "monthly"){
				if(count($getMonthsInRange) > 0){
					foreach($getMonthsInRange as &$res_month){
						$ss_date = $res_month['date'] . '-01';
						$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
						foreach($led_list as $led){
							$led_bd = $this->db->table('entryitems', 'entries')
										->join('entries', 'entries.id = entryitems.entry_id')
										->where('entryitems.ledger_id', $led['id'])
										->where('entries.date >=', $ss_date)
										->where('entries.date <=', $ee_date);
							if(!empty($fund_id)) $led_bd = $led_bd->where('entries.fund_id', $fund_id);
							$led_res = $led_bd->select('entryitems.*')
										->select('entries.date')
										->get()
										->getResultArray();
							$total_dr = 0; $total_cr = 0;
							if(count($led_res) > 0){
								foreach($led_res as $dr){
									if(is_numeric($dr['amount']) == true){
										if(!empty($dr['amount'])) $amount = $dr['amount'];
										else $amount = 0;

										if($dr['dc'] == 'D') $total_dr += $amount;
										if($dr['dc'] == 'C') $total_cr += $amount;
									}
								}
							}
							$fin_amt = $total_cr - $total_dr;
							$led_name = $led['id'];
							$res_month['income_amount'][$led_name] = $fin_amt;
							if(empty($res_month['total_income_amount'])) $res_month['total_income_amount'] = 0;
							$res_month['total_income_amount'] += $fin_amt;
						}
					}
				}
			}
			foreach($led_list as $led){
				$led_bd = $this->db->table('entryitems', 'entries')
							->join('entries', 'entries.id = entryitems.entry_id')
							->where('entryitems.ledger_id', $led['id'])
							->where('entries.date >=', $from_date)
							->where('entries.date <=', $to_date);
				if(!empty($fund_id)) $led_bd = $led_bd->where('entries.fund_id', $fund_id);
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
				$table[] = '<tr>
								<td style="font-weight: bold;font-size: medium;">'.$key.'</td>';
								if($breakdown == "monthly"){
									foreach($getMonthsInRange as $ris_month){
										$table[].= '<td></td>';
									}
									$table[] .= '<td ></td>';
								}
								else{
									$table[] .= '<td ></td>';
								}
				$table[] .= '<tr>';
				foreach($val as $sub_key => $sub_val){
					if($sub_key != "Income"){
						$sub_total_income = get_profit_loss_subtotal($sub_val);
						if($sub_total_income > 0)
						{
							$table[] .= '<tr>
											<td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td>';
											if($breakdown == "monthly"){
												foreach($getMonthsInRange as $ras_month){
													$table[] .= '<td></td>';
												}
												$table[] .= '<td ></td>'; 
											}
											else{
												$table[] .= '<td ></td>';
											}
							$table[] .= '<tr>';
						}
					}
					foreach($sub_val as $skey => $sval){
						foreach($sval as $name => $amt){
							if(!empty($amt))
							{
								$ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
								$table[] .= '<tr>
												<td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' .$ledgername.'</td>';
												if($breakdown == "monthly"){
													foreach($getMonthsInRange as $rks_month){
														$table[] .= '<td>'.number_format($rks_month['income_amount'][$name], "2",".",",").'</td>';
													}
													$table[] .= '<td align="right" >'.number_format($amt, "2",".",",").'</td>'; // TOTAL AMOUNT
												}
												else{
													$table[] .= '<td align="right" >'.number_format($amt, "2",".",",").'</td>';
												}
								$table[] .= '</tr>';
							}
							$total_income += $amt;
						}
					}
				}
			}
		}
		else{
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Income</td><td colspan='.$bd_colspan.'></td><tr>';
		}
	   $table[] .= '<tr><td><strong>Total Income</strong></td>';
	   if($breakdown == "monthly"){
			foreach($getMonthsInRange as $rr_month){
				$table[] .= '<td align="left" style="font-weight:bold">'.number_format($rr_month['total_income_amount'], "2",".",",").'</td>';
			}
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_income, "2",".",",").'</td>';
		}
		else{
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_income, "2",".",",").'</td>';
		}
		$table[] .= '<tr>';

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
			if($breakdown == "monthly"){
				if(count($getMonthsInRange) > 0){
					foreach($getMonthsInRange as &$rss_month){
						$ss_date = $rss_month['date'] . '-01';
						$ee_date = date('Y-m-t', strtotime($rss_month['date'] . '-01'));
						foreach($led_list as $led){
							$led_bd1 = $this->db->table('entryitems', 'entries')
										->join('entries', 'entries.id = entryitems.entry_id')
										->where('entryitems.ledger_id', $led['id'])
										->where('entries.date >=', $ss_date)
										->where('entries.date <=', $ee_date);
							if(!empty($fund_id)) $led_bd1 = $led_bd1->where('entries.fund_id', $fund_id);
							$led_res1 = $led_bd1->select('entryitems.*')
										->select('entries.date')
										->get()
										->getResultArray();
							$total_dr = 0; $total_cr = 0;
							foreach($led_res1 as $dr){
								if(is_numeric($dr['amount']) == true){
									if(!empty($dr['amount'])) $amount = $dr['amount'];
									else $amount = 0;

									if($dr['dc'] == 'D') $total_dr += $amount;
									if($dr['dc'] == 'C') $total_cr += $amount;
								}
							}
						   $fin_amt = $total_dr - $total_cr;
						   $led_name = $led['id'];
						   $rss_month['expense_amount'][$led_name] = $fin_amt;
						   $rss_month['expense_query'][$led_name] = $this->db->getLastQuery();
						   if(empty($rss_month['total_expense_amount'])) $rss_month['total_expense_amount'] = 0;
						   $rss_month['total_expense_amount'] += $fin_amt;
						}
					}
				}
			}
			foreach($led_list as $led){
				$led_bd2 = $this->db->table('entryitems', 'entries')
							->join('entries', 'entries.id = entryitems.entry_id')
							->where('entryitems.ledger_id', $led['id'])
							->where('entries.date >=', $from_date)
							->where('entries.date <=', $to_date);
				if(!empty($fund_id)) $led_bd2 = $led_bd2->where('entries.fund_id', $fund_id);
				$led_res2 = $led_bd2->select('entryitems.*')
							->select('entries.date')
							->get()
							->getResultArray();
				$total_dr = 0; $total_cr = 0;
				foreach($led_res2 as $dr){
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
				$table[] .= '<tr>
								<td style="font-weight: bold;font-size: medium;">'.$key.'</td>';
								if($breakdown == "monthly"){
									foreach($getMonthsInRange as $rea_month){
										$table[] .= '<td></td>';
									}
									$table[] .= '<td ></td>';
								}
								else{
									$table[] .= '<td ></td>';
								}
				 $table[] .= '<tr>';
				foreach($val as $sub_key => $sub_val){
					if($sub_key != "Expenses"){
						$sub_total_expenses = get_profit_loss_subtotal($sub_val);
						if($sub_total_expenses > 0)
						{
							$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;'.$sub_key.'</td>';
											if($breakdown == "monthly"){
												foreach($getMonthsInRange as $reb_month){
													$table[] .= '<td></td>';
												}
												$table[] .= '<td ></td>';
											}
											else{
												$table[] .= '<td ></td>';
											}
							$table[] .= '<tr>';
						}
					}
					foreach($sub_val as $skey => $sval){
						foreach($sval as $name => $amt){
							if(!empty($amt))
							{
								$ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
								$table[] .= '<tr>
												<td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' .$ledgername.'</td>';
												if($breakdown == "monthly"){
													foreach($getMonthsInRange as $rek_month){
													   $table[] .= '<td>'.number_format($rek_month['expense_amount'][$name], "2",".",",").'</td>';
													}
													$table[] .= '<td align="right">'.number_format($amt, "2",".",",").'</td>';
												}
												else{
													$table[] .= '<td align="right">'.number_format($amt, "2",".",",").'</td>';
												}
								$table[] .= '<tr>';
							}
							$total_expenses += $amt;
						}
					}
				}
			}
		}else{
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Expenses</td><td colspan='.$bd_colspan.'></td><tr>';
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;Direct Expenses</td><td colspan='.$bd_colspan.'></td><tr>';
		}
		$table[] .= '<tr><td><strong>Total Expenses</strong></td>';
		if($breakdown == "monthly"){
			foreach($getMonthsInRange as $red_month){
				$table[] .= '<td align="left"  style="font-weight:bold">'.number_format($red_month['total_expense_amount'], "2",".",",").'</td>';
			}
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_expenses, "2",".",",").'</td>';
		}
		else{
			$table[] .= '<td align="right" style="font-weight:bold">'.number_format($total_expenses, "2",".",",").'</td>';
		}
		$table[] .= '<tr>'; */

		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['smonthdate'] = $smonthdate;
		$data['emonthdate'] = $emonthdate;
		$data['breakdown'] = !empty($breakdown) ? $breakdown : 'daily';
		$data['getMonthsInRange'] = $getMonthsInRange;
		$data['bd_colspan'] = $bd_colspan;

		$data['fund_id'] = $fund_id;
		if ($profit >= 0)
			$data['profit'] = 'Total Profit Amount is ' . number_format($profit, '2', '.', ',');
		else {
			$neg = $profit * -1;
			$data['profit'] = 'Total Loss Amount is ' . number_format($neg, '2', '.', ',');
		}
		$data['table'] = $table;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();

		echo view('account/print_profit_loss', $data);
	}
	public function pdf_profit_loss()
	{
		if (!$this->model->list_validate('profit_and_loss_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('profit_and_loss_accounts');

		if ($_POST['pfdate'])
			$sdate = $_POST['pfdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['ptdate'])
			$edate = $_POST['ptdate'];
		else
			$edate = date('Y-m-d');

		if (!empty($_POST['pfmonthdate']))
			$smonthdate = $_POST['pfmonthdate'] . "-01";
		else
			$smonthdate = date('Y-m-01');

		if (!empty($_POST['ptmonthdate'])) {
			$datecount = cal_gregorian($_POST['ptmonthdate']);
			$emonthdate = $_POST['ptmonthdate'] . "-" . $datecount;
		} else {
			$datecount = cal_gregorian($_POST['ptmonthdate']);
			$emonthdate = date('Y-m') . "-" . $datecount;
		}
		$breakdown = $_POST['pdfbreakdown'];
		$fund_id = (!empty($_POST['fund_id_pdf']) ? $_POST['fund_id_pdf'] : '');
		//echo $job_code; //die;
		$table = array();
		$data = array();
		$datas = array();
		$total_income = 0;
		$total_expenses = 0;
		// Income List
		$id = [27, 28, 29];  // direct income, indirect income and sales account group id
		//$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
		$res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
		$subincome_array = array();
		foreach ($res as $row) {
			$subincome_array[$row['name']] = $row['id'];
		}
		$main_incomes['Income'] = "26";
		$income_array = array_merge($main_incomes, $subincome_array);
		//var_dump($income_array);
		//exit;
		$whr = '';
		if (!empty($fund_id))
			$whr = " and e.fund_id=$fund_id";
		$profit = 0;
		if ($breakdown == "monthly") {

			$getMonthsInRange = getMonthsInRange($smonthdate, $emonthdate);
			$bd_colspan = getMonthsInCount($smonthdate, $emonthdate);
			$from_date = $smonthdate;
			$to_date = $emonthdate;

			// Sales //

			$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
			$sales_ledgers = $this->db->table("ledgers")->where('group_id', $top_sales_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_sales_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($sales_ledgers) > 0) {
				foreach ($sales_ledgers as $sales_ledger) {
					$html = '<tr>';
					$ledgercode = $sales_ledger['left_code'] . '/' . $sales_ledger['right_code'];
					$ledgername = $sales_ledger['name'];
					$ledger_id = $sales_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$sales_sub_groups = $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($sales_sub_groups) > 0) {
				foreach ($sales_sub_groups as $sales_sub_group) {
					$sales_sub_ledgers = $this->db->table("ledgers")->where('group_id', $sales_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($sales_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($sales_sub_ledgers as $sales_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $sales_sub_ledger['left_code'] . '/' . $sales_sub_ledger['right_code'];
							$ledgername = $sales_sub_ledger['name'];
							$sub_ledger_id = $sales_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $sales_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$sales_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sales_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($sales_sub_sub_groups) > 0) {
							foreach ($sales_sub_sub_groups as $sales_sub_sub_group) {
								$sales_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $sales_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($sales_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($sales_sub_sub_ledgers as $sales_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $sales_sub_sub_ledger['left_code'] . '/' . $sales_sub_sub_ledger['right_code'];
										$ledgername = $sales_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $sales_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $sales_amounts['cr_total'] - $sales_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $sales_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $sales_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $sales_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_sales_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$sales_total = $ledger_total;

			// Cost of Sales //

			$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
			$co_sales_ledgers = $this->db->table("ledgers")->where('group_id', $top_co_sales_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_co_sales_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$co_sales_total = 0;
			$ledger_total = array();
			if (count($co_sales_ledgers) > 0) {
				foreach ($co_sales_ledgers as $co_sales_ledger) {
					$html = '<tr>';
					$ledgercode = $co_sales_ledger['left_code'] . '/' . $co_sales_ledger['right_code'];
					$ledgername = $co_sales_ledger['name'];
					$ledger_id = $co_sales_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($month_total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$co_sales_sub_groups = $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($co_sales_sub_groups) > 0) {
				foreach ($co_sales_sub_groups as $co_sales_sub_group) {
					$co_sales_sub_ledgers = $this->db->table("ledgers")->where('group_id', $co_sales_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($co_sales_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($co_sales_sub_ledgers as $co_sales_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $co_sales_sub_ledger['left_code'] . '/' . $co_sales_sub_ledger['right_code'];
							$ledgername = $co_sales_sub_ledger['name'];
							$sub_ledger_id = $co_sales_sub_ledger['id'];
							$sub_html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $co_sales_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$co_sales_sub_sub_groups = $this->db->table("groups")->where('parent_id', $co_sales_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($co_sales_sub_sub_groups) > 0) {
							foreach ($co_sales_sub_sub_groups as $co_sales_sub_sub_group) {
								$co_sales_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $co_sales_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($co_sales_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($co_sales_sub_sub_ledgers as $co_sales_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $co_sales_sub_sub_ledger['left_code'] . '/' . $co_sales_sub_sub_ledger['right_code'];
										$ledgername = $co_sales_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $co_sales_sub_sub_ledger['id'];
										$sub_html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$co_sales_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $co_sales_amounts['dr_total'] - $co_sales_amounts['cr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $co_sales_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $co_sales_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right"  class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $co_sales_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_co_sales_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$cost_sales_total = $ledger_total;


			// Gross Profit //

			$gross_profit_total = array();
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Gross Profit/Loss</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $sales_total[$res_month['date']] - $cost_sales_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$html .= '<td align="right" class="bold_text">' . $cur_total_amount . '</td>';
					$month_total += $cur_total;
					$gross_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';

			// Incomes //

			$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
			$incomes_ledgers = $this->db->table("ledgers")->where('group_id', $top_incomes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_incomes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$incomes_total = 0;
			$ledger_total = array();
			if (count($incomes_ledgers) > 0) {
				foreach ($incomes_ledgers as $incomes_ledger) {
					$html = '<tr>';
					$ledgercode = $incomes_ledger['left_code'] . '/' . $incomes_ledger['right_code'];
					$ledgername = $incomes_ledger['name'];
					$ledger_id = $incomes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($month_total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$incomes_sub_groups = $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($incomes_sub_groups) > 0) {
				foreach ($incomes_sub_groups as $incomes_sub_group) {
					$incomes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $incomes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($incomes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($incomes_sub_ledgers as $incomes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $incomes_sub_ledger['left_code'] . '/' . $incomes_sub_ledger['right_code'];
							$ledgername = $incomes_sub_ledger['name'];
							$sub_ledger_id = $incomes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $incomes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$incomes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $incomes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($incomes_sub_sub_groups) > 0) {
							foreach ($incomes_sub_sub_groups as $incomes_sub_sub_group) {
								$incomes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $incomes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($incomes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($incomes_sub_sub_ledgers as $incomes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $incomes_sub_sub_ledger['left_code'] . '/' . $incomes_sub_sub_ledger['right_code'];
										$ledgername = $incomes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $incomes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$incomes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $incomes_amounts['cr_total'] - $incomes_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $incomes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $incomes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $incomes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_incomes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$incomes_total = $ledger_total;


			// Expenses //

			$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
			$expenes_ledgers = $this->db->table("ledgers")->where('group_id', $top_expenes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_expenes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($expenes_ledgers) > 0) {
				foreach ($expenes_ledgers as $expenes_ledger) {
					$html = '<tr>';
					$ledgercode = $expenes_ledger['left_code'] . '/' . $expenes_ledger['right_code'];
					$ledgername = $expenes_ledger['name'];
					$ledger_id = $expenes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$expenes_sub_groups = $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($expenes_sub_groups) > 0) {
				foreach ($expenes_sub_groups as $expenes_sub_group) {
					$expenes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $expenes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($expenes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($expenes_sub_ledgers as $expenes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $expenes_sub_ledger['left_code'] . '/' . $expenes_sub_ledger['right_code'];
							$ledgername = $expenes_sub_ledger['name'];
							$sub_ledger_id = $expenes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $expenes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$expenes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $expenes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($expenes_sub_sub_groups) > 0) {
							foreach ($expenes_sub_sub_groups as $expenes_sub_sub_group) {
								$expenes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $expenes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($expenes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($expenes_sub_sub_ledgers as $expenes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $expenes_sub_sub_ledger['left_code'] . '/' . $expenes_sub_sub_ledger['right_code'];
										$ledgername = $expenes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $expenes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$expenes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $expenes_amounts['dr_total'] - $expenes_amounts['cr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $expenes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $expenes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $expenes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_expenes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$expenes_total = $ledger_total;

			// Net Profit //

			$net_profit_total = array();
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Net Profit/Loss</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $gross_profit_total[$res_month['date']] + $incomes_total[$res_month['date']] - $expenes_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$html .= '<td align="right" class="bold_text">' . $cur_total_amount . '</td>';
					$month_total += $cur_total;
					$net_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';


			// Taxation //

			$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
			$taxes_ledgers = $this->db->table("ledgers")->where('group_id', $top_taxes_group['id'])->get()->getResultArray();
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_taxes_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
			$ledger_total = array();
			if (count($taxes_ledgers) > 0) {
				foreach ($taxes_ledgers as $taxes_ledger) {
					$html = '<tr>';
					$ledgercode = $taxes_ledger['left_code'] . '/' . $taxes_ledger['right_code'];
					$ledgername = $taxes_ledger['name'];
					$ledger_id = $taxes_ledger['id'];
					$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					if (count($getMonthsInRange) > 0) {
						$month_total = 0;
						foreach ($getMonthsInRange as $res_month) {
							$ss_date = $res_month['date'] . '-01';
							$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
							$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $ledger_id$whr")->getRowArray();
							$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
							if (empty($ledger_total[$res_month['date']]))
								$ledger_total[$res_month['date']] = 0;
							$ledger_total[$res_month['date']] += $total;
							$month_total += $total;
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$html .= '<td align="right">' . $total_amount . '</td>';
						}
						if ($total < 0)
							$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
						else
							$month_total_amount = number_format($month_total, 2);
						$html .= '<td align="right">' . $month_total_amount . '</td>';
					}
					$html .= '</tr>';
					if ($month_total > 0)
						$table[] = $html;
				}
				$html = '';
			}
			$taxes_sub_groups = $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($taxes_sub_groups) > 0) {
				foreach ($taxes_sub_groups as $taxes_sub_group) {
					$taxes_sub_ledgers = $this->db->table("ledgers")->where('group_id', $taxes_sub_group['id'])->get()->getResultArray();
					$sub_table = array();
					if (count($taxes_sub_ledgers) > 0) {
						$sub_ledger_total = array();
						foreach ($taxes_sub_ledgers as $taxes_sub_ledger) {
							$html = '<tr>';
							$ledgercode = $taxes_sub_ledger['left_code'] . '/' . $taxes_sub_ledger['right_code'];
							$ledgername = $taxes_sub_ledger['name'];
							$sub_ledger_id = $taxes_sub_ledger['id'];
							$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$ss_date = $res_month['date'] . '-01';
									$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
									$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_ledger_id$whr")->getRowArray();
									$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
									if (empty($sub_ledger_total[$res_month['date']]))
										$sub_ledger_total[$res_month['date']] = 0;
									$sub_ledger_total[$res_month['date']] += $total;
									$month_total += $total;
									if ($total < 0)
										$total_amount = "( " . number_format(abs($total), 2) . " )";
									else
										$total_amount = number_format($total, 2);
									$html .= '<td align="right">' . $total_amount . '</td>';
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							if ($month_total > 0)
								$sub_table[] = $html;
						}
						if (count($sub_table) > 0) {
							$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $taxes_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
							foreach ($sub_table as $sb) {
								$table[] = $sb;
							}
						}
						$taxes_sub_sub_groups = $this->db->table("groups")->where('parent_id', $taxes_sub_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
						if (count($taxes_sub_sub_groups) > 0) {
							foreach ($taxes_sub_sub_groups as $taxes_sub_sub_group) {
								$taxes_sub_sub_ledgers = $this->db->table("ledgers")->where('group_id', $taxes_sub_sub_group['id'])->get()->getResultArray();
								$sub_sub_table = array();
								if (count($taxes_sub_sub_ledgers) > 0) {
									$sub_sub_ledger_total = array();
									foreach ($taxes_sub_sub_ledgers as $taxes_sub_sub_ledger) {
										$html = '<tr>';
										$ledgercode = $taxes_sub_sub_ledger['left_code'] . '/' . $taxes_sub_sub_ledger['right_code'];
										$ledgername = $taxes_sub_sub_ledger['name'];
										$sub_sub_ledger_id = $taxes_sub_sub_ledger['id'];
										$html .= '<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$ss_date = $res_month['date'] . '-01';
												$ee_date = date('Y-m-t', strtotime($res_month['date'] . '-01'));
												$taxes_amounts = $this->db->query("select COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.date BETWEEN '$ss_date' and '$ee_date' and ei.ledger_id = $sub_sub_ledger_id$whr")->getRowArray();
												$total = $taxes_amounts['cr_total'] - $taxes_amounts['dr_total'];
												if (empty($sub_sub_ledger_total[$res_month['date']]))
													$sub_sub_ledger_total[$res_month['date']] = 0;
												$sub_sub_ledger_total[$res_month['date']] += $total;
												$month_total += $total;
												if ($total < 0)
													$total_amount = "( " . number_format(abs($total), 2) . " )";
												else
													$total_amount = number_format($total, 2);
												$html .= '<td align="right">' . $total_amount . '</td>';
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										if ($month_total > 0)
											$sub_sub_table[] = $html;
									}

									if (count($sub_sub_table) > 0) {
										$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $taxes_sub_sub_group['name'] . '</td><td colspan="' . count($getMonthsInRange) . '"></td></tr>';
										foreach ($sub_sub_table as $sb) {
											$table[] = $sb;
										}
										$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $taxes_sub_sub_group['name'] . '</td>';
										if (count($getMonthsInRange) > 0) {
											$month_total = 0;
											foreach ($getMonthsInRange as $res_month) {
												$html .= '<td align="right" class="bold_text">' . $sub_sub_ledger_total[$res_month['date']] . '</td>';
												$month_total += $sub_sub_ledger_total[$res_month['date']];
												if (empty($sub_ledger_total[$res_month['date']]))
													$sub_ledger_total[$res_month['date']] = 0;
												$sub_ledger_total[$res_month['date']] += $sub_sub_ledger_total[$res_month['date']];
											}
											if ($month_total < 0)
												$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
											else
												$month_total_amount = number_format($month_total, 2);
											$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
										}
										$html .= '</tr>';
										$table[] = $html;
									}
								}
							}
						}

						if (count($sub_table) > 0) {
							$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $taxes_sub_group['name'] . '</td>';
							if (count($getMonthsInRange) > 0) {
								$month_total = 0;
								foreach ($getMonthsInRange as $res_month) {
									$html .= '<td align="right" class="bold_text">' . $sub_ledger_total[$res_month['date']] . '</td>';
									$month_total += $sub_ledger_total[$res_month['date']];
									if (empty($ledger_total[$res_month['date']]))
										$ledger_total[$res_month['date']] = 0;
									$ledger_total[$res_month['date']] += $sub_ledger_total[$res_month['date']];
								}
								if ($month_total < 0)
									$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
								else
									$month_total_amount = number_format($month_total, 2);
								$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
							}
							$html .= '</tr>';
							$table[] = $html;
						}
					}
				}
			}
			$html = '';
			$html = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_taxes_group['name'] . '</td>';
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$html .= '<td align="right" class="bold_text">' . $ledger_total[$res_month['date']] . '</td>';
					$month_total += $ledger_total[$res_month['date']];
				}
				if ($total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
				$html .= '<td align="right" class="bold_text">' . $month_total_amount . '</td>';
			}
			$html .= '</tr>';
			$table[] = $html;
			$html = '';
			$taxes_total = $ledger_total;


			// Total Profit //

			$final_profit_total = array();
			if (count($getMonthsInRange) > 0) {
				$month_total = 0;
				foreach ($getMonthsInRange as $res_month) {
					$cur_total = $net_profit_total[$res_month['date']] - $taxes_total[$res_month['date']];
					if ($cur_total < 0)
						$cur_total_amount = "( " . number_format(abs($cur_total), 2) . " )";
					else
						$cur_total_amount = number_format($cur_total, 2);
					$month_total += $cur_total;
					$final_profit_total[$res_month['date']] = $cur_total;
				}
				if ($month_total < 0)
					$month_total_amount = "( " . number_format(abs($month_total), 2) . " )";
				else
					$month_total_amount = number_format($month_total, 2);
			}
			if (count($final_profit_total) > 0) {
				$month_total = 0;
				foreach ($final_profit_total as $fpt) {
					$profit += $fpt;
				}
			}
			$html = '';


		} else {

			$getMonthsInRange = array();
			$bd_colspan = 1;
			$from_date = $sdate;
			$to_date = $edate;

			// Sales //

			$top_sales_group = $this->db->table("groups")->where('code', 4000)->get()->getRowArray();
			$sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_sales_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_sales_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_sales_group['name'] . '</td><td></td></tr>';
			if (count($sales_groups) > 0) {
				foreach ($sales_groups as $sales_group) {
					$group_id = $sales_group['group_id'];
					$total = $sales_group['cr_total'] - $sales_group['dr_total'];
					$top_sales_group_total += $total;
					$ledgercode = $sales_group['left_code'] . '/' . $sales_group['right_code'];
					$ledgername = $sales_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($sales_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$sales_sub_groups_total = 0;
						foreach ($sales_sub_groups as $sales_sub_group) {
							$total = $sales_sub_group['cr_total'] - $sales_sub_group['dr_total'];
							$sales_sub_groups_total += $total;
							$ledgercode = $sales_sub_group['left_code'] . '/' . $sales_sub_group['right_code'];
							$ledgername = $sales_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($sales_sub_groups_total < 0)
							$sales_sub_groups_total_amount = "( " . number_format(abs($sales_sub_groups_total), 2) . " )";
						else
							$sales_sub_groups_total_amount = number_format($sales_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $sales_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $sales_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($sales_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$sales_sub_sub_groups_total = 0;
								foreach ($sales_sub_sub_groups as $sales_sub_sub_group) {
									$total = $sales_sub_sub_group['cr_total'] - $sales_sub_sub_group['dr_total'];
									$sales_sub_sub_groups_total += $total;
									$ledgercode = $sales_sub_sub_group['left_code'] . '/' . $sales_sub_sub_group['right_code'];
									$ledgername = $sales_sub_sub_group['ledger_name'];
									if ($sales_sub_sub_groups_total < 0)
										$sales_sub_sub_groups_total_amount = "( " . number_format(abs($sales_sub_sub_groups_total), 2) . " )";
									else
										$sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($sales_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($sales_sub_sub_groups_total < 0)
									$sales_sub_sub_groups_total_amount = "( " . number_format(abs($sales_sub_sub_groups_total), 2) . " )";
								else
									$sales_sub_sub_groups_total_amount = number_format($sales_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $sales_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $sales_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_sales_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_sales_group_total_amount = "( " . number_format(abs($top_sales_group_total), 2) . " )";
			else
				$top_sales_group_total_amount = number_format($top_sales_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_sales_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_sales_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Cost of Sales //

			$top_co_sales_group = $this->db->table("groups")->where('code', 5000)->get()->getRowArray();
			$co_sales_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_co_sales_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_co_sales_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_co_sales_group['name'] . '</td><td></td></tr>';
			if (count($co_sales_groups) > 0) {
				foreach ($co_sales_groups as $co_sales_group) {
					$group_id = $co_sales_group['group_id'];
					$total = $co_sales_group['dr_total'] - $co_sales_group['cr_total'];
					$top_co_sales_group_total += $total;
					$ledgercode = $co_sales_group['left_code'] . '/' . $co_sales_group['right_code'];
					$ledgername = $co_sales_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_co_sales_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$co_sales_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($co_sales_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$co_sales_sub_groups_total = 0;
						foreach ($co_sales_sub_groups as $co_sales_sub_group) {
							$total = $co_sales_sub_group['dr_total'] - $co_sales_sub_group['cr_total'];
							$co_sales_sub_groups_total += $total;
							$ledgercode = $co_sales_sub_group['left_code'] . '/' . $co_sales_sub_group['right_code'];
							$ledgername = $co_sales_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($co_sales_sub_groups_total < 0)
							$co_sales_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_groups_total), 2) . " )";
						else
							$co_sales_sub_groups_total_amount = number_format($co_sales_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $co_sales_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $co_sales_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$co_sales_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($co_sales_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$co_sales_sub_sub_groups_total = 0;
								foreach ($co_sales_sub_sub_groups as $co_sales_sub_sub_group) {
									$total = $co_sales_sub_sub_group['dr_total'] - $co_sales_sub_sub_group['cr_total'];
									$co_sales_sub_sub_groups_total += $total;
									$ledgercode = $co_sales_sub_sub_group['left_code'] . '/' . $co_sales_sub_sub_group['right_code'];
									$ledgername = $co_sales_sub_sub_group['ledger_name'];
									if ($co_sales_sub_sub_groups_total < 0)
										$co_sales_sub_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_sub_groups_total), 2) . " )";
									else
										$co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($co_sales_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($co_sales_sub_sub_groups_total < 0)
									$co_sales_sub_sub_groups_total_amount = "( " . number_format(abs($co_sales_sub_sub_groups_total), 2) . " )";
								else
									$co_sales_sub_sub_groups_total_amount = number_format($co_sales_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $co_sales_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $co_sales_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_co_sales_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_co_sales_group_total_amount = "( " . number_format(abs($top_co_sales_group_total), 2) . " )";
			else
				$top_co_sales_group_total_amount = number_format($top_co_sales_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_co_sales_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_co_sales_group_total_amount . '</td>';
			$table[] .= '</tr>';
			$gross_profit = $top_sales_group_total - $top_co_sales_group_total;

			if ($gross_profit < 0) {
				$gross_profit_amount = "( " . number_format(abs($gross_profit), 2) . " )";
				$gross_profit_txt = 'Gross Loss';
			} else {
				$gross_profit_amount = number_format($gross_profit, 2);
				$gross_profit_txt = 'Gross Profit';
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $gross_profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $gross_profit_amount . '</td>';
			$table[] .= '</tr>';

			// Incomes

			$top_incomes_group = $this->db->table("groups")->where('code', 8000)->get()->getRowArray();
			$incomes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_incomes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_incomes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_incomes_group['name'] . '</td><td></td></tr>';
			if (count($incomes_groups) > 0) {
				foreach ($incomes_groups as $incomes_group) {
					$group_id = $incomes_group['group_id'];
					$total = $incomes_group['cr_total'] - $incomes_group['dr_total'];
					$top_incomes_group_total += $total;
					$ledgercode = $incomes_group['left_code'] . '/' . $incomes_group['right_code'];
					$ledgername = $incomes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_incomes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$incomes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($incomes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$incomes_sub_groups_total = 0;
						foreach ($incomes_sub_groups as $incomes_sub_group) {
							$total = $incomes_sub_group['cr_total'] - $incomes_sub_group['dr_total'];
							$incomes_sub_groups_total += $total;
							$ledgercode = $incomes_sub_group['left_code'] . '/' . $incomes_sub_group['right_code'];
							$ledgername = $incomes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($incomes_sub_groups_total < 0)
							$incomes_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_groups_total), 2) . " )";
						else
							$incomes_sub_groups_total_amount = number_format($incomes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $incomes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $incomes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$incomes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($incomes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$incomes_sub_sub_groups_total = 0;
								foreach ($incomes_sub_sub_groups as $incomes_sub_sub_group) {
									$total = $incomes_sub_sub_group['cr_total'] - $incomes_sub_sub_group['dr_total'];
									$incomes_sub_sub_groups_total += $total;
									$ledgercode = $incomes_sub_sub_group['left_code'] . '/' . $incomes_sub_sub_group['right_code'];
									$ledgername = $incomes_sub_sub_group['ledger_name'];
									if ($incomes_sub_sub_groups_total < 0)
										$incomes_sub_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_sub_groups_total), 2) . " )";
									else
										$incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($incomes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($incomes_sub_sub_groups_total < 0)
									$incomes_sub_sub_groups_total_amount = "( " . number_format(abs($incomes_sub_sub_groups_total), 2) . " )";
								else
									$incomes_sub_sub_groups_total_amount = number_format($incomes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $incomes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $incomes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_incomes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_incomes_group_total_amount = "( " . number_format(abs($top_incomes_group_total), 2) . " )";
			else
				$top_incomes_group_total_amount = number_format($top_incomes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_incomes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_incomes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Expenses

			$top_expenes_group = $this->db->table("groups")->where('code', 6000)->get()->getRowArray();
			$expenes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_expenes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_expenes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_expenes_group['name'] . '</td><td></td></tr>';
			if (count($expenes_groups) > 0) {
				foreach ($expenes_groups as $expenes_group) {
					$group_id = $expenes_group['group_id'];
					$total = $expenes_group['dr_total'] - $expenes_group['cr_total'];
					$top_expenes_group_total += $total;
					$ledgercode = $expenes_group['left_code'] . '/' . $expenes_group['right_code'];
					$ledgername = $expenes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_expenes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$expenes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($expenes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['name'] . '</td><td></td></tr>';
						$expenes_sub_groups_total = 0;
						foreach ($expenes_sub_groups as $expenes_sub_group) {
							$total = $expenes_sub_group['dr_total'] - $expenes_sub_group['cr_total'];
							$expenes_sub_groups_total += $total;
							$ledgercode = $expenes_sub_group['left_code'] . '/' . $expenes_sub_group['right_code'];
							$ledgername = $expenes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($expenes_sub_groups_total < 0)
							$expenes_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_groups_total), 2) . " )";
						else
							$expenes_sub_groups_total_amount = number_format($expenes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['name'] . '</td><td>' . $expenes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $expenes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$expenes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($expenes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['name'] . '</td><td></td></tr>';
								$expenes_sub_sub_groups_total = 0;
								foreach ($expenes_sub_sub_groups as $expenes_sub_sub_group) {
									$total = $expenes_sub_sub_group['dr_total'] - $expenes_sub_sub_group['cr_total'];
									$expenes_sub_sub_groups_total += $total;
									$ledgercode = $expenes_sub_sub_group['left_code'] . '/' . $expenes_sub_sub_group['right_code'];
									$ledgername = $expenes_sub_sub_group['ledger_name'];
									if ($expenes_sub_sub_groups_total < 0)
										$expenes_sub_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_sub_groups_total), 2) . " )";
									else
										$expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($expenes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($expenes_sub_sub_groups_total < 0)
									$expenes_sub_sub_groups_total_amount = "( " . number_format(abs($expenes_sub_sub_groups_total), 2) . " )";
								else
									$expenes_sub_sub_groups_total_amount = number_format($expenes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['name'] . '</td><td>' . $expenes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $expenes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_expenes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_expenes_group_total_amount = "( " . number_format(abs($top_expenes_group_total), 2) . " )";
			else
				$top_expenes_group_total_amount = number_format($top_expenes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_expenes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_expenes_group_total_amount . '</td>';
			$table[] .= '</tr>';

			// Net Profit

			$net_profit = $gross_profit + $top_incomes_group_total - $top_expenes_group_total;

			if ($net_profit < 0) {
				$net_profit_amount = "( " . number_format(abs($net_profit), 2) . " )";
				$net_profit_txt = "Net Loss";
			} else {
				$net_profit_amount = number_format($net_profit, 2);
				$net_profit_txt = "Net Profit";
			}

			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">' . $net_profit_txt . '</td>';
			$table[] .= '<td align="right" >' . $net_profit_amount . '</td>';
			$table[] .= '</tr>';

			// Taxation

			$top_taxes_group = $this->db->table("groups")->where('code', 9000)->get()->getRowArray();
			$taxes_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = " . $top_taxes_group['id'] . " and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
			$top_taxes_group_total = 0;
			$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_0 level_groups">' . $top_taxes_group['name'] . '</td><td></td></tr>';
			if (count($taxes_groups) > 0) {
				foreach ($taxes_groups as $taxes_group) {
					$group_id = $taxes_group['group_id'];
					$total = $taxes_group['dr_total'] - $taxes_group['cr_total'];
					$top_taxes_group_total += $total;
					$ledgercode = $taxes_group['left_code'] . '/' . $taxes_group['right_code'];
					$ledgername = $taxes_group['ledger_name'];
					if ($total < 0)
						$total_amount = "( " . number_format(abs($total), 2) . " )";
					else
						$total_amount = number_format($total, 2);
					$table[] .= '<tr>
									<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
					$table[] .= '<td align="right" >' . $total_amount . '</td>';
					$table[] .= '</tr>';
				}
			}
			$list_sub_groups = $this->db->table("groups")->where('parent_id', $top_taxes_group['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (count($list_sub_groups) > 0) {
				$list_sub_groups_total = 0;
				foreach ($list_sub_groups as $list_sub_group) {
					$sub_group_id = $list_sub_group['id'];
					$taxes_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
					if (count($taxes_sub_groups) > 0) {
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_1 level_groups">' . $list_sub_group['group_name'] . '</td><td></td></tr>';
						$taxes_sub_groups_total = 0;
						foreach ($taxes_sub_groups as $taxes_sub_group) {
							$total = $taxes_sub_group['dr_total'] - $taxes_sub_group['cr_total'];
							$taxes_sub_groups_total += $total;
							$ledgercode = $taxes_sub_group['left_code'] . '/' . $taxes_sub_group['right_code'];
							$ledgername = $taxes_sub_group['ledger_name'];
							if ($total < 0)
								$total_amount = "( " . number_format(abs($total), 2) . " )";
							else
								$total_amount = number_format($total, 2);
							$table[] .= '<tr>
											<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
							$table[] .= '<td align="right" >' . $total_amount . '</td>';
							$table[] .= '</tr>';
						}
						if ($taxes_sub_groups_total < 0)
							$taxes_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_groups_total), 2) . " )";
						else
							$taxes_sub_groups_total_amount = number_format($taxes_sub_groups_total, 2);
						$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_group['group_name'] . '</td><td>' . $taxes_sub_groups_total_amount . '</td></tr>';
						$list_sub_groups_total += $taxes_sub_groups_total;
					}
					$list_sub_sub_groups = $this->db->table("groups")->where('parent_id', $sub_group_id)->orderBy('code', 'ASC')->get()->getResultArray();
					$list_sub_sub_groups_total = 0;
					if (count($list_sub_sub_groups) > 0) {
						foreach ($list_sub_sub_groups as $list_sub_sub_group) {
							$sub_sub_group_id = $list_sub_sub_group['id'];
							$taxes_sub_sub_groups = $this->db->query("select ei.ledger_id, l.name as ledger_name, l.left_code, l.right_code, l.group_id, g.name as group_name, COALESCE(sum(if(ei.dc = 'C', amount, 0)), 0) as cr_total, COALESCE(sum(if(ei.dc = 'D', amount, 0)), 0) as dr_total from ledgers l left join groups g on g.id = l.group_id left join entryitems ei on ei.ledger_id = l.id left join entries e on e.id = ei.entry_id where g.id = $sub_sub_group_id and e.date >= '$from_date' and e.date <= '$to_date'$whr GROUP BY ei.ledger_id order by l.left_code, l.right_code ASC")->getResultArray();
							if (count($taxes_sub_sub_groups) > 0) {
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_2 level_groups">' . $list_sub_sub_group['group_name'] . '</td><td></td></tr>';
								$taxes_sub_sub_groups_total = 0;
								foreach ($taxes_sub_sub_groups as $taxes_sub_sub_group) {
									$total = $taxes_sub_sub_group['dr_total'] - $taxes_sub_sub_group['cr_total'];
									$taxes_sub_sub_groups_total += $total;
									$ledgercode = $taxes_sub_sub_group['left_code'] . '/' . $taxes_sub_sub_group['right_code'];
									$ledgername = $taxes_sub_sub_group['ledger_name'];
									if ($taxes_sub_sub_groups_total < 0)
										$taxes_sub_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_sub_groups_total), 2) . " )";
									else
										$taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total, 2);
									$table[] .= '<tr>
													<td class="level_ledger">(' . $ledgercode . ')' . $ledgername . '</td>';
									$table[] .= '<td align="right" >' . number_format($taxes_sub_sub_groups_total_amount, "2", ".", ",") . '</td>';
									$table[] .= '</tr>';
								}
								if ($taxes_sub_sub_groups_total < 0)
									$taxes_sub_sub_groups_total_amount = "( " . number_format(abs($taxes_sub_sub_groups_total), 2) . " )";
								else
									$taxes_sub_sub_groups_total_amount = number_format($taxes_sub_sub_groups_total, 2);
								$table[] = '<tr><td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $list_sub_sub_group['group_name'] . '</td><td>' . $taxes_sub_sub_groups_total_amount . '</td></tr>';
								$list_sub_sub_groups_total += $taxes_sub_sub_groups_total;
							}
						}
					}
					$list_sub_groups_total += $list_sub_sub_groups_total;
				}
				$top_taxes_group_total += $list_sub_groups_total;
			}
			if ($total < 0)
				$top_taxes_group_total_amount = "( " . number_format(abs($top_taxes_group_total), 2) . " )";
			else
				$top_taxes_group_total_amount = number_format($top_taxes_group_total, 2);
			$table[] .= '<tr>
							<td style="font-weight: bold;font-size: medium;" class="level_total level_groups">Total ' . $top_taxes_group['name'] . '</td>';
			$table[] .= '<td align="right" >' . $top_taxes_group_total_amount . '</td>';
			$table[] .= '</tr>';
			$profit = $net_profit - $top_taxes_group_total;
		}

		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['smonthdate'] = $smonthdate;
		$data['emonthdate'] = $emonthdate;
		$data['breakdown'] = !empty($breakdown) ? $breakdown : 'daily';
		$data['getMonthsInRange'] = $getMonthsInRange;
		$data['bd_colspan'] = $bd_colspan;
		$data['fund_id'] = $fund_id;
		if ($profit >= 0)
			$data['profit'] = 'Total Profit Amount is ' . number_format($profit, '2', '.', ',');
		else {
			$neg = $profit * -1;
			$data['profit'] = 'Total Loss Amount is ' . number_format($neg, '2', '.', ',');
		}
		$data['table'] = $table;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();

		if ($breakdown == 'daily') {
			$file_name = "Income and Expenditure Statement_" . $data['sdate'] . "_to_" . $data['edate'];
		} else {
			$file_name = "Income and Expenditure Statement_" . $data['smonthdate'] . "_to_" . $data['emonthdate'];
		}
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$dompdf->loadHtml(view('account/pdf/print_profit_loss', ["pdfdata" => $data]));
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream($file_name);
	}
	public function ledgers_name_list()
	{

		if (!$this->model->permission_validate('ledgers_name_list_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}

		$id = 3;

		$data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();

		echo view('account_report/ledgers_name_list', $data);

	}
	public function account_group_list()
	{

		if (!$this->model->permission_validate('account_group_list_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
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
		foreach ($group as $row) {
			$res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
			if (count($res) > 0) {
				foreach ($res as $dd) {
					$led_id = $dd['id'];
					$op_bal = !empty($dd['op_balance']) ? $dd['op_balance'] : 0;
					$debitamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$debitamt_tot = $debitamt['amount'];
					$creditamt_tot = $creditamt['amount'];
					if ($debitamt_tot > $creditamt_tot) {
						$datas_income[$led_id]['DR'][] = ($debitamt_tot + $op_bal) - $creditamt_tot;
					} else {
						$datas_income[$led_id]['CR'][] = ($creditamt_tot - $op_bal) - $debitamt_tot;
					}
				}
			}
		}
		//print_r($datas_income);
		foreach ($datas_income as $key => $row2) {
			if (!empty($row2["CR"])) {
				$ac_lb_data['dr_amount'] = "0.00";
				$ac_lb_data['cr_amount'] = abs($row2["CR"][0]);
			}
			if (!empty($row2["DR"])) {
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

	public function trail_balance_new()
	{
		if (!$this->model->list_validate('trial_balance_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$fund_where = '';
		// if(!empty($fund_id)) $fund_where = " and entries.fund_id = '$fund_id'";
		//echo $sdate; echo $tdate;die;
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by code asc');
		//$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
		$parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach ($parentgroup as $row) {
			//print_r($row['id']);
			/*$datas[] = '<tr>
							<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
					   </tr>';*/
			$presult = $this->db->table('ledgers')->where('group_id', $row['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance_amt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if (!empty($op_balance['dr_amount']) || !empty($op_balance['cr_amount'])) {
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
					} else
						$op_bal = 0;
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$d_amt = $this->db->query($d_sql)->getRowArray();
					$c_amt = $this->db->query($c_sql)->getRowArray();
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					$tab_credit = $tab_debit = 0;
					if ($clbal < 0)
						$tab_credit = abs($clbal);
					else
						$tab_debit = $clbal;
					if (!empty($tab_debit) || !empty($tab_credit)) {
						$datas[] = '<tr>
                                    <td>' . $ledgercode . '</td>
                                    <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a>
                                    </td>
                                    <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                    <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                </tr>';
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $tab_debit;
					$totalcre += $tab_credit;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$crow['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance_amt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$op_bal = $op_balance_amt;
						$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if ($clbal < 0)
							$tab_credit = abs($clbal);
						else
							$tab_debit = $clbal;
						if (!empty($tab_debit) || !empty($tab_credit)) {
							$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                        </tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->orderBy('code', 'ASC')->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
						/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$ccg['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt -= $op_balance['cr_amount'];
							} else {
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if ($clbal < 0)
								$tab_credit = abs($clbal);
							else
								$tab_debit = $clbal;
							if (!empty($tab_debit) || !empty($tab_credit)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
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
                    <td align="right">' . number_format($totaldeb, '2', '.', '') . '</td>
                    <td align="right">' . number_format($totalcre, '2', '.', '') . '</td>
                    </tr></tfoot>';
		$data['sdate'] = $sdate;
		$data['tdate'] = $tdate;
		$data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		// $data['fund_id'] = $fund_id;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/trail_balance_new', $data);
		echo view('template/footer');
	}

public function trail_balance_newcopy()
	{
		if (!$this->model->list_validate('trial_balance_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('trial_balance_accounts');
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$fund_where = '';
		// if(!empty($fund_id)) $fund_where = " and entries.fund_id = '$fund_id'";
		//echo $sdate; echo $tdate;die;
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by code asc');
		//$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
		$parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach ($parentgroup as $row) {
			//print_r($row['id']);
			/*$datas[] = '<tr>
							<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
					   </tr>';*/
			$presult = $this->db->table('ledgers')->where('group_id', $row['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance_amt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if (!empty($op_balance['dr_amount']) || !empty($op_balance['cr_amount'])) {
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
					} else
						$op_bal = 0;
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$d_amt = $this->db->query($d_sql)->getRowArray();
					$c_amt = $this->db->query($c_sql)->getRowArray();
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					$tab_credit = $tab_debit = 0;
					if ($clbal < 0)
						$tab_credit = abs($clbal);
					else
						$tab_debit = $clbal;
					if (!empty($tab_debit) || !empty($tab_credit)) {
						$datas[] = '<tr>
                                    <td>' . $ledgercode . '</td>
                                    <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a>
                                    </td>
                                    <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                    <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                </tr>';
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $tab_debit;
					$totalcre += $tab_credit;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$crow['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance_amt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$op_bal = $op_balance_amt;
						$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if ($clbal < 0)
							$tab_credit = abs($clbal);
						else
							$tab_debit = $clbal;
						if (!empty($tab_debit) || !empty($tab_credit)) {
							$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                        </tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->orderBy('code', 'ASC')->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
						/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$ccg['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt -= $op_balance['cr_amount'];
							} else {
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if ($clbal < 0)
								$tab_credit = abs($clbal);
							else
								$tab_debit = $clbal;
							if (!empty($tab_debit) || !empty($tab_credit)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td><a href="#" style="" id="' . $dd['id'] . '" onclick="ledger_report(' . $dd['id'] . ')">' . $ledgername . '</a></td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
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
                    <td align="right">' . number_format($totaldeb, '2', '.', '') . '</td>
                    <td align="right">' . number_format($totalcre, '2', '.', '') . '</td>
                    </tr></tfoot>';
		$data['sdate'] = $sdate;
		$data['tdate'] = $tdate;
		$data['list'] = $datas;
		$data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		// $data['fund_id'] = $fund_id;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account_report/trail_balance_newcopy', $data);
		echo view('template/footer');
	}
	public function pdf_trial_balance_new()
	{
		if (!$this->model->permission_validate('trial_balance_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);

		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$fund_where = '';
		// if(!empty($fund_id)) $fund_where = " and entries.fund_id = '$fund_id'";
		//echo $sdate; echo $tdate;die;
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by code asc');
		//$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
		$parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach ($parentgroup as $row) {
			//print_r($row['id']);
			/*$datas[] = '<tr>
							<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
					   </tr>';*/
			$presult = $this->db->table('ledgers')->where('group_id', $row['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance_amt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if (!empty($op_balance['dr_amount']) || !empty($op_balance['cr_amount'])) {
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
					} else
						$op_bal = 0;
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$d_amt = $this->db->query($d_sql)->getRowArray();
					$c_amt = $this->db->query($c_sql)->getRowArray();
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					$tab_credit = $tab_debit = 0;
					if ($clbal < 0)
						$tab_credit = abs($clbal);
					else
						$tab_debit = $clbal;
					if (!empty($tab_debit) || !empty($tab_credit)) {
						$datas[] = '<tr>
                                    <td>' . $ledgercode . '</td>
                                    <td>' . $ledgername . '
                                    </td>
                                    <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                    <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                </tr>';
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $tab_debit;
					$totalcre += $tab_credit;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$crow['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance_amt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$op_bal = $op_balance_amt;
						$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if ($clbal < 0)
							$tab_credit = abs($clbal);
						else
							$tab_debit = $clbal;
						if (!empty($tab_debit) || !empty($tab_credit)) {
							$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td>' . $ledgername . '</td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                        </tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->orderBy('code', 'ASC')->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
						/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$ccg['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt -= $op_balance['cr_amount'];
							} else {
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if ($clbal < 0)
								$tab_credit = abs($clbal);
							else
								$tab_debit = $clbal;
							if (!empty($tab_debit) || !empty($tab_credit)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td>' . $ledgername . '</td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
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
                    <td align="right">' . number_format($totaldeb, '2', '.', '') . '</td>
                    <td align="right">' . number_format($totalcre, '2', '.', '') . '</td>
                    </tr></tfoot>';

		$data['list'] = $datas;
		$file_name = "Trial Balance" . $data['fdate'] . "_to_" . $data['tdate'];
		$dompdf = new \Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set(array('isRemoteEnabled' => true));
		$dompdf->setOptions($options);
		$dompdf->loadHtml(view('account_report/pdf_trial_balance_new', ["pdfdata" => $data]));
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($file_name);
	}

	public function print_trial_balance_new()
	{
		if (!$this->model->permission_validate('trial_balance_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);

		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : 1);
		$fund_where = '';
		// if(!empty($fund_id)) $fund_where = " and entries.fund_id = '$fund_id'";
		//echo $sdate; echo $tdate;die;
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by code asc');
		//$query = $this->db->table('groups')->where('parent_id is NULL')->get()->getResultArray();
		$parentgroup = $query->getResultArray();
		//echo '<pre>';
		//print_r($data);die;
		$datas = array();
		foreach ($parentgroup as $row) {
			//print_r($row['id']);
			/*$datas[] = '<tr>
							<td>'.$row['name'].'</td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
							<td>-</td>
					   </tr>';*/
			$presult = $this->db->table('ledgers')->where('group_id', $row['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance_amt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if (!empty($op_balance['dr_amount']) || !empty($op_balance['cr_amount'])) {
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
					} else
						$op_bal = 0;
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$d_amt = $this->db->query($d_sql)->getRowArray();
					$c_amt = $this->db->query($c_sql)->getRowArray();
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					$tab_credit = $tab_debit = 0;
					if ($clbal < 0)
						$tab_credit = abs($clbal);
					else
						$tab_debit = $clbal;
					if (!empty($tab_debit) || !empty($tab_credit)) {
						$datas[] = '<tr>
                                    <td>' . $ledgercode . '</td>
                                    <td>' . $ledgername . '
                                    </td>
                                    <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                    <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                </tr>';
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $tab_debit;
					$totalcre += $tab_credit;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$crow['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance_amt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$op_bal = $op_balance_amt;
						$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if ($clbal < 0)
							$tab_credit = abs($clbal);
						else
							$tab_debit = $clbal;
						if (!empty($tab_debit) || !empty($tab_credit)) {
							$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td>' . $ledgername . '</td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
                                        </tr>';
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->orderBy('code', 'ASC')->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
						/*$datas[] = '<tr>
								<td>&emsp;&emsp;'.$ccg['name'].'</td>
								<td>Group</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
						</tr>';*/
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt -= $op_balance['cr_amount'];
							} else {
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if ($clbal < 0)
								$tab_credit = abs($clbal);
							else
								$tab_debit = $clbal;
							if (!empty($tab_debit) || !empty($tab_credit)) {
								$datas[] = '<tr>
                                            <td>' . $ledgercode . '</td>
                                            <td>' . $ledgername . '</td>
                                            <td align="right">' . number_format($tab_debit, '2', '.', ',') . '</td>
                                            <td align="right">' . number_format($tab_credit, '2', '.', ',') . '</td>
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
                    <td align="right">' . number_format($totaldeb, '2', '.', '') . '</td>
                    <td align="right">' . number_format($totalcre, '2', '.', '') . '</td>
                    </tr></tfoot>';

		$data['list'] = $datas;
		echo view('account_report/print_trial_balance_new', $data);
	}
	public function excel_trial_balance_new()
	{
		if (!$this->model->permission_validate('trial_balance_accounts', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		//print_r($_POST);
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date("Y-m-01");
		if ($_POST['tdate'])
			$tdate = $_POST['tdate'];
		else
			$tdate = date("Y-m-d");
		// $fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : '');
		$fund_where = '';
		// if(!empty($fund_id)) $fund_where = " and entries.fund_id = '$fund_id'";
		$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL or parent_id = 0 order by id asc');
		//$query = $this->db->query('select * from groups where parent_id = "" or parent_id is NULL order by id asc');
		$parentgroup = $query->getResultArray();
		$data = array();
		$datas = array();
		foreach ($parentgroup as $row) {
			$presult = $this->db->table('ledgers')->where('group_id', $row['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
			if (!empty($presult)) {
				foreach ($presult as $dd) {
					$id = $dd['id'];
					$ledgername = get_ledger_name_only($id);
					$ledgercode = get_ledger_code_only($id);
					$debitamt = 0;
					$creditamt = 0;
					$op_bal = 0;
					$op_balance_amt = 0;
					$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
					if (!empty($op_balance['dr_amount']) || !empty($op_balance['cr_amount'])) {
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
					} else
						$op_bal = 0;
					$op_bal = $op_balance_amt;
					$d_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$c_sql = "select sum(entryitems.amount) as amount 
                                            from entryitems 
                                            inner join entries on entries.id = entryitems. entry_id
                                            where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
					$d_amt = $this->db->query($d_sql)->getRowArray();
					$c_amt = $this->db->query($c_sql)->getRowArray();
					$debitamt = $d_amt['amount'];
					$creditamt = $c_amt['amount'];
					$clbal = ($op_bal + $debitamt) - $creditamt;
					$tab_credit = $tab_debit = 0;
					if ($clbal < 0)
						$tab_credit = abs($clbal);
					else
						$tab_debit = $clbal;
					if (!empty($tab_debit) || !empty($tab_credit)) {
						$data[] = array(
							"ledgercode" => $ledgercode,
							"ledgername" => $ledgername,
							"debitamt" => number_format($tab_debit, '2', '.', ''),
							"creditamt" => number_format($tab_credit, '2', '.', '')
						);
					}
					$totalopb += $op_balance_amt;
					$totaldeb += $tab_debit;
					$totalcre += $tab_credit;
					$totalclb += $clbal;
				}
			}
			$childgroup = $this->db->table('groups')->where('parent_id', $row['id'])->orderBy('code', 'ASC')->get()->getResultArray();
			if (!empty($childgroup)) {
				foreach ($childgroup as $crow) {
					$res = $this->db->table('ledgers')->where('group_id', $crow['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
					foreach ($res as $dd) {
						$id = $dd['id'];
						$ledgername = get_ledger_name_only($id);
						$ledgercode = get_ledger_code_only($id);
						$debitamt = 0;
						$creditamt = 0;
						$op_bal = 0;
						$op_balance_amt = 0;
						$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
						if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
							$op_balance_amt -= $op_balance['cr_amount'];
						} else {
							$op_balance_amt += $op_balance['dr_amount'];
						}
						$op_bal = $op_balance_amt;
						$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
						$d_amt = $this->db->query($d_sql)->getRowArray();
						$c_amt = $this->db->query($c_sql)->getRowArray();
						$debitamt = $d_amt['amount'];
						$creditamt = $c_amt['amount'];
						$clbal = ($op_bal + $debitamt) - $creditamt;
						$tab_credit = $tab_debit = 0;
						if ($clbal < 0)
							$tab_credit = abs($clbal);
						else
							$tab_debit = $clbal;
						if (!empty($tab_debit) || !empty($tab_credit)) {
							$data[] = array(
								"ledgercode" => $ledgercode,
								"ledgername" => $ledgername,
								"debitamt" => number_format($tab_debit, '2', '.', ''),
								"creditamt" => number_format($tab_credit, '2', '.', '')
							);
						}
						$totalopb += $op_balance_amt;
						$totaldeb += $tab_debit;
						$totalcre += $tab_credit;
						$totalclb += $clbal;
					}
					$cgroup = $this->db->table('groups')->where('parent_id', $crow['id'])->orderBy('code', 'ASC')->get()->getResultArray();
					foreach ($cgroup as $ccg) {
						$cgchild = $this->db->table('ledgers')->where('group_id', $ccg['id'])->orderBy('left_code', 'ASC')->orderBy('right_code', 'ASC')->get()->getResultArray();
						foreach ($cgchild as $dd) {
							$id = $dd['id'];
							$ledgername = get_ledger_name_only($id);
							$ledgercode = get_ledger_code_only($id);
							$debitamt = 0;
							$creditamt = 0;
							$op_bal = 0;
							$op_balance_amt = 0;
							$op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
							if ($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "") {
								$op_balance_amt -= $op_balance['cr_amount'];
							} else {
								$op_balance_amt += $op_balance['dr_amount'];
							}
							$op_bal = $op_balance_amt;
							$d_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'D' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$c_sql = "select sum(entryitems.amount) as amount 
                                                    from entryitems 
                                                    inner join entries on entries.id = entryitems. entry_id
                                                    where entryitems.dc = 'C' and entryitems.ledger_id = $id and entries.date <= '$tdate'$fund_where";
							$d_amt = $this->db->query($d_sql)->getRowArray();
							$c_amt = $this->db->query($c_sql)->getRowArray();
							$debitamt = $d_amt['amount'];
							$creditamt = $c_amt['amount'];
							$clbal = ($op_bal + $debitamt) - $creditamt;
							$tab_credit = $tab_debit = 0;
							if ($clbal < 0)
								$tab_credit = abs($clbal);
							else
								$tab_debit = $clbal;
							if (!empty($tab_debit) || !empty($tab_credit)) {
								$data[] = array(
									"ledgercode" => $ledgercode,
									"ledgername" => $ledgername,
									"debitamt" => number_format($tab_debit, '2', '.', ''),
									"creditamt" => number_format($tab_credit, '2', '.', '')
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
		}

		$datas = array(
			"Total" => "Total",
			"totaldeb" => number_format($totaldeb, '2', '.', ''),
			"totalcre" => number_format($totalcre, '2', '.', '')
		);
		$fileName = "trial_balance_" . $sdate . "_to_" . $tdate;
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
		foreach ($data as $val) {
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
		$writer->save('uploads/excel/' . $fileName . '.xlsx');
		return $this->response->download('uploads/excel/' . $fileName . '.xlsx', null)->setFileName($fileName . '.xlsx');
	}







	public function profile_loss1()
	{
		if (!$this->model->list_validate('profit_and_loss_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('profit_and_loss_accounts');
		//var_dump($_POST);
		// exit;
		if ($_POST['sdate'])
			$sdate = $_POST['sdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['edate'])
			$edate = $_POST['edate'];
		else
			$edate = date('Y-m-d');
		$fund_id = (!empty($_POST['fund_id']) ? $_POST['fund_id'] : '');
		//echo $job_code; //die;
		$table = array();
		$data = array();
		$datas = array();
		$total_income = 0;
		$total_expenses = 0;
		// Income List
		$id = [27, 28, 29];  // direct income, indirect income and sales account group id
		//$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
		$res = $this->db->table('groups')->where('parent_id', 26)->get()->getResultArray();
		$subincome_array = array();
		foreach ($res as $row) {
			$subincome_array[$row['name']] = $row['id'];
		}
		$main_incomes['Income'] = "26";
		$income_array = array_merge($main_incomes, $subincome_array);
		//var_dump($income_array);
		//exit;
		foreach ($income_array as $key => $row) {
			$led_list = $this->db->table("ledgers")->where('group_id', $row)->get()->getResultArray();
			foreach ($led_list as $led) {
				$led_bd = $this->db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entryitems.ledger_id', $led['id'])
					->where('entries.date >=', $sdate)
					->where('entries.date <=', $edate);
				if (!empty($fund_id))
					$led_bd = $led_bd->where('entries.fund_id', $fund_id);
				$led_res = $led_bd->select('entryitems.*')
					->select('entries.date')
					->get()
					->getResultArray();
				$total_dr = 0;
				$total_cr = 0;
				foreach ($led_res as $dr) {
					if (is_numeric($dr['amount']) == true) {
						if (!empty($dr['amount']))
							$amount = $dr['amount'];
						else
							$amount = 0;

						if ($dr['dc'] == 'D')
							$total_dr += $amount;
						if ($dr['dc'] == 'C')
							$total_cr += $amount;
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
		if (count($data)) {
			foreach ($data as $key => $val) {
				$table[] = '<tr><td style="font-weight: bold;font-size: medium;">' . $key . '</td><td></td><tr>';
				foreach ($val as $sub_key => $sub_val) {
					if ($sub_key != "Income") {
						$sub_total_income = get_profit_loss_subtotal($sub_val);
						if ($sub_total_income > 0) {
							$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;' . $sub_key . '</td><td></td><tr>';
						}
					}
					foreach ($sub_val as $skey => $sval) {
						foreach ($sval as $name => $amt) {
							if (!empty($amt)) {
								$ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
								$table[] .= '<tr><td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' . $ledgername . '</td><td align="right" >' . number_format($amt, "2", ".", ",") . '</td><tr>';
							}
							$total_income += $amt;
						}
					}
				}
			}
		} else {
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Income</td><td></td><tr>';
		}
		$table[] .= '<tr><td>Total Income</td><td align="right" >' . number_format($total_income, "2", ".", ",") . '</td><tr>';

		// Expenses 
		// Direct expenses in staff  id 38
		$id = [31, 45];
		//$res = $this->db->table('groups')->whereIn('id', $id)->get()->getResultArray();
		$res = $this->db->table('groups')->where('parent_id', 30)->get()->getResultArray();
		//echo '<pre>'; print_r($res);die;
		$subexpense_array = array();
		foreach ($res as $row) {
			$subexpense_array[$row['name']] = $row['id'];
		}
		$main_expenses['Expenses'] = "30";
		$expense_array = array_merge($main_expenses, $subexpense_array);
		foreach ($expense_array as $key => $row) {
			$led_list = $this->db->table("ledgers")->where('group_id', $row)->get()->getResultArray();
			foreach ($led_list as $led) {
				$led_bd = $this->db->table('entryitems', 'entries')
					->join('entries', 'entries.id = entryitems.entry_id')
					->where('entryitems.ledger_id', $led['id'])
					->where('entries.date >=', $sdate)
					->where('entries.date <=', $edate);
				if (!empty($fund_id))
					$led_bd = $led_bd->where('entries.fund_id', $fund_id);
				$led_res = $led_bd->select('entryitems.*')
					->select('entries.date')
					->get()
					->getResultArray();
				$total_dr = 0;
				$total_cr = 0;
				foreach ($led_res as $dr) {
					if (is_numeric($dr['amount']) == true) {
						if (!empty($dr['amount']))
							$amount = $dr['amount'];
						else
							$amount = 0;

						if ($dr['dc'] == 'D')
							$total_dr += $amount;
						if ($dr['dc'] == 'C')
							$total_cr += $amount;
					}
				}
				$fin_amt = $total_dr - $total_cr;
				$led_name = $led['id'];
				$datas['Expenses'][$key][] = array(
					"$led_name" => $fin_amt
				);
			}
		}
		if (count($datas)) {
			foreach ($datas as $key => $val) {
				$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">' . $key . '</td><td></td><tr>';
				foreach ($val as $sub_key => $sub_val) {
					if ($sub_key != "Expenses") {
						$sub_total_expenses = get_profit_loss_subtotal($sub_val);
						if ($sub_total_expenses > 0) {
							$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;' . $sub_key . '</td><td></td><tr>';
						}
					}
					foreach ($sub_val as $skey => $sval) {
						foreach ($sval as $name => $amt) {
							if (!empty($amt)) {
								$ledgername = get_ledger_name_only($name);
								$ledgercode = get_ledger_code_only($name);
								$table[] .= '<tr><td>&emsp;&emsp;&emsp;(' . $ledgercode . ')' . $ledgername . '</td><td align="right" >' . number_format($amt, "2", ".", ",") . '</td><tr>';
							}
							$total_expenses += $amt;
						}
					}
				}
			}
		} else {
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">Expenses</td><td></td><tr>';
			$table[] .= '<tr><td style="font-weight: bold;font-size: medium;">&emsp;&emsp;Direct Expenses</td><td></td><tr>';
		}
		$table[] .= '<tr><td>Total Expenses</td><td align="right" >' . number_format($total_expenses, "2", ".", ",") . '</td><tr>';

		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['fund_id'] = $fund_id;
		$profit = $total_income - $total_expenses;
		if ($profit >= 0)
			$data['profit'] = 'Total Profit Amount is ' . number_format($profit, '2', '.', ',');
		else {
			$neg = $profit * -1;
			$data['profit'] = 'Total Loss Amount is ' . number_format($neg, '2', '.', ',');
		}
		$data['table'] = $table;
		$data['funds'] = $this->db->table("funds")->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/profitloss1', $data);
		echo view('template/footer');
	}

	public function receipt_payment()
	{
		if (!$this->model->list_validate('receipt_payment_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}

		$data['permission'] = $this->model->get_permission('receipt_payment_accounts');
		if ($_POST['sdate'])
			$sdate = $_POST['sdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['edate'])
			$edate = $_POST['edate'];
		else
			$edate = date('Y-m-d');

		$receipts = $this->db->query("SELECT l.left_code,l.right_code,ledger_id, l.name as ledger_name, COALESCE(sum(amount), 0) as amount FROM entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.entrytype_id = 1 and dc = 'C' and e.date >= '$sdate' and e.date <= '$edate' group by ledger_id ")->getResultArray();

		$payments = $this->db->query("SELECT l.left_code,l.right_code,ledger_id, l.name as ledger_name, COALESCE(sum(amount), 0) as amount FROM entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.entrytype_id = 2 and dc = 'D' and e.date >= '$sdate' and e.date <= '$edate' group by ledger_id ")->getResultArray();
		$table = array();
		$data = array();
		$total_receipt = 0;
		$total_payment = 0;
		$type_id = !empty($_POST['type_id']) ? $_POST['type_id'] : 3;

		$table[] = '<tr>';
		if (count($receipts) > 0 && $type_id == 1) {
			$table[] .= '<td style="font-weight: bold;font-size: medium;height: 100%;padding: 0 !important;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($receipts as $rec_row) {
				$total_receipt = $total_receipt + $rec_row['amount'];
				$table[] .= '<tr>
												<td>[' . $rec_row['left_code'] . '-' . $rec_row['right_code'] . '] ' . $rec_row['ledger_name'] . '</td>
												<td align="right">' . $rec_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
		} else if (count($payments) > 0 && $type_id == 2) {
			$table[] .= '<td style="font-weight: bold;font-size: medium;padding: 0 !important;vertical-align: top;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($payments as $pay_row) {
				$total_payment = $total_payment + $pay_row['amount'];
				$table[] .= '<tr>
												<td>[' . $pay_row['left_code'] . '-' . $pay_row['right_code'] . '] ' . $pay_row['ledger_name'] . '</td>
												<td align="right">' . $pay_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
		} else if (count($receipts) > 0 && count($payments) > 0 && $type_id == 3) {
			$table[] .= '<td style="font-weight: bold;font-size: medium;padding: 0 !important;height: 100%;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($receipts as $rec_row) {
				$total_receipt = $total_receipt + $rec_row['amount'];
				$table[] .= '<tr>
												<td>[' . $rec_row['left_code'] . '-' . $rec_row['right_code'] . '] ' . $rec_row['ledger_name'] . '</td>
												<td align="right">' . $rec_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
			$table[] .= '<td style="font-weight: bold;font-size: medium;padding: 0 !important;vertical-align: top;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($payments as $pay_row) {
				$total_payment = $total_payment + $pay_row['amount'];
				$table[] .= '<tr>
												<td>[' . $pay_row['left_code'] . '-' . $pay_row['right_code'] . '] ' . $pay_row['ledger_name'] . '</td>
												<td align="right">' . $pay_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
		} else {
			$table[] .= '<td colspan="2">No Records Found</td>';
		}
		$table[] .= '</tr>';

		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['type_id'] = $type_id;
		$data['total_receipt'] = $total_receipt;
		$data['total_payment'] = $total_payment;
		$data['table'] = $table;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/receipt_payment', $data);
		echo view('template/footer');
	}

	public function print_receipt_payment()
	{
		if (!$this->model->list_validate('receipt_payment_accounts')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('receipt_payment_accounts');
		if ($_POST['fdate'])
			$sdate = $_POST['fdate'];
		else
			$sdate = date('Y-m-01');
		if ($_POST['tdate'])
			$edate = $_POST['tdate'];
		else
			$edate = date('Y-m-d');

		$receipts = $this->db->query("SELECT l.left_code,l.right_code,ledger_id, l.name as ledger_name, COALESCE(sum(amount), 0) as amount FROM entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.entrytype_id = 1 and dc = 'C' and e.date >= '$sdate' and e.date <= '$edate' group by ledger_id ")->getResultArray();

		$payments = $this->db->query("SELECT l.left_code,l.right_code,ledger_id, l.name as ledger_name, COALESCE(sum(amount), 0) as amount FROM entryitems ei left join entries e on e.id = ei.entry_id left join ledgers l on l.id = ei.ledger_id where e.entrytype_id = 2 and dc = 'D' and e.date >= '$sdate' and e.date <= '$edate' group by ledger_id ")->getResultArray();
		$table = array();
		$data = array();
		$total_receipt = 0;
		$total_payment = 0;
		$type_id = !empty($_POST['ptype_id']) ? $_POST['ptype_id'] : 3;

		$table[] = '<tr>';
		if (count($receipts) > 0 && $type_id == 1) {
			$table[] .= '<td style="font-weight: bold;font-size: medium;height: 100%;padding:0;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($receipts as $rec_row) {
				$total_receipt = $total_receipt + $rec_row['amount'];
				$table[] .= '<tr>
												<td>[' . $rec_row['left_code'] . '-' . $rec_row['right_code'] . '] ' . $rec_row['ledger_name'] . '</td>
												<td align="right">' . $rec_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
		} else if (count($payments) > 0 && $type_id == 2) {
			$table[] .= '<td style="font-weight: bold;font-size: medium;padding:0;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($payments as $pay_row) {
				$total_payment = $total_payment + $pay_row['amount'];
				$table[] .= '<tr>
												<td>[' . $pay_row['left_code'] . '-' . $pay_row['right_code'] . '] ' . $pay_row['ledger_name'] . '</td>
												<td align="right">' . $pay_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
		} else if (count($receipts) > 0 && count($payments) > 0 && $type_id == 3) {
			$table[] .= '<td style="font-weight: bold;font-size: medium;padding:0 !important;height: 100%;vertical-align: top;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($receipts as $rec_row) {
				$total_receipt = $total_receipt + $rec_row['amount'];
				$table[] .= '<tr>
												<td>[' . $rec_row['left_code'] . '-' . $rec_row['right_code'] . '] ' . $rec_row['ledger_name'] . '</td>
												<td align="right">' . $rec_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
			$table[] .= '<td style="font-weight: bold;font-size: medium;vertical-align: top;padding:0;">
							<table style="width:100%;" border="1" class="table1">';
			foreach ($payments as $pay_row) {
				$total_payment = $total_payment + $pay_row['amount'];
				$table[] .= '<tr>
												<td>[' . $pay_row['left_code'] . '-' . $pay_row['right_code'] . '] ' . $pay_row['ledger_name'] . '</td>
												<td align="right">' . $pay_row['amount'] . '</td>
											</tr>';
			}
			$table[] .= '</table></td>';
		} else {
			$table[] .= '<td colspan="2">No Records Found</td>';
		}
		$table[] .= '</tr>';

		$data['sdate'] = $sdate;
		$data['edate'] = $edate;
		$data['type_id'] = $type_id;
		$data['total_receipt'] = $total_receipt;
		$data['total_payment'] = $total_payment;
		$data['table'] = $table;
		echo view('account/print_receipt_payment', $data);
	}

}