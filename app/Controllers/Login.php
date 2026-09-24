<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Login extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
    }
    public function index(){
		if($this->session->get('login') == true){
			header('Location: /dashboard');
			exit;
		}
		echo view('login');
    }
    
    public function validation(){
        $data = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(trim($username) != '' && trim($password != '') ){
            
			/*$builder1 = $this->db->table('admin_profile')->get()->getRowArray();
			$builder = $this->db->table('login');
				$builder->select('*');
				$builder->where("username", $username);
				$builder->where("password", $password);
				$datas = $builder->get();
				$details = $datas->getRowArray();*/
				
			// $builder = $this->db->table('login')
			// 			->join('admin_profile', 'login.profile_id = admin_profile.id')
			// 			->select('login.*, login.id as log_id, login.name as log_name')
			// 			->select('admin_profile.*')
			// 			->where("username", $username)
			// 			->where("password", $password);
            $builder = $this->db->table('login')
								->select('login.*')
								//->join('role_list', 'role_list.id = login.role')
								//->join('role_permission', 'role_permission.role_id = role_list.id')
								->where("login.username", $username)
								->where("login.password", $password)
								->where("member_comes", 'admin');

				$datas = $builder->get();
				$details_bf = $datas->getRowArray();
				
            if($datas->resultID->num_rows > 0){
                $builder = $this->db->table('login')
						->join('admin_profile', 'login.profile_id = admin_profile.id')
						->select('login.*, login.id as log_id, login.name as log_name')
						->select('admin_profile.*')
						->where("admin_profile.id", $details_bf['profile_id'])
						->where("login.id", $details_bf['id']);
				$datas = $builder->get();
				$details = $datas->getRowArray();
				//var_dump($details);
				//exit;
                $session = array(
                            'username' => $details['username'],
                            'role' => $details['role'],
                            'email' => $details['email'],
                            'ic_number' => $details['ic_number'],
                            'log_id' => $details['log_id'],
                            'log_name' => $details['log_name'],
							'site_title' => $details['name'],
							'address1' => $details['address1'],
							'address2' => $details['address2'],
							'city' => $details['city'],
							'postcode' => $details['postcode'],
							'telephone' => $details['telephone'],
							'mobile' => $details['mobile'],
							'gstno' => $details['gstno'],
							'email' => $details['email'],
							'website' => $details['website'],
                            'profile_id' => $details['profile_id'],
							'logo_img' => $details['image'],
							'booking_range_year' => $details['booking_range_year'],
                            'login' => true
                        );
                 $val = $this->session->get('site_title');
				 /*print_r($val); exit();*/
				 
				 $this->session->set($session);
                 $this->session->setFlashdata('succ', 'Login Successfully!...');
                header('location: '.base_url().'/dashboard');
                 //return redirect()->to('dashboard');
            }else{
                $this->session->setFlashdata('fail', 'Wrong Username And Password');
                echo view('/login');
            }
        }else{
            $this->session->setFlashdata('fail', 'Please Fill Out Username And Password');
            echo view('/login');
        }
    }
    public function auto_login($user_id){
		if(!empty($user_id)){
			$builder = $this->db->table('login')
						->where("id", $user_id);

			$datas = $builder->get();
			$details = $datas->getRowArray();
			if($datas->resultID->num_rows > 0){
                $builder = $this->db->table('login')
						->join('admin_profile', 'login.profile_id = admin_profile.id')
						->select('login.*, login.id as log_id, login.name as log_name')
						->select('admin_profile.*')
						->where("login.profile_id", $details['profile_id'])
						->where("login.id", $details['id']);

				$datas = $builder->get();
				$details = $datas->getRowArray();
                $session = array(
                            'username' => $details['username'],
                            'role' => $details['role'],
                            'email' => $details['email'],
                            'ic_number' => $details['ic_number'],
                            'log_id' => $details['log_id'],
                            'log_name' => $details['log_name'],
							'site_title' => $details['name'],
							'address1' => $details['address1'],
							'address2' => $details['address2'],
							'city' => $details['city'],
							'postcode' => $details['postcode'],
							'telephone' => $details['telephone'],
							'mobile' => $details['mobile'],
							'gstno' => $details['gstno'],
							'email' => $details['email'],
							'website' => $details['website'],
                            'profile_id' => $details['profile_id'],
							'logo_img' => $details['image'],
                            'login' => true
                        );
                 $val = $this->session->get('site_title');
				 
				 $this->session->set($session);
                 $this->session->setFlashdata('succ', 'Login Successfully!...');
                header('location: '.base_url().'/dashboard');
				exit;
            }else{
                $this->session->setFlashdata('fail', 'Wrong Username And Password');
                echo view('/login');
            }
		}else{
            $this->session->setFlashdata('fail', 'Auto Login user not found');
            echo view('/login');
        }
	}
    public function logout(){
        $this->session->destroy();
        header('Location: '.base_url().'/login');
    }
}
