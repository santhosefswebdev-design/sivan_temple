<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Notification extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		$res =  $this->db->table('notification')->where('status', 1)->get()->getResultArray();
		$data['list'] = $res;
        // echo '<pre>'; print_r($data); die;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('notification/index',$data);
		echo view('template/footer');
    }
	public function view(){
	    if(!$this->model->permission_validate('member','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('notification')->where('id', $id)->get()->getRowArray();
		$data['members_list'] = $this->db->table('member')->where("status", 1)->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('notification/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if(!$this->model->permission_validate('member', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['members_list'] = $this->db->table('member')->where("status", 1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('notification/add', $data);
		echo view('template/footer');
	}
	public function edit(){
	    if(!$this->model->permission_validate('member','edit')){
			header('Location: '.base_url().'/dashboard');			
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] 		= $this->db->table('notification')->where('id', $id)->get()->getRowArray();
		$data['members_list'] = $this->db->table('member')->where("status", 1)->get()->getResultArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('notification/add', $data);
		echo view('template/footer');
	}

	public function save(){
		$email = \Config\Services::email();
		// echo '<pre>'; print_r($_POST); die;
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$id = $_POST['id'];
		$data['type'] =	$_POST['type'];
		if(empty($data['type']))
		{
			$msg_data['err'] =  'Please choose type.';
		}
		else{
			if(empty($_POST['title']))
			{
				$msg_data['err'] =  'Please enter title.';
			}
			else if($data['type'] == "Group" && empty($_POST['group_name']) && empty($_POST['group_member_no']))
			{
				$msg_data['err'] =  'Please enter required fields.';
			}
			else if($data['type'] == "Individual" && empty($_POST['member_no']))
			{
				$msg_data['err'] =  'Please enter member no.';
			}
			else
			{
				if($data['type'] == "Group")
				{
					$memno = implode(",", $_POST['group_member_no']);
					$data['group_name'] =	$_POST['group_name'];
				}
				elseif($data['type'] == "Individual")
				{
					$memno = $_POST['member_id'];
				}
				else
				{
					$member_details = $this->db->table('member')->where("status", 1)->get()->getResultArray();
					$mem_det_aray = array();
					foreach($member_details as $member_detail)
					{
						$mem_det_aray[] = $member_detail['id'];
					}
					$memno = implode(",", $mem_det_aray);
				}
				//var_dump($memno);
				//exit;
				$data['member_id'] =	$memno;
				$data['title'] =	$_POST['title'];
				$data['description'] =	$_POST['description'];
				if(!empty($_FILES['file_up']['name']) > 0){
					$logoimg = time() . '_' .$_FILES['file_up']['name'];
					$target_dir = "uploads/notification/";
					move_uploaded_file($_FILES['file_up']['tmp_name'],$target_dir.$logoimg);
					$data['file_upload'] = $logoimg;
				}
				if(empty($id))
				{
					$this->db->table('notification')->insert($data);
					$insert_id = $this->db->insertID();
					$member_noti_dets = $this->db->table('member')->select('email_address')->whereIn("id", array($memno))->get()->getResultArray();
					$member_attachs = $this->db->table('notification')->select('file_upload')->where("id", $insert_id)->get()->getRowArray();
					foreach($member_noti_dets as $member_noti_det)
					{
						if(!empty($member_noti_det['email_address']))
						{
							$titll = !empty($_POST['title'])?$_POST['title']: "";
							$descriptionnn = !empty($_POST['description'])?$_POST['description']: "";
							$title_notitfication = $titll." - RAJAMARIAMMAN TEMPLE NOTIFICATION";
							$email->setFrom('templetest@grasp.com.my', 'RAJAMARIAMMAN TEMPLE');
							$email->setTo($member_noti_det['email_address']);
							//$email->setCC('cc@example.com');
							//$email->setBCC('bcc@example.com');
							$email->setSubject($title_notitfication);
							if(!empty($member_attachs['file_upload']))
							{
								$attments = "./uploads/notification/".$member_attachs['file_upload'];
								$email->attach($attments);
							}
							$email->setMessage($descriptionnn);
							$email->send();
						}
					}
					$msg_data['succ'] = 'Notification detail added successfully';
				}
				else
				{
					$this->db->table('notification')->where("id", $id)->update($data);
					$msg_data['succ'] = 'Notification detail updated successfully';
				}
			}
		}
		echo json_encode($msg_data);
		exit();
	}

	public function searchmemberno() 
	{
		$name = $_POST['search'];
		$data = array();
		$res = $this->db->query("select id,member_no,name from member where name like '%".$name."%' OR member_no like '%".$name."%' ")->getResultArray();
		foreach($res as $row){
			//$data[] = $row['name'];
			$data[]=array('value'=>$row['id'],'label'=>$row['member_no'].' - '.$row['name']);
		}
		echo json_encode($data);
    }
	
}
