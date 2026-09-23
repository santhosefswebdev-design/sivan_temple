<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Agent_profile extends BaseController
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
      $user_id = $this->session->get('log_id_frend');
      $data['data'] = $this->db->table('agent')->join('login','login.index_id = agent.id')->select('agent.*')->where("login.id",$user_id)->get()->getRowArray();
      $data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		  $data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		  echo view('frontend/layout/header');
      echo view('frontend/agent/profile',$data);
    }
    public function update_profile() {
        $id = $_POST['updateid'];
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['address'] = $_POST['address'];
        $data['city'] = $_POST['city'];
        $data['state'] = $_POST['state'];
        $data['country'] = $_POST['country'];
        $data['pincode'] = $_POST['zipcode'];
        $data['dailing_code'] = $_POST['phonecode'];
        $data['phoneno'] = $_POST['mobile'];
        $data['description'] = $_POST['description'];
        $data['updated_at'] = date("Y-m-d H:i:s");
        if(!empty($id))
        {
            $this->db->table("agent")->where('id', $id)->update($data);
            $this->session->setFlashdata('succ', 'Profile Updated Successfully');
			      return redirect()->to("/agent_profile");
        }

        
    }
}



