<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Properties extends BaseController
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
		$data['properties'] = $this->db->table('properties')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/list', $data);
		echo view('template/footer');
    }
	
	public function add() {
		$data['property_category'] = $this->db->table('property_category')->get()->getResultArray();
		$data['property_titles'] = $this->db->table('property_title')->get()->getResultArray();
		$data['property_documents'] = array();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/add', $data);
		echo view('template/footer');
    }
	public function edit($id) {
		$data['property_category'] = $this->db->table('property_category')->get()->getResultArray();
		$data['property_titles'] = $this->db->table('property_title')->get()->getResultArray();
		$data['property'] = $this->db->table('properties')->where("id", $id)->get()->getRowArray();
		$data['property_documents'] = $this->db->table('property_documents')->where("property_id", $id)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('properties/add', $data);
		echo view('template/footer');
    }
	public function store() {
		//exit;
		$id = $_POST['id'];
		$data['name'] = $_POST['property_name'];
		$data['lot_no'] = $_POST['lotno'];
		$data['area'] = $_POST['area'];
		$data['square_feet'] = $_POST['square_feet'];
		//$data['type'] = $_POST['type'];
		$data['amount'] = $_POST['amount'];
		$data['property_category_id'] = $_POST['property_category'];
		$data['purchased_year'] = $_POST['purchased_year'];
		$data['rental_value'] = $_POST['rental_value'];
		$data['title_type'] = $_POST['title_type'];
		$data['due_date'] = $_POST['due_date'];
		if(empty($id)){
			$data['created_at']  =	date('Y-m-d H:i:s');
			$this->db->table('properties')->insert($data);
			$insert_id = $this->db->insertID();
		}
		else
		{
			$data['updated_at' ] = date('Y-m-d H:i:s');
           	$this->db->table('properties')->where('id', $id)->update($data);
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
					$target_dir = "uploads/properties/";
					move_uploaded_file($_FILES['file']['tmp_name'][$j],$target_dir.$logoimg);
					$document_name = $logoimg;
				}
				else {
					$document_name = '';
				}
				$document_data = array(
					'date' => $document_date[$j],
					'document_name' => $document_name,
					'property_id'=> $insert_id
				);
				$this->db->table('property_documents')->insert($document_data);
			}
		}
		$this->session->setFlashdata('succ', 'Property Added Successfully');
		return redirect()->to("/properties");
	}
	public function findpropertyNameExists()
    {
		$property_category =  $this->request->getPost('property_category');
        $updateid = $this->request->getPost('update_id');
		if(!empty($updateid))
		{
			$query = $this->db->table('properties')->where(['property_category_id' => $property_category, 'id !=' => $updateid])->countAllResults();
		}
        else
		{
			$query = $this->db->table('properties')->where(['property_category_id' => $property_category])->countAllResults();
		}
        if($query > 0){
            echo "false";
        }else{
            echo "true";
        }
    }
}