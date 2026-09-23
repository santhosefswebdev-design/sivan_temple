<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Festival_message extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
		helper('common_helper');
        $this->model = new PermissionModel();
		if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
	
	public function index() {
		$data = array();
		$data['member_type_list'] = $this->db->table('member_type')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('festival_message/index', $data);
		echo view('template/footer');
    }
	
	
	public function store() {
		if(!empty($_REQUEST['name']) && !empty($_REQUEST['member_type']) && !empty($_REQUEST['members'])){
			$name = $_REQUEST['name'];
			$member_type = $_REQUEST['member_type'];
			$members = $_REQUEST['members'];
			$this->send_whatsapp_msg($name, $members, $member_type);
			$this->session->setFlashdata('succ', 'Message Sent Successfully');
		}else $this->session->setFlashdata('fail', 'Please select atleast a member');
        return redirect()->to("/festival_message/index");
    }
    
    public function view() {
        
        $storedData = $this->session->getFlashdata('stored_data');
        // var_dump($storedData);
        // die;
        echo view('template/header');
        echo view('template/sidebar');
        echo view('festival_message/view', ['storedData' => $storedData]);
        echo view('template/footer');
    }
    public function get_members_by_type() {
		$json = array();
		if(!empty($_REQUEST['member_type'])){
			$member_type = $_REQUEST['member_type'];
			$json['members'] = $this->db->table('member')->where('member_type', $member_type)->get()->getResultArray();
		}
		echo json_encode($json);
		exit;
	}
	public function send_whatsapp_msg($festival, $member_ids, $member_type)
	{
		$tmpid = 1;
		$data['temple_details'] = $temple_details = $this->db->table('admin_profile')->where('id', $tmpid)->get()->getRowArray();
		if(in_array("all_members", $member_ids)){
			$data['members'] = $members = $this->db->table('member')->where('member_type', $member_type)->get()->getResultArray();
		}else $data['members'] = $members = $this->db->table('member')->whereIn('id', $member_ids)->get()->getResultArray();
		if(count($members) > 0){
			foreach($members as $member){
				if (!empty ($member['mobile'])) {
					$message_params = array();
					$message_params[] = $member['name'];
					$message_params[] = $festival;
					$message_params[] = 'Devotion';
					$message_params[] = ' ';
					$message_params[] = $festival;
					$media['url'] = 'https://selvavinayagar.grasp.com.my/test/uploads/main/1708670418_WhatsApp%20Image%202024-02-23%20at%2012.08.08_ce532764.jpg';
					$media['filename'] = 'Pongal';
					$mobile_number = $member['mobile'];
					// $mobile_number = '+919092615446';
					// print_r($mobile_number);
					// print_r($message_params);
					// print_r($media);
					// die; 
					$whatsapp_resp = whatsapp_aisensy($mobile_number, $message_params, 'festival_message_live1', $media);
					// print_r($whatsapp_resp);
					//echo $whatsapp_resp['success'];
				}
			}
		}
	}
}