<?php
function get_ledger_name($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		if (!empty($tot_groups['code']))
			$name = $tot_groups['code'] . " - " . $tot_groups['name'];
		else {
			$name = '';
			if (!empty($tot_groups['left_code'])) {
				$name .= $tot_groups['left_code'];
				$name .= '/';
				if (!empty($tot_groups['right_code']))
					$name .= $tot_groups['right_code'];
			}
			$name .= " - " . $tot_groups['name'];
		}
	}
	return $name;
}
function get_ledger_name_only($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		if (!empty($tot_groups['name'])) {
			$name = $tot_groups['name'];
		} else {
			$name = "";
		}
	}
	return $name;
}
function get_ledger_code_only($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		$name = '';
		if (!empty($tot_groups['left_code'])) {
			$name .= $tot_groups['left_code'];
		}
		$name .= '/';
		if (!empty($tot_groups['right_code'])) {
			$name .= $tot_groups['right_code'];
		}
	}
	return $name;
}
function total_group_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$sub_tot = 0;
	$tot_groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($tot_groups) {
		foreach ($tot_groups as $tr) {
			$sub_tot += get_group_amt_new_rightcode_triplezero($tr->id, $sdate, $tdate);
		}
	}
	return $sub_tot;
}
function get_group_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
function total_group_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$sub_tot = 0;
	$tot_groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($tot_groups) {
		foreach ($tot_groups as $tr) {
			$sub_tot += get_group_amt_new_rightcode_triplezero_previousyear($tr->id, $sdate, $tdate);
		}
	}
	return $sub_tot;
}

function loanperiodendmonths($emi_start_month_paytype_two, $emi_type_paytype_two)
{
	$data_emi_start_month = date("Y-m-01", strtotime($emi_start_month_paytype_two));
	if (!empty($emi_type_paytype_two)) {
		$emi_dedection_one_month = $emi_type_paytype_two - 1;
		$data_emi_end_month = date("Y-m-t", strtotime("+$emi_dedection_one_month months", strtotime($data_emi_start_month)));
	} else {
		$data_emi_end_month = date("Y-m-t", strtotime($emi_start_month_paytype_two));
	}
	return $data_emi_end_month;
}
function get_group_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_previousyear($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_previousyear($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero_previousyear($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
function get_ledgers_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			$op_balance += $op_balance_amt;
		}
	}
	return $op_balance;
}
function get_ledger_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	// $op = $db->table('ledgers')->where('id', $id)->get()->getRow();
	// $ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	// $op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	// if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
	// $op_balance_amt = $op_balance_new['cr_amount'];
	// } else {
	// $op_balance_amt = $op_balance_new['dr_amount'];
	// }
	// $op_balance += $op_balance_amt;
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_op_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	/* echo $op->name;
	   echo '<br>';
	   echo get_ledger_op_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	   echo '<br>';
	   echo get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	   echo '<br>';
	   echo get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate, $fund_id);
	   echo '<br>'; */
	return $op_balance;
}
function get_ledger_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$builder = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id']);
	// if (!empty ($fund_id))
	// $builder->where('fund_id', $fund_id);
	$op_balance_new = $builder->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt -= $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	return $op_balance;
}
function get_ledgers_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			//$op_balance += $op_balance_amt;
			$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledger_op_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			/* echo $op->name;
					 echo '<br>';
					 echo get_ledger_op_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
					 echo '<br>';
					 echo get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
					 echo '<br>';
					 echo get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate, $fund_id);
					 echo '<br>'; */
		}
	}
	return $op_balance;
}
// this function not required but subtotal without zero check plus and minus included
function get_ledger_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$builder = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id']);
	// if (!empty ($fund_id))
	// $builder->where('fund_id', $fund_id);
	$op_balance_new = $builder->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt = $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	return $op_balance;
}
function get_group_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero_subtotal($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
function get_ledgers_amt_new_rightcode_triplezero_subtotal($id, $sdate = '', $tdate = '')
{ // this function not required but subtotal without zero check plus and minus included
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			$op_balance += $op_balance_amt;
			$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
		}
	}
	return $op_balance;
}
function get_ledger_op_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$fund_where = '';
	$op_balance_amt = 0;
	if (!empty($led_ids)) {
		$led_ids_arr = explode(',', $led_ids);
		foreach ($led_ids_arr as $ld) {
			$builder = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id']);
			// if (!empty ($fund_id))
			// $builder->where('fund_id', $fund_id);
			$op_balance_new = $builder->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt -= $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt += $op_balance_new['dr_amount'];
			}
		}
	}
	return $op_balance_amt;
}
function get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	$fund_where = '';
	// if (!empty ($fund_id))
	// $fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($led_ids)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($c_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$cr_amount = $res['amount'];
	} else {
		$cr_amount = 0;
	}
	return $cr_amount;
}
function get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	$fund_where = '';
	// if (!empty ($fund_id))
	// $fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($led_ids)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($d_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$dr_amount = $res['amount'];
	} else {
		$dr_amount = 0;
	}
	return $dr_amount;
}
function get_ledger_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$builder = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id']);
	// if (!empty ($fund_id))
	// $builder->where('fund_id', $fund_id);
	$op_balance_new = $builder->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt -= $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt += $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate);
	return $op_balance;
}
function get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$fund_where = '';
	// if (!empty ($fund_id))
	// $fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($id)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($c_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$cr_amount = $res['amount'];
	} else {
		$cr_amount = 0;
	}
	return $cr_amount;
}
function get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$fund_where = '';
	// if (!empty ($fund_id))
	// $fund_where = " and entries.fund_id = '$fund_id'";
	if (!empty($id)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'$fund_where";
		$res = $db->query($d_sql)->getRowArray();
	} else {
		$res = 0;
	}
	if (!empty($res['amount'])) {
		$dr_amount = $res['amount'];
	} else {
		$dr_amount = 0;
	}
	return $dr_amount;
}
function get_ledger_ids_leftcode($id)
{
	$db = db_connect();
	$led_da = $db->table("ledgers")->where('id', $id)->get()->getRowArray();
	$left_code = $led_da['left_code'];
	if (!empty($left_code)) {
		$ledger_ids = $db->query("select id from ledgers where id IN (select id from ledgers where left_code = $left_code)")->getResultArray();
	} else {
		$ledger_ids = array();
	}
	$array_ledgerids = array();
	if (count($ledger_ids) > 0) {
		foreach ($ledger_ids as $ledger_id) {
			$array_ledgerids[] = $ledger_id['id'];
		}
	}
	$ledger_ids_implode = implode(',', $array_ledgerids);
	return $ledger_ids_implode;
}

function get_profit_loss_subtotal($sub_val = array())
{
	$subtotal_income = 0;
	foreach ($sub_val as $sval) {
		foreach ($sval as $amt) {
			$subtotal_income += $amt;
		}
	}
	return $subtotal_income;
}
function get_consolidate_profit_loss_subtotal($sub_val = array())
{
	$subtotal_income = 0;
	foreach ($sub_val as $sval) {
		foreach ($sval as $amt) {
			$subtotal_income += array_sum($amt);
		}
	}
	return $subtotal_income;
}
function get_ledger_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '')
{ // this function not required but subtotal without zero check plus and minus included
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt = $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	return $op_balance;
}
function get_group_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	@$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate, $tdate);
	$groups = $db->table('groups')->where('parent_id', $id)->get()->getResult();
	if ($groups) {
		foreach ($groups as $r) {
			$group_amt += get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($r->id, $sdate, $tdate);
			get_group_amt_new_rightcode_triplezero_subtotal_multiplejobcode($r->id, $sdate, $tdate);
		}
	}
	return $group_amt;
}
// this function not required but subtotal without zero check plus and minus included
function get_ledgers_amt_new_rightcode_triplezero_subtotal_multiplejobcode($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$op_balance = 0;
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_list = $db->table('ledgers')->where('group_id', $id)->where('right_code', '000')->get()->getResult();
	if ($op_list) {
		foreach ($op_list as $op) {
			$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $op->id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
			if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
				$op_balance_amt = $op_balance_new['cr_amount'];
			} else {
				$op_balance_amt = $op_balance_new['dr_amount'];
			}
			$op_balance += $op_balance_amt;
			$op_balance += get_ledgers_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledgers_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
		}
	}
	return $op_balance;
}
function archanai_charts()
{
	$jan = archanai_monthwise_count($month = "01");
	$feb = archanai_monthwise_count($month = "02");
	$mar = archanai_monthwise_count($month = "03");
	$apr = archanai_monthwise_count($month = "04");
	$may = archanai_monthwise_count($month = "05");
	$jun = archanai_monthwise_count($month = "06");
	$jul = archanai_monthwise_count($month = "07");
	$aug = archanai_monthwise_count($month = "08");
	$sep = archanai_monthwise_count($month = "09");
	$oct = archanai_monthwise_count($month = "10");
	$nov = archanai_monthwise_count($month = "11");
	$dec = archanai_monthwise_count($month = "12");
	$rtn_arry = array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec);
	return json_encode($rtn_arry);
}
function archanai_monthwise_count($month)
{
	$db = db_connect();
	$current_year = date('Y');
	$archanai_charts = $db->query("SELECT COUNT(id) AS count FROM archanai_booking where YEAR(date) = $current_year AND MONTH(date) = $month ")->getResultArray();
	if (count($archanai_charts) > 0) {
		$countdata = intVal($archanai_charts[0]['count']);
	} else {
		$countdata = 0;
	}
	return $countdata;
}
// function hallbooking_charts()
// {
// 	$jan = hallbooking_monthwise_count($month = "01");
// 	$feb = hallbooking_monthwise_count($month = "02");
// 	$mar = hallbooking_monthwise_count($month = "03");
// 	$apr = hallbooking_monthwise_count($month = "04");
// 	$may = hallbooking_monthwise_count($month = "05");
// 	$jun = hallbooking_monthwise_count($month = "06");
// 	$jul = hallbooking_monthwise_count($month = "07");
// 	$aug = hallbooking_monthwise_count($month = "08");
// 	$sep = hallbooking_monthwise_count($month = "09");
// 	$oct = hallbooking_monthwise_count($month = "10");
// 	$nov = hallbooking_monthwise_count($month = "11");
// 	$dec = hallbooking_monthwise_count($month = "12");
// 	$rtn_arry = array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec);
// 	return json_encode($rtn_arry);
// }


function archanai_booking_range($from_date = '', $to_date = '', $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($from_date))
		$where .= " and b.date >= '$from_date'";
	if (!empty($to_date))
		$where .= " and b.date <= '$to_date'";
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select l.name as counter_name, b.date, a.archanai_id, a.archanai_booking_id, 
	sum(a.quantity) as qty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, 
	count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode 
	else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id 
	left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join login l on b.entry_by = l.id 
	where (b.payment_status not in(1,3) or b.payment_status is NULL)
	$where group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0 order by b.date asc");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
				}

			}

			$archanai_data[] = array(
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"paymentmode" => $paymentname,
				"counter_name" => $row['counter_name'],
				"paid_through" => $row['paid_through'],
				"date" => $row['date'],
				"qty" => $row['qty'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}






// function hallbooking_monthwise_count($month)
// {
// 	$db = db_connect();
// 	$current_year = date('Y');
// 	//$hallbooking_charts = $db->query("SELECT COUNT(id) AS count FROM hall_booking where YEAR(booking_date) = $current_year AND MONTH(booking_date) = $month ")->getResultArray();
// 	if (count($hallbooking_charts) > 0) {
// 		$countdata = intVal($hallbooking_charts[0]['count']);
// 	} else {
// 		$countdata = 0;
// 	}
// 	return $countdata;
// }
function send_mail_with_content($to_mail, $message = array(), $subject, $temple_title = "")
{
	$email = \Config\Services::email();
	$to_mails = $to_mail;
	$mail_count = count($to_mails);
	for ($i = 0; $i < $mail_count; $i++) {
		$mail_id = TRIM($to_mails[$i]);
		//echo $mail_id;
		$email->setTo($mail_id);
		$email->setFrom('templetest@grasp.com.my', $temple_title);
		$email->setSubject($subject);
		$email->setMessage($message);
		$email->send();
	}
}
function qrcode_generation($qr_id, $url, $height = 190, $width = 190)
{
	if (!empty($qr_id)) {
		$qr_url = "https://chart.googleapis.com/chart?cht=qr&chl=" . $url . "?id=" . $qr_id . "&chs=" . $width . "x" . $height . "&chld=L|0";
		return $qr_url;
	}

}
function get_checklist_availablity($date, $id)
{
	$db = db_connect();
	$res = $db->table("hall_booking")->select("id, name")->where("booking_date", $date)->where("status<>", 3)->get()->getResultArray();
	$data_time = array();
	$i = 0;  //echo '<pre>';
	foreach ($res as $r) {
		$ds = $db->table("hall_booking_service_details")->select("checklist_id")->where("hall_booking_id", $r['id'])->get()->getResultArray();
		foreach ($ds as $rr) {
			if (!empty($rr)) {
				$data_time[] = $rr['checklist_id'];
			}
		}
	}
	$tot_checklists = $db->table('checklist')
		->join('booking_addonn_service', 'booking_addonn_service.service_id = checklist.service_id')
		->select('checklist.*')
		->where('booking_addonn_service.id', $id)
		->get()
		->getResultArray();
	$data = array("checklists" => $tot_checklists, "availabilty" => $data_time);
	return $data;
}
function daily_archanai_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
				}
				$paymentname = $row['payment_mode'];
			}

			$archanai_data[] = array(
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"groupname" => $aname['groupname'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}


// function daily_archanai_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
// {
// 	$db = db_connect();
// 	$archanai_data = array();
// 	$data_direct = array();
// 	$data_counter = array();
// 	$data_online = array();
// 	$where = '';
// 	if (!empty ($booking_type))
// 		$where .= " and b.paid_through = '$booking_type'";
// 	if (!empty ($login_id))
// 		$where .= " and b.entry_by = '$login_id'";
// 	$query = $db->query("select a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
// 	$res2 = $query->getResultArray();
// 	if (count($res2)) {
// 		foreach ($res2 as $row) {
// 			$paymentname = '';
// 			$total = $row['amt'] + $row['comm'];
// 			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
// 			if ($row['paid_through'] == 'DIRECT') {
// 				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
// 				$paymentname = $payment_mode['name'];
// 			} else {
// 				if ($row['payment_mode'] == "ipay_merch_qr") {
// 					$paymentname = "QR PAYMENT";
// 				} elseif ($row['payment_mode'] == "ipay_merch_online") {
// 					$paymentname = "ONLINE PAYMENT";
// 				} elseif ($row['payment_mode'] == "cash") {
// 					$paymentname = "CASH";
// 				}
// 				$paymentname = $row['payment_mode'];
// 			}

// 			$archanai_data[] = array(
// 				"name_in_english" => $aname['name_eng'],
// 				"name_in_tamil" => $aname['name_tamil'],
// 				"groupname" => $aname['groupname'],
// 				"paymentmode" => $paymentname,
// 				"paid_through" => $row['paid_through'],
// 				"qty" => $row['qunty'],
// 				"amount" => $total
// 			);
// 		}
// 	}
// 	return $archanai_data;
// }


function daily_group_archanai_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, ag.id as group_id, aa.groupname, aa.name_eng, aa.name_tamil, sum(a.quantity) as qunty, sum(b.discount_amount) as discount_amount, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, c.pay_method as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai aa on aa.id = a.archanai_id left join archanai_group ag on ag.name = aa.groupname where b.date >= '$current_date' and b.date <= '$current_date_two'$where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by c.pay_method, b.paid_through, a.archanai_id, ag.id having count(a.archanai_id) > 0 order by ag.order_no ASC, c.pay_method ASC");

	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				// if ($row['payment_mode'] == "qr") {
				// 	$paymentname = "QR PAYMENT";
				// } elseif ($row['payment_mode'] == "online") {
				// 	$paymentname = "ONLINE PAYMENT";
				// } elseif ($row['payment_mode'] == "cash") {
				// 	$paymentname = "CASH";
				// }
				$paymentname = $row['payment_mode'];
			}
			$archanai_data[$row['group_id']]['title'] = $row['groupname'];
			$archanai_data[$row['group_id']]['data'][] = array(
				"name_in_english" => $row['name_eng'],
				"name_in_tamil" => $row['name_tamil'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => $total,
				"discount_amount" => $row['discount_amount']
			);
		}
	}
	return $archanai_data;
}

function daily_diety_archanai_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$archanai_data = array();
	$data_direct = array();
	$data_counter = array();
	$data_online = array();
	$where = '';
	if (!empty($booking_type))
		$where .= " and b.paid_through = '$booking_type'";
	if (!empty($login_id))
		$where .= " and b.entry_by = '$login_id'";
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, a.diety_id, ad.name as diety_name, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai_diety ad on ad.id = a.diety_id where b.date >= '$current_date' and b.date <= '$current_date_two' $where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by payment_mode, b.paid_through, a.archanai_id, a.diety_id having count(a.archanai_id) > 0 order by a.diety_id");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
			$aname = $db->table('archanai')->where('id', $row['archanai_id'])->get()->getRowArray();
			if ($row['paid_through'] == 'DIRECT') {
				$payment_mode = $db->table('payment_mode')->where('id', $row['payment_mode'])->get()->getRowArray();
				$paymentname = $payment_mode['name'];
			} else {
				if ($row['payment_mode'] == "ipay_merch_qr") {
					$paymentname = "QR PAYMENT";
				} elseif ($row['payment_mode'] == "ipay_merch_online") {
					$paymentname = "ONLINE PAYMENT";
				} elseif ($row['payment_mode'] == "cash") {
					$paymentname = "CASH";
				}

			}
			$archanai_data[$row['diety_id']]['title'] = $row['diety_name'];
			$archanai_data[$row['diety_id']]['data'][] = array(
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => $total
			);
		}
	}
	return $archanai_data;
}

function daily_product_offering_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$builder = $db->table("product_offering_detail as pod")
		->join('product_offering as po', 'po.id = pod.pro_off_id', 'left')
		->join('product_category as pc', 'pc.id = pod.product_id', 'left')
		->join('offering_category as oc', 'oc.id = pod.offering_id', 'left')
		->select("po.name as customer_name, oc.name as category_name, pc.name as product_name, pod.grams, pod.value, oc.name as paymentmode")
		->where("DATE_FORMAT(po.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(po.date, '%Y-%m-%d') <=", $current_date_two);

	if (!empty($booking_type)) {
		$builder->where("po.paid_through", $booking_type);
	}
	if (!empty($login_id)) {
		$builder->where("po.added_by", $login_id);
	}

	$prasadam_data = $builder->get()->getResultArray();

	// foreach ($prasadam_data as $key => $prasadam) {
	//     $detailBuilder = $db->table('prasadam_booking_details as pbd')
	//         ->join('prasadam_setting as ps', 'ps.id = pbd.prasadam_id')
	//         ->join('ledgers as l', 'l.id = ps.ledger_id', 'left')
	//         ->select('ps.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, pbd.quantity, pbd.total_amount as amount')
	//         ->where('pbd.prasadam_booking_id', $prasadam['prasadam_id']);

	//     $products = $detailBuilder->get()->getResultArray();
	//     $prasadam_data[$key]['products'] = $products;  // Nest the products data under each prasadam
	// }

	return $prasadam_data;
}



function daily_hall_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$builder = $db->table("templebooking as tb")
		->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
		//->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
		->select("tb.id as templebooking_id, tb.total_amount as amount, tb.booking_date as date, (SELECT bpd.amount 
				FROM booked_pay_details bpd 
				WHERE bpd.booking_id = tb.id 
				ORDER BY bpd.id ASC LIMIT 1) as paidamount, (SELECT bdd.amount
                FROM booked_deposit_details bdd 
                WHERE bdd.booking_id = tb.id) as deposit, tb.name as customer_name, tb.payment_type, pm.name as paymentmode, tb.booking_through")
		->where('tb.booking_type', 1)
		->where('tb.booking_status', 1)
		->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("tb.payment_status !=", 3)
		->orWhere('tb.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$builder->where("tb.booking_through", $booking_type);
	}
	// if (!empty($login_id)) {
	// 	$builder->where("tb.added_by", $login_id);
	// }

	$ubayam_data = $builder->get()->getResultArray();

	foreach ($ubayam_data as $key => $ubayam) {
		$detailBuilder = $db->table('templebooking as tb')
			->join('booked_packages as bp', 'bp.booking_id = tb.id')
			->join('ledgers as l', 'l.id = bp.ledger_id', 'left')
			->select('bp.name as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, bp.quantity as quantity, tb.amount as amount')
			->where('tb.id', $ubayam['templebooking_id']);

		$products = $detailBuilder->get()->getResultArray();
		$ubayam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
	}

	return $ubayam_data;
}

function daily_ubayam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$builder = $db->table("templebooking as tb")
		->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
		//->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
		->select("tb.id as templebooking_id, tb.amount as amount, tb.booking_date as date, (SELECT bpd.amount 
					FROM booked_pay_details bpd 
					WHERE bpd.booking_id = tb.id 
					AND bpd.is_repayment = 0
					ORDER BY bpd.id ASC LIMIT 1) as paidamount, tb.name as customer_name, tb.payment_type, pm.name as paymentmode, tb.booking_through")
		->where('tb.booking_type', 2)
		->where('tb.booking_status', 1)
		->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(tb.entry_date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("tb.payment_status !=", 3)
		->orWhere('tb.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$builder->where("tb.booking_through", $booking_type);
	}
	if (!empty($login_id)) {
		$builder->where("tb.added_by", $login_id);
	}

	$ubayam_data = $builder->get()->getResultArray();

	foreach ($ubayam_data as $key => $ubayam) {
		$detailBuilder = $db->table('templebooking as tb')
			->join('booked_packages as bp', 'bp.booking_id = tb.id')
			->join('ledgers as l', 'l.id = bp.ledger_id', 'left')
			->select('bp.name as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, bp.quantity as quantity, tb.amount as amount')
			->where('tb.id', $ubayam['templebooking_id']);

		$products = $detailBuilder->get()->getResultArray();
		$ubayam_data[$key]['products'] = $products;  // Nest the products data under each annathanam
	}

	return $ubayam_data;
}

function daily_donation_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("donation as d")
		->join('donation_setting as ds', 'ds.id = d.pay_for')
		->join('payment_mode as pm', 'pm.id = d.payment_mode', 'left')
		->join('donation_payment_gateway_datas as dpgd', 'dpgd.donation_booking_id = d.id', 'left')
		->select("d.amount as paidamount, ds.name as package_name,d.name as person_name,(case when d.paid_through = 'DIRECT' then pm.name else dpgd.pay_method end) as paymentmode, d.paid_through");
	if (!empty($login_id))
		$builder->where("d.added_by", $login_id);
	if (!empty($booking_type))
		$builder->where("d.paid_through", $booking_type);
	$donation_data = $builder->where("DATE_FORMAT(d.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(d.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("d.payment_status", array(1, 3))
		->Orwhere('d.payment_status IS NULL')
		->groupEnd()
		->groupBy('d.id')
		->get()
		->getResultArray();
	return $donation_data;
}

function daily_prasadam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$builder = $db->table("prasadam as p")
		->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
		->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
		->select("p.id as prasadam_id, p.amount, (SELECT pbpd.amount 
					FROM prasadam_booked_pay_details pbpd 
					WHERE pbpd.prasadam_id = p.id 
					ORDER BY pbpd.id ASC LIMIT 1) as paidamount, p.customer_name, p.payment_type, (case when p.paid_through = 'DIRECT' then pm.name else ppgd.pay_method end) as paymentmode, p.paid_through")
		->where("DATE_FORMAT(p.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(p.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->where("p.payment_status !=", 3)
		->orWhere('p.payment_status IS NULL')
		->groupEnd();

	if (!empty($booking_type)) {
		$builder->where("p.paid_through", $booking_type);
	}
	if (!empty($login_id)) {
		$builder->where("p.added_by", $login_id);
	}

	$prasadam_data = $builder->get()->getResultArray();

	foreach ($prasadam_data as $key => $prasadam) {
		$detailBuilder = $db->table('prasadam_booking_details as pbd')
			->join('prasadam_setting as ps', 'ps.id = pbd.prasadam_id')
			->join('ledgers as l', 'l.id = ps.ledger_id', 'left')
			->select('ps.name_eng as package_name, l.name as ledger_name, concat(l.left_code, "-", l.right_code) as ledger_code, pbd.quantity, pbd.total_amount as amount')
			->where('pbd.prasadam_booking_id', $prasadam['prasadam_id']);

		$products = $detailBuilder->get()->getResultArray();
		$prasadam_data[$key]['products'] = $products;
	}

	return $prasadam_data;
}

function daily_payment_voucher_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("entries as e")
		->join('entryitems as ei', 'ei.entry_id = e.id')
		->select("e.dr_total as paidamount, e.id as booking_id, e.payment as paymentmode,e.paid_through, e.paid_to, e.narration,ei.details");
	if (!empty($login_id))
		$builder->where("e.entry_by", $login_id);
	if (!empty($booking_type))
		$builder->where("e.paid_through", $booking_type);
	$payment_voucher_data = $builder->where("DATE_FORMAT(e.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(e.date, '%Y-%m-%d') <=", $current_date_two)
		//->where('e.entrytype_id',2)
		->where('e.inv_id IS NULL')
		->groupBy('ei.entry_id')
		->get()
		->getResultArray();
	//$db->getLastQuery();
	return $payment_voucher_data;
}
function daily_repayment_data_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();

	$prasadamBuilder = $db->table("prasadam as p")
		->join('prasadam_booked_pay_details as pbpd', 'pbpd.prasadam_id = p.id', 'inner')
		->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
		->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
		->select("p.id as id, p.date, p.customer_name, p.amount, p.paid_amount as paidamount, pbpd.amount as repaid_amount, pbpd.paid_through, pbpd.payment_mode_title as paymentmode, 'Prasadam' as type")
		->where("pbpd.is_repayment", 1)
		->where("DATE_FORMAT(pbpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(pbpd.paid_date, '%Y-%m-%d') <=", $current_date_two);
	// ->groupStart()
	// ->where("p.payment_status !=", 3)
	// ->orWhere('p.payment_status IS NULL')
	// ->groupEnd();

	if (!empty($booking_type)) {
		$prasadamBuilder->where("pbpd.paid_through", $booking_type);
	}
	$prasadam_data = $prasadamBuilder->get()->getResultArray();

	$ubayambuilder = $db->table("templebooking as tb")
		->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
		->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
		->select("tb.id as templebooking_id, tb.amount as amount, tb.booking_date as date, tb.paid_amount as paidamount, bpd.paid_through, bpd.amount as repaid_amount, tb.name as customer_name, tb.payment_type, bpd.payment_mode_title as paymentmode, tb.booking_through, 'Ubayam' as type")
		->where("bpd.is_repayment", 1)
		->where('bpd.booking_type', 2)
		->where('bpd.pay_status', 2)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') <=", $current_date_two);
	// ->groupStart()
	// ->where("tb.payment_status !=", 3)
	// ->orWhere('tb.payment_status IS NULL')
	// ->groupEnd();

	if (!empty($booking_type)) {
		$ubayambuilder->where("bpd.paid_through", $booking_type);
	}
	$ubayam_data = $ubayambuilder->get()->getResultArray();


	$hallbuilder = $db->table("templebooking as tb")
		->join('payment_mode as pm', 'pm.id = tb.payment_mode', 'left')
		->join('booked_pay_details as bpd', 'bpd.booking_id = tb.id', 'left')
		->select("tb.id as templebooking_id, tb.amount as amount, tb.booking_date as date, tb.paid_amount as paidamount, bpd.paid_through, bpd.amount as repaid_amount, tb.name as customer_name, tb.payment_type, bpd.payment_mode_title as paymentmode, tb.booking_through, 'Hall Booking' as type")
		->where("bpd.is_repayment", 1)
		->where('bpd.booking_type', 1)
		->where('bpd.pay_status', 2)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(bpd.paid_date, '%Y-%m-%d') <=", $current_date_two);
	// ->groupStart()
	// ->where("tb.payment_status !=", 3)
	// ->orWhere('tb.payment_status IS NULL')
	// ->groupEnd();

	if (!empty($booking_type)) {
		$hallbuilder->where("bpd.paid_through", $booking_type);
	}
	$hall_data = $hallbuilder->get()->getResultArray();

	$combined_data = array_merge($hall_data, $ubayam_data, $prasadam_data);

	return $combined_data;
}
function whatsapp_aisensy($number, $message_params, $template_name = 'hall_whatsapp_api1', $media = array())
{
	$data = array();
	/* $templateParams = [
				   "Naveen",
				   "Marriage Event",
				   "23 Dec 2023",
				   "9:00am - 12:00am",
				   "2200",
				   "1500",
				   "700"
				]; */
	$templateParams = $message_params;
	// $data['apiKey'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1Njg0MGI1M2Y0NmRlMGJlMWFmYmYzNyIsIm5hbWUiOiJHUkFTUCBTT0ZUV0FSRSBTT0xVVElPTlMiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjU2ODQwYjQzZjQ2ZGUwYmUxYWZiZjMyIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE3MDEzMzExMjV9.FiR2rGZ_AAlhSfSJ08evlCHddlsjg8UQuH72sCWefx0';
	/* $data['apiKey'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1ZjgwY2ZkNjYxNmY1MGI5ZjMxYWJjOCIsIm5hbWUiOiJBUlVMTUlHVSBSQUpBTUFSSUFNTUFOIERFVkFTVEhBTkFNIiwiYXBwTmFtZSI6IkFpU2Vuc3kiLCJjbGllbnRJZCI6IjY1ZjgwY2ZkNjYxNmY1MGI5ZjMxYWJjMCIsImFjdGl2ZVBsYW4iOiJCQVNJQ19NT05USExZIiwiaWF0IjoxNzExMDkwMjk5fQ.BEn8LtNGomASZhxlQ2srvnBuDuv50VVxKnf2xkPhaBs';
	   $data['campaignName'] = $template_name;
	   $data['destination'] = $number;
	   $data['userName'] = 'wbapi@rajamariammandevasthanam.com';
	   $data['templateParams'] = $templateParams;
	   if (!empty ($media))
		   $data['media'] = $media;
	   $url = 'https://backend.aisensy.com/campaign/t1/api/v2';
	   $ch = curl_init($url);
	   # Setup request to send json via POST.
	   $payload = json_encode($data);
	   // echo $payload;
	   curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	   # Return response instead of printing.
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   # Send request.
	   $result = curl_exec($ch);
	   curl_close($ch);
	   # Print response.
	   // echo "<pre>$result</pre>";
	   return json_decode($result, true); */
	return true;
}
function sync_users_all_tag($data, $tag_id = 1)
{
	$db = db_connect();
	if (!empty($data['mobile']) && !empty($data['country_phone_code'])) {
		$user_datas = $db->table("users_all")->where('mobile', $data['mobile'])->get()->getResultArray();
		if (count($user_datas) > 0) {
			$user_id = $user_datas[0]['id'];
		} else {
			$db->table('users_all')->insert($data);
			$user_id = $db->insertID();
		}
		$tag_data = array('user_id' => $user_id, 'tag_id' => $tag_id);
		$db->table('user_tag_relation')->delete($tag_data);
		$db->table('user_tag_relation')->insert($tag_data);
	}

}
function loadstaffsalary($staffid, $paytypeid, $ded_month)
{
	$db = db_connect();
	$staff_id = $staffid;
	$paytype_id = $paytypeid;
	$month_advance_salary = 0;
	$emi_advance_salary = 0;
	$basic_pay_data = $db->table('staff')->select("*")->where('id', $staff_id)->get()->getRowArray();
	//if($paytype_id == 1){
	$deduction_month = date('Y-m', strtotime($ded_month));
	$advance_salary_monthly_data = $db->query("select sum(amount) as amount from advancesalary where staff_id = '$staff_id' and deduction_month = '$deduction_month' and type = 1 ")->getResultArray();
	if (count($advance_salary_monthly_data) > 0) {
		if ($advance_salary_monthly_data[0]['amount'] > 0) {
			$month_advance_salary = $advance_salary_monthly_data[0]['amount'];
		} else {
			$month_advance_salary = 0;
		}
	} else {
		$month_advance_salary = 0;
	}
	//}
	//if($paytype_id == 2){
	$deduction_emi = date('Y-m-01', strtotime($ded_month));
	$advance_salary_emi_data = $db->query("select COALESCE(sum(amount),0) as amount,COALESCE(emi_count,0) as emi_count from advancesalary where staff_id = $staff_id and emi_start_month <= '$deduction_emi' and emi_end_month >= '$deduction_emi' and type = 2 ")->getResultArray();
	if (count($advance_salary_emi_data) > 0) {
		if ($advance_salary_emi_data[0]['amount'] > 0) {
			$emi_advance_salary = $advance_salary_emi_data[0]['amount'];
		} else {
			$emi_advance_salary = 0;
		}
	} else {
		$emi_advance_salary = 0;
	}
	//}
	$advance_sal = $month_advance_salary + $emi_advance_salary;
	//return $deduction_emi;
	if (!empty($basic_pay_data['basic_pay'])) {
		if ($basic_pay_data['staff_type'] == 1) { // malaysian
			$epf_amount = $basic_pay_data['epf_amount'];
			$socso_amount = $basic_pay_data['socso_amount'];
			$eis_amount = $basic_pay_data['eis_amount'];
			$allowance = $basic_pay_data['allowance'];
		}
		if ($basic_pay_data['staff_type'] == 2) { //Foreigner
			$epf_amount = 0;
			$socso_amount = 0;
			$eis_amount = 0;
			$allowance = $basic_pay_data['allowance'];
		}
		$earning_amt = $allowance;
		$deduction_amt = $epf_amount + $socso_amount + $eis_amount;
		$eighty_per = $basic_pay_data['basic_pay'];
		$eight_earning_deduction = ($eighty_per + $earning_amt) - $deduction_amt;
		$remaing_amt = $eight_earning_deduction - $advance_sal;
	} else {
		$remaing_amt = 0;
	}
	return $remaing_amt;

}
function loademiamount($provision_amount, $emi_type, $amount, $pay_type)
{
	if ($pay_type == 1) {
		$re_amount = $amount;
	}
	if ($pay_type == 2) {
		if (!empty($emi_type)) {
			if (!empty($provision_amount)) {
				$chck_bf = (float) $amount + (float) $provision_amount;
				$fbf_m_a = $chck_bf / $emi_type;
				$re_amount = $fbf_m_a;
			} else {
				$chck_bf = (float) $amount;
				$fbf_m_a = $chck_bf / $emi_type;
				$re_amount = $fbf_m_a;
			}
		} else {
			$re_amount = $amount;
		}
	}
	return $re_amount;
}
function get_three_level_in_group($code)
{
	$db = db_connect();
	if (!$db) {
		throw new Exception("Failed to connect to the database.");
	}

	// Initialize arrays
	$group_array = [];
	$subgroup_array = [];
	$sub_subgroup_array = [];

	// Fetch the first level of groups
	$groups = $db->table("groups")->select('*')->whereIn('code', $code)->get();
	if (!$groups) {
		throw new Exception("Query failed while fetching groups.");
	}
	$groups = $groups->getResultArray();
	foreach ($groups as $group) {
		$group_array[] = $group['id'];
	}

	// Fetch subgroups
	if (!empty($group_array)) {
		$subgroups = $db->table("groups")->select('*')->whereIn('parent_id', $group_array)->get();
		if (!$subgroups) {
			throw new Exception("Query failed while fetching subgroups.");
		}
		$subgroups = $subgroups->getResultArray();
		foreach ($subgroups as $subgroup) {
			$subgroup_array[] = $subgroup['id'];
		}
	}

	// Fetch sub-subgroups
	if (!empty($subgroup_array)) {
		$sub_subgroups = $db->table("groups")->select('*')->whereIn('parent_id', $subgroup_array)->get();
		if (!$sub_subgroups) {
			throw new Exception("Query failed while fetching sub-subgroups.");
		}
		$sub_subgroups = $sub_subgroups->getResultArray();
		foreach ($sub_subgroups as $sub_subgroup) {
			$sub_subgroup_array[] = $sub_subgroup['id'];
		}
	}

	// Combine all levels
	$combine_array = array_merge($group_array, $subgroup_array, $sub_subgroup_array);

	return $combine_array;
}

// function get_three_level_in_group($code)
// {
// 	$db = db_connect();
// 	$groups = $db->table("groups")->select('*')->whereIn('code',$code)->get()->getResultArray();
// 	$group_array = array();
// 	foreach($groups as $group){
// 		$group_array[] = $group['id'];
// 	}

// 		$subgroups = $db->table("groups")->select('*')->whereIn('parent_id', $group_array)->get()->getResultArray();
// 		$subgroup_array = array();
// 		foreach($subgroups as $subgroup){
// 			$subgroup_array[] = $subgroup['id'];
// 		}
// 		$sub_subgroups = $db->table("groups")->select('*')->whereIn('parent_id', $subgroup_array)->get()->getResultArray();
// 		$sub_subgroup_array = array();
// 		foreach($sub_subgroups as $sub_subgroup){
// 			$sub_subgroup_array[] = $sub_subgroup['id'];
// 		}
// 		$combine_array = array_merge($group_array,$subgroup_array,$sub_subgroup_array);

// 	return $combine_array;
// }
function getMonthsInRange($startDate, $endDate)
{
	$months = array();
	while (strtotime($startDate) <= strtotime($endDate)) {
		$months[]['date'] = date('Y-m', strtotime($startDate));
		// Set date to 1 so that new month is returned as the month changes.
		$startDate = date('01 M Y', strtotime($startDate . '+ 1 month'));
	}
	return $months;
}
function cal_gregorian($yearmonth)
{
	$convert_date = $yearmonth . "-14";
	$year = date("Y", strtotime($convert_date));
	$month = date("m", strtotime($convert_date));
	$day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	return $day;
}
function getMonthsInCount($fromdate, $todate)
{

	$date1 = $fromdate;
	$date2 = $todate;

	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);

	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);

	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

	return $diff + 1;
}

if (!function_exists('changedateFormat')) {
	function changedateFormat($format = 'd-m-Y', $originalDate)
	{
		return date($format, strtotime($originalDate));
	}
}

if (!function_exists('booking_calendar_range_year')) {
	function booking_calendar_range_year($maxyear)
	{
		$current_date = date('Y-m-d');
		$end_date = date('Y-m-d', strtotime('+' . $maxyear . ' years', strtotime($current_date)));
		return $end_date;
	}
}
if (!function_exists('get_overall_temple_block_dates')) {
	function get_overall_temple_block_dates()
	{
		$db = db_connect();
		$val = array();
		$result = $db->table("overall_temple_block")->select("date")->get()->getResultArray();
		foreach ($result as $row) {
			$val[] = date("d-m-Y", strtotime($row['date']));
		}
		$response = json_encode($val);
		return $response;
	}
}
if (!function_exists('history_of_balancing')) {
	function history_of_balancing()
	{
		$db = db_connect();
		$financial_year = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$ac_year_id = $financial_year['id'];
		$sdate = $financial_year['from_year_month'] . '-01';
		$edate = date('Y-m-t', strtotime($financial_year['to_year_month'] . '-01'));
		$result = $db->query("select sum(dr_total) as dr_total, sum(cr_total) as cr_total from(SELECT COALESCE(sum(if(dr_amount != '', dr_amount, 0)), 0) as dr_total, COALESCE(sum(if(cr_amount != '', cr_amount, 0)), 0) as cr_total FROM `ac_year_ledger_balance` where ac_year_id = $ac_year_id UNION ALL SELECT COALESCE(sum(if(dc='D', amount, 0)), 0) as dr_total, COALESCE(sum(if(dc='C', amount, 0)), 0) as cr_total FROM `entryitems` where entry_id in (select id from entries where date BETWEEN '$sdate' and '$edate')) a")->getRowArray();
		return $result;
	}
}

if (!function_exists('loop_general_ledger_statement')) {
	function loop_general_ledger_statement($ledger, $fdate, $tdate)
	{
		$db = db_connect();
		if (empty($fdate) && empty($tdate)) {
			$res = $db->table('entryitems', 'entries')
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
			$res = $db->table('entryitems', 'entries')
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
		$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$op_balance = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $ledger)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
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
			$ops = $db->table('entryitems', 'entries')
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
		$data['op_bal'] = $op_bal;
		$i = 0;
		$datas = array();
		foreach ($res as $row) {
			// Ledger Name
			$getentry = $db->table('entryitems')->where('entry_id', $row['entry_id'])->get()->getResultArray();
			if ($getentry[0]['dc'] == 'D')
				$debit_name = $db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
			else
				$debit_name = $db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();

			if ($getentry[0]['dc'] == 'C')
				$credit_name = $db->table('ledgers')->where('id', $getentry[0]['ledger_id'])->get()->getRowArray();
			else
				$credit_name = $db->table('ledgers')->where('id', $getentry[1]['ledger_id'])->get()->getRowArray();

			$ledger = $debit_name['name'] . ' / Cr ' . $credit_name['name'];

			//Credit Amount
			if (!empty($row['amount']))
				$amount = $row['amount'];
			else
				$amount = 0;
			if ($row['dc'] == 'D') {
				$debit = str_replace('-0', '0', number_format($amount, '2', '.', ','));
				$debit_amount = $amount;
			} else {
				$debit = '';
				$debit_amount = 0.00;
			}

			if ($row['dc'] == 'C') {
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
		return $data;

	}
}