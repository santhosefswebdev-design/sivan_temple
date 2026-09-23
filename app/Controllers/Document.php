<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Document extends BaseController
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
		$data['documents'] = $this->db->table('document')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('document/list', $data);
		echo view('template/footer');
    }
	
	public function add() {
		echo view('template/header');
		echo view('template/sidebar');
		echo view('document/add');
		echo view('template/footer');
    }
	public function edit($id) {
		$data['document'] = $this->db->table('document')->where("id", $id)->get()->getRowArray();
		$data['document_items'] = $this->db->table('document_items')->where("document_id", $data['document']['id'])->get()->getResultArray();
		$data['edit'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('document/add', $data);
		echo view('template/footer');
    }
	public function view($id) {
		$data['document'] = $this->db->table('document')->where("id", $id)->get()->getRowArray();
		$data['document_items'] = $this->db->table('document_items')->where("document_id", $data['document']['id'])->get()->getResultArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('document/add', $data);
		echo view('template/footer');
    }
	public function store() {
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['datetime'] = date("Y-m-d H:i:s", strtotime($_POST['datetime']));
		if(empty($id)){
			$this->db->table('document')->insert($data);
			$insert_id = $this->db->insertID();
		}
		else{
            $this->db->table('document')->where('id', $id)->update($data);
		    $insert_id = $id;
		}
		$files = $this->request->getFileMultiple('document_file');
        foreach($files as $file) {
            if($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/documents/', $newName);
                $this->db->table('document_items')->insert(['document_id'=>$insert_id,'file'=>$newName]);
            }           
        }
		$this->session->setFlashdata('succ', 'Document Added Successfully');
		return redirect()->to("/document");
	}
	public function deletedocument($id,$docid) {
		$this->db->table('document_items')->where("id", $id)->delete();
		return redirect()->to("/document/edit/".$docid);
    }
}