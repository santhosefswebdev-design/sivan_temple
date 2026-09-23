<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Agent_dashboard extends BaseController
{
	  function __construct(){
      parent:: __construct();
      helper('url');
      $this->model = new PermissionModel();
      if( ($this->session->get('log_id_frend') ) == false && $this->session->get('role') != 99){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/member_login');
            exit;
      }
    }
    
    public function index() {
        $data = array();
        $user_id = $this->session->get('log_id_frend');
        echo view('frontend/layout/header');
        echo view('frontend/agent/dashboard',$data);
    }
}



