<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;


class kumbamdonation extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function index()
	{
		
		
		echo view('template/header');
		echo view('template/sidebar');
		echo view('kumbamdonation/index');
		echo view('template/footer');
	}
	
	

}
