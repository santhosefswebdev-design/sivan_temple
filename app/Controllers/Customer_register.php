<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Customer_register extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        helper('common_helper');
    }
    public function index(){
		  echo view('front_user/register');
    }
    public function username_check(){
		  $cust_username = $_POST['cust_username'];
      $builder = $this->db->table('login')
                          ->where("username", $cust_username)
                          ->where("role", '98')
                          ->where("status", '1');
			$datas = $builder->get();
			$details = $datas->getResultArray();
      if(count($details) > 0){
        echo "false";
      }
      else{
        echo "true";
      }
    }
    public function email_check(){
		  $cust_email = $_POST['cust_email'];
      $builder = $this->db->table('login')
                          ->where("email", $cust_email)
                          ->where("role", '98')
                          ->where("status", '1');
			$datas = $builder->get();
			$details = $datas->getResultArray();
      if(count($details) > 0){
        echo "false";
      }
      else{
        echo "true";
      }
    }
    public function save_register(){
        $cust_name = $_POST['cust_name'];
        $cust_ic_no = $_POST['cust_ic_no'];
        $cust_email = $_POST['cust_email'];
        $cust_username = $_POST['cust_username'];
        $cust_password = $_POST['cust_password'];

        $data['name'] = $cust_name;
        $data['ic_number'] = $cust_ic_no;
        $data['username'] = $cust_username;
        $data['password'] = $cust_password;
        $data['email'] = $cust_email;
        $data['role'] = 98;
        $data['profile_id'] = 1;
        $data['status'] = 1;
        $data['member_comes'] = "customer";
        $data['created'] = date('Y-m-d H:i:s');
        $data['modified'] = date('Y-m-d H:i:s');
        $res = $this->db->table('login')->insert($data);
        if ($res) {
          $ins_id = $this->db->insertID();
          if (!empty($_POST['cust_email'])) {
            $temple_title = "Temple Ganesh";
            $mail_data['login_id'] = $ins_id;
            $message = view('front_user/register_mail_template', $mail_data);
            $subject = "Customer Registration";
            $to_user = $_POST['cust_email'];
            $to_mail = array("prithivitest@gmail.com", $to_user);
            send_mail_with_content($to_mail, $message, $subject, $temple_title);
          }
          $this->session->setFlashdata('succ', 'Customer registered Successfully');
          header("Location: " . base_url() . "/customer_login");
        } else {
          $this->session->setFlashdata('fail', 'Please Try Again');
          header("Location: " . base_url() . "/customer_login");
        }

    }

}
