<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Cemeteryreg extends BaseController
{
	function __construct(){
        parent:: __construct();
        helper('url');
        $this->model = new PermissionModel();
		if( ($this->session->get('log_id_frend') ) == false && $this->session->get('role') != 99){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/member_login');
            exit;
		}
    }
    public function list() {
		$data['list'] = $this->db->table('cemetery')->where('draft_status','publish')->where('entry_by', $this->session->get('log_id_frend'))->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/cemetery/list', $data);
		//echo view('frontend/layout/footer');
    }
    public function draft_list() {
		$data['list'] = $this->db->table('cemetery')->where('payment_status',1)->where('paid_through','ONLINE')->where('draft_status','draft')->where('entry_by', $this->session->get('log_id_frend'))->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/cemetery/draft_list', $data);
		//echo view('frontend/layout/footer');
    }
	public function add() {
		$data['max'] = $this->db->table('cemetery')->select('max(num) + 1 as max_num')->get()->getRowArray();
		echo view('frontend/layout/header');
		echo view('frontend/cemetery/registeration', $data);
		//echo view('frontend/layout/footer');
    }
	public function upload_sign(){
		$data = $_POST['signature_img'];
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		$i = 0;
		while($i <= 0){
			$image_name = $this->generateRandomString(23);
			$img_path =  '/uploads/signature/' . $image_name . '.png';
			if(!file_exists(FCPATH . $img_path)) $i++;
		}
		file_put_contents(FCPATH . $img_path, $data);
		echo json_encode(array('image_url' => base_url() . $img_path));
		exit;
	}
	public function upload_app_sign(){
		$data = $_POST['signature_img1'];
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		$i = 0;
		while($i <= 0){
			$image_name = $this->generateRandomString(23);
			$img_path =  '/uploads/signature/' . $image_name . '.png';
			if(!file_exists(FCPATH . $img_path)) $i++;
		}
		file_put_contents(FCPATH . $img_path, $data);
		echo json_encode(array('image_url' => base_url() . $img_path));
		exit;
	}
	public function save_register()
	{
		//var_dump($_POST['save_drafts']);
		//exit;
		$cemetery_application_no = NULL;
		$cemetery_date = $_POST['cemetery_date']; //
		$cemetery_name_deceased = $_POST['cemetery_name_deceased']; //
		$cemetery_address = $_POST['cemetery_address']; //
		$cemetery_nationality = $_POST['cemetery_nationality']; //
		$cemetery_age = $_POST['cemetery_age']; //
		$cemetery_date_demise = $_POST['cemetery_date_demise']; //
		$cemetery_gender = $_POST['cemetery_gender']; //
		$cemetery_marital = $_POST['cemetery_marital']; //
		$nric_old = $_POST['nric_old']; //
		$nric_new = $_POST['nric_new']; //
		$occupation = $_POST['occupation']; //
		$d_certif_no = $_POST['d_certif_no']; //
		$d_certif_issue = $_POST['d_certif_issue']; //
		$d_certif_date = !empty($_POST['d_certif_date']) ? $_POST['d_certif_date'] : NULL; //
		$b_certif_no = $_POST['b_certif_no']; //
		$b_certif_issue = $_POST['b_certif_issue']; //
		$b_certif_date = !empty($_POST['b_certif_date']) ? $_POST['b_certif_date'] : NULL; //
		$cemetery_name_applicant = $_POST['cemetery_name_applicant']; //
		$app_nric_old = $_POST['app_nric_old']; //
		$app_nric_new = $_POST['app_nric_new']; //
		$cemetery_applicant_address = $_POST['cemetery_applicant_address']; //
		$cemetery_relationship_deceased = $_POST['cemetery_relationship_deceased']; //
		$app_phone = $_POST['app_phone']; //
		$exetor_of_estate = $_POST['exetor_of_estate']; //
		$nearest_relative = $_POST['nearest_relative']; //
		$signature = $_POST['signature']; //
		$management = $_POST['management']; //
		$draft_status = 'publish'; //
		//$reg_no = $_POST['reg_no'];
		//$receipt_no = $_POST['receipt_no'];
		//$ash_collect_dete = $_POST['ash_collect_dete'];
		//$ash_collect_by = $_POST['ash_collect_by'];
		//$ash_signature = $_POST['ash_signature'];
		if(!empty($_POST['save_drafts']))
		{
			if($_POST['save_drafts'] == 1)
			{
				$payment_status = 1;
				//$slot_type = NULL; //
				$draft_status = 'draft';
			}
		}
		else
		{
			$payment_status = 1;
			//$slot_type = $_POST['slot_type']; //
		}
		$slot_type = $_POST['slot_type'];
		$paid_through = "ONLINE";
		if($draft_status == 'publish'){
			$ress = $this->db->table("cemetery")->select('slot')->where("slot", $slot_type)->where("date", $cemetrydate)->where("draft_status", 'publish')->where("payment_status", 2)->get()->getResultArray();
			if(count($ress) > 0){
				$this->session->setFlashdata('succ', 'Your Selected date is already booked');
				return redirect()->to("/cemeteryreg/list");
			}
		}
		$inset_data = array(
			"num"=>$cemetery_application_no,
			"date"=>$cemetery_date,
			"name_of_deceased"=>$cemetery_name_deceased,
			"address_of_deceased"=>$cemetery_address,
			"nationality"=>$cemetery_nationality,
			"age"=>$cemetery_age,
			"date_of_demise"=>$cemetery_date_demise,
			"sex"=>$cemetery_gender,
			"marital_status"=>$cemetery_marital,
			"nric_old"=>$nric_old,
			"nric_new"=>$nric_new,
			"occupation"=>$occupation,
			"d_certif_no"=>$d_certif_no,
			"d_certif_issue"=>$d_certif_issue,
			"d_certif_date"=>$d_certif_date,
			"b_certif_no"=>$b_certif_no,
			"b_certif_issue"=>$b_certif_issue,
			"b_certif_date"=>$b_certif_date,
			"name_of_applicant"=>$cemetery_name_applicant,
			"relationship"=>$cemetery_relationship_deceased,
			"address_of_applicant"=>$cemetery_applicant_address,
			"app_nric_old"=>$app_nric_old,
			"app_nric_new"=>$app_nric_new,
			"app_phone"=>$app_phone,
			"exetor_of_estate"=>$exetor_of_estate,
			"nearest_relative"=>$nearest_relative,
			"management"=>$management,
			"signature"=>$signature,
			"slot"=>$slot_type,
			"entry_by"=>$_SESSION['log_id_frend'],
			//"reg_no"=>$reg_no,
			//"receipt_no"=>$receipt_no,
			//"ash_collect_dete"=>$ash_collect_dete,
			//"ash_collect_by"=>$ash_collect_by,
			//"ash_signature"=>$ash_signature,
			"paid_through"=>$paid_through,
			"draft_status"=>$draft_status,
			"payment_status"=>$payment_status
		);
		$cemetery_booking_slot = $this->db->table('cemetery_booking_slot')->where('id', $_POST['slot_type'])->get()->getRowArray();
		if(!empty($cemetery_booking_slot['is_special'])) $inset_data['special_time_status'] = 0;
		else  $inset_data['special_time_status'] = 1;
		$cemetery = $this->db->table('cemetery')->insert($inset_data);
		$cemetery_insert_id = $this->db->insertID();
		$cemetery_check = !empty($_POST['cemetery_check']) ? $_POST['cemetery_check'] : array();
		if(count($cemetery_check) > 0){
			foreach($cemetery_check as $key => $val){
				$items = array(
					'cemetery_id'=>$cemetery_insert_id,
					'fee_text'=>$_POST['cemetery_text'][$key],
					'fee_amount'=>$_POST['cemetery_amount'][$key]
				);
				$this->db->table('cemetery_fee_details')->insert($items);
			}
		}
		if($draft_status == 'draft'){
			return redirect()->to("/cemeteryreg/draft_list/");
		}else{
			if($inset_data['special_time_status'] == 1){
				//$this->account_migration($cemetery_insert_id);
				return redirect()->to("/IpayOnlineCemetery/payment_process1/" . $cemetery_insert_id);
			}
		}
		//$this->session->setFlashdata('succ', 'Cemetery Data Registered Successfully');
		return redirect()->to("/cemeteryreg/list");
	}
	public function account_migration($cemetery_id){
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$cemetery_fee_details = $this->db->table('cemetery_fee_details')->where('cemetery_id', $cemetery_id)->get()->getResultArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', 5)->get()->getRowArray();
		if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
		$total_amount = 0;
		$cemetery_overtime_fee = !empty($cemetery['overtime_fee']) ? (float) $cemetery['overtime_fee'] : 0;
		$total_amount += $cemetery_overtime_fee;
		if(count($cemetery_fee_details)){
			foreach($cemetery_fee_details as $cfd) $total_amount += (float) $cfd['fee_amount'];
		}
		if($total_amount > 0){
			$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$num = 1;
			} else {
				$num = $number['number'] + 1;
			}
			$yr= date('Y',strtotime($cemetery['date'])) ;
			$mon= date('m',strtotime($cemetery['date'])) ;
			$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
			$entries['entry_code'] = 'REC' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
			$entries['entrytype_id'] = '1';
			$entries['number'] 		 = $num;
			$entries['date'] 		 = $cemetery['date'];		
			$entries['dr_total'] 	 = $total_amount;
			$entries['cr_total'] 	 = $total_amount;	
			$entries['narration'] 	 = 'Cemetery Registration';
			$entries['inv_id']		 = $cemetery_id;
			$entries['type']		 = '13';
			$ent = $this->db->table('entries')->insert($entries);
			$en_id = $this->db->insertID();
			$eitems_d = array();
			$eitems_d['entry_id'] = $en_id;
			$eitems_d['ledger_id'] = $payment_mode_details['ledger_id'];
			$eitems_d['amount'] = $total_amount;
			$eitems_d['dc'] = 'D';
			$this->db->table('entryitems')->insert($eitems_d);
			$ledger1 = $this->db->table('ledgers')->where('name', 'BURIAL')->where('group_id', 29)->where('left_code', '7014')->get()->getRowArray();
			if(!empty($ledger1)){
				$cr_id = $ledger1['id'];
			}else{
				$led1['group_id'] = 29;
				$led1['name'] = 'BURIAL';
				$led1['code'] = '7014/005';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led1['left_code'] = '7014';
				$led1['right_code'] = '005';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$cr_id = $this->db->insertID();
			}
			if($cemetery_overtime_fee > 0){
				$eitems_c = array();
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = $cemetery_overtime_fee;
				$eitems_c['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_c);
			}
			foreach($cemetery_fee_details as $cfd){
				$eitems_c = array();
				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id;
				$eitems_c['amount'] = (float) $cfd['fee_amount'];
				$eitems_c['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_c);
			}
		}
	}
	public function draft_edit() {
		$id=  $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		echo view('frontend/layout/header');
		echo view('frontend/cemetery/draft_register_edit', $data);
		//echo view('frontend/layout/footer');
    }
	public function update_draft_register()
	{
		//var_dump($_POST['save_drafts']);
		//exit;
		$id = $_POST['reg_id'];
		$cemetery_application_no = NULL;
		$cemetery_date = $_POST['cemetery_date']; //
		$cemetery_name_deceased = $_POST['cemetery_name_deceased']; //
		$cemetery_address = $_POST['cemetery_address']; //
		$cemetery_nationality = $_POST['cemetery_nationality']; //
		$cemetery_age = $_POST['cemetery_age']; //
		$cemetery_date_demise = $_POST['cemetery_date_demise']; //
		$cemetery_gender = $_POST['cemetery_gender']; //
		$cemetery_marital = $_POST['cemetery_marital']; //
		$nric_old = $_POST['nric_old']; //
		$nric_new = $_POST['nric_new']; //
		$occupation = $_POST['occupation']; //
		$d_certif_no = $_POST['d_certif_no']; //
		$d_certif_issue = $_POST['d_certif_issue']; //
		$d_certif_date = !empty($_POST['d_certif_date']) ? $_POST['d_certif_date'] : NULL; //
		$b_certif_no = $_POST['b_certif_no']; //
		$b_certif_issue = $_POST['b_certif_issue']; //
		$b_certif_date = !empty($_POST['b_certif_date']) ? $_POST['b_certif_date'] : NULL; //
		$cemetery_name_applicant = $_POST['cemetery_name_applicant']; //
		$app_nric_old = $_POST['app_nric_old']; //
		$app_nric_new = $_POST['app_nric_new']; //
		$cemetery_applicant_address = $_POST['cemetery_applicant_address']; //
		$cemetery_relationship_deceased = $_POST['cemetery_relationship_deceased']; //
		$app_phone = $_POST['app_phone']; //
		$exetor_of_estate = $_POST['exetor_of_estate']; //
		$nearest_relative = $_POST['nearest_relative']; //
		$signature = $_POST['signature']; //
		$management = $_POST['management']; //
		$payment_status = 1;
		$slot_type = $_POST['slot_type']; //
		$paid_through = "ONLINE";
		$ress = $this->db->table("cemetery")->select('slot')->where("slot", $slot_type)->where("date", $cemetrydate)->where("draft_status", 'publish')->where("payment_status", 2)->get()->getResultArray();
		if(count($ress) > 0){
			$this->session->setFlashdata('succ', 'Your Selected date is already booked');
			return redirect()->to("/cemeteryreg/draft_list");
		}
		$inset_data = array(
			"num"=>$cemetery_application_no,
			"date"=>$cemetery_date,
			"name_of_deceased"=>$cemetery_name_deceased,
			"address_of_deceased"=>$cemetery_address,
			"nationality"=>$cemetery_nationality,
			"age"=>$cemetery_age,
			"date_of_demise"=>$cemetery_date_demise,
			"sex"=>$cemetery_gender,
			"marital_status"=>$cemetery_marital,
			"nric_old"=>$nric_old,
			"nric_new"=>$nric_new,
			"occupation"=>$occupation,
			"d_certif_no"=>$d_certif_no,
			"d_certif_issue"=>$d_certif_issue,
			"d_certif_date"=>$d_certif_date,
			"b_certif_no"=>$b_certif_no,
			"b_certif_issue"=>$b_certif_issue,
			"b_certif_date"=>$b_certif_date,
			"name_of_applicant"=>$cemetery_name_applicant,
			"relationship"=>$cemetery_relationship_deceased,
			"address_of_applicant"=>$cemetery_applicant_address,
			"app_nric_old"=>$app_nric_old,
			"app_nric_new"=>$app_nric_new,
			"app_phone"=>$app_phone,
			"exetor_of_estate"=>$exetor_of_estate,
			"nearest_relative"=>$nearest_relative,
			"management"=>$management,
			"signature"=>$signature,
			"slot"=>$slot_type,
			"entry_by"=>$_SESSION['log_id_frend'],
			"paid_through"=>$paid_through,
			"draft_status"=>'publish',
			"payment_status"=>$payment_status
		);
		if(!empty($cemetery_booking_slot['is_special'])) $inset_data['special_time_status'] = 0;
		else  $inset_data['special_time_status'] = 1;
		$cemetery = $this->db->table('cemetery')->where('id', $id)->update($inset_data);
		/* $this->db->delete('cemetery_check', array('cemetery_id' => $id));
		$cemetery_check = !empty($_POST['cemetery_check']) ? $_POST['cemetery_check'] : array();
		if(count($cemetery_check) > 0){
			foreach($cemetery_check as $key => $val){
				$items = array(
					'cemetery_id'=>$id,
					'fee_text'=>$_POST['cemetery_text'][$key],
					'fee_amount'=>$_POST['cemetery_amount'][$key]
				);
				$this->db->table('cemetery_fee_details')->insert($items);
			}
		} */
		if($inset_data['special_time_status'] == 1){
			//$this->account_migration($cemetery_insert_id);
			return redirect()->to("/IpayOnlineCemetery/payment_process1/" . $id);
		}else{
			$this->session->setFlashdata('succ', 'Cemetery Registered Successfully. Waiting for Approval');
			return redirect()->to("/cemeteryreg/draft_list");
		}
			
	}

	public function edit() {
		$id=  $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		echo view('frontend/layout/header');
		echo view('frontend/cemetery/register_edit', $data);
		//echo view('frontend/layout/footer');
    }
	public function update_register()
	{
		$id = $_POST['reg_id'];
		$cemetery_name_deceased = $_POST['cemetery_name_deceased'];
		$cemetery_address = $_POST['cemetery_address'];
		$cemetery_nationality = $_POST['cemetery_nationality'];
		$cemetery_age = $_POST['cemetery_age'];
		$cemetery_date_demise = $_POST['cemetery_date_demise'];
		$cemetery_gender = $_POST['cemetery_gender'];
		$cemetery_marital = $_POST['cemetery_marital'];
		$nric_old = $_POST['nric_old'];
		$nric_new = $_POST['nric_new'];
		$occupation = $_POST['occupation'];
		$d_certif_no = $_POST['d_certif_no'];
		$d_certif_issue = $_POST['d_certif_issue'];
		$d_certif_date = $_POST['d_certif_date'];
		$b_certif_no = $_POST['b_certif_no'];
		$b_certif_issue = $_POST['b_certif_issue'];
		$b_certif_date = $_POST['b_certif_date'];
		$cemetery_name_applicant = $_POST['cemetery_name_applicant'];
		$cemetery_relationship_deceased = $_POST['cemetery_relationship_deceased'];
		$cemetery_applicant_address = $_POST['cemetery_applicant_address'];
		$app_nric_old = $_POST['app_nric_old'];
		$app_nric_new = $_POST['app_nric_new'];
		$app_phone = $_POST['app_phone'];
		$exetor_of_estate = $_POST['exetor_of_estate'];
		$nearest_relative = $_POST['nearest_relative'];
		$management = $_POST['management'];
		$signature = $_POST['signature'];
		$slot_type = $_POST['slot_type'];
		//$reg_no = $_POST['reg_no'];
		//$receipt_no = $_POST['receipt_no'];
		//$ash_collect_dete = $_POST['ash_collect_dete'];
		//$ash_collect_by = $_POST['ash_collect_by'];
		//$ash_signature = $_POST['ash_signature'];
		
		$data = array(
			"name_of_deceased"=>$cemetery_name_deceased,
			"address_of_deceased"=>$cemetery_address,
			"nationality"=>$cemetery_nationality,
			"age"=>$cemetery_age,
			"date_of_demise"=>$cemetery_date_demise,
			"sex"=>$cemetery_gender,
			"marital_status"=>$cemetery_marital,
			"nric_old"=>$nric_old,
			"nric_new"=>$nric_new,
			"occupation"=>$occupation,
			"d_certif_no"=>$d_certif_no,
			"d_certif_issue"=>$d_certif_issue,
			"d_certif_date"=>$d_certif_date,
			"b_certif_no"=>$b_certif_no,
			"b_certif_issue"=>$b_certif_issue,
			"b_certif_date"=>$b_certif_date,
			"name_of_applicant"=>$cemetery_name_applicant,
			"relationship"=>$cemetery_relationship_deceased,
			"address_of_applicant"=>$cemetery_applicant_address,
			"app_nric_old"=>$app_nric_old,
			"app_nric_new"=>$app_nric_new,
			"app_phone"=>$app_phone,
			"exetor_of_estate"=>$exetor_of_estate,
			"nearest_relative"=>$nearest_relative,
			"management"=>$management,
			"slot"=>$slot_type,
			"signature"=>$signature
			//"reg_no"=>$reg_no,
			//"receipt_no"=>$receipt_no,
			//"ash_collect_dete"=>$ash_collect_dete,
			//"ash_collect_by"=>$ash_collect_by,
			//"ash_signature"=>$ash_signature
		);
		$cemetery = $this->db->table('cemetery')->where('id', $id)->update($data);
        /* $cemetery_insert_id = $this->db->insertID();
		
		$item_id = $_POST['cemetery_text'];
		$total_item = count($item_id);
		$total_amount = 0;
		$total_amount += $cemetery_overtime_fee;
		for($i = 0; $i < $total_item; $i++) $total_amount += $_POST['cemetery_amount'][$i];
		if(empty($number)) {
			$num = 1;
		} else {
			$num = $number['number'] + 1;
		}
		$yr= date('Y',strtotime($inset_data['date'])) ;
		$mon= date('m',strtotime($inset_data['date'])) ;
		$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
		$entries['entry_code'] = 'REC' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
		$entries['entrytype_id'] = '1';
		$entries['number'] 		 = $num;
		$entries['date'] 		 = $inset_data['date'];		
		$entries['dr_total'] 	 = $total_amount;
		$entries['cr_total'] 	 = $total_amount;	
		$entries['narration'] 	 = 'Cemetery Registration';
		$entries['inv_id']		 = $cemetery_insert_id;
		$entries['type']		 = '3';
		$ent = $this->db->table('entries')->insert($entries);
		$en_id = $this->db->insertID();
		$ledger2 = $this->db->table('ledgers')->where('name', 'Cash Ledger')->where('group_id', 4)->get()->getRowArray();
		if(!empty($ledger2)){
			$dr_id = $ledger2['id'];
		}else{
			$cled1['group_id'] = 4;
			$cled1['name'] = 'Cash Ledger';
			$cled1['op_balance'] = '0';
			$cled1['op_balance_dc'] = 'D';
			$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
			$dr_id = $this->db->insertID();
		}
		$eitems_d = array();
		$eitems_d['entry_id'] = $en_id;
		$eitems_d['ledger_id'] = $dr_id;
		$eitems_d['amount'] = $total_amount;
		$eitems_d['dc'] = 'D';
		$this->db->table('entryitems')->insert($eitems_d);
		if($cemetery_overtime_fee > 0){
			$ledger1 = $this->db->table('ledgers')->where('name', 'Overtime Fee')->where('group_id', 54)->get()->getRowArray();
			if(!empty($ledger1)){
				$cr_id = $ledger1['id'];
			}else{
				$led1['group_id'] = 54;
				$led1['name'] = 'Overtime Fee';
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$cr_id = $this->db->insertID();
			}
			$eitems_d = array();
			$eitems_d['entry_id'] = $en_id;
			$eitems_d['ledger_id'] = $cr_id;
			$eitems_d['amount'] = $cemetery_overtime_fee;
			$eitems_d['dc'] = 'C';
			$this->db->table('entryitems')->insert($eitems_d);
		}
		for($i = 0; $i < $total_item; $i++)
		{
			$items = array(
				'cemetery_id'=>$cemetery_insert_id,
				'fee_text'=>$_POST['cemetery_text'][$i],
				'fee_amount'=>$_POST['cemetery_amount'][$i]
			);
			$this->db->table('cemetery_fee_details')->insert($items);
			$ledger1 = $this->db->table('ledgers')->where('name', $items['fee_text'])->where('group_id', 54)->get()->getRowArray();
			if(!empty($ledger1)){
				$cr_id = $ledger1['id'];
			}else{
				$led1['group_id'] = 54;
				$led1['name'] = $items['fee_text'];
				$led1['op_balance'] = '0';
				$led1['op_balance_dc'] = 'D';
				$led_ins1 = $this->db->table('ledgers')->insert($led1);
				$cr_id = $this->db->insertID();
			}
			$eitems_d = array();
			$eitems_d['entry_id'] = $en_id;
			$eitems_d['ledger_id'] = $cr_id;
			$eitems_d['amount'] = $_POST['cemetery_amount'][$i];
			$eitems_d['dc'] = 'C';
			$this->db->table('entryitems')->insert($eitems_d);
		} */
		$this->session->setFlashdata('succ', 'Data Updated Successfully');
		header("Location: ".base_url()."/cemeteryreg/list");
	}
	public function cemetery_reg_print($id) {
		$data['cemetery'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		echo view('frontend/cemetery/cemetery_reg_print', $data);
    }
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function get_booking_slot()
    {
        $cemetrydate = $_POST['cemetrydate']; 			
        $ress = $this->db->table("cemetery")->select('slot')->where("date", $cemetrydate)->where("draft_status", 'publish')->where("payment_status", 2)->get()->getResultArray();
		$cmeterts = array();
		$implode_arry = array();
		foreach($ress as $row)
		{
			$cmeterts[] = $row['slot'];
		}
        $cemetery_booking_slots = $this->db->table('cemetery_booking_slot')->where("status", 1)->get()->getResultArray();
		$html = "<option value='' >--Select slot--</option>";
		if(!empty($_POST['cemetryid'])){
			$cemetryid = $_POST['cemetryid'];
			$selected_row = $this->db->table("cemetery")->select('slot')
									->where("date", $cemetrydate)->where("id", $cemetryid)->get()->getRowArray();
			$selected_row_slot = $selected_row['slot'];
			$cemetery_selected_booking_slots = $this->db->table('cemetery_booking_slot')->where("id", $selected_row_slot)->get()->getRowArray();
		}
		$html_bool = false;
		foreach($cemetery_booking_slots as $cemetery_booking_slot)
		{
			if( is_array($cmeterts) && in_array($cemetery_booking_slot['id'], $cmeterts) ){
				//$html.= '<option value="" >No Available Slots</option>';
			}
			else{
				$open_cemetery_section = "open_cemetery_section";
				if(!empty($_POST['cemetryid'])){
					$selected = '';
					if($selected_row_slot == $cemetery_booking_slot['id']) $selected = ' selected';
					if(empty($cemetery_booking_slot['from_time']) && empty($cemetery_booking_slot['to_time'])){
						$html.= '<option value="'.$cemetery_booking_slot['id'].'" class="'.$open_cemetery_section.'"' . $selected . '>'.$cemetery_booking_slot['name'].'</option>';
						$html_bool = true;
					}
					else
					{
						if(!empty($cemetery_booking_slot['from_time']) && !empty($cemetery_booking_slot['to_time']) &&  !empty($cemetery_selected_booking_slots['is_special']))
						{
							$html.= '<option value="'.$cemetery_booking_slot['id'].'"' . $selected . '>'.$cemetery_booking_slot['name'].'</option>';
							$html_bool = true;
						}
						else
						{
							$datetime = $cemetrydate." ".$cemetery_booking_slot['from_time'];
							$timestamp = strtotime($datetime);
							$time = $timestamp - (3 * 60 * 60);
							$datetime2 = date("Y-m-d H:i:s", $time);
							$current_datetime3 = date("Y-m-d H:i:s");
							//echo $datetime2;
							//exit;
							if( $current_datetime3 <= $datetime2 )
							{
								$alert_modal = "open_cemetery_section";
								$disabled_slot = "";
								$html.= '<option value="'.$cemetery_booking_slot['id'].'"' . $selected . '>'.$cemetery_booking_slot['name'].'</option>';
								$html_bool = true;
							}
							else
							{
								$alert_modal = 'clk-option';
								$disabled_slot = "readonly";
							}
						}
					}
					if(!$html_bool) $html.= '<option value="" >No Available Slots</option>';
				}else{
					if(empty($cemetery_booking_slot['from_time']) && empty($cemetery_booking_slot['to_time'])){
						$html.= '<option value="'.$cemetery_booking_slot['id'].'" class="'.$open_cemetery_section.'">'.$cemetery_booking_slot['name'].'</option>';
						$html_bool = true;
					}
					else
					{
						$datetime = $cemetrydate." ".$cemetery_booking_slot['from_time'];
						$timestamp = strtotime($datetime);
						$time = $timestamp - (3 * 60 * 60);
						$datetime2 = date("Y-m-d H:i:s", $time);
						$current_datetime3 = date("Y-m-d H:i:s");
						//echo $datetime2;
						//exit;
						if( $current_datetime3 <= $datetime2 )
						{
							$alert_modal = "open_cemetery_section";
							$disabled_slot = "";
							$html.= '<option value="'.$cemetery_booking_slot['id'].'" class="'.$open_cemetery_section.'">'.$cemetery_booking_slot['name'].'</option>';
							$html_bool = true;
						}
						else
						{
							$alert_modal = 'clk-option';
							$disabled_slot = "readonly";
						}
					}
					if(!$html_bool) $html.= '<option value="" >No Available Slots</option>';
				}
				
			}
		}

		echo $html;
    }
	public function payment_success(){
		echo view('frontend/cemetery/payment_success');
	}
	
	public function payment_failed(){
		echo view('frontend/cemetery/payment_failed');
	}
}