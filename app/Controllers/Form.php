<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Form extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        $this->model = new PermissionModel();
        
    }
    
    public function index(){
      echo view('form/index');
    }
    
    public function list(){
      $data['list'] = $this->db->table('registration_form')->get()->getResultArray();
      echo view('form/list', $data);
    }
    
    public function save() {
    
		$data['name']	 =	trim($_POST['name']);
		$data['citizen']		 =	trim($_POST['citizen']);
		$data['type']	 =	trim($_POST['type']);
		$data['pax']		 =	trim($_POST['pax']);
		$data['comments']	 =	trim($_POST['comments']);
	    $data['created_at']  =	date('Y-m-d H:i:s');
	    $this->db->table('registration_form')->insert($data);
	    $ins_id = $this->db->insertID();
        $msg_data['id']   = $ins_id;
		echo json_encode($msg_data);
		exit();
	    
	    
    }
    
   
}