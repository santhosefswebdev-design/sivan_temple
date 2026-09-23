<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class User extends BaseController
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
		
		if (!$this->model->list_validate('user_setting')){
        header('Location: '.base_url().'/dashboard');
		}
	  $data['permission'] = $this->model->get_permission('user_setting');
      $data['list'] = $this->db->table('login')->orderBy('id', 'DESC')
      ->get()->getResultArray();
      echo view('template/header');
      echo view('template/sidebar');
      echo view('user/index',$data);
      echo view('template/footer');

    }
    public function add()
    {
		
	  
      $data['data'] = $this->db->table('login')->get()->getResultArray();
	  $data['role'] = $this->db->table('role_list')->get()->getResultArray();
	  
      echo view('template/header');
      echo view('template/sidebar');
      echo view('user/add', $data);
      echo view('template/footer');
    }
    public function save(){

      $id = $_POST['id'];

        $data['name']		              =	$_POST['name'];
        $data['username']	 	          =	$_POST['user_name'];
        $data['password']	  	        =	$_POST['password'];
        $data['role']                 = $_POST['role'];
        $data['member_comes']          = $_POST['member_comes'];
		$data['email']		            =	$_POST['mailid'];
        $data['profile_id']	          =	1;
        $data['status']		            =	1;

        //echo $id; die;
        if(empty($id)){
          $data['created']  =	date('Y-m-d H:i:s');
          $res = $this->db->table('login')->insert($data);
            if($res){
              $this->session->setFlashdata('succ', 'User Added Successfully');
              header("Location: ".base_url()."/user");
            }else{
              $this->session->setFlashdata('fail', 'Please Try Again');
              header("Location: ".base_url()."/user");
            }
        }
        else{
          $data['modified' ] = date('Y-m-d H:i:s');
            $res = $this->db->table('login')->where('id', $id)->update($data);
            if($res){
                $this->session->setFlashdata('succ', 'User Update Successfully');
                header("Location: ".base_url()."/user");
            }else{
                $this->session->setFlashdata('fail', 'Please Try Again');
                header("Location: ".base_url()."/user");
            }

        }


    }
    public function edit(){
      $id=  $this->request->uri->getSegment(3);
		
	    $data['data'] = $this->db->table('login')->where('id', $id)->get()->getRowArray();
		  $data['role'] = $this->db->table('role_list')->get()->getResultArray();
		  //$data['view'] = true;
	    echo view('template/header');
      echo view('template/sidebar');
      echo view('user/add', $data);
      echo view('template/footer');
    }
  public function view(){
	    $id=  $this->request->uri->getSegment(3);
		$data['role'] = $this->db->table('role_list')->get()->getResultArray();
	    $data['data'] = $this->db->table('login')->where('id', $id)->get()->getRowArray();
		  $data['view'] = true;
	    echo view('template/header');
      echo view('template/sidebar');
      echo view('user/add', $data);
      echo view('template/footer');
	}
	
  public function validation(){
    $name = trim($_POST['name']);
    $user = trim($_POST['user_name']);
    $pass = trim($_POST['password']);
    //$email = trim($_POST['mailid']);
    $data = array();
    if (empty($name) || empty($user) || empty($pass) ) {
      $data['err'] = "Please Fill Out Fields";
      $data['succ']= '';
    }else{
      $data['succ'] = "Form validate";
      $data['err'] ='';
    }
    echo json_encode($data);
  }
  
  public function user_role()
    {
      if($_SESSION['role'] != 1){
        header('Location: '.base_url().'/dashboard');
      }
      $data['data'] = $this->db->table('role_list')->get()->getResultArray();
      echo view('template/header');
      echo view('template/sidebar');
      echo view('user/user_role', $data);
      echo view('template/footer');
    }
	
	public function add_user_role()
    {
      if($_SESSION['role'] != 1){
        header('Location: '.base_url().'/dashboard');
      }
      echo view('template/header');
      echo view('template/sidebar');
      echo view('user/add_user_role');
      echo view('template/footer');
    }
	
	public function del_check(){
		$id = $_POST['id'];
		//$res = "SELECT (select count(*) from archanai_booking where comission_to=$id) + (select count(*) from hall_booking where commision_to=$id) as total_rows";
		$res   = $this->db->query("SELECT (select count(id) from donation where added_by=$id) 
										+ (select count(id) from hall_booking where entry_by=$id) 
										+ (select count(id) from pay_slip where entry_by=$id) 
										+ (select count(id) from stock_inward where added_by=$id) 
										+ (select count(id) from stock_outward where added_by=$id) 
										+ (select count(id) from ubayam where added_by=$id) 
										+ (select count(id) from groups where added_by=$id) 
										+ (select count(id) from archanai where added_by=$id) 
										+ (select count(id) from archanai_booking where entry_by=$id) 
										as total_rows")->getRowArray();
						
						echo $res['total_rows'];
	}
	public function delete_user(){
	    if(!$this->model->permission_validate('user_setting', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
		//echo  $id; exit;
		$res = $this->db->table('login')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'User Delete Successfully');
		    header("Location: ".base_url()."/user/index");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/user/index");
		}
	}
	
}
