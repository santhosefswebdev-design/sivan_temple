<?php
function get_ledger_name($id)
{
	$db = db_connect();
	$tot_groups = $db->table('ledgers')->where('id', $id)->get()->getRowArray();
	if ($tot_groups) {
		if (!empty($tot_groups['code']))
			$name = "(" . $tot_groups['code'] . ") - " . $tot_groups['name'];
		else {
			$name = '';
			if (!empty($tot_groups['left_code'])) {
				$name .= '(';
				$name .= $tot_groups['left_code'];
				$name .= '/';
				if (!empty($tot_groups['right_code']))
					$name .= $tot_groups['right_code'];
				$name .= ')';
			}
			$name .= $tot_groups['name'];
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
	$ac_id = $db->table("ac_year")->where('status', 1)->get()->getRowArray();
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt = $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($id, $sdate, $tdate);
	return $op_balance;
}
function get_ledger_amt_new_rightcode_triplezero_previousyear($id, $sdate = '', $tdate = '')
{
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
			$op_balance += $op_balance_amt;
			$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
			$op_balance += get_ledger_dr_amt_new_rightcode_triplezero($op->id, $sdate, $tdate);
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
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
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
function get_ledger_cr_amt_new_rightcode_triplezero($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	$led_ids = get_ledger_ids_leftcode($id);
	if (!empty($led_ids)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
	if (!empty($led_ids)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id IN($led_ids) and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
	$op_balance_new = $db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id', $id)->where('ac_year_id', $ac_id['id'])->get()->getRowArray();
	if ($op_balance_new['dr_amount'] == "0.00" || $op_balance_new['dr_amount'] == "") {
		$op_balance_amt = $op_balance_new['cr_amount'];
	} else {
		$op_balance_amt = $op_balance_new['dr_amount'];
	}
	$op_balance += $op_balance_amt;
	$op_balance -= get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate);
	$op_balance += get_ledger_dr_amt_new_rightcode_triplezero_single($id, $sdate, $tdate);
	return $op_balance;
}
function get_ledger_cr_amt_new_rightcode_triplezero_single($id, $sdate = '', $tdate = '')
{
	$db = db_connect();
	if (!empty($id)) {
		$c_sql = "select sum(entryitems.amount) as amount 
				from entryitems 
				inner join entries on entries.id = entryitems. entry_id
				where entryitems.dc = 'C' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
	if (!empty($id)) {
		$d_sql = "select sum(entryitems.amount) as amount 
					from entryitems 
					inner join entries on entries.id = entryitems. entry_id
					where entryitems.dc = 'D' and entryitems.ledger_id = '$id' and entries.date >= '$sdate' and entries.date <= '$tdate'";
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
function hallbooking_charts()
{
	$jan = hallbooking_monthwise_count($month = "01");
	$feb = hallbooking_monthwise_count($month = "02");
	$mar = hallbooking_monthwise_count($month = "03");
	$apr = hallbooking_monthwise_count($month = "04");
	$may = hallbooking_monthwise_count($month = "05");
	$jun = hallbooking_monthwise_count($month = "06");
	$jul = hallbooking_monthwise_count($month = "07");
	$aug = hallbooking_monthwise_count($month = "08");
	$sep = hallbooking_monthwise_count($month = "09");
	$oct = hallbooking_monthwise_count($month = "10");
	$nov = hallbooking_monthwise_count($month = "11");
	$dec = hallbooking_monthwise_count($month = "12");
	$rtn_arry = array($jan, $feb, $mar, $apr, $may, $jun, $jul, $aug, $sep, $oct, $nov, $dec);
	return json_encode($rtn_arry);
}
function hallbooking_monthwise_count($month)
{
	$db = db_connect();
	$current_year = date('Y');
	$hallbooking_charts = $db->query("SELECT COUNT(id) AS count FROM hall_booking where YEAR(booking_date) = $current_year AND MONTH(booking_date) = $month ")->getResultArray();
	if (count($hallbooking_charts) > 0) {
		$countdata = intVal($hallbooking_charts[0]['count']);
	} else {
		$countdata = 0;
	}
	return $countdata;
}
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
	$query = $db->query("select l.name as counter_name, b.date, a.archanai_id, a.archanai_booking_id, sum(a.quantity) as qty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join login l on b.entry_by = l.id where (b.payment_status not in(1,3) or b.payment_status is NULL)$where group by payment_mode, b.paid_through, a.archanai_id having count(a.archanai_id) > 0");
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
				"amount" => number_format($total, '2', '.', ',')
			);
		}
	}
	return $archanai_data;
}



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
	$query = $db->query("select a.archanai_id, a.archanai_booking_id, ag.id as group_id, aa.groupname, aa.name_eng, aa.name_tamil, sum(a.quantity) as qunty, sum(a.total_amount) as amt, sum(a.total_commision) as comm, count(a.archanai_id) as cnt, b.paid_through, (case when b.paid_through = 'DIRECT' then b.payment_mode else c.pay_method end) as payment_mode from archanai_booking_details a left join archanai_booking b on b.id = a.archanai_booking_id left join archanai_payment_gateway_datas c on c.archanai_booking_id = b.id left join archanai aa on aa.id = a.archanai_id left join archanai_group ag on ag.name = aa.groupname where b.date >= '$current_date' and b.date <= '$current_date_two'$where and (b.payment_status not in(1,3) or b.payment_status is NULL) group by payment_mode, b.paid_through, a.archanai_id, ag.id having count(a.archanai_id) > 0 order by ag.order_no ASC");
	$res2 = $query->getResultArray();
	if (count($res2)) {
		foreach ($res2 as $row) {
			$paymentname = '';
			$total = $row['amt'] + $row['comm'];
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
			$archanai_data[$row['group_id']]['title'] = $row['groupname'];
			$archanai_data[$row['group_id']]['data'][] = array(
				"name_in_english" => $row['name_eng'],
				"name_in_tamil" => $row['name_tamil'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => $total
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

	if ($query) {
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
	} else {
		// Handle the query execution failure, log or return an error message.
		return "Error executing the query";
	}

	return $archanai_data;
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

			}

			$archanai_data[] = array(
				"name_in_english" => $aname['name_eng'],
				"name_in_tamil" => $aname['name_tamil'],
				"paymentmode" => $paymentname,
				"paid_through" => $row['paid_through'],
				"qty" => $row['qunty'],
				"amount" => number_format($total, '2', '.', ',')
			);
		}
	}
	return $archanai_data;
}
function daily_hall_booking_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	/* $builder = $db->table("hall_booking as hb")
		->join('hall_booking_pay_details as hbp', 'hbp.hall_booking_id = hb.id')
		->join('payment_mode as pm', 'pm.id = hbp.payment_mode')
		->join('hall_booking_service_details as hbd', 'hbd.hall_booking_id = hb.id')
		->join('hall_booking_payment_gateway_datas as hbpgd', 'hbpgd.hall_booking_id = hb.id', 'left')
		->select("hbp.amount as paidamount,hb.event_name, hb.name as person_name,(case when hb.paid_through = 'DIRECT' then pm.name else hbpgd.pay_method end) as paymentmode,hb.paid_through");
	if (!empty($login_id))
		$builder->where("hb.entry_by", $login_id);
	if (!empty($booking_type))
		$builder->where("hb.paid_through", $booking_type);
	$hallbooking_data = $builder->where("DATE_FORMAT(hbp.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(hbp.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("hb.payment_status", array(1, 3))
		->Orwhere('hb.payment_status IS NULL')
		->groupEnd()
		->whereIn("hb.status", array(1, 2))
		->groupBy('hb.id')
		->groupBy('hbp.payment_mode')
		->get()
		->getResultArray(); */
	$where = '';
	if (!empty($login_id)) $where .= " and hb.entry_by = $login_id";
	if (!empty($booking_type)) $where .= " and hbp.paid_through = '$booking_type'";
	$hallbooking_data = $db->query("select a.id, sum(a.paidamount) as paidamount, a.event_name, a.person_name, a.paymentmode, a.paid_through from (SELECT DISTINCT hb.id, hbp.amount as paidamount, hb.event_name, hb.name as person_name, pm.name as paymentmode, hbp.paid_through, hbp.created FROM hall_booking as hb JOIN hall_booking_pay_details as hbp ON hbp.hall_booking_id = hb.id JOIN payment_mode as pm ON pm.id = hbp.payment_mode WHERE DATE_FORMAT(hbp.date, '%Y-%m-%d') >= '$current_date' AND DATE_FORMAT(hbp.date, '%Y-%m-%d') <= '$current_date_two' AND ( hb.payment_status NOT IN (1,3) OR hb.payment_status IS NULL ) AND hb.status IN (1,2)$where) a  GROUP BY a.id, a.paymentmode")->getResultArray();
	// echo $db->getLastQuery();
	/* die; */
	return $hallbooking_data;
}
function daily_ubayam_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("ubayam as u")
		->join('ubayam_setting as us', 'us.id = u.pay_for')
		->join('ubayam_pay_details as upd', 'upd.ubayam_id = u.id', 'left')
		->join('payment_mode as pm', 'pm.id = upd.payment_mode', 'left')
		->join('ubayam_payment_gateway_datas as upgd', 'upgd.ubayam_id = u.id', 'left')
		->select("upd.amount as paidamount, us.name as package_name,u.name as person_name,(case when u.paid_through = 'DIRECT' then pm.name else upgd.pay_method end) as paymentmode, u.paid_through");
	if (!empty($login_id))
		$builder->where("u.added_by", $login_id);
	if (!empty($booking_type))
		$builder->where("u.paid_through", $booking_type);
	$ubayam_data = $builder->where("DATE_FORMAT(upd.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(upd.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("u.payment_status", array(1, 3))
		->Orwhere('u.payment_status IS NULL')
		->groupEnd()
		->groupBy('u.id')
		->get()
		->getResultArray();
	/* echo $db->getLastQuery();
		  die; */
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
		->join('prasadam_booking_details as pbd', 'pbd.prasadam_booking_id = p.id')
		->join('prasadam_setting as ps', 'ps.id = pbd.prasadam_id')
		->join('payment_mode as pm', 'pm.id = p.payment_mode', 'left')
		->join('prasadam_payment_gateway_datas as ppgd', 'ppgd.prasadam_id = p.id', 'left')
		->select("p.amount as paidamount, ps.name_eng as package_name,p.customer_name as person_name,(case when p.paid_through = 'DIRECT' then pm.name else ppgd.pay_method end) as paymentmode, p.paid_through");
	if (!empty($login_id))
		$builder->where("p.added_by", $login_id);
	if (!empty($booking_type))
		$builder->where("p.paid_through", $booking_type);
	$prasadam_data = $builder->where("DATE_FORMAT(p.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(p.date, '%Y-%m-%d') <=", $current_date_two)
		->groupStart()
		->whereNotIn("p.payment_status", array(1, 3))
		->Orwhere('p.payment_status IS NULL')
		->groupEnd()
		->groupBy('p.id')
		->get()
		->getResultArray();
	return $prasadam_data;
}
function daily_payment_voucher_withcurrentdate($current_date, $current_date_two, $booking_type = '', $login_id = '')
{
	$db = db_connect();
	$builder = $db->table("entries as e")
		->join('entryitems as ei', 'ei.entry_id = e.id')
		->select("e.dr_total as paidamount,e.payment as paymentmode,e.paid_through, e.paid_to");
	if (!empty($login_id))
		$builder->where("e.entry_by", $login_id);
	if (!empty($booking_type))
		$builder->where("e.paid_through", $booking_type);
	$payment_voucher_data = $builder->where("DATE_FORMAT(e.date, '%Y-%m-%d') >=", $current_date)
		->where("DATE_FORMAT(e.date, '%Y-%m-%d') <=", $current_date_two)
		->where('e.inv_id IS NULL')
		->groupBy('ei.entry_id')
		->get()
		->getResultArray();
	return $payment_voucher_data;
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
	$data['apiKey'] = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1Njg0MGI1M2Y0NmRlMGJlMWFmYmYzNyIsIm5hbWUiOiJHUkFTUCBTT0ZUV0FSRSBTT0xVVElPTlMiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjU2ODQwYjQzZjQ2ZGUwYmUxYWZiZjMyIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE3MDEzMzExMjV9.FiR2rGZ_AAlhSfSJ08evlCHddlsjg8UQuH72sCWefx0';
	$data['campaignName'] = $template_name;
	$data['destination'] = $number;
	$data['userName'] = 'prithivibiz004';
	$data['templateParams'] = $templateParams;
	if (!empty($media))
		$data['media'] = $media;
	$url = 'https://backend.aisensy.com/campaign/t1/api/v2';
	$ch = curl_init($url);
	# Setup request to send json via POST.
	$payload = json_encode($data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	# Return response instead of printing.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	# Send request.
	$result = curl_exec($ch);
	curl_close($ch);
	# Print response.
	//echo "<pre>$result</pre>";
	return json_decode($result, true);
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
function loadstaffsalary($staffid,$paytypeid,$ded_month)
{
	$db = db_connect();
	$staff_id = $staffid;
	$paytype_id = $paytypeid;
	$month_advance_salary = 0;
	$emi_advance_salary = 0;
	$basic_pay_data = $db->table('staff')->select("*")->where('id', $staff_id)->get()->getRowArray();
	//if($paytype_id == 1){
		$deduction_month = date('Y-m',strtotime($ded_month));
		$advance_salary_monthly_data = $db->query("select sum(amount) as amount from advancesalary where staff_id = '$staff_id' and deduction_month = '$deduction_month' and type = 1 ")->getResultArray();
		if(count($advance_salary_monthly_data) > 0){
			if($advance_salary_monthly_data[0]['amount'] > 0){
				$month_advance_salary = $advance_salary_monthly_data[0]['amount'];
			}
			else { $month_advance_salary = 0; }
		}
		else{
			$month_advance_salary = 0;
		}
	//}
	//if($paytype_id == 2){
		$deduction_emi = date('Y-m-01',strtotime($ded_month));
		$advance_salary_emi_data = $db->query("select sum(amount) as amount,emi_count from advancesalary where staff_id = $staff_id and emi_start_month <= '$deduction_emi' and emi_end_month >= '$deduction_emi' and type = 2 ")->getResultArray();
		if(count($advance_salary_emi_data) > 0){
			if($advance_salary_emi_data[0]['amount'] > 0){
				$emi_advance_salary = $advance_salary_emi_data[0]['amount'];
			}
			else { $emi_advance_salary = 0; }
		}else {  $emi_advance_salary = 0; }
	//}
	$advance_sal = $month_advance_salary + $emi_advance_salary;
	//return $deduction_emi;
	if(!empty($basic_pay_data['basic_pay'])){
		if($basic_pay_data['staff_type'] == 1){ // malaysian
			$epf_amount = $basic_pay_data['epf_amount'];
			$socso_amount = $basic_pay_data['socso_amount'];
			$eis_amount = $basic_pay_data['eis_amount'];
			$allowance = $basic_pay_data['allowance'];
		}
		if($basic_pay_data['staff_type'] == 2){ //Foreigner
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
	}
	else{
		$remaing_amt = 0;
	}
	return $remaing_amt;

}
function loademiamount($provision_amount,$emi_type,$amount,$pay_type)
{
	if($pay_type == 1){
		$re_amount 	= $amount;
	}
	if($pay_type == 2){
		if(!empty($provision_amount)){
			$chck_bf = (float)$amount + (float)$provision_amount;
			$fbf_m_a = $chck_bf / $emi_type;
			$re_amount 	= $fbf_m_a;
		}
		else{
			$chck_bf = (float)$amount;
			$fbf_m_a = $chck_bf / $emi_type;
			$re_amount 	= $fbf_m_a;
		}
	}
	return $re_amount;
}
function getpropertyTotalrentalamount($prop_id)
{
	$db = db_connect();
	$tennant_property = $db->query("SELECT tp.due_start_month,tp.end_date,p.rental_value FROM properties as p JOIN tennant_property as tp ON tp.property_id = p.id WHERE tp.property_id = $prop_id ")->getResultArray();
	$month_total_amount = 0;
	foreach($tennant_property as $row){
		$monthcount = monthcount($row['due_start_month'],$row['end_date']);
		$rental_amt = $row['rental_value'];
		$month_total_amount = $month_total_amount + ($monthcount * $rental_amt);
	}
	return $month_total_amount;
}
function getpropertyTotalrentalpaidamount($prop_id)
{
	$db = db_connect();
	$rental_property = $db->query("SELECT SUM(r.amount) as paid_amount FROM rental as r WHERE r.property_id = $prop_id ")->getResultArray();
	$rental_total_amount = 0;
	foreach($rental_property as $row){
		$rental_amt = $row['paid_amount'];
		$rental_total_amount = $rental_total_amount + $rental_amt;
	}
	return $rental_total_amount;
}
function monthcount($fromdate,$todate){

	$date1 = $fromdate;
	$date2 = $todate;

	$ts1 = strtotime($date1);
	$ts2 = strtotime($date2);

	$year1 = date('Y', $ts1);
	$year2 = date('Y', $ts2);

	$month1 = date('m', $ts1);
	$month2 = date('m', $ts2);

	$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

	return $diff+1;
}
function getpropertyduemonthcount($ten_prop_id,$prop_id)
{
	$db = db_connect();
	$propery_tennant_details = $db->query("SELECT due_start_month,id FROM tennant_property WHERE id = $ten_prop_id ")->getResultArray();
	$paid_status = 0;
	$amount_paid = 0;
	if(count($propery_tennant_details) > 0){
		foreach($propery_tennant_details as $row){
			$min_month = date("Y-m", strtotime($row['due_start_month']));
			$start_month = $min_month."-01";
			$end_month = date("Y-m-01");
			$available_till_month = getMonthsInRange($start_month,$end_month);
			$ten_prp_id = $row['id'];
			if(count($available_till_month) > 0){
				foreach($available_till_month as $res){
					$check_payment_status = $db->query("SELECT * FROM tennant_property JOIN tennant ON tennant.id = tennant_property.tennant_id JOIN rental ON rental.tenn_prop_id = tennant_property.id  WHERE rental.property_id = $prop_id and rental.tenn_prop_id = $ten_prp_id and rental.month_year = '$res' ")->getResultArray();

					if(count($check_payment_status) > 0){
					}
					else{
						$propery_renta_det = $db->query("SELECT rental_value FROM properties WHERE id = $prop_id ")->getResultArray();
						if(count($propery_renta_det) > 0){
							$propery_renta_amt = $propery_renta_det[0]['rental_value'];
						}
						else{
							$propery_renta_amt = 0;
						}
						$amount_paid = $amount_paid + $propery_renta_amt;
						$paid_status = $paid_status + 1;
					}
				}
			}
		}
	}
	return array('unpaid_count'=>$paid_status,'unpaid_amount'=>$amount_paid);
}
function getMonthsInRange($startDate, $endDate)
{
    $months = array();
    while (strtotime($startDate) <= strtotime($endDate)) {
        $months[] = date('Y-m', strtotime($startDate));
        // Set date to 1 so that new month is returned as the month changes.
        $startDate = date('01 M Y', strtotime($startDate . '+ 1 month'));
    }
    return $months;
}
function getproperty_lastpaidmonth($ten_prop_id,$prop_id)
{
	$db = db_connect();
	$current_monf = date('Y-m');
	$propery_tennant_details = $db->query("SELECT r.month_year FROM tennant_property as tp JOIN rental as r ON r.tenn_prop_id = tp.id WHERE r.property_id = $prop_id and r.tenn_prop_id = $ten_prop_id and DATE_FORMAT(tp.due_start_month,'%Y-%m') < '$current_monf' order by r.month_year DESC ")->getResultArray();
	if(count($propery_tennant_details) > 0){
		$lastpaidmonth = date("M, Y", strtotime($propery_tennant_details[0]['month_year']));
	}
	else{
		$lastpaidmonth = "";
	}
	return $lastpaidmonth;
}

function loanperiodendmonths($emi_start_month_paytype_two,$emi_type_paytype_two)
{
	$data_emi_start_month 	= date("Y-m-01", strtotime($emi_start_month_paytype_two)); 
	$emi_dedection_one_month = $emi_type_paytype_two - 1;
	$data_emi_end_month 	= date("Y-m-t", strtotime("+$emi_dedection_one_month months", strtotime($data_emi_start_month)));
	return $data_emi_end_month;
}