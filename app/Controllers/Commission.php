<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Commission extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper("common");
        $this->model = new PermissionModel();
        if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
    
    public function index(){
		if(!$this->model->list_validate('commission')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('commission');

		$data['list'] = $this->db->table('commission')->join('staff','staff.id = commission.staff_id')->select('commission.*,staff.name as staff_name')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('commission/index',$data);
		echo view('template/footer');
    }
	public function view(){
	    if(!$this->model->permission_validate('member','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		
	    
	    $data['data'] = $this->db->table('commission')->where('id', $id)->get()->getRowArray();
		$data['staff_list'] = $this->db->table('staff')->where('is_admin',0)->where('status', 1)->orderBy('name', 'ASC')->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('commission/add', $data);
		echo view('template/footer');
	}
	public function add()
	{
		if(!$this->model->permission_validate('commission', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['staff_list'] = $this->db->table('staff')->where('is_admin',0)->where('status', 1)->orderBy('name', 'ASC')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('commission/add',$data);
		echo view('template/footer');
	}
	public function edit(){
	    if(!$this->model->permission_validate('commission','edit')){
			header('Location: '.base_url().'/dashboard');			
		}
	    $id=  $this->request->uri->getSegment(3);
	    $data['data'] 		= $this->db->table('commission')->where('id', $id)->get()->getRowArray();
		$data['staff_list'] = $this->db->table('staff')->where('is_admin',0)->where('status', 1)->orderBy('name', 'ASC')->get()->getResultArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('commission/add', $data);
		echo view('template/footer');
	}

	public function save(){
		// echo '<pre>'; print_r($_POST); die;
		$id = $_POST['id'];
        $data['date']		    =	trim($_POST['commission_date']);
		$data['type']    =	trim($_POST['commission_type']);
		$data['amount']    		=	trim($_POST['commission_amount']);
		$data['staff_id']  =	trim($_POST['commission_staff']);
		$data['remarks']  =	trim($_POST['commission_remarks']);

		if(empty($id)){
			$data['created']  =	date('Y-m-d H:i:s');
			$res = $this->db->table('commission')->insert($data);
			if($res){
				$this->session->setFlashdata('succ', 'commission Added Successfully');
				header("Location: ".base_url()."/commission");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/commission");
			}
		}else{
			$data['updated'] = date('Y-m-d H:i:s');
			$res = $this->db->table('commission')->where('id', $id)->update($data);
			if($res){
				$this->session->setFlashdata('succ', 'commission Updated Successfully');
				header("Location: ".base_url()."/commission");
			}else{
				$this->session->setFlashdata('fail', 'Please Try Again');
				header("Location: ".base_url()."/commission");
			}
		}
	}
	
	public function delete()
	{
		if(!$this->model->permission_validate('commission','delete_p')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id=  $this->request->uri->getSegment(3);
		$res=$this->db->table('commission')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'commission Deleted Successfully');
		    header("Location: ".base_url()."/commission");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/commission");
		}
		header("Location: ".base_url()."/commission");
	     
	}
	
	
	public function print_page(){
		if(!$this->model->permission_validate('commission','print')){
			header('Location: '.base_url().'/dashboard');			
		}
	 	$id = $this->request->uri->getSegment(3);

		$data['qry1'] = $this->db->table('commission')->where('id', $id)->get()->getRowArray();
		echo view('commission/print_page', $data);
	}
	
}
