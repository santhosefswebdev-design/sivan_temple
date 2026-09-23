<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Productdonation extends BaseController
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
    
    public function index(){
		if(!$this->model->list_validate('product_donation')){
			header('Location: '.base_url().'/dashboard');
		}
		$data['permission'] = $this->model->get_permission('product_donation');
		
		$data['list'] = $this->db->table('donation_product')
					//->join('products', 'products.id = donation_product.product_id')
					//->select('products.name as pname')
					->select('donation_product.*')
					->get()
					->getResultArray();
		
		
		echo view('template/header');
		echo view('template/sidebar');
		echo view('product_donation/index', $data);
		echo view('template/footer');
    }
	
	public function add()
	{
		if(!$this->model->permission_validate('product_donation','create_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['view'] = false;
		$data['readonly'] = "";
		echo view('template/header');
		echo view('template/sidebar');
		echo view('product_donation/add', $data);
		echo view('template/footer');
	}
	
	public function get_productcategory()
	{
		$producttype = $_POST['producttype'];
		$html = "<option value=''> Nothing selected </option>";
		if ($producttype == 1) {
			$products = $this->db->table('product')->get()->getResultArray();
			foreach ($products as $product) {
				$html .= '<option value=' . $product["id"] . '>' . $product["name"] . '</option>';
			}
		}
		if ($producttype == 2) {
			$raw_matrial_groups = $this->db->table('raw_matrial_groups')->get()->getResultArray();
			foreach ($raw_matrial_groups as $raw_matrial_group) {
				$html .= '<option value=' . $raw_matrial_group["id"] . '>' . $raw_matrial_group["name"] . '</option>';
			}
		}
		echo $html;
	}
	
	public function save(){
        //$id = $_POST['id'];
		//echo '<pre>';
		//print_r(date("m", strtotime($_POST['date'])));
		//exit;
		//var_dump(count($_POST['pdon']));
		
		//exit();
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		if(!empty($_POST['date']))
		{
			$yr = date("Y", strtotime($_POST['date']));
			$mon = date("m", strtotime($_POST['date']));
			$query   = $this->db->query("SELECT ref_no FROM donation_product where id=(select max(id) from donation_product where year (date)='". $yr ."' and month (date)='". $mon ."')")->getRowArray();
			$data['ref_no']= 'PR' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($query['ref_no'],-5))+1)));
		}
		$data['date']		 =	$_POST['date'];
		$data['name']		 =	$_POST['name'];
		$data['ic_num']	 	 =	$_POST['ic_num'];
		$data['mobile']	 	 =	$_POST['mobile'];
		$data['address']	 =	$_POST['address'];
		$data['description'] =	$_POST['description'];
		
		if(empty($data['name']) || empty($data['date']))
		{
			$msg_data['err'] = 'Please Fill Required Field';
			echo json_encode($msg_data);
			exit();
		}
		
		if(empty($_POST['pdon'])) {
		    $msg_data['err'] = 'Please Add Product for Denation';
			echo json_encode($msg_data);
			exit();
		}
			
		$builder = $this->db->table('donation_product')->insert($data);
		$ins_id =  $this->db->insertID();
		
		if(count($_POST['pdon']) > 0 && !empty($_POST['pdon']))
		{
			foreach($_POST['pdon'] as $row){
				$amt = !empty($row['amt']) ? $row['amt'] : 0;
				$total = !empty($row['total']) ? $row['total'] : 0;
				$sdata['donation_prod_id']  = $ins_id;
				$sdata['item_type']     = $row['ptype'];
				$sdata['product_id'] 	= $row['pid'];
				$sdata['quantity'] 		= $row['qty'];
				$sdata['uom_range'] 	= $row['range'];
				$sdata['uom'] 			= $row['uom'];
				$sdata['amount'] 	    = $amt;
				$sdata['total_amount'] 	= $total;
				$sdata['created'] 		= date("Y-m-d H:i:s");
				$av_data = $this->db->table('product')->select('opening_stock')->where('id', $row['pid'])->get()->getRowArray();
				$opening_stock = $av_data['opening_stock'] + $row['qty'];
				$sunta = $this->db->table('product')->where('id', $row['pid'])->set('opening_stock', $opening_stock)->update();
				
				
				if($sunta){
					$this->db->table("donation_product_item")->insert($sdata);
					
				}
			}
		}
		
		if($builder){
			$msg_data['succ'] = 'Product Donation Added Successflly';
			$msg_data['id'] = $ins_id;
		}else{
			$msg_data['err'] = 'Please Try Again';
		}
		echo json_encode($msg_data);
		exit();
	}
	
	public function edit(){
	    if(!$this->model->permission_validate('product_donation','edit')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		$data['pro'] = $this->db->table('product')->get()->getResultArray();
	    $data['data'] = $this->db->table('donation_product')->where('id', $id)->get()->getRowArray();
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('product_donation/add', $data);
		echo view('template/footer');
	}
	
	public function view(){
	    if(!$this->model->permission_validate('product_donation','view')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		$data['pro'] = $this->db->table('product')->get()->getResultArray();
	    $data['data'] = $this->db->table('donation_product')->where('id', $id)->get()->getRowArray();
		$data['product_item'] =  $this->db->table('donation_product_item')
								->join('product', 'product.id = donation_product_item.product_id')
								->select('product.name as pname')
								->select('donation_product_item.*')
								->where('donation_prod_id', $id)
								->get()->getResultArray();
	    $data['view'] = true;
	    echo view('template/header');
		echo view('template/sidebar');
		echo view('product_donation/add', $data);
		echo view('template/footer');
	}
	
	public function delete(){
	    if(!$this->model->permission_validate('product_donation','delete_p')){
			header('Location: '.base_url().'/dashboard');
		}
	    $id=  $this->request->uri->getSegment(3);
		
		$get_data_item = $this->db->table('donation_product_item')->where('donation_prod_id', $id)->get()->getResultArray();
		if(count($get_data_item) > 0)
		{
			foreach($get_data_item as $get_data_item_row)
			{
				$av_data = $this->db->table('product')->select('opening_stock')->where('id', $get_data_item_row["product_id"])->get()->getRowArray();
				$opening_stock = $av_data['opening_stock'] - $get_data_item_row['quantity'];
				$this->db->table('product')->where('id', $get_data_item_row["product_id"])->set('opening_stock', $opening_stock)->update();
				$this->db->table('donation_product_item')->delete(['id' => $get_data_item_row["id"]]);
			}
		}
		$res = $this->db->table('donation_product')->delete(['id' => $id]);
		if($res){
		    $this->session->setFlashdata('succ', 'Product Donation Delete Successfully');
		    header("Location: ".base_url()."/product_donation");
		}else{
		    $this->session->setFlashdata('fail', 'Please Try Again');
		    header("Location: ".base_url()."/product_donation");
		}
	}
	
	public function print_page(){
		 
	 	if(!$this->model->permission_validate('product_donation','print')){
			header('Location: '.base_url().'/dashboard');			
		}
		$id = $this->request->uri->getSegment(3);
		 // echo  $id;
		  // exit ;
		$data['qry1'] = $this->db->table('donation_product')
						->select('donation_product.*')
						->where('donation_product.id', $id)
						->get()->getRowArray();
		$data['product_item'] =  $this->db->table('donation_product_item')
								->join('product', 'product.id = donation_product_item.product_id')
								->select('product.name as pname')
								->select('donation_product_item.*')
								->where('donation_prod_id', $id)
								->get()->getResultArray();				
		$data['terms'] =  $this->db->table("terms_conditions")->get()->getRowArray();
		echo view('product_donation/print_page', $data);
	 }
	public function get_product_name(){

      $name= $_POST['name'];
	  $query   = $this->db->query("SELECT * FROM product where id = $name")->getRowArray();
      $data['name']  = $query['name']; 
	  echo json_encode($data);    
    }
    
    public function get_uom_name()
    {
      $name= $_POST['prod_id'];
      $query_prd = $this->db->query("SELECT * FROM product where id = $name")->getRowArray();
      $uomid= $query_prd["uom_id"];
	  $query   = $this->db->query("SELECT * FROM uom_list where id = $uomid")->getRowArray();
      $symbol = $query['symbol']; 
	  echo $symbol;    
    }
}
