<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RequestModel;

class Offering_online extends BaseController
{
    function __construct(){
        parent::__construct();
		helper('url');
		helper('common_helper');
		$this->model = new PermissionModel();
		if (($this->session->get('log_id_frend')) == false) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/member_login');
			exit;
		}
    }
    
    
	public function index()
	{
		$login_id = $_SESSION['log_id_frend'];

		$data['permission'] = $this->model->get_permission('archanai_ticket');
		$data['offer'] = $this->db->table('offering_category')->get()->getResultArray();
		echo view('frontend/layout/header');
		echo view('frontend/offering/index', $data);
		//echo view('frontend/layout/footer');		
	}
	
	public function get_category()
	{
		$json_resp = array();
		if (!empty ($_REQUEST['id'])) {
		    $id = $_REQUEST['id'];
    		$res = $this->db->table('product_category')->where('off_cat_id', $id)->get()->getResultArray();
    		if ($res)
				$json_resp['data'] = $res;
			else
				$json_resp['data'] = array();
		}
		echo json_encode($json_resp);
		exit;
	}
	public function pro_offering_save()
	{
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
	    $id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';

		$data['date'] = date('Y-m-d', strtotime($_POST['date']));
		$data['name'] = trim($_POST['name']);
	    $data['phone'] = trim($_POST['phone']);
	    $data['address'] = trim($_POST['address']);
		$yr= date('Y', strtotime($_POST['date']));
		$mon= date('m', strtotime($_POST['date']));
		$query = $this->db->query("SELECT ref_no FROM product_offering WHERE id=(SELECT max(id) FROM product_offering WHERE year(date)='". $yr ."' AND month(date)='". $mon ."')")->getRowArray();
		$data['ref_no'] = 'PO' .date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['ref_no'], -5)) + 1)));
		$data['paid_through'] = 'COUNTER';
		$data['added_by'] = $this->session->get('log_id_frend');
	    $data['created'] 		= date("Y-m-d H:i:s");
	    $res = $this->db->table('product_offering')->insert($data);
		$ins_id = $this->db->insertID();

		if (!empty($_POST['sout'])) {
			foreach ($_POST['sout'] as $row) {
				$sdata['pro_off_id'] = $ins_id;
				$sdata['offering_id'] = $row['offering_id'];
				$sdata['product_id'] = $row['product_id'];
				$sdata['grams'] = $row['grams'];
				$sdata['value'] = $row['value'];
				$detail_res = $this->db->table("product_offering_detail")->insert($sdata);
		
				$productCategory = $this->db->table("product_category")
											->select('id, off_cat_id, stock_grams, stock_items')
											->where('off_cat_id', $row['offering_id'])
											->where('id', $row['product_id'])
											->get()
											->getRowArray();
		
				if (!empty($productCategory)) {
					$updatedData = [
						'stock_grams' => $productCategory['stock_grams'] + $row['grams'],
						'stock_items' => $productCategory['stock_items'] + 1
					];
					
					$res = $this->db->table("product_category")
							 ->where('id', $row['product_id'])
							 ->update($updatedData);
				}
			}
		}
		
		if($res){
			$msg_data['succ'] = 'Stock In Added Successfully';
			$msg_data['id'] = $ins_id;
		}else{
			$msg_data['err'] = 'Please Try Again';
		}
		echo json_encode($msg_data);
		exit();
	}

	public function print_offering()
	{
		$id=  $this->request->uri->getSegment(3);
		$data['temp_details'] = $this->db->table('admin_profile')->where('id', 1)->get()->getRowArray();
		
	    $data['data'] = $this->db->table('product_offering')->select('product_offering.*')
							->where('id', $id)
							->get()
							->getRowArray();
		
		$data['offering_items'] = $this->db->table('product_offering_detail')
											->select('product_offering_detail.*, product_category.name as product_name, offering_category.name as category_name')
											->join('offering_category', 'product_offering_detail.offering_id = offering_category.id')
											->join('product_category', 'product_offering_detail.product_id = product_category.id')
											->where('product_offering_detail.pro_off_id', $id)->get()->getResultArray();
		
		echo view('offering/print_offering',$data);
	}

}    
    
    
    
    