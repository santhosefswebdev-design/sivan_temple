<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Test extends BaseController
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
		if(!$this->model->list_validate('ac_creation_accounts')){
			header('Location: '.base_url().'/dashboard');
		}
		$datas = array();
        $group = $this->model->get_permission('group');
        if($group['edit'] == 1 ||  $group['delete_p'] == 1) $group_p = 1; else $group_p = 0;
        if($group['edit'] == 1 ) $group_e = 1; else $group_e = 0;
        if($group['delete_p'] == 1 ) $group_d = 1; else $group_d = 0;
        $ledgerp = $this->model->get_permission('ledger');
        if($ledgerp['edit'] == 1 ||  $ledgerp['delete_p'] == 1) $ledger_p = 1; else $ledger_p = 0;
        if($ledgerp['edit'] == 1 ) $ledgere = 1; else $ledgere = 0;
        if($ledgerp['delete_p'] == 1 ) $ledgerd = 1; else $ledgerd = 0;
		$data['permission'] = $this->model->get_permission('ac_creation_accounts');
		$data['add_group'] = $this->model->get_permission('group');
		$data['add_ledger'] = $this->model->get_permission('ledger');
        //Parent Group
        $parent = $this->db->query("select * from groups where parent_id is NULL or parent_id =''")->getResultArray();
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
                    if($group_d == 1) {				
                    $datas[] = '		<a style="color: #fff;" href="#">
                                        <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
                                    </a>';
                    }				
                                    
                $datas[] = '	</td>';
			}
			$datas[] = '<tr>';
            $id =$row['id'];
            $res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
            if(count($res) >0){
                foreach($res as $dd){
                    $lid = $dd['id'].',2';
                    $nid = $dd['id'].'_2';
                    $debitamt = 0;
                    $creditamt= 0;
                    $debitamt = $this->db->table('entryitems')->selectSum('amount')->where('dc','D')->where('ledger_id',$dd['id'])->get()->getRow()->amount;
                    $creditamt = $this->db->table('entryitems')->selectSum('amount')->where('dc','C')->where('ledger_id',$dd['id'])->get()->getRow()->amount;
                    $clbal = ($dd['op_balance'] - $debitamt) + $creditamt;
                    //echo $clbal.'<br>'; 
                    $datas[] = '<tr>
                                    <td><a style="margin-left: 5%;" href="'.base_url().'/accountreport/ledger_statement/'.$dd['id'].'" id="name_'.$nid.'">'.$dd['name'].'</a></td>
                                    <td>Ledger</td>
                                    <td>'.number_format($dd['op_balance'], "2",".",",").'</td>
                                    <td>'.number_format($clbal, "2",".",",").'</td>';
                    if($ledger_p == 1) {				
                    $datas[] = '	<td>';
                        if($ledgere == 1 ) {
                        $datas[] = '
                                            <a style="color: #fff;" href="'.base_url().'/account/edit_ledger/'.$dd['id'].'">
                                                <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
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
                        if($group_d == 1) {				
                        $datas[] = '		<a style="color: #fff;" href="#">
                                            <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
                                        </a>';
                        }				
                                        
                    $datas[] = '	</td>';
                }
                $datas[] = '<tr>';
                $id =$crow['id'];
                $res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
                if(count($res) >0){
                    foreach($res as $dd){
                        $lid = $dd['id'].',2';
                        $nid = $dd['id'].'_2';
                        $debitamt = 0;
                        $creditamt= 0;
                        $debitamt = $this->db->table('entryitems')->selectSum('amount')->where('dc','D')->where('ledger_id',$dd['id'])->get()->getRow()->amount;
                        $creditamt = $this->db->table('entryitems')->selectSum('amount')->where('dc','C')->where('ledger_id',$dd['id'])->get()->getRow()->amount;
                        $clbal = ($dd['op_balance'] - $debitamt) + $creditamt;
                        //echo $clbal.'<br>'; 
                        $datas[] = '<tr>
                                        <td>&emsp;&emsp;<a style="margin-left: 5%;" href="'.base_url().'/accountreport/ledger_statement/'.$dd['id'].'" id="name_'.$nid.'">'.$dd['name'].'</a></td>
                                        <td>Ledger</td>
                                        <td>'.number_format($dd['op_balance'], "2",".",",").'</td>
                                        <td>'.number_format($clbal, "2",".",",").'</td>';
                        if($ledger_p == 1) {				
                        $datas[] = '	<td>';
                            if($ledgere == 1 ) {
                            $datas[] = '
                                                <a style="color: #fff;" href="'.base_url().'/account/edit_ledger/'.$dd['id'].'">
                                                    <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
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
                            if($group_d == 1) {				
                            $datas[] = '		<a style="color: #fff;" href="#">
                                                <button class="btn btn-danger btn-rad" onclick="confirm_modal('.$lid.')"><i class="material-icons">&#xE872;</i></button>
                                            </a>';
                            }				
                                            
                        $datas[] = '	</td>';
                    }
                    $datas[] = '<tr>';
                    $id =$mcrow['id'];
                    $res = $this->db->query("select * from `ledgers` where group_id = $id")->getResultArray();
                    if(count($res) >0){
                        foreach($res as $dd){
                            $lid = $dd['id'].',2';
                            $nid = $dd['id'].'_2';
                            $debitamt = 0;
                            $creditamt= 0;
                            $debitamt = $this->db->table('entryitems')->selectSum('amount')->where('dc','D')->where('ledger_id',$dd['id'])->get()->getRow()->amount;
                            $creditamt = $this->db->table('entryitems')->selectSum('amount')->where('dc','C')->where('ledger_id',$dd['id'])->get()->getRow()->amount;
                            $clbal = ($dd['op_balance'] - $debitamt) + $creditamt;
                            //echo $clbal.'<br>'; 
                            $datas[] = '<tr>
                                            <td>&emsp;&emsp;&emsp;&emsp;<a style="margin-left: 5%;" href="'.base_url().'/accountreport/ledger_statement/'.$dd['id'].'" id="name_'.$nid.'">'.$dd['name'].'</a></td>
                                            <td>Ledger</td>
                                            <td>'.number_format($dd['op_balance'], "2",".",",").'</td>
                                            <td>'.number_format($clbal, "2",".",",").'</td>';
                            if($ledger_p == 1) {				
                            $datas[] = '	<td>';
                                if($ledgere == 1 ) {
                                $datas[] = '
                                                    <a style="color: #fff;" href="'.base_url().'/account/edit_ledger/'.$dd['id'].'">
                                                        <button class="btn btn-primary  btn-rad" style="color: #fff;"><i class="material-icons">&#xE3C9;</i></button>
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
		$data['group'] = $this->db->table('groups')->get()->getResultArray();

		$data['list'] = $datas;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('account/test', $data);
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
		$data['data'] = $this->db->table('entries')->orderBy('id', 'desc')->get()->getResultArray();
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
		//echo '<pre>';
		//print_r($data);die;
		if(empty($id)){
			$res = $this->db->table('ledgers')->insert($data);
			if($res){
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
}
