<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Tennant extends BaseController
{
    function __construct(){
        parent:: __construct();
        helper('url');
        $this->model = new PermissionModel();
		if( ($this->session->get('login') ) == false && $this->session->get('role') != 1){
            $data['dn_msg'] = 'Please Login';
            header('Location: '.base_url().'/login');
            exit;
		}
    }
	
	public function index() {
		$data['tennants'] = $this->db->table('tennant')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/list', $data);
		echo view('template/footer');
    }
	
	public function add() {
		$data['rental_types'] = $this->db->table("rental_type")->where('status',1)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['tenancy_documents'] = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/add', $data);
		echo view('template/footer');
    }
	public function edit($id) {
		$data['tennant'] = $this->db->table('tennant')->where("id", $id)->get()->getRowArray();
		$data['tenancy_documents'] = $this->db->table('tenancy_documents')->where("tennant_id", $id)->get()->getResultArray();
		$data['rental_types'] = $this->db->table("rental_type")->where('status',1)->get()->getResultArray();
		$data['phone_codes'] = $this->db->table("phone_code")->orderBy('dailing_code', 'ASC')->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('tennant/add', $data);
		echo view('template/footer');
    }
	public function store() {
		$id = $_POST['id'];
		$data['property_id'] = $_POST['property_id'];
		$data['name'] = $_POST['tennant_name'];
		$data['phonecode'] = !empty($_POST['phonecode'])?$_POST['phonecode']:"";
		$data['phone'] = !empty($_POST['tennant_phoneno'])?$_POST['tennant_phoneno']:"";
		$data['email'] = $_POST['tennant_emailid'];
		$data['address'] = $_POST['tennant_address'];
		$data['rental_type'] = $_POST['rental_type'];
		$data['company'] = $_POST['company_organisation'];
		$data['start_date'] = $_POST['start_date'];
		$data['end_date'] = $_POST['end_date'];
		$data['deposit_amount'] = $_POST['deposit_amount'];
		$data['utility_deposit'] = $_POST['utility_deposit'];
		$data['status'] = $_POST['status'];
		if(empty($id)){
			$data['created_at']  =	date('Y-m-d H:i:s');
			$this->db->table('tennant')->insert($data);
			$insert_id = $this->db->insertID();
		}
		else
		{
			$data['updated_at' ] = date('Y-m-d H:i:s');
            $this->db->table('tennant')->where('id', $id)->update($data);
			$insert_id = $id;
		}

		if(!empty($_FILES['file']))
		{
			$files = count($_FILES['file']["name"]);
			$document_date = $_POST['date'];
			for($j=0;$j<$files;$j++) 
			{
				if(!empty($_FILES['file']['name'][$j]))
				{
					$logoimg = time() . '_' .$_FILES['file']['name'][$j];
					$target_dir = "uploads/tenant/";
					move_uploaded_file($_FILES['file']['tmp_name'][$j],$target_dir.$logoimg);
					$document_name = $logoimg;
				}
				else {
					$document_name = '';
				}
				$document_data = array(
					'date' => $document_date[$j],
					'document_name' => $document_name,
					'tennant_id'=> $insert_id
				);
				$this->db->table('tenancy_documents')->insert($document_data);
			}
		}
		
		$this->session->setFlashdata('succ', 'Tennant Added Successfully');
		return redirect()->to("/tennant");
	}
	public function findNameExists()
    {
		$tennant_name =  $this->request->getPost('tennant_name');
        $updateid = $this->request->getPost('update_id');
		if(!empty($updateid))
		{
			$query = $this->db->table('tennant')->where(['name' => $tennant_name, 'id !=' => $updateid])->countAllResults();
		}
        else
		{
			$query = $this->db->table('tennant')->where(['name' => $tennant_name])->countAllResults();
		}
        if($query > 0){
            echo "false";
        }else{
            echo "true";
        }
    }
}