<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Archanaibooking extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		$this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false ){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
	  //echo '<pre>';
      if(!$this->model->list_validate('archanai_ticket')){
			header('Location: '.base_url().'/dashboard');
		}
	  $data['permission'] = $this->model->get_permission('archanai_ticket');
	  $data['staff'] = $this->db->table('staff')->get()->getResultArray();
	  $group = $this->db->query("SELECT * FROM archanai_group order by name asc")->getResultArray();
	  $data['archanai'][''] = $this->db->table('archanai')->where('groupname', '')->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
	  foreach($group as $row){ 
			$data['archanai'][$row['name']] = $this->db->table('archanai')->where('groupname', $row['name'])->where('view_archanai', 1)->orderBy('order_no', 'ASC')->get()->getResultArray();
	  }
      //$data['data'] = $this->db->table('archanai')->get()->getResultArray();
		$yr=date('Y');
		$mon=date('m');
		$query   = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();

      $data['bill_no']= 'AR' .date('y').$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
      echo view('template/header');
      echo view('template/sidebar');
      echo view('archanaibooking/index', $data);
      echo view('template/footer');
    }
	
	
    public function getbillno(){

		//echo strtotime($_POST['dt']);
      $yr= date('Y',strtotime($_POST['dt'])) ;
      $mon= date('m',strtotime($_POST['dt'])) ;
		  $query   = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();

      echo 'AR' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));      
    }
	
	 
    public function show_product(){
		$group = $this->db->query("SELECT * FROM archanai_group order by name asc")->getResultArray();
		$archanai[''] = $this->db->query("SELECT * FROM archanai WHERE groupname = '' and view_archanai = 1 and name_eng LIKE '%". $_POST['prod'] ."%' order by order_no asc")->getResultArray();
		foreach($group as $row){
				$name = $row['name']; 
				$archanai[$row['name']] = $this->db->query("SELECT * FROM archanai WHERE groupname = '$name' and view_archanai = 1 and name_eng LIKE '%". $_POST['prod'] ."%' order by order_no asc")->getResultArray();
		}
		//echo '<pre>'; print_r($archanai);
		/* $group = $this->db->query("SELECT groupname, COUNT(groupname) as cnt FROM archanai GROUP BY groupname HAVING COUNT(groupname) > 0")->getResultArray();
		foreach($group as $row){ 
			$name = $row['groupname'];
			$archanai[$row['groupname']] = $this->db->query("SELECT * FROM archanai WHERE groupname = '$name' and name_eng LIKE '%". $_POST['prod'] ."%' order by order_no asc")->getResultArray();
	  	}*/
		  foreach($archanai as $key => $value){
			if(!empty($value)){
				if(!empty($key)) { $val = $key; } else{  $val = '';}
				$tr_row[] = '<div class="col-md-12"><h4>'.$val.'</h4></div>';
				foreach($value as $row) {
					$tr_row[] .= '<div class="col-md-3" style="padding-left: 0px;">
									<div class="prod" id="prod'.$row['id'].'" data-id="prod'.$row['id'].'" onclick="addtocart('.$row['id'].')"><img src="'.base_url().'/uploads/archanai/'.$row['image'].'" width="200" height="80" alt="image" />
										<!--<div class="vl"></div>-->
										<div class="detail">
										<h5 id="nm_'.$row['id'].'" data-id="'.$row['id'].'"> '.$row['name_tamil'].' <br>'.$row['name_eng'].'</h5><h4 id="amt_'.$row['id'].'" data-id="'.($row['amount'] ).'" >RM '.number_format((float)($row['amount'] ), 2).'</h4>
										</div>
									</div>
								</div>';
				}
			}
		  }
      
      $data['row'] = $tr_row;
      // echo '<pre>';
      // print_r($tr_row);
      // die();
      echo json_encode($data);
      //echo $_POST['prod'];

    }
	
	
    public function save(){
		// echo '<pre>';
		// print_r( $_POST); exit;
		$cnt = $_POST['cnt'];
		$comission_to = $_POST['comission_to'];
		//echo $comission_to; exit;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		if ($cnt==0 || $cnt == ''){
			$this->session->setFlashdata('fail', 'Please add atlease on item');
			$msg_data['err'] =  'Please add atlease on item';
    	    //header("Location: ".base_url()."/archanaibooking");
		}else{
			// $yr=date('Y');
			// $mon=date('m');
			$yr= date('Y',strtotime($_POST['dt'])) ;
			$mon= date('m',strtotime($_POST['dt'])) ;
			$query   = $this->db->query("SELECT ref_no FROM archanai_booking where id=(select max(id) from archanai_booking where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();

			$data['ref_no']= 'AR' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
			
			//$data['date']		    =	date('Y-m-d');
			$data['date']			= date('Y-m-d',strtotime($_POST['dt']));
			
			//$data['ref_no']		=	$_POST['billno'];
			$data['entry_by']	    =	$this->session->get('log_id');
			$data['amount']       =	$_POST['tot_amt'];
			$data['created']      =	date('Y-m-d H:i:s');
			$data['comission_to'] =   $comission_to;
				$tot_amt = 0;
				$com_amt = 0;
			foreach ($_POST['arch'] as $arch)
			{
			$cash = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
			$data_arch_book['amount']  =	$cash['amount'];
			$data_arch_book['commision']  =	$cash['commission'];
			$amt = $arch['qty'] * $cash['amount'];
			$camt =  $arch['qty'] * $cash['commission'];
			$tot_amt  +=	$amt;
			$tot_camt  +=	$camt;
			}
			
			// if ($comission_to!=0)
				// $data['amount'] = $tot_amt-$tot_camt;
			// else
				// $data['amount'] = $tot_amt;
			$data['amount'] = $tot_amt-$tot_camt;
			$data['comission'] = $tot_camt;
			
			$res = $this->db->table('archanai_booking')->insert($data);
			$arch_book_id=$this->db->insertID();
			if($res){
				// Debit ledger
				$ledger1 = $this->db->table('ledgers')->where('name', 'Archanai')->where('group_id', 29)->get()->getRowArray();
				if(!empty($ledger1)){
					$dr_id = $ledger1['id'];
				}else{
					$led1['group_id'] = 29;
					$led1['name'] = 'Archanai';
					$led1['op_balance'] = '0';
					$led1['op_balance_dc'] = 'D';
					$led_ins1 = $this->db->table('ledgers')->insert($led1);
					$dr_id = $this->db->insertID();
				}

				// Credit ledger
				// $res_sname = $this->db->table("staff")->where("id", $comission_to)->get()->getRowArray();
				// $ledger = $this->db->table('ledgers')->where('name', $res_sname['name'])->get()->getRowArray();
				// if(!empty($ledger)){
					// $cr_id = $ledger['id'];
				// }else{
					// $cled['group_id'] = 38;
					// $cled['name'] = $res_sname['name'];
					// $cled['op_balance'] = '0';
					// $cled['op_balance_dc'] = 'D';
					// $cled_ins = $this->db->table('ledgers')->insert($cled);
					// $cr_id = $this->db->insertID();
				// }

				$ledger2 = $this->db->table('ledgers')->where('name', 'Cash Ledger')->where('group_id', 4)->get()->getRowArray();
				if(!empty($ledger2)){
					$cr_id1 = $ledger2['id'];
				}else{
					$cled1['group_id'] = 4;
					$cled1['name'] = 'Cash Ledger';
					$cled1['op_balance'] = '0';
					$cled1['op_balance_dc'] = 'D';
					$cled_ins1 = $this->db->table('ledgers')->insert($cled1);
					$cr_id1 = $this->db->insertID();
				}
				
				
				//echo $dr_id.'<br>'.$cr_id.'<br>'.$cr_id1;die;

			//print_r($this->db->insertID());
			  
			  $cash_amt = 0;
			  $com_amt = 0;
			  foreach ($_POST['arch'] as $arch)
			  {            
			  $data_arch_book['archanai_booking_id']	 =	$arch_book_id;
			  $data_arch_book['archanai_id']  =	$arch['id'];
			  $data_arch_book['quantity']  =	$arch['qty'];
			  $data_arch_book['created']  =	date('Y-m-d H:i:s');
			  $cash = $this->db->table('archanai')->where('id', $arch['id'])->get()->getRowArray();
			  $data_arch_book['amount']  =	$cash['amount'];
			  $data_arch_book['commision']  =	$cash['commission'];
			  $amt = $arch['qty'] * $cash['amount'];
			  $camt =  $arch['qty'] * $cash['commission'];
			  $data_arch_book['total_amount']  =	$amt-$camt;
			  $data_arch_book['total_commision']  =	$camt;
			  
			  $cash_amt = $cash_amt + $amt;
			  $com_amt = $com_amt + $camt;
			  
			  $res_2 = $this->db->table('archanai_booking_details')->insert($data_arch_book);
			}
			$number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
				if(empty($number)) {
					$num = 1;
				} else {
					$num = $number['number'] + 1;
				}
				$qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
				$entries['entry_code'] = 'REC' .date('y',strtotime($_POST['dt'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
				
				$entries['entrytype_id'] = '1';
				$entries['number'] 		 = $num;
				$entries['date'] 		 = $data['date'];
								
				$entries['dr_total'] 	 = $cash_amt;
				$entries['cr_total'] 	 = $cash_amt;	
								$entries['narration'] 	 = 'Archanai Booking';
				$entries['inv_id']		 = $arch_book_id;
				$entries['type']		 = '3';
				$ent = $this->db->table('entries')->insert($entries);
				$en_id = $this->db->insertID();
			
			// if ($comission_to!=0)
			// {
				// $number1 = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
				// if(empty($number1)) {
					// $num1 = 1;
				// } else {
					// $num1 = $number1['number'] + 1;
				// }
				// $entries1['entrytype_id'] = '1';
				// $entries1['number'] 	 = $num1;
				// $entries1['date'] 		 = $data['date']; 
				// $entries1['dr_total'] 	 = $com_amt;
				// $entries1['cr_total'] 	 = $com_amt;
				// $entries1['narration'] 	 = 'Archanai Booking';
				// $entries1['inv_id']		 = $arch_book_id;
				// $entries1['type']		 = '3';
				// $ent1 = $this->db->table('entries')->insert($entries1);
				// $en_id1 = $this->db->insertID();
			// }
			if(!empty($en_id) ){
				$eitems_d['entry_id'] = $en_id;
				$eitems_d['ledger_id'] = $dr_id;
				$eitems_d['amount'] = $cash_amt;
				$eitems_d['dc'] = 'C';
				$this->db->table('entryitems')->insert($eitems_d);

				$eitems_c['entry_id'] = $en_id;
				$eitems_c['ledger_id'] = $cr_id1;
				if ($comission_to!=0)
					$eitems_c['amount'] = $cash_amt-$com_amt;
				else
					$eitems_c['amount'] = $cash_amt;
				$eitems_c['dc'] = 'D';
				$this->db->table('entryitems')->insert($eitems_c);
				
				if ($comission_to!=0)
				{
					$com_led = $this->db->table('ledgers')->where('name', 'Commission Ledger')->where('group_id', 13)->get()->getRowArray();
					if(!empty($com_led)){
						$com_led_id = $com_led['id'];
					}else{
						$com_led_data['group_id'] = 13;
						$com_led_data['name'] = 'Commission Ledger';
						$com_led_data['op_balance'] = '0';
						$com_led_data['op_balance_dc'] = 'D';
						$com_led_ins = $this->db->table('ledgers')->insert($com_led_data);
						$com_led_id = $this->db->insertID();
					}
					
					$eitems_com['entry_id'] = $en_id;
					$eitems_com['ledger_id'] = $com_led_id;
					$eitems_com['amount'] = $com_amt;
					$eitems_com['dc'] = 'D';
					$this->db->table('entryitems')->insert($eitems_com);
					
				}
				
			}
				// if ($comission_to!=0 && !empty($en_id1))
				// {
					// $eitems_d1['entry_id'] = $en_id1;
					// $eitems_d1['ledger_id'] = $dr_id;
					// $eitems_d1['amount'] = $com_amt;
					// $eitems_d1['dc'] = 'D';
					// $this->db->table('entryitems')->insert($eitems_d1);

					// $eitems_c1['entry_id'] = $en_id1;
					// $eitems_c1['ledger_id'] = $cr_id;
					// $eitems_c1['amount'] = $com_amt;
					// $eitems_c1['dc'] = 'C';
					// $this->db->table('entryitems')->insert($eitems_c1);
				// }
			
			if($res_2){
				
					if ($comission_to!=0)
					{
						 $this->db->query("update staff set commission_amt=commission_amt+$com_amt where id=$comission_to ");
		
					}
						$this->session->setFlashdata('succ', 'Archanai Booking Added Successfully');
						$msg_data['succ'] = 'Archanai Booking Added Successfully';
						$msg_data['id'] = $arch_book_id;
						/*header("Location: ".base_url()."/archanaibooking"  );*/
						//$url = base_url().'/archanaibooking/print_booking/'.$arch_book_id;
						//echo '<script type="text/javascript"> window.open("'.$url.'", "_blank") </script>';
						//echo "<script>location.replace('".base_url()."/archanaibooking')</script>";
						//header("Location: ".base_url()."/archanaibooking");
						//header("Location: ".base_url()."/archanaibooking/print_booking/$arch_book_id");
						//header("Location: ".base_url()."/archanaibooking/print_booking");
					}else{
						$this->session->setFlashdata('fail', 'Please Try Again');
						$msg_data['err'] = 'Please Try Again';
						//header("Location: ".base_url()."/archanaibooking");
					}
		  }
		}
		echo json_encode($msg_data);
		exit();
    }
	 
	 public function print_booking($arch_book_id){
		 
	 	$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $this->db->table('archanai_booking')->where('id', $id)->get()->getRowArray();
		//$data['qry2'] = $this->db->table('archanai_booking_details')->where('archanai_booking_id', $id)->get()->getResultArray();
		//echo "<pre>"; print_r($id); exit();
		$tmpid = $this->session->get('profile_id');
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();

		$data['booking'] = $this->db->table('archanai_booking_details', 'archanai')
					->join('archanai', 'archanai.id = archanai_booking_details.archanai_id')
					->where('archanai_booking_details.archanai_booking_id', $id )
					->select('archanai.*')
					->select('archanai_booking_details.*,(archanai_booking_details.amount+archanai_booking_details.commision) as tot')
					->get()
					->getResultArray();
					//echo $this->db->getLastQuery();
		//echo "<pre>"; print_r($data); exit();
		echo view('archanaibooking/print', $data);
	 }

	 
	 
}
