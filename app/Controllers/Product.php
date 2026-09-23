<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Product extends BaseController
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
		if(!$this->model->list_validate('product')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('product');
		$data['list'] = $this->db->table('product')
						->select('product.*')
						->get()
						->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('product/index', $data);
		echo view('template/footer');
    }
	public function add_product() {
		if(!$this->model->permission_validate('product', 'create_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['products'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('product_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('product/add_product',$data);
		echo view('template/footer');
    }
	public function checkavailablity_productcount()
	{
		$raw_id = $_POST['rawmat_id'];
		$raw_qty = $_POST['rawmat_qty'];
		$row_data = $this->db->table('raw_matrial_groups')->where('id',$raw_id)->get()->getRowArray();
		$opening_stock = $row_data['opening_stock'];
		$minimum_stock = $row_data['minimum_stock'];
		$balance_stock = $opening_stock - $minimum_stock;
		if($balance_stock < $raw_qty)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	public function save_product(){
        $id = $_POST['id'];
		$data['name']	 =	$_POST['name'];
		$data['product_code'] =	$_POST['product_code'];
		$data['description'] =	$_POST['product_description'];
		$data['opening_stock'] =	$_POST['product_qty'];
		$data['minimum_stock'] =	$_POST['minimum_stock'];
		$data['uom_id'] =	$_POST['uom_id'];
		$data['price'] =	$_POST['price'];
		if(!empty($_FILES['product_image']['name']) > 0){
			echo $_FILES['product_image']['name'];
			$product_img = time() . '_' .$_FILES['product_image']['name'];
			$target_dir = "uploads/product/";
			move_uploaded_file($_FILES['product_image']['tmp_name'],$target_dir.$product_img);
			$data['image'] = $product_img;
		}
		if(empty($id)){
		    $data['created_at']  =	date('Y-m-d H:i:s');
			$data['updated_at'] = date('Y-m-d H:i:s');
			$data['quantity'] =	$_POST['product_qty'];
		    $this->db->table('product')->insert($data);
			$ins_id = $this->db->insertID();
		}else{
            $data['updated_at' ] = date('Y-m-d H:i:s');
            $this->db->table('product')->where('id', $id)->update($data);
			$ins_id = $id;
		}
		if(!empty($_POST['rawmaterial']))
		{
			foreach($_POST['rawmaterial'] as $row){
				$raws['product_id'] = $ins_id;
				$raws['raw_id'] = $row['raw_id'];
				$raws['qty'] = $row['raw_qty'];
				//$av_data = $this->db->table("raw_matrial_groups")->where("id", $row['raw_id'])->get()->getRowArray();
				//$avl_stack['opening_stock'] = $av_data['opening_stock'] - $row['raw_qty'];
				//$this->db->table('raw_matrial_groups')->where('id', $row['raw_id'])->update($avl_stack);
				$this->db->table('product_raw_material_items')->insert($raws);
			}
		}
		$this->session->setFlashdata('succ', 'Product Added Successfully');
    	header("Location: ".base_url()."/product");
	}
	public function update_raw_qty(){
		$id = $_POST['edit_rawid'];
		$edit_id = $_POST['edit_id'];
		$avl_stack['qty'] = $_POST['edit_rawqty'];
		$this->db->table('product_raw_material_items')->where('id', $id)->update($avl_stack);
		return redirect()->to("/product/edit_product/".$edit_id);
	}
	public function delete_product(){
	    if(!$this->model->permission_validate('product', 'delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
		$res = $this->db->table('product')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Product Delete Successfully');
		    header("Location: ".base_url()."/product");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/product");
		}
	}	
	public function edit_product(){
	    if(!$this->model->permission_validate('product', 'edit')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('product')->where('id', $id)->get()->getRowArray();
		$data['products'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('product_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['edit'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('product/add_product', $data);
		echo view('template/footer');
	}
	
	public function view_product(){
	    if(!$this->model->permission_validate('product', 'view')){
			header('Location: '.base_url().'/dashboard');
		}
		$id=  $this->request->uri->getSegment(3);
	    $data['data'] = $this->db->table('product')->where('id', $id)->get()->getRowArray();
		$data['products'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['product_raw_material_items'] = $this->db->table('product_raw_material_items')->where('product_id', $id)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('product/add_product', $data);
		echo view('template/footer');
	}



}