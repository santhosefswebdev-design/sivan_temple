<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Vendor extends BaseController
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
	
	public function index() {
		$data['vendors'] = $this->db->table('vendor')->where('temple_id', $_SESSION['temple_id'])->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('vendor/list', $data);
		echo view('template/footer');
    }
	
	public function add() {
		echo view('template/header');
		echo view('template/sidebar');
		echo view('vendor/add');
		echo view('template/footer');
    }
	public function edit($id) {
		$data['vendor'] = $this->db->table('vendor')->where("id", $id)->get()->getRowArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('vendor/add', $data);
		echo view('template/footer');
    }
	public function view($id) {
		$data['vendor'] = $this->db->table('vendor')->where("id", $id)->get()->getRowArray();
		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('vendor/add', $data);
		echo view('template/footer');
    }
	public function store() {
		$id = $_POST['id'];
		$data['name'] = $_POST['name'];
		$data['contact_person'] = $_POST['contact_person'];
		$data['address1'] = $_POST['address1'];
		$data['address2'] = $_POST['address2'];
		$data['city'] = $_POST['city'];
		$data['state'] = $_POST['state'];
		$data['country'] = $_POST['country'];
		$data['phoneno'] = $_POST['phoneno'];
		$data['email'] = $_POST['email'];
		$data['remarks'] = $_POST['remarks'];
		$data['temple_id'] = $_SESSION['temple_id'];
		if(empty($id)){
			$builder = $this->db->table('vendor')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Vendor Added Successfully');
				return redirect()->to("/vendor");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    return redirect()->to("/vendor");
    		}
		}
		else
		{
            $builder = $this->db->table('vendor')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Vendor Update Successfully');
				return redirect()->to("/vendor");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    return redirect()->to("/vendor");
    		}
		}
	}
}