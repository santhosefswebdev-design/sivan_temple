<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Customer_login extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
    }
    public function index(){
		//echo view('frontend/layout/header');
		echo view('front_user/login');
		//echo view('frontend/layout/footer');
    }
    
    public function validation(){
        $data = array();
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(trim($username) != '' && trim($password != '') ){
            
            $builder = $this->db->table('login')
						->where("username", $username)
						->where("password", $password)
						->where("member_comes", 'customer');

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
                            'username_frend' => $details['username'],
                            'role' => $details['role'],
                            'email_frend' => $details['email'],
                            'ic_number_frend' => $details['ic_number'],
                            'log_id_frend' => $details['log_id'],
                            'log_name_frend' => $details['log_name'],
							'site_title_frend' => $details['name'],
							'address1_frend' => $details['address1'],
							'address2_frend' => $details['address2'],
							'city_frend' => $details['city'],
							'postcode_frend' => $details['postcode'],
							'telephone_frend' => $details['telephone'],
							'mobile_frend' => $details['mobile'],
							'gstno_frend' => $details['gstno'],
							'email_frend' => $details['email'],
							'website_frend' => $details['website'],
                            'profile_id_frend' => $details['profile_id'],
							'logo_img_frend' => $details['image'],
                            'login_frend' => true
                        );
                 $val = $this->session->get('site_title');
				 /*print_r($val); exit();*/
				 
				 $this->session->set($session);
                 $this->session->setFlashdata('succ', 'Login Successfully!...');
                //header('location: '.base_url().'/home');
                //var_dump($_SESSION['role']);
                //exit;
                return redirect()->to('/archanai_booking_cust');
            }else{
                $this->session->setFlashdata('fail', 'Wrong Username And Password');
				return redirect()->to('/customer_login');
            }
        }else{
            $this->session->setFlashdata('fail', 'Please Fill Out Username And Password');
			return redirect()->to('/customer_login');
            //echo view('/customer_login');
        }
    }
    public function logout(){
        $this->session->destroy();
		return redirect()->to('/customer_login');
    }
}
