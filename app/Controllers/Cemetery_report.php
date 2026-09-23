<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Cemetery_report extends BaseController
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
		$data['list'] = $this->db->table('cemetery')->whereIn('payment_status',['1','2'])->where('paid_through','ONLINE')->where('entry_by', $this->session->get('log_id_frend'))->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/cemetery/cemetery_report', $data);
		//echo view('frontend/layout/footer');
    }
    
}