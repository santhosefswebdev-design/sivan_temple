<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\PermissionModel;

class Cemetery extends BaseController
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
   
	public function index() {
		$data['cemetery'] = $this->db->table('cemetery_settings')->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/index', $data);
		echo view('template/footer');
    }
	
	public function cemetery_register() {
		$cemetrylist = $this->db->table('cemetery')->select('*');
					if($_SESSION['role'] != 1 && $_SESSION['log_name'] != "admin"){	
						$cemetrylist = $cemetrylist->where("entry_by", $_SESSION['log_id']);
					}
		$cemetrylist = $cemetrylist->orderBy('id', 'DESC')->get()->getResultArray();
		$data['list'] = $cemetrylist;
		$data['agent_dets']	= $this->db->table('login')->select('id,name,member_comes')->whereIn("role", array("1","99"))->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/cemetery_register', $data);
		echo view('template/footer');
    }
	
	public function register() {
		$data['max'] = $this->db->table('cemetery')->select('max(num) + 1 as max_num')->get()->getRowArray();
		$data['booking_slots'] = $this->db->table('cemetery_booking_slot')->where("status", 1)->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/register', $data);
		echo view('template/footer');
    }
	
	public function register_new() {
		$data['max'] = $this->db->table('cemetery')->select('max(num) + 1 as max_num')->get()->getRowArray();
		$data['booking_slots'] = $this->db->table('cemetery_booking_slot')->where("status", 1)->get()->getResultArray();
		$data['payment_modes'] = $this->db->table('payment_mode')->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/register_new', $data);
		echo view('template/footer');
    }
	
	public function get_booking_slot()
    {
        $cemetryid = $_POST['cemetryid'];
        $cemetrydate = $_POST['cemetrydate'];
		$selected_row = $this->db->table("cemetery")->select('slot')
								->where("date", $cemetrydate)->where("id", $cemetryid)->get()->getRowArray();
		$selected_row_slot = $selected_row['slot']; 			
        $ress = $this->db->table("cemetery")->select('slot')->where("date", $cemetrydate)->get()->getResultArray();
		$cmeterts = array();
		$implode_arry = array();
		foreach($ress as $row)
		{
			$cmeterts[] = $row['slot'];
		}
        $cemetery_booking_slots = $this->db->table('cemetery_booking_slot')->where("status", 1)->get()->getResultArray();
		$html = "<option value='' >--Select slot--</option>";
		foreach($cemetery_booking_slots as $cemetery_booking_slot)
		{
			if( is_array($cmeterts) && in_array($cemetery_booking_slot['id'], $cmeterts) ){
				$disabled = "disabled";
				$selected = "selected";
			}
			else{
				$disabled = "";
				$selected = "";
			}
			
			
			if(empty($cemetery_booking_slot['from_time']) && empty($cemetery_booking_slot['to_time']))
			{
				$html.= '<option value='.$cemetery_booking_slot['id'].' '.$disabled.' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
			}
			else
			{
				if(!empty($cemetery_booking_slot['from_time']) && !empty($cemetery_booking_slot['to_time']) &&  $selected_row_slot == 4)
				{
					$html.= '<option value='.$cemetery_booking_slot['id'].' '.$disabled.' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
				}
				else
				{
					$cur_time = date("H:i:s");
					if(( strtotime($cur_time) >= strtotime($cemetery_booking_slot['from_time']) && strtotime($cur_time) <= strtotime($cemetery_booking_slot['to_time']) ))
					{
						$html.= '<option value='.$cemetery_booking_slot['id'].' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
					}
				}
			}
			
			
			/*if(empty($cemetery_booking_slot['from_time']) && empty($cemetery_booking_slot['to_time']))
			{
				$html.= '<option value='.$cemetery_booking_slot['id'].' '.$disabled.' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
			}
			else
			{
				$cur_time = date("H:i:s");
				if(( strtotime($cur_time) >= strtotime($cemetery_booking_slot['from_time']) && strtotime($cur_time) <= strtotime($cemetery_booking_slot['to_time']) ))
				{
					$html.= '<option value='.$cemetery_booking_slot['id'].' '.$disabled.' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
				}
			}*/
			/*if((date("H:i:s") >= $cemetery_booking_slot['from_time']) && (date("H:i:s") <= $cemetery_booking_slot['to_time']))
			{
				$html.= '<option value='.$cemetery_booking_slot['id'].' '.$disabled.' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
			}
			else
			{
				$html.= '<option value='.$cemetery_booking_slot['id'].' '.$disabled.' '.$selected.' >'.$cemetery_booking_slot['name'].'</option>';
			}*/
		}
		echo $html;
    }
	public function edit() {
		$id=  $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/register_edit', $data);
		echo view('template/footer');
    }
	
	public function update_register()
	{
		$id = $_POST['reg_id'];
		$cemetery_application_no = $_POST['cemetery_application_no'];
		$reg_no = $_POST['reg_no'];
		$receipt_no = $_POST['receipt_no'];
		$ash_collect_dete = $_POST['ash_collect_dete'];
		$ash_collect_by = $_POST['ash_collect_by'];
		$ash_signature = $_POST['ash_signature'];
		
		$data = array(
			"num"=>$cemetery_application_no,
			"reg_no"=>$reg_no,
			"receipt_no"=>$receipt_no,
			"ash_collect_dete"=>$ash_collect_dete,
			"ash_collect_by"=>$ash_collect_by,
			"ash_signature"=>$ash_signature
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
		header("Location: ".base_url()."/cemetery/report");
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
	
	public function save()
	{
	    $builder = $this->db->table('cemetery_settings');
        $builder->truncate(); 
        //$this->db->query("TRUNCATE cemetery_settings");
	    $item_id = $_POST['cemetery_setting_name'];
		$total_item = count($item_id);
		for($i = 0; $i < $total_item; $i++)
		{
			$items = array(
				'meta_key'=>$_POST['cemetery_setting_name'][$i],
				'meta_value'=>$_POST['cemetery_setting_amount'][$i]
			);
			$this->db->table('cemetery_settings')->insert($items);
		}
		
		$this->session->setFlashdata('succ', 'Data Add Successfully');
		header("Location: ".base_url()."/cemetery");
	}
	public function save_register()
	{
		//var_dump($_POST);
		//exit;
		$cemetery_application_no = $_POST['cemetery_application_no'];
		$cemetery_date = $_POST['cemetery_date'];
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
		$reg_no = $_POST['reg_no'];
		$receipt_no = $_POST['receipt_no'];
		$ash_collect_dete = $_POST['ash_collect_dete'];
		$ash_collect_by = $_POST['ash_collect_by'];
		$ash_signature = $_POST['ash_signature'];
		
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
			"entry_by"=>$_SESSION['log_id'],
			"reg_no"=>$reg_no,
			"receipt_no"=>$receipt_no,
			"ash_collect_dete"=>$ash_collect_dete,
			"ash_collect_by"=>$ash_collect_by,
			"ash_signature"=>$ash_signature
		);
		$cemetery = $this->db->table('cemetery')->insert($inset_data);
		$cemetery_insert_id = $this->db->insertID();
		$this->session->setFlashdata('succ', 'Data Registered Successfully');
		header("Location: ".base_url()."/cemetery/cemetery_register");
		/*
		$payment_mode_details = $this->db->table('payment_mode')->where('id', $payment_mode)->get()->getRowArray();
		if(!empty($payment_mode_details['id'])){
			$ress = $this->db->table("cemetery")->select('slot')->where("date", $cemetery_date)->get()->getResultArray();
			$cmeterts = array();
			foreach($ress as $row)
			{
				$cmeterts[] = $row['slot'];
			}
			if( is_array($cmeterts) && in_array($slot_type, $cmeterts) )
			{
				$this->session->setFlashdata('succ', 'Choosed slot type already booked please choose another slot.');
				header("Location: ".base_url()."/cemetery/cemetery_register");
			}
			else
			{
				$total_amount = 0;
				$cemetery_check = !empty($_POST['cemetery_check']) ? $_POST['cemetery_check'] : array();
				if(count($cemetery_check) > 0){
					foreach($cemetery_check as $key => $val) $total_amount += $_POST['cemetery_amount'][$key];
				}
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
				$eitems_d = array();
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $payment_mode_details['ledger_id'];
				$eitems_d['amount'] = $total_amount;
				$eitems_d['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_d);
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
				$eitems_d = array();
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $cr_id;
				$eitems_d['amount'] = $total_amount;
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);
				
			}
		}else{
			$this->session->setFlashdata('err', 'Invalid Payment mode.');
			header("Location: ".base_url()."/cemetery/cemetery_register");
		}
		*/
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
	
	public function report() {
		/*if(!$this->model->list_validate('cemetery_report')){
			header('Location: '.base_url().'/dashboard');
		}*/
		$data['list'] = $this->db->table('login')->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/report', $data);
		echo view('template/footer');
    }
	
	public function cemetery_report()
    {
		$fdt= date('Y-m-d',strtotime($_POST['fdt']));
		$tdt= date('Y-m-d',strtotime($_POST['tdt']));
		$reg_by = $_POST['reg_by'];
		$data = [];
		$builder = $this->db->table('cemetery')
		->join('login', 'login.id = cemetery.entry_by')
		->select('cemetery.*,login.name as agent_name')
		->where('payment_status !=',1)
		->where('cemetery.date>=',$fdt) 
		->where('cemetery.date<=',$tdt);
		if(!empty($reg_by)){
			$builder->where("cemetery.entry_by", $reg_by);
		}
		$dat = $builder->get()->getResultArray();
		
		//$dat = $this->db->table('cemetery')->orderBy('id', 'desc')->get()->getResultArray();
		$i = 1;		
		foreach($dat as $row)
		{
			$option = '<a title="EDIT" class="btn btn-warning btn-rad" href="'.base_url().'/cemetery/cemetery_register_edit/'.$row['id'].'" ><i class="material-icons">edit</i></a>';
			$option .= '<a target="_blank" title="PRINT" class="btn btn-primary btn-rad" href="'.base_url().'/cemetery/cemetery_reg_print/'.$row['id'].'" ><i class="material-icons">print</i></a>';
			$data[] = array(
				$i++,
				$row['agent_name'],
				$row['name_of_deceased'],
				$row['age'],
				date('d/m/Y',strtotime($row['date_of_demise'])),
				$row['b_certif_no'],
				$option,
			);
		}
		
    	$result = array(
    		"draw" => 0,
    		"recordsTotal" => $i-1,
    		"recordsFiltered" => $i-1,
    		"data" => $data,
    	);
    	echo json_encode($result);
    	exit();
    }
	public function cemetery_register_edit() {
		$id=  $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		$data['max'] = $this->db->table('cemetery')->select('max(num) + 1 as max_num')->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/register_edit', $data);
		echo view('template/footer');
    }
    public function print_cemetery()
	{
		/*if(!$this->model->list_validate('cemetery_report')){
			header('Location: '.base_url().'/dashboard');
		}*/
		$data['fdate']= $_REQUEST['fdt'];
		$data['tdate']= $_REQUEST['tdt'];
		$reg_by = $_REQUEST['reg_by'];
		$data['reg_by'] = $reg_by;
		$dat = $this->db->table('cemetery')
							->join('login', 'login.id = cemetery.entry_by')
							->select('cemetery.*,login.name as agent_name')
							->where('payment_status !=',1)
							->where('cemetery.date>=',$_REQUEST['fdt']) 
							->where('cemetery.date<=',$_REQUEST['tdt']);
							if(!empty($reg_by)){
								$dat = $dat->where("cemetery.entry_by", $reg_by);
							}
							$dat = $dat->get()->getResultArray();
		$data['data'] = $dat;
		
		if($_REQUEST['pdf_cemeteryreport'] == "PDF")
		{
			$file_name = "Cemetery_Report_".$data['fdate']."_to_".$data['tdate'];
			$dompdf = new \Dompdf\Dompdf();
			$options = $dompdf->getOptions(); 
			$options->set(array('isRemoteEnabled' => true));
			$dompdf->setOptions($options);			
			$dompdf->loadHtml(view('cemetery/cemetery_print_report', ["pdfdata" => $data]));
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$dompdf->stream($file_name);
		}
		elseif($_REQUEST['excel_cemeteryreport'] == "EXCEL")
		{
			$fileName = "Cemetery_Report_".$data['fdate']."_to_".$data['tdate'];  
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);

			$sheet->getStyle("A1:F1")->applyFromArray($style);
			$sheet->mergeCells('A1:F1'); 
			$sheet->setCellValue('A1', $_SESSION['site_title']);
			$sheet->setCellValue('A2', 'S.No');
			$sheet->setCellValue('B2', 'Agent Name');
			$sheet->setCellValue('C2', 'Name of Deceased');
			$sheet->setCellValue('D2', 'Age');
			$sheet->setCellValue('E2', 'Date of Demise');      
			$sheet->setCellValue('F2', 'Burial No');        
			$rows = 3;
			$si = 1;
			//var_dump($excel_format_data);
			//exit;
			foreach ($data['data'] as $val)
			{
				$sheet->setCellValue('A' . $rows, $si);
				$sheet->setCellValue('B' . $rows, $val['agent_name']);
				$sheet->setCellValue('C' . $rows, $val['name_of_deceased']);
				$sheet->setCellValue('D' . $rows, $val['age']);
				$sheet->setCellValue('E' . $rows, date('d/m/Y',strtotime($val['date_of_demise'])));
				$sheet->setCellValue('F' . $rows, $val['b_certif_no']);
				$rows++;
				$si++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/'.$fileName.'.xlsx');
			return $this->response->download('uploads/excel/'.$fileName.'.xlsx', null)->setFileName($fileName.'.xlsx');
		}
		else
		{
			echo view('cemetery/cemetery_print', $data);
		}
	}
	
	public function cemetery_reg_print($id) {
		/*if(!$this->model->list_validate('cemetery_report')){
			header('Location: '.base_url().'/dashboard');
		}*/
		$data['cemetery'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		echo view('cemetery/cemetery_reg_print', $data);
    }
	
	
	
	public function register1() {
		$data['max'] = $this->db->table('cemetery')->select('max(num) + 1 as max_num')->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/register1', $data);
		echo view('template/footer');
    }
	
	public function save_register1()
	{
		$id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		
		$cemetery_application_no = $_POST['cemetery_application_no'];
		$cemetery_date = $_POST['cemetery_date'];
		$cemetery_name_deceased = $_POST['cemetery_name_deceased'];
		$cemetery_address = $_POST['cemetery_address'];
		$cemetery_nationality = $_POST['cemetery_nationality'];
		$cemetery_age = $_POST['cemetery_age'];
		$cemetery_gender = $_POST['cemetery_gender'];
		$cemetery_marital = $_POST['cemetery_marital'];
		$cemetery_date_demise = $_POST['cemetery_date_demise'];
		$cemetery_date_cremation = $_POST['cemetery_date_cremation'];
		$cemetery_burial_permit_no = $_POST['cemetery_burial_permit_no'];
		$cemetery_place_demise = $_POST['cemetery_place_demise'];
		$cemetery_demise_registered = $_POST['cemetery_demise_registered'];
		$cemetery_funeral = $_POST['cemetery_funeral'];
		$cemetery_name_applicant = $_POST['cemetery_name_applicant'];
		$cemetery_relationship_deceased = $_POST['cemetery_relationship_deceased'];
		$cemetery_applicant_address = $_POST['cemetery_applicant_address'];
		$cemetery_overtime_fee = $_POST['cemetery_overtime_fee'];
		$ic_no = $_POST['ic_no'];
		$signature = $_POST['signature'];
		
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
						"date_for_cremation"=>$cemetery_date_cremation,
						"burial_no"=>$cemetery_burial_permit_no,
						"place_of_demise"=>$cemetery_place_demise,
						"demise_registered"=>$cemetery_demise_registered,
						"funeral_arrangements"=>$cemetery_funeral,
						"name_of_applicant"=>$cemetery_name_applicant,
						"relationship"=>$cemetery_relationship_deceased,
						"address_of_applicant"=>$cemetery_applicant_address,
						"overtime_fee"=>$cemetery_overtime_fee,
						"ic_no"=>$ic_no,
						"signature"=>$signature
					);
		$cemetery = $this->db->table('cemetery')->insert($inset_data);
        $cemetery_insert_id = $this->db->insertID();
		
		$item_id = $_POST['cemetery_text'];
		$total_item = count($item_id);
		$total_amount = 0;
		$total_amount += $cemetery_overtime_fee;
		for($i = 0; $i < $total_item; $i++) $total_amount += $_POST['cemetery_amount'][$i];
		$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
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
		/* $ledger2 = $this->db->table('ledgers')->where('name', 'Cash Ledger')->where('group_id', 4)->get()->getRowArray();
		if(!empty($ledger2)){
			$dr_id = $ledger2['id'];
		}else{
			$cled1['group_id'] = 4;
			$cled1['name'] = 'Cash Ledger';
			$cled1['op_balance'] = '0';
			$cled1['op_balance_dc'] = 'D';
			$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
			$dr_id = $this->db->insertID();
		} */
		$payment_mode_details = $this->db->table('payment_mode')->where('id', 3)->get()->getRowArray();
		if(empty($payment_mode_details['id'])) $payment_mode_details = $this->db->table('payment_mode')->get()->getRowArray();
		$eitems_d = array();
		$eitems_d['entry_id'] = $en_id;
		$eitems_d['ledger_id'] = $payment_mode_details['ledger_id'];
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
		}
		/*$this->session->setFlashdata('succ', 'Data Registered Successfully');
		header("Location: ".base_url()."/cemetery/register");*/
		$msg_data['succ'] = 'Data Registered Successfully';
		echo json_encode($msg_data);
		exit();
	}
	
	public function cemetery_reg_print1() {
		/*if(!$this->model->list_validate('cemetery_report')){
			header('Location: '.base_url().'/dashboard');
		}*/
		$id = $this->request->uri->getSegment(3);
		$data['cemetery'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		echo view('cemetery/cemetery_reg_print', $data);
    }
	
	public function cemetery_specialtime_register_pending() {
		if(!$this->model->list_validate('cemetery_specialtime_register_pending')){
			header('Location: '.base_url().'/dashboard');
		}
		$cemetrylist = $this->db->table('cemetery')->select('*')->where("slot",4)->where("special_time_status","0")->orderBy('id', 'DESC')->get()->getResultArray();
		$data['list'] = $cemetrylist;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/cemetery_register_pending', $data);
		echo view('template/footer');
    }
	public function approvestatus() {
		$id=  $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		$data['specialtime'] = $this->db->table('cemetery_booking_slot')->where('id', $data['data']['slot'])->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/cemetery_change_status', $data);
		echo view('template/footer');
    }
	public function update_specialtime_status()
	{
		$reg_id = $_POST['reg_id'];
		$special_time_status = $_POST['special_time_status'];
		$data = array("special_time_status"=> $special_time_status);
		$cemetery = $this->db->table('cemetery')->where('id', $reg_id)->update($data);
		if($special_time_status == 1){
			//$this->account_migration($reg_id);
			$mail_data['data'] = $this->db->table('cemetery')->where('id', $reg_id)->get()->getRowArray();
			$mail_data['cemetery_fee_details'] = $this->db->table('cemetery_fee_details')->where('cemetery_id', $reg_id)->get()->getResultArray();
			$message =  view('cemetery/mail_template',$mail_data);
			$subject = $_SESSION['site_title']." Cemetery Registration";
			$to_user = $_POST['email_address'];
			$to_mail = array("prithivitest@gmail.com",$to_user);
			send_mail_with_content($to_mail,$message,$subject,$temple_title);
		}
		$this->session->setFlashdata('succ', 'Specialtime status updated successfully');
		return redirect()->to("/cemetery/cemetery_specialtime_register_pending");
	}
	public function cemetery_specialtime_register_approved() {
		if(!$this->model->list_validate('cemetery_specialtime_register_approved')){
			header('Location: '.base_url().'/dashboard');
		}
		$cemetrylist = $this->db->table('cemetery')->select('*')->where("slot",4)->where("special_time_status","1")->where("entry_by", $_SESSION['log_id'])->orderBy('id', 'DESC')->get()->getResultArray();
		$data['list'] = $cemetrylist;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/cemetery_register_approved', $data);
		echo view('template/footer');
    }
	public function payment() {
		$id=  $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('cemetery')->where('id', $id)->get()->getRowArray();
		$data['specialtime'] = $this->db->table('cemetery_booking_slot')->where('id', $data['data']['slot'])->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/cemetery_payment', $data);
		echo view('template/footer');
    }
	public function proceed_payment() {
		return redirect()->to("/cemetery/cemetery_specialtime_register_approved");
	}
	
	public function booking_slot() {
		$data['list'] = $this->db->table('cemetery_booking_slot')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/booking_slot', $data);
		echo view('template/footer');
    }
    
    public function save_slot(){
        $id = $_POST['id'];
        
        $data['name']	 =	trim($_POST['name']);
		
		if(empty($id)){
		    $builder = $this->db->table('cemetery_booking_slot')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Slot Added Successfully');
    		    header("Location: ".base_url()."/cemetery/booking_slot");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/cemetery/booking_slot");
    		}
		}else{
            $builder = $this->db->table('cemetery_booking_slot')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Slot Update Successfully');
    		    header("Location: ".base_url()."/cemetery/booking_slot");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/cemetery/booking_slot");
    		}
		}
	}
	
	public function edit_slot(){
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('cemetery_booking_slot')->where('id', $id)->get()->getRowArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/edit_slot', $data);
		echo view('template/footer');
	}
	
	
	public function spl_time_approval() {
		/*if(!$this->model->list_validate('cemetery_report')){
			header('Location: '.base_url().'/dashboard');
		}*/
		$data['list'] = $this->db->table('cemetery')->where('slot', "4")->get()->getResultArray();
		
		echo view('template/header');
		echo view('template/sidebar');
		echo view('cemetery/spl_time_approval', $data);
		echo view('template/footer');
    }
    
    public function approve_time() {
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('cemetery')->where('id', $id)->update(array('special_time_status'=>'1'));
		if($res){
			$this->account_migration($id);
		    $this->session->setFlashdata('succ', 'Approved Successfully');
		    header("Location: ".base_url()."/cemetery/spl_time_approval");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/cemetery/spl_time_approval");
		}
    }
    
    public function reg_time() {
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('cemetery')->where('id', $id)->update(array('special_time_status'=>'2'));
		if($res){
		    $this->session->setFlashdata('succ', 'Rejected Successfully');
		    header("Location: ".base_url()."/cemetery/spl_time_approval");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/cemetery/spl_time_approval");
		}
    }
    public function account_migration($cemetery_id){
		$cemetery = $this->db->table('cemetery')->where('id', $cemetery_id)->get()->getRowArray();
		$cemetery_fee_details = $this->db->table('cemetery_fee_details')->where('cemetery_id', $cemetery_id)->get()->getResultArray();
		$payment_mode_details = $this->db->table('payment_mode')->where('id', 3)->get()->getRowArray();
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
}