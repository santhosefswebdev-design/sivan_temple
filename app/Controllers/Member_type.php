<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Member_type extends BaseController
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
		if(!$this->model->list_validate('member')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('member');

		$data['list'] = $this->db->table('member_type')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member_type/index',$data);
		echo view('template/footer');
    }
	public function view(){
	    if(!$this->model->permission_validate('member','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		
	    
	    $data['data'] = $this->db->table('member_type')->where('id', $id)->get()->getRowArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('member_type/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if(!$this->model->permission_validate('member', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		echo view('template/header');
		echo view('template/sidebar');
		echo view('member_type/add');
		echo view('template/footer');
	}
	public function edit(){
	    if(!$this->model->permission_validate('member','edit')){
			header('Location: '.base_url().'/dashboard');			
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] 		= $this->db->table('member_type')->where('id', $id)->get()->getRowArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('member_type/add', $data);
		echo view('template/footer');
	}

	public function save(){
		// echo '<pre>'; print_r($_POST); die;
		$id = $_POST['id'];
        $data['name']		    =	trim($_POST['name']);
		$data['description']    =	trim($_POST['description']);
		$data['amount']    		=	trim($_POST['amount']);
		$data['payment_terms']  =	trim($_POST['payment_terms']);

		if(empty($id)){
			$data['created']  =	date('Y-m-d H:i:s');
			$data['updated'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member_type')->insert($data);
			if($res){
				$this->session->setFlashdata('succ', 'Member Type Added Successfully');
				header("Location: ".base_url()."/member_type");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/member_type");
			}
		}else{
			$data['updated'] = date('Y-m-d H:i:s');
			$res = $this->db->table('member_type')->where('id', $id)->update($data);
			if($res){
				$this->session->setFlashdata('succ', 'Member Type Updated Successfully');
				header("Location: ".base_url()."/member_type");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/member_type");
			}
		}
	}
	
	public function delete()
	{
		if(!$this->model->permission_validate('member','delete_p')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id=  $this->request->uri->getSegment(3);
		$res=$this->db->table('member_type')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Member Type Deleted Successfully');
		    header("Location: ".base_url()."/member_type");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/member_type");
		}
		header("Location: ".base_url()."/member_type");
	     
	}
	public function del_member_type_check()
	{
		$id = $_POST['id'];
		$res = $this->db->table("member")->where("member_type", $id)->get()->getResultArray();
		echo count($res);
	}


	public function print_page(){
		if(!$this->model->permission_validate('member','print')){
			header('Location: '.base_url().'/dashboard');			
		}
	 	$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $this->db->table('member')->where('id', $id)->get()->getRowArray();
		echo view('member/print_page', $data);
	}
	
}
