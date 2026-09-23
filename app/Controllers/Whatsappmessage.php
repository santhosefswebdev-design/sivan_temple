<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Whatsappmessage extends BaseController
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
	public function edit(){
		if(!$this->model->permission_validate('message_setting', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['whatsappmessage'] = $this->db->table('whatsapp_message_setting')
							->select('whatsapp_message_setting.*')
							->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('whatsappmessage/edit', $data);
		echo view('template/footer');
	}
	public function save(){
		$data['hall']	    =	$_POST['hall_editor'];
		$data['cash_donation']	=	$_POST['cash_donation_editor'];
		$data['product_donation']	=	$_POST['product_donation_editor'];
		$data['ubayam']		=	$_POST['ubayam_editor'];
		$data['common']	=	$_POST['common_editor'];
	
		$res = $this->db->table('whatsapp_message_setting')->update($data);
		if($res){
			$this->session->setFlashdata('succ', 'Message Updated Successfully');
			return redirect()->to("/whatsappmessage/edit");
		}else{
			$this->session->setFlashdata('fail', 'Please Try Again');
			return redirect()->to("/whatsappmessage/edit");
		}
	}
}


