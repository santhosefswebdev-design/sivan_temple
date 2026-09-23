<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Entries extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper("common_helper");
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }	

	public function add_entries(){
		if(!$this->model->permission_validate('entries_accounts','create_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $uid = $this->request->uri->getSegment(3);
		$group = $this->db->table("groups");
				if($uid == 4)
				{
					$group = $group->whereNotIn('id', array("4","7"));
				}
		$group = $group->get()->getResultArray();
        foreach($group as $row){
            $ledger[] = '<optgroup label="'.$row['name'].'">';
            $res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
            foreach($res as $r){
                $id = $r['id'];
				$ledgername = get_ledger_name($id);
                $ledger[] .= '<option value="'.$id.'">'.$ledgername.'</option>';
            }
            $ledger[] .='</optgroup>';
        }
		
        $number = $this->db->table('entries')->select('number')->where('entrytype_id', $uid)->orderBy('id','desc')->get()->getRowArray(); 
		if(empty($number)) {
			$data['ent_num'] = 1;
		} else {
			$data['ent_num'] = $number['number'] + 1;
		}
        $yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $uid and month (date)='". $mon ."')")->getRowArray();
        if($uid == 1) $bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 2) $bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 3) $bill_no = 'CON' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 4) $bill_no = 'JOR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        $data['entry_code'] = $bill_no;
		$data['en_id'] = $uid;
		if($uid == 1) $data['sub_title'] = "Receipt Entry";
		else if($uid == 2) $data['sub_title'] = "Payment Entry";
		else if($uid == 3) $data['sub_title'] = "Contra Entry";
		else if($uid == 4) $data['sub_title'] = "Journal Entry";
        $data['ledger'] =$ledger;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/add', $data);
		echo view('template/footer');
	}

	public function save_entries(){
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		
		//echo '<pre>'; 
		if($_POST['entries']){
            
            foreach($_POST['entries'] as $row0){
				
				if (empty($row0['ledger']) || ( empty(trim($row0['d_amt'])) && empty(trim($row0['c_amt']))) )
				{
					//print_r($row0);
					//die;
					// if(empty(trim($row['d_amt'])) && empty(trim($row['c_amt'])))
					// {
					$msg_data['err'] = 'Please check Empty Ledger / Dr Amount / Cr Amount. Please Try Again';
					echo json_encode($msg_data);
					exit();
					//}
				}
            }            
        }
		//exit;
		if ($_POST['total_debit']!=$_POST['total_credit']){			
		$msg_data['err'] = 'Credit and Debit Total Mismatched';
		echo json_encode($msg_data);
		exit();
		}
		
		
        $id = $this->request->uri->getSegment(3);
		
		$date = explode('-', $_POST['date']);
		$yr = $date[0];
  		$mon = $date[1];
		$query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $id and month (date)='". $mon ."')")->getRowArray();
        if($id == 1) $bill_no = 'REC' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($id == 2) $bill_no = 'PAY' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($id == 3) $bill_no = 'CON' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($id == 4) $bill_no = 'JOR' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        $data['entry_code'] = $bill_no;
		
		$number = $this->db->table('entries')->select('number')->where('entrytype_id', $id)->orderBy('id','desc')->get()->getRowArray(); 
		if(empty($number)) {
			$data['number'] = 1;
		} else {
			$data['number'] = $number['number'] + 1;
		}
		
        $data['entrytype_id']   = $id;
        $data['number']         = $_POST['number']; 
        $data['date']           = $_POST['date']; 
        $data['payment']        = $_POST['payment']; 
        $data['paid_to']        = $_POST['paid_to']; 
        $data['narration']      = $_POST['narration'];
        //$data['entry_code']     = $_POST['entry_code'];
        if($_POST['payment'] != 'cash'){
            $data['status']         = $_POST['status'];
            $data['cheque_no']      = $_POST['cheque_no'];
            $data['cheque_date']    = $_POST['cheque_date'];
            $data['return_date']    = $_POST['return_date'];
            $data['extra_charge']   = $_POST['extra_charge'];
            $data['collection_date']= $_POST['collection_date'];
        }
		if($_POST['entries']){
            $tot_d = 0; $tot_c = 0;
            foreach($_POST['entries'] as $row){
                if(trim($row['d_amt']) && $row['ledger']) $tot_d += $row['d_amt'];
                if(trim($row['c_amt']) && $row['ledger']) $tot_c += $row['c_amt'];
            }
            if($_POST['payment'] == "cheque" && $_POST['status'] == "returned")
			{
				if($_POST['extra_charge'] != "")
				{
					$data['dr_total']   = $tot_d + $_POST['extra_charge'];
					$data['cr_total']   = $tot_c + $_POST['extra_charge'];
				}
				else
				{
					$data['dr_total']   = $tot_d;
					$data['cr_total']   = $tot_c;
				}
			}
			else
			{
				$data['dr_total']   = $tot_d;
				$data['cr_total']   = $tot_c;
			}
        }
        $this->db->table("entries")->insert($data);
        $insid = $this->db->insertID();
        if(!empty($insid)){
            if($_POST['entries']){
                $tot_d = 0; $tot_c = 0;
                $i = 1;
                foreach($_POST['entries'] as $row)
				{
                    if(!empty($row['ledger']))
					{
						if($i == 1)
						{
							if($_POST['payment'] == "cheque" && $_POST['status'] == "returned")
							{
								if($_POST['extra_charge'] != "")
								{
									// EXTRA CHARGE SECTION C
									$extra_charge_nor = $this->db->table("ledgers")->where(["group_id"=>"15", "name"=>"Extra Charge"])->countAllResults();
									if($extra_charge_nor > 0)
									{
										$extra_charge_row = $this->db->table("ledgers")->where(["group_id"=>"15", "name"=>"Extra Charge"])->get()->getRowArray();
										$ledger_id = $extra_charge_row['id'];
										//var_dump($extra_charge_row);
										//exit;
									}
									else
									{
										$inser_ledger = array("group_id"=>15, "name"=>"Extra Charge", "op_balance"=>0, "op_balance_dc"=>"D");
										$this->db->table("ledgers")->insert($inser_ledger);
										$ledger_id = $this->db->insertID();
									}
									
									if($id == 1)
									{
										$dc_val = "C";
										if(trim($row['d_amt'])) $ent_firstdata['amount'] = $row['d_amt'] + $_POST['extra_charge'];
										$ent_firstdata['entry_id'] = $insid;
										$ent_firstdata['ledger_id'] = $row['ledger'];
										$ent_firstdata['dc'] = "D";
										$ent_firstdata['details'] = $row['details'];
										$this->db->table("entryitems")->insert($ent_firstdata);
										
									}
									else if($id == 2)
									{
										$dc_val = "D";
										if(trim($row['c_amt'])) $ent_firstdata['amount'] = $row['c_amt'] + $_POST['extra_charge'];
										$ent_firstdata['entry_id'] = $insid;
										$ent_firstdata['ledger_id'] = $row['ledger'];
										$ent_firstdata['dc'] = "C";
										$ent_firstdata['details'] = $row['details'];
										$this->db->table("entryitems")->insert($ent_firstdata);
									}
									else
									{
										$dc_val = "D";
										if(trim($row['c_amt'])) $ent_firstdata['amount'] = $row['c_amt'] + $_POST['extra_charge'];
										$ent_firstdata['entry_id'] = $insid;
										$ent_firstdata['ledger_id'] = $row['ledger'];
										$ent_firstdata['dc'] = "C";
										$ent_firstdata['details'] = $row['details'];
										$this->db->table("entryitems")->insert($ent_firstdata);
									}
									
									$ent_c['entry_id'] = $insid;
									$ent_c['ledger_id'] = $ledger_id;
									$ent_c['dc'] = $dc_val;
									$ent_c['details'] = "Extra Charge";
									$ent_c['amount'] = $_POST['extra_charge'];
									$this->db->table("entryitems")->insert($ent_c);
								}
							}
							else
							{
								if(trim($row['d_amt'])) $ent_firstdata['amount'] = $row['d_amt'];
								if(trim($row['c_amt'])) $ent_firstdata['amount'] = $row['c_amt'];
								$ent_firstdata['entry_id'] = $insid;
								$ent_firstdata['ledger_id'] = $row['ledger'];
								$ent_firstdata['dc'] = $row['dc'];
								$ent_firstdata['details'] = $row['details'];
								$this->db->table("entryitems")->insert($ent_firstdata);
							}
						}
						else
						{
							$ent['entry_id'] = $insid;
							$ent['ledger_id'] = $row['ledger'];
							$ent['dc'] = $row['dc'];
							$ent['details'] = $row['details'];
							if(trim($row['d_amt'])) $ent['amount'] = $row['d_amt'];
							if(trim($row['c_amt'])) $ent['amount'] = $row['c_amt'];
							$this->db->table("entryitems")->insert($ent);
						}
                    }
					$i++;
                }
            }//die;
				$msg_data['succ'] = 'Entries Added Successflly';
				$msg_data['id'] = $insid;
            
        }else{
            $msg_data['err'] = 'Please Try Again';
        }
		
		echo json_encode($msg_data);
		exit();
	}

    public function getbillno(){
        $uid = $_POST['eid'];
        $yr= date('Y',strtotime($_POST['dt'])) ;
        $mon= date('m',strtotime($_POST['dt'])) ;
        $query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $uid and month (date)='". $mon ."')")->getRowArray();
        if($uid == 1) $bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 2) $bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 3) $bill_no = 'CON' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 4) $bill_no = 'JOR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));

        echo $bill_no;      
    }

	public function view(){
	    if(!$this->model->permission_validate('entries_accounts','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    
		$data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
		$data['results2'] = $this->db->table("entryitems")->where('entry_id', $id)->get()->getResultArray();
			
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/view', $data);
		echo view('template/footer');
	}

    public function edit(){
        if(!$this->model->permission_validate('entries_accounts','edit')){
			header('Location: '.base_url().'/dashboard');
		}
        $id=  $this->request->uri->getSegment(3);
        $data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
		$data['results2'] = $this->db->table("entryitems")->where('entry_id', $id)->get()->getResultArray();
        foreach($data['results2'] as $row){
            $res = $this->db->table('ledgers')->where('id', $row['ledger_id'])->get()->getRowArray();
            $led_name[] = $res['name'];
        }
		$group = $this->db->table("groups");
				if($id == 4)
				{
					$group = $group->whereNotIn('id', array("4","7"));
				}
		$group = $group->get()->getResultArray();
        foreach($group as $row){
            $ledger[] = '<optgroup label="'.$row['name'].'">';
            $res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
            foreach($res as $r){
                $ids = $r['id'];
                $ledger[] .= '<option value="'.$ids.'">'.$r['name'].'</option>';
            }
            $ledger[] .='</optgroup>';
        }
        $data['led_name'] = $led_name;
        $data['ledger'] = $ledger;
        $data['en_id'] = $id;
	    echo view('template/header');
		echo view('template/sidebar');
        echo view('entries/edit', $data);
		echo view('template/footer');
    }

    public function update_entries(){
        // echo '<pre>'; print_r($_POST);//die;
		// echo '<pre>'; print_r($id);die;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		if($_POST['entries']){
            
            foreach($_POST['entries'] as $row0){
				
				if (empty($row0['ledger']) || (empty(trim($row0['d_amt'])) && empty(trim($row0['c_amt']))))
				{
					
					$msg_data['err'] = 'Please check Empty Ledger / Dr Amount / Cr Amount. Please Try Again';
					echo json_encode($msg_data);
					exit();					
				}				
            }            
        }		
		if ($_POST['total_debit']!=$_POST['total_credit']){	
		$msg_data['err'] = 'Credit and Debit Total Mismatched';
		echo json_encode($msg_data);
		exit();
		}
		
		
        $id = $this->request->uri->getSegment(3);
        $data['payment']        = $_POST['payment']; 
        $data['paid_to']        = $_POST['paid_to']; 
        $data['narration']      = $_POST['narration'];
        $data['entry_code']     = $_POST['entry_code'];
        if($_POST['payment'] == 'cash') $data['status'] = NULL;
        else $data['status'] = $_POST['status'];
        $data['cheque_no']      = $_POST['cheque_no'];
        $data['cheque_date']    = $_POST['cheque_date'];

        if($_POST['return_date'] == '') $data['return_date'] = NULL;
        else $data['return_date']    = $_POST['return_date'];

        if($_POST['extra_charge'] == '') $data['extra_charge'] = NULL;
        else $data['extra_charge']   = $_POST['extra_charge'];

        if($_POST['collection_date'] == '') $data['collection_date'] = NULL;
        else $data['collection_date']= $_POST['collection_date'];
		if($_POST['entries']){
            $tot_d = $_POST['sdr_total']; $tot_c = $_POST['scr_total'];
            foreach($_POST['entries'] as $row){
				
				//ledger
				
                if(trim($row['d_amt']) && $row['ledger']) $tot_d += $row['d_amt'];
                if(trim($row['c_amt']) && $row['ledger']) $tot_c += $row['c_amt'];
            }
            if($_POST['payment'] == "cheque" && $_POST['status'] == "returned")
			{
				if($_POST['extra_charge'] != "")
				{
					$data['dr_total']   = $tot_d + $_POST['extra_charge'];
					$data['cr_total']   = $tot_c + $_POST['extra_charge'];
				}
				else
				{
					$data['dr_total']   = $tot_d;
					$data['cr_total']   = $tot_c;
				}
			}
			else
			{
				$data['dr_total']   = $tot_d;
				$data['cr_total']   = $tot_c;
			}
        }
        $res = $this->db->table("entries")->where('id', $id)->update($data);
        $entry_type = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
        //echo $this->db->getLastQuery();
        if($res){
            //print_r($data);die;
            if($_POST['entries']){
                $tot_d = 0; $tot_c = 0;
                $i = 1;
                foreach($_POST['entries'] as $row)
				{
                    if(!empty($row['ledger']))
					{
						if($i == 1)
						{
							if($_POST['payment'] == "cheque" && $_POST['status'] == "returned")
							{
								if($_POST['extra_charge'] != "")
								{
									// EXTRA CHARGE SECTION C
									$extra_charge_nor = $this->db->table("ledgers")->where(["group_id"=>"15", "name"=>"Extra Charge"])->countAllResults();
									if($extra_charge_nor > 0)
									{
										$extra_charge_row = $this->db->table("ledgers")->where(["group_id"=>"15", "name"=>"Extra Charge"])->get()->getRowArray();
										$ledger_id = $extra_charge_row['id'];
										//var_dump($extra_charge_row);
										//exit;
									}
									else
									{
										$inser_ledger = array("group_id"=>15, "name"=>"Extra Charge", "op_balance"=>0, "op_balance_dc"=>"D");
										$this->db->table("ledgers")->insert($inser_ledger);
										$ledger_id = $this->db->insertID();
									}
									
									if($entry_type['entrytype_id'] == 1)
									{
										$dc_val = "C";
										if(trim($row['d_amt'])) $ent_firstdata['amount'] = $row['d_amt'] + $_POST['extra_charge'];
										$ent_firstdata['entry_id'] = $id;
										$ent_firstdata['ledger_id'] = $row['ledger'];
										$ent_firstdata['dc'] = "D";
										$ent_firstdata['details'] = $row['details'];
										$this->db->table("entryitems")->insert($ent_firstdata);
										
									}
									else if($entry_type['entrytype_id'] == 2)
									{
										$dc_val = "D";
										if(trim($row['c_amt'])) $ent_firstdata['amount'] = $row['c_amt'] + $_POST['extra_charge'];
										$ent_firstdata['entry_id'] = $id;
										$ent_firstdata['ledger_id'] = $row['ledger'];
										$ent_firstdata['dc'] = "C";
										$ent_firstdata['details'] = $row['details'];
										$this->db->table("entryitems")->insert($ent_firstdata);
									}
									else
									{
										$dc_val = "D";
										if(trim($row['c_amt'])) $ent_firstdata['amount'] = $row['c_amt'] + $_POST['extra_charge'];
										$ent_firstdata['entry_id'] = $id;
										$ent_firstdata['ledger_id'] = $row['ledger'];
										$ent_firstdata['dc'] = "C";
										$ent_firstdata['details'] = $row['details'];
										$this->db->table("entryitems")->insert($ent_firstdata);
									}
									
									$ent_c['entry_id'] = $id;
									$ent_c['ledger_id'] = $ledger_id;
									$ent_c['dc'] = $dc_val;
									$ent_c['details'] = "Extra Charge";
									$ent_c['amount'] = $_POST['extra_charge'];
									$this->db->table("entryitems")->insert($ent_c);
								}
							}
							else
							{
								if(trim($row['d_amt'])) $ent_firstdata['amount'] = $row['d_amt'];
								if(trim($row['c_amt'])) $ent_firstdata['amount'] = $row['c_amt'];
								$ent_firstdata['entry_id'] = $id;
								$ent_firstdata['ledger_id'] = $row['ledger'];
								$ent_firstdata['dc'] = $row['dc'];
								$ent_firstdata['details'] = $row['details'];
								$this->db->table("entryitems")->insert($ent_firstdata);
							}
						}
						else
						{
							$ent['entry_id'] = $id;
							$ent['ledger_id'] = $row['ledger'];
							$ent['dc'] = $row['dc'];
							$ent['details'] = $row['details'];
							if(trim($row['d_amt'])) $ent['amount'] = $row['d_amt'];
							if(trim($row['c_amt'])) $ent['amount'] = $row['c_amt'];
							$this->db->table("entryitems")->insert($ent);
						}
                    }
					$i++;
                }
            }//die;
				$msg_data['succ'] = 'Entries Updated Successflly';
				$msg_data['id'] = $id;
        }else{
            $msg_data['err'] = 'Please Try Again';
        }
		
		echo json_encode($msg_data);
		exit();
    }

    public function delete(){
        if(!$this->model->permission_validate('entries_accounts','delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
        $id = $this->request->uri->getSegment(3);
        if($id){
            $res = $this->db->table('entryitems')->delete(['entry_id' => $id]);
            if($res){
                $res1 = $this->db->table('entries')->delete(['id' => $id]);
                if($res1){
                    $this->session->setFlashdata('succ', 'Entries Delete Successfully');
			        header("Location: ".base_url()."/account/entries");
                }else{
                    $this->session->setFlashdata('fail', 'Please Try Again');
			        header("Location: ".base_url()."/account/entries");
                }
            }else{
                $this->session->setFlashdata('fail', 'Please Try Again');
			    header("Location: ".base_url()."/account/entries");
            }
        }else{
            $this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: ".base_url()."/account/entries");
        }
    }

	public function AmountInWords(){
        $amount = (float)$_POST['number'];
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		// // return ($num).'';
		// // exit;
        // Check if there is any number after decimal
		function NumToWords($num){
			$num=floor($num);
			$amt_hundred = null;
			$count_length = strlen($num);
			$x = 0;
			$string = array();
			$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
				3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
				7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
				10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
				13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
				16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
				19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
				40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
				70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
				$here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
				while( $x < $count_length ) {
					$get_divider = ($x == 2) ? 10 : 100;
					$amount = floor($num % $get_divider);
					$num = floor($num / $get_divider);
					$x += $get_divider == 10 ? 1 : 2;
					if ($amount) {
						$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
						$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
						$string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
					}else $string[] = null;
			}
			//$implode_to_Rupees = implode('', array_reverse($string));
			return(implode('', array_reverse($string)));
		}
        
        /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
        //$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal])): '';
        
		$get_paise = ($amount_after_decimal > 0) ? " and Cents ". trim(NumToWords($amount_after_decimal)):'';
        //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        return (NumToWords($amount) ? 'Ringgit '.trim(NumToWords($amount)).'' : ''). $get_paise. ' Only';
        
		//return ($implode_to_paise).'';
		//echo json_encode($amt_words);
    }
	
    public function AmountInWords2(){
		
		// after decimal if 99 is nine nine
        
        $amount = (float)$_POST['number'];
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
            $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
            while( $x < $count_length ) {
                $get_divider = ($x == 2) ? 10 : 100;
                $amount = floor($num % $get_divider);
                $num = floor($num / $get_divider);
                $x += $get_divider == 10 ? 1 : 2;
                if ($amount) {
                    $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                    $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                    $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
                }else $string[] = null;
        }
        $implode_to_Rupees = implode('', array_reverse($string));
        /*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
        " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
        $get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal /10]).' '. trim($change_words[$amount_after_decimal % 10]))  : '';
        
		//$get_paise = ($amount_after_decimal > 0) ? " and Cents ".(trim($change_words[$amount_after_decimal])):'';
        //return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
        return ($implode_to_Rupees ? 'Ringgit '.trim($implode_to_Rupees).'' : ''). $get_paise. ' Only';
        
		//return ($amount_after_decimal).'';
		//echo json_encode($amt_words);
    }
	
	public function print_page(){
		
		$id = $this->request->uri->getSegment(3);
			
		$data['results'] = $this->db->table("entries")->where('id', $id)->get()->getRowArray();
		$tmp_id = 1;
		$data['temple_details'] = $this->db->table("admin_profile")->where('id', $tmp_id)->get()->getRowArray();
		//print_r($data['results']['entrytype_id']); die;
		if ($data['results']['entrytype_id'] !=4)
		
			echo view('entries/entries_print', $data);
		else
			echo view('entries/entries_print_journal', $data);
	}

	public function list(){
		if(!$this->model->list_validate('entries_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('entries_accounts');  
		$entries = $this->db->query("SELECT * FROM entries where type is NULL or type = '' ORDER BY entries.date DESC")->getResultArray();
		//$data['data'] = $this->db->table('entries')->orderBy('id', 'desc')->get()->getResultArray();//->where('inv_id', null)->where('type', null)
		$data['data'] = $entries;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/list', $data);
		echo view('template/footer');
	}
	public function view_page($id1){
		if(!$this->model->list_validate('entries_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('entries_accounts');
		$entries = $this->db->query("SELECT * FROM entries WHERE id = $id1")->getRowArray();
		$data['entries'] = $entries;
		$entry_id = $entries['id'];
		$data['en_id'] = $entries['entrytype_id'];
		$data['entry_code'] = $entries['entry_code'];
		$data['bank_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('left_code', '3600')->orWhere('left_code', '3700')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		if($entries['entrytype_id'] == "1")
		{
			$entrie_items = $this->db->query("SELECT * FROM entryitems WHERE entry_id = $entry_id and dc = 'C' ")->getResultArray();
			$data['entrie_items'] = $entrie_items;
			$data['credit_ledger'] = $this->db->query("SELECT ledger_id,details FROM entryitems WHERE entry_id = $entry_id and dc = 'D' ")->getRowArray();
			echo view('entries/receipt_add',$data);
		}
		if($entries['entrytype_id'] == "2")
		{
			$entrie_items = $this->db->query("SELECT * FROM entryitems WHERE entry_id = $entry_id and dc = 'D' ")->getResultArray();
			$data['entrie_items'] = $entrie_items;
			$data['credit_ledger'] = $this->db->query("SELECT ledger_id,details FROM entryitems WHERE entry_id = $entry_id and dc = 'C' ")->getRowArray();
			echo view('entries/payment_add',$data);
		}
		if($entries['entrytype_id'] == "4")
		{
			$entrie_items = $this->db->query("SELECT * FROM entryitems WHERE entry_id = $entry_id ")->getResultArray();
			$data['entrie_items'] = $entrie_items;
			$data['credit_ledger'] = $this->db->query("SELECT ledger_id,details FROM entryitems WHERE entry_id = $entry_id ")->getRowArray();
			echo view('entries/journal_add',$data);
		}
		echo view('template/footer');
	}
	public function edit_page($id1){
		if(!$this->model->list_validate('entries_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('entries_accounts');  
		$entries = $this->db->query("SELECT * FROM entries WHERE id = $id1")->getRowArray();
		$data['entries'] = $entries;
		$entry_id = $entries['id'];
		$data['en_id'] = $entries['entrytype_id'];
		$data['entry_code'] = $entries['entry_code'];
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		if($entries['entrytype_id'] == "1")
		{
			$entrie_items = $this->db->query("SELECT * FROM entryitems WHERE entry_id = $entry_id and dc = 'C' ")->getResultArray();
			$data['entrie_items'] = $entrie_items;
			if(count($entrie_items) > 0){
				$data['entrie_items_count'] = count($entrie_items) + 1;
			}
			else{
				$data['entrie_items_count'] = 1;
			}
			$data['credit_ledger'] = $this->db->query("SELECT ledger_id,details FROM entryitems WHERE entry_id = $entry_id and dc = 'D' ")->getRowArray();
			echo view('entries/receipt_add',$data);
		}
		if($entries['entrytype_id'] == "2")
		{
			echo view('entries/payment_add',$data);
		}
		if($entries['entrytype_id'] == "4")
		{
			echo view('entries/journal_add',$data);
		}
		echo view('template/footer');
	}
	public function delete_page(){
        if(!$this->model->permission_validate('entries_accounts','delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
        $id = $this->request->uri->getSegment(3);
        if($id){
            $res = $this->db->table('entryitems')->delete(['entry_id' => $id]);
            if($res){
                $res1 = $this->db->table('entries')->delete(['id' => $id]);
                if($res1){
                    $this->session->setFlashdata('succ', 'Entries Delete Successfully');
			        header("Location: ".base_url()."/entries/list");
                }else{
                    $this->session->setFlashdata('fail', 'Please Try Again');
			        header("Location: ".base_url()."/entries/list");
                }
            }else{
                $this->session->setFlashdata('fail', 'Please Try Again');
			    header("Location: ".base_url()."/entries/list");
            }
        }else{
            $this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: ".base_url()."/entries/list");
        }
    }
    public function receipt_add(){
		$uid = 1;
        $yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $uid and month (date)='". $mon ."')")->getRowArray();
        if($uid == 1) $bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 2) $bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 3) $bill_no = 'CON' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 4) $bill_no = 'JOR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        $data['entry_code'] = $bill_no;
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->get()->getResultArray();
		$data['bank_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('type', 1)->get()->getResultArray();
		$data['en_id'] = $uid;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/receipt_add',$data);
		echo view('template/footer');
	}
	public function receipt_debit_ac()
	{
		$rtdebit_ac = $_POST['rtdebit_ac'];
		$reslt_data = $this->db->query("SELECT * FROM ledgers where id !=$rtdebit_ac")->getRowArray();
		$html = "<option value='0'>Select debit a/c</option>";
		foreach($reslt_data as $res)
		{
			$html .= "<option value=".$res["id"].">(" . $res["left_code"] . '/' . $res["right_code"] . ") - ".$res["name"]."</option>";
		}
		echo $html;
	}
	public function save_receipt_entries(){
		//var_dump($_POST['entries']);
		//exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$entry_id = $_POST['entry_id'];
		$entry_type_id = $_POST['entry_type_id'];
		$receipt_date = $_POST['receipt_date'];
		$receipt_paymode = $_POST['receipt_paymode'];
		$receipt_credit_ac = $_POST['receipt_credit_ac'];
		$receipt_entrycode = $_POST['receipt_entrycode'];
		$receipt_receivedfrom = $_POST['receipt_receivedfrom'];
		if($receipt_paymode == "cheque")
		{
			$receipt_chequeno = $_POST['receipt_chequeno'];
			$receipt_chequedate = $_POST['receipt_chequedate'];
		}
		else if($receipt_paymode == "online")
		{
			$receipt_chequeno = $_POST['receipt_refno'];
			$receipt_chequedate = $_POST['receipt_transactiondate'];
		}
		else
		{
			$receipt_chequeno = NULL;
			$receipt_chequedate = NULL;
		}
		$receipt_particulars = $_POST['receipt_particulars'];
		$tot_amt_input = $_POST['tot_amt_input'];
		
		if( !empty($tot_amt_input) && !empty($receipt_paymode) ) {
			$data['entrytype_id']   = $entry_type_id;
			$data['payment']   = $receipt_paymode;
			$data['date']           = $receipt_date; 
			$data['dr_total']        = $tot_amt_input; 
			$data['cr_total']        = $tot_amt_input; 
			$data['narration']      = $receipt_particulars;
			$data['entry_code']      = $receipt_entrycode;
			$data['paid_to']      = $receipt_receivedfrom; 
			$data['cheque_no']      = $receipt_chequeno; 
			$data['cheque_date']      = $receipt_chequedate;

			if(!empty($entry_id)){
				$this->db->table("entries")->where('id', $entry_id)->update($data);
				$insid = $entry_id;
			}
			else{
				$number = $this->db->table('entries')->select('number')->where('entrytype_id', $entry_type_id)->orderBy('id','desc')->get()->getRowArray(); 
				if(empty($number)) {
					$data['number'] = 1;
				} else {
					$data['number'] = $number['number'] + 1;
				}
				$this->db->table("entries")->insert($data);
        		$insid = $this->db->insertID();
				// CREDIT as of now DEBIT
				if(!empty($receipt_credit_ac))
				{
					$entryitems_c['entry_id']  = $insid;
					$entryitems_c['ledger_id'] = $receipt_credit_ac;
					$entryitems_c['details'] = $receipt_receivedfrom;
					$entryitems_c['amount'] = $tot_amt_input;
					$entryitems_c['dc'] = "D";
					$this->db->table('entryitems')->insert($entryitems_c);
				}
			}
			if(!empty($insid)){
				if(!empty($_POST['entries'])){
					foreach($_POST['entries'] as $row)
					{
						if(empty($row['entryitemid']))
						{
							$entryitems_d['entry_id']  = $insid;
							$entryitems_d['ledger_id'] = $row['ledgerid'];
							$entryitems_d['details'] = $row['particulars'];
							$entryitems_d['amount'] = $row['amount'];
							$entryitems_d['dc'] = "C";
							$this->db->table('entryitems')->insert($entryitems_d);
						}
					}
				}
				$msg_data['succ'] = 'Receipt Entry Added Successfully';
              	$msg_data['id'] = $insid;
			}
			else{
            	$msg_data['err'] = 'Please Try Again';
        	}
		}
		else
		{
			$msg_data['err'] = 'Please Fill All Required Field';
		}
		echo json_encode($msg_data);
      	exit();
	}
	public function payment_add(){
		$uid = 2;
        $yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $uid and month (date)='". $mon ."')")->getRowArray();
        if($uid == 1) $bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 2) $bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 3) $bill_no = 'CON' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 4) $bill_no = 'JOR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        $data['entry_code'] = $bill_no;
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->get()->getResultArray();
		$data['bank_ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('type', 1)->get()->getResultArray();
		$data['en_id'] = $uid;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/payment_add',$data);
		echo view('template/footer');
	}
	public function save_payment_entries(){
		//var_dump($_POST['entries']);
		//exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$entry_type_id = $_POST['entry_type_id'];
		$payment_date = $_POST['payment_date'];
		$payment_paymode = $_POST['payment_paymode'];
		$payment_debit_ac = $_POST['payment_debit_ac'];
		$payment_entrycode = $_POST['payment_entrycode'];
		$payment_receivedfrom = $_POST['payment_receivedfrom'];
		if($payment_paymode == "cheque")
		{
			$payment_chequeno = $_POST['payment_chequeno'];
			$payment_chequedate = $_POST['payment_chequedate'];
		}
		else if($payment_paymode == "online")
		{
			$payment_chequeno = $_POST['payment_refno'];
			$payment_chequedate = $_POST['payment_transactiondate'];
		}
		else
		{
			$payment_chequeno = NULL;
			$payment_chequedate = NULL;
		}
		$payment_particulars = $_POST['payment_particulars'];
		$tot_amt_input = $_POST['tot_amt_input'];
		
		if( !empty($tot_amt_input) && !empty($payment_paymode) ) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', $entry_type_id)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$data['number'] = 1;
			} else {
				$data['number'] = $number['number'] + 1;
			}
			$data['entrytype_id']   = $entry_type_id;
			$data['payment']   = $payment_paymode;
			$data['date']           = $payment_date; 
			$data['dr_total']        = $tot_amt_input; 
			$data['cr_total']        = $tot_amt_input; 
			$data['narration']      = $payment_particulars;
			$data['entry_code']      = $payment_entrycode;
			$data['paid_to']      = $payment_receivedfrom; 
			$data['cheque_no']      = $payment_chequeno; 
			$data['cheque_date']      = $payment_chequedate;
			$this->db->table("entries")->insert($data);
        	$insid = $this->db->insertID();
			if(!empty($insid)){
				// DEBIT as of Now CREDIT
				if(!empty($payment_debit_ac))
				{
					$entryitems_c['entry_id']  = $insid;
					$entryitems_c['ledger_id'] = $payment_debit_ac;
					$entryitems_c['details'] = $payment_receivedfrom;
					$entryitems_c['amount'] = $tot_amt_input;
					$entryitems_c['dc'] = "C";
					$this->db->table('entryitems')->insert($entryitems_c);
				}
				if(!empty($_POST['entries'])){
					foreach($_POST['entries'] as $row)
					{
						$entryitems_d['entry_id']  = $insid;
                    	$entryitems_d['ledger_id'] = $row['ledgerid'];
                    	$entryitems_d['details'] = $row['particulars'];
                    	$entryitems_d['amount'] = $row['amount'];
                    	$entryitems_d['dc'] = "D";
						$this->db->table('entryitems')->insert($entryitems_d);
					}
				}
				$msg_data['succ'] = 'Payment Entry Added Successfully';
              	$msg_data['id'] = $insid;
			}
			else{
            	$msg_data['err'] = 'Please Try Again';
        	}
		}
		else
		{
			$msg_data['err'] = 'Please Fill All Required Field';
		}
		echo json_encode($msg_data);
      	exit();
	}
	public function payment_debit_ac()
	{
		$rtdebit_ac = $_POST['rtdebit_ac'];
		$reslt_data = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->where('id !=', $rtdebit_ac)->get()->getResultArray();
		$html = "<option value='0'>Select credit a/c</option>";
		foreach($reslt_data as $res)
		{
			$html .= "<option value=".$res["id"].">(" . $res["left_code"] . '/' . $res["right_code"] . ") - ".$res["name"]."</option>";
		}
		echo $html;
	}

	public function journal_add(){
		$uid = 4;
        $yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id = $uid and month (date)='". $mon ."')")->getRowArray();
        if($uid == 1) $bill_no = 'REC' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 2) $bill_no = 'PAY' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 3) $bill_no = 'CON' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        if($uid == 4) $bill_no = 'JOR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['entry_code'],-5))+1)));
        $data['entry_code'] = $bill_no;
		$data['ledgers'] = $this->db->table("ledgers")->select('id,name,code,left_code,right_code')->orWhere('type', '')->orWhere('type', NULL)->get()->getResultArray();
		$data['en_id'] = $uid;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/journal_add',$data);
		echo view('template/footer');
	}
	public function save_journal_entries(){
		//var_dump($_POST['entries']);
		//exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$entry_type_id = $_POST['entry_type_id'];
		$journal_date = $_POST['journal_date'];
		$journal_entrycode = $_POST['journal_entrycode'];
		$input_total_debit_balance = $_POST['input_total_debit_balance'];
		$input_total_credit_balance = $_POST['input_total_credit_balance'];
		if($input_total_debit_balance > 0 && $input_total_credit_balance > 0 && $input_total_debit_balance == $input_total_credit_balance) {
			$number = $this->db->table('entries')->select('number')->where('entrytype_id', $entry_type_id)->orderBy('id','desc')->get()->getRowArray(); 
			if(empty($number)) {
				$data['number'] = 1;
			} else {
				$data['number'] = $number['number'] + 1;
			}
			$data['entrytype_id']   = $entry_type_id;
			$data['date']           = $journal_date; 
			$data['dr_total']        = $input_total_debit_balance; 
			$data['cr_total']        = $input_total_credit_balance; 
			$data['entry_code']      = $journal_entrycode;
			$this->db->table("entries")->insert($data);
			$insid = $this->db->insertID();
			if(!empty($insid)){
				if(!empty($_POST['entries'])){
					foreach($_POST['entries'] as $row)
					{
						$entryitems_d['entry_id']  = $insid;
						$entryitems_d['ledger_id'] = $row['ledgerid'];
						$entryitems_d['details'] = $row['particulars'];
						if($row['dramt'] > 0)
						{
							$entryitems_d['amount'] = $row['dramt'];
							$entryitems_d['dc'] = "D";
						}
						if($row['cramt'] > 0)
						{
							$entryitems_d['amount'] = $row['cramt'];
							$entryitems_d['dc'] = "C";
						}
						$this->db->table('entryitems')->insert($entryitems_d);
					}
				}
				$msg_data['succ'] = 'Joural Entry Added Successfully';
				$msg_data['id'] = $insid;
			}
			else{
				$msg_data['err'] = 'Please Try Again';
			}
		}
		else
		{
			$msg_data['err'] = 'Credit amount and Debit amount not equal.';
		}
		echo json_encode($msg_data);
      	exit();
	}
	public function getladgerName()
	{
		$ledger_id = $_POST['ledger_id'];
		$row_data = $this->db->table('ledgers')->where('id', $ledger_id)->get()->getRowArray();
		echo '(' . $row_data['left_code'] . '/' . $row_data['right_code'] . ") - ".$row_data['name'];
	}

}
