<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;


class Memberrenewal extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
			exit;
		}
	}
	public function index()
	{
		

		echo view('frontend/layout/header');
		echo view('frontend/memberrenewal/index');
		echo view('frontend/layout/footer');
	}
	

}

