<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Archanai_new extends BaseController
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
        //echo view('template/header');
		//echo view('template/sidebar');
		echo view('archanai_new/index');
		//echo view('template/footer');
    }
	
	
}
