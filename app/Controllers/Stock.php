<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;

class Stock extends BaseController
{
	function __construct()
	{
		parent::__construct();
		helper('url');
		$this->model = new PermissionModel();
		if (($this->session->get('login')) == false && $this->session->get('role') != 1) {
			$data['dn_msg'] = 'Please Login';
			header('Location: ' . base_url() . '/login');
			exit;
		}
	}

	public function stock_in()
	{

		if (!$this->model->list_validate('stock_in')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('stock_in');
		$data['list'] = $this->db->table('stock_inward', 'staff.name as staffname')
			->join('staff', 'staff.id = stock_inward.staff_name')
			->select('staff.name as staffname')
			->select('stock_inward.*')
			->orderBy('stock_inward.id', 'desc')
			->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/stockin', $data);
		echo view('template/footer');
	}

	public function get_out_inv_no()
	{


		$yr = date('Y', strtotime($_POST['dt']));
		$mon = date('m', strtotime($_POST['dt']));
		$query = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)= $yr and month (date)= $mon)")->getRowArray();

		echo 'OT' . date('y', strtotime($_POST['dt'])) . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));
	}

	public function get_in_inv_no()
	{

		$yr = date('Y', strtotime($_POST['dt']));
		$mon = date('m', strtotime($_POST['dt']));

		$query = $this->db->query("SELECT invoice_no FROM stock_inward where id=(select max(id) from stock_inward where year (date)= $yr and month (date)= $mon)")->getRowArray();
		//echo"SELECT invoice_no FROM stock_inward where id=(select max(id) from stock_inward where year (date)= $yr and month (date)= $mon)";
		//$query   = $this->db->query("SELECT invoice_no FROM stock_inward where id=(select max(id) from stock_inward where year (date)= $yr and month (date)= $mon)")->getRowArray();

		echo 'IN' . date('y', strtotime($_POST['dt'])) . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));
	}
	public function stock_in_add()
	{
		if (!$this->model->permission_validate('stock_in', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$yr = date('Y');
		$mon = date('m');
		$query = $this->db->query("SELECT invoice_no FROM stock_inward where id=(select max(id) from stock_inward where year (date)= $yr and month (date)= $mon)")->getRowArray();
		$data['invno'] = 'IN' . date("y") . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/stock_in_add', $data);
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
	public function checkavailablity_productcount()
	{
		$prod_id = $_POST['prod_id'];
		$prod_qty = $_POST['prod_qty'];
		$row_data = $this->db->table('product')->where('id', $prod_id)->get()->getRowArray();
		$opening_stock = $row_data['opening_stock'];
		$minimum_stock = $row_data['minimum_stock'];
		$balance_stock = $opening_stock - $minimum_stock;
		if ($balance_stock < $prod_qty) {
			echo 1;
		} else {
			echo 0;
		}
	}
	public function checkavailablity_rawmaterialcount()
	{
		$raw_id = $_POST['rawmat_id'];
		$raw_qty = $_POST['rawmat_qty'];
		$row_data = $this->db->table('raw_matrial_groups')->where('id', $raw_id)->get()->getRowArray();
		$opening_stock = $row_data['opening_stock'];
		$minimum_stock = $row_data['minimum_stock'];
		$balance_stock = $opening_stock - $minimum_stock;
		if ($balance_stock < $raw_qty) {
			echo 1;
		} else {
			echo 0;
		}
	}
	public function stock_in_save()
	{
		$id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['date']);
		$yr = $date[0];
		$mon = $date[1];
		$query = $this->db->query("SELECT invoice_no FROM stock_inward where id=(select max(id) from stock_inward where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['invoice_no'] = 'IN' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));

		$data['date'] = $_POST['date'];
		$data['staff_name'] = $_POST['staffname'];
		//$data['invoice_no'] 	= $_POST['invno'];
		$data['total_amount'] = $_POST['itemamount'];
		$data['added_by'] = $this->session->get('log_id');
		$data['modified'] = date("Y-m-d H:i:s");
		$data['created'] = date("Y-m-d H:i:s");
		$product_avai_status = array();
		$av_data_r = "";
		if (!empty($_POST['sout'])) {
			foreach ($_POST['sout'] as $row) {
				if ($row['ptype'] == 1) {
					if (!empty($_POST['dedection_box'])) {
						$pr_raw_items = $this->db->table("product as p")
							->join('product_raw_material_items as prm', 'prm.product_id = p.id')
							->select('prm.product_id,prm.raw_id,prm.qty')
							->where("p.id", $row['pid'])
							->get()->getResultArray();
						if (count($pr_raw_items) > 0) {
							foreach ($pr_raw_items as $pr_raw_item) {
								$tot_req_qty = $row['qty'] * $pr_raw_item['qty'];
								$av_data_r = $this->db->table("raw_matrial_groups")->where("id", $pr_raw_item['raw_id'])->get()->getRowArray();
								if ($av_data_r['opening_stock'] < $tot_req_qty) {
									$product_avai_status[] = 1;
								} else {
									$product_avai_status[] = 0;
								}
							}
						}
					}
				}
			}
		}
		//var_dump(array_sum($product_avai_status));
		//exit;
		//$msg_data['err'] = $product_avai_status;
		//echo json_encode($msg_data);
		//exit;
		if (array_sum($product_avai_status) > 0) {
			$msg_data['err'] = 'Raw Material Not Found Choosed Product.';
		} else if (empty($data['staff_name']) || empty($data['invoice_no']) || empty($data['total_amount']) || $data['total_amount'] == '0.00' || $data['total_amount'] < 0) {
			$msg_data['err'] = 'Please Fill Required Field';
		} else {
			$res = $this->db->table('stock_inward')->insert($data);
			$ins_id = $this->db->insertID();
			foreach ($_POST['sout'] as $row) {
				$sdata['stack_in_id'] = $ins_id;
				$sdata['item_type'] = $row['ptype'];
				$sdata['item_id'] = $row['pid'];
				$sdata['item_name'] = $row['pname'];
				$sdata['uom_id'] = $row['uoid'];
				$sdata['rate'] = $row['rate'];
				$sdata['quantity'] = $row['qty'];
				$sdata['amount'] = $row['amt'];
				$sdata['created'] = date("Y-m-d H:i:s");
				$sdata['modified'] = date("Y-m-d H:i:s");
				if ($row['ptype'] == 1) {
					if (!empty($_POST['dedection_box'])) {
						$pr_raw_items = $this->db->table("product as p")
							->join('product_raw_material_items as prm', 'prm.product_id = p.id')
							->select('prm.product_id,prm.raw_id,prm.qty')
							->where("p.id", $row['pid'])
							->get()->getResultArray();
						if (count($pr_raw_items) > 0) {
							$data_rtout['date'] = $_POST['date'];
							$data_rtout['staff_name'] = $_POST['staffname'];
							$query_out = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
							$data_rtout['invoice_no'] = 'RT' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query_out['invoice_no'], -5)) + 1)));
							$data_rtout['added_by'] = $this->session->get('log_id');
							$data_rtout['modified'] = date("Y-m-d H:i:s");
							$data_rtout['created'] = date("Y-m-d H:i:s");
							$this->db->table('stock_outward')->insert($data_rtout);
							$ins_id_rtout = $this->db->insertID();
							$tot_outward_list_amt = 0;
							foreach ($pr_raw_items as $pr_raw_item) {
								$tot_req_qty = $row['qty'] * $pr_raw_item['qty'];
								$av_data_r = $this->db->table("raw_matrial_groups")->where("id", $pr_raw_item['raw_id'])->get()->getRowArray();
								$avl_stack_r['opening_stock'] = $av_data_r['opening_stock'] - $tot_req_qty;
								$this->db->table('raw_matrial_groups')->where('id', $pr_raw_item['raw_id'])->update($avl_stack_r);

								$uom_item_data = $this->db->table('raw_matrial_groups')->where('id', $pr_raw_item['raw_id'])->get()->getRowArray();
								$uom_id = $uom_item_data['uom_id'];
								$item_raw_name = $uom_item_data['name'];
								$item_raw_rate = $uom_item_data['price'];
								$item_raw_qty = $tot_req_qty;
								$item_raw_amt = $uom_item_data['price'] * $tot_req_qty;
								$data_rtout_list['stack_out_id'] = $ins_id_rtout;
								$data_rtout_list['item_type'] = 2;
								$data_rtout_list['item_id'] = $pr_raw_item['raw_id'];
								$data_rtout_list['item_name'] = $item_raw_name;
								$data_rtout_list['uom_id'] = $uom_id;
								$data_rtout_list['rate'] = $item_raw_rate;
								$data_rtout_list['quantity'] = $item_raw_qty;
								$data_rtout_list['amount'] = $item_raw_amt;
								$data_rtout_list['created'] = date("Y-m-d H:i:s");
								$data_rtout_list['modified'] = date("Y-m-d H:i:s");
								$this->db->table('stock_outward_list')->insert($data_rtout_list);
								$tot_outward_list_amt = $tot_outward_list_amt + $item_raw_amt;
							}
							$this->db->table('stock_outward')->where('id', $ins_id_rtout)->update(array("total_amount" => $tot_outward_list_amt));
						}
						$av_data_p = $this->db->table("product")->where("id", $row['pid'])->get()->getRowArray();
						$avl_stack_p['opening_stock'] = $av_data_p['opening_stock'] + $row['qty'];
						$builder = $this->db->table('product')->where('id', $row['pid'])->update($avl_stack_p);
					} else {
						$av_data_p_re = $this->db->table("product")->where("id", $row['pid'])->get()->getRowArray();
						$avl_stack_p_re['opening_stock'] = $av_data_p_re['opening_stock'] + $row['qty'];
						$builder = $this->db->table('product')->where('id', $row['pid'])->update($avl_stack_p_re);
					}
				}
				if ($row['ptype'] == 2) {
					$av_data_r = $this->db->table("raw_matrial_groups")->where("id", $row['pid'])->get()->getRowArray();
					$avl_stack_r['opening_stock'] = $av_data_r['opening_stock'] + $row['qty'];
					$builder = $this->db->table('raw_matrial_groups')->where('id', $row['pid'])->update($avl_stack_r);
				}
				if ($builder) {
					$dres = $this->db->table("stock_inward_list")->insert($sdata);
				}
			}
			if ($dres) {
				$msg_data['succ'] = 'Stock In Added Successfully';
				$msg_data['id'] = $ins_id;
			} else {
				$msg_data['err'] = 'Please Try Again';
			}
		}

		echo json_encode($msg_data);
		exit();
	}

	public function getuom()
	{
		$type = $_POST['type'];
		$name = $_POST['name'];
		if ($type == 1) {
			$query = $this->db->query("SELECT * FROM product where id = $name")->getRowArray();
		}
		if ($type == 2) {
			$query = $this->db->query("SELECT * FROM raw_matrial_groups where id = $name")->getRowArray();
		}
		$uom = $query['uom_id'];
		$query1 = $this->db->query("select * from uom_list where id = $uom")->getRowArray();
		$data['stock'] = $query['opening_stock'];
		$data['amount'] = $query['price'];
		$data['uom_id'] = $uom;
		$data['name'] = $query['name'];
		$data['uom_name'] = $query1['symbol'];
		echo json_encode($data);
	}

	public function getinvno()
	{

		$yr = date('Y', strtotime($_POST['date']));
		$yr = substr($year, -2);
		$mon = date('m', strtotime($_POST['date']));

		echo 'IN' . $yr . $mon;
	}

	public function stock_out()
	{
		if (!$this->model->list_validate('stock_out')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$data['permission'] = $this->model->get_permission('stock_out');
		$data['list'] = $this->db->table('stock_outward', 'staff.name as staffname')
			->join('staff', 'staff.id = stock_outward.staff_name')
			->select('staff.name as staffname')
			->select('stock_outward.*')
			->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/stockout', $data);
		echo view('template/footer');
	}

	public function stock_out_add()
	{
		if (!$this->model->permission_validate('stock_out', 'create_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$yr = date('Y');
		$mon = date('m');
		$query = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)= $yr and month (date)= $mon)")->getRowArray();

		$data['inv_no'] = 'OT' . date("y") . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));
		//print_r($data);die;
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/stock_out_add', $data);
		echo view('template/footer');
	}

	public function stock_out_save()
	{

		$id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['date']);
		$yr = $date[0];
		$mon = $date[1];
		$query = $this->db->query("SELECT invoice_no FROM stock_outward where id=(select max(id) from stock_outward where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['invoice_no'] = 'OT' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));

		$data['date'] = $_POST['date'];
		$data['staff_name'] = $_POST['staffname'];
		//$data['invoice_no'] 	= $_POST['invno'];
		$data['total_amount'] = $_POST['itemamount'];
		$data['added_by'] = $this->session->get('log_id');
		$data['modified'] = date("Y-m-d H:i:s");
		$data['created'] = date("Y-m-d H:i:s");
		if (empty($data['staff_name']) || empty($data['invoice_no']) || empty($data['total_amount']) || $data['total_amount'] == '0.00' || $data['total_amount'] < 0) {
			$msg_data['err'] = 'Please Fill Required Field';
			echo json_encode($msg_data);
			exit();
		}
		$res = $this->db->table('stock_outward')->insert($data);
		$ins_id = $this->db->insertID();
		// echo '<pre>';
		// print_r($data);die;


		/* $res_sname = $this->db->table("staff")->where("id", $_POST['staffname'])->get()->getRowArray();
																																																																					  //print_r($res_sname);die;
																																																																					  // debit ledger
																																																																					  $ledger = $this->db->table('ledgers')->where('name', 'Temple Products')->where('group_id', 10)->get()->getRowArray();
																																																																					  if(!empty($ledger)){
																																																																						  $dr_id = $ledger['id'];
																																																																					  }else{
																																																																						  $led['group_id'] = 10;
																																																																						  $led['name'] = 'Temple Products';
																																																																						  $led['op_balance'] = '0';
																																																																						  $led['op_balance_dc'] = 'D';
																																																																						  $led_ins = $this->db->table('ledgers')->insert($led);
																																																																						  $dr_id = $this->db->insertID();
																																																																					  }

																																																																					  // credit ledger
																																																																					  $ledger1 = $this->db->table('ledgers')->where('name', 'Stock Outward')->where('group_id', 31)->get()->getRowArray();
																																																																					  if(!empty($ledger1)){
																																																																						  $cr_id = $ledger1['id'];
																																																																					  }else{
																																																																						  $led1['group_id'] = 31;
																																																																						  $led1['name'] = 'Stock Outward';
																																																																						  $led1['op_balance'] = '0';
																																																																						  $led1['op_balance_dc'] = 'C';
																																																																						  $led_ins1 = $this->db->table('ledgers')->insert($led1);
																																																																						  $cr_id = $this->db->insertID();
																																																																					  }
																																																																					  //echo $dr_id.'<br>'.$cr_id;die;
																																																																					  if($res){
																																																																						  $number = $this->db->table('entries')->select('number')->where('entrytype_id',1)->orderBy('id','desc')->get()->getRowArray(); 
																																																																							  if(empty($number)) {
																																																																								  $num = 1;
																																																																							  } else {
																																																																								  $num = $number['number'] + 1;
																																																																							  }
																																																																							  $qry   = $this->db->query("SELECT entry_code FROM entries where id=(select max(id) from entries where year (date)='". $yr ."' and entrytype_id =1 and month (date)='". $mon ."')")->getRowArray();
																																																																							  $entries['entry_code'] = 'REC' .date('y',strtotime($_POST['date'])).$mon. (sprintf("%05d",(((float)  substr($qry['entry_code'],-5))+1)));
																																																																							  
																																																																							  $entries['entrytype_id'] = '1';
																																																																							  $entries['number'] 		 = $num;
																																																																							  $entries['date'] 		 = $data['date']; 
																																																																							  $entries['dr_total'] 	 = $data['total_amount'];
																																																																							  $entries['cr_total'] 	 = $data['total_amount'];
																																																																							  $entries['narration'] 	 = 'Stock Out';
																																																																							  $entries['inv_id']       = $ins_id;
																																																																							  $entries['type']         = 6;
																																																																							  $ent = $this->db->table('entries')->insert($entries);
																																																																							  $en_id = $this->db->insertID();
																																																																							  if(!empty($en_id)){
																																																																								  $eitems_d['entry_id'] = $en_id;
																																																																								  $eitems_d['ledger_id'] = $dr_id;
																																																																								  $eitems_d['amount'] = $data['total_amount'];
																																																																								  $eitems_d['dc'] = 'C';
																																																																								  $this->db->table('entryitems')->insert($eitems_d);

																																																																								  $eitems_c['entry_id'] = $en_id;
																																																																								  $eitems_c['ledger_id'] = $cr_id;
																																																																								  $eitems_c['amount'] = $data['total_amount'];
																																																																								  $eitems_c['dc'] = 'D';
																																																																								  $this->db->table('entryitems')->insert($eitems_c);
																																																																							  }
																																																																						  //echo $ins_id;
																																																																																																																																										  } */
		foreach ($_POST['sout'] as $row) {
			$sdata['stack_out_id'] = $ins_id;
			$sdata['item_type'] = $row['ptype'];
			$sdata['item_id'] = $row['pid'];
			$sdata['item_name'] = $row['pname'];
			$sdata['uom_id'] = $row['uoid'];
			$sdata['rate'] = $row['rate'];
			$sdata['quantity'] = $row['qty'];
			$sdata['amount'] = $row['amt'];
			$sdata['created'] = date("Y-m-d H:i:s");
			$sdata['modified'] = date("Y-m-d H:i:s");

			if ($row['ptype'] == 1) {
				$av_data_p = $this->db->table("product")->where("id", $row['pid'])->get()->getRowArray();
				$avl_stack_p['opening_stock'] = $av_data_p['opening_stock'] - $row['qty'];
				$builder = $this->db->table('product')->where('id', $row['pid'])->update($avl_stack_p);
			}
			if ($row['ptype'] == 2) {
				$av_data_r = $this->db->table("raw_matrial_groups")->where("id", $row['pid'])->get()->getRowArray();
				$avl_stack_r['opening_stock'] = $av_data_r['opening_stock'] - $row['qty'];
				$builder = $this->db->table('raw_matrial_groups')->where('id', $row['pid'])->update($avl_stack_r);
			}
			if ($builder) {
				$dres = $this->db->table("stock_outward_list")->insert($sdata);
			}
		}
		if ($dres) {
			$msg_data['succ'] = 'Stock Out Added Successfully';
			$msg_data['id'] = $ins_id;
		} else {
			$msg_data['err'] = 'Please Try Again';
		}
		echo json_encode($msg_data);
		exit();
	}


	public function view_stock_in()
	{
		if (!$this->model->permission_validate('stock_in', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['data'] = $this->db->table('stock_inward')->select('stock_inward.*')->select('staff.name')->join('staff', 'staff.id = stock_inward.staff_name', 'inner')->where('stock_inward.id', $id)->get()->getRowArray();
		$data['sto'] = $this->db->table('stock_inward_list')
			->join('uom_list', 'stock_inward_list.uom_id = uom_list.id')
			->select('uom_list.*')
			->select('stock_inward_list.*')
			->where('stack_in_id', $id)->get()->getResultArray();

		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/stock_in_add', $data);
		echo view('template/footer');
	}


	public function print_page_stock_in()
	{
		if (!$this->model->permission_validate('stock_in', 'print')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['data'] = $this->db->table('stock_inward')->select('stock_inward.*')->select('staff.name,staff.address1,staff.address2,staff.city,staff.mobile as mobile_no')->join('staff', 'staff.id = stock_inward.staff_name', 'inner')->where('stock_inward.id', $id)->get()->getRowArray();
		$data['sto'] = $this->db->table('stock_inward_list')
			->join('uom_list', 'stock_inward_list.uom_id = uom_list.id')
			->select('uom_list.*')
			->select('stock_inward_list.*')
			->where('stack_in_id', $id)->get()->getResultArray();

		echo view('stock/stock_in_print_page', $data);
	}



	public function delete_stock_in()
	{
		if (!$this->model->permission_validate('stock_in', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$qry1 = $this->db->table('stock_inward_list')->where('stack_in_id', $id)->get()->getResultArray();
		foreach ($qry1 as $row) {
			$qry2 = $this->db->table('raw_matrial_groups')->where('id', $row['item_name'])->get()->getRowArray();
			$qry3 = $qry2['opening_stock'] - $row['quantity'];
			$res = $this->db->table('raw_matrial_groups')->where('id', $row['item_name'])->set('opening_stock', $qry3)->update();
		}
		$res = $this->db->table('stock_inward')->delete(['id' => $id]);
		$res = $this->db->table('stock_inward_list')->delete(['stack_in_id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Stock In Delete Successfully');
			header("Location: " . base_url() . "/stock/stock_in");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/stock/stock_in");
		}
	}


	public function view_stock_out()
	{
		if (!$this->model->permission_validate('stock_out', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['data'] = $this->db->table('stock_outward')->select('stock_outward.*')->select('staff.name')->join('staff', 'staff.id = stock_outward.staff_name', 'inner')->where('stock_outward.id', $id)->get()->getRowArray();
		$data['sto'] = $this->db->table('stock_outward_list')
			->join('uom_list', 'stock_outward_list.uom_id = uom_list.id')
			->select('uom_list.*')
			->select('stock_outward_list.*')
			->where('stack_out_id', $id)->get()->getResultArray();

		$data['view'] = true;
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/stock_out_add', $data);
		echo view('template/footer');
	}


	public function print_page_stock_out()
	{

		if (!$this->model->permission_validate('stock_out', 'view')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['data'] = $this->db->table('stock_outward')
			->select('stock_outward.*, staff.name, staff.mobile as mobile_no')
			->join('staff', 'staff.id = stock_outward.staff_name', 'inner')
			->where('stock_outward.id', $id)
			->get()
			->getRowArray();
		$data['sto'] = $this->db->table('stock_outward_list')
			->join('uom_list', 'stock_outward_list.uom_id = uom_list.id')
			->select('uom_list.*')
			->select('stock_outward_list.*')
			->where('stack_out_id', $id)->get()->getResultArray();
		echo view('stock/stock_out_print_page', $data);
	}




	public function delete_stock_out()
	{
		if (!$this->model->permission_validate('stock_out', 'delete_p')) {
			header('Location: ' . base_url() . '/dashboard');
		}
		$id = $this->request->uri->getSegment(3);
		$qry1 = $this->db->table('stock_outward_list')->where('stack_out_id', $id)->get()->getResultArray();
		//echo "<pre>"; print_r($qry1); exit();
		foreach ($qry1 as $row) {
			$qry2 = $this->db->table('raw_matrial_groups')->where('id', $row['item_name'])->get()->getRowArray();
			$qry3 = $qry2['opening_stock'] + $row['quantity'];
			$res = $this->db->table('raw_matrial_groups')->where('id', $row['item_name'])->set('opening_stock', $qry3)->update();
		}
		$res = $this->db->table('stock_outward')->delete(['id' => $id]);
		$res = $this->db->table('stock_outward_list')->delete(['stack_out_id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Stock In Delete Successfully');
			header("Location: " . base_url() . "/stock/stock_out");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/stock/stock_out");
		}
	}
	public function AmountInWords()
	{
		$amount = (float) $_POST['number'];
		$amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
		// Check if there is any number after decimal
		$amt_hundred = null;
		$count_length = strlen($num);
		$x = 0;
		$string = array();
		$change_words = array(0 => '', 1 => 'One', 2 => 'Two',
			3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
			7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
			10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
			13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
			19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
			40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
			70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
		$here_digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
		while ($x < $count_length) {
			$get_divider = ($x == 2) ? 10 : 100;
			$amount = floor($num % $get_divider);
			$num = floor($num / $get_divider);
			$x += $get_divider == 10 ? 1 : 2;
			if ($amount) {
				$add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
				$amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
				$string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . ' 
			' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . ' 
			' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
			} else
				$string[] = null;
		}
		$implode_to_Rupees = implode('', array_reverse($string));
		/*$get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
																																																																																																																																																									  " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';*/
		$get_paise = ($amount_after_decimal > 0) ? "and " . ($change_words[$amount_after_decimal / 10] . " 
		" . $change_words[$amount_after_decimal % 10]) . ' Cents' : '';
		//return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
		return ($implode_to_Rupees ? 'Ringgit ' . $implode_to_Rupees : '') . $get_paise . ' Only';
	}


	public function defective_item()
	{

		$data['permission'] = $this->model->get_permission('stock_out');
		$data['list'] = $this->db->table('defective_item', 'staff.name as staffname')
			->join('staff', 'staff.id = defective_item.staff_name')
			->select('staff.name as staffname')
			->select('defective_item.*')
			->get()->getResultArray();

		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/defective_item', $data);
		echo view('template/footer');
	}


	public function defective_item_add()
	{
		$yr = date('Y');
		$mon = date('m');


		$query = $this->db->query("SELECT MAX(CAST(SUBSTRING(invoice_no, 9) AS UNSIGNED)) as max_invoice FROM defective_item WHERE YEAR(date) = $yr AND MONTH(date) = $mon AND invoice_no LIKE 'OT%'")->getRowArray();


		$lastFiveDigits = (int) $query['max_invoice'];


		$data['inv_no'] = 'OT' . date("ym") . sprintf("%05d", $lastFiveDigits + 1);

		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();


		$productQuery = $this->db->table('raw_material_groups')->get();

		if ($productQuery !== false) {
			$data['product'] = $productQuery->getResultArray();
		} else {

			$data['product'] = array();
		}

		// Load views
		echo view('template/header');
		echo view('template/sidebar');
		echo view('stock/defective_item_add', $data);
		echo view('template/footer');
	}




	public function defective_item_save()
	{

		$id = $_POST['id'];
		$msg_data = array();
		$msg_data['err'] = '';
		$msg_data['succ'] = '';
		$date = explode('-', $_POST['date']);
		$yr = $date[0];
		$mon = $date[1];
		$query = $this->db->query("SELECT invoice_no FROM defective_item where id=(select max(id) from defective_item where year (date)='" . $yr . "' and month (date)='" . $mon . "')")->getRowArray();
		$data['invoice_no'] = 'OT' . date('y', strtotime($_POST['date'])) . $mon . (sprintf("%05d", (((float) substr($query['invoice_no'], -5)) + 1)));

		$data['date'] = $_POST['date'];
		$data['staff_name'] = $_POST['staffname'];
		//$data['invoice_no'] 	= $_POST['invno'];
		$data['total_amount'] = $_POST['itemamount'];
		$data['reason'] = $_POST['reason'];
		$data['added_by'] = $this->session->get('log_id');
		$data['modified'] = date("Y-m-d H:i:s");
		$data['created'] = date("Y-m-d H:i:s");
		if (empty($data['staff_name']) || empty($data['invoice_no']) || empty($data['total_amount']) || $data['total_amount'] == '0.00' || $data['total_amount'] < 0) {
			$msg_data['err'] = 'Please Fill Required Field';
			echo json_encode($msg_data);
			exit();
		}
		$res = $this->db->table('defective_item')->insert($data);
		$ins_id = $this->db->insertID();


		foreach ($_POST['sout'] as $row) {
			$sdata['defective_item_id'] = $ins_id;
			$sdata['item_type'] = $row['ptype'];
			$sdata['item_id'] = $row['pid'];
			$sdata['item_name'] = $row['pname'];
			$sdata['uom_id'] = $row['uoid'];
			$sdata['rate'] = $row['rate'];
			$sdata['quantity'] = $row['qty'];
			$sdata['amount'] = $row['amt'];
			$sdata['created'] = date("Y-m-d H:i:s");
			$sdata['modified'] = date("Y-m-d H:i:s");

			if ($row['ptype'] == 1) {
				$av_data_p = $this->db->table("product")->where("id", $row['pid'])->get()->getRowArray();
				$avl_stack_p['opening_stock'] = $av_data_p['opening_stock'] - $row['qty'];
				$builder = $this->db->table('product')->where('id', $row['pid'])->update($avl_stack_p);
			}
			if ($row['ptype'] == 2) {
				$av_data_r = $this->db->table("raw_matrial_groups")->where("id", $row['pid'])->get()->getRowArray();
				$avl_stack_r['opening_stock'] = $av_data_r['opening_stock'] - $row['qty'];
				$builder = $this->db->table('raw_matrial_groups')->where('id', $row['pid'])->update($avl_stack_r);
			}
			if ($builder) {
				$dres = $this->db->table("defective_item_list")->insert($sdata);
			}
		}
		if ($dres) {
			$msg_data['succ'] = 'Defective Item Added Successfully';
			$msg_data['id'] = $ins_id;
		} else {
			$msg_data['err'] = 'Please Try Again';
		}
		echo json_encode($msg_data);
		exit();
	}








	public function view_defective_item()
	{
		$id = $this->request->uri->getSegment(3);

		// Fetching staff data
		$staffResult = $this->db->table('staff')->where('is_admin', 0)->get();
		$data['staff'] = $staffResult !== false ? $staffResult->getResultArray() : [];

		// Fetching UOM data
		$uomResult = $this->db->table('uom_list')->get();
		$data['uom'] = $uomResult !== false ? $uomResult->getResultArray() : [];

		// Fetching product data
		$productResult = $this->db->table('raw_matrial_groups')->get();
		$data['product'] = $productResult !== false ? $productResult->getResultArray() : [];

		// Fetching defective item data
		$defectiveItemResult = $this->db->table('defective_item')
			->select('defective_item.*')
			->select('staff.name')
			->join('staff', 'staff.id = defective_item.staff_name', 'inner')
			->where('defective_item.id', $id)
			->get();

		$data['data'] = $defectiveItemResult !== false ? $defectiveItemResult->getRowArray() : [];

		// Fetching defective item list data
		$defectiveItemListResult = $this->db->table('defective_item_list')
			->join('uom_list', 'defective_item_list.uom_id = uom_list.id')
			->select('uom_list.*')
			->select('defective_item_list.*')
			->where('defective_item_id', $id)
			->get();

		$data['sto'] = $defectiveItemListResult !== false ? $defectiveItemListResult->getResultArray() : [];

		$data['view'] = true;

		echo view('template/header', $data);
		echo view('template/sidebar');
		echo view('stock/defective_item_add', $data);
		echo view('template/footer');
	}


	public function print_page_defective_item()
	{
		$id = $this->request->uri->getSegment(3);
		$data['staff'] = $this->db->table('staff')->where('is_admin', 0)->get()->getResultArray();
		$data['uom'] = $this->db->table('uom_list')->get()->getResultArray();
		$data['product'] = $this->db->table('raw_matrial_groups')->get()->getResultArray();
		$data['data'] = $this->db->table('defective_item')
			->select('defective_item.*, staff.name, staff.mobile as mobile_no')
			->join('staff', 'staff.id = defective_item.staff_name', 'inner')
			->where('defective_item.id', $id)
			->get()
			->getRowArray();
		$data['sto'] = $this->db->table('defective_item_list')
			->join('uom_list', 'defective_item_list.uom_id = uom_list.id')
			->select('uom_list.*')
			->select('defective_item_list.*')
			->where('defective_item_id', $id)->get()->getResultArray();
		echo view('stock/defective_item_print_page', $data);
	}



	public function delete_defective_item()
	{

		$id = $this->request->uri->getSegment(3);
		$qry1 = $this->db->table('defective_item_list')->where('defective_item_id', $id)->get()->getResultArray();
		//echo "<pre>"; print_r($qry1); exit();
		foreach ($qry1 as $row) {
			$qry2 = $this->db->table('raw_matrial_groups')->where('id', $row['item_name'])->get()->getRowArray();
			$qry3 = $qry2['opening_stock'] + $row['quantity'];
			$res = $this->db->table('raw_matrial_groups')->where('id', $row['item_name'])->set('opening_stock', $qry3)->update();
		}
		$res = $this->db->table('defective_item')->delete(['id' => $id]);
		$res = $this->db->table('defective_item_list')->delete(['defective_item_id' => $id]);
		if ($res) {
			$this->session->setFlashdata('succ', 'Stock In Delete Successfully');
			header("Location: " . base_url() . "/stock/defective_item");
		} else {
			$this->session->setFlashdata('fail', 'Please Try Again');
			header("Location: " . base_url() . "/stock/defective_item");
		}
	}

}
