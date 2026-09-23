<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Kavadi extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        $this->model = new PermissionModel();
		if( ($this->session->get('log_id_frend') ) == false ){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/member_login');
            exit;
		}
		
    }
    
    public function index(){
      echo view('frontend/layout/header');
      echo view('frontend/kavadi/index');
      echo view('frontend/layout/footer');
    }
	public function store()
	{
		$data['application_for']        = $_POST['application_for'];
		$data['full_name']        = $_POST['full_name'];
		$data['native']        = $_POST['native'];
		$data['kovil_pirivu']        = $_POST['kovil_pirivu'];
		$data['dob']        = $_POST['dob'];
		$data['age']        = $_POST['age'];
		$data['identification_no']        = $_POST['icnum'];
		$data['nationality']        = $_POST['nationality'];
		$data['res_address']        = $_POST['address'];
		$data['contact_no']        = $_POST['contact_no'];
		$data['email_address']        = $_POST['email_address'];
		$data['no_of_years_carring_kavadi']        = $_POST['no_of_years_carring_kavadi'];
		$data['recent_year_kavadi_carring']        = $_POST['recent_year_kavadi_carring'];
		$data['signature']        = $_POST['signature'];
        $data['created_at']       = date("Y-m-d H:i:s");
		
		$res = $this->db->table("kavadi_registration")->insert($data);
		$id = $this->db->insertID();
		if($id){
			return redirect()->to("/kavadi/qrcode_generation/".$id);
		}
	}
	public function qrcode_generation($qr_id)
	{
		$kavadi_registration_check = $this->db->table("kavadi_registration")->where("id", $qr_id)->get()->getResultArray();
		if(count($kavadi_registration_check) > 0)
		{
			if(!empty($qr_id))
			{
				$qr_url = "https://chart.googleapis.com/chart?cht=qr&chl=http://demotemple.graspsoftwaresolutions.com/kavadi/reg/?id=".$qr_id."&chs=160x160&chld=L|0";
				$data['qr_image'] = $qr_url;
				echo view('frontend/layout/book_header');
				echo view('frontend/kavadi/qrcode_generation', $data);
				echo view('frontend/layout/footer');
			}
		}
		else
		{
			return redirect()->to("/kavadi");
		}
		
	}
	public function upload_sign(){
		$data = $_POST['signature_img'];
		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);
		$i = 0;
		while($i <= 0){
			$image_name = $this->generateRandomString(23);
			$img_path =  '/uploads/signature/' . $image_name . '.png';
			if(!file_exists(FCPATH . $img_path)) $i++;
		}
		file_put_contents(FCPATH . $img_path, $data);
		echo json_encode(array('image_url' => base_url() . $img_path));
		exit;
	}
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
    
}
