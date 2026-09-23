<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Rawmaterial extends BaseController
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
		// if(!$this->model->list_validate('raw_material')){
		// 	header('Location: '.base_url().'/dashboard');
		// }
		$data['permission'] = $this->model->get_permission('raw_material');
		$data['list'] = $this->db->table('raw_matrial_groups')
						->join('uom_list', 'uom_list.id = raw_matrial_groups.uom_id', 'left')
						->select('uom_list.*')
						->select('raw_matrial_groups.*')
						->get()
						->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('raw_material/index', $data);
		echo view('template/footer');
    }
	public function add_product() {
		if(!$this->model->permission_validate('raw_material', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('product')->get()->getResultArray();
		$data['suppliers'] = $this->db->table('supplier')->where('status',1)->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('raw_material/add_product', $data);
		echo view('template/footer');
    }
	
	public function save_product(){
        $id = $_POST['id'];
		$data['name']	 =	$_POST['name'];
		//$data['product_id']	 =	$_POST['product_id'];
		$data['opening_stock']	 =	$_POST['opening_stock'];
		$data['minimum_stock']	 =	$_POST['minimum_stock'];
		$data['uom_id']	 =	$_POST['uom_id'];
		$data['price']	 =	$_POST['price'];
		$data['expire_type']	 =	!empty($_POST['expire_type']) ? $_POST['expire_type'] : 0;
		if($_POST['expire_type'] == 1)
		{
			$data['mfg_date']	 =	$_POST['mfg_date'];
			$data['exp_date']	 =	$_POST['exp_date'];
			$data['service_date']	 =	NULL;
		}
		else if($_POST['expire_type'] == 2)
		{
			$data['service_date']	 =	$_POST['service_date'];
			$data['mfg_date']	 =	NULL;
			$data['exp_date']	 =	NULL;
		}
		else
		{
			$data['service_date']	 =	NULL;
			$data['mfg_date']	 =	NULL;
			$data['exp_date']	 =	NULL;
		}
		$data['description'] =	$_POST['product_description'];
		$data['supplier_id'] =	$_POST['supplier_id'];
		if(empty($id)){
			$data['quantity']	 =	$_POST['opening_stock'];
		    $data['created']  =	date('Y-m-d H:i:s');
			$data['modified'] = date('Y-m-d H:i:s');
		    $builder = $this->db->table('raw_matrial_groups')->insert($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Item Added Successfully');
    		    header("Location: ".base_url()."/rawmaterial");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/rawmaterial");
    		}
		}else{
            $data['modified' ] = date('Y-m-d H:i:s');
            $builder = $this->db->table('raw_matrial_groups')->where('id', $id)->update($data);
		    if($builder){
    		    $this->session->setFlashdata('succ', 'Item Update Successfully');
    		    header("Location: ".base_url()."/rawmaterial");
    		}else{
    		    $this->session->setFlashdata('fail', 'Please Try Again');
    		    header("Location: ".base_url()."/rawmaterial");
    		}
		}
	}
	
	public function delete_product(){
	    if(!$this->model->permission_validate('raw_material', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('raw_matrial_groups')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Product Delete Successfully');
		    header("Location: ".base_url()."/rawmaterial");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/rawmaterial");
		}
	}	
	public function edit_product(){
	    if(!$this->model->permission_validate('raw_material', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('raw_matrial_groups')->where('id', $id)->get()->getRowArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('product')->get()->getResultArray();
		$data['suppliers'] = $this->db->table('supplier')->where('status',1)->get()->getResultArray();
		$data['edit'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('raw_material/add_product', $data);
		echo view('template/footer');
	}
	
	public function view_product(){
	    if(!$this->model->permission_validate('raw_material', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('raw_matrial_groups')->where('id', $id)->get()->getRowArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('product')->get()->getResultArray();
		$data['suppliers'] = $this->db->table('supplier')->where('status',1)->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('raw_material/add_product', $data);
		echo view('template/footer');
	}



}