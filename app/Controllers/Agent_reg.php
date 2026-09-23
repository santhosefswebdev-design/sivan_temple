<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Agent_reg extends BaseController
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
		if(!$this->model->list_validate('agent_registration')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('agent_registration');
		$data['list'] = $this->db->table("agent")
								->where("status", 1)
								->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('agent/index',$data);
		echo view('template/footer');
    }
	public function view(){
	    if(!$this->model->permission_validate('agent_registration','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('agent')->where('id', $id)->get()->getRowArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('agent/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if(!$this->model->permission_validate('agent_registration', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('agent/add');
		echo view('template/footer');
	}
	public function edit(){
	    if(!$this->model->permission_validate('agent_registration','edit')){
			header('Location: '.base_url().'/dashboard');			
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] 		= $this->db->table('agent')->where('id', $id)->get()->getRowArray();
		$data['edit'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('agent/add', $data);
		echo view('template/footer');
	}

	public function save()
	{
		$id = $_POST['id'];
		if(empty($id)){
			$agent_data = array(
							"name"=>$_POST['name'],
							"email"=>$_POST['email'],
							"username"=>$_POST['username'],
							"password"=>$_POST['password'],
							"address"=>$_POST['address'],
							"city"=>!empty($_POST['city'])?$_POST['city']:"",
							"state"=>!empty($_POST['state'])?$_POST['state']:"",
							"country"=>!empty($_POST['country'])?$_POST['country']:"",
							"phoneno"=>!empty($_POST['phoneno'])?$_POST['phoneno']:"",
							"description"=>$_POST['description']
						);
			$this->db->table('agent')->insert($agent_data);
			$agent_id = $this->db->insertID();
			$user_data = array(
							"name"=>$_POST['name'],
							"email"=>$_POST['email'],
							"username"=>$_POST['username'],
							"password"=>$_POST['password'],
							"role"=>99,
							"profile_id"=>1,
							"member_comes"=>"agent",
							"index_id"=>$agent_id,
							"created"=>date("Y-m-d H:i:s"),
							"modified"=>date("Y-m-d H:i:s")
						);
			$this->db->table('login')->insert($user_data);
			//echo '<pre>'; print_r($data); die;
			$this->db->table('login')->insert($data);
			$this->session->setFlashdata('succ', 'Agent Added Successfully');
			return redirect()->to("/agent_reg");
		}else{
			$agent_data = array(
				"name"=>$_POST['name'],
				"email"=>$_POST['email'],
				"address"=>$_POST['address'],
				"city"=>!empty($_POST['city'])?$_POST['city']:"",
				"state"=>!empty($_POST['state'])?$_POST['state']:"",
				"country"=>!empty($_POST['country'])?$_POST['country']:"",
				"phoneno"=>!empty($_POST['phoneno'])?$_POST['phoneno']:"",
				"description"=>$_POST['description']
			);
			$this->db->table('agent')->where('id', $id)->update($agent_data);
			$user_data = array(
				"name"=>$_POST['name'],
				"email"=>$_POST['email'],
				//"username"=>$_POST['username'],
				//"password"=>$_POST['password'],
				"modified"=>date("Y-m-d H:i:s")
			);
			$this->db->table('login')->where('index_id', $id)->update($user_data);
			$this->session->setFlashdata('succ', 'Agent Updated Successfully');
			return redirect()->to("/agent_reg");
		}
	}
	public function findusernameExists()
    {
		$username =  $this->request->getPost('username');
        $updateid = $this->request->getPost('update_id');
		if(!empty($updateid))
		{
			$query = $this->db->table('agent')->where(['name' => $username,'id !=' => $updateid,'status'=>1])->countAllResults();
		}
        else
		{
			$query = $this->db->table('agent')->where(['name' => $username,'status'=>1])->countAllResults();
		}
        if($query > 0){
            echo "false";
        }else{
            echo "true";
        }
    }
	public function findemailExists()
    {
		$email =  $this->request->getPost('email');
        $updateid = $this->request->getPost('update_id');
		if(!empty($updateid))
		{
			$query = $this->db->table('agent')->where(['email' => $email,'id !=' => $updateid,'status'=>1])->countAllResults();
		}
        else
		{
			$query = $this->db->table('agent')->where(['email' => $email,'status'=>1])->countAllResults();
		}
        if($query > 0){
            echo "false";
        }else{
            echo "true";
        }
    }
	public function delete()
	{
		if(!$this->model->permission_validate('member','delete_p')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id=  $this->request->uri->getSegment(3);
		$res=$this->db->table('agent')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Member Type Deleted Successfully');
		    header("Location: ".base_url()."/agent_reg");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/agent_reg");
		}
		header("Location: ".base_url()."/agent_reg");
	     
	}
	
}
