<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Account extends BaseController
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
    
    public function index(){
		if(!$this->model->list_validate('ac_creation_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('ac_creation_accounts');
		$data['add_group'] = $this->model->get_permission('group');
		$data['add_ledger'] = $this->model->get_permission('ledger');

        if(!empty($_POST['ledger'])) $ledger_id = $_POST['ledger'];
        else $ledger_id ="";

		$group = $this->db->table("groups")->get()->getResultArray();
		$ledger[] = '<option value="">--Select Ledger--</option>';
		foreach($group as $row){
            $res = $this->db->table("ledgers")->where('group_id', $row['id'])->get()->getResultArray();
            foreach($res as $r){
                $id = $r['id'];
                $ledgername = get_ledger_name($id);
				if($ledger_id == $id) $selected = 'selected';
                else $selected = '';
                $ledger[] .= '<option '.$selected.' value="'.$id.'">'.$ledgername.'</option>';
            }
        }
		$data['ledger'] =$ledger;
		$data['group'] = $group;
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		$sdate = $ac_id['from_year_month']."-01";
		$tdate = $ac_id['to_year_month']."-31";
		//var_dump($sdate);
		//var_dump($tdate);
		//var_dump($ac_id);
		//exit;
		$datas = array();
        $group = $this->model->get_permission('group');
        if($group['edit'] == 1 ||  $group['delete_p'] == 1) $group_p = 1; else $group_p = 0;
        if($group['edit'] == 1 ) $group_e = 1; else $group_e = 0;
        if($group['delete_p'] == 1 ) $group_d = 1; else $group_d = 0;
        $ledgerp = $this->model->get_permission('ledger');
        if($ledgerp['edit'] == 1 ||  $ledgerp['delete_p'] == 1) $ledger_p = 1; else $ledger_p = 0;
        if($ledgerp['edit'] == 1 ) $ledgere = 1; else $ledgere = 0;
        if($ledgerp['delete_p'] == 1 ) $ledgerd = 1; else $ledgerd = 0;
		//Parent Group
        $datas = array();
        $parent = $this->db->query("select * from groups where parent_id is NULL or parent_id ='' or parent_id = 0")->getResultArray();
        foreach($parent as $row){
            $lid = $row['id'].',1';
			$nid = $row['id'].'_1';
			//print_r($row);
			$datas[] = '<tr>
					   		<td><span id="name_'.$nid.'">'.$row['name'].'</span></td>
							<td>Group</td>
							<td>-</td>
							<td>-</td>';
			if($group_p == 1) {
                $datas[] = '	<td>';
                    if($group_e == 1 ) {
                    $datas[] = '		<a style="color: #fff;" href="'.base_url().'/account/edit_group/'.$row['id'].'">
                                            <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                        </a>';
                                        
                    }
                    /*if($group_d == 1) {				
                    $datas[] = '		<a style="color: #fff;" href="#">
                                        <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
                                    </a>';
                    }*/				
                                    
                $datas[] = '	</td>';
			}
			$datas[] = '<tr>';
            $id =$row['id'];
			if(!empty($_POST['ledger'])) 
			{
				$ledger_id = $_POST['ledger'];
				$res = $this->db->query("select * from ledgers where group_id = '".$id."' and id = '".$ledger_id."' ")->getResultArray();
			}
			else
			{
				$res = $this->db->query("select * from `ledgers` where group_id = '".$id."' ")->getResultArray();	
			}
			//$res = $this->db->query("select * from ledgers where group_id = '".$id."' ")->getResultArray();
            if(count($res) >0){
                foreach($res as $dd){
                    $lid = $dd['id'].',2';
                    $nid = $dd['id'].'_2';
					$led_id = $dd['id'];
					$ledgername = get_ledger_name($led_id);
                    $debitamt = 0;
                    $creditamt= 0;
					$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
					$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
                    if($debitamt['amount'] == '') $debitamt['amount'] = 0;
                    if($creditamt['amount'] == '') $creditamt['amount'] = 0;
                    $op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$dd['id'])->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
					if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
					{
						$op_balance_amt = $op_balance['cr_amount'];
					}
					else
					{
						$op_balance_amt = $op_balance['dr_amount'];
					}
					//echo $creditamt['amount'];
					//exit;
                    $clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
                    //echo $clbal.'<br>'; 
                    $datas[] = '<tr>
                                    <td><a style="margin-left: 5%;" href="'.base_url().'/accountreport/ledger_statement/'.$dd['id'].'" id="name_'.$nid.'">'.$ledgername.'</a></td>
                                    <td>Ledger</td>
                                    <td>'.number_format($op_balance_amt, "2",".",",").'</td>
                                    <td>'.number_format(abs($clbal), "2",".",",").'</td>';
                    if($ledger_p == 1) {				
                    $datas[] = '	<td>';
                        if($ledgere == 1 ) {
                        $datas[] = '
                                            <a style="color: #fff;" href="'.base_url().'/account/edit_ledger/'.$dd['id'].'">
                                                <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                            </a> 
                                            <a style="color: #fff;" href="'.base_url().'/account/edit_opbal/'.$dd['id'].'">
                                                <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                            </a>';
                        }
                        if($ledgerd == 1 ) {
                        $datas[] = '
                                        <a style="color: #fff;" href="#">
                                            <button class="btn btn-danger  btn-rad" onclick="confirm_modal('.$lid.')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                        </a>';
                        }
                    $datas[] = '
                                    </td>';
                    }
                    $datas[] = '<tr>';
                }
            }
            // Child Group
            $cgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
            foreach($cgroup as $crow){
                $lid = $crow['id'].',1';
                $nid = $crow['id'].'_1';
                //print_r($row);
                $datas[] = '<tr>
                                <td>&emsp;<span id="name_'.$nid.'">'.$crow['name'].'</span></td>
                                <td>Group</td>
                                <td>-</td>
                                <td>-</td>';
                if($group_p == 1) {
                    $datas[] = '	<td>';
                        if($group_e == 1 ) {
                        $datas[] = '		<a style="color: #fff;" href="'.base_url().'/account/edit_group/'.$crow['id'].'">
                                                <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                            </a>';
                                            
                        }
                        /*if($group_d == 1) {				
                        $datas[] = '		<a style="color: #fff;" href="#">
                                            <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
                                        </a>';
                        }	*/			
                                        
                    $datas[] = '	</td>';
                }
                $datas[] = '<tr>';
                $id =$crow['id'];
				if(!empty($_POST['ledger'])) 
				{
					$ledger_id = $_POST['ledger'];
					$res = $this->db->query("select * from ledgers where group_id = '".$id."' and id = '".$ledger_id."' ")->getResultArray();
				}
				else
				{
					$res = $this->db->query("select * from `ledgers` where group_id = '".$id."' ")->getResultArray();	
				}
                if(count($res) >0){
                    foreach($res as $dd){
                        $lid = $dd['id'].',2';
                        $nid = $dd['id'].'_2';
						$led_id = $dd['id'];
						$ledgername = get_ledger_name($led_id);
                        $debitamt = 0;
                        $creditamt= 0;
						$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
						if($debitamt['amount'] == '') $debitamt['amount'] = 0;
						if($creditamt['amount'] == '') $creditamt['amount'] = 0;		
                        $op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$dd['id'])->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
						if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
						{
							$op_balance_amt = $op_balance['cr_amount'];
						}
						else
						{
							$op_balance_amt = $op_balance['dr_amount'];
						}
                        $clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
                        $datas[] = '<tr>
                                        <td>&emsp;&emsp;<a style="margin-left: 5%;" href="'.base_url().'/accountreport/ledger_statement/'.$dd['id'].'" id="name_'.$nid.'">'.$ledgername.'</a></td>
                                        <td>Ledger</td>
                                        <td>'.number_format($op_balance_amt, "2",".",",").'</td>
                                        <td>'.number_format(abs($clbal), "2",".",",").'</td>';
                        if($ledger_p == 1) {				
                        $datas[] = '	<td>';
                            if($ledgere == 1 ) {
                            $datas[] = '
                                                <a style="color: #fff;" href="'.base_url().'/account/edit_ledger/'.$dd['id'].'">
                                                    <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                                </a> 
                                                <a style="color: #fff;" href="'.base_url().'/account/edit_opbal/'.$dd['id'].'">
                                                    <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                                </a>';
                            }
                            if($ledgerd == 1 ) {
                            $datas[] = '
                                            <a style="color: #fff;" href="#">
                                                <button class="btn btn-danger  btn-rad" onclick="confirm_modal('.$lid.')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                            </a>';
                            }
                        $datas[] = '
                                        </td>';
                        }
                        $datas[] = '<tr>';
                    }
                }
                // 2nd child
                $mcgroup = $this->db->query("select * from groups where parent_id = $id")->getResultArray();
                foreach($mcgroup as $mcrow){
                    $lid = $mcrow['id'].',1';
                    $nid = $mcrow['id'].'_1';
                    //print_r($row);
                    $datas[] = '<tr>
                                    <td>&emsp;&emsp;&emsp;<span id="name_'.$nid.'">'.$mcrow['name'].'</span></td>
                                    <td>Group</td>
                                    <td>-</td>
                                    <td>-</td>';
                    if($group_p == 1) {
                        $datas[] = '	<td>';
                            if($group_e == 1 ) {
                            $datas[] = '		<a style="color: #fff;" href="'.base_url().'/account/edit_group/'.$mcrow['id'].'">
                                                    <button class="btn btn-primary  btn-rad"><i class="material-icons">&#xE3C9;</i></button>
                                                </a>';
                                                
                            }
                           /* if($group_d == 1) {				
                            $datas[] = '		<a style="color: #fff;" href="#">
                                                <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
                                            </a>';
                            }	*/			
                                            
                        $datas[] = '	</td>';
                    }
                    $datas[] = '<tr>';
                    $id =$mcrow['id'];
					if(!empty($_POST['ledger'])) 
					{
						$ledger_id = $_POST['ledger'];
						$res = $this->db->query("select * from ledgers where group_id = '".$id."' and id = '".$ledger_id."' ")->getResultArray();
					}
					else
					{
						$res = $this->db->query("select * from `ledgers` where group_id = '".$id."' ")->getResultArray();	
					}
                    if(count($res) >0){
                        foreach($res as $dd){
							$led_id = $dd['id'];
							$ledgername = get_ledger_name($led_id);
                            $lid = $dd['id'].',2';
                            $nid = $dd['id'].'_2';
                            $debitamt = 0;
                            $creditamt= 0;
							$debitamt =	$this->db->query("select sum(entryitems.amount) as amount 
								from entryitems 
								inner join entries on entries.id = entryitems. entry_id
								where entryitems.dc = 'D' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							$creditamt = $this->db->query("select sum(entryitems.amount) as amount 
									from entryitems 
									inner join entries on entries.id = entryitems. entry_id
									where entryitems.dc = 'C' and entryitems.ledger_id = $led_id and entries.date >= '$sdate' and entries.date <= '$tdate'")->getRowArray();
							if($debitamt['amount'] == '') $debitamt['amount'] = 0;
							if($creditamt['amount'] == '') $creditamt['amount'] = 0;
                            $op_balance = $this->db->table('ac_year_ledger_balance')->select('dr_amount,cr_amount')->where('ledger_id',$dd['id'])->where('ac_year_id',$ac_id['id'])->get()->getRowArray();
							if($op_balance['dr_amount'] == "0.00" || $op_balance['dr_amount'] == "")
							{
								$op_balance_amt = $op_balance['cr_amount'];
							}
							else
							{
								$op_balance_amt = $op_balance['dr_amount'];
							}
							$clbal = ($op_balance_amt - $creditamt['amount']) + $debitamt['amount'];
                            $datas[] = '<tr>
                                            <td>&emsp;&emsp;&emsp;&emsp;<a style="margin-left: 5%;" href="'.base_url().'/accountreport/ledger_statement/'.$dd['id'].'" id="name_'.$nid.'">'.$ledgername.'</a></td>
                                            <td>Ledger</td>
                                            <td>'.number_format($op_balance_amt, "2",".",",").'</td>
                                            <td>'.number_format(abs($clbal), "2",".",",").'</td>';
                            if($ledger_p == 1) {				
                            $datas[] = '	<td>';
                                if($ledgere == 1 ) {
                                $datas[] = '
                                                    <a style="color: #fff;" href="'.base_url().'/account/edit_ledger/'.$dd['id'].'">
                                                        <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
                                                    </a> 
                                                    <a style="color: #fff;" href="'.base_url().'/account/edit_opbal/'.$dd['id'].'">
                                                        <button class="btn btn-success  btn-rad"><i class="material-icons">attach_money</i></button>
                                                    </a>';
                                }
                                if($ledgerd == 1 ) {
                                $datas[] = '
                                                <a style="color: #fff;" href="#">
                                                    <button class="btn btn-danger  btn-rad" onclick="confirm_modal('.$lid.')" style="color: #fff;"><i class="material-icons">&#xE872;</i></button>
                                                </a>';
                                }
                            $datas[] = '
                                            </td>';
                            }
                            $datas[] = '<tr>';
                        }
                    }
                }
            }
        }
		$data['list'] = $datas;
        $data['check_financial_year'] = $this->db->table("ac_year")->where('status', 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/index', $data);
		echo view('template/footer');
    }
	
	public function add_group(){		
		
		if(!$this->model->permission_validate('group', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_group', $data);
		echo view('template/footer');
    }
	
	public function edit_group(){
		if(!$this->model->permission_validate('group', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('groups')->where("id", $id)->get()->getRowArray();
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		//print_r($data);die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/edit_group', $data);
		echo view('template/footer');
	}

	public function save_add_group() {
		$id = $_POST['id'];
		
		$data['parent_id']	 =	$_POST['pgroup'];
		$data['name']		 =	$_POST['gname'];
		$data['code']	 	 =	$_POST['gcode'];
		$data['added_by']	 =	$this->session->get('log_id');
	
		if(empty($id)){
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('groups')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Groups Added Successfully');
    		    header("Location: ".base_url()."/account");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/account");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('groups')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Groups Update Successfully');
    		    header("Location: ".base_url()."/account");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/account");
    		}
		}
	}
	
	public function add_ledger(){
		if(!$this->model->permission_validate('ledger', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/add_ledger', $data);
		echo view('template/footer');
    }

	public function edit_ledger(){
		if(!$this->model->permission_validate('ledger', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['data'] = $this->db->table('ledgers')->where("id", $id)->get()->getRowArray();
		$data['group'] = $this->db->table('groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/edit_ledger', $data);
		echo view('template/footer');
	}

	public function entries(){
		if(!$this->model->list_validate('entries_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('entries_accounts');
		$data['data'] = $this->db->table('entries')->where('inv_id', null)->where('type', null)->orderBy('id', 'desc')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('entries/index', $data);
		echo view('template/footer');
	}

	public function save_add_ledger(){
		$id = $_POST['id'];
		$data['group_id'] = $_POST['lgroup'];
		$data['name'] = $_POST['lname'];
		$data['code'] = $_POST['lcode'];
		$data['op_balance'] = $_POST['op_bal'];
		$data['op_balance_dc'] = $_POST['op_dc'];
		$data['type'] = $_POST['type'];
		$data['reconciliation'] = $_POST['reconciliation'];
		$data['left_code'] = $_POST['left_code'];
		$data['right_code'] = $_POST['right_code'];
		//echo '<pre>';
		//print_r($data);die;
		$ac_id = $this->db->table("ac_year")->where('status', 1)->get()->getRowArray();
		if(empty($id)){
			$res = $this->db->table('ledgers')->insert($data);
			if($res){
				$ledger_id=$this->db->insertID();
				if($_POST['op_dc'] == "D"){
					$acdata['dr_amount'] = $_POST['op_bal'];
					$acdata['cr_amount'] = "0.00";
				}
				else{
					$acdata['cr_amount'] = $_POST['op_bal'];
					$acdata['dr_amount'] = "0.00";
				}
				$acdata['ledger_id'] = $ledger_id;
				$acdata['ac_year_id'] = $ac_id['id'];
				$this->db->table('ac_year_ledger_balance')->insert($acdata);
				
				$this->session->setFlashdata('succ', 'Ledger Add Successfully');
				header("Location: ".base_url()."/account");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/account");
			}
		}else{
			$res = $this->db->table('ledgers')->where('id', $id)->update($data);
			if($res){
				$this->session->setFlashdata('succ', 'Ledger Update Successfully');
				header("Location: ".base_url()."/account");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/account");
			}
		}
	}

	public function check_group(){
		$id = $this->request->uri->getSegment(3);
		$ent = $this->db->table('entryitems')->where('ledger_id', $id)->get()->getNumRows();
		$led = $this->db->table('ledgers')->where('group_id', $id)->get()->getNumRows();
		$grp = $this->db->table('groups')->where('parent_id', $id)->get()->getNumRows();
		if($ent == 0 && $led == 0 && $grp == 0) $res = true;
		else $res = false;
		echo json_encode($res);
	}
	public function check_ledger(){
		$id = $this->request->uri->getSegment(3);
		$ent = $this->db->table('entryitems')->where('ledger_id', $id)->get()->getNumRows();
		if($ent == 0) $res = true;
		else $res = false;
		echo json_encode($res);
	}

	public function delete_group(){
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('groups')->delete(['id' => $id]);
		if($res){
			$this->session->setFlashdata('succ', 'Group Delete Successfully');
			header("Location: ".base_url()."/account");
		}else{
			$this->session->setFlashdata('fail', 'Please Try Again...');
			header("Location: ".base_url()."/account");
		}
	}

	public function delete_ledger(){
		$id = $this->request->uri->getSegment(3);
		$res = $this->db->table('ledgers')->delete(['id' => $id]);
		if($res){
			$this->session->setFlashdata('succ', 'Ledger Delete Successfully');
			header("Location: ".base_url()."/account");
		}else{
			$this->session->setFlashdata('fail', 'Please Try Again...');
			header("Location: ".base_url()."/account");
		}
	}
	
	public function edit_opbal(){
		if(!$this->model->permission_validate('ledger', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['id'] = $id;
		//$data['data1'] = $this->db->table('ledgers')->where("id", $id)->get()->getRowArray();
		$data['data'] = $this->db->table('ac_year_ledger_balance')->where("ledger_id", $id)->get()->getRowArray();
		$data['year'] = $this->db->table('ac_year')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/edit_opbal', $data);
		echo view('template/footer');
	}
	
	public function save_add_ledger_opbal(){
		$year = $_POST['fyear'];
		$id = $_POST['id'];
		$data['ac_year_id'] = $year;
		$data['ledger_id'] = $id;
		$selval =  $_POST['op_dc'];
		if ($selval == "D") {
			$data['dr_amount'] = $_POST['op_bal'];
			$data['cr_amount'] = "0.00";
		}
		else if ($selval == "C") 
		{
			$data['dr_amount'] = "0.00";
			$data['cr_amount'] = $_POST['op_bal'];
		}
		$data_exists = $this->db->table('ac_year_ledger_balance')->where('ledger_id', $id)->where('ac_year_id', $year)->get()->getNumRows();
		//echo '<pre>';
		//print_r($data);die;
		if($data_exists > 0)  {
			$res = $this->db->table('ac_year_ledger_balance')->where('ledger_id', $id)->where('ac_year_id', $year)->update($data);
			if($res){
				$this->session->setFlashdata('succ', 'Opening Balance Updated Successfully');
				header("Location: ".base_url()."/account");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/account");
			}
		}else{
			$res = $this->db->table('ac_year_ledger_balance')->insert($data);
			if($res){
				$this->session->setFlashdata('succ', 'Opening Balance Added Successfully');
				header("Location: ".base_url()."/account");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/account");
			}
		}
	}
	
	public function get_amt()
	{
      $id = $_POST['id'];
	  $yr = $_POST['yr'];
      $res = $this->db->table("ac_year_ledger_balance")->where("ledger_id", $id)->where("ac_year_id", $yr)->get()->getRowArray();
	  if($res['cr_amount'] == "0.00")
	  { 
		  $data['select'] = "D"; 
		  $data['amt'] = $res['dr_amount']; 
	  }
	  else if($res['dr_amount'] == "0.00")
	  { 
		  $data['select'] = "C"; 
		  $data['amt'] = $res['cr_amount']; 
	  }
	  else 
	  { 
		  $data['select'] = "D"; 
		  $data['amt'] = "0.00";  
	  }
      echo json_encode($data);
    }
	
}
